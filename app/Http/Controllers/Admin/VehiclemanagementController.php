<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Vehicle\StoreVehicleRequest;
use App\Http\Requests\Admin\Vehicle\UpdateVehicleRequest;
use App\Http\Requests\Admin\Vehiclemanagement\StoreVehiclemanagementRequest;
use App\Http\Requests\Admin\Vehiclemanagement\UpdateVehiclemanagementRequest;
use App\Models\Vehicle;
use App\Models\Vehiclemanagement;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VehiclemanagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vehicles = Vehicle::all();
        $vehiclemanagements = Vehiclemanagement::with('vehicle')
            ->when(request('search'), function ($query, $search) {
                $query->where('driver_name', 'LIKE', "$search%")
                    ->orWhere('location', 'LIKE', "$search%");
            })
            ->when(request('vehicle_id'), function ($query, $vehicleId) {
                $query->where('vehicle_id', '=', $vehicleId);
            })
            ->when(request()->filled('from_date') && request()->filled('to_date'), function ($query) {
                $query->whereBetween('created_at', [
                    Carbon::parse(request('from_date'))->startOfDay(),
                    Carbon::parse(request('to_date'))->endOfDay(),
                ]);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();
        return view('vehiclemanagement.index', ['vehiclemanagements' => $vehiclemanagements, 'vehicles' => $vehicles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $vehicles = Vehicle::where('status', 1)
            ->get();
        return view('vehiclemanagement.create', ['vehicles' => $vehicles]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVehiclemanagementRequest $request)
    {
        // dd($request);
        Vehiclemanagement::create($request->validated());
        return to_route('admin.vehiclemanagement.index')->with('success', "Vehical detail added!!!");
    }

    /**
     * Display the specified resource.
     */
    public function show(Vehiclemanagement $vehiclemanagement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vehiclemanagement $vehiclemanagement)
    {
        $vehicles = Vehicle::where('status', 1)
            ->get();
        return view('vehiclemanagement.edit', ['vehiclemanagement' => $vehiclemanagement, 'vehicles' => $vehicles]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVehiclemanagementRequest $request, Vehiclemanagement $vehiclemanagement)
    {
        $vehiclemanagement->update($request->validated());
        return to_route('admin.vehiclemanagement.index')->with('success', "Vehicle detail updated!!!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehiclemanagement $vehiclemanagement)
    {
        $vehiclemanagement->delete();
        return to_route('admin.vehiclemanagement.index')->with('success', "Vehicle detail deleted!!!");
    }
}
