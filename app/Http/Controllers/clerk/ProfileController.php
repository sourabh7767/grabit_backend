<?php

namespace App\Http\Controllers\clerk;

use App\Http\Controllers\Controller;
use App\Models\clerk\Clerk;
use App\Models\clerk\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $store_id=$request->session()->get('store_id');
        $clerk_id=$request->session()->get('clerk_id');
        $data['title'] = 'Clerks';
        $data['section'] = "Clerks";
        $data['clerk'] = Clerk::where('id',$clerk_id)->where('store_id',$store_id)->first();


        return view('clerk/profile/edit', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\clerk\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\clerk\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\clerk\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {
        $store_id=$request->session()->get('store_id');
        $clerk_id=$request->session()->get('clerk_id');

        $auth_user=Clerk::where('id','=',$clerk_id)->first();
        $hash_check= Hash::check($request->oldpassword,$auth_user->password);

        if($hash_check) {
            
            $validatedData = $request->validate([

                'oldpassword' => 'required|min:8|max:16',
                'password' => 'required|min:8|max:16',
                'phone' => 'required|min:11|max:13',


            ]);

            $password = Hash::make($request->password);

            $clerks = Clerk::find($clerk_id);

            $clerks->phone = $request->phone;

            $clerks->password = $password;

            $clerks->save();


            $request->session()->flash('message', 'Successfully Update Profile!');


            return redirect('clerk/profile/');

            } else{
            $request->session()->flash('error', 'Check old Password !');
            return redirect('clerk/profile/');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\clerk\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
