<?php

namespace App\Http\Controllers;

use App\Models\Solving;
use Illuminate\Http\Request;

class SolvingController extends Controller
{
    public function create()
    {
        $solvings = Solving::all();

        $title = '! WARNING !';
        $text = "คุณต้องการลบชื่อยี่ห้อนี้ใช่หรือไม่";
        confirmDelete($title, $text);

        return view('problem.solving', compact('solvings'));
    }

    public function store(Request $request)
    {
        //dd($request->Solving);
        $request->validate([
            'solving_title' => 'required|string',
        ]);

        $solving = Solving::create([
            'solving_title' => $request->solving_title,
        ]);
        toast('บันทึกข้อมูล เสร็จสิ้น!','success');
        return redirect()->route('problem_solving.create');
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
            'solving' => 'required|string',
        ]);

        $solving = Solving::findOrFail($id);
        $solving->update([
            'solving_title' => $request->solving,
        ]);
        toast('บันทึกข้อมูล เสร็จสิ้น!','success');
        return redirect()->route('problem_solving.create');
    }
    public function destroy($id)
    {
        $solving = Solving::findOrFail($id);
        $solving->delete();

        toast('ลบข้อมูล เสร็จสิ้น!','success');
        return redirect()->route('problem_solving.create');
    }
}
