<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function administrator()
    {
        return view('admin.index');
    }

    public function administratorUserManagement()
    {
        return view('admin.usermanagement');
    }

    public function administratorNotifications()
    {
        return view('admin.notifications');
    }

    public function administratorReport()
    {
        return view('admin.reportandanalysis');
    }

    public function administratorSubmission()
    {
        return view('admin.submission');
    }

    public function administratorClosure()
    {
        return view('admin.closuredate');
    }

    public function administratorLogs()
    {
        return view('admin.logsandsecurity');
    }

    public function administratorInquiry()
    {
        return view('admin.inquirymanagement');
    }

    public function administratorEditUserData()
    {
        return view('admin.edituserdata');
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
