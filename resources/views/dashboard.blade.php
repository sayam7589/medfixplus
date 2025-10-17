@extends('layouts.adminlte')

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

      {{-- ===== กราฟหลัก (Hero) : หน่วยงาน × ประเภท ===== --}}
      <div class="card card-success">
        <div class="card-header d-flex align-items-center">
          <h3 class="card-title">จำนวนอุปกรณ์แยกตามประเภท (หน่วยงาน)</h3>
          <div class="card-tools" style="min-width:320px;">
            <select id="deptFilter" class="form-control form-control-sm">
              @foreach($departments as $dep)
                <option value="{{ $dep->id }}">{{ $dep->gong }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="card-body">
          <div id="heroLoading" class="text-muted mb-2" style="display:none;">กำลังโหลดข้อมูล…</div>
          <canvas id="invByDeptTypeBar" style="min-height:420px;height:420px;max-height:520px;"></canvas>
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

      {{-- สรุปตัวเลข --}}
      <div class="row">
        <div class="col-lg-3 col-6">
          <div class="small-box bg-warning"><div class="inner"><h3>{{ $medfix_count }}</h3><p>รายการแจ้งซ่อม</p></div><div class="icon"><i class="ion ion-bag"></i></div></div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="small-box bg-success"><div class="inner"><h3>{{ $inventory_count }}</h3><p>รายการสินทรัพย์</p></div><div class="icon"><i class="ion ion-stats-bars"></i></div></div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="small-box bg-danger"><div class="inner"><h3>{{ $project_count }}</h3><p>โครงการจัดซื้อ</p></div><div class="icon"><i class="ion ion-person-add"></i></div></div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="small-box bg-info"><div class="inner"><h3>{{ $user_count }}</h3><p>ผู้ใช้งาน</p></div><div class="icon"><i class="ion ion-pie-graph"></i></div></div>
        </div>
      </div>

      {{-- กราฟ/ตารางอื่น ๆ ของคุณต่อจากนี้ --}}
      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header"><h3 class="card-title">สถิติการซ่อม</h3></div>
            <div class="card-body"><canvas id="areaChart" style="min-height:250px;height:250px;"></canvas></div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="card">
            <div class="card-header"><h3 class="card-title">ปัญหาที่พบบ่อย</h3></div>
            <div class="card-body p-0">
              <table class="table table-striped">
                <thead><tr><th style="width:10px">#</th><th>ปัญหา</th><th style="width:40%"></th><th>จำนวน</th><th style="width:40px">%</th></tr></thead>
                <tbody>
                  @foreach($repairsByIssue as $i=>$r)
                    <tr>
                      <td>{{ $i+1 }}</td>
                      <td>{{ $r->issue_name }}</td>
                      <td><div class="progress progress-xs"><div class="progress-bar progress-bar-danger" style="width: {{ $r->successful_repairs ? 100 : 0 }}%"></div></div></td>
                      <td><span class="badge bg-info">{{ $r->successful_repairs }}</span></td>
                      <td><span class="badge bg-danger">{{ $r->successful_repairs ? 100 : 0 }}%</span></td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
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
  // ===== HERO CHART =====
  var invByDeptChart;

  async function loadInvByDeptChart(deptId){
    const canvas = document.getElementById('invByDeptTypeBar');
    $('#heroLoading').show();

    if (invByDeptChart) { invByDeptChart.destroy(); invByDeptChart = null; }
    if (!deptId) { fillDeptTable([],0); $('#heroLoading').hide(); return; }

    try{
      const url = `{{ url('/charts/inventory/bydept') }}?dept_id=${encodeURIComponent(deptId)}`;
      const res = await fetch(url, { headers: { 'X-Requested-With':'XMLHttpRequest' }});
      const json = await res.json();

      invByDeptChart = new Chart(canvas.getContext('2d'), {
        type: 'bar',
        data: {
          labels: json.labels,
          datasets: [{
            label: 'จำนวน (เครื่อง)',
            data: json.data,
            backgroundColor: 'rgba(60,141,188,0.8)',
            borderColor: 'rgba(60,141,188,1)',
            borderWidth: 1
          }]
        },
        options: {
          maintainAspectRatio:false, responsive:true, legend:{display:false},
          tooltips:{mode:'index', intersect:false},
          scales:{ xAxes:[{gridLines:{display:false}}],
                   yAxes:[{ticks:{beginAtZero:true, precision:0}}] }
        }
      });

      fillDeptTable(json.rows||[], json.total||0);
    }catch(e){
      console.error('hero chart error:', e);
      fillDeptTable([],0);
    }finally{
      $('#heroLoading').hide();
    }
  }

  function fillDeptTable(rows,total){
    const tbody = $('#deptTypeTable tbody'); tbody.empty();
    if (!rows.length) {
      tbody.append('<tr><td colspan="2" class="text-center text-muted">— ไม่มีข้อมูล —</td></tr>');
    } else {
      rows.forEach(r => tbody.append(`<tr><td>${r.type_name}</td><td class="text-right">${parseInt(r.total,10)}</td></tr>`));
    }
    $('#deptTypeTotal').text(parseInt(total,10));
  }

  // preload: เลือก option แรก แล้วโหลดกราฟทันที
  const firstVal = $('#deptFilter option:first').val();
  if (firstVal) { $('#deptFilter').val(firstVal); loadInvByDeptChart(firstVal); }

  // เปลี่ยนหน่วยงาน → โหลดใหม่
  $('#deptFilter').on('change', function(){ loadInvByDeptChart($(this).val()); });

  // ===== กราฟซ่อมเดิม (ย่อ) =====
  var labels = {!! json_encode($repairs->pluck('month_thai')) !!};
  var data   = {!! json_encode($repairs->pluck('total_repairs')) !!};
  new Chart(document.getElementById('areaChart').getContext('2d'), {
    type:'line',
    data:{ labels, datasets:[{ label:'จำนวนการแจ้งซ่อม', data,
      backgroundColor:'rgba(60,141,188,0.9)', borderColor:'rgba(60,141,188,0.8)', pointRadius:false }]},
    options:{ maintainAspectRatio:false, responsive:true, legend:{display:false},
      scales:{ xAxes:[{gridLines:{display:false}}], yAxes:[{gridLines:{display:false}}] } }
  });
});
</script>
@endsection
