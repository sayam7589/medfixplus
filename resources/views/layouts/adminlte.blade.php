<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Blank Page</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    -->
    <link  rel="stylesheet" href="{{ asset('css/kanitfont.css') }}" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    <style>

        body {
            font-family: 'Kanit', sans-serif;
        }

        h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {
            font-family: 'Kanit', sans-serif;
        }

        .navbar, .sidebar, .content-wrapper, .main-footer {
            font-family: 'Kanit', sans-serif;
        }

    </style>
    <!-- Page style -->
    @yield('style')
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">

</head>

<body class="hold-transition sidebar-mini">

    <!-- Alert -->
    @include('sweetalert::alert')
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/dashboard"" class="nav-link">หน้าหลัก</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                <!-- Messages Dropdown Menu -->
                <!-- Notifications Dropdown Menu -->
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="#" class="brand-link">
                <img src="{{ asset('adminlte/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">

                <span class="brand-text font-weight-light">{{env('APP_NAME')}}</span>

            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('adminlte/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                            alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">
                            @auth
                                {{ session()->get('user_rank') }}
                                {{ session()->get('user_fname') }}
                                {{ session()->get('user_lname') }}
                            @endauth
                        </a>
                    </div>
                </div>

                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="{{ route('medfix') }}" class="nav-link">
                            <i class="nav-icon fas fa-wrench"></i>
                            <p>
                            รายการเเจ้งซ่อม
                            @php
                                $count_medfix = DB::table('medfix')->where('medfix_status', '0')->count();
                            @endphp
                            <span class="right badge badge-warning">{{$count_medfix}}</span>
                            </p>
                        </a>
                    </li>

                        <li class="nav-item">
                            <a href="/projects_index" class="nav-link">
                                <i class="nav-icon far fa-clipboard"></i>
                                <p>
                                    โครงการจัดซื้อ
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/projects_index" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>รายการโครงการจัดซื้อ</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/projects_create" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>เพิ่มโครงการจัดซื้อ</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="/projects_index" class="nav-link">
                                <i class="nav-icon fas fa-save"></i>
                                <p>
                                    <i class="right fas fa-angle-left"></i>
                                    บัญชีสินทรัพย์
                                </p>
                            </a>

                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/inventorys_index" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>รายการบัญชีสินทรัพย์</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/inventorys_create" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>เพิ่มบัญชีสินทรัพย์</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="/projects_index" class="nav-link">
                                <i class="nav-icon fas fa-exclamation-triangle"></i>
                                <p>
                                    <i class="right fas fa-angle-left"></i>
                                    การเเก้ไขปัญหา
                                </p>
                            </a>

                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('problem_issue.create') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>ปัญหาที่พบ</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('problem_solving.create') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>วิธีการเเก้ไข</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('department.create') }}" class="nav-link">
                                <i class="nav-icon fas fa-building"></i>
                                <p>
                                    หน่วยปฏิบัติงาน
                                </p>
                            </a>
                        </li>
 
                        <li class="nav-item">
                            <a href="{{ route('inventory_brands.create') }}" class="nav-link">
                                <i class="nav-icon fas fa-box"></i>
                                <p>
                                    ยี่ห้อ
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('users.permissions.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-user-shield"></i>
                                <p>
                                    สิทธิ์การใช้งาน
                                </p>
                            </a>
                        </li>
                        <li class="nav-header">ETC</li>
                        <li class="nav-item">
                            <form name="signout" id="signout" method="POST" action="{{ route('logout') }}">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                <a href="#" class="nav-link"
                                    onclick="document.getElementById('signout').submit()">
                                    <i class="nav-icon fas fa-sign-out-alt"></i>
                                    <p>
                                        ออกจากระบบ
                                    </p>
                                </a>
                            </form>
                        </li>

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>





        <!-- Content Wrapper. Contains page content -->
        @yield('content')
        <!-- /.content-wrapper -->






        <footer class="main-footer">
            <strong>Develop By Medical Rtaf.</strong>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
    <!-- Page Script -->
    <script src="{{ asset('adminlte/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
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
         pdfMake.fonts = {
            THSarabun: {
                normal: 'THSarabun.ttf',
                bold: 'THSarabun Bold.ttf',
                italics: 'THSarabun Italic.ttf',
                bolditalics: 'THSarabun Bold Italic.ttf'
            }
        };
    </script>


    <script>
        $(function () {
          bsCustomFileInput.init();
        });
    </script>



<!--****Page Script**** -->
@yield('scripts')
</body>

</html>
