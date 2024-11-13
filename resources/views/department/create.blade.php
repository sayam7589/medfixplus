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
                        <h1>หน่วยปฏิบัติงาน</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/dashboard">หน้าหลัก</a></li>
                            <li class="breadcrumb-item active">กอง/เเผนก</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                        <form action="{{ route('department.store') }}" method="POST">
                            @csrf
                            <!-- jquery validation -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">เพิ่มกอง/เเผนก</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Gong Dropdown -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="gong">กอง</label>
                                        
                                                <!-- Select dropdown for predefined gong options -->
                                                <select id="gong_select" name="gong" class="form-control" onchange="checkInputType()">
                                                    <option disabled>เลือกจากรายการ</option>
                                                    @foreach($gongs as $gong)
                                                        <option value="{{ $gong->gong }}">{{ $gong->gong }}</option>
                                                    @endforeach
                                                    <option value="0">อื่นๆ</option>
                                                </select>
                                        
                                                <!-- Input field for custom value -->
                                                <input type="text" id="gong_input" class="form-control" name='gong' placeholder="โปรดระบุชื่อกอง" oninput="checkInputType()" style="display:none;">
                                        
                                            </div>
                                        </div>
                                                           
                        
                                        <!-- Panag Input and Submit Button -->
                                        <div class="col-md-6">
                                            <label for="panag" class="mr-2">&nbsp;เเผนก</label>
                                            <div class="form-group d-flex align-items-center">
                                  
                                                <input id="panag" name="panag" type="text" class="form-control mr-2" placeholder="ชื่อเเผนก" required>
                                                <button type="submit" class="btn btn-primary">เพิ่ม</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        </div>                
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">หน่วยปฏิบัติงาน</h3>
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
                                <th>ลำดับ</th>
                                <th>กอง</th>
                                <th>เเผนก</th>
                                <th>เพิ่มเติม</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($departments as $department)
                                <tr>
                                    @if($department->gong != "")
                                        <td>{{ $department->id }}</td>
                                        <td>{{ $department->gong }}</td>
                                        @if($department->panag != "")
                                            <td>{{ $department->panag }}</td>
                                        @else
                                            <td>-</td>
                                        @endif
                                    <td>
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#exampleModal-{{ $department->id }}">
                                            แก้ไข
                                        </button>
                                        <a href="{{ route('department.destroy', $department->id) }}" class="btn btn-danger btn-sm" data-confirm-delete="true">ลบ</a>
                                    @endif
                                        <!-- Modal -->
                                        <form name="f{{ $department->id }}" id="f{{ $department->id }}" action="{{ route('department.update', $department->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal fade" id="exampleModal-{{ $department->id }}" tabindex="-1" role="dialog"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <label for="gong">กอง</label>
                                                            <input type="text" name="gong" id="gong" class="form-control" value="{{ $department->gong }}">
                                                        </div>
                                                        <div class="modal-body">
                                                            <label for="panag">เเผนก</label>
                                                            <input type="text" name="panag" id="panag" class="form-control" value="{{ $department->panag }}">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">ปิด</button>
                                                            <button type="submit" class="btn btn-warning btn-sm">แก้ไข</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
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


<script>
    function checkInputType() {
        var selectField = document.getElementById('gong_select');
        var inputField = document.getElementById('gong_input');

        // If user selects an option from the dropdown, show the input as hidden
        if (selectField.value) {
            inputField.style.display = 'none';
            inputField.disabled = true;
            selectField.disabled = false;
        } 
        if (selectField.value == "0"){
            inputField.style.display = 'block'; // Show input if no selection
            inputField.disabled = false;
        }
    }

    // Initialize the form with input visible and select disabled
    window.onload = checkInputType;
</script>


@endsection
