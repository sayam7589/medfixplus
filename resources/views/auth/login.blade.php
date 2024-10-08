<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MEDFIX</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="adminlte/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="adminlte/dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="adminlte/index2.html">MED<b>FIX+</b></a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                @if (session('error'))
                    <p class="login-box-msg text-danger">{{ session('error') }}</p>
                @else
                    <p class="login-box-msg">กรุณาเข้าสู่ระบบด้วย email ทอ.</p>
                @endif

                <form action="{{ route('login') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" id="username" name="username" class="form-control"
                            placeholder="อีเมล ทอ. ไม่ต้องใส่ @rtaf.mi.th" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" id="password" name="password" class="form-control"
                            placeholder="รหัสผ่าน" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <button type="button" class="btn btn-link" data-toggle="modal" data-target="#exampleModal">
                                อีเมลมีปัญหา/ลืมรหัสผ่าน
                              </button>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <!-- /.social-auth-links -->

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">อีเมลมีปัญหา/ลืมรหัสผ่าน</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <ol type="1">
                                    <li>การแจ้งปัญหา Email
                                        <ul>
                                            <li><a href="https://rtaf.site/annouce/emailhelpdesk.png" target="_blank" rel="noopener noreferrer">https://rtaf.site/annouce/emailhelpdesk.png</a></li>
                                        </ul>
                                    </li>
                                    <li>การตั้งรหัสผ่านใหม่ด้วยตนเอง
                                        <ul>
                                            <li><a href="https://rtaf.site/annouce/reset_pass_email.png" target="_blank" rel="noopener noreferrer">https://rtaf.site/annouce/reset_pass_email.png</a></li>
                                        </ul>
                                    </li>
                                    <li>กรณีสมัคร Email ใหม่ทำได้ดังนี้
                                        <ul>
                                            <li>ประสาน แผนกธุรการหน่วยในการส่งข้อมูลมาที่ HelpDesk</li>
                                            <li>กรณีส่งเอง
                                                <ul>
                                                    <li>กรอกแบบฟอร์ม <a href="https://rtaf.site/annouce/apply_rtafmail.xlsx" target="_blank" rel="noopener noreferrer">https://rtaf.site/annouce/apply_rtafmail.xlsx</a> ให้ครบถ้วน</li>
                                                    <li>ใช้ Email ภายนอกของท่านเช่น Gmail , Hotmail แนบแฟ้มตามข้อ B ส่งมาที่ support@rtaf.mi.th</li>
                                                    <li>รอการตอบกลับจาก support@rtaf.mi.th</li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ol>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="adminlte/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="adminlte/dist/js/adminlte.min.js"></script>
</body>

</html>
