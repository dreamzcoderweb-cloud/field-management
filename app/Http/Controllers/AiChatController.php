<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AiChatController extends Controller
{

    public function index()
    {

    }

    public function sendMessage(Request $request)
    {
        $response = Http::withHeaders([
            'Content-Type' => "application/json",
            "Authorization" => "Bearer ".env('OPEN_AI_KEY'),
        ])->post('https://api.openai.com/v1/chat/completions', [
            "model" => "gpt-3.5-turbo",
            "messages" => [
                [
                    "role"=> "user",
                    "content" => $request->post('message')
                ]
            ],
            "max_tokens" => 2048,
            "temperature" => 0,
        ])->body();

        return response()->json(json_decode($response));
    }
}
