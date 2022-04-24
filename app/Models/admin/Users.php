<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;
    protected $table = 'users';
    public $timestamps = false;
    protected $fillable = [
        'id', 'name', 'email', 'phone', 'password', 'active'
    ];
}
