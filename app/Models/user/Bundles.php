<?php

namespace App\Models\user;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bundles extends Model
{
    use HasFactory;
    protected $table = 'bundles';
    protected $appends = ['store_details'];
    public $timestamps = false;
    protected $fillable = [
        'id', 'bundle_name','description','description_ar', 'bundle_name_ar','sub_category_id','total_after_discount', 'items', 'price', 'stock','status','img', 'store_id', 'created_at', 'updated_at',

    ];

    public function getStoreDetailsAttribute(){
    	$store = Stores::find($this->store_id);
    	return $store;
    }
}
