<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MarketingCoordinatorControllerr extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        // Fetch users where role is 'Marketing Coordinator', sorted by newest first, with pagination
        $marketing_coordinators = User::whereHas('role', function ($query) {
            $query->where('role', 'Marketing Coordinator');
        })->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.usermanagementmarketingcoordinator', compact('marketing_coordinators'));
    }
}
