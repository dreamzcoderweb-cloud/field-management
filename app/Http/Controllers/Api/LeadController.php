<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Lead\StoreLeadRequest;
use App\Http\Requests\Api\Lead\UpdateLeadRequest;
use App\Models\Client;
use App\Models\Lead;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statusMap = [
            1 => 'Cold',
            2 => 'Warm',
            3 => 'Hot',
            4 => 'Convert to customer',
        ];

        $leads = Lead::with('product')
            ->when(request('search'), function ($query, $search) {
                $query->where('name', 'LIKE', "$search%")
                    ->orWhere('mobile', 'LIKE', "$search%")
                    ->orWhere('city', 'LIKE', "$search%")
                    ->orWhere('email', 'LIKE', "$search%")
                    ->orWhere('model', 'LIKE', "$search%")
                    ->orWhere('year', 'LIKE', "$search%")
                    ->orWhere('vehicle_number', 'LIKE', "$search%")
                    ->orWhereRelation('user', 'user_name', 'LIKE', "$search%")
                    ->orWhereRelation('product', 'name', 'LIKE', "$search%");
            })
            ->when(request('from_date'), function ($query, $from_date) {
                $query->whereDate('created_at', '>=', $from_date);
            })
            ->when(request('to_date'), function ($query, $to_date) {
                $query->whereDate('created_at', '<=', $to_date);
            })
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        foreach ($leads as $lead) {
            $lead->product_name = $lead->product?->name;
            $lead->status_name = $statusMap[$lead->status] ?? 'Unknown';
        }

        return new JsonResponse([
            "statusCode" => 200,
            'status' => "success",
            'leads' => $leads,
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
    public function store(StoreLeadRequest $request)
    {
        // return $request->validated();
        $validator = $request->validated();
        $lead = Lead::create($validator);
        if ($validator['status'] == 4) {
            Client::create([
                'name' => $lead?->name,
                'address' => $lead?->address,
                'latitude' => $lead?->latitude,
                'longitude' => $lead?->longitude,
                'phone' => $lead?->mobile,
                'email' => $lead?->email,
                'city' => $lead?->city,
                'created_by_id' => Auth::id(),
            ]);
        }
        return new JsonResponse([
            "statusCode" => 200,
            'status' => "success",
            'data' => "Lead created!!!"
        ]);
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
    public function update(UpdateLeadRequest $request, Lead $lead)
    {
        $validator = $request->validated();
        if ($lead->user_id == Auth::id()) {
            if ($validator['status'] == 4) {
                Client::create([
                    'name' => $lead?->name,
                    'address' => $lead?->address,
                    'latitude' => $lead?->latitude,
                    'longitude' => $lead?->longitude,
                    'phone' => $lead?->mobile,
                    'email' => $lead?->email,
                    'city' => $lead?->city,
                    'created_by_id' => Auth::id(),
                ]);
            }
            $lead->update($validator);
            return new JsonResponse([
                "statusCode" => 200,
                'status' => "success",
                'data' => "Lead Updated!!!"
            ]);
        } else {
            return new JsonResponse([
                 "statusCode" => 500,
                'status' => "failed",
                'data' => "Unable to access your lead"
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lead $lead)
    {
        //
    }
}
