<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotifyController extends Controller
{
    /**
     * ส่งข้อความผ่าน LINE Notify
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(Request $request)
    {
        $message = $request->input('message', 'Hello from Laravel!');
        $result = sendLineNotify($message);

        if ($result) {
            return response()->json(['status' => 'success', 'message' => 'ข้อความถูกส่งเรียบร้อยแล้ว.']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'ไม่สามารถส่งข้อความได้.'], 500);
        }
    }



    public function handle(Request $request)
    {
        $events = $request->input('events');
        $channelToken = 'YOUR_LINE_CHANNEL_ACCESS_TOKEN';
        $openAiApiKey = 'Contact IT-med-rtaf';
        foreach ($events as $event) {
            if ($event['type'] === 'message' && $event['message']['type'] === 'text') {
                $userMessage = $event['message']['text'];
                $replyToken = $event['replyToken'];

                // ส่งข้อความไปยัง ChatGPT
                $chatResponse = Http::withToken($openAiApiKey)->post('https://api.openai.com/v1/chat/completions', [
                    'model' => 'gpt-3',
                    'messages' => [
                        ['role' => 'user', 'content' => $userMessage]
                    ],
                ]);

                $replyText = $chatResponse['choices'][0]['message']['content'] ?? 'ขออภัย เกิดข้อผิดพลาด';

                // ส่งกลับไปหา LINE User
                Http::withToken($channelToken)->post('https://api.line.me/v2/bot/message/reply', [
                    'replyToken' => $replyToken,
                    'messages' => [
                        ['type' => 'text', 'text' => $replyText]
                    ]
                ]);
            }
        }

        return response()->json(['status' => 'ok']);
    }
}

