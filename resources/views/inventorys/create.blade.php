@extends('layouts.adminlte')

@section('style')
    <!-- Style (Page) -->
@endsection

@section('title', 'Create Project')

@section('content')
    <form id="myForm" action="{{ route('inventorys.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>เพิ่มบัญชีสินทรัพย์</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="/dashboard">หน้าหลัก</a></li>
                                <li class="breadcrumb-item active">เพิ่มบัญชีสินทรัพย์</li>
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
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="inv_name">ชื่อเครื่อง</label>
                                                <input type="text" name="inv_name" class="form-control" id="inv_name" value=""  placeholder="ชื่อเครื่อง" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="project_id">ชื่อโครงการ</label>
                                                <select type="hidden" name="project_id" class="form-control" id="project_id" required>
                                                    <option value="">-- เลือกชื่อโครงการ --</option>
                                                    @foreach($inventory as $inv)
                                                    <option value="{{ $inv->id }}" {{ isset($formData['project_id']) && $formData['project_id'] == $inv->id ? 'selected' : '' }}>
                                                        {{ $inv->project_name }}
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="inv_type">ประเภทสินทรัพย์</label>
                                                <select name="inv_type" class="form-control" id="inv_type" required>
                                                    <option value="" >-- เลือกประเภทสินทรัพย์ --</option>
                                                    @foreach($types as $type)
                                                    <option value="{{ $type->id }}" {{ isset($formData['inv_type']) && $formData['inv_type'] == $type->id ? 'selected' : '' }}>
                                                        {{ $type->type_name }}
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="inv_brand">ยี่ห้อ</label>
                                                <select name="inv_brand" class="form-control" id="inv_brand" required>
                                                    <option value="">-- เลือกยี่ห้อ --</option>
                                                    @foreach($brands as $brand)
                                                    <option value="{{ $brand->id }}" {{ isset($formData['inv_brand']) && $formData['inv_brand'] == $brand->id ? 'selected' : '' }}>
                                                        {{ $brand->brand_name }}
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="inv_model">รุ่น</label>
                                                <input type="text" name="inv_model" class="form-control" id="inv_model" placeholder="รุ่น" required value="{{ isset($formData['inv_model']) ? $formData['inv_model'] : '' }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="inv_detail">รายละเอียดเพิ่มเติม</label>
                                                <textarea name="inv_detail" class="form-control" id="inv_detail" placeholder="รายละเอียด" required>{{ isset($formData['inv_detail']) ? $formData['inv_detail'] : '' }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="inv_rtaf_serial">หมายเลขคุรุภัณฑ์</label>
                                                <input type="text" name="inv_rtaf_serial" class="form-control" id="inv_rtaf_serial" placeholder="หมายเลขอ้างอิง" required value="{{ isset($formData['inv_rtaf_serial']) ? $formData['inv_rtaf_serial'] : '' }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="inv_serial_number">หมายเลขซีเรียล</label>
                                                <input type="text" name="inv_serial_number" class="form-control" id="inv_serial_number" placeholder="หมายเลขซีเรียล" required value="{{ isset($formData['inv_serial_number']) ? $formData['inv_serial_number'] : '' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="inv_mac_address">MAC Address</label>
                                                <input type="text" name="inv_mac_address" class="form-control" id="inv_mac_address" placeholder="MAC Address" required value="{{ isset($formData['inv_mac_address']) ? $formData['inv_mac_address'] : '' }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="inv_cpu">CPU</label>
                                                <select name="inv_cpu" class="form-control" id="inv_cpu" required>
                                                    <option value="">เลือก CPU</option>
                                                    <option value="Intel Celeron" {{ isset($formData['inv_cpu']) && $formData['inv_cpu'] == 'Intel Celeron' ? 'selected' : '' }}>Intel Celeron</option>
                                                    <option value="Intel Core 2" {{ isset($formData['inv_cpu']) && $formData['inv_cpu'] == 'Intel Core 2' ? 'selected' : '' }}>Intel Core 2</option>
                                                    <option value="Intel Core i3" {{ isset($formData['inv_cpu']) && $formData['inv_cpu'] == 'Intel Core i3' ? 'selected' : '' }}>Intel Core i3</option>
                                                    <option value="Intel Core i5" {{ isset($formData['inv_cpu']) && $formData['inv_cpu'] == 'Intel Core i5' ? 'selected' : '' }}>Intel Core i5</option>
                                                    <option value="Intel Core i7" {{ isset($formData['inv_cpu']) && $formData['inv_cpu'] == 'Intel Core i7' ? 'selected' : '' }}>Intel Core i7</option>
                                                    <option value="Intel Core i9" {{ isset($formData['inv_cpu']) && $formData['inv_cpu'] == 'Intel Core i9' ? 'selected' : '' }}>Intel Core i9</option>
                                                    <option value="Intel Core2 Duo" {{ isset($formData['inv_cpu']) && $formData['inv_cpu'] == 'Intel Core2 Duo' ? 'selected' : '' }}>Intel Core2 Duo</option>
                                                    <option value="Intel Core Quad" {{ isset($formData['inv_cpu']) && $formData['inv_cpu'] == 'Intel Core Quad' ? 'selected' : '' }}>Intel Core Quad</option>
                                                    <option value="Intel Pentium D" {{ isset($formData['inv_cpu']) && $formData['inv_cpu'] == 'Intel Pentium D' ? 'selected' : '' }}>Intel Pentium D</option>
                                                    <option value="Intel Pentium G" {{ isset($formData['inv_cpu']) && $formData['inv_cpu'] == 'Intel Pentium G' ? 'selected' : '' }}>Intel Pentium G</option>
                                                    <option value="Intel Pentium J" {{ isset($formData['inv_cpu']) && $formData['inv_cpu'] == 'Intel Pentium J' ? 'selected' : '' }}>Intel Pentium J</option>
                                                    <option value="Intel Pentium R" {{ isset($formData['inv_cpu']) && $formData['inv_cpu'] == 'Intel Pentium R' ? 'selected' : '' }}>Intel Pentium R</option>
                                                    <option value="AMD Atlon" {{ isset($formData['inv_cpu']) && $formData['inv_cpu'] == 'AMD Atlon' ? 'selected' : '' }}>AMD Atlon</option>
                                                    <option value="AMD E2" {{ isset($formData['inv_cpu']) && $formData['inv_cpu'] == 'AMD E2' ? 'selected' : '' }}>AMD E2</option>
                                                    <option value="AMD Ryzen 3" {{ isset($formData['inv_cpu']) && $formData['inv_cpu'] == 'AMD Ryzen 3' ? 'selected' : '' }}>AMD Ryzen 3</option>
                                                    <option value="AMD Ryzen 5" {{ isset($formData['inv_cpu']) && $formData['inv_cpu'] == 'AMD Ryzen 5' ? 'selected' : '' }}>AMD Ryzen 5</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!--ทำต่ออออออออ-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="inv_ram">RAM</label>
                                              <select name="inv_ram" class="form-control" id="inv_ram" required>
                                                    <option value="">ประเภทเเรม</option>
                                                        <option value="DDR2" {{ isset($formData['inv_ram']) && $formData['inv_ram'] == 'DDR2' ? 'selected' : '' }}>DDR2</option>
                                                        <option value="DDR3" {{ isset($formData['inv_ram']) && $formData['inv_ram'] == 'DDR3' ? 'selected' : '' }}>DDR3</option>
                                                        <option value="DDR4" {{ isset($formData['inv_ram']) && $formData['inv_ram'] == 'DDR4' ? 'selected' : '' }}>DDR4</option>
                                                        <option value="DDR5" {{ isset($formData['inv_ram']) && $formData['inv_ram'] == 'DDR5' ? 'selected' : '' }}>DDR5</option>
                                                        <option value="DDR6" {{ isset($formData['inv_ram']) && $formData['inv_ram'] == 'DDR6' ? 'selected' : '' }}>DDR6</option>
                                                        <option value="DDR7" {{ isset($formData['inv_ram']) && $formData['inv_ram'] == 'DDR7' ? 'selected' : '' }}>DDR7</option>
                                                        <option value="บริษัท" {{ isset($formData['inv_ram']) && $formData['inv_ram'] == 'บริษัท' ? 'selected' : '' }}>บริษัท</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="inv_ram_speed">ความเร็ว RAM</label>
                                               <select name="inv_ram_speed" class="form-control" id="inv_ram_speed" required>
                                                    <option value="">ความเร็ว RAM</option>
                                                    <option value="1" {{ isset($formData['inv_ram_speed']) && $formData['inv_ram_speed'] == '1' ? 'selected' : '' }}>1</option>
                                                    <option value="2" {{ isset($formData['inv_ram_speed']) && $formData['inv_ram_speed'] == '2' ? 'selected' : '' }}>2</option>
                                                    <option value="3" {{ isset($formData['inv_ram_speed']) && $formData['inv_ram_speed'] == '3' ? 'selected' : '' }}>3</option>
                                                    <option value="4" {{ isset($formData['inv_ram_speed']) && $formData['inv_ram_speed'] == '4' ? 'selected' : '' }}>4</option>
                                                    <option value="5" {{ isset($formData['inv_ram_speed']) && $formData['inv_ram_speed'] == '5' ? 'selected' : '' }}>5</option>
                                                    <option value="8" {{ isset($formData['inv_ram_speed']) && $formData['inv_ram_speed'] == '8' ? 'selected' : '' }}>8</option>
                                                    <option value="9" {{ isset($formData['inv_ram_speed']) && $formData['inv_ram_speed'] == '9' ? 'selected' : '' }}>9</option>
                                                    <option value="10" {{ isset($formData['inv_ram_speed']) && $formData['inv_ram_speed'] == '10' ? 'selected' : '' }}>10</option>
                                                    <option value="11" {{ isset($formData['inv_ram_speed']) && $formData['inv_ram_speed'] == '11' ? 'selected' : '' }}>11</option>
                                                    <option value="12" {{ isset($formData['inv_ram_speed']) && $formData['inv_ram_speed'] == '12' ? 'selected' : '' }}>12</option>
                                                    <option value="16" {{ isset($formData['inv_ram_speed']) && $formData['inv_ram_speed'] == '16' ? 'selected' : '' }}>16</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="inv_storage_type">ประเภทหน่วยความจำ</label>
                                                <select name="inv_storage_type" class="form-control" id="inv_storage_type" required>
                                                    <option value="">เลือกประเภทหน่วยความจำ</option>
                                                    <option value="HDD" {{ isset($formData['inv_storage_type']) && $formData['inv_storage_type'] == 'HDD' ? 'selected' : '' }}>HDD</option>
                                                    <option value="SSD" {{ isset($formData['inv_storage_type']) && $formData['inv_storage_type'] == 'SSD' ? 'selected' : '' }}>SSD</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="inv_storage_size">ขนาดหน่วยความจำ</label>
                                                <select name="inv_storage_size" class="form-control" id="inv_storage_size" required>
                                                <option value="">เลือกขนาดหน่วยความจำ</option>
                                                <option value="128" {{ isset($formData['inv_storage_size']) && $formData['inv_storage_size'] == '128' ? 'selected' : '' }}>128 GB</option>
                                                <option value="256" {{ isset($formData['inv_storage_size']) && $formData['inv_storage_size'] == '256' ? 'selected' : '' }}>256 GB</option>
                                                <option value="300" {{ isset($formData['inv_storage_size']) && $formData['inv_storage_size'] == '300' ? 'selected' : '' }}>300 GB</option>
                                                <option value="512" {{ isset($formData['inv_storage_size']) && $formData['inv_storage_size'] == '512' ? 'selected' : '' }}>512 GB</option>
                                                <option value="1024" {{ isset($formData['inv_storage_size']) && $formData['inv_storage_size'] == '1024' ? 'selected' : '' }}>1024 GB</option>
                                                    <option value="2048" {{ isset($formData['inv_storage_size']) && $formData['inv_storage_size'] == '2048' ? 'selected' : '' }}>2048 GB</option>
                                            </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="inv_os_type">ระบบปฏิบัติการ</label>
                                                <select name="inv_os_type" class="form-control" id="inv_os_type" required>
                                                     <option value="">เลือกระบบปฏิบัติการ</option>
                                                        <option value="Windows" {{ isset($formData['inv_os_type']) && $formData['inv_os_type'] == 'Windows' ? 'selected' : '' }}>Windows</option>
                                                        <option value="macOS" {{ isset($formData['inv_os_type']) && $formData['inv_os_type'] == 'macOS' ? 'selected' : '' }}>macOS</option>
                                                        <option value="Linux" {{ isset($formData['inv_os_type']) && $formData['inv_os_type'] == 'Linux' ? 'selected' : '' }}>Linux</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="inv_os_version">เวอร์ชั่น OS</label>
                                                <select name="inv_os_version" class="form-control" id="inv_os_version" required>
                                                    <option value="">เลือกเวอร์ชั่น OS</option>
                                                    <option value="macOS 10.15" {{ isset($formData['inv_os_version']) && $formData['inv_os_version'] == 'macOS 10.15' ? 'selected' : '' }}>macOS 10.15</option>
                                                    <option value="Windows Xp" {{ isset($formData['inv_os_version']) && $formData['inv_os_version'] == 'Windows Xp' ? 'selected' : '' }}>Windows Xp</option>
                                                    <option value="Windows 7 32 bit" {{ isset($formData['inv_os_version']) && $formData['inv_os_version'] == 'Windows 7 32 bit' ? 'selected' : '' }}>Windows 7 32 bit</option>
                                                    <option value="Windows 7 64 bit" {{ isset($formData['inv_os_version']) && $formData['inv_os_version'] == 'Windows 7 64 bit' ? 'selected' : '' }}>Windows 7 64 bit</option>
                                                    <option value="Windows 8 32 bit" {{ isset($formData['inv_os_version']) && $formData['inv_os_version'] == 'Windows 8 32 bit' ? 'selected' : '' }}>Windows 8 32 bit</option>
                                                    <option value="Windows 8 64 bit" {{ isset($formData['inv_os_version']) && $formData['inv_os_version'] == 'Windows 8 64 bit' ? 'selected' : '' }}>Windows 8 64 bit</option>
                                                    <option value="Windows 10 32 bit" {{ isset($formData['inv_os_version']) && $formData['inv_os_version'] == 'Windows 10 32 bit' ? 'selected' : '' }}>Windows 10 32 bit</option>
                                                    <option value="Windows 10 64 bit" {{ isset($formData['inv_os_version']) && $formData['inv_os_version'] == 'Windows 10 64 bit' ? 'selected' : '' }}>Windows 10 64 bit</option>
                                                    <option value="Windows 11" {{ isset($formData['inv_os_version']) && $formData['inv_os_version'] == 'Windows 11' ? 'selected' : '' }}>Windows 11</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="inv_os_copyright">ลิขสิทธิ์ OS</label>
                                                <select name="inv_os_copyright" class="form-control" id="inv_os_copyright" >
                                                    <option value="1">มี</option>
                                                    <option value="0">ไม่มี</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="inv_msoffice_version">เวอร์ชั่น MS Office</label>
                                                <select name="inv_msoffice_version" class="form-control" id="inv_msoffice_version" required>
                                                    <option value="">เลือกเวอร์ชัน MS Office</option>
                                                    <option value="MS-Office 2007" {{ isset($formData['inv_msoffice_version']) && $formData['inv_msoffice_version'] == 'MS-Office 2007' ? 'selected' : '' }}>MS-Office 2007</option>
                                                    <option value="MS-Office 2010" {{ isset($formData['inv_msoffice_version']) && $formData['inv_msoffice_version'] == 'MS-Office 2010' ? 'selected' : '' }}>MS-Office 2010</option>
                                                    <option value="MS-Office 2011" {{ isset($formData['inv_msoffice_version']) && $formData['inv_msoffice_version'] == 'MS-Office 2011' ? 'selected' : '' }}>MS-Office 2011</option>
                                                    <option value="MS-Office 2013" {{ isset($formData['inv_msoffice_version']) && $formData['inv_msoffice_version'] == 'MS-Office 2013' ? 'selected' : '' }}>MS-Office 2013</option>
                                                    <option value="MS-Office 2013-2019" {{ isset($formData['inv_msoffice_version']) && $formData['inv_msoffice_version'] == 'MS-Office 2013-2019' ? 'selected' : '' }}>MS-Office 2013-2019</option>
                                                    <option value="MS-Office 2016" {{ isset($formData['inv_msoffice_version']) && $formData['inv_msoffice_version'] == 'MS-Office 2016' ? 'selected' : '' }}>MS-Office 2016</option>
                                                    <option value="MS-Office 2019" {{ isset($formData['inv_msoffice_version']) && $formData['inv_msoffice_version'] == 'MS-Office 2019' ? 'selected' : '' }}>MS-Office 2019</option>
                                                    <option value="MS-Office 365" {{ isset($formData['inv_msoffice_version']) && $formData['inv_msoffice_version'] == 'MS-Office 365' ? 'selected' : '' }}>MS-Office 365</option>
                                                </select>                                                
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="inv_msoffice_copyright">ลิขสิทธิ์ MS Office</label>
                                                <select name="inv_msoffice_copyright" class="form-control" id="inv_msoffice_copyright" >
                                                    <option value="1">มี</option>
                                                    <option value="0">ไม่มี</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="inv_antivirus">โปรแกรมป้องกันไวรัส</label>
                                                <select name="inv_antivirus" class="form-control" id="inv_antivirus" required>
                                                    <option value="">เลือกโปรแกรมป้องกันไวรัส</option>
                                                    <option value="Deep instinct" {{ isset($formData['inv_antivirus']) && $formData['inv_antivirus'] == 'Deep instinct' ? 'selected' : '' }}>Deep instinct</option>
                                                    <option value="ESET" {{ isset($formData['inv_antivirus']) && $formData['inv_antivirus'] == 'ESET' ? 'selected' : '' }}>ESET</option>
                                                    <option value="Eset NOD" {{ isset($formData['inv_antivirus']) && $formData['inv_antivirus'] == 'Eset NOD' ? 'selected' : '' }}>Eset NOD</option>
                                                    <option value="NOD 32" {{ isset($formData['inv_antivirus']) && $formData['inv_antivirus'] == 'NOD 32' ? 'selected' : '' }}>NOD 32</option>
                                                    <option value="McAfee" {{ isset($formData['inv_antivirus']) && $formData['inv_antivirus'] == 'McAfee' ? 'selected' : '' }}>McAfee</option>
                                                    <option value="Panda" {{ isset($formData['inv_antivirus']) && $formData['inv_antivirus'] == 'Panda' ? 'selected' : '' }}>Panda</option>
                                                    <option value="Trellix" {{ isset($formData['inv_antivirus']) && $formData['inv_antivirus'] == 'Trellix' ? 'selected' : '' }}>Trellix</option>
                                                    <option value="Trend Micro" {{ isset($formData['inv_antivirus']) && $formData['inv_antivirus'] == 'Trend Micro' ? 'selected' : '' }}>Trend Micro</option>
                                                    <option value="Windows Security" {{ isset($formData['inv_antivirus']) && $formData['inv_antivirus'] == 'Windows Security' ? 'selected' : '' }}>Windows Security</option>
                                                    <option value="Microsoft Security" {{ isset($formData['inv_antivirus']) && $formData['inv_antivirus'] == 'Microsoft Security' ? 'selected' : '' }}>Microsoft Security</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="inv_antivirus_copyright">ลิขสิทธิ์โปรแกรมป้องกันไวรัส</label>
                                                <select name="inv_antivirus_copyright" class="form-control" id="inv_antivirus_copyright">
                                                    <option value="1" {{ isset($formData['inv_antivirus_copyright']) && $formData['inv_antivirus_copyright'] == '1' ? 'selected' : '' }}>มี</option>
                                                    <option value="0" {{ isset($formData['inv_antivirus_copyright']) && $formData['inv_antivirus_copyright'] == '0' ? 'selected' : '' }}>ไม่มี</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="inv_setup_year">วันที่ติดตั้ง</label>
                                                <input type="date" name="inv_setup_year" class="form-control" id="inv_setup_year" placeholder="ปีที่ติดตั้ง" value="{{ isset($formData['inv_setup_year']) ? $formData['inv_setup_year'] : '' }}" required>
                                        
                                            </div>
                                        </div>    
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="inv_status">สถานะการใช้งาน</label>
                                                <select name="inv_status" class="form-control" id="inv_status">
                                                    <option value="1" {{ isset($formData['inv_status']) && $formData['inv_status'] == '1' ? 'selected' : '' }}>ใช้งาน</option>
                                                    <option value="0" {{ isset($formData['inv_status']) && $formData['inv_status'] == '0' ? 'selected' : '' }}>ไม่ใช้งาน</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                   
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="inv_cpu_clock">ความเร็ว CPU(GHz)</label>
                                            <input type="text" name="inv_cpu_clock" class="form-control" id="inv_cpu_clock" placeholder="ความเร็ว CPU" value="{{ isset($formData['inv_cpu_clock']) ? $formData['inv_cpu_clock'] : '' }}" required>
                                        </div>
                                    </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="inv_picture">รูปภาพ</label>
                                                <div class="input-group">
                                                  <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="inv_picture" name="inv_picture">
                                                    <label class="custom-file-label" for="inv_picture">เลือกไฟล์</label>
                                                  </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </section>              


            <!--person part-->
                            <br>    
                            <section class="content-header">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <h1>เพิ่มรายชื่อผู้รับ</h1>
                                            </div>
                                        </div>
                                    </div>
                            </section>
                            
                            <section class="content">
                                <div class="container-fluid">
                                    <div class="row">
                                        <!-- left column -->
                                        <div class="col-md-12">
                                            <!-- jquery validation -->
                                            <div class="card card-primary">
                                                <div class="card-header">
                                                    <h3 class="card-title">บันทึกข้อมูลผู้รับ</h3>
                                                </div>
                                                <!-- /.card-header -->
                                                <!-- form start -->
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="rec_prefix">คำนำหน้า</label>
                                                                <input type="text" name="rec_prefix" class="form-control" id="rec_prefix" placeholder="คำนำหน้า">
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="rec_fname">ชื่อ</label>
                                                                <input type="text" name="rec_fname" class="form-control" id="rec_fname" placeholder="ชื่อ">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="rec_lname">นามสกุล</label>
                                                                <input type="text" name="rec_lname" class="form-control" id="rec_lname" placeholder="นามสกุล">
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="rec_personal_tel">เบอร์โทรติดต่อ</label>
                                                                <input type="text" name="rec_personal_tel" class="form-control" id="rec_personal_tel" 
                                                                       placeholder="เบอร์โทรติดต่อ" onkeypress="return isNumberKey(event)">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="rec_org_tel">เบอร์โทรหน่วย</label>
                                                                <input type="text" name="rec_org_tel" class="form-control" id="rec_org_tel" 
                                                                       placeholder="เบอร์โทรหน่วย" onkeypress="return isNumberKey(event)">
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="department2" class="form-label">หน่วย/สังกัด</label>
                                                            <input type="text" class="form-control" id="department2" name="rec_address"  placeholder="พิมพ์ชื่อหน่วยของท่าน" autocomplete="off">
                                                            <div id="departmentList2"></div>
                                                            <input type="hidden" id="department_id2" name="rec_organize" value="1" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                            </section>
                                <!--save-->
                                <div class="container-fluid">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <button type="submit" class="btn btn-primary">Save</button>
                                                <button type="button"  class="btn btn-primary" onclick="clearFields()">Clear</button>
                                            </div>
                                        </div>    
                                    </div>
                                </div>
                         
                            
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
    </form>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function clearFields() {
    // Clear text inputs
    var inputs = document.querySelectorAll('#myForm input[type="text"]');
    inputs.forEach(function(input) {
        input.value = '';
    });

    // Clear select elements
    var selects = document.querySelectorAll('#myForm select');
    selects.forEach(function(select) {
        select.selectedIndex = 0; // Select the first option
    });

    // Clear textareas
    var textareas = document.querySelectorAll('#myForm textarea');
    textareas.forEach(function(textarea) {
        textarea.value = '';
    });

        $('#inv_ram').prop('disabled', false);
        $('#inv_mac_address').prop('disabled', false);
        $('#inv_ram_speed').prop('disabled', false);
        $('#inv_storage_type').prop('disabled', false);
        $('#inv_storage_size').prop('disabled', false);
        $('#inv_cpu').prop('disabled', false);
        $('#inv_cpu_clock').prop('disabled', false);
        $('#inv_os_type').prop('disabled', false);
        $('#inv_os_version').prop('disabled', false);
        $('#inv_os_copyright').prop('disabled', false);
        $('#inv_msoffice_version').prop('disabled', false);
        $('#inv_msoffice_copyright').prop('disabled', false);
        $('#inv_antivirus').prop('disabled', false);
        $('#inv_antivirus_copyright').prop('disabled', false);
}    

    $(document).ready(function() {
        // Function to update the disabled state of the inv_author field
        function updateAuthorField() {
            // Get the selected value of the inv_type field
            var selectedValue = $('#inv_type').val();
            // Check if the selected value is '2' or '3'
            if (selectedValue === "2" || selectedValue === "3") {
                $('#inv_ram').prop('disabled', true);
                $('#inv_mac_address').prop('disabled', true);
                $('#inv_ram_speed').prop('disabled', true);
                $('#inv_storage_type').prop('disabled', true);
                $('#inv_storage_size').prop('disabled', true);
                $('#inv_cpu').prop('disabled', true);
                $('#inv_cpu_clock').prop('disabled', true);
                $('#inv_os_type').prop('disabled', true);
                $('#inv_os_version').prop('disabled', true);
                $('#inv_os_copyright').prop('disabled', true);
                $('#inv_msoffice_version').prop('disabled', true);
                $('#inv_msoffice_copyright').prop('disabled', true);
                $('#inv_antivirus').prop('disabled', true);
                $('#inv_antivirus_copyright').prop('disabled', true);
            } else {
                $('#inv_ram').prop('disabled', false);
                $('#inv_mac_address').prop('disabled', false);
                $('#inv_ram_speed').prop('disabled', false);
                $('#inv_storage_type').prop('disabled', false);
                $('#inv_storage_size').prop('disabled', false);
                $('#inv_cpu').prop('disabled', false);
                $('#inv_cpu_clock').prop('disabled', false);
                $('#inv_os_type').prop('disabled', false);
                $('#inv_os_version').prop('disabled', false);
                $('#inv_os_copyright').prop('disabled', false);
                $('#inv_msoffice_version').prop('disabled', false);
                $('#inv_msoffice_copyright').prop('disabled', false);
                $('#inv_antivirus').prop('disabled', false);
                $('#inv_antivirus_copyright').prop('disabled', false);
            }
        }

        // Add an event listener to the inv_type select field
        $('#inv_type').change(updateAuthorField);

        // Call the function initially to set the correct state based on the default value
        updateAuthorField();
    });

</script>

<script>
    function isNumberKey(evt) {
        var charCode = evt.which ? evt.which : evt.keyCode;
        // Allow only numbers (0-9)
        if (charCode < 48 || charCode > 57) {
            evt.preventDefault();
            return false;
        }
        return true;
    }
</script>

<script type="text/javascript">
    $(document).ready(function() {
        function setupAutocomplete(inputSelector, listSelector, hiddenInputSelector) {
            $(inputSelector).on('keyup', function() {
                var query = $(this).val();
                if (query != '') {
                    $.ajax({
                        url: '//127.0.0.1:8000/departments/search',
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
                var departmentId = $(this).data('id')|| 1;
                var departmentText = $(this).text();

                // ใส่ชื่อหน่วยงานที่เลือกในช่อง input
                if(departmentId == 'null'){
                    departmentId = 1;
                }
                
                $(inputSelector).val(departmentText);

                // เก็บค่า department_id ใน hidden input
                $(hiddenInputSelector).val(departmentId);

                $(listSelector).fadeOut();
            });
        }

        // เรียกใช้ฟังก์ชันสำหรับ input แต่ละช่อง
        //setupAutocomplete('#department1', '#departmentList1', '#department_id1');
        setupAutocomplete('#department2', '#departmentList2', '#department_id2');
    });
</script>

    

@endsection
