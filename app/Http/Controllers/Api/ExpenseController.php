<?php

namespace App\Http\Controllers\Api;

use App\Api\Shared\Responses\Error;
use App\Api\Shared\Responses\Success;
use App\Http\Controllers\Controller;
use App\Models\ExpenseRequest;
use App\Models\ExpenseType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExpenseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function getExpenseTypes()
    {
        $expenseTypes = ExpenseType::where('status', 1)->get();

        $response = $expenseTypes->map(function ($expenseType) {
            return [
                'id' => $expenseType->id,
                'name' => $expenseType->name,
                'isImgRequired' => (bool)$expenseType->is_img_required,
            ];
        });

        return response()->json([
            'statusCode' => 200,
            'status' => 'success',
            'data' => $response,
        ]);

    }

    public function getExpenseRequests()
    {
        $expenseRequests = ExpenseRequest::where('user_id', auth()->user()->id)->get();

        $response = $expenseRequests->map(function ($expenseRequest) {
            return [
                'id' => $expenseRequest->id,
                'date' => $expenseRequest->for_date,
                'type' => $expenseRequest->expenseType->name,
                'actualAmount' => doubleval($expenseRequest->amount),
                'approvedAmount' => $expenseRequest->approved_amount != null ? floatval($expenseRequest->approved_amount) : null,
                'comments' => $expenseRequest->remarks,
                'status' => $expenseRequest->status,
                'createdAt' => $expenseRequest->created_at->format('Y-m-d H:i:s'),
                'approvedAt' => $expenseRequest->approved_at != null ? $expenseRequest->approved_at : '',
                'approvedBy' => $expenseRequest->approved_by != null ? 'Admin' : '',
            ];
        });

        return response()->json([
            'statusCode' => 200,
            'status' => 'success',
            'data' => $response,
        ]);
    }

    public function deleteExpenseRequest(Request $request)
    {
        $req = $request->all();

        $expenseRequestId = reset($req);

        if ($expenseRequestId == null) {
            return Error::response('Expense Request Id is required');
        }

        $expenseRequest = ExpenseRequest::find($expenseRequestId);

        if ($expenseRequest == null) {
            return Error::response('Expense Request not found');
        }

        if ($expenseRequest->status != 'pending') {
            return Error::response('Expense Request cannot be deleted');
        }

        $expenseRequest->delete();

        return Success::response('Expense Request deleted successfully');

    }

    public function uploadExpenseDocument(Request $request)
    {

        $file = $request->file('file');

        if ($file == null) {
            Error::response('File is required');
        }

        $lastExpenseRequest = ExpenseRequest::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->first();

        if ($lastExpenseRequest == null) {
            Error::response('No expense request found');
        }

        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('uploads/ExpenseRequestDocuments', $fileName, 'public');

        Storage::put($filePath, file_get_contents($file));

        $lastExpenseRequest->document = '/storage/' . $filePath;
        $lastExpenseRequest->save();

        return Success::response('Document uploaded successfully');
    }


    public function createExpenseRequest(Request $request)
    {
        $date = $request->date;
        $amount = $request->amount;
        $expenseTypeId = $request->typeId;
        $remarks = $request->comments;

        if ($date == null) {
            return Error::response('Date is required');
        }

        if ($amount == null) {
            return Error::response('Amount is required');
        }

        if ($amount <= 0) {
            return Error::response('Amount should be greater than 0');
        }

        if ($expenseTypeId == null) {
            return Error::response('Expense Type is required');
        }

        if ($remarks == null) {
            return Error::response('Remarks is required');
        }

        $finalForDate = strtotime($date);

        $expenseRequest = new ExpenseRequest();
        $expenseRequest->user_id = auth()->user()->id;
        $expenseRequest->for_date = date('Y-m-d', $finalForDate);
        $expenseRequest->amount = $amount;
        $expenseRequest->expense_type_id = $expenseTypeId;
        $expenseRequest->remarks = $remarks;
        $expenseRequest->status = 'pending';

        $expenseRequest->save();

        return Success::response('Expense Request Created Successfully');
    }
}
