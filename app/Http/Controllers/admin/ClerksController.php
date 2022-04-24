<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Clerks;
use App\Models\admin\Stores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClerksController extends Controller
{
    public function index()
    {
        $data['title'] = 'Clerks';
        $data['clerks'] = Clerks::all();
        $data['section'] = "Clerks";

        return view('admin/clerks/list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = 'Clerks';
        $data['section'] = "clerks";
        $data['stores'] = Stores::all();

        return view('admin/clerks/new', $data);
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
            'phone' => 'required|min:11|max:13',
            'email' => 'required' ,
            'store_id' => 'required'


        ]);

        $password=  Hash::make($request->password);

        Clerks::create([
            'name'=> $request->name,
            'password'=>$password,
            'phone'=>$request->phone,
            'store_id'=>$request->store_id,
            'email'=>$request->email,
            'is_manager'=>1,
            'active'=>1
        ]);


        $request->session()->flash('message', 'Successfully Add New Clerk!');

          return redirect('admin/clerks/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\admin\Clerks $clerks
     * @return \Illuminate\Http\Response
     */
    public function show(Clerks $clerks)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\admin\Clerks $clerks
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,Clerks $clerks)
    {
        $data['title'] = 'Clerks';
        $data['section'] = "Clerks";
        $data['clerks'] = Clerks::where('id', $request->segment(3))->first();
        $data['stores'] = Stores::all();
        return view('admin/clerks/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\admin\Clerks $clerks
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Clerks $clerks)
    {


        $validatedData = $request->validate([
            'name' => 'required|min:3|max:255',
            'password' => 'required|min:8|max:16',
            'phone' => 'required|min:11|max:13',
            'email' => 'required' ,
            'store_id' => 'required'
        ]);

        $password=  Hash::make($request->password);

        $clerks=Clerks::find($request->segment(3))  ;

        $clerks->name= $request->name;
        $clerks->email=$request->email;
        $clerks->phone=$request->phone;
        $clerks->store_id=$request->store_id;
        $clerks->password=$password;

        $clerks->save();


        $request->session()->flash('message', 'Successfully Update Clerk!');


        return redirect('admin/clerks/'.$request->segment(3).'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\admin\Clerks $clerks
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Clerks $clerks)
    {
        Clerks::destroy($request->segment(3));
        return redirect('admin/clerks');
    }
}
