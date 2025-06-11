<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>{{ $inventory->inv_name  ?? 'ไม่พบข้อมูล' }}</title>
    <style>
        @page {
            size: 3.94in 1.97in landscape; /* แนวนอน */
            margin: 0;
        }

        body {
            margin: 0;
            font-family: "TH SarabunPSK", sans-serif;
            font-size: 28pt;
        }

        .label-container {
            display: flex;
            width: 100%;
            height: 100%;
            box-sizing: border-box;
            padding: 5mm;
        }

        .qr-code {
            flex: 0 0 auto;
            width: 40%; /* ปรับขนาด QR code */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .content {
            flex: 1;
            padding-left: 10px;
        }

        h4 {
            margin: 0 0 2px;
            font-size: 38pt;
        }

        p {
            margin: 0 0 2px;
        }

        strong {
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }
    </style>
</head>
<body>
    <div class="label-container">
        <div class="qr-code">
            {!! $qrcode !!}
        </div>
        <div class="content">
            <h4><u>MEDFIX+ (แจ้งซ่อม, ลงทะเบียนผู้ใช้งาน)</u></h4>
            <p><strong>MAC-Address: {{ $inventory->inv_mac_address ?? 'ไม่พบข้อมูล' }}</strong></p>
            <p><strong>RTAF-Number: {{ $inventory->inv_rtaf_serial  ?? 'ไม่พบข้อมูล' }}</strong></p>
            <p><strong>โครงการ: {{ $inventory->project->project_name  ?? 'ไม่พบข้อมูล' }}</strong></p>
            <p><strong>วันที่เริ่มใช้(ป/ด/ว): {{ $inventory->inv_setup_year  ?? 'ไม่พบข้อมูล' }}</strong></p>
            <p><strong>นททสส.พอ.(โทร 20008)</strong></p>
        </div>
    </div>
</body>
</html>
