<?php

// app/Http/Controllers/DashboardController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Medfix;
use App\Models\Inventory;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        // --- ของเดิม (คงไว้) ---
        $repairs = DB::table('medfix')
            ->selectRaw('MONTH(medfix_date) AS month, YEAR(medfix_date) AS year, COUNT(*) AS total_repairs')
            ->selectRaw('SUM(CASE WHEN medfix_status = 1 THEN 1 ELSE 0 END) AS successful_repairs')
            ->where('medfix_date', '>=', \Carbon\Carbon::now()->subMonths(7))
            ->groupBy(DB::raw('YEAR(medfix_date), MONTH(medfix_date)'))
            ->orderBy('year')->orderBy('month')
            ->get();

        $repairs->transform(function ($item) {
            $item->month_thai = function_exists('getThaiMonthAbbreviation')
                ? getThaiMonthAbbreviation($item->month) : $item->month;
            return $item;
        });

        $repairs_2 = DB::table('medfix')
            ->join('department', 'medfix.medfix_user_org', '=', 'department.id')
            ->select('department.gong', DB::raw('COUNT(*) AS total_repairs'))
            ->selectRaw('SUM(CASE WHEN medfix_status = 1 THEN 1 ELSE 0 END) AS successful_repairs')
            ->whereYear('medfix_date', \Carbon\Carbon::now()->year)
            ->groupBy('department.gong')
            ->orderBy('total_repairs', 'desc')
            ->get();

        $totalRepairs = DB::table('medfix')
            ->whereYear('medfix_date', \Carbon\Carbon::now()->year)
            ->where('medfix_status', 1)
            ->count();

        $repairsByIssue = DB::table('medfix')
            ->join('issue', 'medfix.issue_id', '=', 'issue.id')
            ->select('issue.issue_name', DB::raw('SUM(CASE WHEN medfix_status = 1 THEN 1 ELSE 0 END) AS successful_repairs'))
            ->selectRaw('ROUND((SUM(CASE WHEN medfix_status = 1 THEN 1 ELSE 0 END) / ?) * 100, 2) AS percentage', [$totalRepairs ?: 1])
            ->whereYear('medfix_date', \Carbon\Carbon::now()->year)
            ->groupBy('issue.issue_name')
            ->orderBy('successful_repairs', 'desc')
            ->get();

        $medfix_count    = Medfix::count();
        $inventory_count = Inventory::count();
        $project_count   = Project::count();
        $user_count      = User::count();
        $user            = Auth::user();

        // --- ดึงรายชื่อหน่วยงานแบบไม่ซ้ำ (กัน dropdown ซ้ำ) ---
        $departments = DB::table('department')
            ->selectRaw('MIN(id) AS id, gong')
            ->groupBy('gong')
            ->orderBy('gong')
            ->get();

        return view('dashboard', compact(
            'user', 'medfix_count', 'inventory_count', 'project_count',
            'user_count', 'repairs', 'repairs_2', 'repairsByIssue', 'departments'
        ));
    }

    /**
     * AJAX: จำนวนอุปกรณ์แยกตามประเภทภายในหน่วยงานที่เลือก
     * รองรับทั้งกรองด้วย department.id หรือด้วยชื่อหน่วยงาน (กรณี inventory.rec_organize เก็บชื่อ)
     */
    public function inventoryByDeptType(Request $request)
    {
        $deptId = $request->integer('dept_id');
        if (!$deptId) {
            return response()->json(['labels'=>[], 'data'=>[], 'total'=>0, 'rows'=>[]]);
        }

        // 1) แปลง id -> ชื่อหน่วยงาน (gong)
        $deptName = DB::table('department')->where('id', $deptId)->value('gong');
        if (!$deptName) {
            return response()->json(['labels'=>[], 'data'=>[], 'total'=>0, 'rows'=>[]]);
        }

        // 2) JOIN รองรับทั้ง rec_organize = id หรือ = gong แล้ว "กรองด้วยชื่อหน่วยงาน"
        $rows = DB::table('inventory')
            ->join('department', function ($j) {
                $j->on('inventory.rec_organize', '=', 'department.id')
                ->orOn('inventory.rec_organize', '=', 'department.gong');
            })
            ->leftJoin('inventory_type','inventory_type.id','=','inventory.inv_type')
            ->where('department.gong', $deptName)   // << เปลี่ยนจุดนี้จาก where id เป็น where gong
            ->select([
                DB::raw('COALESCE(inventory_type.type_name, inventory.inv_type) AS type_name'),
                DB::raw('COUNT(*) AS total'),
            ])
            ->groupBy('type_name')
            ->orderBy('total','desc')
            ->get();

        $labels = collect($rows)->pluck('type_name')->values();
        $data   = collect($rows)->pluck('total')->map(fn($v)=>(int)$v)->values();

        return response()->json([
            'labels' => $labels,
            'data'   => $data,
            'total'  => $data->sum(),
            'rows'   => $rows,
            // 'debug' => ['dept_id'=>$deptId, 'dept_name'=>$deptName], // อยากดีบักค่อยปลดได้
        ]);
    }
}