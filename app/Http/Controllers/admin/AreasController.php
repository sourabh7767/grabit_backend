<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Areas;
use App\Models\admin\Regions;
use Illuminate\Http\Request;

class AreasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'Areas';
        $data['areas'] = Areas::all();
        $data['section'] = "Areas";

        return view('admin/areas/list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = 'Areas';
        $data['section'] = "Areas";
        $data['regions']=Regions::all();

        return view('admin/areas/new', $data);
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
            'area_name_ar' => 'required|min:3|max:255',
            'area_name_en' => 'required|min:3|max:255',
            'region_id' => 'required',

        ]);


        Areas::create([
            'area_name_ar'=> $request->area_name_ar,
            'area_name_en'=>$request->area_name_en,
            'region_id'=>$request->region_id,

        ]);


        $request->session()->flash('message', 'Successfully Add New Area!');

       return redirect('admin/areas/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\admin\Stores  $stores
     * @return \Illuminate\Http\Response
     */
    public function show(Areas $areas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\admin\Stores  $stores
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,Areas $areas)
    {
        $data['title'] = 'Areas';
        $data['section'] = "Areas";
        $data['area'] = Areas::where('id', $request->segment(3))->first();
        $data['regions']=Regions::all();
        return view('admin/areas/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\admin\Areas $areas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Areas $areas)
    {

        $validatedData = $request->validate([
            'area_name_ar' => 'required|min:3|max:255',
            'area_name_en' => 'required|min:3|max:255',
            'region_id' => 'required',

        ]);



        $areas=Areas::find($request->segment(3))  ;

        $areas->area_name_ar= $request->area_name_ar;
        $areas->area_name_en=$request->area_name_en;
        $areas->region_id=$request->region_id;


        $areas->save();


        $request->session()->flash('message', 'Successfully Update Area!');

        return redirect('admin/areas/'.$request->segment(3).'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\admin\Stores  $stores
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Areas $areas)
    {
        Areas::destroy($request->segment(3));
        return redirect('admin/areas');
    }
}
