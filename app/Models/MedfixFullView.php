<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedfixFullView extends Model
{
    protected $table = 'view_medfix_full';

    // สำคัญมาก: VIEW ไม่มี primary key
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;

    // ป้องกัน Laravel พยายาม insert/update
    protected $guarded = [];
}
