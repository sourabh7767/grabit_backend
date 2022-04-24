<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regions extends Model
{
    use HasFactory;
    protected $table = 'regions';
    public $timestamps = false;
    protected $guard = 'web';
    protected $fillable = [
        'id', 'region_name_ar', 'region_name_en'
    ];
}
