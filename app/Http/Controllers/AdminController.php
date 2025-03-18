<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditAccountSettingRequest;
use App\Models\AcademicYear;
use App\Models\Contribution;
use App\Models\Faculty;
use App\Models\PasswordResetRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // Display a listing of the resource (default listing)
    public function index()
    {
        $admins = User::whereHas('role', function ($query) {
            $query->where('role', 'Admin');
        })->orderBy('updated_at', 'desc')->paginate(10);

        return view('admin.usermanagement', compact('admins'));
    }

    // Search for admins based on the search query
    public function search(Request $request)
    {
        $search = $request->input('search');

        if (!$search) {
            return redirect()->route('admin.user-management');
        }

        $admins = User::whereHas('role', function ($query) {
            $query->where('role', 'Admin');
        })
            ->where(function ($query) use ($search) {
                $query->where('username', 'LIKE', "%{$search}%")
                    ->orWhere('user_code', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('first_name', 'LIKE', "%{$search}%")
                    ->orWhere('last_name', 'LIKE', "%{$search}%");
            })
            ->paginate(10);

        return view('admin.usermanagement', compact('admins', 'search'));
    }

    // Sort admins by last login date
    public function sortByLastLoginDate(Request $request)
    {
        $order = $request->input('order', 'asc'); // Default to ascending if not specified

        $admins = User::whereHas('role', function ($query) {
            $query->where('role', 'Admin');
        })
            ->orderBy('last_login_date', $order)
            ->paginate(10);

        return view('admin.usermanagement', compact('admins', 'order'));
    }
    public function accountSetting()
    {
        // Get the currently authenticated admin user
        $user = Auth::user();
        return view('admin.accountsetting', compact('user'));
    }

    // Update the admin's account settings
    public function updateAccountSetting(EditAccountSettingRequest $request, $id)
    {
        // Find the admin user by ID
        $user = User::findOrFail($id);

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete the old profile image if it exists
            if ($user->profile_image && Storage::exists('public/profile_images/' . $user->profile_image)) {
                Storage::delete('public/profile_images/' . $user->profile_image);
            }

            // Store the new profile image in the 'storage/app/public/profile_images' directory
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = basename($path); // Save only the filename
        }

        // Update the admin's personal details
        $user->username = $request->input('username');
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');

        // Save changes to the database
        $user->save();

        // Redirect back with a success message
        return redirect()->route('admin.account-setting')->with('success', 'Account settings updated successfully.');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
            'new_password_confirmation' => 'required', // Add this line
        ], [
            'new_password.confirmed' => 'The password confirmation does not match.',
            'new_password_confirmation.required' => 'Please confirm your password.',
        ]);

        $user = Auth::user();

        // Check if the old password matches
        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->back()->withErrors(['old_password' => 'The old password is incorrect.']);
        }

        // Update the password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Password changed successfully.');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'password' => 'required|min:6',
        ]);

        $user = User::where('user_id', $request->user_id)->first();
        $user->password = Hash::make($request->password);

        // Update the PasswordResetRequest status
        PasswordResetRequest::where('user_id', $request->user_id)
            ->where('status', 'Pending') // Ensure only pending requests are updated
            ->update(['status' => 'Completed']);

        $user->save();

        return redirect()->back()->with('success', 'Password reset successfully.');
    }

    public function faculty_guest_search(Request $request)
    {
        // Get input values from the request
        $search = $request->input('search');
        $facultyId = $request->input('faculty');
        $sortOrder = $request->input('sort', 'desc');

        // Get the "Guest" role
        $guestRole = Role::where('role', 'Guest')->first();

        if (!$guestRole) {
            // Handle the case where the "Guest" role does not exist
            return redirect()->back()->with('error', 'Guest role not found. Please contact the administrator.');
        }

        $guestRoleId = $guestRole->role_id; // Get the role ID

        // Base query for users with the "Guest" role and non-null faculty_id
        $guestsQuery = User::where('role_id', $guestRoleId)
            ->whereNotNull('faculty_id');

        // Apply search filter if search term is provided
        if ($search) {
            $guestsQuery->where(function ($query) use ($search) {
                $query->where('username', 'LIKE', "%{$search}%")
                    ->orWhere('user_code', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('first_name', 'LIKE', "%{$search}%")
                    ->orWhere('last_name', 'LIKE', "%{$search}%");
            });
        }

        // Apply faculty filter if faculty ID is provided
        if ($facultyId) {
            $guestsQuery->where('faculty_id', $facultyId);
        }

        // Apply sorting and pagination
        $faculty_guests = $guestsQuery->orderBy('created_at', $sortOrder)
            ->paginate(10)
            ->appends($request->all());

        // Get all faculties for the filter dropdown
        $faculties = Faculty::all();

        // Return the view with data
        return view('admin.facultyguest', compact('faculty_guests', 'search', 'faculties', 'facultyId', 'sortOrder'));
    }

    public function faculty_guest_index()
    {
        $guestRole = Role::where('role', 'Guest')->first();

        if (!$guestRole) {
            // Handle the case where the "Guest" role does not exist
            return redirect()->back()->with('error', 'Guest role not found. Please contact the administrator.');
        }

        $guestRoleId = $guestRole->role_id; // Get the role ID

        $faculty_guests = User::where('role_id', $guestRoleId) // Get the id of Guest role
            ->whereNotNull('faculty_id')
            ->orderBy('created_at')
            ->paginate(10);
        $faculties = Faculty::all();

        return view('admin.facultyguest', compact('faculty_guests', 'faculties'));
    }

    public function report_index(Request $request)
    {
        $published_contributions = Contribution::where('contribution_status', 'Publish')
            ->orderBy('published_date')
            ->paginate(10);

        $commented_contributions = Contribution::whereHas('comments')
            ->with(['comments.user']) // Load comments and the users who made them
            ->orderBy('published_date', 'desc')
            ->paginate(10);

        // Get the selected academic year from the request
        $academicYear = $request->input('academic_year');

        // Fetch all faculties
        $all_faculties = Faculty::all();
        $faculties = Faculty::pluck('faculty', 'faculty_id');

        // Fetch contributions grouped by faculty and academic year
        $contributions = Contribution::query()
            ->when($academicYear, function ($query) use ($academicYear) {
                return $query->whereHas('intake', function ($q) use ($academicYear) {
                    $q->where('academic_year_id', $academicYear);
                });
            })
            ->with(['user.faculty', 'intake.academicYear'])
            ->get()
            ->groupBy('user.faculty.faculty_id');

        // Calculate total contributions
        $totalContributions = $contributions->flatten()->count();

        // Calculate total unique contributors
        $totalUniqueContributors = $contributions->flatten()->unique('user_id')->count();

        // Prepare data for the charts
        $labels = $faculties->values()->toArray();
        $countData = [];
        $percentageData = [];
        $contributorCountData = [];
        $contributorPercentageData = [];

        foreach ($faculties as $facultyId => $facultyName) {
            // Count contributions
            $count = $contributions->get($facultyId, collect())->count();
            $countData[] = $count; // Raw count of contributions
            $percentage = $totalContributions > 0 ? ($count / $totalContributions) * 100 : 0;
            $percentageData[] = round($percentage, 2); // Percentage of contributions

            // Count unique contributors
            $contributorCount = $contributions->get($facultyId, collect())->unique('user_id')->count();
            $contributorCountData[] = $contributorCount; // Count of unique contributors

            // Calculate percentage of unique contributors
            $contributorPercentage = $totalUniqueContributors > 0 ? ($contributorCount / $totalUniqueContributors) * 100 : 0;
            $contributorPercentageData[] = round($contributorPercentage, 2); // Percentage of unique contributors
        }

        // Fetch all academic years for the filter dropdown
        $academicYears = AcademicYear::pluck('academic_year', 'academic_year_id');

        return view('admin.reports', [
            'labels' => $labels,
            'countData' => $countData, // Pass count data (contributions) to the view
            'percentageData' => $percentageData, // Pass percentage data (contributions) to the view
            'contributorCountData' => $contributorCountData, // Pass contributor count data to the view
            'contributorPercentageData' => $contributorPercentageData, // Pass contributor percentage data to the view
            'academicYears' => $academicYears, // Pass academicYears to the view
            'published_contributions' => $published_contributions,
            'commented_contributions' => $commented_contributions,
            'all_faculties' => $all_faculties
        ]);
    }
}
