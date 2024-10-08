<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    use HasFactory;

    protected $table = 'issue';

    protected $fillable = [
        'issue_name',
        'issue_detail',
        'inv_type',
    ];
}
