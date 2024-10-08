<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'project';

    // Add the fillable fields if necessary
    protected $fillable = [
        'project_name',
        'project_detail', 
        'project_company', 
        'project_company_contact', 
        'project_file',
        'project_date'
    ];
}
