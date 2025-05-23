@extends('layouts.qrcode')

@section('title', 'QR Code')

@section('content')
    <div class="row justify-content-center mb-2">
        <div class="card-container col-md-10">
            <div class="qr-card">
                <div class ="card-title">
                <h4>Medfix+</h4>
                <h4>เเจ้งซ่อม, ลงทะเบียนผู้ใช้งาน</h4>

                </div>
                <div class="qr-code">
                    {!! $qrcode !!}
                </div>
                <div class="info">
                    <p><strong>MAC-Address:</strong> {{ $inventory->inv_mac_address ?? 'ไม่พบข้อมูล' }}</p>
                    <p><strong>RTAF-Number:</strong> {{ $inventory->inv_rtaf_serial  ?? 'ไม่พบข้อมูล'}}</p>
                    <p><strong>โครงการ:</strong> {{ $inventory->project->project_name  ?? 'ไม่พบข้อมูล'}}</p>
                    <p><strong>วันที่เริ่มใช้(ป/ด/ว):</strong> {{ $inventory->inv_setup_year  ?? 'ไม่พบข้อมูล'}}</p>
                    <p><strong>นททสส.พอ.(โทร 20008)</strong></p>
                </div>
            </div>
        </div>
    </div>
@endsection









