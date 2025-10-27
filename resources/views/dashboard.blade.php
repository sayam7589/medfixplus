@extends('layouts.adminlte')

@section('style')
<style>
/* ====== Overall Style ====== */
.main-highlight .card {
  box-shadow: 0 10px 24px rgba(0,0,0,.08);
  border-radius: 1rem;
}
.main-highlight .card-header {
  border-top-left-radius: 1rem;
  border-top-right-radius: 1rem;
}
.main-highlight .gong-select-wrap {
  display: flex; align-items: center; justify-content: center; flex-wrap: wrap;
  column-gap: .75rem; row-gap: .5rem;
}
.main-highlight select#gongSelect {
  min-width: 180px; max-width: 220px; height: 32px; font-size: .9rem;
}

/* Filter (Month/Year) */
.filter-inline {
  background: #f4f6f9; border-radius: 8px; padding: .5rem .75rem;
  box-shadow: 0 2px 4px rgba(0,0,0,0.05);
  display: flex; align-items: center; justify-content: center; flex-wrap: wrap;
  column-gap: .5rem; row-gap: .35rem;
}
.filter-inline .group { display: flex; align-items: center; column-gap: .35rem; }
.filter-inline label { margin: 0; font-size: .8rem; color: #6c757d; }
.filter-inline select.form-control {
  min-width: 96px; text-align: center; height: 32px; padding: 2px 8px; font-size: .9rem;
  background-color: #fff; border: 1px solid #ced4da; border-radius: 50rem;
  transition: all .2s ease-in-out;
}
.filter-inline select.form-control:focus {
  border-color: #007bff; box-shadow: 0 0 3px rgba(0,123,255,.3);
}
.filter-inline .btn {
  height: 32px; line-height: 1; border-radius: 50rem; padding: 0 .9rem; font-weight: 500;
  box-shadow: 0 1px 2px rgba(0,0,0,.06);
}
.filter-inline .btn:hover { transform: translateY(-1px); }

#invTypeBar, #lineChart { width: 100%; }
</style>
@endsection

@section('content')
<div class="content-wrapper">
  <!-- Header -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6"><h1>Dashboard</h1></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboards</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <!-- Main Content -->
  <section class="content">
    <div class="container-fluid">

      <!-- KPI Small Boxes -->
      <div class="row">
        <div class="col-lg-3 col-6">
          <div class="small-box bg-warning">
            <div class="inner"><h3>{{ $medfix_count }}</h3><p>รายการแจ้งซ่อม</p></div>
            <div class="icon"><i class="ion ion-bag"></i></div>
            <a href="{{ route('medfix') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="small-box bg-success">
            <div class="inner"><h3>{{ $inventory_count }}</h3><p>รายการสินทรัพย์</p></div>
            <div class="icon"><i class="ion ion-stats-bars"></i></div>
            <a href="/inventorys_index" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="small-box bg-danger">
            <div class="inner"><h3>{{ $project_count }}</h3><p>โครงการจัดซื้อ</p></div>
            <div class="icon"><i class="ion ion-person-add"></i></div>
            <a href="/projects_index" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="small-box bg-info">
            <div class="inner"><h3>{{ $user_count }}</h3><p>ผู้ใช้งาน</p></div>
            <div class="icon"><i class="ion ion-pie-graph"></i></div>
            <a href="#" class="small-box-footer"><i class="fa fa-address-book"></i></a>
          </div>
        </div>
      </div>

      <!-- MAIN HIGHLIGHT (เลือกกอง + กราฟ) -->
      <div class="row main-highlight">
        <div class="col-12">
          <div class="card card-outline card-info">
            <div class="card-header text-center">
              <h2 class="card-title font-weight-bold">ภาพรวมประเภทครุภัณฑ์ (inv_type) ตามกอง (gong)</h2>
            </div>
            <div class="card-body">
              <div class="gong-select-wrap mb-3">
                <label for="gongSelect" class="mb-0">เลือกกอง:</label>
                <select id="gongSelect" class="form-control form-control-sm">
                  <option value="" selected disabled>— เลือกกอง —</option>
                  @foreach($gongs as $gong)
                    <option value="{{ $gong }}">{{ $gong }}</option>
                  @endforeach
                </select>
              </div>
              <div class="chart">
                <canvas id="invTypeBar" style="min-height:380px;height:400px;max-height:460px;"></canvas>
              </div>
              <small class="text-muted d-block mt-2 text-center">
                * กราฟนี้รวมทุก “หน่วย/แผนก” ที่อยู่ใต้กอง (gong) ที่เลือก
              </small>
            </div>
          </div>
        </div>
      </div>

      <!-- SECOND ROW -->
      <div class="row">
        <!-- Line Chart (สถิติการซ่อม) -->
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header d-flex align-items-center justify-content-between">
              <h3 class="card-title">สถิติการซ่อม (รายเดือน)</h3>
              <div class="filter-inline">
                <div class="group">
                  <label>ตั้งแต่:</label>
                  <select id="startMonth" class="form-control form-control-sm">
                    @foreach(range(1,12) as $m)
                      <option value="{{ $m }}">{{ getThaiMonthAbbreviation($m) }}</option>
                    @endforeach
                  </select>
                  <select id="startYear" class="form-control form-control-sm">
                    @foreach(range(now()->year-1, now()->year+1) as $y)
                      <option value="{{ $y }}">{{ $y }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="group">
                  <label>ถึง:</label>
                  <select id="endMonth" class="form-control form-control-sm">
                    @foreach(range(1,12) as $m)
                      <option value="{{ $m }}" {{ $m == now()->month ? 'selected' : '' }}>
                        {{ getThaiMonthAbbreviation($m) }}
                      </option>
                    @endforeach
                  </select>
                  <select id="endYear" class="form-control form-control-sm">
                    @foreach(range(now()->year-1, now()->year+1) as $y)
                      <option value="{{ $y }}" {{ $y == now()->year ? 'selected' : '' }}>
                        {{ $y }}
                      </option>
                    @endforeach
                  </select>
                </div>
                <button id="filterBtn" class="btn btn-sm btn-primary">กรองข้อมูล</button>
              </div>
            </div>
            <div class="card-body">
              <div class="chart">
                <canvas id="lineChart" style="min-height:250px;height:250px;max-height:300px;"></canvas>
              </div>
            </div>
          </div>
        </div>

        <!-- Common Issues Table -->
        <div class="col-md-6">
          <div class="card">
            <div class="card-header"><h3 class="card-title">ปัญหาที่พบบ่อย</h3></div>
            <div class="card-body p-0">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>#</th><th>ปัญหาการซ่อม</th><th></th><th>จำนวนครั้ง</th><th>ร้อยละ</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($repairsByIssue as $i => $repair)
                    <tr>
                      <td>{{ $i+1 }}</td>
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
        </div>
      </div> <!-- row -->
    </div>
  </section>
</div>
@endsection

@section('scripts')
<script src="{{ asset('adminlte/plugins/chart.js/Chart.min.js') }}"></script>
<script>
$(function () {
  // ====== LINE CHART (ซ่อม) ======
  const lineCanvas = document.getElementById('lineChart');
  let lineChart;
  if (lineCanvas && typeof Chart !== 'undefined') {
    const labelsInit = {!! json_encode($repairs->pluck('month_thai')) !!};
    const dataInit   = {!! json_encode($repairs->pluck('total_repairs')) !!};
    lineChart = new Chart(lineCanvas.getContext('2d'), {
      type: 'line',
      data: {
        labels: labelsInit,
        datasets: [{
          label: 'จำนวนการแจ้งซ่อม',
          borderColor: 'rgba(60,141,188,1)',
          backgroundColor: 'rgba(60,141,188,0.1)',
          pointBackgroundColor: '#3b8bba',
          pointBorderColor: '#fff',
          data: dataInit,
          fill: true,
          lineTension: 0.3
        }]
      },
      options: {
        responsive: true, maintainAspectRatio: false,
        legend: { display: false },
        scales: {
          xAxes: [{ gridLines: { display:false } }],
          yAxes: [{ ticks: { beginAtZero:true }, gridLines: { color:'rgba(0,0,0,.06)' } }]
        }
      }
    });
  }

  // กรองข้อมูลช่วงเดือน
  $('#filterBtn').on('click', async () => {
    const params = new URLSearchParams({
      start_month: $('#startMonth').val(),
      start_year:  $('#startYear').val(),
      end_month:   $('#endMonth').val(),
      end_year:    $('#endYear').val(),
    });
    try {
      const res = await fetch(`{{ route('dashboard.repairs.filter') }}?${params}`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
      const json = await res.json();
      if (lineChart) {
        lineChart.data.labels = json.labels || [];
        lineChart.data.datasets[0].data = json.data || [];
        lineChart.update();
      }
    } catch (e) { console.error('กรองสถิติการซ่อมล้มเหลว:', e); }
  });

  // ====== BAR CHART (inv_type by gong) ======
  const gongSelect = document.getElementById('gongSelect');
  const barCanvas  = document.getElementById('invTypeBar');
  if (!barCanvas) return;
  const barCtx = barCanvas.getContext('2d');

  const gradient = barCtx.createLinearGradient(0, 0, 0, 400);
  gradient.addColorStop(0, 'rgba(0,123,255,0.9)');
  gradient.addColorStop(1, 'rgba(0,123,255,0.2)');

  let invTypeBarChart = new Chart(barCtx, {
    type: 'bar',
    data: { labels: [], datasets: [{
      label: 'จำนวนครุภัณฑ์ (ตามประเภท)',
      data: [], backgroundColor: gradient,
      borderColor: 'rgba(0,123,255,1)', borderWidth: 1,
      hoverBackgroundColor: 'rgba(0,123,255,0.8)',
      hoverBorderColor: '#0056b3'
    }]},
    options: {
      responsive:true, maintainAspectRatio:false,
      animation:{ duration:1200, easing:'easeOutQuart' },
      legend:{ display:false },
      tooltips:{
        backgroundColor:'#333', titleFontSize:13, bodyFontSize:12,
        xPadding:10, yPadding:8, displayColors:false,
        callbacks:{ label:(t)=>`จำนวน ${t.yLabel.toLocaleString()} รายการ` }
      },
      scales:{
        xAxes:[{ gridLines:{ display:false },
          ticks:{ fontColor:'#555', maxRotation:35, minRotation:0, autoSkip:true }
        }],
        yAxes:[{ ticks:{ beginAtZero:true, stepSize:1, fontColor:'#555' },
          gridLines:{ color:'rgba(0,0,0,0.05)' }
        }]
      },
      hover:{ animationDuration:400 }
    }
  });

  async function loadInvTypeCountsByGong(gong) {
    if (!gong) return;
    const url = @json(route('dashboard.invTypeCounts')) + '?gong=' + encodeURIComponent(gong);
    try {
      const res  = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' }});
      const json = await res.json();
      invTypeBarChart.data.labels = json.labels || [];
      invTypeBarChart.data.datasets[0].data = json.data || [];
      invTypeBarChart.update();
    } catch (e) { console.error('โหลดข้อมูล inv_type ล้มเหลว:', e); }
  }

  if (gongSelect) {
    gongSelect.addEventListener('change', () => loadInvTypeCountsByGong(gongSelect.value));
    const firstVal = gongSelect.querySelector('option[value]:not([disabled])')?.value;
    if (firstVal) { gongSelect.value = firstVal; loadInvTypeCountsByGong(firstVal); }
  }
});
</script>
@endsection
