<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::get();
        $leads = Lead::when(request('search'), function ($query, $search) {
            $query->where('name', 'LIKE', "$search%")
                ->orWhere('mobile', 'LIKE', "$search%")
                ->orWhere('city', 'LIKE', "$search%")
                ->orWhereRelation('user', 'user_name', 'LIKE', "$search%");
        })
            ->when(request('productId'), function ($query, $productId) {
                $query->where('product_id', $productId);
            })
            ->when(request('status'), function ($query, $status) {
                $query->where('status', $status);
            })
            ->when(request('from_date'), function ($query, $from_date) {
                $query->whereDate('created_at', '>=', $from_date);
            })
            ->when(request('to_date'), function ($query, $to_date) {
                $query->whereDate('created_at', '<=', $to_date);
            })
            ->with(['user', 'product'])
            ->latest()
            ->paginate(20);
        return view('lead.index', ['leads' => $leads, 'products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $lead = Lead::where('id', $request?->id)
            ->first();
        if (isset($lead)) {
            $lead->update([
                'status' => $request?->status
            ]);

            return new JsonResponse([
                'status' => true
            ]);
        }
        return new JsonResponse([
            'status' => false
        ]);
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
    public function show(Lead $lead)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lead $lead)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lead $lead)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lead $lead)
    {
        //
    }
}
