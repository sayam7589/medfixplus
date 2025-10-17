<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

use App\Models\Medfix;
use App\Models\Inventory;
use App\Models\Project;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // ===== สถิติการซ่อม (ของเดิม) =====
        $repairs = DB::table('medfix')
            ->selectRaw('MONTH(medfix_date) AS month, YEAR(medfix_date) AS year, COUNT(*) AS total_repairs')
            ->selectRaw('SUM(CASE WHEN medfix_status = 1 THEN 1 ELSE 0 END) AS successful_repairs')
            ->where('medfix_date', '>=', \Carbon\Carbon::now()->subMonths(7))
            ->groupBy(DB::raw('YEAR(medfix_date), MONTH(medfix_date)'))
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        // เพิ่มชื่อเดือนย่อไทย (สมมติว่ามี helper getThaiMonthAbbreviation)
        $repairs->transform(function ($item) {
            if (function_exists('getThaiMonthAbbreviation')) {
                $item->month_thai = getThaiMonthAbbreviation($item->month);
            } else {
                $item->month_thai = $item->month; // fallback
            }
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
            ->where('medfix_status', '=', 1)
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

        // ===== Dropdown หน่วยงาน (ใช้ตาราง department; คอลัมน์ 'gong' คือชื่อหน่วยงาน) =====
        $departments = DB::table('department')
            ->select('id', 'gong')
            ->orderBy('gong')
            ->get();

        return view('dashboard', compact(
            'user', 'medfix_count', 'inventory_count', 'project_count',
            'user_count', 'repairs', 'repairs_2', 'repairsByIssue', 'departments'
        ));
    }

    /**
     * AJAX: จำนวนอุปกรณ์แยกตาม "ประเภท" ภายใน "หน่วยงานที่เลือก"
     * GET /charts/inventory/by-dept?dept_id={id}
     * Response: { labels: [...], data: [...], total: N, rows: [{type_name, total}] }
     */
    public function inventoryByDeptType(Request $request)
    {
        $deptId = $request->integer('dept_id');
        if (!$deptId) {
            return response()->json([
                'labels' => [], 'data' => [], 'total' => 0, 'rows' => []
            ]);
        }

        $cacheKey = 'chart:inv_by_dept_type:' . $deptId;
        $rows = Cache::remember($cacheKey, 300, function () use ($deptId) {
            return DB::table('inventory')
                ->leftJoin('inventory_type', 'inventory_type.id', '=', 'inventory.inv_type')
                ->where('inventory.rec_organize', $deptId) // FK ไป department.id
                ->select([
                    DB::raw('COALESCE(inventory_type.type_name, inventory.inv_type) AS type_name'),
                    DB::raw('COUNT(*) AS total'),
                ])
                ->groupBy('type_name')
                ->orderBy('total', 'desc')
                ->get();
        });

        $labels = collect($rows)->pluck('type_name')->values();
        $data   = collect($rows)->pluck('total')->map(fn($v)=>(int)$v)->values();
        $total  = $data->sum();

        return response()->json([
            'labels' => $labels,
            'data'   => $data,
            'total'  => $total,
            'rows'   => $rows,
        ]);
    }
}
