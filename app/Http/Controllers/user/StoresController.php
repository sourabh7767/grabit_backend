<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\user\Bundles;
use App\Models\user\Items;
use App\Models\user\Stores;
use App\Models\user\SubCategories;
use Illuminate\Http\Request;

class StoresController extends Controller
{

    public function store(Request $request,$id){
        if (!LoginController::auth($request)){
            return "error";
        };
        $bundleitemdetials=[];
        $i=0;
        $items=Items::where('store_id','=',$id)->where('status','=',1)->where('stock','>=',1)->get();
        $bundles=Bundles::where('store_id','=',$request->store_id)->where('status','=',1)->where('stock','>=',1)->get();
        foreach ($bundles as $bundle){

            $bundleitems=unserialize($bundle->items);
            foreach ($bundleitems as $bundleitem){
                $bundleitemdetials[$i]=Items::where('store_id','=',$request->store_id)->where('id','=',$bundleitem)->first();
                $i ++;
            }

            $bundle->items=$bundleitemdetials;
        }

        $data=array('bundles'=>$bundles,'items'=>$items);
        return json_encode($data);

    }

    public function store_details(Request $request,$id){
        if (!LoginController::auth($request)){
            return "error";
        };

        return Stores::where('id',$id)->first();

    }



    public function sub_categories(Request $request){
        if (!LoginController::auth($request)){
            return "error";
        };

        return SubCategories::where('store_id',$request->store_id)->get();
    }


    public function sub_category_items(Request $request,$id){
        if (!LoginController::auth($request)){
            return "error";
        };
        $bundleitemdetials=[];
        $i=0;
        $items=Items::where('store_id','=',$request->store_id)->where('sub_category_id','=',$id)->where('stock','>=',1)->get();
        $bundles=Bundles::where('store_id','=',$request->store_id)->where('sub_category_id','=',$id)->where('stock','>=',1)->get();
        foreach ($bundles as $bundle){

            $bundleitems=unserialize($bundle->items);
            foreach ($bundleitems as $bundleitem){
                $bundleitemdetials[$i]=Items::where('store_id','=',$request->store_id)->where('id','=',$bundleitem)->first();
                $i ++;
            }

            $bundle->items=$bundleitemdetials;
        }


       $data=array('bundles'=>$bundles,'items'=>$items);
        return json_encode($data);



    }


    public function stores(Request $request){

        if (!LoginController::auth($request)){
            return "error";
        };

        return Stores::where('city',$request->city_id)->get();

    }

}
