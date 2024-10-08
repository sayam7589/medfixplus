<?php

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
