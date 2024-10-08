@extends('layouts.adminlte')

@section('style')
    <!-- Style (Page) -->
@endsection

@section('title', 'Create Project')

@section('content')
    <form action="{{ route('projects.store') }}" method="POST">
        @csrf
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>เพิ่มโครงการจัดซื้อ</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="/dashboard">หน้าหลัก</a></li>
                                <li class="breadcrumb-item active">เพิ่มโครงการจัดซื้อ</li>
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
                                    <h3 class="card-title">บันทึกข้อมูล</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="project_name">ชื่อโครงการ</label>
                                            <input type="text" name="project_name" class="form-control" id="project_name" placeholder="" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="project_detail">รายละเอียดโครงการ</label>
                                            <textarea name="project_detail" class="form-control" id="project_detail" placeholder=""></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="project_company">บริษัทห้างร้านผู้จำหน่าย</label>
                                            <input type="text" name="project_company" class="form-control" id="project_company" placeholder="" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="project_company_contact">เบอร์โทรติดต่อ</label>
                                            <input type="text" name="project_company_contact" class="form-control" id="project_company_contact" placeholder="" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="project_file">อัปโหลดไฟล์</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="project_file" name="project_file">
                                                    <label class="custom-file-label" for="project_file">เลือกไฟล์</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="project_date">วันอนุมัติโครงการ</label>
                                            <input type="date" name="project_date" class="form-control" id="project_date" placeholder="" required>
                                        </div>

                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Save</button>
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
    </form>
@endsection

@section('scripts')
@endsection
