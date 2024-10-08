@extends('layouts.adminlte')

@section('style')
    <!-- Style (Page) -->
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>404 Error Page</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">404 Error Page</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="error-page">
                <h2 class="headline text-warning"> 404</h2>

                <div class="error-content">
                    <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! You not have permission on this page นะจ๊ะ.</h3>

                    <p>ถ้าต้องการใช้งานในส่วนนี้กรุณาติดต่อ ผู้ดูแลระบบ sayam_pai@rtaf.mi.th</p>

                </div>
                <!-- /.error-content -->
            </div>
            <!-- /.error-page -->

        </section>
        <!-- /.content -->
    </div>
@endsection


@section('script')
    <!-- Script(Page) -->
@endsection
