<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeaveType\StoreLeaveTypeRequest;
use App\Http\Requests\LeaveType\UpdateLeaveTypeRequest;
use App\Models\LeaveType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LeaveTypeController extends Controller
{
    public function index()
    {
        return view('leaveType.index',[
            'leave_types' => LeaveType::all()
        ]);
    }

    public function create()
    {
        return view('leaveType.create');
    }

    public function store(StoreLeaveTypeRequest $request)
    {
        LeaveType::create($request->all());

        return redirect()->route('leaveType.index')->with('success', 'Leave Type Created Successfully');
    }

    public function edit(LeaveType $leaveType)
    {
        return view('leaveType.edit', ['leaveType' => $leaveType]);
    }

    public function update(UpdateLeaveTypeRequest $request, LeaveType $leaveType) : RedirectResponse
    {
        $leaveType->update($request->all());

        return redirect()->route('leaveType.index')->with('success', 'Leave Type Updated Successfully');
    }


    public function destroy(LeaveType $leaveType)
    {
        $leaveType->delete();

        return redirect()->route('leaveType.index')->with('success', 'Leave Type Deleted Successfully');
    }

    public function changeStatus(Request $request)
    {
        if(env('DEMO_MODE'))
            return response()->json('This action is disabled in demo mode');

        $leaveType = LeaveType::find($request->id);
        $leaveType->status = $leaveType->status == 'active' ? 'inactive' : 'active';
        $leaveType->save();

        return response()->json('Status Updated Successfully.');
    }

}
