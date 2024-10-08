@extends('layouts.adminlte')

@section('style')
    <!-- Style (Page) -->
@endsection

@section('title', 'View Project')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>ดูบัญชีสินทรัพย์</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/dashboard">หน้าหลัก</a></li>
                            <li class="breadcrumb-item active">ดูบัญชีสินทรัพย์</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- jquery validation -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">ข้อมูลสินทรัพย์</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="project_id">รหัสโครงการ</label>
                                            <p>{{ $inventory->project_id }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="inv_type">ประเภท</label>
                                            <p>{{ $inventory->inv_type }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="inv_brand">ยี่ห้อ</label>
                                            <p>{{ $inventory->inv_brand }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="inv_model_id">รุ่น</label>
                                            <p>{{ $inventory->inv_model_id }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="inv_detail">รายละเอียด</label>
                                            <p>{{ $inventory->inv_detail }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="inv_rtaf_serial">หมายเลขอ้างอิง</label>
                                            <p>{{ $inventory->inv_rtaf_serial }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="inv_serial_number">หมายเลขซีเรียล</label>
                                            <p>{{ $inventory->inv_serial_number }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="inv_mac_address">MAC Address</label>
                                            <p>{{ $inventory->inv_mac_address }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="inv_cpu">CPU</label>
                                            <p>{{ $inventory->inv_cpu }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="inv_ram">RAM</label>
                                            <p>{{ $inventory->inv_ram }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="inv_ram_speed">ความเร็ว RAM</label>
                                            <p>{{ $inventory->inv_ram_speed }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="inv_storage_type">ประเภทหน่วยความจำ</label>
                                            <p>{{ $inventory->inv_storage_type }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="inv_storage_size">ขนาดหน่วยความจำ</label>
                                            <p>{{ $inventory->inv_storage_size }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="inv_os_type">ระบบปฏิบัติการ</label>
                                            <p>{{ $inventory->inv_os_type }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="inv_os_version">เวอร์ชั่น OS</label>
                                            <p>{{ $inventory->inv_os_version }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="inv_os_copyright">ลิขสิทธิ์ OS</label>
                                            <p>{{ $inventory->inv_os_copyright }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="inv_msoffice_version">เวอร์ชั่น MS Office</label>
                                            <p>{{ $inventory->inv_msoffice_version }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="inv_msoffice_copyright">ลิขสิทธิ์ MS Office</label>
                                            <p>{{ $inventory->inv_msoffice_copyright }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="inv_antivirus">โปรแกรมป้องกันไวรัส</label>
                                            <p>{{ $inventory->inv_antivirus }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="inv_antivirus_copyright">ลิขสิทธิ์โปรแกรมป้องกันไวรัส</label>
                                            <p>{{ $inventory->inv_antivirus_copyright }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="inv_setup_year">ปีที่ติดตั้ง</label>
                                            <p>{{ $inventory->inv_setup_year }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="inv_status">สถานะ</label>
                                            <p>{{ $inventory->inv_status }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="inv_picture">รูปภาพ</label>
                                            <img src="{{ asset('storage/' . $inventory->inv_picture) }}" class="img-fluid" alt="รูปภาพสินทรัพย์">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#qrCodeModal">
                                    QR Code
                                </button>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (left) -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Modal -->
    <div class="modal fade" id="qrCodeModal" tabindex="-1" role="dialog" aria-labelledby="qrCodeModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="qrCodeModalLabel">QR Code</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <div id="qrcode"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="printQRCode()">Print</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        function generateQRCode() {
            const qrcodeContainer = document.getElementById('qrcode');
            qrcodeContainer.innerHTML = '';
            new QRCode(qrcodeContainer, {
                text: "{{ route('inventorys.show', $inventory->id) }}",
                width: 200,
                height: 200,
            });
        }

        function printQRCode() {
            const printWindow = window.open('', '_blank');
            const qrCodeHtml = document.getElementById('qrcode').innerHTML;
            printWindow.document.write('<html><head><title>Print QR Code</title></head><body>' + qrCodeHtml + '</body></html>');
            printWindow.document.close();
            printWindow.print();
        }

        // Generate QR code when the modal is shown
        $('#qrCodeModal').on('show.bs.modal', generateQRCode);
    </script>
@endsection