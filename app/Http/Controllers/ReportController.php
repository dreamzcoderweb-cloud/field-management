<?php

namespace App\Http\Controllers;

use App\Exports\AttendanceExport;
use App\Exports\ExpenseReport;
use App\Exports\LeaveReport;
use App\Exports\VisitExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index()
    {
         $employees = \App\Models\User::query()
            // ->where('designation', 'employee')
            ->get();

        return view('report.index', compact('employees'));
    }

    public function getAttendanceReport(Request $request)
    {
        $fromDate = $request->from_date;
        $toDate = $request->to_date;

        // Blade sends `employeeId`
        $employeeId = $request->employeeId;

        // Backward compatibility: if no from/to provided, use month/year from `period`
        $period = $request->period;

        if (empty($fromDate) && empty($toDate)) {
            if (!$period) {
                return redirect()->back()->with('error', 'Please select a period');
            }

            $month = date('m', strtotime($period));
            $year = date('Y', strtotime($period));

            return Excel::download(
                new AttendanceExport($month, $year, null, null, $employeeId),
                time() . '_attendance_report.xlsx'
            );
        }

        // from/to provided: ignore month/year and filter by date range
        return Excel::download(
            new AttendanceExport(null, null, $fromDate, $toDate, $employeeId),
            time() . '_attendance_report.xlsx'
        );
    }

    public function getVisitReport(Request $request)
    {
        $period = $request->period;

        if (!$period) {
            return redirect()->back()->with('error', 'Please select a period');
        }

        $month = date('m', strtotime($period));

        $year = date('Y', strtotime($period));

        return Excel::download(new VisitExport($month, $year), time() . '_visit_report.xlsx');
    }

    public function getLeaveReport(Request $request)
    {
        $period = $request->period;

        if (!$period) {
            return redirect()->back()->with('error', 'Please select a period');
        }

        $month = date('m', strtotime($period));

        $year = date('Y', strtotime($period));

        return Excel::download(new LeaveReport($month, $year), time() . '_leave_report.xlsx');
    }

    public function getExpenseReport(Request $request)
    {
        $period = $request->period;

        if (!$period) {
            return redirect()->back()->with('error', 'Please select a period');
        }

        $month = date('m', strtotime($period));

        $year = date('Y', strtotime($period));

        return Excel::download(new ExpenseReport($month, $year), time() . '_expense_report.xlsx');
    }
}
