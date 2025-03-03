<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function administrator()
    {
        // Fetch users where role is not null, sorted by newest first, with pagination
        $total_users = User::all();
        $total_students = User::whereHas('role', function ($query) {
            $query->where('role', 'Student');
        })->get();

        return view('admin.index', compact('total_users', 'total_students'));
    }

    public function administratorUserManagement()
    {
        return view('admin.usermanagement');
    }

    public function administratorUserManagementStudent()
    {
        return view('admin.usermanagementstudent');
    }

    public function administratorUserManagementMarketingManager()
    {
        return view('admin.usermanagementmarketingmanager');
    }

    public function administratorUserManagementMarketingCoordinator()
    {
        return view('admin.usermanagementmarketingcoordinator');
    }

    public function administratorNotifications()
    {
        return view('admin.notifications');
    }

    public function administratorNotificationsPassword()
    {
        return view('admin.notificationspassword');
    }

    public function administratorNotificationsInquiry()
    {
        return view('admin.notificationsinquiry');
    }

    public function administratorClosure()
    {
        return view('admin.closuredate');
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
        return view('marketingmanager.index');
    }
    public function marketingcoordinator()
    {
        return view('marketingcoordinator.index');
    }
    public function marketingcoordinatorAccountSetting()
    {
        return view('marketingcoordinator.accountsetting');
    }
    public function marketingcoordinatorGuestManagement()
    {
        return view('marketingcoordinator.guestmanagement');
    }
    public function marketingcoordinatorSubmissionManagement()
    {
        return view('marketingcoordinator.submissionmanagement');
    }
    public function marketingcoordinatorSubmissionManagementViewDetailContribution()
    {
        return view('marketingcoordinator.submissionmanagementviewcontribution');
    }

    public function marketingcoordinatorProvideFeedBack()
    {
        return view('marketingcoordinator.feedback');
    }
    public function marketingcoordinatorPublishedContribution()
    {
        return view('marketingcoordinator.publishedcontribution');
    }
    public function marketingcoordinatorNotifications()
    {
        return view('marketingcoordinator.notifications');
    }
    public function student()
    {
        return view('student.index');
    }
}
