<?php

namespace App\Http\Controllers;

use App\Http\Requests\InquiryRequest;
use App\Models\Inquiry;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->input('sort', 'desc'); // Get the sort parameter from the request
        $search = $request->input('search'); // Get the search parameter from the request
        $filter = $request->input('filter'); // Get the filter parameter from the request

        // Base query
        $inquiries = Inquiry::query();

        // Apply search filter if search term is provided
        if ($search) {
            $inquiries->where(function ($query) use ($search) {
                $query->where('inquiry', 'LIKE', "%{$search}%")
                    ->orWhereHas('user', function ($query) use ($search) {
                        $query->where('username', 'LIKE', "%{$search}%")
                            ->orWhere('user_code', 'LIKE', "%{$search}%")
                            ->orWhere('email', 'LIKE', "%{$search}%")
                            ->orWhere('first_name', 'LIKE', "%{$search}%")
                            ->orWhere('last_name', 'LIKE', "%{$search}%");
                    });
            });
        }

        // Apply filter if filter is provided
        if ($filter) {
            if ($filter === 'Pending') {
                $inquiries->where('inquiry_status', 'Pending');
            } elseif ($filter === 'Resolved') {
                $inquiries->where('inquiry_status', 'Resolved');
            }
        }

        // Apply sorting
        $inquiries->orderBy('created_at', $sort);

        // Paginate the results
        $inquiries = $inquiries->paginate(10)->appends([
            'sort' => $sort,
            'search' => $search, // Keep the search parameter in pagination links
            'filter' => $filter, // Keep the filter parameter in pagination links
        ]);

        return view('admin.notificationsinquiry', compact('inquiries', 'sort', 'search', 'filter'));
    }

    //Store inquiry from user
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
