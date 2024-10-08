<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medfix extends Model
{
    use HasFactory;
    protected $table = 'medfix';
    protected $fillable = [
        'inv_id',
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
    ];
    public function user(){
        return $this->belongsTo(User::class, 'medfix_user_id');
    }
    public function issue(){
        return $this->belongsTo(Issue::class, 'issue_id');
    }
    public function technician(){
        return $this->belongsTo(User::class, 'medfix_technician_user_id');
    }
    public function solving(){
        return $this->belongsTo(Solving::class, 'solving_id');
    }
    public function equipment(){
        return $this->belongsTo(Equipment::class, 'medfix_upgrade_equipment');
    }
    public function prefix(){
        return $this->belongsTo(Prefix::class, 'medfix_owner_prefix');
    }
    public function inventory(){
        return $this->belongsTo(Inventory::class, 'inv_id');
    }
    public function userorg(){
        return $this->belongsTo(Department::class, 'medfix_user_org');
    }


}
