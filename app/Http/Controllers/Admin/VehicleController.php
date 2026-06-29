<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Vehicle\StoreVehicleRequest;
use App\Http\Requests\Admin\Vehicle\UpdateVehicleRequest;
use App\Models\Vehicle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vehicles = Vehicle::latest()
            ->get();
        return view('vehicle.index', ['vehicles' => $vehicles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vehicle.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVehicleRequest $request)
    {
        Vehicle::create($request->validated());
        return to_route('admin.vehicle.index')->with('success', "Vehicle Added!!!");
    }

    /**
     * Display the specified resource.
     */
    public function show(Vehicle $vehicle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vehicle $vehicle)
    {
        return view('vehicle.edit', ['vehicle' => $vehicle]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVehicleRequest $request, Vehicle $vehicle)
    {
        $vehicle->update($request->validated());
        return to_route('admin.vehicle.index')->with('success', "Vehicle Updated!!!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle)
    {
        //
    }

    public function updateVehicleStatus(Request $request)
    {
        $vehicle = Vehicle::where('id', $request?->id)
            ->first();
        if (isset($vehicle)) {
            $vehicle->update([
                'status' => $request?->status == 1 ? 1 : 0
            ]);

            return new JsonResponse([
                'status' => true
            ]);
        }
        return new JsonResponse([
            'status' => false
        ]);
    }
}
