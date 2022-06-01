<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return "sdf";
});*/

/*Route::group(['middleware' => 'auth:api'], function($app) {
     $app->get('/verify-otp', function() {
         echo "hello";die;
     });
});*/

Route::post('/register', 'App\Http\Controllers\user\LoginController@register');
Route::post('/login', 'App\Http\Controllers\user\LoginController@login');
Route::post('/auth', 'App\Http\Controllers\user\LoginController@auth');
Route::group(['middleware' => 'auth:user'], function(){
    Route::get('/get_notifications', 'App\Http\Controllers\user\HomeController@getNotifications');
    Route::get('/get_all_stores', 'App\Http\Controllers\user\HomeController@getAllStores');
    Route::get('/get_store/{id}', 'App\Http\Controllers\user\HomeController@getStore');
    Route::get('/get_item_details/{id}', 'App\Http\Controllers\user\HomeController@getItemDetails');
    Route::get('/get_bundel_details/{id}', 'App\Http\Controllers\user\HomeController@getBundelInfo');
    
    Route::get('/get_items_category/{id}', 'App\Http\Controllers\user\HomeController@getItemsCategory');
    Route::get('/home', 'App\Http\Controllers\user\HomeController@home');
    Route::post('/update_notification_status', 'App\Http\Controllers\user\LoginController@updateNotificationStatus');
    Route::post('/change_password', 'App\Http\Controllers\user\LoginController@changePassword');
    Route::get('/get_profile', 'App\Http\Controllers\user\LoginController@getProfile');
	Route::post('/update_profile', 'App\Http\Controllers\user\LoginController@update_profile');
	Route::post('/update_location', 'App\Http\Controllers\user\LoginController@update_location');
    Route::post('/update_token', 'App\Http\Controllers\user\LoginController@update_token');
	Route::post('/verify-token', 'App\Http\Controllers\user\LoginController@verifyToken');
	Route::post('/verify-otp', 'App\Http\Controllers\user\LoginController@verifyOtp');
    Route::post('/cart', 'App\Http\Controllers\user\CartController@items');
    Route::post('/cart/add', 'App\Http\Controllers\user\CartController@add');
    Route::post('/add/item/quantity', 'App\Http\Controllers\user\CartController@addItemQty');
    Route::post('/cart/remove', 'App\Http\Controllers\user\CartController@remove');
    Route::post('/cart/update', 'App\Http\Controllers\user\CartController@update');
    Route::get('/cart/clear', 'App\Http\Controllers\user\CartController@clear');
    Route::post('/order/add', 'App\Http\Controllers\user\OrdersController@place_order');
    Route::post('/order/cancel', 'App\Http\Controllers\user\OrdersController@cancel_order');
    //Route::post('/order/status', 'App\Http\Controllers\user\OrdersController@status');
    Route::get('/orders', 'App\Http\Controllers\user\OrdersController@orders');
    Route::get('/orders/{order_id}', 'App\Http\Controllers\user\OrdersController@order_details');
	Route::post('/logout', 'App\Http\Controllers\user\LoginController@logout');
});



// Reset Password



Route::post('/categories', 'App\Http\Controllers\user\CategoriesController@categories_list');
Route::post('/category/{id}', 'App\Http\Controllers\user\CategoriesController@get_category');

Route::post('/stores/city', 'App\Http\Controllers\user\StoresController@stores');

// list sub Categories
        Route::post('/stores/list', 'App\Http\Controllers\user\CategoriesController@sub_categories');
        Route::post('/store/{id}', 'App\Http\Controllers\user\StoresController@store');

// list items
Route::post('/store/sub-categories', 'App\Http\Controllers\user\StoresController@sub_categories');
Route::post('/store/sub-categories/{id}', 'App\Http\Controllers\user\StoresController@sub_category_items');

Route::post('/store-details/{id}', 'App\Http\Controllers\user\StoresController@store_details');




Route::get('/cities/{id}', function (Request $request,$id) {
        return  (\App\Models\admin\Areas::where('region_id','=',$id)->get());
});

Route::get('/regions', function (Request $request) {
    return  (\App\Models\admin\Regions::all());
});

