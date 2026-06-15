@extends('layouts.adminlte')

@section('style')
    <!-- Style (Page) -->
@endsection

@section('title', 'ไม่พบข้อมูล')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>ไม่พบข้อมูล</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">ไม่พบข้อมูล</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="mf-state-page">
            <span class="mf-state-icon"><i class="far fa-folder-open"></i></span>
            <h3>ไม่พบข้อมูลที่ต้องการ</h3>
            <p class="text-muted">หน้านี้ยังไม่มีข้อมูล หรือรายการที่ค้นหาอาจถูกลบไปแล้ว</p>
            <a href="/dashboard" class="btn btn-primary mt-2">
                <i class="fas fa-home mr-1"></i> กลับหน้าหลัก
            </a>
        </div>
    </section>
    <!-- /.content -->
</div>
@endsection


@section('script')
    <!-- Script(Page) -->
@endsection
