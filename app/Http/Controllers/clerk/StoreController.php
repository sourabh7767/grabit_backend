<?php

namespace App\Http\Controllers\clerk;

use App\Http\Controllers\Controller;
use App\Models\clerk\Categories;
use App\Models\clerk\Regions;
use App\Models\clerk\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $store_id=$request->session()->get('store_id');
        $data['title'] = 'Store';
        $data['stores'] = Store::where('id',$store_id)->get();
        $data['section'] = "Store";

        return view('clerk/stores/list', $data);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\clerk\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function edit(Store $store,Request $request)
    {
        $store_id=$request->session()->get('store_id');
        $data['title'] = 'Store';
        $data['stores'] = Store::where('id',$store_id)->first();
        $data['section'] = "Store";
        $data['categories']=Categories::all();
        $data['regions']=Regions::all();
        return view('clerk/stores/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\clerk\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Store $store)
    {
        $validatedData = $request->validate([
            'ar_name' => 'required|min:3|max:255',
            'en_name' => 'required|min:3|max:255',
            'category' => 'required',
            'location' => 'required|min:5|max:255',
            'phone' => 'required|min:11|max:13',
            'delivery_price' => 'required',
            'cities' => 'required',
            'region' => 'required',
            'longitude' => 'required',
            'latitude' => 'required',
        ]);


        if(!empty($request->logo)){

            $imageName = time().'.'.$request->img->extension();
            $request->img->move(public_path('images/stores'), $imageName);

        }else{
            $imageName=$request->img_src;
        }

        $store=Store::find($request->segment(3))  ;

        $store->en_name= $request->en_name;
        $store->ar_name=$request->ar_name;
        $store->category_id=$request->category;
        $store->location=$request->location;
        $store->phone=$request->phone;
        $store->delivery_price=$request->delivery_price;

        $store->longitude=$request->longitude;
        $store->latitude=$request->latitude;
        $store->city=$request->cities;
        $store->region=$request->region;
        $store->logo=$imageName  ;

        $store->save();


        $request->session()->flash('message', 'Successfully Update Store!');

        return redirect('clerk/store/');
    }



}
