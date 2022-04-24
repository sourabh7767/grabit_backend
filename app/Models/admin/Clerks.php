<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clerks extends Model
{
    use HasFactory;
    protected $table = 'clerks';
    public $timestamps = false;
    protected $fillable = [
        'id', 'name', 'email', 'phone', 'password', 'active' , 'store_id','is_manager'
    ];
}
