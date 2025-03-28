<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UnassignedUserController extends Controller
{
    // Search for unassigned users.
    public function search(Request $request)
    {
        $search = $request->input('search');

        if (!$search) {
            return redirect()->route('admin.notifications.unregister-user');
        }

        // Fetch the role ID for the "Guest" role
        $guestRole = Role::where('role', 'Guest')->first();

        if (!$guestRole) {
            // Handle the case where the "Guest" role does not exist
            return redirect()->back()->with('error', 'Guest role not found. Please contact the administrator.');
        }

        $guestRoleId = $guestRole->role_id; // Get the role ID

        $users = User::where('role_id', $guestRoleId)
            ->where(function ($query) use ($search) {
                $query->where('username', 'LIKE', "%{$search}%")
                    ->orWhere('user_code', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('first_name', 'LIKE', "%{$search}%")
                    ->orWhere('last_name', 'LIKE', "%{$search}%");
            })
            ->paginate(10);

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
        $student_percentage_change = min(round($student_percentage_change, 2), 100);

        // Inquiry
        $inquiries = Inquiry::all();

        // Get the current month's new inquiry count
        $current_month_inquiries = Inquiry::whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        // Get the previous month's new inquiry count
        $previous_month_inquiries = Inquiry::whereYear('created_at', Carbon::now()->subMonth()->year)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->count();

        // Calculate the percentage change
        $inquiry_percentage_change = 0;
        if ($previous_month_inquiries > 0) {
            $inquiry_percentage_change = (($current_month_inquiries - $previous_month_inquiries) / $previous_month_inquiries) * 100;
        }

        // Round the percentage to 2 decimal places
        $inquiry_percentage_change = min(round($inquiry_percentage_change, 2), 100);

        // Fetch the role ID for the "Guest" role
        $guestRole = Role::where('role', 'Guest')->first();

        if (!$guestRole) {
            // Handle the case where the "Guest" role does not exist
            return redirect()->back()->with('error', 'Guest role not found. Please contact the administrator.');
        }

        $guestRoleId = $guestRole->role_id; // Get the role ID

        // Fetch users with the "Guest" role and no faculty_id (unassigned users)
        $unassigned_users = User::where('role_id', $guestRoleId)->get();

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
        $unassigned_user_percentage_change = 0;
        if ($previous_month_unassigned_users > 0) {
            $unassigned_user_percentage_change = (($current_month_unassigned_users - $previous_month_unassigned_users) / $previous_month_unassigned_users) * 100;
        }

        // Round the percentage to 2 decimal places
        $unassigned_user_percentage_change = min(round($unassigned_user_percentage_change, 2), 100);

        return view('admin.notificationsunregister', compact('users', 'search', 'total_students', 'student_percentage_change', 'inquiries', 'inquiry_percentage_change', 'unassigned_users', 'unassigned_user_percentage_change'));
    }

    // Display a listing of the resource.
    public function index(Request $request)
    {
        $sort = $request->input('sort', 'desc'); // Default to 'desc' if no sort is selected

        // Fetch the role ID for the "Guest" role
        $guestRole = Role::where('role', 'Guest')->first();

        if (!$guestRole) {
            // Handle the case where the "Guest" role does not exist
            return redirect()->back()->with('error', 'Guest role not found. Please contact the administrator.');
        }

        $guestRoleId = $guestRole->role_id; // Get the role ID

        // Fetch users with the "Guest" role and no faculty_id (unassigned users)
        $unassigned_users = User::where('role_id', $guestRoleId)->get();

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
        $unassigned_user_percentage_change = 0;
        if ($previous_month_unassigned_users > 0) {
            $unassigned_user_percentage_change = (($current_month_unassigned_users - $previous_month_unassigned_users) / $previous_month_unassigned_users) * 100;
        }

        // Round the percentage to 2 decimal places
        $unassigned_user_percentage_change = min(round($unassigned_user_percentage_change, 2), 100);

        // Inquiry
        $inquiries = Inquiry::all();

        // Get the current month's new inquiry count
        $current_month_inquiries = Inquiry::whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        // Get the previous month's new inquiry count
        $previous_month_inquiries = Inquiry::whereYear('created_at', Carbon::now()->subMonth()->year)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->count();

        // Calculate the percentage change
        $inquiry_percentage_change = 0;
        if ($previous_month_inquiries > 0) {
            $inquiry_percentage_change = (($current_month_inquiries - $previous_month_inquiries) / $previous_month_inquiries) * 100;
        }

        // Round the percentage to 2 decimal places
        $inquiry_percentage_change = min(round($inquiry_percentage_change, 2), 100);

        $users = User::where('role_id', $guestRoleId) // Get the id of Guest role
            ->orderBy('created_at', $sort)
            ->paginate(10)
            ->appends(['sort' => $sort]);

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
        $student_percentage_change = min(round($student_percentage_change, 2), 100);

        return view('admin.notificationsunregister', compact('unassigned_users', 'unassigned_user_percentage_change', 'inquiries', 'inquiry_percentage_change', 'users', 'total_students', 'student_percentage_change', 'sort'));
    }
}
