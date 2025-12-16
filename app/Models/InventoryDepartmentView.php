<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryDepartmentView extends Model
{
    protected $table = 'view_inventory_department';

    // สำคัญมาก: VIEW ไม่มี primary key
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;

    // ป้องกัน Laravel พยายาม insert/update
    protected $guarded = [];
}
