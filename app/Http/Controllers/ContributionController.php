<?php

namespace App\Http\Controllers;

use App\Models\Contribution;
use App\Models\ContributionCategory;
use App\Models\Intake;
use Illuminate\Http\Request;

class ContributionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $intakes = Intake::all();
        $contribution_categories = ContributionCategory::all();

        return view('student.upload_contribution', compact('intakes', 'contribution_categories'));
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('search');

        $contributions = Contribution::where('contribution_title', 'LIKE', "%{$searchTerm}%")
            ->orWhere('contribution_description', 'LIKE', "%{$searchTerm}%")
            ->orWhereHas('user', function ($query) use ($searchTerm) {
                $query->where('username', 'LIKE', "%{$searchTerm}%");
            })
            ->paginate(20);
        $contribution_categories = ContributionCategory::all();


        return view('contributions.index', compact('contributions', 'contribution_categories'));
    }

    public function contribution_index()
    {
        $contributions = Contribution::paginate(20);
        $contribution_categories = ContributionCategory::all();

        return view('contributions.index', compact('contributions', 'contribution_categories'));
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
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'contribution_title' => 'required|string|max:255',
            'intake_id' => 'required|exists:intakes,intake_id',
            'contribution_category_id' => 'required|exists:contribution_categories,contribution_category_id',
            'contribution_description' => 'required|string',
            'contribution_cover' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
            'contribution_file_path' => 'required|mimes:doc,docx|max:5120', // Max 5MB
        ]);

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
        $contributions = Contribution::all();

        // Get trending contributions (e.g., top 5 most viewed)
        $trendingContributions = Contribution::orderBy('view_count', 'desc')
            ->limit(5) // Adjust the limit as needed
            ->get();

        // Pass the contribution and trending contributions to the view
        return view('student.contribution-detail', compact('contributions', 'contribution', 'trendingContributions'));
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
