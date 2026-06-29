<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseType\StoreExpenseTypeRequest;
use App\Http\Requests\ExpenseType\UpdateExpenseTypeRequest;
use App\Models\ExpenseType;
use Illuminate\Http\Request;

class ExpenseTypeController extends Controller
{
    public function index()
    {
        $expenseTypes = ExpenseType::all();

        return view('expenseType.index', compact('expenseTypes'));
    }

    public function create()
    {
        return view('expenseType.create');
    }

    public function store(StoreExpenseTypeRequest $request)
    {
        ExpenseType::create($request->all());

        return redirect()->route('expenseType.index')->with('success', 'Expense Type Created Successfully');
    }

    public function edit(ExpenseType $expenseType)
    {
        return view('expenseType.edit', ['expenseType' => $expenseType]);
    }

    public function update(UpdateExpenseTypeRequest $request, ExpenseType $expenseType)
    {
        $expenseType->update($request->all());

        return redirect()->route('expenseType.index')->with('success', 'Expense Type Updated Successfully');
    }

    public function changeStatus(Request $request)
    {
        if(env('DEMO_MODE'))
            return response()->json('This action is disabled in demo mode');

        $expenseType = ExpenseType::find($request->id);
        $expenseType->status = $expenseType->status == 'active' ? 'inactive' : 'active';
        $expenseType->save();

        return response()->json('Status Updated Successfully.');
    }
}
