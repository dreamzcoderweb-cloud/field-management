<?php

namespace App\Http\Controllers;


use App\Models\Loan;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;


class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $loan = Loan::latest()->where('status','active')->get();
        return view('loan.index',['loans'=>$loan]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('loan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = $request->validate(['name'=>'required']);
        $user = Sentinel::getUser();

        $validator['user_id'] = $user->id;
        Loan::create($validator);
        return redirect()->route('loan.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(Loan $loan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Loan $loan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Loan $loan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Loan $loan)
    {
        //
    }


    public function changeStatus(Request $request)
    {
        if(env('DEMO_MODE'))
            return response()->json('This action is disabled in demo mode');

        $loan = Loan::find($request->id);
        $loan->status = $loan->status == 'active' ? 'inactive' : 'active';
        $loan->save();

        return response()->json('Status Updated Successfully.');
    }
}
