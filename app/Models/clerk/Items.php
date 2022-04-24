<?php

namespace App\Models\clerk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    use HasFactory;
    protected $table = 'items';
    public $timestamps = false;
    protected $fillable = [
        'id', 'ar_item_name', 'en_item_name', 'ar_description', 'en_description', 'sub_category_id', 'store_id', 'price','discount','status', 'img' , 'stock','created_at','updated_at'
    ];
}
