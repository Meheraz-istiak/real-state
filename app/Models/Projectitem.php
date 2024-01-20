<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projectitem extends Model
{
    use HasFactory;
    protected $table ="projectitems";
    protected $fillable = [
        'name','project_id','item_position','item_side','price','item_type'
    ];
}
