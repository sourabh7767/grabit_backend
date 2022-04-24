<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\user\Cart;
use App\Models\user\Items;
use App\Models\user\Orders;
use Illuminate\Http\Request;

class OrdersController extends Controller
{

    public function place_order(Request $request)
    {
        if (!LoginController::auth($request)) {
            return "error";
        };
         $check_order=Orders::where('order_number',$request->generated_order_number)->get();
        if (count($check_order) ==0) {

        $store_id = 0;
        $cart_items = [];
        $i = 0;
        $items = Cart::where('user_id', $request->id)->get();
        foreach ($items as $item) {

            $this_item = Items::where('id', $item->item_id)->first();
            $item_details = array('item_id' => $item->item_id, 'quantity' => $item->quantity, 'item_ar_name' => $this_item->ar_item_name);
            $cart_items[$i] = $item_details;
            $store_id = $this_item->store_id;
            $i++;
        }
        $seralized_items = serialize($cart_items);

        Orders::Create([
            'order_number' => $request->generated_order_number,
            'user_id' => $request->id,
            'store_id' => $store_id,
            'items' => $seralized_items,
            'total' => $request->total,
            'status' => 1,
            'delivery_type' => $request->delivery_type,

        ]);

        Cart::where('user_id', $request->id)->delete();

        return json_encode(['status'=>'done']);

    }else{
        return json_encode(['status'=>'already exist']);
        }


    }


    public function cancel_order(Request $request)
    {
        if (!LoginController::auth($request)){
            return "error";
        };


       $order= Orders::where('user_id',$request->id)->get();
       
       $order->status=0;

       $order->save();

        return json_encode(['status'=>'done']);

    }


    public function orders(Request $request)
    {
        if (!LoginController::auth($request)){
            return "error";
        };


      return Orders::where('user_id',$request->id)->get();

    }



    public function order_details(Request $request,$order_id)
    {
        if (!LoginController::auth($request)){
            return "error";
        };

        return Orders::where('user_id',$request->id)->where('id',$order_id)->get();


    }

    public function status(Request $request)
    {
        if (!LoginController::auth($request)){
            return "error";
        };

       return Orders::where('id',$request->order_id)->first()->status;


    }



}
