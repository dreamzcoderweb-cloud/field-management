<?php

namespace App\Http\Controllers;

use App\Classes\TrackingHelper;
use App\Classes\ViewHelper;
use App\Models\Attendance;
use App\Models\ExpenseRequest;
use App\Models\LeaveRequest;
use App\Models\Settings;
use App\Models\Team;
use App\Models\Tracking;
use App\Models\User;
use App\Models\UserDevice;
use App\Models\Visit;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $viewHelper = new ViewHelper();

        $counts = [
            'leaveRequests' => LeaveRequest::where('status', '=', 'pending')->count(),
            'visits' => Visit::whereDate('created_at', '=', now())->count(),
            'expenseRequests' => ExpenseRequest::where('status', '=', 'pending')->count(),
            'totalEmployees' => $viewHelper->getEmployeesCount(),
        ];

        return view('dashboard.index', compact('counts'));
    }

    public function liveLocation()
    {
        return view('dashboard.live_location');
    }

    public function liveLocationAjax()
    {

        try {
            $userDevices = UserDevice::whereDate('updated_at', '>=', now())
                ->with('user')
                ->get();

            $todayAttendances = Attendance::with('user.userDevice')
                ->whereDate('created_at', '>=', now())
                ->with('user')->with('user.userDevice')
                ->get();


            $response = [];

            foreach ($todayAttendances as $attendance) {

                /*  $response[] = [
                      'id' => $attendance->id,
                      'name' => $attendance->user->getFullName(),
                      'latitude' => $attendance->user->userDevice->latitude,
                      'longitude' => $attendance->user->userDevice->longitude,
                      'is_online' => $attendance->user->userDevice->is_online,
                      'is_gps_on' => $attendance->user->userDevice->is_gps_on,
                      'updated_at' => $attendance->user->userDevice->updated_at,
                  ];*/

                if ($attendance->user->userDevice == null) {
                    continue;
                }

                $settings = Settings::first();

                $status = 'offline';
                //  ? $status = 'online' : $status = 'offline';
                $trackingHelper = new TrackingHelper();
                if ($trackingHelper->isUserOnline($attendance->user->userDevice->updated_at)) {
                    $status = 'online';
                }

                $response[] = [
                    'id' => $attendance->user_id,
                    'name' => $attendance->user->getFullName(),
                    'latitude' => $attendance->user->userDevice->latitude,
                    'longitude' => $attendance->user->userDevice->longitude,
                    'status' => $status,
                    'updatedAt' => $attendance->user->userDevice->updated_at,
                    'type' => $settings->offline_check_time_type,
                    'time' => $settings->offline_check_time,
                ];
            }

            return response()->json($response);
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function cardView()
    {
        $teamsList = Team::where('status', '=', 'active')
            ->get();


        $attendances = Attendance::whereDate('created_at', '=', now())
            ->get();

        $trackingHelper = new TrackingHelper();

        $users = User::where('status', '=', 'active')
            ->where('team_id', '!=', null)
            ->where('shift_id', '!=', null)
            ->get();

        $userDevices = UserDevice::whereIn('user_id', $users->pluck('id'))
            ->get();

        $teams = [];
        foreach ($teamsList as $team) {

            $user = $users->where('team_id', '=', $team->id);

            $teamAttendances = $attendances->whereIn('user_id', $user->pluck('id'));

            $cardItems = [];

            foreach ($teamAttendances as $attendance) {

                $device = $userDevices
                    ->where('user_id', '=', $attendance->user_id)
                    ->first();

                if ($device == null) {
                    continue;
                }

                $isOnline = $trackingHelper->isUserOnline($device->updated_at);

                $visitsCount = Visit::where('attendance_id', '=', $attendance->id)
                    ->whereDate('created_at', '=', now())
                    ->count();

                $cardItems[] = [
                    'id' => $attendance->user->id,
                    'name' => $attendance->user->first_name . ' ' . $attendance->user->last_name,
                    'phoneNumber' => $attendance->user->phone_number,
                    'batteryLevel' => $device->battery_percentage,
                    'isGpsOn' => $device->is_gps_on,
                    'isWifiOn' => $device->is_wifi_on,
                    'updatedAt' => $device->updated_at,
                    'isOnline' => $isOnline,
                    'teamId' => $attendance->user->team_id,
                    'teamName' => $team->name,
                    'attendanceInAt' => $attendance->check_in_time,
                    'attendanceOutAt' => $attendance->check_out_time ?? '',
                    'latitude' => $device->latitude,
                    'longitude' => $device->longitude,
                    'address' => $device->address,
                    'visitsCount' => $visitsCount,
                ];
            }

            $teams[] = [
                'id' => $team->id,
                'name' => $team->name,
                'totalEmployees' => $user->count(),
                'cardItems' => $cardItems,
            ];

        }


        return view('dashboard.card_view', compact('teams'));
    }

    public function cardViewAjax()
    {
        $teamsList = Team::where('status', '=', 'active')
            ->get();


        $attendances = Attendance::whereDate('created_at', '=', now())
            ->get();

        $trackingHelper = new TrackingHelper();

        $users = User::where('status', '=', 'active')
            ->where('team_id', '!=', null)
            ->where('shift_id', '!=', null)
            ->get();

        $userDevices = UserDevice::whereIn('user_id', $users->pluck('id'))
            ->get();

        $cardItems = [];
        foreach ($teamsList as $team) {

            $user = $users->where('team_id', '=', $team->id);

            $teamAttendances = $attendances->whereIn('user_id', $user->pluck('id'));


            foreach ($teamAttendances as $attendance) {

                $device = $userDevices
                    ->where('user_id', '=', $attendance->user_id)
                    ->first();

                if ($device == null) {
                    continue;
                }

                $isOnline = $trackingHelper->isUserOnline($device->updated_at);

                $visitsCount = Visit::where('attendance_id', '=', $attendance->id)
                    ->whereDate('created_at', '=', now())
                    ->count();

                $cardItems[] = [
                    'id' => $attendance->user->id,
                    'name' => $attendance->user->first_name . ' ' . $attendance->user->last_name,
                    'phoneNumber' => $attendance->user->phone_number,
                    'batteryLevel' => $device->battery_percentage,
                    'isGpsOn' => $device->is_gps_on,
                    'isWifiOn' => $device->is_wifi_on,
                    'updatedAt' => $device->updated_at->diffForHumans(),
                    'isOnline' => $isOnline,
                    'teamId' => $attendance->user->team_id,
                    'teamName' => $team->name,
                    'attendanceInAt' => $attendance->check_in_time,
                    'attendanceOutAt' => $attendance->check_out_time ?? '',
                    'latitude' => $device->latitude,
                    'longitude' => $device->longitude,
                    'address' => $device->address,
                    'visitsCount' => $visitsCount,
                ];
            }
        }

        return response()->json($cardItems);
    }

    public function timeline()
    {
        $viewHelper = new ViewHelper();

        $employees = $viewHelper->getEmployeeSelectLists();

        return view('dashboard.time_line', compact('employees'));
    }


    public function getTimeLineAjax(Request $request)
    {

        $employeeId = $request->userId;
        $date = $request->date;

        $trackingHelper = new TrackingHelper();

        $attendance = Attendance::where('user_id', '=', $employeeId)
            ->with('user')
            ->with('trackings')
            ->whereDate('created_at', '=', $date)
            ->first();

        $device = UserDevice::where('user_id', '=', $employeeId)
            ->with('user')
            ->first();

        if ($attendance == null) {
            return response()->json([
                'employeeName' => $device->user->getFullName(),
                'employeeId' => $device->user->id,
                'totalTrackedTime' => '00:00:00',
                'totalAttendanceTime' => '00:00:00',
                'deviceInfo' => $device->brand . ' ' . $device->model,
                'timeLineItems' => [],
            ]);
        }

        $totalKM = 0;

        $trackingItems = [];

        if ($attendance->trackings->count() > 0) {

            $checkIn = $attendance->trackings->first();
            $checkOut = $attendance->trackings->last();

            $now = now();

            $totalTrackedTime = '00:00:00';
            if ($checkOut->type == 'checked_out') {
                $totalTrackedTime = $checkIn->created_at->diff($checkOut->created_at)->format('%H:%I:%S');
            } else {
                $totalTrackedTime = $checkIn->created_at->diff($now)->format('%H:%I:%S');
            }

            $totalAttendanceTime = $totalTrackedTime;

            $trackings = Tracking::where('attendance_id', '=', $attendance->id)
                ->orderBy('created_at', 'asc')
                ->get();

            $filteredTrackings = $trackingHelper->getFilteredData($trackings);

            $timeLineItems = [];

            for ($i = 0; $i < count($filteredTrackings); $i++) {

                $elapseTime = "0";

                $tracking = $filteredTrackings[$i];
                $nextTracking = null;
                if ($tracking->type == 'checked_in') {
                    if ($i < count($filteredTrackings) - 1 && count($filteredTrackings) != 1) {
                        $nextTracking = $filteredTrackings[$i + 1];
                        $elapseTime = $tracking->created_at->diff($nextTracking->created_at)->format('%H:%I:%S');
                    } else {
                        $elapseTime = '0';
                    }
                    $timeLineItems[] = [
                        'id' => $tracking->id,
                        'type' => 'checkIn',
                        'accuracy' => $tracking->accuracy,
                        'activity' => $tracking->activity,
                        'batteryPercentage' => $tracking->battery_percentage,
                        'isGPSOn' => $tracking->is_gps_on,
                        'isWifiOn' => $tracking->is_wifi_on,
                        'latitude' => $tracking->latitude,
                        'longitude' => $tracking->longitude,
                        'address' => $tracking->address,
                        'signalStrength' => $tracking->signal_strength,
                        'trackingType' => $tracking->type,
                        'startTime' => $tracking->created_at->format('h:i A'),
                        'endTime' => $nextTracking != null ? $nextTracking->created_at->format('h:i A') : $tracking->created_at->format('h:i A'),
                        'elapseTime' => $elapseTime,
                    ];
                    continue;
                }

                if ($tracking->type == 'checked_out') {


                    $elapseTime = '00:00:00';

                    $timeLineItems[] = [
                        'id' => $tracking->id,
                        'type' => 'checkOut',
                        'accuracy' => $tracking->accuracy,
                        'activity' => $tracking->activity,
                        'batteryPercentage' => $tracking->battery_percentage,
                        'isGPSOn' => $tracking->is_gps_on,
                        'isWifiOn' => $tracking->is_wifi_on,
                        'latitude' => $tracking->latitude,
                        'longitude' => $tracking->longitude,
                        'address' => $tracking->address,
                        'signalStrength' => $tracking->signal_strength,
                        'trackingType' => $tracking->type,
                        'startTime' => $tracking->created_at->format('h:i A'),
                        'endTime' => $tracking->created_at->format('h:i A'),
                        'elapseTime' => $elapseTime,
                    ];
                    continue;
                }

                $nextTracking = null;

                if ($i + 1 < count($filteredTrackings)) {
                    $nextTracking = $filteredTrackings[$i + 1];
                    $elapseTime = $tracking->created_at->diff($nextTracking->created_at)->format('%H:%I:%S');
                } else {
                    $elapseTime = '00:00:00';
                }

                switch ($tracking->activity) {
                    case 'ActivityType.STILL':
                        $timeLineItems[] = [
                            'id' => $tracking->id,
                            'type' => 'still',
                            'accuracy' => $tracking->accuracy ?? 0,
                            'activity' => $tracking->activity,
                            'batteryPercentage' => $tracking->battery_percentage,
                            'isGPSOn' => $tracking->is_gps_on,
                            'isWifiOn' => $tracking->is_wifi_on,
                            'latitude' => $tracking->latitude,
                            'longitude' => $tracking->longitude,
                            'address' => $tracking->address,
                            'signalStrength' => $tracking->signal_strength,
                            'trackingType' => $tracking->type,
                            'startTime' => $tracking->created_at->format('h:i A'),
                            'endTime' => $nextTracking != null ? $nextTracking->created_at->format('h:i A') : $tracking->created_at->format('h:i A'),
                            'elapseTime' => $elapseTime,
                        ];
                        break;
                    case 'ActivityType.WALKING':
                        $timeLineItems[] = [
                            'id' => $tracking->id,
                            'type' => 'walk',
                            'accuracy' => $tracking->accuracy ?? 0,
                            'activity' => $tracking->activity,
                            'batteryPercentage' => $tracking->battery_percentage,
                            'isGPSOn' => $tracking->is_gps_on,
                            'isWifiOn' => $tracking->is_wifi_on,
                            'latitude' => $tracking->latitude,
                            'longitude' => $tracking->longitude,
                            'address' => $tracking->address,
                            'signalStrength' => $tracking->signal_strength,
                            'trackingType' => $tracking->type,
                            'startTime' => $tracking->created_at->format('h:i A'),
                            'endTime' => $nextTracking != null ? $nextTracking->created_at->format('h:i A') : $tracking->created_at->format('h:i A'),
                            'elapseTime' => $elapseTime,
                        ];
                        break;
                    default:

                        $distance = 0;
                        if ($i + 1 < count($filteredTrackings)) {
                            $nextTracking = $filteredTrackings[$i + 1];
                            $distance = round($trackingHelper->GetDistance($tracking->latitude, $tracking->longitude, $nextTracking->latitude, $nextTracking->longitude), 2);
                            $totalKM += $distance;
                        }


                        $timeLineItems[] = [
                            'id' => $tracking->id,
                            'type' => 'vehicle',
                            'accuracy' => $tracking->accuracy ?? 0,
                            'activity' => $tracking->activity,
                            'batteryPercentage' => $tracking->battery_percentage,
                            'isGPSOn' => $tracking->is_gps_on,
                            'isWifiOn' => $tracking->is_wifi_on,
                            'latitude' => $tracking->latitude,
                            'longitude' => $tracking->longitude,
                            'address' => $tracking->address,
                            'signalStrength' => $tracking->signal_strength,
                            'trackingType' => $tracking->type,
                            'startTime' => $tracking->created_at->format('h:i A'),
                            'endTime' => $nextTracking != null ? $nextTracking->created_at->format('h:i A') : $tracking->created_at->format('h:i A'),
                            'elapseTime' => $elapseTime,
                            'distance' => $distance,
                        ];
                        break;
                }
            }

            $totalKM = round($totalKM, 2);

            $snappedPath = $trackingHelper->getSnappedPath($filteredTrackings);

            $response = [
                'employeeId' => $attendance->user->id,
                'employeeName' => $attendance->user->getFullName(),
                'attendanceId' => $attendance->id,
                'totalTrackedTime' => $totalTrackedTime,
                'totalAttendanceTime' => $totalAttendanceTime,
                'deviceInfo' => $device->brand . ' ' . $device->model,
                'totalKM' => $totalKM,
                'timeLineItems' => $timeLineItems,
                'snappedPath' => $snappedPath,
            ];

            return response()->json($response);
        } else {
            return response()->json("No");
        }
    }


    public function updateLocationAjax()
    {
        $trackingId = request('trackingId');
        $address = request('address');

        if ($trackingId == null || $address == null) {
            return response()->json('error');
        }

        $tracking = Tracking::find($trackingId);

        if ($tracking == null) {
            return response()->json('error');
        }

        $tracking->address = $address;
        $tracking->save();

        return response()->json('success');
    }

    public function getTeamWiseCountAjax()
    {
        $now = now();

        $trackingHelper = new TrackingHelper();

        $teams = Team::where('status', '=', 'active')
            ->with('users')->with('users.userDevice')
            ->get();

        $attendance = Attendance::whereDate('created_at', '=', $now)
            ->get();

        $response = [];

        foreach ($teams as $team) {

            $onlineUsers = 0;
            $offlineUsers = 0;
            $notWorkingUsers = 0;

            foreach ($team->users as $user) {
                if ($attendance->where('user_id', '=', $user->id)->count() > 0) {
                    if ($trackingHelper->isUserOnline($user->userDevice->updated_at)) {
                        $onlineUsers++;
                    } else {
                        $offlineUsers++;
                    }
                } else {
                    $notWorkingUsers++;
                }
            }


            $response[] = [
                'name' => $team->name,
                'onlineCount' => $onlineUsers,
                'offlineCount' => $offlineUsers,
                'notWorkingCount' => $notWorkingUsers,
            ];
        }

        return response()->json($response);
    }

    public function getRecentCheckInsAjax()
    {
        $now = now();

        $viewHelper = new ViewHelper();

        $trackingHelper = new TrackingHelper();

        $totalEmployeesCount = $viewHelper->getEmployeesCount();

        $attendance = Attendance::whereDate('created_at', '=', $now)
            ->with('user')->with('user.userDevice')
            ->get();

        $response = [];

        $onlineCount = 0;
        $offlineCount = 0;
        $notWorkingCount = 0;

        foreach ($attendance as $attend) {

            if ($attend->user->userDevice == null) {
                continue;
            }

            if ($trackingHelper->isUserOnline($attend->user->userDevice->updated_at)) {
                $onlineCount++;
            } else {
                $offlineCount++;
            }

            $response[] = [
                'name' => $attend->user->getFullName(),
                'attendanceInAt' => $attend->check_in_time,
                'attendanceOutAt' => $attend->check_out_time ?? '',
                'lastUpdate' => $attend->user->userDevice->updated_at->diffForHumans(),
                'address' => $attend->user->userDevice->address,
                'latitude' => $attend->user->userDevice->latitude,
                'longitude' => $attend->user->userDevice->longitude,
            ];
        }

        $notWorkingCount = $totalEmployeesCount - $onlineCount + $offlineCount;

        return response()->json([
            'employeeItems' => $response,
            'onlineCount' => $onlineCount,
            'offlineCount' => $offlineCount,
            'notWorkingCount' => $notWorkingCount,
        ]);
    }

    public function getPresentDataAjax()
    {
        $startDate = Carbon::now()->subDays(12);

        $viewHelper = new ViewHelper();

        $totalEmployeesCount = $viewHelper->getEmployeesCount();

        $attendance = Attendance::whereDate('created_at', '>=', $startDate)
            ->get();

        $response = [];

        for ($i = 0; $i < 12; $i++) {
            $date = $startDate->addDay()->format('Y-m-d');
            $presentCount = $attendance->where('created_at', '=', $date)->count();
            $response[] = [
                'date' => $date,
                'presentCount' => $presentCount,
                'absentCount' => $totalEmployeesCount - $presentCount,
            ];
        }

        return response()->json($response);
    }

    public function getTeamWiseAttendanceAjax()
    {

        $teams = Team::where('status', '=', 'active')
            ->with('users')
            ->get();

        $now = Carbon::now();

        $attendance = Attendance::whereDate('created_at', '=', $now)
            ->get();


        $employees = $teams->pluck('users')->flatten();

        $leaveRequests = LeaveRequest::whereDate('from_date', '>=', $now)
            ->whereDate('to_date', '<=', $now)
            ->where('status', '=', 'approved')
            ->get();


        $response = [];

        foreach ($teams as $team) {

            $presentCount = 0;
            $absentCount = 0;
            $leaveCount = 0;

            foreach ($team->users as $user) {
                if ($attendance->where('user_id', '=', $user->id)->count() > 0) {
                    $presentCount++;
                } else {
                    $absentCount++;
                }
            }

            foreach ($leaveRequests as $leaveRequest) {
                if ($leaveRequest->user->team_id == $team->id) {
                    $leaveCount++;
                }
            }

            $response[] = [
                'name' => $team->name,
                'present' => $presentCount,
                'absent' => $absentCount,
                'onLeave' => $leaveCount,
            ];
        }

        return response()->json($response);
    }
}
