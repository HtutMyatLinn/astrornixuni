<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
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
