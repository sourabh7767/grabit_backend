<?php

namespace App\Models\user;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class CartDetail extends Model
{
    use HasFactory;
    protected $table = 'cart_details';
    protected $appends = ['item_details'];
    public $timestamps = false;
    protected $fillable = [
        'id','cart_id', 'item_id','item_type','user_id','price','quantity'
    ];

    public function getItemDetailsAttribute(){
    	if($this->item_type == 1){
          return Items::find($this->item_id);  
        } 
    	if($this->item_type == 2){
            
            return Bundles::find($this->item_id);  
        } 
    }
}
