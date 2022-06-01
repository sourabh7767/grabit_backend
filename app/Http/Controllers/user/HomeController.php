<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\user\User;
use App\Models\user\Stores;
use App\Models\user\Categories;
use App\Models\user\SubCategories;
use App\Models\user\Notification;
use App\Models\user\Bundles;
use App\Models\user\Items;
use App\Models\user\CartDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Response;
use Validator;
use Auth;

class HomeController extends Controller
{
    public function getAllStores(Request $request){
    	$stores = Stores::orderBy('id','Desc')->get();
    	if($stores){
    		return Response::json([
                                'status' => 1,
                                'message' => "Stores found.",
                                'store_base_url' => url('/images/stores/').'/',
                                'data' => $stores
                            ],200);
        }else{
             return Response::json([
                                    'status' => 0,
                                    'message' => "Stores not found."
                                ],400);
        }
    }

    public function getStore($id){
    	$store = Stores::find($id);
    	if($store){
            //get cat than->all sub cat--loop app sub cat and name of sub cat with item  array
            $subCats = SubCategories::where('category_id', $store->category_id)->get();
            $itemsByCat = [];
            foreach ($subCats as $key => $subCat) {
                $items = Items::where('sub_category_id', $subCat->id)->get();
                $itemsByCat[$key]["title"] = $subCat->sub_category_name;
                $itemsByCat[$key]["data"] = $items;
                //$itemsByCat[$subCat->sub_category_name] = $items;
            }
            $store->category_items = $itemsByCat;
    		return Response::json([
                                'status' => 1,
                                'message' => "Store details found.",
                                'store_base_url' => url('/images/stores/').'/',
                                'item_base_url' => url('/images/items/').'/',
                                'data' => $store
                            ],200);
        }else{
             return Response::json([
                                    'status' => 0,
                                    'message' => "Store not found."
                                ],400);
        }
    }

    public function getItemsCategory($id){
        $items = Items::where('sub_category_id', $id)->get();
        $user = Auth::user();
        if($items){
            foreach ($items as $key => $item) {
                $cart = CartDetail::where('user_id', $user->id)->where('item_id', $item->id)->first();
                if($cart){
                    $items[$key]->added_in_cart = $cart->quantity;  
                }else{
                    $items[$key]->added_in_cart = 0;  
                } 
            }
            return Response::json([
                                'status' => 1,
                                'message' => "Items found.",
                                'item_base_url' => url('/images/items/').'/',
                                'category_base_url' => url('/images/categories/').'/',
                                'data' => $items
                            ],200);
        }else{
             return Response::json([
                                    'status' => 0,
                                    'message' => "Items not found."
                                ],400);
        }   
    }

    public function getItemDetails($id){
        $item = Items::where('id', $id)->first();
        $user = Auth::user();
        if($item){
            $cart = CartDetail::where('user_id', $user->id)->where('item_id', $item->id)->first();
            if($cart){
                $item->added_in_cart = $cart->quantity;  
            }else{
                $item->added_in_cart = 0;  
            } 
            return Response::json([
                                'status' => 1,
                                'message' => "Item details found.",
                                'item_base_url' => url('/images/items/').'/',
                                'data' => $item
                            ],200);
        }else{
             return Response::json([
                                    'status' => 0,
                                    'message' => "Item details not found."
                                ],400);
        }   
    }

    public function home(Request $request){
    	$stores = Stores::orderBy('id','Desc')->get();
    	$data['near_by_store'] = $stores;
    	$categories = Categories::orderBy('id','Desc')->get();
    	$data['category_list'] = $categories;
        $bundels = Bundles::where('status', '1')->get();
        // foreach ($bundels as $key => $bundel) {
        //     $bundels->items = json_decode($bundel->items);
        // }
        $data['hot_deal'] = $bundels;
        $items = Items::orderBy('id', 'Desc')->get();
        $data['near_by_me'] = $items;
    	return Response::json([
                                'status' => 1,
                                'message' => "Data Found.",
                                'store_base_url' => url('/images/stores/').'/',
                                'item_base_url' => url('/images/items/').'/',
                                'data' => $data
                            ],200);
    }

    public function getNotifications(){
        $user = Auth::user();
    	$notifications = Notification::where('user_id', $user->id)->get();
    	if($notifications){
    		return Response::json([
                                'status' => 1,
                                'message' => "Notifications found.",
                                'bundel_base_url' => url('/images/bundles/').'/',
                                'data' => $notifications
                            ],200);
        }else{
             return Response::json([
                                    'status' => 0,
                                    'message' => "Notifications not found."
                                ],400);
        }
    }

    public function getBundelInfo($id,request $request){
        $bundels = Bundles::where('id', $id)->first();
        $user = Auth::user();
        if($bundels){
            $cart = CartDetail::where('user_id', $user->id)->where('item_id', $bundels->id)->first();
            if($cart){
                $bundels->added_in_cart = $cart->quantity;  
            }else{
                $bundels->added_in_cart = 0;  
            }
            return Response::json([
                                'status' => 1,
                                'message' => "Item details found.",
                                'item_base_url' => url('/images/items/').'/',
                                'data' => $bundels
                            ],200);
        }else{
             return Response::json([
                                    'status' => 0,
                                    'message' => "Item details not found."
                                ],400);
        } 

    }

    public function addToCart(Request $request){

    }
}
