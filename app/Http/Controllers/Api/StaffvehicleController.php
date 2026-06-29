<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Staffvehicle\StoreStaffvehicleRequest;
use App\Models\Staffvehicle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffvehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staffvehiclesCount = Staffvehicle::where('user_id', Auth::id())
            ->get()
            ->count();

        return new JsonResponse([
            'success' => true,
            'count' => $staffvehiclesCount
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
    public function store(StoreStaffvehicleRequest $request)
    {
        $validator = $request->validated();
        $existing = Staffvehicle::where('user_id', Auth::id())
            ->latest()
            ->first();
        // return $existing;
        if (($existing == "") || ($existing?->type != $validator['type'])) {

            if ($request->has('kilometer_image')) {
                $imageDecode = base64_decode($validator['kilometer_image']);
                if ($imageDecode !== false) {
                    $imageName = uniqid() . ".jpeg";
                    file_put_contents(public_path('staff/vehicle') . '/' . $imageName, $imageDecode);
                    $validator['kilometer_image'] = $imageName;
                }
            }

            Staffvehicle::create($validator);
            return new JsonResponse([
                'success' => true,
                'message' => "Staff vehicle added successfully"
            ]);
        } else {
            // return new JsonResponse([
            //     'success' => false,
            //     'message' => "The type cannot be the same as the previous entry. Please open or close the last record before proceeding"
            // ], 422);

            return response()->json([
                'statusCode' => 400,
                'status' => 'failed',
                'data' => "The type cannot be the same as the previous entry. Please open or close the last record before proceeding",
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Staffvehicle $staffvehicle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Staffvehicle $staffvehicle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Staffvehicle $staffvehicle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Staffvehicle $staffvehicle)
    {
        //
    }
}

