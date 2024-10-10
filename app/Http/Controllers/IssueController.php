<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use Illuminate\Http\Request;

class IssueController extends Controller
{
    public function create()
    {
        $issues = Issue::all();

        $title = '! WARNING !';
        $text = "คุณต้องการลบชื่อยี่ห้อนี้ใช่หรือไม่";
        confirmDelete($title, $text);

        return view('problem.issue', compact('issues'));
    }

    public function store(Request $request)
    {
        //dd($request->issue);
        $request->validate([
            'issue_name' => 'required|string',
        ]);

        $Issue = Issue::create([
            'issue_name' => $request->issue_name,
            'issue_detail' => $request->issue_name,
            'inv_type'=> '0',
        ]);
        toast('บันทึกข้อมูลเสร็จสิ้น!','success');
        return redirect()->route('problem_issue.create');
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
            'issue' => 'required|string',
        ]);

        $issue = Issue::findOrFail($id);
        $issue->update([
            'issue_name' => $request->issue,
            'issue_detail' => $request->issue,
            'inv_type'=> '0',
        ]);
        toast('บันทึกข้อมูลเสร็จสิ้น!','success');
        return redirect()->route('problem_issue.create');
    }
    public function destroy($id)
    {
        $issue = Issue::findOrFail($id);
        $issue->delete();

        toast('ลบข้อมูลเสร็จสิ้น!','success');
        return redirect()->route('problem_issue.create');
    }
}
