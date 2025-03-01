<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        // Fetch users where role is 'Admin', sorted by newest first, with pagination
        $admins = User::whereHas('role', function ($query) {
            $query->where('role', 'Admin');
        })->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.usermanagement', compact('admins'));
    }
}
