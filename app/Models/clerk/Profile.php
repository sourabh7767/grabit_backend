<?php

namespace App\Models\clerk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $table = 'clerks';
    protected $guard = 'clerk';
    public $timestamps = false;
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',

    ];
}
