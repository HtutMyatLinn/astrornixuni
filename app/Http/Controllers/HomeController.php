<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditAccountSettingRequest;
use App\Http\Requests\UserEditRequest;
use App\Models\BrowserStat;
use App\Models\Contribution;
use App\Models\Faculty;
use App\Models\Inquiry;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function administrator()
    {
        // Get the total number of users
        $total_users = User::all();

        // Get the current month's user count
        $current_month_users = User::whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        // Get the previous month's user count
        $previous_month_users = User::whereYear('created_at', Carbon::now()->subMonth()->year)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->count();

        // Calculate the percentage change
        $percentage_change = 0;
        if ($previous_month_users > 0) {
            $percentage_change = (($current_month_users - $previous_month_users) / $previous_month_users) * 100;
        }

        // Round the percentage to 2 decimal places
        $percentage_change = round($percentage_change, 2);

        // Inquiry
        $inquiries = Inquiry::all();

        // Get the current month's inquiry count
        $current_month_inquiries = User::whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        // Get the previous month's inquiry count
        $previous_month_inquiries = User::whereYear('created_at', Carbon::now()->subMonth()->year)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->count();

        // Calculate the percentage change
        $inquiry_percentage_change = 0;
        if ($previous_month_users > 0) {
            $inquiry_percentage_change = (($current_month_inquiries - $previous_month_inquiries) / $previous_month_inquiries) * 100;
        }

        // Round the percentage to 2 decimal places
        $inquiry_percentage_change = round($inquiry_percentage_change, 2);

        $total_students = User::whereHas('role', function ($query) {
            $query->where('role', 'Student');
        })->get();

        // Get the current month's student count
        $current_month_students = User::whereHas('role', function ($query) {
            $query->where('role', 'Student');
        })
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        // Get the previous month's student count
        $previous_month_students = User::whereHas('role', function ($query) {
            $query->where('role', 'Student');
        })
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->count();

        // Calculate the percentage change
        $student_percentage_change = 0;
        if ($previous_month_students > 0) {
            $student_percentage_change = (($current_month_students - $previous_month_students) / $previous_month_students) * 100;
        }

        // Round the percentage to 2 decimal places
        $student_percentage_change = round($student_percentage_change, 2);

        $faculties = Faculty::all();
        $contributions = Contribution::where('contribution_status', 'Upload')->paginate(10);
        $rejected_contributions = Contribution::where('contribution_status', 'Reject')->paginate(10);
        $published_contributions = Contribution::where('contribution_status', 'Publish')->paginate(10);

        // Get browser data
        $browserStats = BrowserStat::all();
        $labels = $browserStats->pluck('browser_name');
        $data = $browserStats->pluck('visit_count');

        return view('admin.index', compact('total_users', 'total_students', 'student_percentage_change', 'percentage_change', 'labels', 'data', 'inquiries', 'inquiry_percentage_change', 'faculties', 'contributions', 'rejected_contributions', 'published_contributions'));
    }

    public function adminAccountSetting()
    {
        return view('admin.accountsetting');
    }

    public function adminEditAccountSetting(EditAccountSettingRequest $request, string $id)
    {
        $user = User::find($id);

        // Update user data
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->username = $request->username;
        $user->save();

        // Redirect to roles index page with a success message
        return redirect()->back()->with('success', 'Your account updated successfully.');
    }

    public function administratorNotificationsPassword()
    {
        $unassigned_users = User::whereNull('role_id')->get();

        // Get the current month's unassigned user count
        $current_month_unassigned_users = User::whereNull('role_id')
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        // Get the previous month's unassigned user count
        $previous_month_unassigned_users = User::whereNull('role_id')
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->count();

        // Calculate the percentage change
        $assigned_user_percentage_change = 0;
        if ($previous_month_unassigned_users > 0) {
            $assigned_user_percentage_change = (($current_month_unassigned_users - $previous_month_unassigned_users) / $previous_month_unassigned_users) * 100;
        }

        // Round the percentage to 2 decimal places
        $assigned_user_percentage_change = round($assigned_user_percentage_change, 2);

        // New inquiry
        $new_inquiries = Inquiry::where('inquiry_status', 'Pending')->get();

        // Get the current month's new inquiry count
        $current_month_new_inquiries = Inquiry::where('inquiry_status', 'Pending')
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        // Get the previous month's new inquiry count
        $previous_month_new_inquiries = Inquiry::where('inquiry_status', 'Pending')
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->count();

        // Calculate the percentage change
        $new_inquiry_percentage_change = 0;
        if ($previous_month_new_inquiries > 0) {
            $new_inquiry_percentage_change = (($current_month_new_inquiries - $previous_month_new_inquiries) / $previous_month_new_inquiries) * 100;
        }

        // Round the percentage to 2 decimal places
        $new_inquiry_percentage_change = round($new_inquiry_percentage_change, 2);

        // Total student
        $total_students = User::whereHas('role', function ($query) {
            $query->where('role', 'Student');
        })->get();

        // Get the current month's student count
        $current_month_students = User::whereHas('role', function ($query) {
            $query->where('role', 'Student');
        })
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        // Get the previous month's student count
        $previous_month_students = User::whereHas('role', function ($query) {
            $query->where('role', 'Student');
        })
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->count();

        // Calculate the percentage change
        $student_percentage_change = 0;
        if ($previous_month_students > 0) {
            $student_percentage_change = (($current_month_students - $previous_month_students) / $previous_month_students) * 100;
        }

        // Round the percentage to 2 decimal places
        $student_percentage_change = round($student_percentage_change, 2);
        $contributions = Contribution::where('contribution_status', 'Upload')->get();

        return view('admin.notificationspassword', compact('unassigned_users', 'assigned_user_percentage_change', 'new_inquiries', 'new_inquiry_percentage_change', 'total_students', 'student_percentage_change', 'contributions'));
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
        $user->status = $request->status;
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
    public function marketingmanagerAccountSetting()
    {
        return view('marketingmanager.accountsetting');
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
    public function marketingcoordinatorGuestManagement(Request $request)
    {
        // Get the logged-in user
        $coordinator = auth()->user();

        // Get the faculty ID of the logged-in coordinator
        $facultyId = $coordinator->faculty_id;

        // Start building the query
        $query = User::where('faculty_id', $facultyId)
            ->where('role_id', 5); // Assuming 'guest' is the role_id for guests

        // Apply search filter
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('username', 'LIKE', "%{$search}%")
                    ->orWhere('first_name', 'LIKE', "%{$search}%")
                    ->orWhere('last_name', 'LIKE', "%{$search}%");
            });
        }

        // Apply status filter
        if ($request->has('status')) {
            $status = $request->input('status');
            $query->where('status', $status);
        }

        // Apply sorting
        $sort = $request->input('sort', 'last_login_date');
        $order = $request->input('order', 'desc');
        $query->orderBy($sort, $order);

        // Paginate the results
        $guests = $query->paginate(10);

        return view('marketingcoordinator.guestmanagement', compact('guests'));
    }

    public function updateGuestStatus(Request $request, $userId)
    {
        $request->validate([
            'status' => 'required|in:0,1', // Ensure status is either 0 or 1
        ]);

        $user = User::findOrFail($userId);
        $user->status = (int) $request->status; // Cast to integer
        $user->save();

        return redirect()->route('marketingcoordinator.guest-management')->with('success', 'Status updated successfully.');
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
        $contributions = Contribution::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        $trendingContributions = Contribution::orderBy('view_count', 'desc')
            ->limit(4) // Adjust the limit as needed
            ->get();

        return view('student.index', compact('contributions', 'trendingContributions'));
    }
}
