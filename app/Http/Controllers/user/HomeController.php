<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\user\User;
use App\Models\user\Stores;
use App\Models\user\Categories;
use App\Models\user\Notification;
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
    		return Response::json([
                                'status' => 1,
                                'message' => "Store details found.",
                                'data' => $store
                            ],200);
        }else{
             return Response::json([
                                    'status' => 0,
                                    'message' => "Store not found."
                                ],400);
        }
    }

    public function home(Request $request){
    	$stores = Stores::orderBy('id','Desc')->get();
    	$data['near_by_store'] = $stores;
    	$categories = Categories::orderBy('id','Desc')->get();
    	$data['category_list'] = $categories;
    	return Response::json([
                                'status' => 1,
                                'message' => "Data Found.",
                                'data' => $data
                            ],200);
    }

    public function getNotifications(){
    	$notifications = Notification::get();
    	if($notifications){
    		return Response::json([
                                'status' => 1,
                                'message' => "Notifications found.",
                                'data' => $notifications
                            ],200);
        }else{
             return Response::json([
                                    'status' => 0,
                                    'message' => "Notifications not found."
                                ],400);
        }
    }
}
