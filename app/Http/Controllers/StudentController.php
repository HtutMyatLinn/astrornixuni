<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Faculty;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->input('search');
        $facultyId = $request->input('faculty');
        $sortOrder = $request->input('sort', 'desc');

        $studentsQuery = User::whereHas('role', function ($query) {
            $query->where('role', 'Student');
        });

        if ($search) {
            $studentsQuery->where(function ($query) use ($search) {
                $query->where('username', 'LIKE', "%{$search}%")
                    ->orWhere('user_code', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('first_name', 'LIKE', "%{$search}%")
                    ->orWhere('last_name', 'LIKE', "%{$search}%");
            });
        }

        if ($facultyId) {
            $studentsQuery->where('faculty_id', $facultyId);
        }

        $students = $studentsQuery->orderBy('last_login_date', $sortOrder)->paginate(10)->appends($request->all());
        $faculties = Faculty::all();

        return view('admin.usermanagementstudent', compact('students', 'search', 'faculties', 'facultyId', 'sortOrder'));
    }

    public function index()
    {
        $students = User::whereHas('role', function ($query) {
            $query->where('role', 'Student');
        })->orderBy('last_login_date', 'desc')->paginate(10);

        $faculties = Faculty::all();

        return view('admin.usermanagementstudent', compact('students', 'faculties'));
    }
}
