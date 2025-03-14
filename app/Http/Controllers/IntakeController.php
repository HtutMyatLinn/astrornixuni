<?php

namespace App\Http\Controllers;

use App\Http\Requests\IntakeEditRequest;
use App\Models\Intake;
use Illuminate\Http\Request;

class IntakeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
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

    public function update(Request $request, string $id)
    {
        $request->validate([
            'edit_intake' => 'required|string|max:50',
            'status' => 'required|in:active,finished,upcoming',
        ]);

        $intake = Intake::findOrFail($id);
        $intake->intake = $request->edit_intake;
        $intake->status = $request->status;
        $intake->save();

        return redirect()->route('academic-years.index', ['#overall-information'])
            ->with('intake_update_success', 'Intake updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
