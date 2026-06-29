<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Target;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TargetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $targets = Target::when(request('from_date'), function ($query, $from_date) {
            $query->whereDate('from', '>=', "$from_date");
        })
            ->when(request('to_date'), function ($query, $to_date) {
                $query->whereDate('from', '<=', "$to_date");
            })
            ->where('user_id', Auth::id())
            ->with('targetproduct', 'user')
            // Total target count
            ->withCount('targetproduct')
            ->withCount([
                'targetproduct as completedTargetCount' => function ($q) {
                    $q->where('is_completed', 1);
                }
            ])
            ->withCount([
                'targetproduct as balanceTargetCount' => function ($q) {
                    $q->where('is_completed', 0);
                }
            ])
            ->withSum('targetproduct', 'incentive')
            ->latest()
            ->get();

        return new JsonResponse([
            'success' => true,
            'targets' => $targets
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
    public function show(Target $target)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Target $target)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Target $target)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Target $target)
    {
        //
    }
}
