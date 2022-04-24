<?php

namespace App\Models\user;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;
    protected $table = 'orders';
    public $timestamps = true;
    protected $fillable = [
        'id','order_number', 'user_id','store_id','items','total'  ,'status' ,'delivery_type','bundle'
    ];
}
