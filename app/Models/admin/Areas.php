<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Areas extends Model
{
    use HasFactory;
    protected $table = 'cities';
    protected $guard = 'web';
    public $timestamps = false;
    protected $fillable = [
        'id', 'area_name_ar', 'area_name_en', 'region_id'
    ];
}
