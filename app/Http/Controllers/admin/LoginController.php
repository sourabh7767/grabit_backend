<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:admin', ['except' => ['login', 'check']]);
    }


    public function check()
    {
        if (Auth::guard('admin')->check()) {
            return redirect('admin/dashboard');
        } else {
            return view('admin/login');
        }
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }


    public function login(Request $request)
    {
       // echo bcrypt($request->password);die;
       // dd($request->password);
        //echo Hash::make('oth123oth'); exit;
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password, 'active' => 1])) {
            $request->session()->flash('status', 'Admin Loged in');
            //add admin setcookie
            setcookie("adminoth2020", "adminoth2020", 0, "/");

            return redirect('/admin/dashboard');
        } else {
            $request->session()->flash('status', 'Username Wrong or Not Active');
           return redirect('/admin');
        }


    }

    public function logout()
    {
        //remove admin cookie
        unset($_COOKIE['adminoth2020']);
        setcookie("adminoth2020", "", time() - 3600, "/");

        Auth::logout();
        return redirect('/admin');
    }
}
