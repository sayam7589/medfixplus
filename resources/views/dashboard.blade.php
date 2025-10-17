@extends('layouts.adminlte')

@section('style')
    <!-- Style (Page) -->
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6"><h1>Dashboard</h1></div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">

                <!-- Top stats -->
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner"><h3>{{ $medfix_count }}</h3><p>รายการแจ้งซ่อม</p></div>
                            <div class="icon"><i class="ion ion-bag"></i></div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner"><h3>{{ $inventory_count }}</h3><p>รายการสินทรัพย์</p></div>
                            <div class="icon"><i class="ion ion-stats-bars"></i></div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner"><h3>{{ $project_count }}</h3><p>โครงการจัดซื้อ</p></div>
                            <div class="icon"><i class="ion ion-person-add"></i></div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner"><h3>{{ $user_count }}</h3><p>ผู้ใช้งาน</p></div>
                            <div class="icon"><i class="ion ion-pie-graph"></i></div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- LEFT -->
                    <div class="col-md-6">

                        <!-- AREA CHART -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">สถิติการซ่อม</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart">
                                    <canvas id="areaChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- STACKED BAR + DROPDOWN -->
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">สินทรัพย์ตามประเภท × หน่วยงาน</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="card-body">

                                <!-- Dropdown เลือกหน่วยงาน -->
                                <div class="row mb-2">
                                    <div class="col-12 col-sm-8">
                                        <label for="deptSelect" class="mb-1">เลือกหน่วยงาน</label>
                                        <select id="deptSelect" class="form-control">
                                            <option value="">— แสดงทุกหน่วยงาน —</option>
                                            @foreach($departments as $d)
                                                <option value="{{ $d->id }}">{{ $d->gong }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="chart" style="min-height: 320px; height: 320px; max-height: 320px; max-width: 100%;">
                                    <canvas id="invOrgTypeBar"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT -->
                    <div class="col-md-6">
                        <!-- Frequent Issues Table -->
                        <div class="card">
                            <div class="card-header"><h3 class="card-title">ปัญหาที่พบบ่อย</h3></div>
                            <div class="card-body p-0">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>ปัญหาการซ่อม</th>
                                            <th style="width: 40%"></th>
                                            <th>จำนวนครั้ง</th>
                                            <th style="width: 40px">ร้อยละ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($repairsByIssue as $idx => $repair)
                                            <tr>
                                                <td>{{ $idx + 1 }}</td>
                                                <td>{{ $repair->issue_name }}</td>
                                                <td>
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar progress-bar-danger" style="width: {{ $repair->percentage }}%"></div>
                                                    </div>
                                                </td>
                                                <td><span class="badge bg-info">{{ $repair->successful_repairs }}</span></td>
                                                <td><span class="badge bg-danger">{{ $repair->percentage }}%</span></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- ถ้าจะใช้ Donut ภายหลัง ค่อยปลดคอมเมนต์การ์ด + JS --}}
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection

@section('scripts')
    <!-- Chart.js v2 from AdminLTE -->
    <script src="{{ asset('adminlte/plugins/chart.js/Chart.min.js') }}"></script>
    <script>
        $(function () {
            // ===== AREA CHART (เดิม) =====
            var labels = {!! json_encode($repairs->pluck('month_thai')) !!};
            var data   = {!! json_encode($repairs->pluck('total_repairs')) !!};
            var areaChartCanvas = $('#areaChart').get(0).getContext('2d');
            var areaChartData = {
                labels: labels,
                datasets: [{
                    label: 'จำนวนการแจ้งซ่อม',
                    backgroundColor: 'rgba(60,141,188,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: data
                }]
            };
            var areaChartOptions = {
                maintainAspectRatio: false,
                responsive: true,
                legend: { display: false },
                scales: { xAxes: [{ gridLines: { display: false }}], yAxes: [{ gridLines: { display: false }}]}
            };
            new Chart(areaChartCanvas, { type: 'line', data: areaChartData, options: areaChartOptions });

            // ===== INVENTORY CHART (Stacked / Single) =====
            var invOrgTypeChart;
            var $dept = $('#deptSelect');

            async function loadInvChart() {
                try {
                    var params = new URLSearchParams();
                    if ($dept.val()) params.set('org_id', $dept.val());

                    const url = `{{ route('charts.inventory.byOrgType') }}${params.toString() ? '?' + params.toString() : ''}`;
                    const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                    const json = await res.json();

                    const ctx = document.getElementById('invOrgTypeBar').getContext('2d');
                    if (invOrgTypeChart) invOrgTypeChart.destroy();

                    // โหมด stacked vs single
                    var isStacked = (json.mode === 'stacked');

                    invOrgTypeChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: json.labels,
                            datasets: json.datasets.map(function (ds, i) {
                                return $.extend({}, ds, {
                                    backgroundColor: getColor(i),
                                    borderColor: getColor(i),
                                    borderWidth: 1
                                });
                            })
                        },
                        options: {
                            maintainAspectRatio: false,
                            responsive: true,
                            legend: { display: true, position: 'top' },
                            tooltips: { mode: 'index', intersect: false },
                            scales: {
                                xAxes: [{ stacked: isStacked, gridLines: { display: false } }],
                                yAxes: [{ stacked: isStacked, ticks: { beginAtZero: true, precision: 0 } }]
                            }
                        }
                    });
                } catch (e) {
                    console.error('Load inv chart error:', e);
                }
            }

            function getColor(i) {
                var base = [
                    'rgba(60,141,188,0.8)','rgba(0,166,90,0.8)','rgba(243,156,18,0.8)',
                    'rgba(221,75,57,0.8)','rgba(0,192,239,0.8)','rgba(96,92,168,0.8)',
                    'rgba(210,214,222,0.8)','rgba(57,204,204,0.8)','rgba(255,133,27,0.8)'
                ];
                return base[i % base.length];
            }

            // โหลดครั้งแรก + เมื่อเปลี่ยน Dropdown
            loadInvChart();
            $dept.on('change', loadInvChart);
        });
    </script>
@endsection
