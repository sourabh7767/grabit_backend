<?php

namespace App\Http\Controllers\clerk;

use App\Http\Controllers\Controller;
use App\Models\clerk\Clerk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClerksController extends Controller
{
    public function index(Request $request)
    {

        $store_id=$request->session()->get('store_id');
        $data['title'] = 'Clerks';
        $data['clerks'] = Clerk::where('store_id',$store_id)->get();
        $data['section'] = "Clerks";

        return view('clerk/clerks/list', $data);
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


        return view('clerk/clerks/new', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $store_id=$request->session()->get('store_id');
        $validatedData = $request->validate([
            'name' => 'required|min:3|max:255',
            'password' => 'required|min:8|max:16',
            'phone' => 'required|min:11|max:13',
            'email' => 'required' ,


        ]);

        $password=  Hash::make($request->password);
        
        Clerk::create([
            'name'=> $request->name,
            'password'=>$password,
            'phone'=>$request->phone,
            'store_id'=>$store_id,
            'email'=>$request->email,
        ]);


        $request->session()->flash('message', 'Successfully Add New Clerk!');

          return redirect('clerk/clerks/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\admin\Clerks $clerks
     * @return \Illuminate\Http\Response
     */
    public function show(Clerk $clerks)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\admin\Clerks $clerks
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,Clerk $clerks)
    {
        $store_id=$request->session()->get('store_id');
        $data['title'] = 'Clerks';
        $data['section'] = "Clerks";
        $data['clerk'] = Clerk::where('id', $request->segment(3))->where('store_id',$store_id)->first();

        return view('clerk/clerks/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\admin\Clerks $clerks
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Clerk $clerks)
    {


        $validatedData = $request->validate([
            'name' => 'required|min:3|max:255',
            'password' => 'required|min:8|max:16',
            'phone' => 'required|min:11|max:13',
            'email' => 'required' ,

        ]);

        $password=  Hash::make($request->password);

        $clerks=Clerk::find($request->segment(3))  ;

        $clerks->name= $request->name;
        $clerks->email=$request->email;
        $clerks->phone=$request->phone;

        $clerks->password=$password;

        $clerks->save();


        $request->session()->flash('message', 'Successfully Update Clerk!');


        return redirect('clerk/clerks/'.$request->segment(3).'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\admin\Clerks $clerks
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Clerk $clerks)
    {
        Clerk::destroy($request->segment(3));
        return redirect('clerk/clerks');
    }
}
