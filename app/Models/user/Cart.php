<?php

namespace App\Models\user;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'cart';
    public $timestamps = false;
    protected $fillable = [
        'id', 'total_price','store_id','user_id','address','latitude','logitude'
    ];
}
