<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Staffvehicle\UpdateStaffvehicleRequest;
use App\Models\Staffvehicle;
use Illuminate\Http\Request;

class StaffvehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userId = $request->userId;
        $staffVehicles = Staffvehicle::where('user_id', $userId)
            ->latest()
            ->get();
        return view('staffvehicle.index', ['staffvehicles' => $staffVehicles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Staffvehicle $staffvehicle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Staffvehicle $staffvehicle)
    {
        return view('staffvehicle.edit', ['staffvehicle' => $staffvehicle->load('user')]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStaffvehicleRequest $request, Staffvehicle $staffvehicle)
    {
        $validator = $request->validated();
        if ($request->hasFile('kilometer_image')) {
            $imageName = uniqid() . "." . $request->kilometer_image->extension();
            $request->kilometer_image->move(public_path('staff/vehicle/'), $imageName);
            $validator['kilometer_image'] = $imageName;
        }
        $staffvehicle->update($validator);
        return to_route('admin.staffvehicle.index', ['userId' => $staffvehicle?->user_id])->with('success', "Staff Vehicle Update");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Staffvehicle $staffvehicle)
    {
        $staffvehicle->delete();
        return to_route('employee.index')->with('success', "Staff Vehicle Removed!!!");
    }
}
