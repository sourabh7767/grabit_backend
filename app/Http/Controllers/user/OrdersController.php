<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\user\Cart;
use App\Models\user\CartDetail;
use App\Models\user\Items;
use App\Models\user\Orders;
use App\Models\clerk\Clerk;
use Illuminate\Http\Request;
use Auth;
use Response;

class OrdersController extends Controller
{

    public function place_order(Request $request)
    {

        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();
        if($cart){
            $store_id = $cart->store_id;
            $cartDetail = CartDetail::where('cart_id', $cart->id)->get();
            $order = Orders::Create([
                                        'user_id' => $user->id,
                                        'store_id' => $cart->store_id,
                                        'items' => json_encode($cartDetail),
                                        'total_price' => $cart->total_price,
                                        'address' => $cart->address,
                                        'latitude' => $cart->logitude,
                                        //'total_price' => $cart->total_price,
                                        'status' => 1,
                                        'delivery_type' => 0,
                                    ]);
            $order->items = json_decode($order->items);
            foreach ($order->items as $key => $item) {
              $itemUpdate = Items::where('id', $item->item_id)->first();
              $itemUpdate->stock = $itemUpdate->stock - $item->quantity;
              $itemUpdate->save();
            }
            CartDetail::where('cart_id', $cart->id)->delete();
            $cart->delete();

            $fcmIDs = Clerk::where("store_id",$store_id)->whereNotNull("device_token")->pluck('device_token',"device_token")->toArray();
            //echo "<pre>";print_r($fcmIDs);die;
            if($fcmIDs){
                $this->sendWebNotification(array_values($fcmIDs),"New order","You have recived a new order, Please referesh the screen"); 
            }
            
            return Response::json([
                                      'status' => 1,
                                      'message' => "Order Placed.",
                                      'data' => $order
                                  ],200);
        }else{
            return Response::json([
                                      'status' => 1,
                                      'message' => "Please add item in your cart."
                                  ],200);
        }

    }


    public function cancel_order(Request $request)
    {
        $rules = [
            'order_id' => 'required|exists:ordres,id',
        ];

        $input = $request->only('order_id');
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()]);
        }

        $user = Auth::user();

        $order= Orders::where('user_id',$user->id)->where('order_id', $request->order_id)->first();
       
        $order->status=0;

        $order->save();

        return Response::json([
                                  'status' => 1,
                                  'message' => "Order Cancelled."
                              ],200);

    }


    public function orders(Request $request)
    {
     // $this->sendWebNotification();die;
        $user = Auth::user();
        $orders = Orders::where('user_id', $user->id)->get();
        if($orders){
            foreach ($orders as $key => $order) {
                $orders[$key]->items = json_decode($order->items);
            }
            return Response::json([
                                      'status' => 1,
                                      'message' => "Orders Found.",
                                      'item_base_url' => url('/images/items/').'/',
                                      'bundel_base_url' => url('/images/bundles/').'/',
                                      'store_base_url' => url('/images/stores/').'/',
                                      'data' => $orders
                                  ],200);        
        }else{
            return Response::json([
                                      'status' => 0,
                                      'message' => "Orders Not Found.",
                                      'data' => $orders
                                  ],200);                
        }

    }



    public function order_details($order_id)
    {
        $user = Auth::user();
        $order =  Orders::where('id',$order_id)->first();
        if($order){
            $order->items = json_decode($order->items);
            return Response::json([
                                      'status' => 1,
                                      'message' => "Order Details Found.",
                                      'item_base_url' => url('/images/items/').'/',
                                      'bundel_base_url' => url('/images/bundles/').'/',
                                      'store_base_url' => url('/images/stores/').'/',
                                      'data' => $order
                                  ],200);                
        }else{
            return Response::json([
                                      'status' => 0,
                                      'message' => "Order Not Found.",
                                      'data' => $order
                                  ],200);                
        }

    }

    public function status(Request $request)
    {
        if (!LoginController::auth($request)){
            return "error";
        };

       return Orders::where('id',$request->order_id)->first()->status;


    }

    public function sendWebNotification($FcmToken,$title,$messages)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        //$FcmToken = ["cHfFsOx2ecx9TZiVf336wu:APA91bGzYxwGCvPICDUtVIJVhcYBlS08lFsrEoIieL6hBJXsdqUoUOPe_ijnzowHgekZj7L87cAwcN_EmE9LDrj04b5IIu1LMyK9TyOdWUwi1DW2XTxnNO5JQ4xefI-QyYq-hEw-D0D2"];//Clerk::whereNotNull('device_key')->pluck('device_key')->all();
          
        $serverKey = 'AAAA5Rj4RBU:APA91bECTiRSo3HsokP01DMjPGf7_W8WiyYwjJY70gVUsINmeSQ0aKpuq4DSAfkcRG2pfrbb2pu7uvYIsmRitfY4dDUf5n3YuK_jHnjpxOu1rr-iifuU2LwYWUCIsLAelbqo1hzHaVz0';
  
        $data = [
            "registration_ids" => $FcmToken,
            "notification" => [
                "title" => $title,
                "body" => $messages,  
            ]
        ];
        $encodedData = json_encode($data);
    
        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }        
        // Close connection
        curl_close($ch);
        // FCM response
        dd($result);        
    }



}
