<?php

namespace App\Http\Controllers;

use App\Models\Medfix;
use App\Models\Prefix;
use App\Models\PersonalHasInv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
Use Alert;
use App\Models\Department;
use App\Models\Inventory;
use App\Models\MedfixFullView;

class MedfixController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $roles = $user->getRoleNames();

        $title = '! WARNING !';
        $text = "คุณต้องการลบรายการนี้ใช่หรือไม่";
        confirmDelete($title, $text);
        //$medfixes = MedfixFullView::whereIn('dep_short_name', $roles)->orderBy('id', 'asc')->get();
        $medfixes = Medfix::leftJoin('view_inventory_department as vid', 'medfix.inv_id', '=', 'vid.id')
                    ->select('medfix.*', 'vid.dep_short_name')
                    ->whereIn('vid.dep_short_name', $roles)
                    ->get();
        return view('medfix.index', compact('medfixes'));
    }

    public function create()
    {
        return view('medfix.create');
    }

    public function store(Request $request, $invid)
    {
        //dd($invid);
        $imagePath = 0;
        $request->validate([
            'medfix_owner_prefix' => 'required',
            'medfix_owner_fname' => 'required',
            'medfix_owner_lname' => 'required',
            'department_id1' => 'required',
            'medfix_detail' => 'required',
            'medfix_tel' => 'required',
            'medfix_pic' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
        //dd($request->medfix_pic);
        if($request->medfix_pic != null){
            //dd($request->medfix_pic);
            $imagePath = $request->file('medfix_pic')->store('images', 'public');
        }
        $dataset = ([
            'inv_id' => $invid,

            'medfix_owner_prefix' => $request->medfix_owner_prefix,
            'medfix_owner_fname' => $request->medfix_owner_fname,
            'medfix_owner_lname' => $request->medfix_owner_lname,
            'medfix_user_id' => Auth::user()->id,
            'medfix_user_org' => $request->department_id1,

            'medfix_detail' => $request->medfix_detail,
            'medfix_tel' => $request->medfix_tel,
            'medfix_pic' => $imagePath,

            'medfix_ticket_date' => date('Y-m-d H:i:s'),
            'medfix_technician_user_id' => Auth::user()->id,
            'issue_id' => 1,
            'solving_id' => 1,
            'medfix_technician_comment' => 0,
            'medfix_upgrade_equipment' => 1,
            'medfix_upgrade_detail' => 0,
            'medfix_status' => 0,
            'medfix_date' => date('Y-m-d H:i:s'),
        ]);
        //dd($dataset);
        if($medfix = Medfix::create($dataset)){
            Alert::success('ดำเนินการ เสร็จสิ้น!', 'บันทึกข้อมูลเสร็จสิ้น');
            $title = "🔧🔧 แจ้งซ่อม‼ 🔧🔧";
            $person = "👤: ".getPrefixShortById($request->medfix_owner_prefix).$request->medfix_owner_fname." ".$request->medfix_owner_lname;
            $invname = "💻: ".getInvDetailsById($invid);
            $from = "📍: ".getPanakGongById($request->department_id1);
            $detail = "📋: ".$request->medfix_detail;
            $tel = "📞: ".$request->medfix_tel;
            $link = "🚀: http://medfix.dyndns.tv:8080/inventory/".$invid;
            $message = $title."\n".$detail."\n".$invname."\n".$person."\n".$from."\n".$tel."\n".$link;
            //sendLineNotify($message);
            return redirect()->route('inventory', $invid);
        }else{
            Alert::warning('พบข้อผิดพลาด', 'กรุณาตรวจสอบว่ากรอกข้อมูลครับถ้วนแล้ว');
            return redirect()->route('inventory', $invid);
        }
    }

    public function edit(Medfix $medfix)
    {
        return view('medfix.edit', compact('medfix'));
    }

    public function closejob(Request $request, $id)
    {
        $comment = "-";
        $request->validate([
            'issue' => 'required',
            'solving' => 'required',
            'status' => 'required'
        ]);
        if($request->comment != ""){
            $comment = $request->comment;
        }
        $medfix = Medfix::findOrFail($id);
        $medfix->medfix_technician_user_id = Auth::user()->id;
        $medfix->issue_id = $request->issue;
        $medfix->solving_id = $request->solving;
        $medfix->medfix_technician_comment = $comment;
        $medfix->medfix_status = $request->status;
        $medfix->medfix_date = date('Y-m-d H:i:s');
        if($medfix->save()){
            Alert::success('ดำเนินการ เสร็จสิ้น!', 'บันทึกข้อมูลเสร็จสิ้น');
            return redirect()->route('inventory', $request->inv_id);
        }else{
            Alert::warning('พบข้อผิดพลาด', 'กรุณาตรวจสอบว่ากรอกข้อมูลครับถ้วนแล้ว');
            return redirect()->route('inventory', $request->inv_id);
        }
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $roles = $user->getRoleNames();

        $medfixesDep = MedfixFullView::where('id', $id)->value('dep_short_name');

        // กัน hasRole(null) error กรณีไม่พบข้อมูลหน่วยของรายการนี้
        if (!$medfixesDep || !$user->hasRole($medfixesDep)) {
            toast('คุณไม่มีสิทธิ์ในการลบข้อมูลให้กับ '.$medfixesDep, 'error');
            return redirect()->route('medfix');
        }

        $medfix = Medfix::findOrFail($id);
        if($medfix->delete()){
            toast('ลบข้อมูล เสร็จสิ้น!','success');
            return redirect()->route('medfix');
        }
    }
    public function regismedfix(Request $request)
    {
        //$prefixid = Prefix::select('id')->where('prefix_short',  $request->prefix)->first();
        $validatedData = $request->validate([
            'prefix' => 'required',
            'fname' => 'required',
            'lname' => 'required',
            'department_id2' => 'nullable',
            'tel' => 'nullable',
            'inv_id' => 'required|integer',
        ]);

        $data = ([
            'prefix' => $request->prefix,
            'fname' => $request->fname,
            'lname' => $request->lname,
            'org' => $request->department_id2,
            'tel' => $request->tel,
            'inv_id' => $request->inv_id
        ]);

        if(PersonalHasInv::create($data)){
            Alert::success('ดำเนินการ เสร็จสิ้น!', 'บันทึกข้อมูลเสร็จสิ้น');
            return redirect()->route('inventory', $request->inv_id);
        }else{
            Alert::warning('พบข้อผิดพลาด', 'กรุณาตรวจสอบว่ากรอกข้อมูลครับถ้วนแล้ว');
            return redirect()->route('inventory', $request->inv_id);
        }

    }
    public function search(){
        $inventory = null;
        $gong = null;
        $departments = Department::select('gong')
            ->whereNotNull('gong')
            ->where('gong', '!=', '')
            ->groupBy('gong')
            ->get();
        return view('medfix.search', compact('departments', 'inventory', 'gong'));
    }

    public function search_sm(Request $request){
        $gong = $request->dep;
        $departments = Department::select('gong')
            ->whereNotNull('gong')
            ->where('gong', '!=', '')
            ->groupBy('gong')
            ->get();
        $inventory = Inventory::join('department', 'inventory.rec_organize', '=', 'department.id')
            ->where('department.gong', '=', $gong)
            ->select('inventory.*','department.panag as panag')
            ->get();

        return view('medfix.search', compact('departments', 'inventory', 'gong'));
    }
}
