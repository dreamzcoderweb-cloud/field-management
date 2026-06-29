<?php

namespace App\Http\Controllers;

use App\Classes\ViewHelper;
use App\Models\Visit;
use Illuminate\Http\Request;

class VisitController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->date;
        $employeeId = $request->employeeId;

        $viewHelper = new ViewHelper();

        if($date != null && $employeeId != null){
            $visits = Visit::whereDate('created_at', $date)
                ->where('created_by_id', $employeeId)->get();
        }else{
            $visits = Visit::all();
        }

        $employees = $viewHelper->getEmployeeSelectLists();

        return view('visit.index', compact('visits', 'employees', 'date', 'employeeId'));
    }

    public function destroy($id)
    {
        if(env('DEMO_MODE'))
            return redirect()->route('visit.index')->with('error', 'This action is disabled in demo mode');

        $visit = Visit::find($id);
        $visit->delete();

        return redirect()->route('visit.index')->with('success', 'Visit deleted successfully');
    }
}
