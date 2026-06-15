<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@hasSection('title')@yield('title') — MEDFIX+ @else MEDFIX+ @endif</title>

    <!-- Google Font: Kanit (เฉพาะ weight ที่ใช้จริง — ลดขนาดโหลดฟอนต์) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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
    <!-- MEDFIX+ Modern Theme (ต้องโหลดหลัง adminlte.min.css) -->
    <link rel="stylesheet" href="{{ asset('css/medfix-theme.css') }}">

    <!-- Page style -->
    @yield('style')

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
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button" aria-label="เปิด/ปิดเมนู"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/dashboard" class="nav-link">หน้าหลัก</a>
                </li>
            </ul>

            <!-- Right navbar links: ผู้ใช้ + ออกจากระบบ (แพตเทิร์นที่ผู้ใช้คุ้นเคย) -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-label="เมนูผู้ใช้">
                        <i class="fas fa-user-circle mr-1"></i>
                        <span class="d-none d-md-inline">
                            @auth
                                {{ session()->get('user_rank') }}
                                {{ session()->get('user_fname') }}
                            @endauth
                        </span>
                        <i class="fas fa-angle-down ml-1 text-muted"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <span class="dropdown-item-text text-muted small">
                            @auth
                                {{ session()->get('user_rank') }}
                                {{ session()->get('user_fname') }}
                                {{ session()->get('user_lname') }}
                            @endauth
                        </span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item text-danger"
                            onclick="document.getElementById('signout').submit(); return false;">
                            <i class="fas fa-sign-out-alt mr-2"></i>ออกจากระบบ
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->


        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="/dashboard" class="brand-link d-flex align-items-center">
                <span class="brand-icon"><i class="fas fa-briefcase-medical"></i></span>
                <span class="brand-text font-weight-light">MED<b>FIX+</b></span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
                    <div class="image d-flex align-items-center">
                        <span class="user-avatar"><i class="fas fa-user-md"></i></span>
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
                        <input class="form-control form-control-sidebar" type="search" placeholder="ค้นหาเมนู"
                            aria-label="ค้นหาเมนู">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar" aria-label="ค้นหา">
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
                                รายการแจ้งซ่อม
                                @php
                                    $count_medfix = DB::table('medfix')->where('medfix_status', '0')->count();
                                @endphp
                                <span class="right badge badge-warning">{{$count_medfix}}</span>
                                </p>
                            </a>
                        </li>


                        <li class="nav-item">
                            {{-- หัวข้อที่มีเมนูย่อยเป็นปุ่ม toggle ไม่ใช่ลิงก์ปลายทาง (เดิมชี้ /projects_index ผิดหมวด) --}}
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-save"></i>
                                <p>
                                    บัญชีสินทรัพย์
                                    <i class="right fas fa-angle-left"></i>
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
                            <a href="#" class="nav-link">
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
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-exclamation-triangle"></i>
                                <p>
                                    การแก้ไขปัญหา
                                    <i class="right fas fa-angle-left"></i>
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
                                        <p>วิธีการแก้ไข</p>
                                    </a>
                                </li>
                            </ul>
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
                            <a href="{{ route('department.create') }}" class="nav-link">
                                <i class="nav-icon fas fa-building"></i>
                                <p>
                                    หน่วยปฏิบัติงาน
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
                        <li class="nav-header">อื่น ๆ</li>
                        <li class="nav-item">
                            {{-- ฟอร์ม logout ใช้ร่วมกับ dropdown ใน navbar ด้านบน --}}
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
            <strong>Developed by Medical RTAF</strong>
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
    <script src="{{ asset('adminlte/plugins/pdfmake/vfs_fonts_thai.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

    <script>
        $(function () {
          bsCustomFileInput.init();
        });

        // ค่า default กลางของ DataTables (ทุกหน้า): ข้อความภาษาไทย
        // ตั้งก่อนสคริปต์ของแต่ละหน้า จึงมีผลกับทุกตารางโดยไม่ต้องแก้รายหน้า
        if ($.fn.dataTable) {
            $.extend(true, $.fn.dataTable.defaults, {
                language: {
                    search: 'ค้นหา:',
                    lengthMenu: 'แสดง _MENU_ รายการ',
                    info: 'แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ',
                    infoEmpty: 'ไม่มีข้อมูล',
                    infoFiltered: '(กรองจากทั้งหมด _MAX_ รายการ)',
                    zeroRecords: 'ไม่พบข้อมูลที่ค้นหา',
                    emptyTable: 'ไม่มีข้อมูลในตาราง',
                    processing: 'กำลังโหลด...',
                    paginate: { first: 'หน้าแรก', previous: 'ก่อนหน้า', next: 'ถัดไป', last: 'หน้าสุดท้าย' }
                }
            });
        }
    </script>

    <!-- ===== Smooth Navigation (ไม่เปลี่ยน behavior — ลิงก์ยังทำงานแบบเดิม) ===== -->
    <div id="mf-pagebar"></div>
    <script>
    (function () {
        var bar = document.getElementById('mf-pagebar');

        // ลิงก์ที่ถือว่าเป็นการ "เปลี่ยนหน้า" จริง
        function isNavLink(a) {
            if (!a || !a.href) return false;
            var href = a.getAttribute('href') || '';
            if (href === '' || href.charAt(0) === '#' || href.indexOf('javascript:') === 0) return false;
            if (a.target && a.target !== '_self') return false;
            if (a.hasAttribute('download')) return false;
            // ปุ่ม widget ของ Bootstrap/AdminLTE ไม่ใช่การเปลี่ยนหน้า
            if (a.hasAttribute('data-toggle') || a.hasAttribute('data-widget') ||
                a.hasAttribute('data-dismiss') || a.hasAttribute('data-card-widget') ||
                a.hasAttribute('data-slide')) return false;
            // ปุ่มลบที่ SweetAlert ดักไว้ (ไม่ใช่การเปลี่ยนหน้าทันที และห้าม prefetch URL ลบข้อมูล)
            if (a.hasAttribute('data-confirm-delete')) return false;
            if (/destroy|_destroy/.test(a.pathname)) return false;
            return a.origin === location.origin;
        }

        var barTimer;
        function startBar() {
            bar.classList.remove('loading');
            void bar.offsetWidth; // restart transition
            bar.classList.add('loading');
            // กันแถบค้าง กรณีการนำทางถูกยกเลิก (เช่น กดยกเลิกใน SweetAlert)
            clearTimeout(barTimer);
            barTimer = setTimeout(function () { bar.classList.remove('loading'); }, 8000);
        }

        // 1) แถบโหลดตอนคลิกลิงก์ / submit ฟอร์ม
        document.addEventListener('click', function (e) {
            if (e.defaultPrevented || e.button !== 0 || e.ctrlKey || e.metaKey || e.shiftKey) return;
            var a = e.target.closest('a');
            if (isNavLink(a)) startBar();
        }, true);
        document.addEventListener('submit', function () { startBar(); }, true);
        window.addEventListener('pageshow', function () { bar.classList.remove('loading'); });

        // 2) Prefetch หน้าไว้ล่วงหน้าตอน hover (เปิดเร็วขึ้นเพราะ browser cache ไว้แล้ว)
        var prefetched = {};
        document.addEventListener('mouseover', function (e) {
            var a = e.target.closest('a');
            if (!isNavLink(a)) return;
            var url = a.href.split('#')[0];
            if (prefetched[url] || url === location.href.split('#')[0]) return;
            prefetched[url] = true;
            var l = document.createElement('link');
            l.rel = 'prefetch';
            l.href = url;
            document.head.appendChild(l);
        }, { passive: true });

        // Fallback: ถ้าหน้าไหนมี #example1/#example2 แต่ไม่ได้ init DataTables
        // ให้แสดงตารางตามปกติหลังโหลดเสร็จ (กันตารางหายถาวร)
        window.addEventListener('load', function () {
            setTimeout(function () {
                document.querySelectorAll('#example1, #example2').forEach(function (t) {
                    t.classList.add('mf-dt-show');
                });
            }, 300);
        });

        // 3) จำตำแหน่ง scroll ของ sidebar ระหว่างเปลี่ยนหน้า
        var sb = document.querySelector('.main-sidebar .sidebar');
        if (sb) {
            var saved = sessionStorage.getItem('mf-sidebar-scroll');
            if (saved) sb.scrollTop = parseInt(saved, 10);
            window.addEventListener('beforeunload', function () {
                sessionStorage.setItem('mf-sidebar-scroll', sb.scrollTop);
            });
        }

        // 4) ไฮไลต์เมนูของหน้าปัจจุบัน + กางเมนูย่อยค้างไว้ (ลดความรู้สึก "เริ่มใหม่" ทุกหน้า)
        var path = location.pathname.replace(/\/+$/, '') || '/';
        document.querySelectorAll('.nav-sidebar a.nav-link[href]').forEach(function (a) {
            var href = a.getAttribute('href');
            if (!href || href.charAt(0) === '#') return;
            // ข้ามเมนูหัวข้อที่มีเมนูย่อย (เป็นปุ่ม toggle ไม่ใช่หน้าปลายทาง)
            // เพราะ href ของหัวข้อหลายอันชี้ /projects_index ซ้ำกัน ทำให้ไฮไลต์ติดทั้งแถบ
            var li = a.closest('.nav-item');
            if (li && li.querySelector(':scope > .nav-treeview')) return;
            var linkPath = new URL(a.href).pathname.replace(/\/+$/, '') || '/';
            if (linkPath === path) {
                a.classList.add('mf-active');
                var tree = a.closest('.nav-treeview');
                if (tree) {
                    var parent = tree.closest('.nav-item');
                    if (parent) parent.classList.add('menu-open');
                }
            }
        });
    })();
    </script>



<!--****Page Script**** -->
@yield('scripts')
</body>

</html>
