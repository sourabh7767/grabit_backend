<?php

namespace App\Http\Controllers\clerk;

use App\Http\Controllers\Controller;
use App\Models\clerk\Items;
use App\Models\clerk\SubCategories;
use Illuminate\Http\Request;

class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $store_id=$request->session()->get('store_id');
        $data['title'] = 'Items';
        $data['items'] = Items::where('store_id',$store_id)->get();
        $data['section'] = "Items";

        return view('clerk/items/list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $data['title'] = 'Items';
        $data['section'] = "Items";
        $data['sub_categories']=SubCategories::all();
        return view('clerk/items/new', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        date_default_timezone_set('Africa/Cairo');
        $validatedData = $request->validate([
            'ar_item_name' => 'required|min:3|max:255',
            'en_item_name' => 'required|min:3|max:255',
            'ar_description' => 'required|min:3|max:255',
            'en_description' => 'required|min:3|max:255',
            'sub_category_id' => 'required',
            'price' => 'required',
            'discount' => 'required',
            'img' => 'required',
            'stock' => 'required',


        ]);

        $imageName = time().'.'.$request->img->extension();
        $store_id=$request->session()->get('store_id');
        $request->img->move(public_path('images/items'), $imageName);

        Items::create([
            'ar_item_name'=> $request->ar_item_name,
            'en_item_name'=>$request->en_item_name,
            'ar_description'=>$request->ar_description,
            'en_description'=>$request->en_description,
            'sub_category_id'=>$request->sub_category_id,
            'price'=>$request->price,
            'discount'=>$request->discount,
            'status'=>$request->status??0,
            'stock'=>$request->stock,
            'store_id'=>$store_id,
            'price_time_out'=>$request->price_time_out,
            'created_at'=> date('Y-m-d H:i:s'),
            'img'=>$imageName
        ]);


        $request->session()->flash('message', 'Successfully Add New Item!');

        return redirect('clerk/items/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\clerk\Items  $items
     * @return \Illuminate\Http\Response
     */
    public function show(Items $items)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\clerk\Items  $items
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,Items $items)
    {
        $store_id=$request->session()->get('store_id');
        $data['title'] = 'Items';
        $data['section'] = "Items";
        $data['item'] = Items::where('id', $request->segment(3))->where('store_id',$store_id)->first();
        $data['sub_categories']=SubCategories::all();
        return view('clerk/items/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\clerk\Items  $items
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Items $items)
    {
        date_default_timezone_set('Africa/Cairo');
        $validatedData = $request->validate([
            'ar_item_name' => 'required|min:3|max:255',
            'en_item_name' => 'required|min:3|max:255',
            'ar_description' => 'required|min:3|max:255',
            'en_description' => 'required|min:3|max:255',
            'sub_category_id' => 'required',
            'price' => 'required',
            'discount' => 'required',
            'stock' => 'required',

        ]);


        if(!empty($request->logo)){

            $imageName = time().'.'.$request->img->extension();
            $request->img->move(public_path('images/items'), $imageName);

        }else{
            $imageName=$request->img_src  ;
        }

        $items=Items::find($request->segment(3))  ;

        $items->ar_item_name= $request->ar_item_name;
        $items->en_item_name=$request->en_item_name;
        $items->ar_description=$request->ar_description;
        $items->en_description=$request->en_description;
        $items->sub_category_id=$request->sub_category_id;
        $items->price=$request->price;
        $items->discount=$request->discount;
        $items->status=$request->status??0;
        $items->stock=$request->stock;
        $items->price_time_out=$request->price_time_out;
        $items->updated_at=date('Y-m-d H:i:s');
        $items->img=$imageName ;

        $items->save();


        $request->session()->flash('message', 'Successfully Update Item!');

        return redirect('clerk/items/'.$request->segment(3).'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\clerk\Items  $items
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Items $items)
    {
        Items::destroy($request->segment(3));
        return redirect('clerk/items');
    }
}
