<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Sentinel;

class LeaveRequestController extends Controller
{
    public function index()
    {
        $leaveRequests = LeaveRequest::all();

        return view('leaveRequest.index', compact('leaveRequests'));
    }

    public function create()
    {
        return view('leaveRequest.create');
    }

    public function show(LeaveRequest $leaveRequest)
    {
        return view('leaveRequest.show', compact('leaveRequest'));
    }

    public function action(Request $request)
    {
        $leaveRequest = LeaveRequest::find($request->input('id'));

        $leaveRequest->status = request('status');
        $leaveRequest->approved_by_id = Sentinel::getUser()->id;
        $leaveRequest->approver_remarks = request('approverRemarks');
        $leaveRequest->approved_at = now();
        $leaveRequest->save();

        return redirect()->route('leaveRequest.index')->with('success', 'Leave request has been '.request("status").' successfully.');
    }


    public function store()
    {
        $leaveRequest = new LeaveRequest();
        $leaveRequest->leave_type_id = request('leave_type_id');
        $leaveRequest->user_id = request('user_id');
        $leaveRequest->start_date = request('start_date');
        $leaveRequest->end_date = request('end_date');
        $leaveRequest->reason = request('reason');
        $leaveRequest->status = request('status');
        $leaveRequest->save();

        return redirect()->route('leaveRequest.index');
    }

    public function edit(LeaveRequest $leaveRequest)
    {
        return view('leaveRequest.edit', compact('leaveRequest'));
    }

    public function update(LeaveRequest $leaveRequest)
    {
        $leaveRequest->leave_type_id = request('leave_type_id');
        $leaveRequest->user_id = request('user_id');
        $leaveRequest->start_date = request('start_date');
        $leaveRequest->end_date = request('end_date');
        $leaveRequest->reason = request('reason');
        $leaveRequest->status = request('status');
        $leaveRequest->save();

        return redirect()->route('leaveRequest.index');
    }


    public function destroy(LeaveRequest $leaveRequest)
    {
        $leaveRequest->delete();

        return redirect()->route('leaveRequest.index');
    }

    public function changeStatus(LeaveRequest $leaveRequest)
    {
        $leaveRequest->status = !$leaveRequest->status;
        $leaveRequest->save();

        return redirect()->route('leaveRequest.index');
    }

}
