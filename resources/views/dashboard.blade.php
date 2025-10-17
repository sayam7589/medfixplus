@extends('layouts.adminlte')

@section('style')
{{-- เพิ่ม style ได้ตามต้องการ --}}
@endsection

@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6"><h1>Dashboard</h1></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">

      {{-- สรุปตัวเลข --}}
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
        {{-- ซ้าย: กราฟซ่อมเดิม --}}
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">สถิติการซ่อม</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
              </div>
            </div>
            <div class="card-body">
              <canvas id="areaChart" style="min-height:250px;height:250px;max-height:250px;max-width:100%;"></canvas>
            </div>
          </div>
        </div>

        {{-- ขวา: ปัญหาที่พบบ่อย + การ์ดใหม่เลือกหน่วยงาน --}}
        <div class="col-md-6">
          <div class="card">
            <div class="card-header"><h3 class="card-title">ปัญหาที่พบบ่อย</h3></div>
            <div class="card-body p-0">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th style="width:10px">#</th>
                    <th>ปัญหาการซ่อม</th>
                    <th style="width:40%"></th>
                    <th>จำนวนครั้ง</th>
                    <th style="width:40px">ร้อยละ</th>
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

          {{-- การ์ดใหม่: เลือกหน่วยงาน → กราฟ/ตาราง --}}
          <div class="card card-success">
            <div class="card-header d-flex align-items-center">
              <h3 class="card-title">จำนวนอุปกรณ์แยกตามประเภท (เลือกหน่วยงาน)</h3>
              <div class="card-tools" style="min-width:280px;">
                <select id="deptFilter" class="form-control form-control-sm">
                  <option value="">-- เลือกหน่วยงาน --</option>
                  @foreach($departments as $dep)
                    <option value="{{ $dep->id }}">{{ $dep->gong }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="card-body">
              <canvas id="invByDeptTypeBar" style="min-height:320px;height:320px;max-height:320px;"></canvas>
              <hr>
              <div class="table-responsive">
                <table class="table table-striped table-sm mb-0" id="deptTypeTable">
                  <thead>
                    <tr><th style="width:60%;">ประเภทอุปกรณ์</th><th class="text-right">จำนวน</th></tr>
                  </thead>
                  <tbody></tbody>
                  <tfoot>
                    <tr><th class="text-right">รวมทั้งหมด</th><th class="text-right" id="deptTypeTotal">0</th></tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>

        </div>
      </div>

    </div>
  </section>
</div>
@endsection

@section('scripts')
<script src="{{ asset('adminlte/plugins/chart.js/Chart.min.js') }}"></script>
<script>
$(function () {
  /* ===== กราฟซ่อมเดิม ===== */
  var labels = {!! json_encode($repairs->pluck('month_thai')) !!};
  var data   = {!! json_encode($repairs->pluck('total_repairs')) !!};
  var ctxA   = document.getElementById('areaChart').getContext('2d');
  new Chart(ctxA, {
    type: 'line',
    data: { labels: labels, datasets: [{
      label: 'จำนวนการแจ้งซ่อม',
      data: data,
      backgroundColor: 'rgba(60,141,188,0.9)',
      borderColor: 'rgba(60,141,188,0.8)',
      pointRadius: false
    }] },
    options: { maintainAspectRatio:false, responsive:true, legend:{display:false},
      scales:{ xAxes:[{gridLines:{display:false}}], yAxes:[{gridLines:{display:false}}] } }
  });

  /* ===== กราฟ/ตารางอุปกรณ์ตามประเภทในหน่วยงานที่เลือก ===== */
  var invByDeptChart;

  $('#deptFilter').on('change', function () {
    const deptId = $(this).val();
    loadInvByDeptChart(deptId);
  });

  async function loadInvByDeptChart(deptId){
    const canvas = document.getElementById('invByDeptTypeBar');
    if (invByDeptChart) { invByDeptChart.destroy(); invByDeptChart = null; }

    if (!deptId) { fillDeptTable([], 0); return; }

    try {
      const url = `{{ url('/charts/inventory/by-dept') }}?dept_id=${encodeURIComponent(deptId)}`;
      const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
      const json = await res.json();

      invByDeptChart = new Chart(canvas.getContext('2d'), {
        type: 'bar',
        data: { labels: json.labels, datasets: [{
          label: 'จำนวน (เครื่อง)',
          data: json.data,
          backgroundColor: 'rgba(60,141,188,0.8)',
          borderColor: 'rgba(60,141,188,1)',
          borderWidth: 1
        }]},
        options: {
          maintainAspectRatio:false, responsive:true, legend:{display:false},
          tooltips:{mode:'index', intersect:false},
          scales:{ xAxes:[{gridLines:{display:false}}],
                   yAxes:[{ticks:{beginAtZero:true, precision:0}}] }
        }
      });

      fillDeptTable(json.rows || [], json.total || 0);

    } catch (e) {
      console.error(e);
      fillDeptTable([], 0);
    }
  }

  function fillDeptTable(rows, total){
    const tbody = $('#deptTypeTable tbody');
    tbody.empty();
    if (!rows.length) {
      tbody.append('<tr><td colspan="2" class="text-center text-muted">— ไม่มีข้อมูล —</td></tr>');
      $('#deptTypeTotal').text('0');
      return;
    }
    rows.forEach(r => {
      tbody.append(`<tr><td>${r.type_name}</td><td class="text-right">${parseInt(r.total,10)}</td></tr>`);
    });
    $('#deptTypeTotal').text(parseInt(total, 10));
  }

  // ถ้าต้องการ preload ตัวแรก: ปลดคอมเมนต์สองบรรทัดล่าง
  // const firstVal = $('#deptFilter option:eq(1)').val();
  // if (firstVal) { $('#deptFilter').val(firstVal).trigger('change'); }
});
</script>
@endsection
