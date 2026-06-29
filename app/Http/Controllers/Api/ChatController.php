<?php

namespace App\Http\Controllers\Api;

use App\Api\Shared\Responses\Error;
use App\Api\Shared\Responses\Success;
use App\Classes\ChatHelper;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function postChat(Request $request)
    {
        $req = $request->all();

        $message = reset($req);

        Chat::create([
            'team_id' => auth()->user()->team_id,
            'user_id' => auth()->user()->id,
            'message' => $message,
            'type' => 'text',
        ]);

        return Success::response('Chat posted successfully');
    }

    public function postImageChat(Request $request)
    {
        $file = $request->file('file');

        $fileName = time() . '.' . $file->getClientOriginalExtension();

        $file->move(public_path('uploads/chatImages'), $fileName);

        Chat::create([
            'team_id' => auth()->user()->team_id,
            'user_id' => auth()->user()->id,
            'message' => $fileName,
            'type' => 'image',
        ]);

        return Success::response('Chat posted successfully');
    }

    public function getChats(Request $request)
    {
        $skip = $request->skip ?? 0;
        $take = $request->take ?? 10;

        $user = auth()->user();

        $team = Team::where('id', $user->team_id)->first();

        if ($team == null) {
            return Error::response('Team not found');
        }

        $chatItems = [];

        $chats = Chat::where('team_id', $team->id)
            ->orderBy('created_at', 'desc')
            ->skip($skip)
            ->take($take)
            ->get();

        if ($chats != null && $chats->count() > 0) {

            $chatHelper = new ChatHelper();

            $chatItems = $chats->map(function ($chat) use ($chatHelper) {
                $from = '';
                if ($chat->user_id != auth()->user()->id) {
                    $fromUser = User::where('id', $chat->user_id)->first();
                    $from = $fromUser->first_name . ' ' . $fromUser->last_name;
                }
                return [
                    'id' => $chat->id,
                    'message' => $chat->message,
                    'createdAt' => $chatHelper->time2str($chat->created_at),
                    'createdBy' => $chat->user->name,
                    'chatType' => $chat->type == 'text' ? 'text' : 'image',
                    'fileUrl' => $chat->type == 'image' ? url('uploads/chatImages/' . $chat->message) : '',
                    'from' => $from,
                ];
            });
        }

        $response = [
            'teamName' => $team->name,
            'teamId' => $team->id,
            'isChatEnabled' => (bool)$team->is_chat_enabled,
            'chatItems' => $chatItems,
        ];

        return response()->json([
            'statusCode' => 200,
            'status' => 'success',
            'data' => $response,
        ]);
    }


}
