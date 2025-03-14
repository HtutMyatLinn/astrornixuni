<?php

namespace App\Http\Controllers;

use App\Http\Requests\InquiryRequest;
use App\Models\Contribution;
use App\Models\Inquiry;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->input('sort', 'desc'); // Get the sort parameter from the request
        $search = $request->input('search'); // Get the search parameter from the request
        $filter = $request->input('filter'); // Get the filter parameter from the request

        // Base query
        $unassigned_users = User::whereNull('role_id')->get();

        // Get the current month's unassigned user count
        $current_month_unassigned_users = User::whereNull('role_id')
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        // Get the previous month's unassigned user count
        $previous_month_unassigned_users = User::whereNull('role_id')
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->count();

        // Calculate the percentage change
        $assigned_user_percentage_change = 0;
        if ($previous_month_unassigned_users > 0) {
            $assigned_user_percentage_change = (($current_month_unassigned_users - $previous_month_unassigned_users) / $previous_month_unassigned_users) * 100;
        }

        // Round the percentage to 2 decimal places
        $assigned_user_percentage_change = round($assigned_user_percentage_change, 2);

        // Inquiry
        $inquiries = Inquiry::all();

        // Get the current month's new inquiry count
        $current_month_inquiries = Inquiry::whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        // Get the previous month's new inquiry count
        $previous_month_inquiries = Inquiry::whereYear('created_at', Carbon::now()->subMonth()->year)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->count();

        // Calculate the percentage change
        $inquiry_percentage_change = 0;
        if ($previous_month_inquiries > 0) {
            $inquiry_percentage_change = (($current_month_inquiries - $previous_month_inquiries) / $previous_month_inquiries) * 100;
        }

        // Round the percentage to 2 decimal places
        $inquiry_percentage_change = round($inquiry_percentage_change, 2);

        $inquiries = Inquiry::query();

        // Total student
        $total_students = User::whereHas('role', function ($query) {
            $query->where('role', 'Student');
        })->get();

        // Get the current month's student count
        $current_month_students = User::whereHas('role', function ($query) {
            $query->where('role', 'Student');
        })
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        // Get the previous month's student count
        $previous_month_students = User::whereHas('role', function ($query) {
            $query->where('role', 'Student');
        })
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->count();

        // Calculate the percentage change
        $student_percentage_change = 0;
        if ($previous_month_students > 0) {
            $student_percentage_change = (($current_month_students - $previous_month_students) / $previous_month_students) * 100;
        }

        // Round the percentage to 2 decimal places
        $student_percentage_change = round($student_percentage_change, 2);

        // Get the current month's student count
        $current_month_students = User::whereHas('role', function ($query) {
            $query->where('role', 'Student');
        })
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        // Get the previous month's student count
        $previous_month_students = User::whereHas('role', function ($query) {
            $query->where('role', 'Student');
        })
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->count();

        // Calculate the percentage change
        $student_percentage_change = 0;
        if ($previous_month_students > 0) {
            $student_percentage_change = (($current_month_students - $previous_month_students) / $previous_month_students) * 100;
        }

        // Round the percentage to 2 decimal places
        $student_percentage_change = round($student_percentage_change, 2);
        $contributions = Contribution::where('contribution_status', 'Upload')->get();

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

        return view('admin.notificationsinquiry', compact('inquiries', 'inquiry_percentage_change', 'inquiries', 'sort', 'search', 'filter', 'total_students', 'student_percentage_change', 'unassigned_users', 'assigned_user_percentage_change'));
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
