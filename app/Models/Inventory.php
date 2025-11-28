<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'inventory';

    // Add the fillable fields
    protected $fillable = [
        'project_id',
        'inv_type',
        'inv_brand',
        'inv_model',
        'inv_detail',
        'inv_rtaf_serial',
        'inv_serial_number',
        'inv_mac_address',
        'inv_cpu',
        'inv_ram',
        'inv_ram_speed',
        'inv_storage_type',
        'inv_storage_size',
        'inv_os_type',
        'inv_os_version',
        'inv_os_copyright',
        'inv_name',
        'inv_msoffice_version',
        'inv_msoffice_copyright',
        'inv_antivirus',
        'inv_antivirus_copyright',
        'inv_setup_year',
        'inv_status',
        'inv_cpu_clock',
        'inv_picture',
        'rec_prefix',
        'rec_fname',
        'rec_lname',
        'rec_personal_tel',
        'rec_org_tel',
        'rec_organize',
        'rec_address'
    ];

    //innerjoin
    // ความสัมพันธ์กับตาราง project
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    // ความสัมพันธ์กับตาราง inventory_type
    public function type()
    {
        return $this->belongsTo(Inventory_type::class, 'inv_type')->withDefault();
    }

    public function brand()
    {
        return $this->belongsTo(Inventory_brand::class, 'inv_brand')->withDefault();
    }

    public function prefix()
    {
        return $this->belongsTo(Prefix::class, 'rec_prefix')->withDefault();
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'rec_organize')->withDefault();
    }

}
