<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prefix extends Model
{
    use HasFactory;

    protected $table = 'prefix';

    protected $fillable = [
        'prefix_short',
        'prefix_name'
    ];
}
