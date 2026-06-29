<?php

namespace App\Http\Controllers\Api;

use App\Api\Shared\Responses\Error;
use App\Api\Shared\Responses\Success;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\AttendanceBreak;
use App\Models\Duty;
use App\Models\LeaveRequest;
use App\Models\Shift;
use App\Models\Tracking;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function setEarlyCheckoutReason(Request $request)
    {
        $reason = $request->reason;

        if ($reason == null || $reason == '') {
            return Error::response('Reason is required');
        }

        $attendance = Attendance::where('user_id', auth()->user()->id)
            ->whereDate('created_at', Carbon::today())
            ->first();

        if ($attendance == null) {
            return Error::response('Not checked in');
        }

        $attendance->early_checkout_reason = $reason;
        $attendance->save();

        return Success::response('Reason updated successfully');
    }

    public function canCheckOut()
    {
        $attendance = Attendance::where('user_id', auth()->user()->id)
            ->whereDate('created_at', Carbon::today())
            ->first();

        if ($attendance == null) {
            return Error::response('Not checked in');
        }

        $shift = Shift::find(auth()->user()->shift_id);

        if ($shift == null) {
            return Error::response('Shift not found');
        }

        if ($shift->end_time < now()) {
            return Success::response('You can check out');
        } else {
            return Error::response('You can not check out before shift end time');
        }
    }

    public function checkStatus()
    {
        $user = auth()->user();

        $attendance = Attendance::where('user_id', auth()->user()->id)
            ->whereDate('created_at', Carbon::today())
            ->first();

        $shift = Shift::find($user->shift_id);

        $status = 'new';
        $checkInTime = null;
        $checkOutTime = null;
        $trackedHours = 0.0;
        $travelledDistance = 0.0;

        if ($attendance != null) {
            if ($attendance->status == 'checked_in') {
                $status = 'checkedin';
                //Check in time only
                $date = strtotime($attendance->check_in_time);
                $checkInTime = date('h:i A', $date);
                //$trackedHours = (now() - $attendance->check_in_time) / 3600;
            } else {
                $status = 'checkedout';
                //Check in and check out time
                $date = strtotime($attendance->check_in_time);
                $checkInTime = date('h:i A', $date);

                $date = strtotime($attendance->check_out_time);
                $checkOutTime = date('h:i A', $date);
            }
        }

        $isLate = false;

        //Late check
        if ($status == 'new' && now() > $shift->start_time) {
            $isLate = true;
        }

        //Leave Check
        $isOnLeave = false;
        $leave = LeaveRequest::where('user_id', $user->id)
            ->where('status', 'approved')
            ->where('from_date', '<=', Carbon::today())
            ->where('to_date', '>=', Carbon::today())
            ->first();

        if ($leave != null) {
            $isOnLeave = true;
        }

        //Break checking
        $isOnBreak = false;
        $breakStartedAt = '';
        if ($attendance != null && $attendance->status == 'checked_in') {
            $break = AttendanceBreak::where('attendance_id', $attendance->id)
                ->whereNull('end_time')
                ->first();

            if ($break != null) {
                $isOnBreak = true;
                $date = strtotime($break->start_time);
                $breakStartedAt = date('h:i:s A', $date);
            }
        }

        $attendanceType = $this->getAttendanceTypeString($user->attendance_type);

        $shiftStartTime = date('h:i A', strtotime($shift->start_time));
        $shiftEndTime = date('h:i A', strtotime($shift->end_time));

        return response()->json([
            'statusCode' => 200,
            'status' => 'success',
            'data' => [
                'attendanceType' => $attendanceType,
                'userStatus' => $user->status,
                'status' => $status, // 'new', 'present', 'checkedout
                'checkInAt' => $checkInTime,
                'checkOutAt' => $checkOutTime,
                'shiftStartTime' => $shiftStartTime,
                'shiftEndTime' => $shiftEndTime,
                'isLate' => $isLate,
                'isOnBreak' => $isOnBreak,
                'breakStartedAt' => $breakStartedAt,
                'isOnLeave' => $isOnLeave,
                'travelledDistance' => $travelledDistance,
                'trackedHours' => $trackedHours,

                'isSiteEmployee' => $attendanceType == 'site',
                'siteName' => $attendanceType == 'site' ? $user->site->name : '',
                'siteAttendanceType' => $attendanceType == 'site' ? $this->getAttendanceTypeString($user->site->attendance_type) : '',
            ],
        ]);
    }

    private function getAttendanceTypeString($type)
    {
        $attendanceType = 'none';
        if ($type == 'geofence') {
            $attendanceType = 'geofence';
        } else if ($type == 'site') {
            $attendanceType = 'site';
        } else if ($type == 'ip_address') {
            $attendanceType = 'ip';
        } else if ($type == 'static_qr_code') {
            $attendanceType = 'staticqrcode';
        } else if ($type == 'dynamic_qr_code') {
            $attendanceType = 'dynamicqrcode';
        }

        return $attendanceType;
    }

    public function checkInOut(Request $request)
    {
        // return auth()->user();
        $status = $request->status;
        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $isMock = $request->isMock;
        $batteryPercentage = $request->batteryPercentage;
        $isGpsOn = $request->isLocationOn;
        $isWifiOn = $request->isWifiOn;
        $signalStrength = $request->signalStrength;
        $lateReason = $request->lateReason;

        if ($status == null) {
            return Error::response('Status is required');
        }

        if ($status != 'checkin' && $status != 'checkout') {
            return Error::response('Invalid status');
        }

        if ($latitude == null) {
            return Error::response('Latitude is required');
        }

        if ($longitude == null) {
            return Error::response('Longitude is required');
        }

        $user = auth()->user();

        $attendance = Attendance::whereDate('created_at', Carbon::today())
            ->where('user_id', $user->id)
            ->first();

        if ($attendance != null && $status == 'checkin') {
            return Error::response('Already checked in');
        }

        if ($attendance == null && $status == 'checkout') {
            return Error::response('Not checked in');
        }

        if ($status == 'checkin') {
            if ($attendance == null) {
                $checkLatLong = $this->chcekLatLong($latitude, $longitude);
                if ($checkLatLong['success'] == false) {
                    return Error::response($checkLatLong['message']);
                }            
                $createdAttendance = Attendance::create([
                    'user_id' => $user->id,
                    'check_in_time' => date('Y-m-d H:i:s'),
                    'status' => 'checked_in',
                    'site_id' => $user->attendance_type == 'site' ? $user->site_id : null,
                    'late_reason' => $lateReason,
                    'shift_id' => $user->shift_id
                ]);

                Tracking::create([
                    'attendance_id' => $createdAttendance->id,
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'is_mock' => $isMock,
                    'battery_percentage' => $batteryPercentage,
                    'is_gps_on' => $isGpsOn,
                    'is_wifi_on' => $isWifiOn,
                    'signal_strength' => $signalStrength,
                    'type' => 'checked_in',
                    'accuracy' => 100
                ]);
            }
        } else {
            $tasks = Duty::where('user_id', auth()->id())
                ->whereIn('status', [0, 3, 4])
                ->get();
            if (count($tasks) > 0) {
                return Error::response("Unable to check out while a current task is in progress or pending.");
            }
            if ($attendance != null) {
                $attendance->status = 'checked_out';
                $attendance->check_out_time = date('Y-m-d H:i:s');
                $attendance->save();

                Tracking::create([
                    'attendance_id' => $attendance->id,
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'is_mock' => $isMock,
                    'battery_percentage' => $batteryPercentage,
                    'is_gps_on' => $isGpsOn,
                    'is_wifi_on' => $isWifiOn,
                    'signal_strength' => $signalStrength,
                    'type' => 'checked_out',
                    'accuracy' => 100
                ]);
            }
        }

        return Success::response('Status updated successfully');
    }
    
    public function chcekLatLong($latitude, $longitude)
    {
        $user = auth()->user();
        if ($user?->lat == null && $user?->long == null) {
            return ['success' => false, "message" => "Location not registered. Please contact the administrator."];
        }

        $userLat = $user->lat;
        $userLng = $user->long;

        // Haversine formula
        $earthRadius = 6371; // km

        $dLat = deg2rad($latitude - $userLat);
        $dLng = deg2rad($longitude - $userLng);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($userLat)) * cos(deg2rad($latitude)) *
            sin($dLng / 2) * sin($dLng / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c; // distance in km

        // Inside radius means return FALSE
        if ($distance <= 3) {
            return ['success' => false, "message" => "Check-in failed. You are within the 3 km radius of your registered location."];
        }

        // Outside radius means return TRUE
        return ['success' => true];
    }    

    public function statusUpdate(Request $request)
    {
        $status = $request->status;
        $accuracy = $request->accuracy;
        $activity = $request->activity;
        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $isMock = $request->isMock;
        $batteryPercentage = $request->batteryPercentage;
        $isGpsOn = $request->isGPSOn;
        $isWifiOn = $request->isWifiOn;
        $signalStrength = $request->signalStrength;


        if ($status == null) {
            return Error::response('Status is required');
        }

        if ($latitude == null) {
            return Error::response('Latitude is required');
        }

        if ($longitude == null) {
            return Error::response('Longitude is required');
        }

        $attendance = auth()->user()->attendances()->whereDate('created_at', Carbon::now())->first();

        if ($attendance == null) {
            return Error::response('Not checked in');
        }

        Tracking::create([
            'attendance_id' => $attendance->id,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'is_mock' => $isMock,
            'battery_percentage' => $batteryPercentage,
            'is_gps_on' => $isGpsOn,
            'is_wifi_on' => $isWifiOn,
            'signal_strength' => $signalStrength,
            'type' => $status == 'still' ? 'still' : 'travelling',
            'activity' => $activity,
            'accuracy' => $accuracy
        ]);

        return Success::response('Status updated successfully');
    }
}
