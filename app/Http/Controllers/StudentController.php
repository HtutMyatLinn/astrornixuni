<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserEditRequest;
use App\Models\Faculty;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;


class StudentController extends Controller
{
    public function index()
    {
        $students = User::whereHas('role', function ($query) {
            $query->where('role', 'Student');
        })->orderBy('last_login_date', 'desc')->paginate(10); // Fetch students with pagination (10 per page)
        $faculties = Faculty::all();     // Fetch all faculties from the database
        return view('admin.usermanagementstudent', compact('students', 'faculties'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $sortOrder = $request->input('sort', 'desc');
        $faculty = $request->input('faculty');  // Get the selected faculty ID

        // Build the query for students
        $studentsQuery = User::whereHas('role', function ($query) {
            $query->where('role', 'Student');
        });

        // Apply search filters (username, first name, last name, email)
        if ($search) {
            $studentsQuery->where(function ($query) use ($search) {
                $query->where('username', 'LIKE', "%{$search}%")
                    ->orWhere('first_name', 'LIKE', "%{$search}%")
                    ->orWhere('last_name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        // Apply faculty filter if a faculty is selected
        if ($faculty) {
            $studentsQuery->where('faculty_id', $faculty);
        }

        // Get paginated results
        $students = $studentsQuery
            ->orderBy('last_login_date', $sortOrder)
            ->paginate(10)
            ->appends($request->all());

        // Fetch all faculties for the filter dropdown
        $faculties = Faculty::all();

        // Pass data to the view
        return view('admin.usermanagementstudent', compact('students', 'search', 'sortOrder', 'faculties', 'faculty'));
    }

    public function update(UserEditRequest $request)
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = time() . '_' . $image->getClientOriginalName();

            // Define the path to store the image in the public folder
            $imagePath = public_path('profile_images');

            // Create the directory if it doesn't exist
            if (!File::isDirectory($imagePath)) {
                File::makeDirectory($imagePath, 0777, true, true);
            }

            // Move the image to the public folder
            $image->move($imagePath, $imageName);

            // Delete the old profile image if it exists
            if ($user->profile_image && File::exists(public_path('profile_images/' . $user->profile_image))) {
                File::delete(public_path('profile_images/' . $user->profile_image));
            }

            // Update user's profile image
            $user->profile_image = $imageName;
        }

        // Update user's personal details
        $user->username = $request->input('username');
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');

        // Save changes
        $user->save();

        // Flash a success message to the session
        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}
