<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Categories;
use App\Models\admin\Regions;
use App\Models\admin\Stores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'Stores';
        $data['stores'] = Stores::all();
        $data['section'] = "Stores";

        return view('admin/stores/list', $data);
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = 'Stores';
        $data['section'] = "Stores";
        $data['regions']=Regions::all();
        $data['categories']=Categories::all();
        return view('admin/stores/new', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'ar_name' => 'required|min:3|max:255',
            'en_name' => 'required|min:3|max:255',
            'category' => 'required',
            'location' => 'required|min:5|max:255',
            'phone' => 'required|min:11|max:13',
            'delivery_price' => 'required',
            'logo' => 'required',
            'region' => 'required',
            'cities' => 'required',
        ]);

        $imageName = time().'.'.$request->logo->extension();


        $request->logo->move(public_path('images/stores'), $imageName);

        Stores::create([
            'en_name'=> $request->en_name,
            'ar_name'=>$request->ar_name,
            'category_id' => $request->category,
            'location'=>$request->location,
            'phone'=>$request->phone,
            'delivery_price'=>$request->delivery_price,
            'region'=>$request->region,
            'city'=> $request->cities,
            'logo'=>$imageName
        ]);


        $request->session()->flash('message', 'Successfully Add New Store!');

       return redirect('admin/stores/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\admin\Stores  $stores
     * @return \Illuminate\Http\Response
     */
    public function show(Stores $stores)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\admin\Stores  $stores
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,Stores $stores)
    {
        $data['title'] = 'Dashboard';
        $data['section'] = "Stores";
        $data['store'] = Stores::where('id', $request->segment(3))->first();
        $data['regions']=Regions::all();
        $data['categories']=Categories::all();
        return view('admin/stores/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\admin\Stores  $stores
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stores $stores)
    {

            $validatedData = $request->validate([
                'ar_name' => 'required|min:3|max:255',
                'en_name' => 'required|min:3|max:255',
                'category' => 'required',
                'location' => 'required|min:5|max:255',
                'phone' => 'required|min:11|max:13',
                'delivery_price' => 'required',
                'region' => 'required',
                'cities' => 'required',
            ]);


        if(!empty($request->logo)){

            $imageName = time().'.'.$request->logo->extension();
            $request->logo->move(public_path('images/stores'), $imageName);

        }else{
            $imageName=$request->img_src  ;
        }

        $store=Stores::find($request->segment(3))  ;

            $store->en_name= $request->en_name;
            $store->ar_name=$request->ar_name;
            $store->category_id=$request->category;
            $store->location=$request->location;
            $store->phone=$request->phone;
            $store->delivery_price=$request->delivery_price;
            $store->region=$request->region;
            $store->city=$request->cities;
            $store->logo=$imageName  ;

            $store->save();


        $request->session()->flash('message', 'Successfully Update Store!');

        return redirect('admin/stores/'.$request->segment(3).'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\admin\Stores  $stores
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Stores $stores)
    {
        Stores::destroy($request->segment(3));
        return redirect('admin/stores');
    }
}
