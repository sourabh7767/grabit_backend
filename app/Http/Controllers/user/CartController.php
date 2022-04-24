<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\user\Cart;
use App\Models\user\Items;
use App\Models\user\Stores;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function items(Request $request)
    {
        if (!LoginController::auth($request)){
            return "error";
        };



     return Cart::where('user_id',$request->id)->get();

    }


    public function add(Request $request)
    {
        if (!LoginController::auth($request)){
            return "error";
        };

        $item_exist= Cart::where('user_id',$request->id)->where('item_id',$request->item_id)->get();
       if(count($item_exist)==0){

           Cart::Create([
               'item_id'=>$request->item_id,
               'quantity'=>$request->quantity,
               'price'=>$request->price,
               'user_id'=>$request->id,
               'bundle'=>$request->bundle ?? 0,
           ]);
           return json_encode(['status'=>'done']);
       }else{
           return json_encode(['status'=>'already exist']);
       }



    }


    public function remove(Request $request)
    {
        if (!LoginController::auth($request)){
            return "error";
        };


       Cart::where('user_id',$request->id)->where('item_id',$request->item_id)->delete();

        return json_encode(['status'=>'done']);

    }


    public function update(Request $request)
    {
        if (!LoginController::auth($request)){
            return "error";
        };

     $item= Cart::where('user_id',$request->id)->where('item_id',$request->item_id)->first();

          $item->quantity=$request->quantity;
          $item->price=$request->price;
          $item->save();


    }


    public function clear(Request $request)
    {
        if (!LoginController::auth($request)){
            return "error";
        };


        Cart::where('user_id',$request->id)->delete();

        return json_encode(['status'=>'done']);



    }


}
