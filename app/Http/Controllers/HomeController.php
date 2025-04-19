<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditAccountSettingRequest;
use App\Http\Requests\UserEditRequest;
use App\Models\AcademicYear;
use App\Models\BrowserStat;
use App\Models\Contribution;
use App\Models\Faculty;
use App\Models\Feedback;
use App\Models\Inquiry;
use App\Models\PasswordResetRequest;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use ZipArchive;



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
        $percentage_change = min(round($percentage_change, 2), 100);

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
        $inquiry_percentage_change = min(round($inquiry_percentage_change, 2), 100);

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

        $faculties = Faculty::all();

        // Contribution calculations
        $total_contributions = Contribution::all();

        $current_month_contributions = Contribution::whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        $previous_month_contributions = Contribution::whereYear('created_at', Carbon::now()->subMonth()->year)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->count();

        $contribution_percentage_change = 0;
        if ($previous_month_contributions > 0) {
            $contribution_percentage_change = (($current_month_contributions - $previous_month_contributions) / $previous_month_contributions) * 100;
        }
        $contribution_percentage_change = min(round($contribution_percentage_change, 2), 100);

        $pending_contributions = Contribution::where('contribution_status', 'Upload')->get();

        // Selected Contributions
        $selected_contributions = Contribution::where('contribution_status', 'Select')->get();

        $current_month_selected = Contribution::where('contribution_status', 'Select')
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        $previous_month_selected = Contribution::where('contribution_status', 'Select')
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->count();

        $selected_percentage_change = 0;
        if ($previous_month_selected > 0) {
            $selected_percentage_change = (($current_month_selected - $previous_month_selected) / $previous_month_selected) * 100;
        }
        $selected_percentage_change = min(round($selected_percentage_change, 2), 100);

        // Rejected Contributions
        $rejected_contributions = Contribution::where('contribution_status', 'Reject')->get();

        $current_month_rejected = Contribution::where('contribution_status', 'Reject')
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        $previous_month_rejected = Contribution::where('contribution_status', 'Reject')
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->count();

        $rejected_percentage_change = 0;
        if ($previous_month_rejected > 0) {
            $rejected_percentage_change = (($current_month_rejected - $previous_month_rejected) / $previous_month_rejected) * 100;
        }
        $rejected_percentage_change = min(round($rejected_percentage_change, 2), 100);

        // Published Contributions
        $published_contributions = Contribution::where('contribution_status', 'Publish')->get();

        $current_month_published = Contribution::where('contribution_status', 'Publish')
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        $previous_month_published = Contribution::where('contribution_status', 'Publish')
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->count();

        $published_percentage_change = 0;
        if ($previous_month_published > 0) {
            $published_percentage_change = (($current_month_published - $previous_month_published) / $previous_month_published) * 100;
        }
        $published_percentage_change = min(round($published_percentage_change, 2), 100);

        // Get browser data
        $browserStats = BrowserStat::all();
        $labels = $browserStats->pluck('browser_name');
        $data = $browserStats->pluck('visit_count');

        return view('admin.index', compact('total_users', 'total_students', 'student_percentage_change', 'percentage_change', 'labels', 'data', 'inquiries', 'inquiry_percentage_change', 'faculties', 'total_contributions', 'contribution_percentage_change', 'pending_contributions', 'selected_contributions', 'selected_percentage_change', 'rejected_contributions', 'rejected_percentage_change', 'published_contributions', 'published_percentage_change'));
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

        // Handle search for unassigned users
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

        // Handle sort for unassigned users
        $sort = $request->input('sort', 'desc');
        $unassigned_users->orderBy('created_at', $sort);

        // Handle filter for unassigned users
        if ($request->has('filter')) {
            $filter = $request->input('filter');
            if ($filter === 'Pending') {
                $unassigned_users->where('status', 'Pending');
            } elseif ($filter === 'Resolved') {
                $unassigned_users->where('status', 'Resolved');
            }
        }

        // Paginate unassigned users
        $unassigned_users = $unassigned_users->paginate(10)->appends([
            'sort' => $sort,
            'search' => $request->input('search'),
            'filter' => $request->input('filter'),
        ]);

        // Get the current month's guest user count (fixed to check role_id instead of NULL)
        $current_month_unassigned_users = User::where('role_id', $guestRoleId)
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        // Get the previous month's guest user count (fixed to check role_id instead of NULL)
        $previous_month_unassigned_users = User::where('role_id', $guestRoleId)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->count();

        // Calculate the percentage change (keeping your original logic)
        $unassigned_user_percentage_change = 0;
        if ($previous_month_unassigned_users > 0) {
            $unassigned_user_percentage_change = (($current_month_unassigned_users - $previous_month_unassigned_users) / $previous_month_unassigned_users) * 100;
        }

        // Round the percentage to 2 decimal places (keeping your original logic)
        $unassigned_user_percentage_change = min(round($unassigned_user_percentage_change, 2), 100);

        // Inquiry
        $inquiries = Inquiry::all();

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
        $reset_password_users = PasswordResetRequest::where('status', 'Pending');

        // Handle search for reset password users
        if ($request->has('search')) {
            $search = $request->input('search');
            $reset_password_users->where(function ($query) use ($search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('username', 'like', "%{$search}%")
                        ->orWhere('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            });
        }

        // Handle filter for reset password users
        if ($request->has('filter')) {
            $filter = $request->input('filter');
            if ($filter === 'Pending') {
                $reset_password_users->where('status', 'Pending');
            } elseif ($filter === 'Resolved') {
                $reset_password_users->where('status', 'Resolved');
            }
        }

        // Handle sort for reset password users
        $reset_password_users->orderBy('created_at', $sort);

        // Paginate reset password users
        $reset_password_users = $reset_password_users->paginate(5)->appends([
            'sort' => $sort,
            'search' => $request->input('search'),
            'filter' => $request->input('filter'),
        ]);

        // Round the percentage to 2 decimal places
        $student_percentage_change = min(round($student_percentage_change, 2), 100);
        $contributions = Contribution::where('contribution_status', 'Upload')->get();

        return view('admin.notificationspassword', compact(
            'unassigned_users',
            'unassigned_user_percentage_change',
            'inquiries',
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
        // Published Contributions
        $totalPublishedContributions = Contribution::where('contribution_status', 'Publish')->get();

        $current_month_published = Contribution::where('contribution_status', 'Publish')
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        $previous_month_published = Contribution::where('contribution_status', 'Publish')
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->count();

        $published_percentage_change = 0;
        if ($previous_month_published > 0) {
            $published_percentage_change = (($current_month_published - $previous_month_published) / $previous_month_published) * 100;
        }
        $published_percentage_change = min(round($published_percentage_change, 2), 100);

        // Active Faculty Participation (faculties with at least one contribution)
        $activeFacultyParticipation = Faculty::whereHas('users.contributions', function ($query) {
            $query->where('contribution_status', 'Publish');
        })->count();

        // Submission Trends This Year (contributions with view_count > 100)
        $submissionTrendsThisYear = Contribution::where('view_count', '>', 100)->count();

        $current_month_popular = Contribution::where('view_count', '>', 100)
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        $previous_month_popular = Contribution::where('view_count', '>', 100)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->count();

        $popular_percentage_change = 0;
        if ($previous_month_popular > 0) {
            $popular_percentage_change = (($current_month_popular - $previous_month_popular) / $previous_month_popular) * 100;
        }
        $popular_percentage_change = min(round($popular_percentage_change, 2), 100);

        // Total Contributions Submitted (all contributions)
        $totalContributionsSubmitted = Contribution::count();

        $current_month_contributions = Contribution::whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        $previous_month_contributions = Contribution::whereYear('created_at', Carbon::now()->subMonth()->year)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->count();

        $contribution_percentage_change = 0;
        if ($previous_month_contributions > 0) {
            $contribution_percentage_change = (($current_month_contributions - $previous_month_contributions) / $previous_month_contributions) * 100;
        }
        $contribution_percentage_change = min(round($contribution_percentage_change, 2), 100);

        // Total Students = count of user's role -> student
        $totalStudents = User::whereHas('role', function ($query) {
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

        // Total Marketing Coordinators = count of user's role -> marketing coordinator
        $totalMarketingCoordinators = User::whereHas('role', function ($query) {
            $query->where('role', 'marketing coordinator');
        })->count();

        // Total Faculty = count of Faculty
        $totalFaculty = Faculty::count();

        // Pass data to the view
        return view('marketingmanager.index', [
            'totalPublishedContributions' => $totalPublishedContributions,
            'published_percentage_change' => $published_percentage_change,
            'activeFacultyParticipation' => $activeFacultyParticipation,
            'submissionTrendsThisYear' => $submissionTrendsThisYear,
            'popular_percentage_change' => $popular_percentage_change,
            'totalContributionsSubmitted' => $totalContributionsSubmitted,
            'contribution_percentage_change' => $contribution_percentage_change,
            'totalStudents' => $totalStudents,
            'student_percentage_change' => $student_percentage_change,
            'totalMarketingCoordinators' => $totalMarketingCoordinators,
            'totalFaculty' => $totalFaculty,
        ]);
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

    public function downloadMultipleContributions(Request $request)
    {
        // Get the selected contribution IDs from the request
        $contributionIds = explode(',', $request->query('ids'));

        // Fetch the contributions
        $contributions = Contribution::whereIn('contribution_id', $contributionIds)->get();

        if ($contributions->isEmpty()) {
            return redirect()->back()->with('error', 'No contributions selected.');
        }

        // Check if the final_closure_date has passed
        foreach ($contributions as $contribution) {
            $intake = $contribution->intake; // Assuming you have a relationship between Contribution and Intake

            if (now() < $intake->final_closure_date) {
                return redirect()->back()->with('error', 'You can only download contributions after the final closure date.');
            }
        }

        // Create a new ZIP archive
        $zip = new ZipArchive();
        $zipFileName = 'contributions_' . time() . '.zip'; // Unique ZIP file name
        $zipFilePath = storage_path('app/public/' . $zipFileName);

        // Open the ZIP file for writing
        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            foreach ($contributions as $contribution) {
                // Construct the full file path
                $filePath = storage_path('app/public/contribution-documents/' . $contribution->contribution_file_path);

                // Check if the file exists
                if (File::exists($filePath)) {
                    // Add the file to the ZIP
                    $zip->addFile($filePath, basename($filePath)); // Use basename to avoid path issues
                }
            }

            // Close the ZIP file
            $zip->close();

            // Return the ZIP file as a downloadable response
            return response()->download($zipFilePath)->deleteFileAfterSend(true);
        } else {
            // Handle the error if the ZIP file cannot be created
            return redirect()->back()->with('error', 'Unable to create ZIP file.');
        }
    }

    public function checkIntakeStatus(Request $request)
    {
        $contributionIds = $request->input('contributionIds');
        $contributions = Contribution::whereIn('contribution_id', $contributionIds)->get();

        foreach ($contributions as $contribution) {
            $intake = $contribution->intake;

            if (now() < $intake->final_closure_date) {
                return response()->json(['error' => 'You can only download contributions after the final closure date.']);
            }
        }

        return response()->json(['success' => true]);
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
        // Fetch all faculties
        $all_faculties = Faculty::all();
        $faculties = Faculty::pluck('faculty', 'faculty_id');

        // Fetch all academic years for the filter dropdown
        $academicYears = AcademicYear::pluck('academic_year', 'academic_year_id');

        // Get contributions for charts (filtered by academic year if selected)
        $chartContributions = Contribution::with(['user.faculty', 'intake.academicYear'])
            ->when($request->filled('academic_year'), function ($query) use ($request) {
                return $query->whereHas('intake', function ($q) use ($request) {
                    $q->where('academic_year_id', $request->academic_year);
                });
            })
            ->get()
            ->groupBy('user.faculty.faculty_id');

        // Calculate total contributions
        $totalContributions = $chartContributions->flatten()->count();
        $totalUniqueContributors = $chartContributions->flatten()->unique('user_id')->count();

        // Prepare data for the charts
        $labels = $faculties->values()->toArray();
        $countData = [];
        $percentageData = [];
        $contributorCountData = [];
        $contributorPercentageData = [];

        foreach ($faculties as $facultyId => $facultyName) {
            $count = $chartContributions->get($facultyId, collect())->count();
            $countData[] = $count;
            $percentage = $totalContributions > 0 ? ($count / $totalContributions) * 100 : 0;
            $percentageData[] = round($percentage, 2);

            $contributorCount = $chartContributions->get($facultyId, collect())->unique('user_id')->count();
            $contributorCountData[] = $contributorCount;
            $contributorPercentage = $totalUniqueContributors > 0 ? ($contributorCount / $totalUniqueContributors) * 100 : 0;
            $contributorPercentageData[] = round($contributorPercentage, 2);
        }

        // Handle published contributions with pagination and sorting (without academic year filter)
        $published_contributions = Contribution::where('contribution_status', 'Publish')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->input('search');
                return $query->where(function ($q) use ($search) {
                    $q->where('contribution_title', 'like', "%{$search}%")
                        ->orWhere('contribution_description', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($q) use ($search) {
                            $q->where('username', 'like', "%{$search}%")
                                ->orWhere('first_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%");
                        });
                });
            })
            ->when($request->filled('faculty') && $request->faculty != 'all', function ($query) use ($request) {
                $query->whereHas('user.faculty', function ($q) use ($request) {
                    $q->where('faculty_id', $request->faculty);
                });
            })
            ->orderBy('published_date', $request->input('sort', 'desc'))
            ->paginate(10)
            ->appends($request->except('academic_year')); // Don't include academic_year in pagination links

        // Handle feedbacked contributions
        $feedbacked_contributions = Feedback::with(['user', 'contribution'])
            ->when($request->filled('feedback_search'), function ($query) use ($request) {
                // ... (keep existing feedback search logic)
            })
            ->when($request->filled('feedback_faculty'), function ($query) use ($request) {
                // ... (keep existing feedback faculty filter)
            })
            ->orderBy('feedback_given_date', $request->input('feedback_sort', 'desc'))
            ->paginate(10)
            ->appends([
                'feedback_search' => $request->input('feedback_search'),
                'feedback_faculty' => $request->input('feedback_faculty'),
                'feedback_sort' => $request->input('feedback_sort'),
            ]);

        return view('marketingmanager.report', [
            'labels' => $labels,
            'countData' => $countData,
            'percentageData' => $percentageData,
            'contributorCountData' => $contributorCountData,
            'contributorPercentageData' => $contributorPercentageData,
            'academicYears' => $academicYears,
            'published_contributions' => $published_contributions,
            'feedbacked_contributions' => $feedbacked_contributions,
            'all_faculties' => $all_faculties,
            'selectedAcademicYear' => $request->input('academic_year'), // Pass selected academic year to view
        ]);
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
        $student_percentage_change = min(round($student_percentage_change, 2), 100);

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
        $faculty_guests_percentage_change = min(round($faculty_guests_percentage_change, 2), 100);

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
        $contributions_percentage_change = min(round($contributions_percentage_change, 2), 100);

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
        $pending_contributions_percentage_change = min(round($pending_contributions_percentage_change, 2), 100);

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
        $selected_contributions_percentage_change = min(round($selected_contributions_percentage_change, 2), 100);

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
        $rejected_contributions_percentage_change = min(round($rejected_contributions_percentage_change, 2), 100);

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
        $published_contributions_percentage_change = min(round($published_contributions_percentage_change, 2), 100);

        return view('marketingcoordinator.index', compact('labels', 'data', 'total_students', 'student_percentage_change', 'faculty_guests', 'faculty_guests_percentage_change', 'total_contributions', 'contributions_percentage_change', 'pending_contributions', 'pending_contributions_percentage_change', 'selected_contributions', 'selected_contributions_percentage_change', 'rejected_contributions', 'rejected_contributions_percentage_change', 'published_contributions', 'published_contributions_percentage_change'));
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

    public function marketingcoordinatorStudentManagement(Request $request)
    {
        // Get the logged-in user
        $coordinator = auth()->user();

        // Get the faculty ID of the logged-in coordinator
        $facultyId = $coordinator->faculty_id;

        // Start building the query
        $query = User::where('faculty_id', $facultyId) // Filter by faculty_id
            ->whereHas('role', function ($query) {
                $query->where('role', 'Student'); // Filter by role (Student instead of Guest)
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
        $students = $query->paginate(5);

        return view('marketingcoordinator.studentmanagement', compact('students'));
    }

    public function marketingcoordinatorSubmissionManagement(Request $request)
    {
        // Get the logged-in user
        $coordinator = auth()->user();
        $facultyId = $coordinator->faculty_id;

        // Start building the query
        $query = Contribution::whereHas('user', function ($query) use ($facultyId) {
            $query->where('faculty_id', $facultyId); // Filter by faculty_id
        })
            ->orderBy('submitted_date', 'desc'); // Order by latest submitted_date

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
        $contributions = $query->paginate(10);

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
        $contributions = Contribution::where('contribution_status', 'Publish')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        $trendingContributions = Contribution::where('contribution_status', 'Publish')
            ->orderBy('view_count', 'desc')
            ->limit(4) // Adjust the limit as needed
            ->get();

        return view('student.index', compact('contributions', 'trendingContributions'));
    }

    public function reupload()
    {
        $userId = auth()->id();

        // Get all contributions for the logged-in user
        $contributions = Contribution::where('user_id', $userId)
            ->orderBy('submitted_date', 'desc')
            ->get();

        // Check if there are any contributions under review (for notification)
        $noti = Contribution::where('user_id', $userId)
            ->where('contribution_status', 'Review');

        // Get all feedbacks for the user's contributions with pagination
        $feedbacks = Feedback::whereHas('contribution', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
            ->with(['contribution', 'user']) // Eager load relationships
            ->orderBy('feedback_given_date', 'desc')
            ->paginate(3);

        // Keep this for any existing functionality that might need it
        $reviewedContribution = null;

        return view('student.re_upload_contribution', compact('contributions', 'noti', 'reviewedContribution', 'feedbacks'));
    }
}
