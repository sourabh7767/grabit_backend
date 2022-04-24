<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {

    Route::get('/', 'App\Http\Controllers\admin\LoginController@check')->name('login');
    Route::post('/login', 'App\Http\Controllers\admin\LoginController@login');

    Route::group(['middleware' => 'auth:admin'], function () {

        Config::set('auth.defines', 'admin');
        Config::set('auth.defaults.guard' , 'admin');

        Route::group(['middleware' => 'is_admin'], function () {

            Route::get('/dashboard', 'App\Http\Controllers\admin\DashboardController@index');
            Route::get('/logout', 'App\Http\Controllers\admin\LoginController@logout');
            Route::get('/cities/{id}', function (Request $request,$id) {
                return  (\App\Models\admin\Areas::where('region_id','=',$id)->get());
            });
            Route::resource('stores', 'App\Http\Controllers\admin\StoresController');
            Route::resource('categories', 'App\Http\Controllers\admin\CategoriesController');

            Route::resource('sub-categories', 'App\Http\Controllers\admin\SubCategoriesController');

            Route::resource('orders', 'App\Http\Controllers\admin\OrdersController');

            Route::resource('clerks', 'App\Http\Controllers\admin\ClerksController');
            Route::resource('users', 'App\Http\Controllers\admin\UsersController');

            Route::resource('admins', 'App\Http\Controllers\admin\AdminsController');

            Route::resource('regions', 'App\Http\Controllers\admin\RegionsController');
            Route::resource('areas', 'App\Http\Controllers\admin\AreasController');

            Route::resource('settings', 'App\Http\Controllers\admin\SettingsController');

        });
    });
});


Route::group(['prefix' => 'clerk', 'as' => 'clerk.'], function () {

    Route::get('/', 'App\Http\Controllers\clerk\LoginController@check')->name('login');
    Route::post('/login', 'App\Http\Controllers\clerk\LoginController@login');

    Route::group(['middleware' => 'auth:clerk'], function () {
        Config::set('auth.defines', 'clerk');
        Config::set('auth.defaults.guard' , 'clerk');
        Route::group(['middleware' => 'is_clerk'], function () {

            Route::get('/dashboard', 'App\Http\Controllers\clerk\DashboardController@index');
            Route::get('/logout', 'App\Http\Controllers\clerk\LoginController@logout');


            Route::resource('sub-categories', 'App\Http\Controllers\clerk\SubCategoriesController');
            Route::resource('items', 'App\Http\Controllers\clerk\ItemsController');
            Route::resource('store', 'App\Http\Controllers\clerk\StoreController');

            Route::get('/cities/{id}', function (Request $request,$id) {
                return  (\App\Models\admin\Areas::where('region_id','=',$id)->get());
            });
            Route::resource('bundles', 'App\Http\Controllers\clerk\BundlesController');



            Route::resource('orders', 'App\Http\Controllers\clerk\OrdersController');
            Route::resource('orders/{id}/accept', 'App\Http\Controllers\clerk\OrdersController');
            Route::resource('orders/{id}/cancel', 'App\Http\Controllers\clerk\OrdersController');
            Route::resource('orders/{id}/deliver', 'App\Http\Controllers\clerk\OrdersController');
            Route::resource('orders/{id}/complete', 'App\Http\Controllers\clerk\OrdersController');

            Route::resource('clerks', 'App\Http\Controllers\clerk\ClerksController');
            Route::resource('profile', 'App\Http\Controllers\clerk\ProfileController');

        });
    });
});



Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/clr', function () {
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    return "done";
});

/*Route::get('/admin', function () {
    return view('welcome');
})->name('admin.home')->middleware('is_clerk') ;
       */
