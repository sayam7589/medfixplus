<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory_brand extends Model
{
    use HasFactory;

    protected $table = 'inventory_brand';

    protected $fillable = [
        'brand_name'
    ];
}
