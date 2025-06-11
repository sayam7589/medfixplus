<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LineController extends Controller
{
    public function webhook(Request $request)
    {
        $events = $request->input('events', []);

        foreach ($events as $event) {
            if ($event['type'] === 'message' && $event['message']['type'] === 'text') {
                $userId = $event['source']['userId'];
                $question = $event['message']['text'];

               
                $response = Http::post('http://127.0.0.1:9000/ask/', [
                    'question' => $question
                ]);

                $answer = $response->successful()
                    ? $response->body() // plain text จาก FastAPI
                    : 'Error connecting to FastAPI.';


                $this->sendLineMessage($userId, $answer);
            }
        }

        return response()->json(['status' => 'ok']);
    }

    private function sendLineMessage($userId, $message)
    {
        $channelAccessToken = env('CHANNEL_ACCESS_TOKEN_LINE');

        Http::timeout(30)->withHeaders([
            'Authorization' => "Bearer {$channelAccessToken}",
            'Content-Type' => 'application/json',
        ])->post('https://api.line.me/v2/bot/message/push', [
            'to' => $userId,
            'messages' => [
                [
                    'type' => 'text',
                    'text' => $message,
                ]
            ],
        ]);
    }
}

