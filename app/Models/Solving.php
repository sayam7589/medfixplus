<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solving extends Model
{
    protected $table = 'solving';
    protected $fillable = [
        'solving_title',
    ];
}
