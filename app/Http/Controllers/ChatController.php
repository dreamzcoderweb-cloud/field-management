<?php

namespace App\Http\Controllers;

use App\Classes\ChatHelper;
use App\Models\Chat;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Sentinel;

class ChatController extends Controller
{
    public function index()
    {
        $teams = Team::where('status', '=', 'active')
            ->select('id', 'name', 'description')
            ->get();

        return view('chat.index', compact('teams'));
    }

    public function getTeamChat(Request $request)
    {
        $authUserId = Sentinel::getUser()->id;

        $users = User::where('id', '!=', $authUserId)
            ->select('id', 'first_name', 'last_name')
            ->get();

        $chats = Chat::where('team_id', '=', $request->teamId)
            ->orderBy('created_at', 'asc')
            ->get();

        $response = [];

        $chatHelper = new ChatHelper();

        foreach ($chats as $chat) {
            $isYour = $chat->user_id == $authUserId;

            $response[] = [
                'isYou' => $isYour,
                'from' => $isYour ? 'You' : $users->where('id', '=', $chat->user_id)->first()->getFullName(),
                'message' => $chat->message,
                'time' => $chatHelper->time2str($chat->created_at),
                'type' => $chat->type,
                'imageUrl' => $chat->type == 'image' ? url('uploads/chatImages/' . $chat->message) : '',
            ];
        }
        return response()->json($response);
    }

    public function sendMessage(Request $request)
    {
        $chat = new Chat();
        $chat->team_id = $request->teamId;
        $chat->user_id = Sentinel::getUser()->id;
        $chat->message = $request->message;
        $chat->save();

        return response()->json(['success' => true]);
    }
}
