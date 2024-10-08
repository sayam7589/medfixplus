<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inventory MED RTAF</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

    <style>
        body {
            font-family: 'Kanit', sans-serif;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .h1,
        .h2,
        .h3,
        .h4,
        .h5,
        .h6 {
            font-family: 'Kanit', sans-serif;
        }

        .navbar,
        .sidebar,
        .content-wrapper,
        .main-footer {
            font-family: 'Kanit', sans-serif;
        }
        .dropdown-menu li:hover {
            background-color: #ddd; /* สีของ highlight */
            cursor: pointer; /* ทำให้เมาส์เปลี่ยนเป็น pointer */
        }
    </style>
</head>

<body>
    <!-- Alert -->
    @include('sweetalert::alert')
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">MEDFIX+</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <!--
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Dropdown
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#">Disabled</a>
                </li>
            -->
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <label style="padding-right: 10px;">
                    @auth
                        {{ session()->get('user_rank') }}
                        {{ session()->get('user_fname') }}
                        {{ session()->get('user_lname') }}
                    @endauth
                </label>
                <button class="btn btn-danger my-2" type="submit">SignOut</button>
            </form>
        </div>
    </nav>
    <!-- Automatic element centering -->
    <!-- Main content -->
    <section class="content" style="margin-top: 15px;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">


                    <!-- About Me Box -->
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">ค้นหา</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form id="myForm" action="{{ route('inventory_search_sm') }}" method="POST">
                                @csrf
                                <select class="form-control" id="dep" name="dep" onchange="this.form.submit()">
                                    @foreach ($departments as $dep)
                                        <option value="{{ $dep->gong }}" {{ $gong == $dep->gong ? 'selected' : '' }}>
                                            {{ $dep->gong }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                            <br>
                            <h4>@if ($gong != null){{ $gong }}@endif</h4>
                            @if ($inventory != null)
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ลำดับ</th>
                                        <th>ประเภท</th>
                                        <th>ยี่ห้อ</th>
                                        <th>ชื่อสินทรัพย์</th>
                                        <th>Serial No./เลขครุภัณฑ์</th>
                                        <th>หน่วยผู้ใช้</th>
                                        <th>เพิ่มเติม</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($inventory as $invs)
                                        <tr>
                                            <td>{{ $invs->id }}</td>
                                            <td>{{ $invs->type->type_name }}</td>
                                            <td>{{ $invs->brand->brand_name }}<br>{{ $invs->inv_model }}</td>
                                            <td>{{ $invs->inv_name }}</td>
                                            <td>
                                                Serial No: {{ $invs->inv_serial_number }}<br>
                                                เลขครุภัณฑ์: {{ $invs->inv_rtaf_serial }}
                                            </td>
                                            <td>
                                                @if ($invs->panag == null || $invs->panag == "")
                                                    ไม่ระบุ
                                                @else
                                                    {{ $invs->panag }}
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('inventory', $invs->id) }}" class="btn btn-warning btn-sm"><i class='fas fa-tools'></i> แจ้งซ่อม</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            @endif
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <!-- /.center -->

    <!-- jQuery -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
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
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "pageLength": 50,
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

</body>


</html>
