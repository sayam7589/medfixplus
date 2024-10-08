
@extends('layouts.qrcode')

@section('title', 'QR Code')

@section('content')
    <div class="row justify-content-center mb-2">
        <div class="card-container col-md-10">
            <div class="qr-card">
                <h3 class ="card-title">Medfix+</h3>
                <h3>เเจ้งซ่อม, ลงทะเบียนผู้ใช้งาน</h3>
                <h3>( กรุณา scan qrcode ด่านล่าง )</h3><br>
                <div class="qr-code">
                    {!! $qrcode !!}
                </div><br>
                <div class="info">
                    <p><strong>MAC-Address:</strong> {{ $inventory->inv_mac_address ?? 'ไม่พบข้อมูล' }}</p>
                    <p><strong>RTAF-Number:</strong> {{ $inventory->inv_rtaf_serial  ?? 'ไม่พบข้อมูล'}}</p>
                    <p><strong>ชื่อโครงการ:</strong> {{ $inventory->project->project_name  ?? 'ไม่พบข้อมูล'}}</p>
                    <p><strong>วันที่เริ่มใช้:</strong> {{ $inventory->project->project_date  ?? 'ไม่พบข้อมูล'}}</p>
                    <p><strong>นททสส.พอ.(โทร 20008)</strong></p>
                </div>
            </div>
        </div>
    </div>
@endsection









