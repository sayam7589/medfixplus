@extends('layouts.adminlte')

@section('title', 'แดชบอร์ด')

@section('style')
<style>
/* ====== Overall Style ====== */
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
  border-color: #0c7187; box-shadow: 0 0 3px rgba(12,113,135,.3);
}
.filter-inline .btn {
  height: 32px; line-height: 1; border-radius: 50rem; padding: 0 .9rem; font-weight: 500;
  box-shadow: 0 1px 2px rgba(0,0,0,.06);
}
.filter-inline .btn:hover { transform: translateY(-1px); }

#invTypeBar, #lineChart { width: 100%; }

/* แถบ progress ตารางปัญหาที่พบบ่อย (เดิม class BS3 ไม่มีสี) */
.mf-progress-bar {
  background: linear-gradient(90deg, #14b8a6, #0c7187);
  border-radius: 20px;
}
.progress.progress-xs { background: #eef2f6; border-radius: 20px; }

/* donut ปัญหาที่พบบ่อย */
.issue-donut-wrap { width: 100%; max-width: 235px; margin: 0 auto; }

/* หัวการ์ดกราฟ: ให้ filter ตกบรรทัดได้บนจอแคบ */
.card-primary .card-header.d-flex { flex-wrap: wrap; row-gap: .5rem; }
</style>
@endsection

@section('content')
<div class="content-wrapper">
  <!-- Header -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6"><h1>แดชบอร์ด</h1></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">หน้าหลัก</a></li>
            <li class="breadcrumb-item active">แดชบอร์ด</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <!-- Main Content -->
  <section class="content">
    <div class="container-fluid">

      <!-- KPI Cards (clean minimal — ลิงก์/ข้อมูลเดิมทุกตัว) -->
      <div class="row">
        <div class="col-lg-3 col-6">
          <div class="mf-kpi">
            <div class="mf-kpi-top">
              <div>
                <p class="mf-kpi-label">รายการแจ้งซ่อม</p>
                <h3 class="mf-kpi-value">{{ $medfix_count }}</h3>
              </div>
              <span class="mf-kpi-icon is-warning"><i class="fas fa-tools"></i></span>
            </div>
            <a href="{{ route('medfix') }}" class="mf-kpi-link">รายละเอียด <i class="fas fa-arrow-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="mf-kpi">
            <div class="mf-kpi-top">
              <div>
                <p class="mf-kpi-label">รายการสินทรัพย์</p>
                <h3 class="mf-kpi-value">{{ $inventory_count }}</h3>
              </div>
              <span class="mf-kpi-icon is-success"><i class="fas fa-boxes"></i></span>
            </div>
            <a href="/inventorys_index" class="mf-kpi-link">รายละเอียด <i class="fas fa-arrow-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="mf-kpi">
            <div class="mf-kpi-top">
              <div>
                <p class="mf-kpi-label">โครงการจัดซื้อ</p>
                <h3 class="mf-kpi-value">{{ $project_count }}</h3>
              </div>
              <span class="mf-kpi-icon is-primary"><i class="fas fa-file-signature"></i></span>
            </div>
            <a href="/projects_index" class="mf-kpi-link">รายละเอียด <i class="fas fa-arrow-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="mf-kpi">
            <div class="mf-kpi-top">
              <div>
                <p class="mf-kpi-label">ผู้ใช้งาน</p>
                <h3 class="mf-kpi-value">{{ $user_count }}</h3>
              </div>
              <span class="mf-kpi-icon is-info"><i class="fas fa-users"></i></span>
            </div>
            <a href="{{ route('users.permissions.index') }}" class="mf-kpi-link">รายละเอียด <i class="fas fa-arrow-right"></i></a>
          </div>
        </div>
      </div>

      <!-- MAIN HIGHLIGHT (เลือกกอง + กราฟ) -->
      <div class="row main-highlight">
        <div class="col-12">
          <div class="card card-outline card-info">
            <div class="card-header text-center">
              <h3 class="card-title font-weight-bold">กราฟแท่งแสดงประเภทครุภัณฑ์</h3>
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

        <!-- Common Issues: donut + table -->
        <div class="col-md-6">
          <div class="card">
            <div class="card-header"><h3 class="card-title">ปัญหาที่พบบ่อย</h3></div>
            @if($repairsByIssue->count())
            <div class="card-body pb-0 pt-3">
              <div class="issue-donut-wrap">
                <canvas id="issueDonut" style="min-height:200px;height:210px;max-height:220px;"></canvas>
              </div>
            </div>
            @endif
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
                        {{-- เดิมใช้ progress-bar-danger (Bootstrap 3) → แถบไม่มีสี --}}
                        <div class="progress progress-xs">
                          <div class="progress-bar mf-progress-bar" style="width: {{ $repair->percentage ?? 0 }}%"></div>
                        </div>
                      </td>
                      {{-- ตัวเลขสถิติใช้โทนกลาง (เดิม bg-danger สีแดงทั้งที่ไม่ใช่ค่าลบ + class ไม่ตรงธีม) --}}
                      <td><span class="badge badge-info">{{ $repair->successful_repairs }}</span></td>
                      <td><span class="badge badge-neutral">{{ $repair->percentage ?? 0 }}%</span></td>
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
  // ====== ค่ากลางของกราฟ (โทนเดียวกับธีม MEDFIX+) ======
  const MF = {
    primary: '#0c7187',
    accent:  '#14b8a6',
    text:    '#64748b',
    grid:    'rgba(100,116,139,.12)',
    tooltipBg: 'rgba(15,23,42,.92)'
  };
  if (typeof Chart !== 'undefined') {
    Chart.defaults.global.defaultFontFamily = "'Kanit', sans-serif";
    Chart.defaults.global.defaultFontColor  = MF.text;
    Chart.defaults.global.defaultFontSize   = 13;
  }
  // tooltip สไตล์เดียวกันทุกกราฟ
  const mfTooltip = {
    backgroundColor: MF.tooltipBg,
    titleFontSize: 13, bodyFontSize: 13,
    titleFontStyle: '600',
    xPadding: 12, yPadding: 10,
    cornerRadius: 8, caretSize: 6,
    displayColors: false
  };

  // ====== LINE CHART (ซ่อม) ======
  const lineCanvas = document.getElementById('lineChart');
  let lineChart;
  if (lineCanvas && typeof Chart !== 'undefined') {
    const labelsInit = {!! json_encode($repairs->pluck('month_thai')) !!};
    const dataInit   = {!! json_encode($repairs->pluck('total_repairs')) !!};

    // gradient ใต้เส้น โทน teal จาง ๆ
    const lineCtx = lineCanvas.getContext('2d');
    const lineGradient = lineCtx.createLinearGradient(0, 0, 0, 280);
    lineGradient.addColorStop(0, 'rgba(20,184,166,0.25)');
    lineGradient.addColorStop(1, 'rgba(20,184,166,0.02)');

    lineChart = new Chart(lineCtx, {
      type: 'line',
      data: {
        labels: labelsInit,
        datasets: [{
          label: 'จำนวนการแจ้งซ่อม',
          borderColor: MF.accent,
          borderWidth: 3,
          backgroundColor: lineGradient,
          pointBackgroundColor: '#fff',
          pointBorderColor: MF.accent,
          pointBorderWidth: 2.5,
          pointRadius: 4.5,
          pointHoverRadius: 7,
          pointHoverBackgroundColor: MF.accent,
          pointHoverBorderColor: '#fff',
          data: dataInit,
          fill: true,
          lineTension: 0.35
        }]
      },
      options: {
        responsive: true, maintainAspectRatio: false,
        legend: { display: false },
        tooltips: Object.assign({}, mfTooltip, {
          callbacks: { label: (t) => ` แจ้งซ่อม ${Number(t.yLabel).toLocaleString()} รายการ` }
        }),
        scales: {
          xAxes: [{ gridLines: { display:false }, ticks: { padding: 8 } }],
          yAxes: [{
            ticks: { beginAtZero:true, precision:0, padding: 10, maxTicksLimit: 6 },
            gridLines: { color: MF.grid, zeroLineColor: MF.grid, drawBorder: false }
          }]
        }
      }
    });
  }

  // กรองข้อมูลช่วงเดือน (ใช้ relative URL ป้องกัน Mixed Content)
  $('#filterBtn').on('click', async () => {
    const params = new URLSearchParams({
      start_month: $('#startMonth').val(),
      start_year:  $('#startYear').val(),
      end_month:   $('#endMonth').val(),
      end_year:    $('#endYear').val(),
    });
    try {
      const base = @json(route('dashboard.repairs.filter', [], false)); // << relative
      const res  = await fetch(`${base}?${params}`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
      const json = await res.json();
      if (lineChart) {
        lineChart.data.labels = json.labels || [];
        lineChart.data.datasets[0].data = json.data || [];
        lineChart.update();
      }
    } catch (e) { console.error('กรองสถิติการซ่อมล้มเหลว:', e); }
  });

  // ====== DONUT (ปัญหาที่พบบ่อย — top 6 จากข้อมูลที่หน้านี้มีอยู่แล้ว) ======
  const donutCanvas = document.getElementById('issueDonut');
  if (donutCanvas && typeof Chart !== 'undefined') {
    const issueLabels = {!! json_encode($repairsByIssue->take(6)->pluck('issue_name')) !!};
    const issueData   = ({!! json_encode($repairsByIssue->take(6)->pluck('successful_repairs')) !!}).map(Number);
    if (issueLabels.length) {
      new Chart(donutCanvas.getContext('2d'), {
        type: 'doughnut',
        data: {
          labels: issueLabels,
          datasets: [{
            data: issueData,
            backgroundColor: ['#0c7187', '#14b8a6', '#3aa7c4', '#7fd1c5', '#b6dde8', '#cbd5e1'],
            borderColor: '#fff',
            borderWidth: 2,
            hoverBorderColor: '#fff'
          }]
        },
        options: {
          responsive: true, maintainAspectRatio: false,
          cutoutPercentage: 70,
          legend: { display: false }, // ตารางด้านล่างทำหน้าที่เป็น legend อยู่แล้ว
          tooltips: Object.assign({}, mfTooltip, {
            callbacks: {
              label: (t, d) => {
                const v = d.datasets[0].data[t.index] || 0;
                const total = d.datasets[0].data.reduce((a, b) => a + b, 0) || 1;
                return ` ${d.labels[t.index]}: ${v.toLocaleString()} ครั้ง (${Math.round(v / total * 100)}%)`;
              }
            }
          })
        }
      });
    }
  }

  // ====== BAR CHART (inv_type by gong) ======
  const gongSelect = document.getElementById('gongSelect');
  const barCanvas  = document.getElementById('invTypeBar');
  if (!barCanvas) return;
  const barCtx = barCanvas.getContext('2d');

  // gradient โทน navy-teal ของธีม
  const gradient = barCtx.createLinearGradient(0, 0, 0, 420);
  gradient.addColorStop(0, 'rgba(12,113,135,0.92)');
  gradient.addColorStop(1, 'rgba(20,184,166,0.4)');

  let invTypeBarChart = new Chart(barCtx, {
    type: 'bar',
    data: { labels: [], datasets: [{
      label: 'จำนวนครุภัณฑ์ (ตามประเภท)',
      data: [], backgroundColor: gradient,
      borderColor: 'transparent', borderWidth: 0,
      maxBarThickness: 52,
      barPercentage: 0.7,
      categoryPercentage: 0.65,
      hoverBackgroundColor: 'rgba(12,113,135,1)'
    }]},
    options: {
      responsive:true, maintainAspectRatio:false,
      animation:{ duration:900, easing:'easeOutQuart' },
      legend:{ display:false },
      tooltips: Object.assign({}, mfTooltip, {
        callbacks:{ label:(t)=>` จำนวน ${Number(t.yLabel).toLocaleString()} รายการ` }
      }),
      scales:{
        xAxes:[{ gridLines:{ display:false },
          ticks:{ maxRotation:35, minRotation:0, autoSkip:true, padding:6 }
        }],
        yAxes:[{ ticks:{ beginAtZero:true, precision:0, padding:10, maxTicksLimit:8 },
          gridLines:{ color: MF.grid, zeroLineColor: MF.grid, drawBorder:false }
        }]
      },
      hover:{ animationDuration:300 }
    }
  });

  async function loadInvTypeCountsByGong(gong) {
    if (!gong) return;
    const base = @json(route('dashboard.invTypeCounts', [], false)); // << relative
    const url  = `${base}?gong=${encodeURIComponent(gong)}`;
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
