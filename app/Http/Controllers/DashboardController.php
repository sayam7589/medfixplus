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

        return view('dashboard', compact(
            'user', 'medfix_count', 'inventory_count', 'project_count',
            'user_count', 'repairs', 'repairs_2', 'repairsByIssue'
        ));
    }

    // ✅ เมธอดสำหรับกราฟ AJAX
    public function inventoryByOrgType(Request $request)
    {
        $year  = $request->integer('year');   // optional
        $month = $request->integer('month');  // optional

        // JOIN ตารางสำหรับชื่อแสดงผล
        $query = DB::table('inventory')
            ->leftJoin('department', 'department.id', '=', 'inventory.rec_organize')
            ->leftJoin('inventory_type', 'inventory_type.id', '=', 'inventory.inv_type')
            ->select([
                DB::raw('COALESCE(department.gong, inventory.rec_organize) AS dept_name'),   // 👈 เปลี่ยนเป็นชื่อคอลัมน์จริงได้
                DB::raw('COALESCE(inventory_type.type_name, inventory.inv_type) AS type_name'), // 👈 เปลี่ยนเป็นชื่อคอลัมน์จริงได้
                DB::raw('COUNT(*) AS total')
            ])
            ->groupBy('dept_name', 'type_name');

        // ถ้ามีคอลัมน์วันที่ (เช่น created_at) ให้ปลดคอมเมนต์และปรับชื่อ
        // if ($year)  $query->whereYear('inventory.created_at', $year);
        // if ($month) $query->whereMonth('inventory.created_at', $month);

        // แคช 5 นาที (ตามพารามิเตอร์กรอง)
        $cacheKey = 'chart:inv_by_org_type:' . md5(json_encode([$year, $month]));
        $rows = Cache::remember($cacheKey, 300, fn () => $query->get());

        // เตรียมข้อมูลสำหรับ Chart.js
        $orgs  = collect($rows)->pluck('dept_name')->unique()->values();
        $types = collect($rows)->pluck('type_name')->unique()->values();

        $matrix = [];
        foreach ($types as $t) $matrix[$t] = array_fill(0, $orgs->count(), 0);

        foreach ($rows as $r) {
            $orgIndex = $orgs->search($r->dept_name);
            $matrix[$r->type_name][$orgIndex] = (int) $r->total;
        }

        return response()->json([
            'labels'   => $orgs,
            'datasets' => $types->map(fn ($t) => [
                'label' => $t,
                'data'  => $matrix[$t],
                'stack' => 'inv_type_stack',
            ])->values(),
        ]);
    }
}
