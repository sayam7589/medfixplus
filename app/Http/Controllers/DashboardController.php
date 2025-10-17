<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Medfix;
use App\Models\Prefix;
use App\Models\PersonalHasInv;
Use Alert;
use App\Models\Department;
use App\Models\Inventory;
use App\Models\Project;
use App\Models\User;
use DB;


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
            ->whereYear('medfix_date', \Carbon\Carbon::now()->year) // ปีปัจจุบัน
            ->groupBy('department.gong')
            ->orderBy('total_repairs', 'desc')
            ->get();

        $totalRepairs = DB::table('medfix')
            ->whereYear('medfix_date', \Carbon\Carbon::now()->year) // ปีปัจจุบัน
            ->where('medfix_status', '=', 1)
            ->count();

        $repairsByIssue = DB::table('medfix')
            ->join('issue', 'medfix.issue_id', '=', 'issue.id')
            ->select('issue.issue_name', DB::raw('SUM(CASE WHEN medfix_status = 1 THEN 1 ELSE 0 END) AS successful_repairs'))
            ->selectRaw('ROUND((SUM(CASE WHEN medfix_status = 1 THEN 1 ELSE 0 END) / ?) * 100, 2) AS percentage', [$totalRepairs]) // คำนวณเปอร์เซ็นต์
            ->whereYear('medfix_date', \Carbon\Carbon::now()->year) // ปีปัจจุบัน
            ->groupBy('issue.issue_name')
            ->orderBy('successful_repairs', 'desc')
            ->get();
        //dd($repairsByIssue);
        $medfix_count = Medfix::count();
        $inventory_count = Inventory::count();
        $project_count = Project::count();
        $user_count = User::count();
        $user = Auth::user();


        return view('dashboard', compact('user', 'medfix_count', 'inventory_count', 'project_count', 'user_count', 'user', 'repairs', 'repairs_2', 'repairsByIssue'));
    }

}
