<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Categories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'All Categories';
        $data['categories'] = Categories::all();
        $data['section'] = "Categories";

        return view('admin/categories/list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = 'Create Category';
        $data['section'] = "Categories";
        return view('admin/categories/new', $data);
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
            'category_name' => 'required|unique:category|min:3|max:255',
            'category_name_ar' => 'required|min:3|max:255',
            'description' => 'required|min:3|max:255',
            'description_ar' => 'required|min:3|max:255',
            'img' => 'required|min:5',
        ]);

        $imageName = time().'.'.$request->img->extension();
        $request->img->move(public_path('images/categories'), $imageName);

        Categories::create(['category_name'=> $request->category_name,
                   'category_name_ar'=>$request->category_name_ar,
                   'description'=>$request->description,
                   'description_ar'=>$request->description_ar,
                   'img'=>$imageName
        ]);


        $request->session()->flash('message', 'Successfully add new Category!');

        return redirect('admin/categories/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\admin\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function show(Categories $categories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\admin\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,Categories $categories)
    {
        $data['title'] = 'Edit Category';
        $data['section'] = "Categories";
        $data['category'] = Categories::where('id', $request->segment(3))->first();

        return view('admin/categories/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\admin\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Categories $categories)
    {
        $validatedData = $request->validate([
            'category_name' => 'required|unique:category|min:3|max:255',
            'category_name_ar' => 'required|min:3|max:255',
            'description' => 'required|min:3|max:255',
            'description_ar' => 'required|min:3|max:255',

        ]);
           if(!empty($request->img)){

               $imageName = time().'.'.$request->img->extension();
               $request->img->move(public_path('images/categories'), $imageName);

           }else{
               $imageName=$request->img_src  ;
           }

        $category=Categories::find($request->segment(3));

            $category->category_name= $request->category_name;
            $category->category_name_ar=$request->category_name_ar;
            $category->description=$request->description;
            $category->description_ar=$request->description_ar;
            $category->img=$imageName ;

        $category->save();


        $request->session()->flash('message', 'Successfully Update Category!');

        return redirect('admin/categories/'.$request->segment(3).'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\admin\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categories $categories,Request $request)
    {
        Categories::destroy($request->segment(3));
        return redirect('admin/categories');
    }
}
