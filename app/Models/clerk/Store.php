<?php

namespace App\Models\clerk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    protected $table = 'stores';
    protected $guard = 'clerk';
    public $timestamps = false;
    protected $fillable = [
        'id', 'ar_name', 'ar_category', 'en_name', 'en_category', 'location', 'region', 'phone', 'status' ,'delivery_price','longitude','latitude'
    ];


}
