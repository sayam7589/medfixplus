@extends('layouts.adminlte')

@section('style')
    <!-- Style (Page) -->
    <!-- DataTables-->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>รายการเเจ้งซ่อม</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">รายการเเจ้งซ่อม</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">


            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">รายการแจ้งซ่อม</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">

                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>รายการ</th>
                                <th>Serial No.</th>
                                <th>ผู้แจ้ง</th>
                                <th>อาการเบื้องต้น</th>
                                <th>สถานะ</th>
                                <th>เพิ่มเติม</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($medfixes as $medfix)
                                <tr>
                                    <td>{{ $medfix->id }}</td>
                                    <td><a href="{{ route('inventorys.edit', $medfix->inv_id) }}">{{ $medfix->inventory->brand->brand_name }} ({{ $medfix->inventory->type->type_name }})<br><span>{{ $medfix->inventory->inv_model }}</span></a></td>
                                    <td>RTAF SN: {{ $medfix->inventory->inv_rtaf_serial }}<br>Product SN: {{ $medfix->inventory->inv_serial_number }}</td>
                                    <td>{{ $medfix->user->rank.$medfix->user->fname.' '.$medfix->user->lname }}<br>{{ $medfix->userorg->gong." ".$medfix->userorg->panag }}</td>
                                    <td style="width: 30%">{{ $medfix->medfix_detail }}</td>
                                    <td>
                                        @if ($medfix->medfix_status == 0)
                                        <span class="badge badge-warning">{{ translateStatus($medfix->medfix_status) }}</span>
                                        @endif
                                        @if ($medfix->medfix_status == 1)
                                        <span class="badge badge-success">{{ translateStatus($medfix->medfix_status) }}</span>
                                        @endif
                                        @if ($medfix->medfix_status == 2)
                                        <span class="badge badge-default">{{ translateStatus($medfix->medfix_status) }}</span>
                                        @endif
                                        @if ($medfix->medfix_status == 3)
                                        <span class="badge badge-default">{{ translateStatus($medfix->medfix_status) }}</span>
                                        @endif
                                    </td>
                                    <td style="width: 8%">
                                        <!-- Button trigger modal -->
                                        <a href="{{ route('inventory', $medfix->inv_id) }}" target="blank" class="btn btn-info btn-sm">ดู</a>
                                        <a href="{{ route('medfix.destroy', $medfix->id) }}" class="btn btn-danger btn-sm" data-confirm-delete="true">ลบ</a>
                                        <!-- Modal -->

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                </div>
                <!-- /.card-footer-->
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>
@endsection


@section('scripts')
    <!-- Script(Page) -->
    <!-- DataTables  & Plugins-->
    <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <!-- Page specific script-->
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "order": [[ 0, "desc" ]],
                "buttons": ["excel", "pdf", "print"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>


@endsection
