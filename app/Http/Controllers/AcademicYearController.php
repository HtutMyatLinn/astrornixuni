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
        $intake_search = $request->input('intake_search');

        if (!$intake_search) {
            return redirect()->route('academic-years.index');
        }

        $intakes = AcademicYear::where('academic_year', 'LIKE', "%{$intake_search}%")->paginate(10);
        $intakes = Intake::paginate(10);

        return view('admin.closuredate', compact('intakes', 'intake_search'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $academic_years = AcademicYear::paginate(10);
        $intakes = Intake::paginate(10);

        return view('admin.closuredate', compact('academic_years', 'intakes'));
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
        $academic_year->academic_year_select = $request->academic_year_select;
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
        $intake->closure_date = $request->closure_date;

        // Automatically set final_closure_date to 14 days after closure_date
        $intake->final_closure_date = \Carbon\Carbon::parse($request->closure_date)->addDays(14);

        $intake->save();

        return redirect()->back()->with('success', 'Intake created successfully.');
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
    public function update(AcademicYearEditRequest $request, string $id)
    {
        // Find the academic year
        $academic_year = AcademicYear::find($id);

        // Update role data
        $academic_year->academic_year = $request->edit_academic_year;
        $academic_year->save();

        // Redirect to roles index page with a success message
        return redirect()->route('academic-years.index')->with('success', 'Academin year updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
