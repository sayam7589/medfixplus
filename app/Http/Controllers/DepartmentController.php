<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->input('query');

        // Query ข้อมูลจากตาราง department ทุกคอลัมน์ที่มีข้อมูลตรงกับ keyword
        $departments = Department::where('grom', 'like', "%{$search}%")
            ->orWhere('gong', 'like', "%{$search}%")
            ->orWhere('panag', 'like', "%{$search}%")
            ->orWhere('fay', 'like', "%{$search}%")
            ->orWhere('short_name', 'like', "%{$search}%")
            ->get(['id', 'grom', 'gong', 'panag', 'fay']); // ดึงข้อมูล 'id' มาด้วย

        return response()->json($departments);
    }
}
