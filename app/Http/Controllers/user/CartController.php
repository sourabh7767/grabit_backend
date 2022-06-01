<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\user\Cart;
use App\Models\user\Items;
use App\Models\user\Stores;
use App\Models\user\CartDetail;
use Illuminate\Http\Request;
use Validator;
use Response;
use Auth;

class CartController extends Controller
{

    public function items(Request $request)
    {
      $user = Auth::user();
      $cart = Cart::where('user_id',$user->id)->first();
      if($cart){
        $cart->cart_details = CartDetail::where('cart_id', $cart->id)->get();
        return Response::json([
                                  'status' => 1,
                                  'message' => "Cart Found.",
                                  'data' => $cart
                              ],200);
      }else{
        return Response::json([
                                  'status' => 0,
                                  'message' => "Cart Not Found.",
                                  'data' => $cart
                              ],200);
      }

    }


    public function add(Request $request)
    {
        $rules = [
            'quantity'    => 'required',
            'price' => 'required',
            'item_type' => 'required|in:1,2',
            // 'address' => 'required',
            // 'latitude' => 'required',
            // 'logitude' => 'required'
        ];

        $input = $request->only('quantity', 'price','item_type');
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()]);
        }

        if($request->item_type == 1){
          $rules = [
              'item_id'    => 'required:exist:items,id'
          ];          
        }

        if($request->item_type == 2){
          $rules = [
              'item_id'    => 'required:exist:bundels,id'
          ];
        }

        $input = $request->only('item_id');
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()]);
        }          
        

        $user = Auth::user();
        $check = Cart::where('user_id',$user->id)->first();
        if($check){
          //cart exist
          $check->total_price = $check->total_price + $request->price;
          $check->save();
          $item_exist = CartDetail::where('user_id', $user->id)->where("item_type",$request->item_type)->where('item_id', $request->item_id)->first();
          if($item_exist){
            $item_exist->quantity = $item_exist->quantity + $request->quantity;
            $item_exist->save();
          }else{
            $cartDetail = CartDetail::Create([
                  'cart_id' => $check->id,
                 'item_id' => $request->item_id,
                 'quantity' => $request->quantity,
                 'price' => $request->price,
                 'user_id' => $user->id,
                 "item_type"=>$request->item_type
             ]);
          }
          $cart = Cart::where('user_id',$user->id)->first();
          $cart->cart_details = CartDetail::where('cart_id', $cart->id)->get();
          return Response::json([
                                    'status' => 1,
                                    'message' => "Cart updated.",
                                    'data' => $cart
                                ],200);
        }else{
          //new cart created
          $items = Items::find($request->item_id);
            $cart = Cart::Create([
                 'item_id' => $request->item_id,
                 'total_price' => $request->price,
                 'user_id' => $user->id,
                 'store_id' => $items->store_id,
                 'address' => $user->address,
                 'latitude' => $user->lat,
                 'logitude' => $user->lng
             ]);
            if($cart){
              $cartDetail = CartDetail::Create([
                  'cart_id' => $cart->id,
                 'item_id' => $request->item_id,
                 'item_type' => $request->item_type,
                 'quantity' => $request->quantity,
                 'price' => $request->price,
                 'user_id' => $user->id
             ]);
            }
            $cart->cart_details = CartDetail::where('cart_id', $cart->id)->get();
            return Response::json([
                                    'status' => 1,
                                    'message' => "Cart created.",
                                    'data' => $cart
                                ],200);
        }
    }

    public function addItemQty(Request $request){
      $rules = [
          'item_type' => 'required|in:1,2',
          'status' => 'required|in:0,1'//1:add,0:subtract
      ];

      $input = $request->only('status', 'item_type');
      $validator = Validator::make($input, $rules);

      if ($validator->fails()) {
          return response()->json(['success' => false, 'error' => $validator->messages()]);
      }
      if($request->item_type == 1){
        $rules = [
            'item_id'    => 'required:exist:items,id'
        ]; 
      }

      if($request->item_type == 2){
        $rules = [
            'item_id'    => 'required:exist:bundels,id'
        ];
      }
      $input = $request->only('item_id');
      $validator = Validator::make($input, $rules);

      if ($validator->fails()) {
          return response()->json(['success' => false, 'error' => $validator->messages()]);
      }

      $user = Auth::user();
      $cart = CartDetail::where('user_id',$user->id)->first();
      $cartDetails = CartDetail::where('user_id',$user->id)->where('item_id',$request->item_id)->first();
      if($cartDetails){
        if($request->status == 1){
          $cartDetails->quantity = $cartDetails->quantity + 1;
        }else{
          $cartDetails->quantity = $cartDetails->quantity - 1;
        }
        if($cartDetails->quantity == 0){
          $cartDetails->delete();
          $restitems = $cartDetails = CartDetail::where('cart_id',$cart->id)->first();
          if(!$restitems){
            $cart->delete();
            return Response::json([
                                      'status' => 1,
                                      'message' => "Cart is empty,Please add new items in cart."
                                  ],200);
          }
        }else{
          $cartDetails->save();
          $cart = Cart::where('user_id', $user->id)->first();
          if($request->status == 1){
            $cart->total_price = $cart->total_price + $cartDetails->price;
          }else{
            $cart->total_price = $cart->total_price - $cartDetails->price;
          }
          
          $cart->save();

          $cart = Cart::where('user_id',$user->id)->first();
          $cart->cart_details = CartDetail::where('cart_id', $cart->id)->get();
          return Response::json([
                                      'status' => 1,
                                      'message' => "Quantity Updated.",
                                      'data' => $cart
                                  ],200);
        }
      }else{
        return Response::json([
                                  'status' => 0,
                                  'message' => "Item not exists."
                              ],200);
      }
    }

    public function remove(Request $request)
    {
        $rules = [
            'item_type' => 'required||in:1,2'
        ];

        $input = $request->only('item_id');
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()]);
        }

        if($request->item_type == 1){
          $rules = [
              'item_id'    => 'required:exist:items,id'
          ];
        }

      if($request->item_type == 2){
        $rules = [
            'item_id'    => 'required:exist:bundels,id'
        ];
      }

      $input = $request->only('item_id');
      $validator = Validator::make($input, $rules);

      if ($validator->fails()) {
          return response()->json(['success' => false, 'error' => $validator->messages()]);
      }

        $user = Auth::user();
        $item = Items::find($request->item_id);
        $cartDetails = CartDetail::where('user_id',$user->id)->where('item_id',$request->item_id)->first();
        $cart = Cart::where('user_id', $user->id)->first();
        $cart->total_price = $cart->total_price - ($item->price * $cartDetails->quantity);
        $cart->save();
        $cartDetails->delete();
        
        return Response::json([
                                  'status' => 1,
                                  'message' => "Item Removed."
                              ],200);

    }


    public function update(Request $request)
    {
        $rules = [
            'item_id' => 'required|exists:items,id',
            'quantity'    => 'required',
            'price' => 'required',
        ];

        $input = $request->only('item_id', 'quantity', 'price');
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()]);
        }

        $user = Auth::user();

        $item = Cart::where('user_id',$user->id)->where('item_id',$request->item_id)->first();
        if($item){
          $item->quantity = $request->quantity;
          $item->price = $request->price;
          $item->save();
          return Response::json([
                                    'status' => 1,
                                    'message' => "Cart updated.",
                                    'data' => $item
                                ],200);
        }

    }


    public function clear(Request $request)
    {
        $user = Auth::user();
        Cart::where('user_id',$user->id)->delete();
        CartDetail::where('user_id',$user->id)->delete();

        return Response::json([
                                'status' => 1,
                                'message' => "Cart cleared."
                            ],200);
    }


}
