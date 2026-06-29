<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Task\StoreTaskRequest;
use App\Models\Client;
use App\Models\Clientmeet;
use App\Models\Due;
use App\Models\Duty;
use App\Models\Followlead;
use App\Models\Lead;
use App\Models\Sale;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DutyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $duties = Duty::with(['user', 'assignedby', 'team'])
            ->when(request('search'), function ($query, $search) {
                $query->where('title', 'LIKE', "$search%")
                    ->orWhereRelation('user', 'first_name', 'LIKE', "$search%")
                    ->orWhereRelation('user', 'last_name', 'LIKE', "$search%")
                    ->orWhereRelation('assignedby', 'first_name', 'LIKE', "$search%")
                    ->orWhereRelation('assignedby', 'last_name', 'LIKE', "$search%");
            })
            ->when(request('employee_id'), function ($query, $employeeId) {
                $query->where('user_id', $employeeId);
            })            
            ->when(request('status'), function ($query, $status) {
                if ($status == 8) {
                    $status = 0;
                }
                $query->where('status', '=', $status);
            })
            ->when(request('team_id'), function ($query, $team_id) {
                $query->where('team_id', $team_id);
            })
            ->when(request('type'), function ($query, $type) {
                $query->where('type', '=', $type);
            })
            ->when(request('from_date'), function ($query, $fromDate) {
                $query->where(function ($query) use ($fromDate) {
                    $query->whereDate('created_at', '>=', $fromDate);
                });
            })
            ->when(request('to_date'), function ($query, $toDate) {
                $query->where(function ($query) use ($toDate) {
                    $query->whereDate('created_at', '<=', $toDate);
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();
        $teams = Team::whereHas('users')
            ->get();
        return view('duty.index', ['duties' => $duties, 'teams' => $teams]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::all();
        $teams = Team::whereHas('users')
            ->get();
        $employees = User::where('designation', "Employee")
            ->with('team')
            ->get();
        // dd($employees);
        $leads = Lead::get();
        return view('duty.create', ['clients' => $clients, 'employees' => $employees, 'leads' => $leads, 'teams' => $teams]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $validated = $request->validated();
        // dd($validated);
        $duty = Duty::create($request->validated());
        if ($validated['type'] == 2) {
            Clientmeet::create([
                'duty_id' => $duty?->id,
                'client_id' => $validated['client_id'],
            ]);
        }
        if ($validated['type'] == 3) {
            Due::create([
                'sale_id' => $validated['sale_id'],
                'duty_id' => $duty?->id,
                'amount' => $validated['amount'],
                'client_id' => $validated['client_id'],
            ]);
        }

        if ($validated['type'] == 4) {
            Followlead::create([
                'lead_id' => $validated['lead_id'],
                'duty_id' => $duty?->id
            ]);
        }


        return to_route('admin.task.index')->with('success', "Task Added");
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Duty $duty)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Duty $duty)
    {
        // dd($duty);
        $duty->delete();
        return back()->with('error', "Task deleted!!!");
    }

    public function clientDetails(Request $request)
    {
        // dd($request->all());
        if ($request->type == 2) {
            $client = Client::where('id', $request->id)
                ->first();
            return new JsonResponse([
                'type' => $request->type,
                'client' => $client
            ]);
        } elseif ($request->type == 3) {
            $sales = Sale::with('product')
                ->where('client_id', $request->id)
                ->where('is_completed', 0)
                ->get();
            return new JsonResponse([
                'type' => $request->type,
                'sales' => $sales
            ]);
        }
    }

    public function getAmount(Request $request)
    {
        $amount = Sale::where('id', $request?->id)
            ?->first()
            ?->emi_amount;
        return new JsonResponse([
            'amount' => $amount
        ]);
    }

    public function updateTaskStatus(Request $request)
    {
        // dd($request->all());
        $duty = Duty::where('id', $request?->id)
            ->first();
        if (isset($duty)) {
            $duty->update([
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
}
