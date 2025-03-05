<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Display a listing of the resource (default listing)
    public function index()
    {
        $admins = User::whereHas('role', function ($query) {
            $query->where('role', 'Admin');
        })->orderBy('updated_at', 'desc')->paginate(10);

        return view('admin.usermanagement', compact('admins'));
    }

    // Search for admins based on the search query
    public function search(Request $request)
    {
        $search = $request->input('search');

        if (!$search) {
            return redirect()->route('admin.user-management');
        }

        $admins = User::whereHas('role', function ($query) {
            $query->where('role', 'Admin');
        })
            ->where(function ($query) use ($search) {
                $query->where('username', 'LIKE', "%{$search}%")
                    ->orWhere('user_code', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('first_name', 'LIKE', "%{$search}%")
                    ->orWhere('last_name', 'LIKE', "%{$search}%");
            })
            ->paginate(10);

        return view('admin.usermanagement', compact('admins', 'search'));
    }

    // Sort admins by last login date
    public function sortByLastLoginDate(Request $request)
    {
        $order = $request->input('order', 'asc'); // Default to ascending if not specified

        $admins = User::whereHas('role', function ($query) {
            $query->where('role', 'Admin');
        })
            ->orderBy('last_login_date', $order)
            ->paginate(10);

        return view('admin.usermanagement', compact('admins', 'order'));
    }
}
