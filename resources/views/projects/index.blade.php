@extends('layouts.adminlte')

@section('style')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <style>
        .content {
            display: none;
            }
    </style>
    @endsection

@section('title', 'Projects')

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
                    <h1>รายการโครงการจัดซื้อ</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">รายการโครงการจัดซื้อ</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="col-12">
            <div class="card-primary">
                <div class="card-header">
                    <h3 class="card-title">ข้อมูลโครงการจัดซื้อ</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>ชื่อโครงการ</th>
                                <th>บริษัทห้างร้านผู้จำหน่าย</th>
                                <th>วันอนุมัติโครงการ</th>
                                <th>รายละเอียด</th>
                                <th>เบอร์โทรติดต่อ</th>
                                <th>เพิ่มเติม</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($projects as $project)
                                <tr>
                                    <td>{{ $project->id }}</td>
                                    <td>{{ $project->project_name }}</td>
                                    <td>{{ optional($project)->project_company ?? 'ไม่พบข้อมูล' }}</td>
                                    <td>{{ optional($project)->project_date ?? 'ไม่พบข้อมูล' }}</td>
                                    <td>{{ optional($project)->project_detail ?? 'ไม่พบข้อมูล' }}</td>
                                    <td>{{ optional($project)->project_company_contact ?? 'ไม่พบข้อมูล' }}</td>
                                    <td>
                                        <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-warning btn-sm">ตรวจสอบ/เเก้ไข</a>
                                        <a href="{{ route('projects.delete', $project->id) }}" class="btn btn-danger btn-sm delete-btn">ลบ</a>
 
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
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
        // DataTable initialization
        $(function () {
            var table = $('#example1').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
               "columns": [
                { "visible": true },  // Checkbox column
                { "visible": true },  // ID
                { "visible": true },  // Asset Name
                { "visible": true },  // MAC Address
                { "visible": false }, // Hidden columns in web page
                { "visible": false }, // Hidden columns in web page
                // Add more as needed
                { "visible": true }   // Action buttons
            ],

            "buttons": [
            {
                extend: 'excel',
                text: 'Export to Excel',
                exportOptions: {
                columns: ':not(:last-child)' // Exclude the last column
                }
            }
        ],

        "initComplete": function() {    
            $('.content').show();      // Show the content after DataTable is fully loaded
        }
            
        });
            table.buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
