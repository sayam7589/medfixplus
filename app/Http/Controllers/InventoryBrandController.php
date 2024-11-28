<?php

namespace App\Http\Controllers;

use App\Models\Inventory_brand;
use Illuminate\Http\Request;

class InventoryBrandController extends Controller
{
    public function create()
    {
        $brands = Inventory_brand::all();

        $title = '! WARNING !';
        $text = "คุณต้องการลบชื่อยี่ห้อนี้ใช่หรือไม่";
        confirmDelete($title, $text);

        return view('inventory.brands', compact('brands'));
    }

    public function store(Request $request)
    {
        //dd($request->brand);
        $request->validate([
            'brand' => 'required|string',
        ]);

        $inventory_brand = Inventory_brand::create([
            'brand_name' => $request->brand,
        ]);
        toast('บันทึกข้อมูล เสร็จสิ้น!','success');
        return redirect()->route('inventory_brands.create');
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
            'brand' => 'required|string',
        ]);

        $brand = Inventory_brand::findOrFail($id);
        $brand->update([
            'brand_name' => $request->brand,
        ]);
        toast('บันทึกข้อมูล เสร็จสิ้น!','success');
        return redirect()->route('inventory_brands.create');
    }
    public function destroy($id)
    {
        $brand = Inventory_brand::findOrFail($id);
        $brand->delete();

        toast('ลบข้อมูล เสร็จสิ้น!','success');
        return redirect()->route('inventory_brands.create');
    }
}
