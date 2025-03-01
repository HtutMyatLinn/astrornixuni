<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContributionCategoryEditRequest;
use App\Http\Requests\ContributionCategoryRequest;
use App\Models\ContributionCategory;
use Illuminate\Http\Request;

class ContributionCategoryController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->input('search');

        if (!$search) {
            return redirect()->route('contribution-category.index');
        }

        $contribution_categories = ContributionCategory::where('contribution_category', 'LIKE', "%{$search}%")
            ->paginate(5);

        if ($contribution_categories->isEmpty()) {
            return view('admin.contributioncategory', compact('contribution_categories'));
        }

        return view('admin.contributioncategory', compact('contribution_categories', 'search'));
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contribution_categories = ContributionCategory::paginate(5);
        return view('admin.contributioncategory', compact('contribution_categories'));
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
    public function store(ContributionCategoryRequest $request)
    {
        // Create a new role
        $contribution_category = new ContributionCategory();
        $contribution_category->contribution_category = $request->contribution_category;
        $contribution_category->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Contribution Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(ContributionCategoryEditRequest $request, string $id)
    {
        // Find the role by ID
        $contribution_category = ContributionCategory::find($id);
        // Update role data
        $contribution_category->contribution_category = $request->edit_contribution_category;
        $contribution_category->save();
        // Redirect to roles index page with a success message
        return redirect()->back()->with('success', 'Contribution category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
