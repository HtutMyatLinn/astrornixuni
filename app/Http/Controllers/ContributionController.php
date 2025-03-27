<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContributionRequest;
use App\Mail\ContributionPublishedNotification;
use App\Mail\ContributionRejected;
use App\Models\Comment;
use App\Models\Contribution;
use App\Models\ContributionCategory;
use App\Models\ContributionImage;
use App\Models\Feedback;
use App\Models\Intake;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContributionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $intakes = Intake::where('status', 'active')->get();
        $contribution_categories = ContributionCategory::all();

        return view('student.upload_contribution', compact('intakes', 'contribution_categories'));
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('search');

        $contributions = Contribution::where('contribution_status', 'Publish')
            ->where(function ($query) use ($searchTerm) {
                $query->where('contribution_title', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('contribution_description', 'LIKE', "%{$searchTerm}%")
                    ->orWhereHas('user', function ($query) use ($searchTerm) {
                        $query->where('username', 'LIKE', "%{$searchTerm}%");
                    });
            })
            ->orderBy('published_date', 'desc')
            ->paginate(20);

        $contribution_categories = ContributionCategory::all();

        return view('contributions.index', compact('contributions', 'contribution_categories'));
    }


    public function selectedContributions(Request $request)
    {
        // Fetch contributions with status "Select"
        $contributionsQuery = Contribution::where('contribution_status', 'Select')
            ->with(['user', 'category']) // Eager load relationships
            ->orderBy('submitted_date', $request->input('sort', 'desc')); // Default sorting by 'desc' if no sort is provided

        // If a search is provided, apply filters for Contribution Title and Student Name
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $contributionsQuery->where(function ($query) use ($search) {
                $query->where('contribution_title', 'LIKE', "%{$search}%")
                    ->orWhereHas('user', function ($query) use ($search) {
                        $query->where('first_name', 'LIKE', "%{$search}%")
                            ->orWhere('last_name', 'LIKE', "%{$search}%");
                    });
            });
        }

        // Paginate the results
        $contributions = $contributionsQuery->paginate(10);

        return view('marketingcoordinator.selectedcontribution', compact('contributions'));
    }

    public function contribution_index(Request $request)
    {
        $selectedCategory = $request->input('contribution_category', 'all');
        $searchQuery = $request->input('search', '');
        $otherCategory = $request->input('other_category', '');

        // Start the query with a join to include user details
        $query = Contribution::where('contribution_status', 'Publish')
            ->orderBy('published_date', 'desc')
            ->leftJoin('users', 'contributions.user_id', '=', 'users.user_id')
            ->select('contributions.*', 'users.first_name', 'users.last_name');

        if ($selectedCategory !== 'all' && $selectedCategory !== 'other') {
            $query->where('contribution_category_id', $selectedCategory);
        }

        if ($selectedCategory === 'other' && !empty($otherCategory)) {
            $query->whereNotIn('contribution_category_id', ContributionCategory::pluck('contribution_category_id'))
                ->where('contribution_title', 'LIKE', "%{$otherCategory}%");
        }

        // Search contributions and user names
        if (!empty($searchQuery)) {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('contribution_title', 'LIKE', "%{$searchQuery}%")
                    ->orWhere('contribution_description', 'LIKE', "%{$searchQuery}%")
                    ->orWhere('users.first_name', 'LIKE', "%{$searchQuery}%")
                    ->orWhere('users.last_name', 'LIKE', "%{$searchQuery}%");
            });
        }

        $contributions = $query->paginate(20)->appends([
            'contribution_category' => $selectedCategory,
            'search' => $searchQuery,
            'other_category' => $otherCategory
        ]);

        $contribution_categories = ContributionCategory::all();

        return view('contributions.index', compact('contributions', 'contribution_categories', 'selectedCategory', 'searchQuery', 'otherCategory'));
    }

    public function guest_index()
    {
        $contributions = Contribution::where('contribution_status', 'Publish')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        $trendingContributions = Contribution::where('contribution_status', 'Publish')
            ->orderBy('view_count', 'desc')
            ->limit(4) // Adjust the limit as needed
            ->get();

        return view('home', compact('contributions', 'trendingContributions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContributionRequest $request)
    {
        // Initialize variables with default values
        $coverImageName = null; // Default value for cover image
        $documentName = null;

        // Handle the cover image upload
        if ($request->hasFile('contribution_cover')) {
            $file = $request->file('contribution_cover');
            $coverImageName = 'contribution_cover_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/contribution-images', $coverImageName);
        }

        // Handle the document upload
        if ($request->hasFile('contribution_file_path')) {
            $file = $request->file('contribution_file_path');
            $documentName = 'contribution_file_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/contribution-documents', $documentName);
        }

        // Create a new Contribution instance
        $contribution = new Contribution();
        $contribution->intake_id = $request->intake_id;
        $contribution->contribution_category_id = $request->contribution_category_id;
        $contribution->user_id = $request->user_id;
        $contribution->contribution_title = $request->contribution_title;
        $contribution->contribution_description = $request->contribution_description;
        $contribution->contribution_cover = $coverImageName; // Save the file name
        $contribution->contribution_file_path = $documentName; // Save the file name
        $contribution->submitted_date = now();
        $contribution->save();

        // Handle additional images upload
        if ($request->hasFile('contribution_images')) {
            foreach ($request->file('contribution_images') as $image) {
                $imageName = 'contribution_image_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/contribution-images', $imageName);

                // Save each image to the contribution_images table
                ContributionImage::create([
                    'contribution_id' => $contribution->contribution_id,
                    'contribution_image_path' => $imageName,
                ]);
            }
        }

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Your contribution has been submitted successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contribution $contribution)
    {
        // Increment the view count
        $contribution->increment('view_count');

        // Eager load the user relationship
        $contribution->load('user');

        // Get 5 random contributions excluding the current one
        $contributions = Contribution::where('contribution_id', '!=', $contribution->contribution_id)
            ->where('contribution_status', 'Publish') // Only get published contributions
            ->inRandomOrder()
            ->limit(5)
            ->get();
        $comments = Comment::where('contribution_id', $contribution->contribution_id)->get();

        // Get trending contributions excluding the current one
        $trendingContributions = Contribution::where('contribution_id', '!=', $contribution->contribution_id)
            ->where('contribution_status', 'Publish') // Only get published contributions
            ->orderBy('view_count', 'desc')
            ->limit(5) // Adjust the limit as needed
            ->get();

        return view('student.contribution-detail', compact('contributions', 'contribution', 'comments', 'trendingContributions'));
    }


    public function viewDetail($id)
    {
        // Fetch the contribution by ID
        $contribution = Contribution::findOrFail($id);

        return view('marketingcoordinator.submissionmanagementviewcontribution', compact('contribution'));
    }

    // public function updateStatus(Request $request, $id)
    // {
    //     // Validate the request
    //     $request->validate([
    //         'status' => 'required|in:Upload,Reject,Update,Select,Publish',
    //     ]);

    //     // Find the contribution
    //     $contribution = Contribution::findOrFail($id);

    //     // Update the status
    //     $contribution->contribution_status = $request->status;
    //     $contribution->save();

    //     // Redirect based on the status
    //     if ($request->status == 'Upload') {
    //         return redirect()->route('marketingcoordinator.submission-management.feedback', $id);
    //     }

    //     // Redirect back with a success message
    //     return redirect()->back()->with('success', 'Contribution status updated successfully.');
    // }

    public function updateStatus(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'status' => 'required|in:Upload,Reject,Update,Select,Publish',
        ]);

        // Find the contribution
        $contribution = Contribution::findOrFail($id);

        // Store the old status before updating
        $oldStatus = $contribution->contribution_status;

        // Update the status
        $contribution->contribution_status = $request->status;
        $contribution->save();

        // If the status is "Reject", send an email to the user
        if ($request->status == 'Reject') {
            // Send rejection email to the user
            Mail::to($contribution->user->email)->send(new ContributionRejected($contribution));
        }

        // Redirect based on the status
        if ($request->status == 'Upload') {
            return redirect()->route('marketingcoordinator.submission-management.feedback', $id);
        }

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Contribution status updated successfully.');
    }

    public function showFeedbackForm($id)
    {
        // Fetch the contribution by ID
        $contribution = Contribution::findOrFail($id);

        return view('marketingcoordinator.feedback', compact('contribution'));
    }

    public function publishContribution($id)
    {
        // Find the contribution
        $contribution = Contribution::findOrFail($id);

        // Get the associated intake
        $intake = $contribution->intake; // Assuming you have a relationship between Contribution and Intake

        // Check if the intake exists and if the final_closure_date has passed
        if (!$intake || now() < $intake->final_closure_date) {
            return redirect()->back()->with('error', 'You can only publish contributions after the final closure date of the intake.');
        }

        // Update the status to "Publish"
        $contribution->contribution_status = 'Publish';
        $contribution->published_date = now();
        $contribution->save();

        // Send an email notification to the user who uploaded the contribution
        try {
            Mail::to($contribution->user->email)->send(new ContributionPublishedNotification($contribution));
        } catch (\Exception $e) {
            Log::error('Failed to send email: ' . $e->getMessage());
        }

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Contribution published successfully.');
    }

    public function submitFeedback(Request $request, $id)
    {
        // Find the contribution
        $contribution = Contribution::with('intake')->findOrFail($id);

        // Check if the current date is before the final closure date from the intake
        if ($contribution->intake && $contribution->intake->final_closure_date) {
            if (now()->isAfter($contribution->intake->final_closure_date)) {
                return redirect()->back()->withErrors(['error' => 'Feedback submission is only allowed before the final closure date.']);
            }
        } else {
            return redirect()->back()->withErrors(['error' => 'Final closure date is not set for this intake.']);
        }

        // Validate the request
        $request->validate([
            'feedback' => 'required|string|max:1000',
        ]);

        // Create a new feedback record
        Feedback::create([
            'contribution_id' => $contribution->contribution_id,
            'user_id' => auth()->id(),
            'feedback' => $request->feedback,
            'feedback_given_date' => now(),
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Feedback submitted successfully.');
    }
    public function marketingcoordinatorNotifications()
    {
        $user = Auth::user();

        // Get the faculty ID of the logged-in coordinator
        $facultyId = $user->faculty_id;
        // Fetch the role ID for the "Guest" role
        $guestRole = Role::where('role', 'Guest')->first();

        if (!$guestRole) {
            // Handle the case where the "Guest" role does not exist
            return redirect()->back()->with('error', 'Guest role not found. Please contact the administrator.');
        }

        $guestRoleId = $guestRole->role_id; // Get the role ID

        // Total faculty guests in the logged-in user's faculty
        $faculty_guests = User::where('role_id', $guestRoleId)
            ->where('faculty_id', $user->faculty_id)
            ->whereNotNull('faculty_id')
            ->count();

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

        // Fetch contributions with status 'Update' and same faculty as the logged-in user
        $contributions = Contribution::where('contribution_status', 'Update')
            ->whereHas('user.faculty', function ($query) use ($user) {
                $query->where('faculty_id', $user->faculty_id);
            })
            ->with(['user', 'category'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $resubmitted_contributions = Contribution::where('contribution_status', 'Update')
            ->whereHas('user.faculty', function ($query) use ($user) {
                $query->where('faculty_id', $user->faculty_id);
            })
            ->with(['user', 'category']);

        // Contributions with status 'Update' added this month
        $current_month_update_contributions = Contribution::where('contribution_status', 'Update')
            ->whereHas('user.faculty', function ($query) use ($user) {
                $query->where('faculty_id', $user->faculty_id);
            })
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        // Contributions with status 'Update' added last month
        $previous_month_update_contributions = Contribution::where('contribution_status', 'Update')
            ->whereHas('user.faculty', function ($query) use ($user) {
                $query->where('faculty_id', $user->faculty_id);
            })
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->count();

        // Calculate the percentage change
        $update_contributions_percentage_change = 0;
        if ($previous_month_update_contributions > 0) {
            $update_contributions_percentage_change = (($current_month_update_contributions - $previous_month_update_contributions) / $previous_month_update_contributions) * 100;
        }

        // Round the percentage to 2 decimal places
        $update_contributions_percentage_change = round($update_contributions_percentage_change, 2);

        $pending_review = Contribution::with(['user', 'category'])
            ->whereHas('user', function ($q) use ($facultyId) {
                $q->where('faculty_id', $facultyId); // Filter by faculty_id
            })
            ->whereDoesntHave('feedbacks');

        // Get current month's pending review contributions
        $current_month_pending_review = Contribution::whereHas('user', function ($q) use ($facultyId) {
            $q->where('faculty_id', $facultyId);
        })
            ->whereDoesntHave('feedbacks')
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        // Get previous month's pending review contributions
        $previous_month_pending_review = Contribution::whereHas('user', function ($q) use ($facultyId) {
            $q->where('faculty_id', $facultyId);
        })
            ->whereDoesntHave('feedbacks')
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->count();

        // Calculate the percentage change in pending reviews
        $pending_review_percentage_change = 0;
        if ($previous_month_pending_review > 0) {
            $pending_review_percentage_change = (($current_month_pending_review - $previous_month_pending_review) / $previous_month_pending_review) * 100;
        }

        // Round to 2 decimal places
        $pending_review_percentage_change = round($pending_review_percentage_change, 2);

        // Total feedback sent by the logged-in user
        $total_feedback_sent = Feedback::where('user_id', $user->user_id)->count();

        // Feedback sent this month by the logged-in user
        $current_month_feedback = Feedback::where('user_id', $user->user_id)
            ->whereYear('feedback_given_date', Carbon::now()->year)
            ->whereMonth('feedback_given_date', Carbon::now()->month)
            ->count();

        // Feedback sent last month by the logged-in user
        $previous_month_feedback = Feedback::where('user_id', $user->user_id)
            ->whereYear('feedback_given_date', Carbon::now()->subMonth()->year)
            ->whereMonth('feedback_given_date', Carbon::now()->subMonth()->month)
            ->count();

        // Calculate the percentage change
        $feedback_percentage_change = 0;
        if ($previous_month_feedback > 0) {
            $feedback_percentage_change = (($current_month_feedback - $previous_month_feedback) / $previous_month_feedback) * 100;
        }

        // Round the percentage to 2 decimal places
        $feedback_percentage_change = round($feedback_percentage_change, 2);

        return view('marketingcoordinator.notifications', compact('contributions', 'update_contributions_percentage_change', 'resubmitted_contributions', 'faculty_guests', 'faculty_guests_percentage_change', 'pending_review', 'pending_review_percentage_change', 'total_feedback_sent', 'feedback_percentage_change'));
    }

    public function reports(Request $request)
    {
        // Get the logged-in user
        $coordinator = auth()->user();

        // Get the faculty ID of the logged-in coordinator
        $facultyId = $coordinator->faculty_id;

        // Get search term and sort order from the request
        $searchTerm = $request->input('search');
        $sortOrder = $request->input('sort', 'desc'); // Default to descending

        // Start building the query for contributions without feedback, filtered by faculty
        $query = Contribution::with(['user', 'category'])
            ->whereHas('user', function ($q) use ($facultyId) {
                $q->where('faculty_id', $facultyId); // Filter by faculty_id
            })
            ->whereDoesntHave('feedbacks'); // Ensure contribution has no feedback

        // Apply search filter by student name or contribution title
        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('contribution_title', 'LIKE', "%{$searchTerm}%")
                    ->orWhereHas('user', function ($q) use ($searchTerm) {
                        $q->where('first_name', 'LIKE', "%{$searchTerm}%")
                            ->orWhere('last_name', 'LIKE', "%{$searchTerm}%");
                    });
            });
        }

        // Apply sorting by submitted date
        $query->orderBy('submitted_date', $sortOrder);

        // Paginate the results
        $contributions = $query->paginate(10);

        return view('marketingcoordinator.report', compact('contributions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contribution $contribution)
    {
        // Ensure the user can only delete their own contributions
        if ($contribution->user_id !== auth()->id()) {
            abort(403);
        }

        $contribution->delete();

        return redirect()->route('student.re_upload_contribution')->with('success', 'Contribution deleted successfully');
    }
}
