<?php

namespace App\Http\Controllers;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
 use Illuminate\Support\Facades\Log;
use App\Models\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bank = Bank::latest()->where('status','active')->get();
        return view('bank.index',['banks'=>$bank]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bank.create');
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = $request->validate(['name'=>'required']);
        $user = Sentinel::getUser();

        $validator['user_id'] = $user->id;
        Bank::create($validator);
        return redirect()->route('bank.index')->with('success','Bank Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Bank $bank)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bank $bank)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bank $bank)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
  
    
    public function destroy($id)
{
    // Find the ProductCategory by ID
    $bank= Bank::find($id);

    // Check if the category exists
    if (!$bank) {
        Log::error('Bank not found for ID: ' . $id);
        return redirect()->route('bank.index')->with('error', 'Bank not found.');
    }

    Log::info('Attempting to delete category ID: ' . $bank->id);

    // Check if the category has subcategories
    if ($bank->client()->count() > 0) {
         return redirect()->route('bank.index')->with('error', 'This bank has used in client so cannot be deleted.');
    }

    // Attempt to delete the category
    try {
        $bank->delete();
         return redirect()->route('bank.index')->with('success', 'Bank deleted successfully.');
    } catch (\Exception $e) {
        // Handle any exceptions during deletion
         return redirect()->route('bank.index')->with('error', 'An error occurred while deleting the category.');
    }
}



    public function changeStatus(Request $request)
    {
        if(env('DEMO_MODE'))
            return response()->json('This action is disabled in demo mode');

        $bank = Bank::find($request->id);
        $bank->status = $bank->status == 'active' ? 'inactive' : 'active';
        $bank->save();

        return response()->json('Status Updated Successfully.');
    }
}
