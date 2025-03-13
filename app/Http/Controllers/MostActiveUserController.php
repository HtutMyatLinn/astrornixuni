<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class MostActiveUserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('login_count', 'desc')->paginate(10); // Fetch students with pagination (10 per page)
        $roles = Role::all();
        return view('admin.mostactiveusers', compact('users', 'roles'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $roleId = $request->input('role');
        $sortOrder = $request->input('sort', 'desc');

        // Query to fetch users
        $usersQuery = User::query();

        // Apply search filter
        if ($search) {
            $usersQuery->where(function ($query) use ($search) {
                $query->where('username', 'LIKE', "%{$search}%")
                    ->orWhere('user_code', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('first_name', 'LIKE', "%{$search}%")
                    ->orWhere('last_name', 'LIKE', "%{$search}%");
            });
        }

        // Apply role filter
        if ($roleId) {
            $usersQuery->where('role_id', $roleId);
        }

        // Apply sorting
        $users = $usersQuery->orderBy('login_count', $sortOrder)->paginate(10)->appends($request->all());

        $roles = Role::all(); // Fetch all roles

        return view('admin.mostactiveusers', compact('users', 'roles', 'search', 'roleId', 'sortOrder'));
    }
}
