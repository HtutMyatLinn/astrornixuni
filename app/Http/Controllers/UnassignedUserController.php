<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UnassignedUserController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        // Fetch users where role is not null, sorted by newest first, with pagination
        $users = User::whereNull('role_id')->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.notificationsunregister', compact('users'));
    }
}
