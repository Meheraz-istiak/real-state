<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $table ="settings";
    protected $fillable = [
        'company_name','company_address','website','email','phone','facebook','linkedIn','instagram','company_logo','favicon','site_title','meta_description'
    ];
}
