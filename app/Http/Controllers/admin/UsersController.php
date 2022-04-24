<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Users;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        $data['title'] = 'Users';
        $data['users'] = Users::all();
        $data['section'] = "Users";

        return view('admin/users/list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = 'Users';
        $data['section'] = "Users";

        return view('admin/users/new', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\admin\Users $users
     * @return \Illuminate\Http\Response
     */
    public function show(Stores $stores)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\admin\Users $users
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,Users $users)
    {
        $data['title'] = 'Users';
        $data['section'] = "Users";
        $data['user'] = Users::where('id', $request->segment(3))->first();

        return view('admin/users/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\admin\Users $users
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Users $users)
    {

        $validatedData = $request->validate([
            'active' => 'required',

        ]);



        $user=Users::find($request->segment(3))  ;

        $user->active= $request->active;


        $user->save();


        $request->session()->flash('message', 'Successfully Update Store!');

        return redirect('admin/users/'.$request->segment(3).'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\admin\Stores  $stores
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Users $users)
    {
        Users::destroy($request->segment(3));
        return redirect('admin/users');
    }
}
