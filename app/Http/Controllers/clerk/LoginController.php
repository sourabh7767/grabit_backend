<?php

namespace App\Http\Controllers\clerk;

use App\Http\Controllers\Controller;
use App\Models\clerk\Clerk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:clerk', ['except' => ['login', 'check']]);
    }


    public function check()

    {
        if (Auth::guard('clerk')->check()) {
            return redirect('clerk/dashboard');
        } else {
            return view('clerk/login');
        }
    }

    protected function guard()
    {
        return Auth::guard('clerk');
    }


    public function login(Request $request)
    {
        
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);
       // dd($request->email." - " .$request->password) ;


        if (Auth::guard('clerk')->attempt(['email' => $request->email, 'password' => $request->password, 'active' => 1])) {
            $request->session()->flash('status', 'Clerk Loged in');
            //add admin setcookie
            setcookie("clerkadminoth2020", "75454154578778", 0, "/");
            $clerk =Clerk::where('email',$request->email)->first();
            $request->session()->put('is_manager',$clerk->is_manager);
            $request->session()->put('store_id',$clerk->store_id);
            $request->session()->put('clerk_id',$clerk->id);
            return redirect('/clerk/dashboard');
        } else{

            $request->session()->flash('status', 'Username Wrong or Not Active');
         return redirect('/clerk');
        }


    }

    public function logout(Request $request)
    {
        //remove admin cookie
        unset($_COOKIE['adminoth2020']);
        setcookie("adminoth2020", "", time() - 3600, "/");
                $request->session()->remove('store_id');
                $request->session()->remove('clerk_id');
        Auth::logout();
        return redirect('/clerk');
    }
}
