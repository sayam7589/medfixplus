<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LineController extends Controller
{
    public function webhook(Request $request)
    {
        $events = $request->input('events', []);

        foreach ($events as $event) {
            // กัน key หายจาก payload ที่ไม่สมบูรณ์
            if (($event['type'] ?? null) === 'message' && ($event['message']['type'] ?? null) === 'text') {
                $userId = $event['source']['userId'] ?? null;
                $question = $event['message']['text'] ?? '';

                if (!$userId) {
                    continue;
                }

                try {
                    $response = Http::timeout(30)->post('http://127.0.0.1:9000/ask/', [
                        'question' => $question
                    ]);

                    $answer = $response->successful()
                        ? $response->body() // plain text จาก FastAPI
                        : 'Error connecting to FastAPI.';
                } catch (\Exception $e) {
                    Log::error('LINE webhook -> FastAPI error: ' . $e->getMessage());
                    $answer = 'Error connecting to FastAPI.';
                }

                $this->sendLineMessage($userId, $answer);
            }
        }

        return response()->json(['status' => 'ok']);
    }

    private function sendLineMessage($userId, $message)
    {
        $channelAccessToken = env('CHANNEL_ACCESS_TOKEN_LINE');

        if (!$channelAccessToken) {
            Log::error('CHANNEL_ACCESS_TOKEN_LINE ไม่ได้ถูกตั้งค่าในไฟล์ .env');
            return;
        }

        try {
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
        } catch (\Exception $e) {
            Log::error('LINE push message error: ' . $e->getMessage());
        }
    }
}

