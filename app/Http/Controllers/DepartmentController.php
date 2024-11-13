<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Inventory;
use App\Models\Project;
use App\Models\Inventory_brand;
use App\Models\Inventory_type;
use App\Models\Prefix;
use App\Models\Medfix;
use Illuminate\Support\Facades\DB;
Use Alert;
use App\Models\Issue;
use App\Models\Solving;


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

    public function create()
    {
        $departments = Department::all();
        $gongs = Department::select('gong')->distinct()->get();

        $title = '! WARNING !';
        $text = "คุณต้องการลบชื่อยี่ห้อนี้ใช่หรือไม่";
        confirmDelete($title, $text);

        return view('department.create', compact('departments','gongs'));
    }

    public function store(Request $request)
    {
        dd($request);
        $request->validate([
            'gong' => 'required|string',
            'panag' => 'nullable|string',
        ]);
        
        $department = Department::create([
            'grom' => 'พอ.',
            'gong' => $request->gong,
            'panag' => $request->panag,
        ]);

        toast('บันทึกข้อมูล เสร็จสิ้น!','success');
        return redirect()->route('department.create');
    }

    /**
     * Update the specified project in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inventory  $project
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        $request->validate([
            'gong' => 'required|string',
            'panang' => 'nullable|string',
        ]);

        $department = Department::findOrFail($id);
        $department->update([
            'grom' => 'พอ.',
            'gong' => $request->gong,
            'panag' => $request->panag,
        ]);
        toast('บันทึกข้อมูลเสร็จสิ้น!','success');
        return redirect()->route('department.create');
    }
    public function destroy($id)
    {
        $brand = Department::findOrFail($id);
        $brand->delete();

        toast('ลบข้อมูลเสร็จสิ้น!','success');
        return redirect()->route('department.create');
    }
}

