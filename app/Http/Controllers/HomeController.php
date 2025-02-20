<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function admin()
    {
        return view('admin.dashboard');
    }
    public function marketingmanager()
    {
        return view('marketingmanager.dashboard');
    }
    public function marketingcoordinator()
    {
        return view('marketingcoordinator.dashboard');
    }
    public function student()
    {
        return view('student.dashboard');
    }
}
