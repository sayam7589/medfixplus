<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Project;
use App\Models\Inventory_brand;
use App\Models\Inventory_type;
use App\Models\Prefix;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\PersonalHasInv;
use App\Models\Medfix;
use Illuminate\Support\Facades\DB;
Use Alert;
use App\Models\Issue;
use App\Models\Solving;

class InvController extends Controller
{
    public function index()
    {
        $inventory = Inventory::all();

        $title = '! WARNING !';
        $text = "คุณต้องการลบข้อมูลสินทรัพย์นี้นี้ใช่หรือไม่";
        confirmDelete($title, $text);

        return view('inventorys.index', compact('inventory'));
    }

    public function view(Inventory $inventory)
    {
        return view('inventorys.view', compact('inventory'));
    }

    public function create(Request $request)
    {
        $inventory = Project::all();
        $types = Inventory_type::all();
        $brands = Inventory_brand::all();
        $prefixs = Prefix::all();
        $formData = $request->session()->get('formData', []);

        return view('inventorys.create', compact('inventory', 'types', 'brands', 'formData','prefixs'));

    }

    public function store(Request $request)
    {

        $validate = $request->validate([
            'project_id' => 'required|integer',
            'inv_type' => 'required|integer',
            'inv_brand' => 'required|integer',
            'inv_model' => 'required|string|max:255',
            'inv_detail' => 'nullable|string|max:255',
            'inv_rtaf_serial' => 'required|string|max:255',
            'inv_serial_number' => 'required|string|max:255',
            'inv_mac_address' => 'nullable|string|max:255',
            'inv_cpu' => 'nullable|string|max:255',
            'inv_ram' => 'nullable|string|max:255',
            'inv_ram_speed' => 'nullable|integer',
            'inv_storage_type' => 'nullable|string|max:255',
            'inv_storage_size' => 'nullable|integer',
            'inv_os_type' => 'nullable|string|max:255',
            'inv_os_version' => 'nullable|string|max:255',
            'inv_os_copyright' => 'nullable|integer',
            'inv_name' => 'required|string|max:255',
            'inv_msoffice_version' => 'nullable|string|max:255',
            'inv_msoffice_copyright' => 'nullable|integer',
            'inv_antivirus' => 'nullable|string|max:255',
            'inv_antivirus_copyright' => 'nullable|integer',
            'inv_setup_year' => 'nullable|date',
            'inv_status' => 'nullable|integer',
            'inv_cpu_clock' => 'nullable|string|max:255',
            'inv_picture' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'rec_prefix' => 'nullable|string|max:255',
            'rec_fname' => 'nullable|string|max:255',
            'rec_lname' => 'nullable|string|max:255',
            'rec_personal_tel' => 'nullable||integer',
            'rec_org_tel' => 'nullable||integer',
            'rec_organize' => 'nullable|string|max:255',
            'rec_address' => 'nullable|string|max:255',
        ]);

        $request->session()->put('formData', $validate);

        $check = Inventory::create($request->all());

        if($check){
            toast('เพิ่มโครงการสำเร็จเเล้วนะจ๊ะ', 'success');
            return redirect()->route('inventorys.create');
        } else {
            toast('เกิดข้อผิดพลาด', 'error');
            return redirect()->route('inventorys.create');
        }
    }

    /**
     * Show the form for editing the specified project.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */

    public function edit(Inventory $inventory)
    {
        $project = Project::all();
        $types = Inventory_type::all();
        $brands = Inventory_brand::all();
        $prefixs = Prefix::all();

        return view('inventorys.edit', compact('inventory','project','types', 'brands','prefixs'));


    }



    /**
     * Show the form for editing the specified project.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */

    public function showqr($id)
    {
        $inventory = Inventory::findOrFail($id);
        $qrcode = QrCode::size(400)
                        ->generate('https://medfix.site/inventory/'.$id);  //edit qrcode here

        return view('inventorys.qr', compact('inventory', 'qrcode'));
    }


    /**
     * Show the form for editing the specified project.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */

     public function showmulqr(Request $request)
{
    // Check if the request is a POST request (from AJAX)
    if ($request->isMethod('post')) {
        $find = $request->input('ids');

        if (!is_array($find)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid data received',
            ]);
        }

        $ids = implode(',', $find);

        // Return a JSON response with the redirect URL
        return response()->json([
            'status' => 'success',
            'redirect_url' => route('inventorys.mulqr') . '?ids=' . $ids,
        ]);
    }

    // Handle the GET request (for displaying the QR codes)
    if ($request->isMethod('get')) {
        $ids = explode(',', $request->query('ids'));

        // Debug log to ensure the IDs are being passed
        if (empty($ids)) {
            return view('errors.general', ['message' => 'No IDs found']);
        }

        $inventories = Inventory::whereIn('id', $ids)->get();

        // Make sure there are inventories to process
        if ($inventories->isEmpty()) {
            return view('errors.general', ['message' => 'No inventories found']);
        }

        $qrcodes = $inventories->mapWithKeys(function ($inventory) {
            $id = route('inventorys.qr', ['id' => $inventory->id]); // No need for manual URL modification
            return [$inventory->id => QrCode::size(350)->generate('https://medfix.site/inventory/'.$id)];
        });

        return view('inventorys.mulqr', compact('inventories', 'qrcodes'));
    }

    // Fallback in case the method is neither POST nor GET
    return response()->json([
        'status' => 'error',
        'message' => 'Invalid request method',
    ]);
}


    public function update(Request $request, Inventory $inventory)
    {
        //dd($request->all());
        $request->validate([
            'project_id' => 'required|integer',
            'inv_type' => 'required|integer',
            'inv_brand' => 'nullable|integer',
            'inv_model' => 'nullable|string|max:255',
            'inv_detail' => 'nullable|string|max:255',
            'inv_rtaf_serial' => 'nullable|string|max:255',
            'inv_serial_number' => 'nullable|string|max:255',
            'inv_mac_address' => 'nullable|string|max:255',
            'inv_cpu' => 'nullable|string|max:255',
            'inv_ram' => 'nullable|string|max:255',
            'inv_ram_speed' => 'nullable|integer',
            'inv_storage_type' => 'nullable|string|max:255',
            'inv_storage_size' => 'nullable|integer',
            'inv_os_type' => 'nullable|string|max:255',
            'inv_os_version' => 'nullable|string|max:255',
            'inv_os_copyright' => 'nullable|integer',
            'inv_name' => 'required|string|max:255',
            'inv_msoffice_version' => 'nullable|string|max:255',
            'inv_msoffice_copyright' => 'nullable|integer',
            'inv_antivirus' => 'nullable|string|max:255',
            'inv_antivirus_copyright' => 'nullable|integer',
            'inv_setup_year' => 'nullable|date',
            'inv_status' => 'nullable|integer',
            'inv_cpu_clock' => 'nullable|string|max:255',
            'inv_picture' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'rec_prefix' => 'nullable|string|max:255',
            'rec_fname' => 'nullable|string|max:255',
            'rec_lname' => 'nullable|string|max:255',
            'rec_personal_tel' => 'nullable||integer',
            'rec_org_tel' => 'nullable||integer',
            'rec_organize' => 'nullable|string|max:255',
            'rec_address' => 'nullable|string|max:255',
        ]);
        $check = $inventory->update($request->all());

        if($check){
            toast('บันทึกข้อมูลสำเร็จเเล้วนะจ๊ะ', 'success');
            return redirect()->route('inventorys.index');
        } else {
            toast('เกิดข้อผิดพลาด', 'error');
            return redirect()->back()->withInput();
        }
    }

     /**
     * Remove the specified project from storage.
     *
     * @param  \App\Models\Inventory  $project
     * @return \Illuminate\Http\Response
     */

    public function destroy(Inventory $inventory)
    {
        try {
            $check = $inventory->delete();

            if($check){
                toast('ลบข้อมูลสำเร็จเเล้วนะจ๊ะ', 'success');
                return redirect()->route('inventorys.index');
            } else {
                toast('เกิดข้อผิดพลาด', 'error');
                return redirect()->route('inventorys.index');
            }
        } catch (\Exception $e) {
            toast('เกิดข้อผิดพลาด: ' . $e->getMessage(), 'error');
            return redirect()->route('inventorys.index');
        }
    }


    public function profile($id)
    {
        $personal_data = PersonalHasInv::where('inv_id',  $id)->first();
        $personal = ([
            'fname' => '',
            'lname' => ''
        ]);
        //dd($personal_data->fname);
        if ($personal_data != null) {
            $personal = [
                'fname' => $personal_data->fname,
                'lname' => $personal_data->lname
            ];
        }
        $inv = Inventory::find($id);
        $prefix = Prefix::all();
        $medfix_status = Medfix::where('inv_id', '=', $id)->where('medfix_status', '=', 0)->count();
        $medfix_status2 = Medfix::where('inv_id', '=', $id)->where('medfix_status', '<', 4)->count();
        ///////////////////// เช็คคิวซ่อม
        $qu = Medfix::where('medfix_status', '=', 0)->count();
        ///////////////////// แสดงข้อมูลปิดงาน
        $repair = Medfix::where('inv_id', '=', $id)->where('medfix_status', '=', 0)->first();
        $medfixs = Medfix::select(DB::raw('YEAR(medfix_date) as year'),
            'medfix_owner_prefix',
            'medfix_owner_fname',
            'medfix_owner_lname',
            'medfix_user_id',
            'medfix_user_org',
            'medfix_detail',
            'medfix_tel',
            'medfix_pic',
            'medfix_ticket_date',
            'medfix_technician_user_id',
            'issue_id',
            'solving_id',
            'medfix_technician_comment',
            'medfix_upgrade_equipment',
            'medfix_upgrade_detail',
            'medfix_status',
            'medfix_date',
            'created_at',
            'updated_at')
            ->orderByRaw('YEAR(medfix_date) desc')
            ->orderBy('id', 'desc')
            ->where('inv_id', '=', $id)->get();
        $issues = Issue::all();
        $solvings = Solving::all();

        $historys = DB::table('medfix')
            ->join('prefix', 'medfix.medfix_owner_prefix', '=', 'prefix.id')
            ->join('department', 'medfix.medfix_user_org', '=', 'department.id') // Join กับ department
            ->select(
                'prefix.prefix_short as prefix',
                'medfix_owner_fname as fname',
                'medfix_owner_lname as lname',
                // ใช้ CONCAT พร้อมกับตรวจสอบ null
                DB::raw('CONCAT(
                    IF(department.gong IS NOT NULL, CONCAT(department.gong), ""),
                    IF(department.panag IS NOT NULL, CONCAT("  ", department.panag), ""),
                    IF(department.fay IS NOT NULL, CONCAT("  ", department.fay), "")
                ) as organize'),
                'medfix_ticket_date as activity_date',
                DB::raw('"แจ้งซ่อม" as activity_type')
            )
            ->where('inv_id', $id)
            ->unionAll(
                DB::table('personal_has_inv')
                    ->join('prefix', 'personal_has_inv.prefix', '=', 'prefix.id')
                    ->join('department', 'personal_has_inv.org', '=', 'department.id') // Join กับ department
                    ->select(
                        'prefix.prefix_short as prefix',
                        'fname',
                        'lname',
                        // ใช้ CONCAT พร้อมกับตรวจสอบ null
                        DB::raw('CONCAT(
                            IF(department.gong IS NOT NULL, CONCAT(department.gong), ""),
                            IF(department.panag IS NOT NULL, CONCAT("  ", department.panag), ""),
                            IF(department.fay IS NOT NULL, CONCAT("  ", department.fay), "")
                        ) as organize'),
                        'personal_has_inv.created_at as activity_date',
                        DB::raw('"ลงทะเบียนผู้ใช้" as activity_type')
                    )
                    ->where('inv_id', $id)
            )
            ->orderBy('activity_date', 'desc')
            ->get();




        $totalRepairs = DB::table('medfix')
            ->whereYear('medfix_date', \Carbon\Carbon::now()->year)
            ->where('inv_id', '=', $id)
            ->where('medfix_status', '=', 1)
            ->count();

        $repairsByIssue = DB::table('medfix')
            ->join('issue', 'medfix.issue_id', '=', 'issue.id')
            ->select(
                'issue.issue_name',
                DB::raw('SUM(CASE WHEN medfix_status = 1 THEN 1 ELSE 0 END) AS successful_repairs')
            )
            ->selectRaw(
                'ROUND((SUM(CASE WHEN medfix_status = 1 THEN 1 ELSE 0 END) / ?) * 100, 2) AS percentage',
                [$totalRepairs]
            )
            ->whereYear('medfix_date', \Carbon\Carbon::now()->year)
            ->where('inv_id', '=', $id)
            ->groupBy('issue.issue_name')
            ->orderBy('successful_repairs', 'desc')
            ->get();

        return view('inventorys.profile', compact('inv', 'prefix', 'personal', 'medfix_status', 'medfix_status2', 'medfixs', 'repair', 'issues', 'solvings', 'historys', 'qu', 'repairsByIssue'));
    }
}
