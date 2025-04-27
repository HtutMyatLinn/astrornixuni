<?php

namespace App\Http\Controllers;

use App\Http\Requests\AcademicYearEditRequest;
use App\Http\Requests\AcademicYearRequest;
use App\Http\Requests\IntakeRequest;
use App\Models\AcademicYear;
use App\Models\Intake;
use Illuminate\Http\Request;

class AcademicYearController extends Controller
{
    // Search functionality
    public function search(Request $request)
    {
        $search = $request->input('search');

        if (!$search) {
            return redirect()->route('academic-years.index');
        }

        $academic_years = AcademicYear::where('academic_year', 'LIKE', "%{$search}%")->paginate(10);
        $intakes = Intake::paginate(10);

        return view('admin.closuredate', compact('academic_years', 'intakes', 'search'));
    }

    // Search functionality for intake
    public function intake_search(Request $request)
    {
        $academicYearSearch = $request->input('academic_year');

        // If no search query, return all records
        if (!$academicYearSearch) {
            return redirect()->route('academic-years.index');
        }

        // Find intakes that belong to the searched academic year
        $intakes = Intake::whereHas('academicYear', function ($query) use ($academicYearSearch) {
            $query->where('academic_year', 'LIKE', "%{$academicYearSearch}%");
        })
            ->orWhere('intake', 'LIKE', "%{$academicYearSearch}%")
            ->paginate(10);

        $academic_years = AcademicYear::paginate(10); // Keep academic years loaded

        return view('admin.closuredate', compact('intakes', 'academic_years', 'academicYearSearch'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sort = $request->input('sort', 'desc'); // Sorting for academic years
        $sortFinalClosureDate = $request->input('sort_final_closure_date', 'desc'); // Sorting for final closure date

        // Sorting academic years by created_at
        $academic_years = AcademicYear::orderBy('created_at', $sort)
            ->paginate(10)
            ->appends(['sort' => $sort]); // Keep sorting on pagination

        // Sorting intakes by final_closure_date
        $intakes = Intake::orderBy('final_closure_date', $sortFinalClosureDate)
            ->paginate(10)
            ->appends(['sort_final_closure_date' => $sortFinalClosureDate]); // Keep sorting on pagination

        return view('admin.closuredate', compact('academic_years', 'intakes', 'sort', 'sortFinalClosureDate'));
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
    public function store(AcademicYearRequest $request)
    {
        // Create a new academic year
        $academic_year = new AcademicYear();
        $academic_year->academic_year = $request->academic_year;
        $academic_year->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Academic Year created successfully.');
    }

    // Store a newly created intake in storage
    public function intake_store(IntakeRequest $request)
    {
        $intake = new Intake();
        $intake->intake = $request->intake;
        $intake->academic_year_id = $request->academic_year_select;
        $intake->status = 'upcoming';
        $intake->closure_date = $request->closure_date;

        // Automatically set final_closure_date to 14 days after closure_date
        $intake->final_closure_date = \Carbon\Carbon::parse($request->closure_date)->addDays(14);

        $intake->save();

        return redirect()->back()->with('intake_success', 'Intake created successfully.');
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
    public function update(AcademicYearEditRequest $request, $id)
    {
        // Find the academic year
        $academic_year = AcademicYear::findOrFail($id);

        // Update academic year data
        $academic_year->academic_year = $request->edit_academic_year;
        $academic_year->save();

        // Redirect to academic years index page with a success message
        return redirect()->route('academic-years.index')->with('success', 'Academic year updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
