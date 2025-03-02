<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // Search for students based on the search query
    public function search(Request $request)
    {
        $search = $request->input('search');

        if (!$search) {
            return redirect()->route('admin.user-management.student');
        }

        $students = User::whereHas('role', function ($query) {
            $query->where('role', 'Student');
        })
            ->where(function ($query) use ($search) {
                $query->where('username', 'LIKE', "%{$search}%")
                    ->orWhere('user_code', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('first_name', 'LIKE', "%{$search}%")
                    ->orWhere('last_name', 'LIKE', "%{$search}%");
            })
            ->paginate(10);

        return view('admin.usermanagementstudent', compact('students', 'search'));
    }

    // Display a listing of the resource.
    public function index()
    {
        // Fetch users where role is 'Student', sorted by newest first, with pagination
        $students = User::whereHas('role', function ($query) {
            $query->where('role', 'Student');
        })->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.usermanagementstudent', compact('students'));
    }
}
