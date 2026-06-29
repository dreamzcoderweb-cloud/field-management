<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use App\Models\User;
use Request;

class ShiftController extends Controller
{
    public function index()
    {
        $shifts = Shift::all();
        return view('shift.index', compact('shifts'));
    }

    public function create()
    {
        return view('shift.create');
    }

    public function store()
    {
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'startTime' => 'required',
            'endTime' => 'required',
        ];

        $this->validate(request(), $rules);

        if(request('sunday') == null && request('monday') == null && request('tuesday') == null && request('wednesday') == null && request('thursday') == null && request('friday') == null && request('saturday') == null)
        {
            return redirect()->back()->withInput()->with('error', 'Please select at least one day');
        }

        $shift = new Shift();
        $shift->title = request('name');
        $shift->description = request('description');
        $shift->start_time = request('startTime');
        $shift->end_time = request('endTime');
        $shift->sunday = request('sunday') == null ? 0 : 1;
        $shift->monday = request('monday') == null ? 0 : 1;
        $shift->tuesday = request('tuesday') == null ? 0 : 1;
        $shift->wednesday = request('wednesday') == null ? 0 : 1;
        $shift->thursday = request('thursday') == null ? 0 : 1;
        $shift->friday = request('friday') == null ? 0 : 1;
        $shift->saturday = request('saturday') == null ? 0 : 1;

        $shift->save();

        return redirect()->route('shift.index')->with('success', 'Shift created successfully');
    }

    public function destroy($id)
    {
        if(User::where('shift_id', $id)->count() > 0)
        {
            return redirect()->route('shift.index')->with('error', 'Shift cannot be deleted as it is assigned to one or more users');
        }

        $shift = Shift::find($id);
        $shift->delete();

        return redirect()->route('shift.index');
    }

    public function edit($id)
    {
        $shift = Shift::find($id);
        return view('shift.edit', compact('shift'));
    }

    public function update(Request $request)
    {
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'startTime' => 'required',
            'endTime' => 'required',
        ];

        $this->validate(request(), $rules);

        if(request('sunday') == null && request('monday') == null && request('tuesday') == null && request('wednesday') == null && request('thursday') == null && request('friday') == null && request('saturday') == null)
        {
            return redirect()->back()->withInput()->with('error', 'Please select at least one day');
        }

        $shift = Shift::find(request('id'));

        if($shift->title != request('name'))
        {
            $shift->title = request('name');
        }

        if($shift->description != request('description'))
        {
            $shift->description = request('description');
        }

        if($shift->start_time != request('startTime'))
        {
            $shift->start_time = request('startTime');
        }

        if($shift->end_time != request('endTime'))
        {
            $shift->end_time = request('endTime');
        }

        if($shift->sunday != (request('sunday') == null ? 0 : 1))
        {
            $shift->sunday = request('sunday') == null ? 0 : 1;
        }


        if($shift->monday != (request('monday') == null ? 0 : 1))
        {
            $shift->monday = request('monday') == null ? 0 : 1;
        }


        if($shift->tuesday != (request('tuesday') == null ? 0 : 1))
        {
            $shift->tuesday = request('tuesday') == null ? 0 : 1;
        }

        if ($shift->wednesday != (request('wednesday') == null ? 0 : 1)) {
            $shift->wednesday = request('wednesday') == null ? 0 : 1;
        }

        if ($shift->thursday != (request('thursday') == null ? 0 : 1)) {
            $shift->thursday = request('thursday') == null ? 0 : 1;
        }

        if ($shift->friday != (request('friday') == null ? 0 : 1)) {
            $shift->friday = request('friday') == null ? 0 : 1;
        }

        if ($shift->saturday != (request('saturday') == null ? 0 : 1)) {
            $shift->saturday = request('saturday') == null ? 0 : 1;
        }

        $shift->save();

        return redirect()->route('shift.index')->with('success', 'Shift updated successfully');
    }
}
