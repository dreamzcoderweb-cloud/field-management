<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Task\UpdateTaskRequest;
use App\Models\Clientmeet;
use App\Models\Duty;
use App\Models\Ledger;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required', Rule::exists(User::class, 'id')]
        ]);
        $tasks = Duty::with(['user', 'assignedby', 'due.client', 'clientmeet.client', 'followlead.lead.product'])
            ->where('user_id', $validated['user_id'])
            ->whereNotIn('status', [1, 2])
            ->latest()
            ->get();
        return new JsonResponse([
            'status' => true,
            'message' => $tasks
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
    public function show(Duty $duty)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Duty $duty)
    {
        return new JsonResponse([
            'status' => true,
            'task_details' => $duty?->load(['user', 'assignedby', 'due.client', 'clientmeet.client', 'followlead.lead.product'])
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Duty $duty)
    {
        $validated = $request->validated();
        // Check if the authenticated user is authorized to update the task
        if ($validated['user_id'] !== $duty->user_id) {
            return new JsonResponse([
                'status' => false,
                'message' => 'Unable to access this task for the current user.'
            ], 401);
        }

        if ($duty->status == 1) {
            return new JsonResponse([
                'status' => false,
                'message' => 'Unable to change status because it is already completed.'
            ], 403);
        }

        if ($duty->type == 3 && $validated['status'] == 1) {
            if ($duty?->due) {
                $duty?->due?->sale->decrement('balance', $duty->due->amount);
                $duty?->due?->sale->increment('paid_amount', $duty->due->amount);
            }
        }

        if ($duty->type == 2 && $validated['next_meet'] != "") {
            $client_meet = Clientmeet::where('duty_id', $duty->id)
                ->first();
            $client_meet->next_meet = $validated['next_meet'];
            $client_meet->update();
        }

        $duty->update($validated);
        $completeSale = $this->CompleteSale();
        return new JsonResponse([
            'status' => true,
            'message' => 'Task updated successfully!'
        ]);
    }

    public function CompleteSale()
    {
        $success = false;
        $sales = Sale::where('is_completed', 0)
            ->with(['duty', 'due'])
            ->get();
        // dd($sales[0]?->due?->filter(fn($due) => optional($due?->duty)?->status == 1)->count());

        foreach ($sales as $sale) {
            if ($sale->emi_month == $sale?->due?->filter(fn($due) => optional($due?->duty)?->status == 1)->count()) {
                $sale->is_completed = 1;
                $ledger = $this->checkLedger($sale);
                $sale->update();
                $success = true;
            }
        }

        return response()->json($success);
    }

    public function checkLedger($sale)
    {
        $ledger = Ledger::where('status', 2)
            ->where('sale_id', $sale->id)
            ->first();
        if (isset($ledger) && (now() < $ledger->created_at->addDays(180))) {
            if ($sale->paid_amount >= $sale->amount) {
                $ledger->status = 1;
                $ledger->save();
            }
        }
        return true;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Duty $duty)
    {
        //
    }
}

