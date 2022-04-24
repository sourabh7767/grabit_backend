<?php

namespace App\Http\Controllers\clerk;

use App\Http\Controllers\Controller;
use App\Models\clerk\SubCategories;
use App\Models\user\Categories;
use Illuminate\Http\Request;

class SubCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $data['title'] = 'Sub Categories';
        $store_id=$request->session()->get('store_id');
        $data['sub_categories'] = SubCategories::where('store_id',$store_id)->get();
        $data['section'] = "Sub Categories";

        return view('clerk/sub-categories/list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = 'Sub Categories';
        $data['section'] = "Sub Categories";
        $data['categories']=Categories::all();
        return view('clerk/sub-categories/new', $data);
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
            'category_name_ar' => 'required|min:3|max:255',
            'description_ar' => 'required|min:3|max:255',
            'category_name' => 'required|min:3',
            'description' => 'required|min:3|max:255',
            'img' => 'required',
        ]);

        $imageName = time().'.'.$request->img->extension();
        $store_id=$request->session()->get('store_id');

        $request->img->move(public_path('images/sub-categories'), $imageName);

        SubCategories::create([
            'sub_category_name_ar'=> $request->category_name_ar,
            'sub_description_ar'=>$request->description_ar,
            'sub_category_name'=>$request->category_name,
            'sub_description'=>$request->description,
            'img'=> $imageName,
            'store_id'=>$store_id,
        ]);


        $request->session()->flash('message', 'Successfully Add New Store!');

          return redirect('clerk/sub-categories/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\clerk\SubCategories  $subCategories
     * @return \Illuminate\Http\Response
     */
    public function show(SubCategories $subCategories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\clerk\SubCategories  $subCategories
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,SubCategories $subCategories)
    {
        $data['title'] = 'Sub Categories';
        $data['section'] = "Sub Categories";
        $store_id=$request->session()->get('store_id');
        $data['SubCategories'] = SubCategories::where('id', $request->segment(3))->where('store_id',$store_id)->first();
        $data['categories']=Categories::all();
              
        return view('clerk/sub-categories/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\clerk\SubCategories  $subCategories
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubCategories $subCategories)
    {
        $validatedData = $request->validate([
            'category_name_ar' => 'required|min:3|max:255',
            'description_ar' => 'required|min:3|max:255',
            'category_name' => 'required|min:3',
            'description' => 'required|min:3|max:255',

   
        ]);


        if(!empty($request->logo)){

            $imageName = time().'.'.$request->img->extension();
            $request->img->move(public_path('images/sub-categories'), $imageName);

        }else{
            $imageName=$request->img_src  ;
        }

        $store_id=$request->session()->get('store_id');

        $subcategories=SubCategories::find($request->segment(3))  ;

        $subcategories->sub_category_name_ar= $request->category_name_ar;
        $subcategories->sub_description_ar=$request->description_ar;
        $subcategories->sub_category_name=$request->category_name;
        $subcategories->sub_description=$request->description;
       // $subcategories->category_id=$request->category;
        $subcategories->img=$imageName  ;
        $subCategories->store_id=$store_id;

        $subcategories->save();


        $request->session()->flash('message', 'Successfully Update Sub Category!');

        return redirect('clerk/sub-categories/'.$request->segment(3).'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\clerk\SubCategories  $subCategories
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,SubCategories $subCategories)
    {
        SubCategories::destroy($request->segment(3));
        return redirect('clerk/sub-categories');
    }
}
