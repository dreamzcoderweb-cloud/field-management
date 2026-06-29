<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Task;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;


class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $task = Task::latest()->get();
        return view('task.index', ['tasks' => $task]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $client = Client::where('status', 'active')->latest()->get();
        return view('task.create', ['clients' => $client]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'client_id' => 'required',
            'type' => 'required'
        ]);


        // Get the authenticated user's ID
        $authId = Sentinel::getUser()->id;
        $validator['assigned_by_id'] = $authId;

        $task = Task::create($validator);
        return redirect()->route('task.index')->with('success', 'Task Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }
}
