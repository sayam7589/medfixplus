@extends('layouts.adminlte')

@section('style')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title></title>
    <style>
    .content {
        display: none;
        }
    </style>

@endsection

@section('title', 'Inventorys')

@section('content')
   <!-- Display flash message -->
<div class="content-wrapper">
 @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
 @endif
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>รายการบัญชีสินทรัพย์</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">รายการบัญชีสินทรัพย์</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="col-12">
            <div class="card-primary">
                <div class="card-header">
                    <h3 class="card-title">ข้อมูลสินทรัพย์</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="select-all"></th> <!-- Header Checkbox -->
                                <th>ลำดับ</th>
                                <th>ประเภทสินทรัพย์</th>
                                <th>ชื่อเครื่อง</th>
                                <th>เลข macaddress</th>
                                <th>เลขครุภัณฑ์</th>
                                <th>หน่วยผู้ใช้</th>
                                <th>สถานะการใช้งาน</th>
                                <th>คำนำหน้า</th>
                                <th>ชื่อ</th>
                                <th>นามสกุล</th>
                                <!--<th>วันที่ติดตั้ง</th> 
                                <th>ประเภท</th>
                                <th>ยี่ห้อ</th>
                                <th>รุ่น</th>
                                <th>รายละเอียดเพิ่มเติม</th>
                                <th>หมายเลขซีเรียล</th>
                                <th>CPU</th>
                                <th>RAM</th>
                                <th>ความเร็ว RAM</th>
                                <th>ประเภทหน่วยความจำ</th>
                                <th>ขนาดหน่วยความจำ</th>
                                <th>ระบบปฏิบัติการ</th>
                                <th>เวอร์ชั่น OS</th>
                                <th>ลิขสิทธิ์ OS</th>
                                <th>เวอร์ชั่น MS Office</th>
                                <th>ลิขสิทธิ์ MS Office</th>
                                <th>โปรแกรมป้องกันไวรัส</th>
                                <th>ลิขสิทธิ์โปรแกรมป้องกันไวรัส</th>
                                <th>เบอร์โทรติดต่อ</th>
                                <th>เบอร์โทรหน่วย</th>
                                <th>เเผนกผู้ใช้</th>
                                <th>ความเร็ว CPU(GHz)</th>-->
                                <th>เพิ่มเติม</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($inventory as $invs)
                                <tr>
                                    <td><input type="checkbox" class="row-select" value="{{ $invs->id }}"></td> <!-- Row Checkbox -->
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $invs->type->type_name }}</td>
                                    <td>{{ $invs->inv_name }}</td>
                                    <td>{{ $invs->inv_mac_address }}</td>
                                    <td>{{ $invs->inv_rtaf_serial }}</td>
                                    <td>{{ $invs->department->gong }}</td>
                                    <td>{{ $invs->inv_status == 1 ? 'ใช้งาน' : 'ไม่ใช้งาน'}}</td>   
                                    <td>{{ optional($invs->prefix)->prefix_short ?? 'ไม่พบข้อมูล' }}</td>
                                    <td>{{ $invs->rec_fname }}</td>
                                    <td>{{ $invs->rec_lname }}</td>    
                                    <!--<td>{{ $invs->inv_setup_year == '0000-00-00' ? 'ไม่ระบุข้อมูล' : $invs->inv_setup_year}}</td>
                                    <td>{{ $invs->project->project_name }}</td>
                                    <td>{{ $invs->brand->brand_name }}</td>
                                    <td>{{ $invs->inv_model }}</td>
                                    <td>{{ $invs->inv_detail }}</td>
                                    <td>{{ $invs->inv_serial_number }}</td>
                                    <td>{{ $invs->inv_cpu}}</td>
                                    <td>{{ $invs->inv_ram }}</td>
                                    <td>{{ $invs->inv_ram_speed }}</td>
                                    <td>{{ $invs->inv_storage_type }}</td>
                                    <td>{{ $invs->inv_storage_size }}</td>
                                    <td>{{ $invs->inv_os_type }}</td>
                                    <td>{{ $invs->inv_os_version }}</td>
                                    <td>{{ $invs->inv_os_copyright == 1 ? 'มี' : 'ไม่มี'}}</td>
                                    <td>{{ $invs->inv_msoffice_version }}</td>
                                    <td>{{ $invs->inv_msoffice_copyright == 1 ? 'มี' : 'ไม่มี'}}</td>
                                    <td>{{ $invs->inv_antivirus }}</td>
                                    <td>{{ $invs->inv_antivirus_copyright == 1 ? 'มี' : 'ไม่มี'}}</td>
                                    <td>{{ $invs->department->panag }}</td>
                                    <td>{{ $invs->rec_personal_tel }}</td>
                                    <td>{{ $invs->rec_org_tel }}</td>
                                    <td>{{ $invs->inv_cpu_clock }}</td>-->
                                    <td>
                                        <a href="{{ route('inventorys.edit', $invs->id) }}" class="btn btn-warning btn-sm">ตรวจสอบ/เเก้ไข</a>
                                        <a href="{{ route('inventorys.qr', $invs->id) }}" class="btn btn-primary btn-sm" target="_blank">QR</a>
                                        <a href="{{ route('inventorys.destroy', $invs->id) }}" class="btn btn-danger btn-sm delete-btn" data-confirm-delete="true">ลบ</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        <button id="sendSelected" class="btn btn-success  mb-3 btn-lg-print"><i class="fas fa-print" target="_blank"></i> print QR</button>
            <!-- /.card -->
        </div>
    </section>
</div>



<!-- Delete Confirmation Modal -->
@endsection

@section('footer')
    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            <b>Version</b> 3.2.0
        </div>
        <strong>&copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
@endsection



@section('scripts')
<script>
   $(function () {
    var selectedRows = {};

    // Select/Deselect all checkboxes
    $('#select-all').on('click', function() {
        var isChecked = this.checked;
        $('.row-select').each(function() {
            this.checked = isChecked;
            selectedRows[$(this).val()] = isChecked;
        });
    });

    // Handle checkbox state change
    $('#example1').on('change', '.row-select', function() {
        selectedRows[$(this).val()] = this.checked;
    });

    var table = $('#example1').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "pageLength": 10,
        "ordering": false,
        "info": false,
        "autoWidth": false,
        "responsive": true,
        "processing": true,
        "stateSave": true,
        "deferRender":true,
        "deferLoading": 0, 
    
        "columns": [
            { "visible": true },  // Checkbox column
            { "visible": true },  // ID
            { "visible": true },  // Type
            { "visible": true },  // Asset Name
            { "visible": true },  // Mac address
            { "visible": true },  // Rtaf serial
            { "visible": true },  // User Department
            { "visible": true },  // Status
            { "visible": false },  // User User_prefix
            { "visible": false },  // User User_name
            { "visible": false },  // User User_lastname
            // add what u want to hide
            // { "visible": false }, // Hidden columns in web page

            
            // Add more as needed
            { "visible": true }   // Action buttons
        ],
    "buttons": [
    {
        extend: 'excel',
        text: 'Export to Excel',
        exportOptions: {
            columns: ':not(:first-child):not(:last-child)' // Exclude the last column (actions)
        }
    },
    {
        extend: 'pdfHtml5',
        text: 'Export to PDF',
        orientation: 'landscape',
        pageSize: 'A4',
        title: '',
        filename: 'รายงานบัญชีสินทรัพย์', // ✅ ชื่อไฟล์ PDF ที่จะดาวน์โหลด
        exportOptions: {
            columns: ':not(:first-child):not(:last-child)'
        },
        customize: function (doc) {
    doc.defaultStyle = {
        font: 'THSarabunNew',
        fontSize: 12,
        alignment: 'center'
    };

    doc.content.unshift({
        text: 'รายงานบัญชีสินทรัพย์',
        fontSize: 24,
        bold: true,
        alignment: 'center',
        margin: [0, 0, 0, 20]
    });



    // ✅ แบ่ง page break ทุก 10 แถว
    var tableBody = doc.content[1].table.body;
    var header = tableBody[0]; // row header
    var newBody = [header]; // เริ่มด้วย header

    for (var i = 1; i < tableBody.length; i++) {
        newBody.push(tableBody[i]);

        if (i % 10 === 0) {
            // ใส่ pageBreak หลังจากทุกๆ 10 แถว
            newBody.push([{ text: '', pageBreak: 'after', colSpan: header.length }].concat(Array(header.length - 1).fill({})));
        }
    }

    doc.content[1].table.body = newBody;

    // ✅ เพิ่มลายเซ็นท้ายเอกสาร
    doc.content.push({
        margin: [0, 50, 0, 0],
        fontSize: 13,
        font: 'THSarabunNew',
        alignment: 'center',
        table: {
            widths: ['*'],
            body: [[{
                text: `(ลงชื่อ) .......................................... (เจ้าหน้าที่ตรวจสอบ)\n` +
                      `ตำแหน่ง ........................................\n` +
                      `.......... / .......... / ..........`,
                alignment: 'center',
                fontSize: 14,
                lineHeight: 1.3,
                border: [false, false, false, false]
            }]]
        },
        layout: 'noBorders'
    });
}
    }
    ],
    
        "initComplete": function() {    
            $('.content').show();      // Show the content after DataTable is fully loaded
        }
    });

    table.buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

    $('#sendSelected').on('click', function() {
        var selected = [];
        $('.row-select:checked').each(function() {
            selected.push($(this).val());
        });
    
        if (selected.length > 0) {
            // Send selected IDs to a route via AJAX
            $.ajax({
                url: '//medfix.site/inventorys/mulqr',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    ids: selected
                },
                success: function(response) {
                    if (response.redirect_url) {
                        window.location.href = response.redirect_url;
                    } else {
                        alert('An unexpected error occurred.');
                    }
                },
                error: function(xhr) {
                    alert('Error occurred: ' + xhr.status + ' ' + xhr.statusText + '\nResponse: ' + xhr.responseText + selected);
                }
            });
        } else {
            alert('กรุณาเลือกข้อมูลที่ต้องการ'); // "Please select data" in Thai
        }
    });

    table.on('draw', function () {
    // Clear checkboxes when the table is redrawn
    $('input[type="checkbox"]').prop('checked', false);
    });

    table.on('page.dt', function () {
    // Clear checkboxes when the page is changed
    $('input[type="checkbox"]').prop('checked', false);
    });

    table.on('order.dt', function () {
    // Clear checkboxes when the table is sorted
    $('input[type="checkbox"]').prop('checked', false);
    });

    table.on('search.dt', function () {
    // Clear checkboxes when a search/filter is applied
    $('input[type="checkbox"]').prop('checked', false);
    });
    

    // Handle send selected button click
});

</script>


@endsection
