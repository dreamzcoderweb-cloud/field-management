<?php

namespace App\Http\Controllers\Api;

use App\Api\Shared\Responses\Error;
use App\Api\Shared\Responses\Success;
use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LeaveController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function getLeaveTypes()
    {
        $leaveTypes = LeaveType::where('status', 'active')->get();

        $response = $leaveTypes->map(function ($leaveType) {
            return [
                'id' => $leaveType->id,
                'name' => $leaveType->name,
                'isImgRequired' => (bool)$leaveType->is_img_required,
            ];
        });

        return Success::response($response);
    }

    public function getLeaveRequests()
    {
        $leaveRequests = LeaveRequest::where('user_id', auth()->user()->id)->get();

        $response = $leaveRequests->map(function ($leaveRequest) {
            return [
                'id' => $leaveRequest->id,
                'fromDate' => $leaveRequest->from_date,
                'toDate' => $leaveRequest->to_date,
                'leaveType' => $leaveRequest->leaveType->name,
                'comments' => $leaveRequest->remarks,
                'status' => $leaveRequest->status,
                'createdOn' => $leaveRequest->created_at->format('Y-m-d H:i:s'),
                'approvedOn' => $leaveRequest->approved_at != null ? $leaveRequest->approved_at : '',
                'approvedBy' => $leaveRequest->approved_at != null ? 'Admin' : '',
            ];
        });

        return Success::response($response);
    }

    public function uploadLeaveDocument(Request $request)
    {
        $file = $request->file('file');

        if ($file == null) {
            return response()->json([
                'statusCode' => 400,
                'status' => 'failed',
                'message' => 'File is required',
            ]);
        }

        $lastLeaveRequest = LeaveRequest::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->first();

        if ($lastLeaveRequest == null) {
            return response()->json([
                'statusCode' => 400,
                'status' => 'failed',
                'message' => 'No leave request found',
            ]);
        }

        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('uploads/LeaveRequestDocuments', $fileName, 'public');

        Storage::put($filePath, file_get_contents($file));

        $lastLeaveRequest->document = '/storage/' . $filePath;
        $lastLeaveRequest->save();

        return Success::response('Document uploaded successfully');

    }

    public function deleteLeaveRequest(Request $request)
    {
        $req = $request->all();

        $leaveRequestId = reset($req);

        if ($leaveRequestId == null) {
            Error::response('Leave request Id is required');
        }

        $leaveRequest = LeaveRequest::find($leaveRequestId);

        if ($leaveRequest == null) {
            Error::response('Leave request not found');
        }

        if ($leaveRequest->status != 'pending') {
            Error::response('Leave request cannot be deleted');
        }

        $leaveRequest->delete();

        Success::response('Leave request deleted successfully');
    }

    public function createLeaveRequest(Request $request)
    {

        $fromDate = $request->fromDate;
        $toDate = $request->toDate;
        $leaveTypeId = $request->leaveType;
        $remarks = $request->comments;

        if ($fromDate > $toDate) {
            Error::response('From date cannot be greater than to date');
        }

        if ($leaveTypeId == null) {
            Error::response('Leave type is required');
        }

        $leaveType = LeaveType::find($leaveTypeId);

        if ($leaveType == null) {
            return Error::response('Leave type not found');
        }


        $finalFromDate = strtotime($fromDate);
        $finalToDate = strtotime($toDate);


        LeaveRequest::create([
            'from_date' => date('Y-m-d', $finalFromDate),
            'to_date' => date('Y-m-d', $finalToDate),
            'leave_type_id' => $leaveTypeId,
            'remarks' => $remarks,
            'user_id' => auth()->user()->id,
        ]);

        return Success::response('Leave request created successfully');
    }
}
