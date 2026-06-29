<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ledger;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LedgerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validator = $request->validate(['status' => 'required|integer|in:1,2']);
        $ledgers = Ledger::when(request('from'), function ($query, $from) {
            $query->whereDate('created_at', '>=', "$from");
        })
            ->when(request('to'), function ($query, $to) {
                $query->whereDate('created_at', '<=', Carbon::parse($to)->endOfDay());
            })
            ->where('status', $validator['status'])
            ->where('user_id', Auth::id())
            ->with('sale', 'sale.client', 'sale.product', 'user')
            ->latest()
            ->get();
        return response()->json([
            'statusCode' => 200,
            'status' => 'success',
            'data' => $ledgers,
        ]);
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
    public function show(Ledger $ledger)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ledger $ledger)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ledger $ledger)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ledger $ledger)
    {
        //
    }
}
