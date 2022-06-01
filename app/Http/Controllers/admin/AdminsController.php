<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Admins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminsController extends Controller
{
    public function index()
    {
        $data['title'] = 'Admins';
        $data['admins'] = Admins::where('id','!=',1)->get();
        $data['section'] = "Admins";

        return view('admin/admins/list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = 'Admins';
        $data['section'] = "Admins";

        return view('admin/admins/new', $data);
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
            'name' => 'required|min:3|max:255',
            'password' => 'required|min:8|max:16',
            'email' => 'required'

        ]);
      $password=  Hash::make($request->password);


        Admins::create([
            'name'=> $request->name,
            'password'=>$password,
            'email'=>$request->email,
            'active' => 1
        ]);


        $request->session()->flash('message', 'Successfully Add New Admin!');

          return redirect('admin/admins/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\admin\Stores  $stores
     * @return \Illuminate\Http\Response
     */
    public function show(Admins $admins)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\admin\Stores  $stores
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,Admins $admins)
    {
        $data['title'] = 'Admins';
        $data['section'] = "Admins";
        $data['admins'] = Admins::where('id', $request->segment(3))->first();

        return view('admin/admins/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\admin\Stores  $stores
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admins $admins)
    {

        $validatedData = $request->validate([
            'name' => 'required|min:3|max:255',
            'password' => 'required|min:8|max:16',
            'email' => 'required'
        ]);


        $password=  Hash::make($request->password);
        $admin=Admins::find($request->segment(3))  ;

        $admin->name= $request->name;
        $admin->email=$request->email;
        $admin->password=$password;


        $admin->save();


        $request->session()->flash('message', 'Successfully Update Admin!');

        return redirect('admin/admins/'.$request->segment(3).'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\admin\Stores  $stores
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Admins $admins)
    {
        Admins::destroy($request->segment(3));
        return redirect('admin/admins');
    }
}
