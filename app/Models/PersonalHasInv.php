<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalHasInv extends Model
{
    use HasFactory;
    protected $table = 'personal_has_inv';

    protected $fillable = [
        'prefix',
        'fname',
        'lname',
        'org',
        'tel',
        'inv_id',
    ];
}
