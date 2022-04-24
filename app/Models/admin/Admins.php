<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admins extends Model
{
    use HasFactory;
    protected $table = 'admins';
    public $timestamps = true;
    protected $fillable = [
        'id', 'name', 'email', 'password', 'active'
    ];
}
