<?php

namespace App\Http\Controllers;

use App\Http\Requests\InquiryRequest;
use App\Mail\InquiryResponseMail;
use App\Models\Contribution;
use App\Models\Inquiry;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class InquiryController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->input('sort', 'desc'); // Get the sort parameter from the request
        $search = $request->input('search'); // Get the search parameter from the request
        $filter = $request->input('filter'); // Get the filter parameter from the request

        // Fetch the role ID for the "Guest" role
        $guestRole = Role::where('role', 'Guest')->first();

        if (!$guestRole) {
            // Handle the case where the "Guest" role does not exist
            return redirect()->back()->with('error', 'Guest role not found. Please contact the administrator.');
        }

        $guestRoleId = $guestRole->role_id; // Get the role ID

        // Fetch users with the "Guest" role (keeping your original query)
        $unassigned_users = User::where('role_id', $guestRoleId)->get();

        // Get the current month's guest user count (fixed to check role_id instead of NULL)
        $current_month_unassigned_users = User::where('role_id', $guestRoleId)
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        // Get the previous month's guest user count (fixed to check role_id instead of NULL)
        $previous_month_unassigned_users = User::where('role_id', $guestRoleId)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->count();

        // Calculate the percentage change (keeping your original logic)
        $unassigned_user_percentage_change = 0;
        if ($previous_month_unassigned_users > 0) {
            $unassigned_user_percentage_change = (($current_month_unassigned_users - $previous_month_unassigned_users) / $previous_month_unassigned_users) * 100;
        }

        // Round the percentage to 2 decimal places (keeping your original logic)
        $unassigned_user_percentage_change = min(round($unassigned_user_percentage_change, 2), 100);

        // Inquiry
        $inquiries = Inquiry::all();

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
        $student_percentage_change = min(round($student_percentage_change, 2), 100);

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
        $student_percentage_change = min(round($student_percentage_change, 2), 100);
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

        return view('admin.notificationsinquiry', compact('inquiries', 'inquiries', 'sort', 'search', 'filter', 'total_students', 'student_percentage_change', 'unassigned_users', 'unassigned_user_percentage_change'));
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

    // Update inquiry
    public function update(Request $request, $id)
    {
        // Validate input
        $request->validate([
            'response_content' => 'required|string|min:10'
        ]);

        try {
            // Find inquiry
            $inquiry = Inquiry::with('user')->findOrFail($id);

            // Check if the user exists and has an email
            if (!$inquiry->user || empty($inquiry->user->email)) {
                return response()->json([
                    'success' => false,
                    'message' => 'User email not found for this inquiry.'
                ], 400);
            }

            // Update inquiry status
            $inquiry->update([
                'inquiry_status' => 'Resolved',
                'response_date' => now(),
                'response_content' => $request->response_content
            ]);

            // Send email (try-catch to handle failures)
            try {
                Mail::to($inquiry->user->email)->send(new InquiryResponseMail(
                    $inquiry->user->username ?? 'User',
                    $inquiry->inquiry,
                    $request->response_content
                ));
            } catch (\Exception $mailException) {
                Log::error('Failed to send email: ' . $mailException->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Response saved, but email failed to send.'
                ], 500);
            }

            return response()->json([
                'success' => true,
                'message' => 'Response sent successfully!'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Inquiry not found: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Inquiry not found.'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Inquiry response failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing the response.'
            ], 500);
        }
    }
}
