<?php

namespace App\Http\Controllers;

use App\Models\UserDevice;

class DeviceController extends Controller
{
    public function index()
    {
        $devices = UserDevice::with('user')->get();

        return view('device.index', compact('devices'));
    }

    public function revoke($id)
    {
        if(env('DEMO_MODE')){
            return redirect()->back()->with('error', 'This feature is disabled in demo mode');
        }

        $device = UserDevice::find($id);
        $device->delete();

        return redirect()->back()->with('success', 'Device revoked successfully');
    }
}
