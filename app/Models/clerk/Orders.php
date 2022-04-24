<?php

namespace App\Models\clerk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;
    protected $table = 'orders';
    public $timestamps = true;
    protected $fillable = [
        'id', 'user_id','store_id','items' ,'status','delivery_type','bundle'
    ];

}
