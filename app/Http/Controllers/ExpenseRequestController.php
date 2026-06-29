<?php

namespace App\Http\Controllers;

use App\Models\ExpenseRequest;
use Illuminate\Http\Request;
use Sentinel;

class ExpenseRequestController extends Controller
{
    public function index()
    {
        $expenseRequests = ExpenseRequest::all();

        return view('expenseRequest.index', compact('expenseRequests'));
    }

    public function show(ExpenseRequest $expenseRequest)
    {
        return view('expenseRequest.show', compact('expenseRequest'));
    }

    public function action(Request $request)
    {
        $rules = [
            'status' => 'required',
            'remarks' => 'required',
        ];

        $this->validate($request, $rules);


        $expenseRequest = ExpenseRequest::find($request->input('id'));

        $expenseRequest->status = request('status');
        $expenseRequest->approved_by_id = Sentinel::getUser()->id;
        $expenseRequest->approver_remarks = request('remarks');
        $expenseRequest->approved_amount = request('approvedAmount');
        $expenseRequest->approved_at = now();
        $expenseRequest->save();

        return redirect()->route('expenseRequest.index')->with('success', 'Expense request has been '.request("status").' successfully.');
    }
}
