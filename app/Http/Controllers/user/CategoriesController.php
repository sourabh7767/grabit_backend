<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\user\Categories;
use App\Models\user\Stores;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{



    public function categories_list(Request $request)
    {
        if (!LoginController::auth($request)){
            return "error";
        };
       return Categories::all();


    }

   
    public function get_category(Request $request,$id)
    {
        if (!LoginController::auth($request)){
            return "error";
        };

      return Stores::where('category_id','=',$id)->get();



        
    }


}
