<?php

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
        $repairs = DB::table('medfix')
            ->selectRaw('MONTH(medfix_date) AS month, YEAR(medfix_date) AS year, COUNT(*) AS total_repairs')
            ->selectRaw('SUM(CASE WHEN medfix_status = 1 THEN 1 ELSE 0 END) AS successful_repairs')
            ->where('medfix_date', '>=', \Carbon\Carbon::now()->subMonths(7))
            ->groupBy(DB::raw('YEAR(medfix_date), MONTH(medfix_date)'))
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        $repairs->transform(function ($item) {
            $item->month_thai = getThaiMonthAbbreviation($item->month);
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
            ->selectRaw('ROUND((SUM(CASE WHEN medfix_status = 1 THEN 1 ELSE 0 END) / ?) * 100, 2) AS percentage', [$totalRepairs])
            ->whereYear('medfix_date', \Carbon\Carbon::now()->year)
            ->groupBy('issue.issue_name')
            ->orderBy('successful_repairs', 'desc')
            ->get();

        $medfix_count    = Medfix::count();
        $inventory_count = Inventory::count();
        $project_count   = Project::count();
        $user_count      = User::count();
        $user            = Auth::user();

        // ✅ รายการหน่วยงานสำหรับ Dropdown
        $departments = DB::table('department')
            ->select('id', 'gong') // 👈 ถ้าชื่อคอลัมน์ต่างไป แก้ตรงนี้
            ->orderBy('gong')
            ->get();

        return view('dashboard', compact(
            'user', 'medfix_count', 'inventory_count', 'project_count',
            'user_count', 'repairs', 'repairs_2', 'repairsByIssue', 'departments'
        ));
    }

    // ✅ API สำหรับกราฟ (All orgs = stacked, Selected org = single)
    public function inventoryByOrgType(Request $request)
    {
        $orgId = $request->integer('org_id'); // optional

        // ฐาน JOIN เพื่อดึงชื่อแสดงผล
        $base = DB::table('inventory')
            ->leftJoin('department', 'department.id', '=', 'inventory.rec_organize')
            ->leftJoin('inventory_type', 'inventory_type.id', '=', 'inventory.inv_type');

        if ($orgId) {
            // โหมด: เลือกหน่วยงานเดียว → กราฟแท่งเดียว (แกน X = ประเภท)
            $query = (clone $base)
                ->where('inventory.rec_organize', $orgId)
                ->select([
                    DB::raw('COALESCE(inventory_type.type_name, inventory.inv_type) as type_name'), // 👈 แก้ชื่อคอลัมน์ตามจริง
                    DB::raw('COUNT(*) as total')
                ])
                ->groupBy('type_name');

            $rows = Cache::remember("chart:inv_by_type:org:$orgId", 300, fn () => $query->get());

            $labels = collect($rows)->pluck('type_name')->values();
            $data   = collect($rows)->pluck('total')->map(fn($v)=>(int)$v)->values();

            // ชื่อหน่วยงานไว้เป็น label dataset
            $deptName = DB::table('department')->where('id', $orgId)->value('gong'); // 👈 แก้คอลัมน์ถ้าจำเป็น

            return response()->json([
                'mode'     => 'single',
                'labels'   => $labels,    // inv_type
                'datasets' => [[
                    'label' => $deptName ?: 'หน่วยงานที่เลือก',
                    'data'  => $data,
                ]],
            ]);
        }

        // โหมด: ทุกหน่วยงาน → Stacked Bar (แกน X = หน่วยงาน, dataset = ประเภท)
        $query = (clone $base)
            ->select([
                DB::raw('COALESCE(department.gong, inventory.rec_organize) as dept_name'),     // 👈 แก้ชื่อคอลัมน์ตามจริง
                DB::raw('COALESCE(inventory_type.type_name, inventory.inv_type) as type_name'), // 👈 แก้ชื่อคอลัมน์ตามจริง
                DB::raw('COUNT(*) as total')
            ])
            ->groupBy('dept_name', 'type_name');

        $rows = Cache::remember('chart:inv_by_org_type:all', 300, fn () => $query->get());

        $orgs  = collect($rows)->pluck('dept_name')->unique()->values();
        $types = collect($rows)->pluck('type_name')->unique()->values();

        $matrix = [];
        foreach ($types as $t) $matrix[$t] = array_fill(0, $orgs->count(), 0);
        foreach ($rows as $r) {
            $i = $orgs->search($r->dept_name);
            $matrix[$r->type_name][$i] = (int) $r->total;
        }

        return response()->json([
            'mode'     => 'stacked',
            'labels'   => $orgs,  // หน่วยงาน
            'datasets' => $types->map(fn ($t) => [
                'label' => $t,
                'data'  => $matrix[$t],
                'stack' => 'inv_type_stack',
            ])->values(),
        ]);
    }
}
