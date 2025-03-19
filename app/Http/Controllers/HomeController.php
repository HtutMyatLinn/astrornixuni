<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditAccountSettingRequest;
use App\Http\Requests\UserEditRequest;
use App\Models\BrowserStat;
use App\Models\Contribution;
use App\Models\Faculty;
use App\Models\Inquiry;
use App\Models\PasswordResetRequest;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $total_contributions = Contribution::all();
        $pending_contributions = Contribution::where('contribution_status', 'Upload')->get();
        $selected_contributions = Contribution::where('contribution_status', 'Select')->get();
        $rejected_contributions = Contribution::where('contribution_status', 'Reject')->get();
        $published_contributions = Contribution::where('contribution_status', 'Publish')->get();

        // Get browser data
        $browserStats = BrowserStat::all();
        $labels = $browserStats->pluck('browser_name');
        $data = $browserStats->pluck('visit_count');

        return view('admin.index', compact('total_users', 'total_students', 'student_percentage_change', 'percentage_change', 'labels', 'data', 'inquiries', 'inquiry_percentage_change', 'faculties', 'total_contributions', 'pending_contributions', 'selected_contributions', 'rejected_contributions', 'published_contributions'));
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

    public function administratorNotificationsPassword(Request $request)
    {
        // Fetch the role ID for the "Guest" role
        $guestRole = Role::where('role', 'Guest')->first();

        if (!$guestRole) {
            // Handle the case where the "Guest" role does not exist
            return redirect()->back()->with('error', 'Guest role not found. Please contact the administrator.');
        }

        $guestRoleId = $guestRole->role_id; // Get the role ID

        // Fetch users with the "Guest" role and no faculty_id (unassigned users)
        $unassigned_users = User::where('role_id', $guestRoleId);

        // Handle search
        if ($request->has('search')) {
            $search = $request->input('search');
            $unassigned_users->where(function ($query) use ($search) {
                $query->where('username', 'like', "%{$search}%")
                    ->orWhere('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('user_code', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Handle sort
        $sort = $request->input('sort', 'desc');
        $unassigned_users->orderBy('created_at', $sort);

        // Handle filter
        if ($request->has('filter')) {
            $filter = $request->input('filter');
            if ($filter === 'Pending') {
                $unassigned_users->where('status', 'Pending');
            } elseif ($filter === 'Resolved') {
                $unassigned_users->where('status', 'Resolved');
            }
        }

        // Paginate results
        $unassigned_users = $unassigned_users->paginate(10)->appends([
            'sort' => $sort,
            'search' => $request->input('search'),
            'filter' => $request->input('filter'),
        ]);

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
        $unassigned_user_percentage_change = round($unassigned_user_percentage_change, 2);

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
        $inquiry_percentage_change = round($inquiry_percentage_change, 2);

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

        // Reset password users
        $reset_password_users = PasswordResetRequest::where('status', 'Pending')->paginate(5);

        // Round the percentage to 2 decimal places
        $student_percentage_change = round($student_percentage_change, 2);
        $contributions = Contribution::where('contribution_status', 'Upload')->get();

        return view('admin.notificationspassword', compact(
            'unassigned_users',
            'unassigned_user_percentage_change',
            'inquiries',
            'inquiry_percentage_change',
            'total_students',
            'student_percentage_change',
            'contributions',
            'reset_password_users'
        ));
    }

    public function administratorEditUserData($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        $faculties = Faculty::all();

        return view('admin.edituserdata', compact('user', 'roles', 'faculties'));
    }

    public function marketingcoordinatorEditUserData($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        $faculties = Faculty::all();

        return view('marketingcoordinator.edituserdata', compact('user', 'roles', 'faculties'));
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

    /**
     * Display the marketing manager dashboard with real data.
     */
    public function marketingmanager()
    {
        // Total Published Contributions (contribution_status = 'Publish')
        $totalPublishedContributions = Contribution::where('contribution_status', 'Publish')->count();

        // Active Faculty Participation (faculties with at least one contribution)
        $activeFacultyParticipation = Faculty::whereHas('users.contributions', function ($query) {
            $query->where('contribution_status', 'Publish');
        })->count();

        // Submission Trends This Year (contributions with view_count > 100)
        $submissionTrendsThisYear = Contribution::where('view_count', '>', 100)->count();

        // Total Contributions Submitted (all contributions)
        $totalContributionsSubmitted = Contribution::count();

        // Pass data to the view
        return view('marketingmanager.index', [
            'totalPublishedContributions' => $totalPublishedContributions,
            'activeFacultyParticipation' => $activeFacultyParticipation,
            'submissionTrendsThisYear' => $submissionTrendsThisYear,
            'totalContributionsSubmitted' => $totalContributionsSubmitted,
        ]);
    }
    public function marketingmanagerAccountSetting()
    {
        return view('marketingmanager.accountsetting');
    }
    /**
     * Display all published contributions for the marketing manager's dashboard.
     */
    public function marketingmanagerPublishedContribution()
    {
        // Fetch all contributions with status "Publish"
        $contributions = Contribution::where('contribution_status', 'Publish')
            ->with(['user', 'category']) // Eager load relationships
            ->paginate(20); // Paginate for better performance

        return view('marketingmanager.publishedcontribution', compact('contributions'));
    }

    // New method for downloading the contribution as a zip
    public function downloadContributionZip($contribution_id)
    {
        $contribution = Contribution::findOrFail($contribution_id);

        // Path where the zip file will be stored
        $zip_file = storage_path('app/public/contributions-' . $contribution->contribution_title . '.zip');

        // Initialize ZipArchive
        $zip = new \ZipArchive();
        if ($zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {
            // Fetch files from storage related to the contribution
            $files = Storage::files('public/contribution-files/' . $contribution_id);

            // Add each file to the zip
            foreach ($files as $file) {
                $zip->addFile(storage_path('app/' . $file), basename($file)); // Ensure correct path
            }
            $zip->close(); // Close the zip file after adding the files
        } else {
            return response()->json(['error' => 'Could not create zip file'], 500);
        }

        // Check if the zip file was created successfully and return for download
        if (file_exists($zip_file)) {
            return response()->download($zip_file)->deleteFileAfterSend(true); // Delete after download
        } else {
            return response()->json(['error' => 'Zip file not found'], 404);
        }
    }



    /**
     * Display details of a specific published contribution.
     */
    public function marketingmanagerPublishedContributionViewDetail($id)
    {
        // Fetch the contribution by ID
        $contribution = Contribution::with(['user', 'category', 'comments'])
            ->findOrFail($id);

        return view('marketingmanager.publishedcontributionviewdetail', compact('contribution'));
    }
    public function marketingmanagerDownloadContribution()
    {
        return view('marketingmanager.downloadcontribution');
    }

    public function marketingmanagerReport(Request $request)
    {
        // Fetch all faculties for the filter dropdown
        $faculties = Faculty::all();

        // Start building the query for published contributions
        $contributions = Contribution::with(['user', 'user.faculty'])
            ->where('contribution_status', 'Publish');

        // Filter by faculty
        if ($request->has('faculty') && $request->faculty != 'all') {
            $contributions->whereHas('user.faculty', function ($query) use ($request) {
                $query->where('faculty_id', $request->faculty);
            });
        }

        // Search by student name or title
        if ($request->has('search')) {
            $search = $request->input('search');
            $contributions->where(function ($query) use ($search) {
                $query->where('contribution_title', 'LIKE', "%{$search}%")
                    ->orWhereHas('user', function ($query) use ($search) {
                        $query->where('first_name', 'LIKE', "%{$search}%")
                            ->orWhere('last_name', 'LIKE', "%{$search}%");
                    });
            });
        }

        // Sort by publish date
        $sort = $request->input('sort', 'desc'); // Default to newest first
        $contributions->orderBy('published_date', $sort);

        // Paginate the results
        $contributions = $contributions->paginate(5);

        return view('marketingmanager.report', compact('contributions', 'faculties'));
    }

    public function marketingmanagerNotifation()
    {
        return view('marketingmanager.notifications');
    }

    public function marketingcoordinator()
    {
        // Get the logged-in user
        $user = Auth::user();

        // Fetch the count of uploaded contributions related to the logged-in user's faculty
        $uploadedCount = Contribution::where('contribution_status', 'Upload')
            ->whereHas('user', function ($query) use ($user) {
                $query->where('faculty_id', $user->faculty_id); // Filter by logged-in user's faculty_id
            })->count();

        // Fetch the count of published contributions related to the logged-in user's faculty
        $publishedCount = Contribution::where('contribution_status', 'Publish')
            ->whereHas('user', function ($query) use ($user) {
                $query->where('faculty_id', $user->faculty_id); // Filter by logged-in user's faculty_id
            })->count();

        // Prepare data for the pie chart
        $labels = ['Uploaded', 'Published'];
        $data = [$uploadedCount, $publishedCount];

        // Total students in the logged-in user's faculty
        $total_students = User::whereHas('role', function ($query) {
            $query->where('role', 'Student');
        })->where('faculty_id', $user->faculty_id) // Filter by faculty_id
            ->get();

        // Get the current month's student count in the logged-in user's faculty
        $current_month_students = User::whereHas('role', function ($query) {
            $query->where('role', 'Student');
        })
            ->where('faculty_id', $user->faculty_id) // Filter by faculty_id
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        // Get the previous month's student count in the logged-in user's faculty
        $previous_month_students = User::whereHas('role', function ($query) {
            $query->where('role', 'Student');
        })
            ->where('faculty_id', $user->faculty_id) // Filter by faculty_id
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

        // Fetch the role ID for the "Guest" role
        $guestRole = Role::where('role', 'Guest')->first();

        if (!$guestRole) {
            // Handle the case where the "Guest" role does not exist
            return redirect()->back()->with('error', 'Guest role not found. Please contact the administrator.');
        }

        $guestRoleId = $guestRole->role_id; // Get the role ID

        // Fetch guest users related to the logged-in user's faculty
        $faculty_guests = User::where('role_id', $guestRoleId)
            ->where('faculty_id', $user->faculty_id)
            ->whereNotNull('faculty_id')
            ->orderBy('created_at')
            ->paginate(10);

        // Faculty guests added this month
        $current_month_faculty_guests = User::where('role_id', $guestRoleId)
            ->where('faculty_id', $user->faculty_id)
            ->whereNotNull('faculty_id')
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        // Faculty guests added last month
        $previous_month_faculty_guests = User::where('role_id', $guestRoleId)
            ->where('faculty_id', $user->faculty_id)
            ->whereNotNull('faculty_id')
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->count();

        // Calculate the percentage change
        $faculty_guests_percentage_change = 0;
        if ($previous_month_faculty_guests > 0) {
            $faculty_guests_percentage_change = (($current_month_faculty_guests - $previous_month_faculty_guests) / $previous_month_faculty_guests) * 100;
        }

        // Round the percentage to 2 decimal places
        $faculty_guests_percentage_change = round($faculty_guests_percentage_change, 2);

        // Fetch contributions related to the logged-in user's faculty
        $total_contributions = Contribution::whereHas('user.faculty', function ($query) use ($user) {
            $query->where('faculty_id', $user->faculty_id);
        })->get();

        // Contributions for the current month
        $current_month_contributions = Contribution::whereHas('user.faculty', function ($query) use ($user) {
            $query->where('faculty_id', $user->faculty_id);
        })->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        // Contributions for the previous month
        $previous_month_contributions = Contribution::whereHas('user.faculty', function ($query) use ($user) {
            $query->where('faculty_id', $user->faculty_id);
        })->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->count();

        // Calculate the percentage change
        $contributions_percentage_change = 0;
        if ($previous_month_contributions > 0) {
            $contributions_percentage_change = (($current_month_contributions - $previous_month_contributions) / $previous_month_contributions) * 100;
        }

        // Round the percentage to 2 decimal places
        $contributions_percentage_change = round($contributions_percentage_change, 2);

        // Pending contributions
        $pending_contributions = Contribution::where('contribution_status', 'Upload')
            ->whereHas('user.faculty', function ($query) use ($user) {
                $query->where('faculty_id', $user->faculty_id);
            })->get();

        // Pending contributions for the current month
        $current_month_pending_contributions = Contribution::where('contribution_status', 'Upload')
            ->whereHas('user.faculty', function ($query) use ($user) {
                $query->where('faculty_id', $user->faculty_id);
            })
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        // Pending contributions for the previous month
        $previous_month_pending_contributions = Contribution::where('contribution_status', 'Upload')
            ->whereHas('user.faculty', function ($query) use ($user) {
                $query->where('faculty_id', $user->faculty_id);
            })
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->count();

        // Calculate the percentage change for pending contributions
        $pending_contributions_percentage_change = 0;
        if ($previous_month_pending_contributions > 0) {
            $pending_contributions_percentage_change = (($current_month_pending_contributions - $previous_month_pending_contributions) / $previous_month_pending_contributions) * 100;
        }

        // Round the percentage to 2 decimal places
        $pending_contributions_percentage_change = round($pending_contributions_percentage_change, 2);

        // Selected contributions
        $selected_contributions = Contribution::where('contribution_status', 'Select')
            ->whereHas('user.faculty', function ($query) use ($user) {
                $query->where('faculty_id', $user->faculty_id);
            })->get();

        // Selected contributions for the current month
        $current_month_selected_contributions = Contribution::where('contribution_status', 'Select')
            ->whereHas('user.faculty', function ($query) use ($user) {
                $query->where('faculty_id', $user->faculty_id);
            })
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        // Selected contributions for the previous month
        $previous_month_selected_contributions = Contribution::where('contribution_status', 'Select')
            ->whereHas('user.faculty', function ($query) use ($user) {
                $query->where('faculty_id', $user->faculty_id);
            })
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->count();

        // Calculate the percentage change for selected contributions
        $selected_contributions_percentage_change = 0;
        if ($previous_month_selected_contributions > 0) {
            $selected_contributions_percentage_change = (($current_month_selected_contributions - $previous_month_selected_contributions) / $previous_month_selected_contributions) * 100;
        }

        // Round the percentage to 2 decimal places
        $selected_contributions_percentage_change = round($selected_contributions_percentage_change, 2);

        // Rejected contributions
        $rejected_contributions = Contribution::where('contribution_status', 'Reject')
            ->whereHas('user.faculty', function ($query) use ($user) {
                $query->where('faculty_id', $user->faculty_id);
            })->get();

        // Rejected contributions for the current month
        $current_month_rejected_contributions = Contribution::where('contribution_status', 'Reject')
            ->whereHas('user.faculty', function ($query) use ($user) {
                $query->where('faculty_id', $user->faculty_id);
            })
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        // Rejected contributions for the previous month
        $previous_month_rejected_contributions = Contribution::where('contribution_status', 'Reject')
            ->whereHas('user.faculty', function ($query) use ($user) {
                $query->where('faculty_id', $user->faculty_id);
            })
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->count();

        // Calculate the percentage change for rejected contributions
        $rejected_contributions_percentage_change = 0;
        if ($previous_month_rejected_contributions > 0) {
            $rejected_contributions_percentage_change = (($current_month_rejected_contributions - $previous_month_rejected_contributions) / $previous_month_rejected_contributions) * 100;
        }

        // Round the percentage to 2 decimal places
        $rejected_contributions_percentage_change = round($rejected_contributions_percentage_change, 2);

        // Published contributions
        $published_contributions = Contribution::where('contribution_status', 'Publish')
            ->whereHas('user.faculty', function ($query) use ($user) {
                $query->where('faculty_id', $user->faculty_id);
            })->get();

        // Published contributions for the current month
        $current_month_published_contributions = Contribution::where('contribution_status', 'Publish')
            ->whereHas('user.faculty', function ($query) use ($user) {
                $query->where('faculty_id', $user->faculty_id);
            })
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        // Published contributions for the previous month
        $previous_month_published_contributions = Contribution::where('contribution_status', 'Publish')
            ->whereHas('user.faculty', function ($query) use ($user) {
                $query->where('faculty_id', $user->faculty_id);
            })
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->count();

        // Calculate the percentage change for published contributions
        $published_contributions_percentage_change = 0;
        if ($previous_month_published_contributions > 0) {
            $published_contributions_percentage_change = (($current_month_published_contributions - $previous_month_published_contributions) / $previous_month_published_contributions) * 100;
        }

        // Round the percentage to 2 decimal places
        $published_contributions_percentage_change = round($published_contributions_percentage_change, 2);

        return view('marketingcoordinator.index', compact('labels', 'data', 'total_students', 'student_percentage_change', 'faculty_guests', 'faculty_guests_percentage_change', 'total_contributions', 'contributions_percentage_change', 'pending_contributions', 'pending_contributions_percentage_change', 'selected_contributions', 'selected_contributions_percentage_change', 'rejected_contributions', 'rejected_contributions_percentage_change', 'published_contributions', 'published_contributions_percentage_change'));
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
        $query = User::where('faculty_id', $facultyId) // Filter by faculty_id
            ->whereHas('role', function ($query) {
                $query->where('role', 'Guest'); // Filter by role
            });

        // Apply search filter
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('user_code', 'LIKE', "%{$search}%")
                    ->orWhere('username', 'LIKE', "%{$search}%")
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
        $guests = $query->paginate(5);

        return view('marketingcoordinator.guestmanagement', compact('guests'));
    }

    public function marketingcoordinatorSubmissionManagement(Request $request)
    {
        // Get the logged-in user
        $coordinator = auth()->user();
        $facultyId = $coordinator->faculty_id;

        // Start building the query
        $query = Contribution::whereHas('user', function ($query) use ($facultyId) {
            $query->where('faculty_id', $facultyId); // Filter by faculty_id
        });

        // Apply search filter by student name or contribution title
        if ($request->filled('search')) {  // Use 'filled' to check if the input exists and is not empty
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('contribution_title', 'LIKE', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('username', 'LIKE', "%{$search}%");
                    });
            });
        }

        // Apply status filter only if it's not empty
        if ($request->filled('status')) {  // Use 'filled' for status as well
            $status = $request->input('status');
            $query->where('contribution_status', $status);
        }

        // Paginate the results
        $contributions = $query->paginate(5);

        return view('marketingcoordinator.submissionmanagement', compact('contributions'));
    }


    public function marketingcoordinatorSubmissionManagementViewDetailContribution()
    {
        return view('marketingcoordinator.submissionmanagementviewcontribution');
    }

    public function marketingcoordinatorProvideFeedBack()
    {
        return view('marketingcoordinator.feedback');
    }

    public function marketingcoordinatorSelectedContribution()
    {
        return view('marketingcoordinator.selectedcontribution');
    }
    // HomeController.php
    // HomeController.php
    public function marketingcoordinatorPublishedContribution(Request $request)
    {
        // Get the logged-in user
        $user = auth()->user();

        // Get the faculty ID of the logged-in user
        $facultyId = $user->faculty_id;

        // Start with contributions that have the status "Publish" and belong to the same faculty
        $query = Contribution::where('contribution_status', 'Publish')
            ->whereHas('user', function ($q) use ($facultyId) {
                $q->where('faculty_id', $facultyId); // Filter by faculty_id
            })
            ->with(['user', 'category']); // Eager load relationships

        // Search by submitted person name or contribution title
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('contribution_title', 'LIKE', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('username', 'LIKE', "%{$search}%")
                            ->orWhere('email', 'LIKE', "%{$search}%");
                    });
            });
        }

        // Sorting by submitted date
        $sort = $request->input('sort', 'desc'); // Default sorting is newest first
        $query->orderBy('submitted_date', $sort);

        // Paginate the results
        $contributions = $query->paginate(5);

        return view('marketingcoordinator.publishedcontribution', compact('contributions', 'sort'));
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
