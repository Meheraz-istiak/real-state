<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $table ="projects";
    protected $fillable = [
        'name','location','start_date','end_date','project_type','photo','excel'
    ];
}
