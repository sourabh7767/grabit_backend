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
        'id', 'item_id','user_id','price','quantity'
    ];
}
