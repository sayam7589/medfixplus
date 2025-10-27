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
            <form name="signout" id="signout" method="POST" action="{{ route('logout') }}">
                @csrf
                <label style="padding-right: 10px;">
                    @auth
                        {{ session()->get('user_rank') }}
                        {{ session()->get('user_fname') }}
                        {{ session()->get('user_lname') }}
                    @endauth
                </label>
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                <a href="#" class="btn btn-danger my-2"
                    onclick="document.getElementById('signout').submit()">
                    <i class="nav-icon fas fa-sign-out-alt"></i>
                        Sign Out
                </a>
            </form>
        </div>
    </nav>
    <!-- Automatic element centering -->
    <!-- Main content -->
    <section class="content" style="margin-top: 15px;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card card-info card-outline">
                        <div class="card-body box-profile">
                            @if ($medfix_status > 0)
                                <div class="alert alert-warning alert-dismissible">
                                    <h6><i class='fas fa-tools'></i> อยู่ระหว่างการซ่อมบำรุง !</h6>
                                </div>
                            @endif
                            <div class="text-center">
                                @if ($inv->inv_brand != 7)
                                <img class="profile-user-img img-fluid img-circle"
                                    src="{{ asset('brands/' . $inv->brand->brand_name . '.png') }}"
                                    alt="User profile picture">
                                @else
                                <img class="profile-user-img img-fluid img-circle"
                                    src="{{ asset('brands/ETC.png') }}"
                                    alt="User profile picture">
                                @endif
                            </div>

                            <h3 class="profile-username text-center">{{ $inv->brand->brand_name }}
                                ({{ $inv->type->type_name }})</h3>

                            <p class="text-muted text-center">{{ $inv->inv_model }}</p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>เลขครุภัณฑ์</b> <a class="float-right">{{ $inv->inv_rtaf_serial }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Serial No.</b> <a class="float-right">{{ $inv->inv_serial_number }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>PC Name</b> <a class="float-right">{{ $inv->inv_name }}</a>
                                </li>
                            </ul>
                            @if ($countSixMonth == 0)
                                <button type="button" class="btn btn-primary btn-block" data-toggle="modal"
                                    data-target="#exampleModal2">
                                    <b><i class='fas fa-user-edit'></i> ลงทะเบียนผู้ใช้<br>(เจ้าของเครื่องนี้)</b>
                                </button>
                            @else
                                @if ($medfix_status == 0)
                                    <button type="button" class="btn btn-warning btn-block" data-toggle="modal"
                                        data-target="#exampleModal">
                                        <b><i class='fas fa-tools'></i> แจ้งซ่อม</b>
                                    </button>
                                @else
                                    <button type="button" class="btn btn-warning btn-block" data-toggle="modal"
                                        data-target="#exampleModal" disabled>
                                        <b><i class='fas fa-tools'></i> แจ้งซ่อม</b>
                                    </button>
                                @endif

                            @endif

                            @role('admin')
                            @if ($medfix_status != 0)
                                <button type="button" class="btn btn-danger btn-block" data-toggle="modal"
                                    data-target="#exampleModal3">
                                    <b><i class='fas fa-tools'></i> ตรวจสอบ / ปิดงาน</b>
                                </button>
                            @endif

                            <a href="{{ route('inventorys.edit', $inv->id) }}" target="_blank" class="btn btn-default btn-block">
                                <b><i class='fas fa-edit'></i> แก้ไขข้อมูลเครื่อง</b>
                            </a>
                            @endrole


                            <form name="medfix" id="medfix" action="{{ route('storemedfix', $inv->id) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <b>แจ้งซ่อม Serial No. {{ $inv->inv_serial_number }}</b>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <div class="alert alert-warning" role="alert">
                                                        คิวซ่อมปัจจุบัน <b>{{$qu}} คิว</b>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="medfix_detail"
                                                        class="form-label">อาการเบื้องต้น</label>
                                                    <textarea class="form-control" id="medfix_detail" name="medfix_detail" rows="3" required></textarea>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="medfix_pic" class="form-label">ภาพประกอบ</label>
                                                    <!--<input type="hidden" class="form-control-file" id="inv_id" name="inv_id" required>-->
                                                    <input type="file" class="form-control-file" id="medfix_pic"
                                                        name="medfix_pic" accept="image/*">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="medfix_owner_prefix" class="form-label">ยศ/คำนำหน้า
                                                        (เจ้าของเครื่อง)</label>
                                                    @php
                                                        $rank = trim(session()->get('user_rank'));
                                                    @endphp
                                                    <select class="form-control" id="medfix_owner_prefix" name="medfix_owner_prefix">
                                                        @foreach ($prefix as $pf)
                                                            <option value="{{ $pf->id }}" {{ $rank == $pf->prefix_short ? 'selected' : '' }}>
                                                                {{ $pf->prefix_short }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="medfix_owner_fname" class="form-label">ชื่อ
                                                        (เจ้าของเครื่อง)</label>
                                                    <input type="text" class="form-control"
                                                        id="medfix_owner_fname" name="medfix_owner_fname"
                                                        value="{{ $personal['fname'] }}" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="medfix_owner_lname"
                                                        class="form-label">นามสกุล(เจ้าของเครื่อง)</label>
                                                    <input type="text" class="form-control"
                                                        id="medfix_owner_lname" name="medfix_owner_lname"
                                                        value="{{ $personal['lname'] }}" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="department1" class="form-label">หน่วย/สังกัด</label>
                                                    <input type="text" class="form-control" id="department1" name="department1" placeholder="พิมพ์ชื่อหน่วยของท่าน" autocomplete="off" required>
                                                    <div id="departmentList1"></div>
                                                    <input type="hidden" id="department_id1" name="department_id1" required>
                                                </div>
                                                <hr>
                                                <div class="mb-3">
                                                    <label for="voicename" class="form-label">ผู้แจ้งซ่อม</label>
                                                    <input type="text" class="form-control" id="voicename"
                                                        name="voicename"
                                                        value="{{ session()->get('user_rank') . session()->get('user_fname') . ' ' . session()->get('user_lname') }}"
                                                        disabled>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="medfix_tel" class="form-label">เบอร์ติดต่อกลับ</label>
                                                    <input type="text" class="form-control" id="medfix_tel"
                                                        name="medfix_tel" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary btn-sm"
                                                    data-dismiss="modal">ปิด</button>
                                                <button type="submit" class="btn btn-warning btn-sm"><i
                                                        class='fas fa-tools'></i> แจ้งซ่อม</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            @role('admin')
                            @if ($repair != null)
                                <form name="closejob" id="closejob" action="{{ route('closejob', $repair->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <b>ตรวจสอบ / ปิดงาน Serial No. {{ $inv->inv_serial_number }}</b>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    @if ($repair->medfix_pic != 0)
                                                        <img src="{{ asset('storage/' . $repair->medfix_pic) }}"
                                                            alt="Uploaded Image" style="max-width: 300px;"><br>
                                                    @endif
                                                    <b>วันที่แจ้งซ่อม:</b>
                                                    {{ toThaiDateFormat($repair->medfix_ticket_date) }}<br>
                                                    <b>อาการเบื้องต้น:</b> {{ $repair->medfix_detail }}<br>
                                                    <b>เจ้าของเครื่อง:</b>
                                                    {{ $repair->prefix->prefix_short . $repair->medfix_owner_fname . ' ' . $repair->medfix_owner_lname }}<br>
                                                    <b>ผู้แจ้ง:</b>
                                                    {{ $repair->user->rank . $repair->user->fname . ' ' . $repair->user->lname }}<br>
                                                    <b>หน่วย/สังกัด:</b> {{ $repair->userorg->gong." ".$repair->userorg->panag }}<br>
                                                    <b>เบอร์โทร:</b> {{ $repair->medfix_tel }}<br>
                                                    <hr>
                                                    <div class="mb-3">
                                                        <label for="voicename" class="form-label">ช่างซ่อม</label>
                                                        <input type="hidden" name="inv_id"
                                                            value="{{ $repair->inv_id }}">
                                                        <input type="text" class="form-control" id="voicename"
                                                            name="voicename"
                                                            value="{{ session()->get('user_rank') . session()->get('user_fname') . ' ' . session()->get('user_lname') }}"
                                                            disabled>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="issue"
                                                            class="form-label">ผลการตรวจสอบพบว่า</label>
                                                        <select class="form-control" id="issue" name="issue">
                                                            @foreach ($issues as $issue)
                                                                <option value="{{ $issue->id }}">
                                                                    {{ $issue->issue_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="solving" class="form-label">แก้ปัญหาโดย</label>
                                                        <select class="form-control" id="solving" name="solving">
                                                            @foreach ($solvings as $solving)
                                                                <option value="{{ $solving->id }}">
                                                                    {{ $solving->solving_title }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="comment" class="form-label">หมายเหตุ</label>
                                                        <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="status" class="form-label">สถานะ</label>
                                                        <select class="form-control" id="status" name="status">
                                                            <option value="1">ซ่อมสำเร็จ</option>
                                                            <option value="2">ไม่สามารถซ่อมได้ ส่งกลับหน่วย</option>
                                                        </select>
                                                    </div>


                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-sm"
                                                        data-dismiss="modal">ปิด</button>
                                                    <button type="submit" class="btn btn-warning btn-sm"><i
                                                            class='fas fa-tools'></i> ปิดงาน</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            @endif
                            @endrole



                            <form name="medfixregis" id="medfixregis" action="{{ route('regismedfix') }}"
                                method="POST">
                                @csrf
                                <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <b>ลงทะเบียนผู้ใช้ (เจ้าของเครื่องนี้)</b>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="prefix" class="form-label">ยศ/คำนำหน้า</label>
                                                    <input type="hidden" name="inv_id" value="{{ $inv->id }}">
                                                    @php
                                                        $rank = trim(session()->get('user_rank'));
                                                    @endphp
                                                    <select class="form-control" id="prefix" name="prefix">
                                                        @foreach ($prefix as $pf)
                                                            <option value="{{ $pf->id }}" {{ $rank == $pf->prefix_short ? 'selected' : '' }}>
                                                                {{ $pf->prefix_short }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="fname" class="form-label">ชื่อ</label>
                                                    <input type="text" class="form-control"
                                                        id="medfix_owner_fname" name="fname"
                                                        value="{{ session()->get('user_fname') }}" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="lname" class="form-label">นามสกุล</label>
                                                    <input type="text" class="form-control" id="medfix_owner_lname"
                                                        name="lname" value="{{ session()->get('user_lname') }}"
                                                        required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="department2" class="form-label">หน่วย/สังกัด</label>
                                                    <input type="text" class="form-control" id="department2" name="department2" placeholder="พิมพ์ชื่อหน่วยของท่าน" autocomplete="off">
                                                    <div id="departmentList2"></div>
                                                    <input type="hidden" id="department_id2" name="department_id2" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="tel" class="form-label">เบอร์ติดต่อ</label>
                                                    <input type="text" class="form-control" id="medfix_tel"
                                                        name="tel" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary btn-sm"
                                                    data-dismiss="modal">ปิด</button>
                                                <button type="submit" class="btn btn-primary btn-sm"><i
                                                        class='fas fa-user-edit'></i> ลงทะเบียนใช้งาน</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>




                            <div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <b class="text-danger">แจ้งเตือน !!</b>
                                        </div>
                                        <div class="modal-body">

                                            <center><b>ระเบียบกองทัพอากาศ ว่าด้วยการรักษาความปลอดภัยระบบสารสนเทศ พ.ศ.๒๕๖๓</b> <br><b>หมวด ๔</b> การบริหารจัดการทรัพย์สิน<br> <b>ส่วนที่ ๑</b> ความรับผิดชอบต่อทรัพย์สิน</center>
                                            <br>
                                            <p class="text-danger"><b>ข้อ ๒๘</b> ..."ให้มีวิธีการจัดทำและจัดการป้ายชื่อสำหรับ ทรัพย์สิน ซึ่งทรัพย์สินทั้งหมดต้องมีการระบุผู้ถือครองหรือผู้รับผิดชอบ"
                                             <a href="{{ asset('files/rtaf_2563.pdf') }}" target="blank"> อ่านเพิ่มเติม..</a>
                                            </p>
                                            <br>กรุณาลงทะเบียนผู้ถือครองทรัพย์สิน
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary btn-sm"
                                                data-dismiss="modal">ฉันลงทะเบียนแล้ว</button>
                                            <button type="button" class="btn btn-primary btn-sm" id="btexampleModal2" data-toggle="modal" data-target="#exampleModal2" data-dismiss="modal">
                                                <b><i class='fas fa-user-edit'></i> ลงทะเบียนผู้ถือครอง</b>
                                                </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- About Me Box -->
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">รายละเอียด</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <strong><i class="fas fa-book mr-1"></i> โครงการจัดซื้อ/ที่มา</strong>

                            <p class="text-muted">
                                {{ $inv->project->project_name }}
                            </p>

                            <hr>

                            <strong><i class='fas fa-calendar-alt mr-1'></i> เริ่มใช้เมื่อ</strong>

                            <p class="text-muted">{{ toThaiDateFormatWithoutTime($inv->inv_setup_year) }}</p>
                            <hr>

                            <strong><i class="fas fa-map-marker-alt mr-1"></i> เริ่มใช้ครั้งแรกที่</strong>

                            <p class="text-muted">{{ $inv->department->gong.' '.$inv->department->panag.' '.$inv->department->fay.' / ' . $inv->rec_address }}</p>

                            <hr>

                            <strong><i class="fas fa-user-alt mr-1"></i> บุคคลอ้างอิง</strong>

                            <p class="text-muted">
                                @if ($inv->prefix == "" || $inv->rec_fname == "" || $inv->rec_lname == "")
                                    <span class="tag tag-danger">ไม่ระบุ</span>
                                @else
                                    <span class="tag tag-danger">{{ $inv->prefix->prefix_short . $inv->rec_fname . ' ' . $inv->rec_lname }}</span>
                                @endif
                                <br><span class="tag tag-success">โทร:{{ $inv->rec_org_tel }}</span>
                                <br><span class="tag tag-info">มือถือ:{{ $inv->rec_personal_tel }}</span>
                            </p>

                            <hr>


                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#statuss"
                                        data-toggle="tab">ภาพรวม</a></li>
                                <li class="nav-item"><a class="nav-link" href="#timeline"
                                        data-toggle="tab">ประวัติการซ่อม</a></li>
                                <li class="nav-item"><a class="nav-link" href="#settings"
                                        data-toggle="tab">ประวัติผู้ใช้งาน</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="statuss">
                                    <!-- DONUT CHART -->
                                    <div>
                                        <canvas id="repairsDonutChart"></canvas>
                                    </div>
                                    <div style="padding-top: 20px;">

                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">การซ่อม</th>
                                                    <th scope="col" style="width: 40%"></th>
                                                    <th scope="col">จำนวนครั้ง / ร้อยละ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $c = 0;
                                                @endphp
                                                @foreach($repairsByIssue as $repair)
                                                <tr>
                                                    <th scope="row">{{ $c }}</td>
                                                    <td>{{ $repair->issue_name }}</td>
                                                    <td>
                                                        <div class="progress progress-xs">
                                                            <div class="progress-bar progress-bar-danger" style="width: {{ $repair->percentage }}%"></div>
                                                        </div>


                                                    </td>
                                                    <td><span class="badge bg-info">{{ $repair->successful_repairs }}</span> <span class="badge bg-danger">{{ $repair->percentage }}%</span></td>
                                                </tr>
                                                @php
                                                    $c++;
                                                @endphp
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                                <!-- /.tab-pane -->

                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="timeline">
                                    <!-- The timeline -->
                                    <div class="timeline timeline-inverse">
                                        @if ($medfix_status2 == 0)
                                            <div class="time-label">
                                                <span class="bg-danger">
                                                    ไม่มีประวัติการซ่อม
                                                </span>
                                            </div>
                                        @endif
                                        @php
                                            $y = '';
                                            $check = 0;
                                            $countid = 0;
                                        @endphp
                                        @foreach ($medfixs as $medfix)
                                            <!-- timeline time label -->
                                            @php
                                                if ($y != $medfix->year) {
                                                    $y = $medfix->year;
                                                    $check = 0;
                                                }
                                            @endphp
                                            @if ($check == 0)
                                                <div class="time-label">
                                                    <span class="bg-danger">
                                                        {{ $medfix->year + 543 }}
                                                    </span>
                                                </div>
                                                @php
                                                    $check++;
                                                @endphp
                                            @endif
                                            <!-- /.timeline-label -->
                                            <!-- timeline item -->
                                            @if ($medfix->medfix_status != 0)
                                                <div>
                                                    <i class="fas fa-tools bg-warning"></i>

                                                    <div class="timeline-item">
                                                        <span class="time"> <i class="far fa-check-circle"></i> {{ translateStatus($medfix->medfix_status) }}</span>
                                                        <h3 class="timeline-header"><i class="far fa-calendar-alt"></i> {{ toThaiDateFormat($medfix->medfix_ticket_date) }} | <a href="#">{{ $medfix->issue->issue_name }}</a></h3>

                                                        <div class="timeline-body">
                                                            <b>ผู้ใช้:</b>
                                                            {{ $medfix->prefix->prefix_short . $medfix->medfix_owner_fname . ' ' . $medfix->medfix_owner_lname }}<br>
                                                            <b>อาการที่ได้รับแจ้ง:</b> {{ $medfix->medfix_detail }}<br>
                                                            <b>ช่างวินิจฉัย:</b> {{ $medfix->issue->issue_name }}<br>
                                                            <b>แนวทางการซ่อม:</b> {{ $medfix->solving->solving_title }}<br>
                                                            <b>ความเห็นช่าง:</b>
                                                            @if ($medfix->medfix_technician_comment == 0)
                                                                -
                                                            @else
                                                                {{ $medfix->medfix_technician_comment }}
                                                            @endif

                                                            <br>
                                                            <b>ภาพประกอบ:</b>
                                                            @if ($medfix->medfix_pic != 0)
                                                                <a class="btn btn-link btn-xs" data-toggle="collapse"
                                                                    href="#collapseExample{{ $countid }}"
                                                                    role="button" aria-expanded="false"
                                                                    aria-controls="collapseExample{{ $countid }}"><i
                                                                        class="fa fa-eye"></i> ดู</a>
                                                            @else
                                                                -
                                                            @endif
                                                            <div class="collapse"
                                                                id="collapseExample{{ $countid }}">
                                                                @if ($medfix->medfix_pic != 0)
                                                                    <img src="{{ asset('storage/' . $medfix->medfix_pic) }}"
                                                                        alt="Uploaded Image"
                                                                        style="max-width: 300px;">
                                                                @endif

                                                            </div>
                                                            <br>
                                                            <span class="time"><i class="fas fa-user-alt"></i>
                                                                <b>แจ้งซ่อม:</b>
                                                                {{ $medfix->user->rank . $medfix->user->fname . ' ' . $medfix->user->lname }}</span>
                                                            | <span class="time"><i class="fas fa-user-secret"></i>
                                                                <b>ช่างซ่อม:</b>
                                                                {{ $medfix->technician->rank . $medfix->technician->fname . ' ' . $medfix->technician->lname }}</span>
                                                        </div>
                                                        <div class="timeline-footer">
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            <!-- END timeline item -->
                                            @php
                                                $countid++;
                                            @endphp
                                        @endforeach


                                        <div>
                                            <i class="far fa-clock bg-gray"></i>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="settings">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">วันที่</th>
                                                <th scope="col">กิจกรรม</th>
                                                <th scope="col">ผู้ใช้(เจ้าของ)</th>
                                                <th scope="col">หน่วยงาน</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($historys as $history)
                                            <tr>
                                                <th scope="row">{{toThaiDateFormatWithoutTime($history->activity_date)}}</td>
                                                <td>{{$history->activity_type}}</td>
                                                <td>{{$history->prefix.$history->fname.' '.$history->lname}}</td>
                                                <td>{{$history->organize}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
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
    <script src="{{ asset('adminlte/plugins/chart.js/Chart.min.js') }}"></script>
    <script>
        window.addEventListener('load', function() {
          var modal3 = new bootstrap.Modal(document.getElementById('exampleModal3'));
          modal3.show();
        });
    </script>

    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            function setupAutocomplete(inputSelector, listSelector, hiddenInputSelector) {
                $(inputSelector).on('keyup', function() {
                    var query = $(this).val();
                    if (query != '') {
                        $.ajax({
                            url: '//medfix.site/departments/search',
                            method: "GET",
                            data: { query: query },
                            success: function(data) {
                                $(listSelector).fadeIn();
                                var html = '<ul class="dropdown-menu" style="display:block; position:relative">';
                                $.each(data, function(index, department) {
                                    var displayText = department.gong ? department.gong : '';
                                    displayText += department.panag ? ' -> ' + department.panag : '';
                                    displayText += department.fay ? ' -> ' + department.fay : '';

                                    html += '<li data-id="' + department.id + '">' + displayText + '</li>';
                                });
                                html += '</ul>';
                                $(listSelector).html(html);
                            }
                        });
                    } else {
                        $(listSelector).fadeOut();
                    }
                });

                $(document).on('click', listSelector + ' li', function() {
                    var departmentId = $(this).data('id');
                    var departmentText = $(this).text();

                    // ใส่ชื่อหน่วยงานที่เลือกในช่อง input
                    $(inputSelector).val(departmentText);

                    // เก็บค่า department_id ใน hidden input
                    $(hiddenInputSelector).val(departmentId);

                    $(listSelector).fadeOut();
                });
            }

            // เรียกใช้ฟังก์ชันสำหรับ input แต่ละช่อง
            setupAutocomplete('#department1', '#departmentList1', '#department_id1');
            setupAutocomplete('#department2', '#departmentList2', '#department_id2');
        });
    </script>

    <script>
        // เตรียมข้อมูลจาก Laravel ที่ถูกส่งมาในรูป JSON
        var issueNames = @json($repairsByIssue->pluck('issue_name'));
        var percentages = @json($repairsByIssue->pluck('percentage'));

        // สร้าง Donut Chart
        var ctx = document.getElementById('repairsDonutChart').getContext('2d');
        var repairsDonutChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: issueNames, // ชื่อของ issues
                datasets: [{
                    label: 'Percentage of Successful Repairs',
                    data: percentages, // เปอร์เซ็นต์ของการซ่อมสำเร็จ
                    backgroundColor: [
                        '#FF6384', // สีทึบ (ไม่มีความโปร่งใส)
                        '#36A2EB',
                        '#FFCE56',
                        '#4BC0C0',
                        '#9966FF',
                        '#FF9F40'
                    ],
                    borderColor: [
                        '#FF6384', // สีของเส้นขอบเหมือนกัน
                        '#36A2EB',
                        '#FFCE56',
                        '#4BC0C0',
                        '#9966FF',
                        '#FF9F40'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw + '%';
                            }
                        }
                    }
                }
            }
        });
    </script>

</body>

</html>
