<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UnassignedUserController extends Controller
{
    // Search for unassigned users.
    public function search(Request $request)
    {
        $search = $request->input('search');

        if (!$search) {
            return redirect()->route('admin.notifications.unregister-user');
        }

        $users = User::whereDoesntHave('role')
            ->where(function ($query) use ($search) {
                $query->where('username', 'LIKE', "%{$search}%")
                    ->orWhere('user_code', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('first_name', 'LIKE', "%{$search}%")
                    ->orWhere('last_name', 'LIKE', "%{$search}%");
            })
            ->paginate(10);

        return view('admin.notificationsunregister', compact('users', 'search'));
    }

    // Display a listing of the resource.
    public function index()
    {
        // Fetch users where role is not null, sorted by newest first, with pagination
        $users = User::whereNull('role_id')->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.notificationsunregister', compact('users'));
    }
}
