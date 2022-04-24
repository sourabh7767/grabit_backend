<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Categories;
use App\Models\admin\SubCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubCategoriesController extends Controller
{
    public function index()
    {
        $data['title'] = 'Sub Categories';
        $data['sub_categories'] = SubCategories::all();
        $data['section'] = "Sub Categories";

        return view('admin/sub-categories/list', $data);
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
        $data['title'] = 'Sub Categories';
        $data['section'] = "Sub Categories";
        $data['categories']=Categories::all();
        return view('admin/sub-categories/new', $data);
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
            'category' => 'required',
            'img' => 'required',

        ]);

        $imageName = time().'.'.$request->img->extension();

        $request->img->move(public_path('images/sub-categories'), $imageName);

        SubCategories::create([
            'sub_category_name_ar'=> $request->category_name_ar,
            'sub_description_ar'=>$request->description_ar,
            'sub_category_name'=>$request->category_name,
            'sub_description'=>$request->description,
            'category_id'=>$request->category,
            'img'=> $imageName,

        ]);


        $request->session()->flash('message', 'Successfully Add New Store!');

          return redirect('admin/sub-categories/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\admin\SubCategories $SubCategories
     * @return \Illuminate\Http\Response
     */
    public function show(Stores $stores)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\admin\SubCategories $SubCategories
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,SubCategories $SubCategories)
    {
        $data['title'] = 'Sub Categories';
        $data['section'] = "Sub Categories";
        $data['SubCategories'] = SubCategories::where('id', $request->segment(3))->first();
       
        $data['categories']=Categories::all();
        return view('admin/sub-categories/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\admin\Stores  $stores
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubCategories $SubCategories)
    {

        $validatedData = $request->validate([
            'category_name_ar' => 'required|min:3|max:255',
            'description_ar' => 'required|min:3|max:255',
            'category_name' => 'required|min:3',
            'description' => 'required|min:3|max:255',
            'category' => 'required',

        ]);


        if(!empty($request->img)){

            $imageName = time().'.'.$request->img->extension();
            $request->img->move(public_path('images/sub-categories'), $imageName);

        }else{
            $imageName=$request->img_src  ;
        }

        $subcategories=SubCategories::find($request->segment(3))  ;
      
        $subcategories->sub_category_name_ar= $request->category_name_ar;
        $subcategories->sub_description_ar=$request->description_ar;
        $subcategories->sub_category_name=$request->category_name;
        $subcategories->sub_description=$request->description;
        $subcategories->category_id=$request->category;
        $subcategories->img=$imageName  ;

        $subcategories->save();


        $request->session()->flash('message', 'Successfully Update Sub Category!');

        return redirect('admin/sub-categories/'.$request->segment(3).'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\admin\SubCategories $SubCategories
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,SubCategories $SubCategories)
    {
        SubCategories::destroy($request->segment(3));
        return redirect('admin/sub-categories');
    }
}
