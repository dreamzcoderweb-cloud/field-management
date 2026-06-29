<?php

namespace App\Http\Controllers\Api;

use App\Api\Shared\Responses\Error;
use App\Api\Shared\Responses\Success;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Tracking;
use App\Models\UserDevice;
use http\Env\Response;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function checkDevice(Request $request)
    {
        $deviceId = $request->deviceId;
        $deviceType = $request->deviceType;

        if($deviceId == null || $deviceType == null){
            return Error::response('Device id or device type is missing');
        }

        $userDevice = UserDevice::where('user_id', auth()->user()->id)
            ->first();

        if($userDevice != null) {

            if($userDevice->device_id == $deviceId && $userDevice->device_type == $deviceType){
                return Success::response('Verified');
            }

            return Error::response('Already registered with other device');

        }else{

            if(UserDevice::where('device_id', '=',$deviceId)->where('device_type','=',$deviceType)->count() > 0)
                return Error::response('Already registered with other user');

            return Error::response('Not registered');
        }

       /* if($device != null && UserDevice::where('user_id','=',auth()->user()->id)->count() > 0){
            return Error::response('Already registered with other device');
        }*/
    }

    public  function registerDevice(Request $request){
        $deviceId = $request->deviceId;
        $deviceType = $request->deviceType;
        $brand = $request->brand;
        $board = $request->board;
        $sdkVersion = $request->sdkVersion;
        $model = $request->model;

        if($deviceId == null){
            return Error::response('Device id is required');
        }

        if($deviceType == null){
            return Error::response('Device type is required');
        }

        if(!(strtolower($deviceType)=='android' || strtolower($deviceType)=='ios')){
            return Error::response('Invalid device type');
        }

        $oldDevice = UserDevice::where('user_id', auth()->user()->id)
            ->first();

        if($oldDevice != null){
            $oldDevice->delete();
        }

        $device = new UserDevice();
        $device->user_id = auth()->user()->id;
        $device->device_id = $deviceId;
        $device->device_type = $deviceType;
        $device->brand = $brand;
        $device->board = $board;
        $device->sdk_version = $sdkVersion;
        $device->model = $model;
        $device->token = '';
        $device->save();

        return Success::response('Device registered successfully');
    }

    public function messagingToken(Request $request){

        $token = $request->Token;
        $deviceType = $request->DeviceType;

        if($token == null){
            return Error::response('Token is required');
        }

        if($deviceType == null){
            return Error::response('Device type is required');
        }

        $device = UserDevice::where('user_id', auth()->user()->id)
            ->first();

        if($device == null){
            return Error::response('Device not registered');
        }
        $device->token = $token;
        $device->save();

        return Success::response('Token saved successfully');
    }

    public function updateDeviceStatus(Request $request){

        $batteryPercentage = $request->batteryPercentage;
        $isGpsOn = $request->isGPSOn;
        $isWifiOn = $request->isWifiOn;
        $isMock = $request->isMock ?? false;
        $signalStrength = $request->signalStrength;
        $latitude = $request->latitude;
        $longitude = $request->longitude;

        $device = UserDevice::where('user_id', auth()->user()->id)
            ->first();

        if($device == null){
            return Error::response('Device not registered');
        }

        $device->battery_percentage = $batteryPercentage;
        $device->is_gps_on = $isGpsOn;
        $device->is_wifi_on = $isWifiOn;
        $device->is_mock = $isMock;
        $device->signal_strength = $signalStrength;
        $device->latitude = $latitude;
        $device->longitude = $longitude;
        $device->save();

        return Success::response('Status updated successfully');
    }

}
