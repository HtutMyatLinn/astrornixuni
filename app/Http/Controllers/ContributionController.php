<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContributionRequest;
use App\Models\Comment;
use App\Models\Contribution;
use App\Models\ContributionCategory;
use App\Models\Feedback;
use App\Models\Intake;
use Illuminate\Http\Request;

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
            ->paginate(20);

        $contribution_categories = ContributionCategory::all();

        return view('contributions.index', compact('contributions', 'contribution_categories'));
    }

    // ContributionController.php
    public function selectedContributions(Request $request)
    {
        // Fetch contributions with status "Select"
        $contributions = Contribution::where('contribution_status', 'Select')
            ->with(['user', 'category']) // Eager load relationships
            ->paginate(10);

        return view('marketingcoordinator.selectedcontribution', compact('contributions'));
    }

    public function contribution_index()
    {
        $contributions = Contribution::where('contribution_status', 'Publish')->paginate(20);
        $contribution_categories = ContributionCategory::all();

        return view('contributions.index', compact('contributions', 'contribution_categories'));
    }

    public function guest_index()
    {
        $contributions = Contribution::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        $trendingContributions = Contribution::orderBy('view_count', 'desc')
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
        // Handle the cover image upload
        if ($request->contribution_cover) {
            $file = $request->contribution_cover;
            $coverImageName = 'contribution_cover_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/contribution-images', $coverImageName);
        }

        // Handle the document upload
        if ($request->contribution_file_path) {
            $file = $request->contribution_file_path;
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

        // // Redirect back with a success message
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
            ->inRandomOrder()
            ->limit(5)
            ->get();
        $comments = Comment::where('contribution_id', $contribution->contribution_id)->get();

        // Get trending contributions excluding the current one
        $trendingContributions = Contribution::where('contribution_id', '!=', $contribution->contribution_id)
            ->orderBy('view_count', 'desc')
            ->limit(5) // Adjust the limit as needed
            ->get();

        return view('student.contribution-detail', compact('contributions', 'contribution', 'comments', 'trendingContributions'));
    }

    // ContributionController.php
    public function viewDetail($id)
    {
        // Fetch the contribution by ID
        $contribution = Contribution::findOrFail($id);

        return view('marketingcoordinator.submissionmanagementviewcontribution', compact('contribution'));
    }

    public function updateStatus(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'status' => 'required|in:Upload,Reject,Update,Select,Publish',
        ]);

        // Find the contribution
        $contribution = Contribution::findOrFail($id);

        // Update the status
        $contribution->contribution_status = $request->status;
        $contribution->save();

        // Redirect based on the status
        if ($request->status == 'Update') {
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

        // Update the status to "Publish"
        $contribution->contribution_status = 'Publish';
        $contribution->published_date = now();
        $contribution->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Contribution published successfully.');
    }

    public function submitFeedback(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'feedback' => 'required|string|max:1000',
        ]);

        // Find the contribution
        $contribution = Contribution::findOrFail($id);

        // Create a new feedback record
        Feedback::create([
            'contribution_id' => $contribution->contribution_id,
            'user_id' => auth()->id(), // Assuming the authenticated user is giving the feedback
            'feedback' => $request->feedback,
            'feedback_given_date' => now(),
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Feedback submitted successfully.');
    }

    public function marketingcoordinatorNotifications()
    {
        // Fetch contributions with status "Update" (resubmitted after feedback)
        $contributions = Contribution::where('contribution_status', 'Update')
            ->with(['user', 'category']) // Eager load relationships
            ->paginate(10);

        return view('marketingcoordinator.notifications', compact('contributions'));
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

        // Start building the query for contributions without comments, filtered by faculty
        $query = Contribution::with(['user', 'category'])
            ->whereHas('user', function ($query) use ($facultyId) {
                $query->where('faculty_id', $facultyId); // Filter by faculty_id
            })
            ->whereDoesntHave('comments'); // Only contributions without comments

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
    public function destroy(string $id)
    {
        //
    }
}
