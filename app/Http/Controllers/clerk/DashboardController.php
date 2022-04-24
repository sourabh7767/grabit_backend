<?php

namespace App\Http\Controllers\clerk;

use App\Http\Controllers\Controller;
use App\Models\Admin\Audit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth:clerk', ['except' => ['login', 'check']]);

    }
    protected function guard()
    {
        return Auth::guard('clerk');
    }
    public function index()
    {



        $data['title'] = 'Dashboard';
        $data['section'] = 'Dashboard';
        return view('clerk/dashboard', $data);
    }
}
