<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserEditRequest;
use App\Models\Faculty;
use App\Models\Role;
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

    public function adminAccountSetting()
    {
        return view('admin.accountsetting');
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

    public function administratorInquiry()
    {
        return view('admin.inquirymanagement');
    }

    public function administratorEditUserData($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        $faculties = Faculty::all();

        return view('admin.edituserdata', compact('user', 'roles', 'faculties'));
    }

    public function administratorUpdateUserData(UserEditRequest $request, string $id)
    {
        $user = User::find($id);

        // Update user data
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->username = $request->username;
        $user->role_id = $request->role_id;
        $user->faculty_id = $request->faculty_id;
        $user->save();

        // Redirect to roles index page with a success message
        return redirect()->back()->with('success', 'User updated successfully.');
    }

    public function marketingmanager()
    {
        return view('marketingmanager.index');
    }

    public function marketingmanagerPublishedContribution()
    {
        return view('marketingmanager.publishedcontribution');
    }

    public function marketingmanagerPublishedContributionViewDetail()
    {
        return view('marketingmanager.publishedcontributionviewdetail');
    }



    public function marketingmanagerDownloadContribution()
    {
        return view('marketingmanager.downloadcontribution');
    }

    public function marketingmanagerReport()
    {
        return view('marketingmanager.report');
    }

    public function marketingmanagerNotifation()
    {
        return view('marketingmanager.notifications');
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
