<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory_type extends Model
{
    use HasFactory;

    protected $table = 'inventory_type';

    protected $fillable = [
        'type_name'
    ];
}
