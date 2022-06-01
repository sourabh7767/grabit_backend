<?php

namespace App\Models\user;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    use HasFactory;
    protected $table = 'items';
    protected $appends = ['store_details'];
    protected $fillable = [
        'id' , 'ar_item_name' , 'en_item_name' , 'ar_description' , 'en_description' , 'sub_category_id' , 'store_id' , 'price' , 'discount', 'status', 'img' , 'stock' , 'price_time_out' ,'created_at','updated_a'
    ];

    public function getStoreDetailsAttribute(){
    	$store = Stores::find($this->store_id);
    	return $store;
    }

}
