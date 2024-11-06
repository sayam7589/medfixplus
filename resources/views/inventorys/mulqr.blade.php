@extends('layouts.qrcode')

@section('title', 'Multiple QR Codes')

@section('content')
<div class="row justify-content-center  mb-2">
    <div class="card-container col-md-10"">
        @foreach($inventories as $inventory)
        <div class="qr-card">
            <h3 class ="card-title">Medfix+</h3>
            <h3>เเจ้งซ่อม, ลงทะเบียนผู้ใช้งาน</h3>
            <h3>( กรุณา scan qrcode ด่านล่าง )</h3><br>
            <div class="qr-code">
                {!! $qrcodes[$inventory->id] !!}
            </div><br>
            <div class="info">
            
                <p><strong>&nbsp;&nbsp;&nbsp;MAC-Address:</strong> {{ $inventory->inv_mac_address ?? 'ไม่พบข้อมูล' }}</p>
                <p><strong>&nbsp;&nbsp;&nbsp;RTAF-Number:</strong> {{ $inventory->inv_rtaf_serial  ?? 'ไม่พบข้อมูล'}}</p>
                <p><strong>&nbsp;&nbsp;&nbsp;ชื่อโครงการ:</strong> {{ $inventory->project->project_name  ?? 'ไม่พบข้อมูล'}}</p>
                <p><strong>&nbsp;&nbsp;&nbsp;วันที่เริ่มใช้:</strong> {{ $inventory->project->project_date  ?? 'ไม่พบข้อมูล'}}</p>
                <p><strong>&nbsp;&nbsp;&nbsp;นททสส.พอ.(โทร 20008)</strong></p><br>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
