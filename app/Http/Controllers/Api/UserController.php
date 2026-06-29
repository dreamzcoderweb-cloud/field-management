<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ExpenseRequest;
use App\Models\Shift;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function getDashboardData()
    {
        $user = auth()->user();

        $shift = Shift::where('id', $user->shift_id)->first();

        $expenseRequests = ExpenseRequest::where('user_id', $user->id)->get();

        $approvedAmount = $expenseRequests->where('status', 'approved')->sum('approved_amount');

        $pendingAmount = $expenseRequests->where('status', 'pending')->sum('amount');

        $rejectedAmount = $expenseRequests->where('status', 'rejected')->sum('amount');

        $response =[
            'scheduleTime' => $shift->start_time . ' - ' . $shift->end_time,
            'availableLeaveCount' => $user->available_leave_count,
            'approved'=> $approvedAmount,
            'pending'=> $pendingAmount,
            'rejected'=> $rejectedAmount,
            'WeekOffDays'=> 0, //TODO: need to calculate from schedule
            'presentDays'=> 0, //TODO: need to calculate from attendance
            'absentDays'=> 0, //TODO: need to calculate from attendance
            'halfDays'=> 0, //TODO: need to calculate from attendance
            'onLeaveDays'=> 0,
            'travelled'=> 0, //TODO: need to calculate from visit
            'scheduleWeeks'=>[
                (bool)$shift->sunday,
                (bool)$shift->monday,
                (bool)$shift->tuesday,
                (bool)$shift->wednesday,
                (bool)$shift->thursday,
                (bool)$shift->friday,
                (bool)$shift->saturday,
            ]
        ];

        return response()->json([
            'statusCode' => 200,
            'status' => 'success',
            'data' => $response,
        ]);
    }
}
