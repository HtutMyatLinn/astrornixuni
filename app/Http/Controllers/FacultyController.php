<?php

namespace App\Http\Controllers;

use App\Http\Requests\FacultyEditRequest;
use App\Http\Requests\FacultyRequest;
use App\Models\Contribution;
use App\Models\Faculty;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
    // Search for faculty based on the search query
    public function search(Request $request)
    {
        $search = $request->input('search');

        if (!$search) {
            return redirect()->route('faculty.index');
        }

        $faculties = Faculty::where('faculty', 'LIKE', "%{$search}%")
            ->paginate(10);

        if ($faculties->isEmpty()) {
            return view('admin.faculty', compact('faculties'));
        }

        return view('admin.faculty', compact('faculties', 'search'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sort = $request->input('sort', 'desc'); // Default sort is 'desc'

        $faculties = Faculty::orderBy('created_at', $sort)
            ->paginate(10)
            ->appends(['sort' => $sort]); // Keep sort on pagination links

        return view('admin.faculty', compact('faculties', 'sort'));
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
    public function store(FacultyRequest $request)
    {
        // Create a new role
        $faculty = new Faculty();
        $faculty->faculty = $request->faculty;
        $faculty->contact_number = $request->contact_number;
        $faculty->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Faculty created successfully.');
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
    public function update(FacultyEditRequest $request, string $id)
    {
        // Find the faculty
        $faculty = Faculty::find($id);
        // Update faculty data
        $faculty->faculty = $request->edit_faculty;
        $faculty->contact_number = $request->edit_contact_number;
        $faculty->save();

        // Redirect to roles index page with a success message
        return redirect()->route('faculty.index')->with('success', 'Faculty updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function faculty()
    {
        $faculties = Faculty::all();
        $contributions = Contribution::with('faculty')->get();

        return view('faculty', compact('faculties', 'contributions'));
    }

    public function filterByFaculty(Request $request, $faculty_id)
    {
        \Log::info('Faculty ID received: ' . $faculty_id); // Check the received faculty_id

        if ($faculty_id == 'all') {
            $contributions = Contribution::with('faculty', 'user')->get();
        } else {
            $contributions = Contribution::where('faculty_id', $faculty_id)
                ->with('faculty', 'user')
                ->get();
        }

        \Log::info('Filtered Contributions: ', $contributions->toArray()); // Log the filtered contributions

        return response()->json([
            'contributions' => $contributions
        ]);
    }
}
