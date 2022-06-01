<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Audit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth:admin', ['except' => ['login', 'check']]);

    }
    protected function guard()
    {
        return Auth::guard('admin');
    }
    public function index()
    {

       // echo "hello";die;

        $data['title'] = 'Dashboard';
        $data['section'] = "Stores";

        return view('admin/dashboard', $data);
    }
}
