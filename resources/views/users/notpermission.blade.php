@extends('layouts.adminlte')

@section('style')
    <!-- Style (Page) -->
@endsection

@section('title', 'ไม่มีสิทธิ์เข้าถึง')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>ไม่มีสิทธิ์เข้าถึง</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">หน้าหลัก</a></li>
                            <li class="breadcrumb-item active">ไม่มีสิทธิ์เข้าถึง</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="mf-state-page">
                <span class="mf-state-icon"><i class="fas fa-lock"></i></span>
                <h3>คุณไม่มีสิทธิ์ใช้งานหน้านี้</h3>
                <p class="text-muted">
                    หากต้องการใช้งานส่วนนี้ กรุณาติดต่อผู้ดูแลระบบ<br>
                    <a href="mailto:sayam_pai@rtaf.mi.th">sayam_pai@rtaf.mi.th</a>
                </p>
                <a href="{{ route('dashboard') }}" class="btn btn-primary mt-2">
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
