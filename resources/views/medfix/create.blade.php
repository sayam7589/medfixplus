@extends('layouts.adminlte')

@section('title', 'แจ้งซ่อม')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>แจ้งซ่อม</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">แจ้งซ่อม</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-tools mr-2 text-muted"></i>สร้างรายการแจ้งซ่อม</h3>
                </div>
                {{-- ฟอร์มเดิม: POST ไป medfix.store (หน้านี้เป็น stub — แจ้งซ่อมหลักทำผ่านหน้าสแกน QR) --}}
                <form action="{{ route('medfix.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <p class="text-muted mb-0">
                            <i class="fas fa-info-circle mr-1"></i>
                            การแจ้งซ่อมโดยทั่วไปทำได้โดยสแกน QR Code ที่ติดอยู่กับเครื่อง
                        </p>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
@endsection
