<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
Use Alert;



class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::all();

        // if($check){
        //     toast('ลบข้อมูลสำเร็จเเล้วนะจ๊ะ', 'success');
        //     return redirect()->route('projects.index');
        // }

        // else{
        //     toast('WTF','error');
        //     return redirect()->route('projects.index');
        // }

        return view('projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
        //////
    }

    public function delete($id)
    {
        //ประกาศ confirmdelete ก่อน !!!!!!!
        $title = ' คำเตือน ';
        $text = "ข้อมูลสินทัพย์ในโครงการนี้จะถูกลบทั้งหมด คุณต้องการลบโครงการนี้ใช่หรือไม่";
        confirmDelete($title, $text);

        $project = Project::findOrFail($id);
        return view('projects.delete', compact('project'));
        
    }

    
    public function confirm($id)
    {           
            
            $del = Project::findOrFail($id);
            $check = $del->delete();


            if($check){
                toast('ลบข้อมูลสำเร็จเเล้วนะจ๊ะ', 'success');
                return redirect()->route('projects.index');
            }

            else{
                toast('ลบข้อมูลไม่สำเร็จนะจ๊ะ', 'error');
                return redirect()->route('projects.index');
            }

    }


    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'project_name' => 'required|string|max:255',
            'project_detail' => 'nullable|string|max:255',
            'project_company' => 'required|string|max:255',
            'project_company_contact' => 'required|string|max:255',
            'project_file' => 'nullable|string|max:255',
            'project_date' => 'required|date',
        ]);

        $check = Project::create($request->all());

        if($check){
            //toast('บันทึกโครงการสำเร็จเเล้วนะจ๊ะ','success');
            toast('เพิ่มโครงการสำเร็จเเล้วนะจ๊ะ','success');
            return redirect()->route('projects.index');
        }

        else{
            toast('เพิ่มโครงการไม่สำเร็จได้นะจ๊ะ', 'error');
            return redirect()->back()->withInput();
        }

    }

    /**
     * Show the form for editing the specified project.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {

        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified project in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'project_name' => 'required|string|max:255',
            'project_detail' => 'required|string',
            'project_company' => 'required|string|max:255',
            'project_company_contact' => 'required|string|max:255',
            'project_file' => 'nullable|string|max:255',
            'project_date' => 'required|date',
        ]);

        $check = $project->update($request->all());

        if($check){
            toast('บันทึกข้อมูลสำเร็จเเล้วนะจ๊ะ','success');
            return redirect()->route('projects.index');
        }

        else{
            toast('เพิ่มโครงการไม่สำเร็จนะจ๊ะ', 'error');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified project from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
       
            $check = $project->delete();
      
            if($check){
                toast('ลบข้อมูลสำเร็จเเล้วนะจ๊ะ', 'success');
                return redirect()->route('projects.index');
            }
            else{
                toast('ลบข้อมูลไม่สำเร็จนะจ๊ะ', 'error');
                return redirect()->back()->withInput();
            }
    }
    

}