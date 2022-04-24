<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Regions;
use Illuminate\Http\Request;

class RegionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'Regions';
        $data['regions'] = Regions::all();
        $data['section'] = "Regions";

        return view('admin/regions/list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = 'Regions';
        $data['section'] = "Regions";


        return view('admin/regions/new', $data);
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
            'region_name_ar' => 'required|min:3|max:255',
            'region_name_en' => 'required|min:3|max:255',

        ]);


        Regions::create([
            'region_name_ar'=> $request->region_name_ar,
            'region_name_en'=>$request->region_name_en,

        ]);


        $request->session()->flash('message', 'Successfully Add New Region!');

         return redirect('admin/regions/create');
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
    public function edit(Request $request,Regions $region)
    {
        $data['title'] = 'Regions';
        $data['section'] = "Regions";
        $data['region'] = Regions::where('id', $request->segment(3))->first();

        
        return view('admin/regions/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\admin\Stores  $stores
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Regions $regions)
    {

        $validatedData = $request->validate([
            'region_name_ar' => 'required|min:3|max:255',
            'region_name_en' => 'required|min:3|max:255',

        ]);



        $region=Regions::find($request->segment(3))  ;

        $region->region_name_ar= $request->region_name_ar;
        $region->region_name_en=$request->region_name_en;


        $region->save();


        $request->session()->flash('message', 'Successfully Update Region!');

        return redirect('admin/regions/'.$request->segment(3).'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\admin\Stores  $stores
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Regions $regions)
    {
        Regions::destroy($request->segment(3));
        return redirect('admin/regions');
    }
}
