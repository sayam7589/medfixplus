<?php

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
/**
 * ส่งข้อความผ่าน LINE Notify
 *
 * @param string $message ข้อความที่ต้องการส่ง
 * @return bool ผลลัพธ์การส่ง (true: สำเร็จ, false: ล้มเหลว)
 */

if (!function_exists('toThaiDateFormat')) {
    function toThaiDateFormat($dateTime) {
        // แปลง string วันเวลาให้เป็น timestamp
        $timestamp = strtotime($dateTime);

        // กำหนดชื่อเดือนภาษาไทย
        $thaiMonths = [
            1 => 'ม.ค.',
            2 => 'ก.พ.',
            3 => 'มี.ค.',
            4 => 'เม.ย.',
            5 => 'พ.ค.',
            6 => 'มิ.ย.',
            7 => 'ก.ค.',
            8 => 'ส.ค.',
            9 => 'ก.ย.',
            10 => 'ต.ค.',
            11 => 'พ.ย.',
            12 => 'ธ.ค.'
        ];

        // ดึงค่าวัน เดือน ปี เวลา
        $day = date('j', $timestamp);
        $month = $thaiMonths[(int)date('n', $timestamp)];
        $year = date('Y', $timestamp) + 543;
        $time = date('H:i', $timestamp);

        // รวมผลลัพธ์ให้เป็นรูปแบบที่ต้องการ
        return "$day $month $year $time";
    }
}
if (!function_exists('toThaiDateFormatWithoutTime')) {
    function toThaiDateFormatWithoutTime($dateTime) {
        // แปลง string วันเวลาให้เป็น timestamp
        $timestamp = strtotime($dateTime);
        if($dateTime == '0000-00-00'){
            return "ไม่ระบุ";
        }else{
            // กำหนดชื่อเดือนภาษาไทย
            $thaiMonths = [
                1 => 'ม.ค.',
                2 => 'ก.พ.',
                3 => 'มี.ค.',
                4 => 'เม.ย.',
                5 => 'พ.ค.',
                6 => 'มิ.ย.',
                7 => 'ก.ค.',
                8 => 'ส.ค.',
                9 => 'ก.ย.',
                10 => 'ต.ค.',
                11 => 'พ.ย.',
                12 => 'ธ.ค.'
            ];

            // ดึงค่าวัน เดือน ปี
            $day = date('j', $timestamp);
            $month = $thaiMonths[(int)date('n', $timestamp)];
            $year = date('Y', $timestamp) + 543;

            // รวมผลลัพธ์ให้เป็นรูปแบบที่ต้องการ
            return "$day $month $year";

        }
    }
}

if (!function_exists('translateStatus')) {
    function translateStatus($status) {
        // กำหนดค่าแปลงสถานะ
        $statusMapping = [
            0 => 'อยู่ระหว่างดำเนินการ',
            1 => 'ซ่อมสำเร็จ',
            2 => 'ส่งกลับหน่วย',
            3 => 'ชำรุด',
        ];

        // ตรวจสอบสถานะ และส่งค่าที่แปลงแล้ว
        return $statusMapping[$status] ?? 'สถานะไม่รู้จัก'; // หากไม่พบสถานะใน mapping ให้ส่งค่าที่ไม่รู้จัก
    }
}
function getThaiMonthAbbreviation($monthNumber){
    $thaiMonths = [
        1 => 'ม.ค.', 2 => 'ก.พ.', 3 => 'มี.ค.', 4 => 'เม.ย.',
        5 => 'พ.ค.', 6 => 'มิ.ย.', 7 => 'ก.ค.', 8 => 'ส.ค.',
        9 => 'ก.ย.', 10 => 'ต.ค.', 11 => 'พ.ย.', 12 => 'ธ.ค.'
    ];

    return $thaiMonths[$monthNumber] ?? null;
}

if (!function_exists('sendLineNotify')) {
    function sendLineNotify(string $message): bool
    {
        // รับ Access Token จากไฟล์ .env
        $token = env('LINE_NOTIFY_TOKEN');

        if (!$token) {
            Log::error('LINE_NOTIFY_TOKEN ไม่ได้ถูกตั้งค่าในไฟล์ .env');
            return false;
        }

        // สร้าง Guzzle HTTP Client
        $client = new Client();

        try {
            // ส่ง POST request ไปยัง LINE Notify API
            $response = $client->request('POST', 'https://notify-api.line.me/api/notify', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                ],
                'form_params' => [
                    'message' => $message,
                ],
            ]);

            // ตรวจสอบสถานะการตอบกลับ
            if ($response->getStatusCode() === 200) {
                return true;
            }

            Log::error('LINE Notify ส่งข้อความไม่สำเร็จ: ' . $response->getBody());
            return false;
        } catch (\Exception $e) {
            // จัดการกับข้อผิดพลาด
            Log::error('LINE Notify Error: ' . $e->getMessage());
            return false;
        }
    }
}

if (!function_exists('getPrefixShortById')) {
    /**
     * แปลง id เป็น prefix_short
     *
     * @param int $id
     * @return string|null
     */
    function getPrefixShortById($id)
    {
        // เปลี่ยน 'prefixes' เป็นชื่อของตารางที่เก็บ prefix ของคุณ
        $prefix = DB::table('prefix')->where('id', $id)->value('prefix_short');

        return $prefix ?: null; // คืนค่า prefix_short หรือ null หากไม่พบ
    }
}

if (!function_exists('getPanakGongById')) {
    /**
     * แปลง id เป็น panak / gong
     *
     * @param int $id
     * @return string|null
     */
    function getPanakGongById($id)
    {
        // ดึงข้อมูลจากตาราง department ตาม id ที่กำหนด
        $department = DB::table('department')->where('id', $id)->first();

        if ($department) {
            return $department->panag . ' / ' . $department->gong; // คืนค่ารูปแบบ panak / gong
        }

        return null; // คืนค่า null หากไม่พบ
    }
}
