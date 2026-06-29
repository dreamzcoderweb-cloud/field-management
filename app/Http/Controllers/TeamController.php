<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request as HttpRequest;
use Request;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::all();
        return view('team.index', compact('teams'));
    }

    public function create()
    {
        return view('team.create');
    }

    public function store()
    {
        $data = request()->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        Team::create($data);

        return redirect()->route('team.index')->with('success', 'Team Created Successfully');
    }

    public function edit($id)
    {
        $team = Team::find($id);
        return view('team.edit', compact('team'));
    }

    public function update(Request $request)
    {
        $rules = [
            'name' => 'required',
            'description' => 'required',
        ];

        $data = request()->validate($rules);

        $team = Team::find(request('id'));

        if ($team->name != request('name')) {
            $team->name = request('name');
        }

        if ($team->description != request('description')) {
            $team->description = request('description');
        }

        $team->save();

        return redirect()->route('team.index')->with('success', 'Team Updated Successfully');
    }

    public function delete($id)
    {
        $team = Team::find($id);
        $team->delete();
        return redirect()->route('team.index')->with('success', 'Team Deleted Successfully');
    }

    public function changeStatus()
    {
        $team = Team::find(request()->id);
        $team->status = $team->status == 'active' ? 'inactive' : 'active';
        $team->save();

        return response()->json('Status Updated Successfully.');
    }

    public function changeChatStatus()
    {
        $team = Team::find(request()->id);
        $team->is_chat_enabled = $team->is_chat_enabled == '1' ? '0' : '1';
        $team->save();

        return response()->json('Chat Status Updated Successfully.');
    }

    public function getMembers(HttpRequest $request)
    {
        // dd($request->all());
        $users = User::where('team_id', $request->teamId)
            ->get();
            // dd($users);
        return new JsonResponse([
            'users' => $users
        ]);
    }
}
