<?php

namespace App\Http\Controllers;

use App\Http\Requests\InquiryRequest;
use App\Models\Inquiry;

class InquiryController extends Controller
{
    public function store(InquiryRequest $request)
    {
        // Create a new inquiry
        $inquiry = new Inquiry();
        $inquiry->user_id = $request->user_id;
        $inquiry->priority_level = $request->priority_level;
        $inquiry->inquiry = $request->inquiry;
        $inquiry->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Your inquiry has been submitted successfully!');
    }
}
