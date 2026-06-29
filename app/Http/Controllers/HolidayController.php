<?php

namespace App\Http\Controllers;

use App\Models\Holiday;

class HolidayController extends Controller
{
    public function index()
    {
        $holidays = Holiday::all();

        return view('holiday.index', compact('holidays'));
    }

    public function create()
    {
        return view('holiday.create');
    }

    public function store()
    {
        $rules = [
            'name' => 'required',
            'date' => 'required',
        ];

        $this->validate(request(), $rules);

        $holiday = new Holiday();
        $holiday->name = request('name');
        $holiday->date = request('date');
        $holiday->save();

        return redirect()->route('holiday.index')->with('success', 'Holiday created successfully');
    }

    public function destroy($id)
    {
        if(env('DEMO_MODE'))
            return redirect()->route('holiday.index')->with('error', 'This action is disabled in demo mode');


        $holiday = Holiday::findOrFail($id);
        $holiday->delete();

        return redirect()->route('holiday.index')->with('success', 'Holiday deleted successfully');
    }

    public function edit($id)
    {
        $holiday = Holiday::findOrFail($id);

        return view('holiday.edit', compact('holiday'));
    }

    public function update(\Request $request)
    {
        $rules = [
            'name' => 'required',
            'date' => 'required',
        ];

        $this->validate(request(), $rules);

        $holiday = Holiday::findOrFail(request('id'));
        $holiday->name = request('name');
        $holiday->date = request('date');
        $holiday->save();

        return redirect()->route('holiday.index')->with('success', 'Holiday updated successfully');
    }
}
