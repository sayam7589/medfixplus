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
}
