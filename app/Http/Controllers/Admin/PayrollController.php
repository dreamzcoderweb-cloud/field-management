<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Settings;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $month = $request->month;
        $year = $request->year;

        // Get all attendances matching filters
        $attendances = Attendance::with('user')
            ->when($request->search, function ($query, $search) {
                $query->whereRelation('user', 'user_name', 'LIKE', "$search%");
            })
            ->when($month, fn($q) => $q->whereMonth('created_at', $month))
            ->when($year, fn($q) => $q->whereYear('created_at', $year))
            ->get()
            ->groupBy('user_id'); // Group by user for payroll

        $settings = Settings::first();

        // Map payroll calculation
        $payrollCollection = $attendances->map(function ($userAttendances, $userId) use ($month, $year) {
            $user = $userAttendances->first()->user;
            $baseSalary = $user->base_salary ?? 0;
            $availableLeaves = $user->available_leaves ?? 0;

            $date = Carbon::createFromDate($year, $month, 1);
            $totalDays = $date->daysInMonth;

            // Count Sundays
            $sundays = collect(range(1, $totalDays))
                ->map(fn($day) => Carbon::create($year, $month, $day))
                ->filter(fn($day) => $day->isSunday())
                ->count();

            // Count unique present days
            $presentDays = $userAttendances->groupBy(function ($attendance) {
                return Carbon::parse($attendance->created_at)->toDateString();
            })->count();

            $workingDays = $totalDays - $sundays;

            $totalLeavesTaken = $workingDays - $presentDays;
            $paidLeavesUsed = min($totalLeavesTaken, $availableLeaves);
            $unpaidLeaves = max(0, $totalLeavesTaken - $availableLeaves);

            $dailySalary = $workingDays > 0 ? $baseSalary / $workingDays : 0;
            $finalSalary = round($baseSalary - ($unpaidLeaves * $dailySalary), 2);

            return [
                'user_name' => $user->user_name,
                'base_salary' => $baseSalary,
                'present_days' => $presentDays,
                'sundays' => $sundays,
                'total_leaves_taken' => $totalLeavesTaken,
                'paid_leaves_used' => $paidLeavesUsed,
                'unpaid_leaves' => $unpaidLeaves,
                'calculated_salary' => $finalSalary,
            ];
        })->values(); // reset collection keys

        // Manual pagination
        $page = $request->get('page', 1);
        $perPage = 10;

        $paginatedPayroll = new LengthAwarePaginator(
            $payrollCollection->forPage($page, $perPage),
            $payrollCollection->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('payroll.index', [
            'payrollData' => $paginatedPayroll,
            'settings' => $settings,
            'month' => $month,
            'year' => $year
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
