<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MarketingCoordinatorControllerr extends Controller
{
    // Search for marketing coordinators based on the search query
    public function search(Request $request)
    {
        $search = $request->input('search');

        if (!$search) {
            return redirect()->route('admin.user-management.marketing-coordinator');
        }

        $marketing_coordinators = User::whereHas('role', function ($query) {
            $query->where('role', 'Marketing Coordinator');
        })
            ->where(function ($query) use ($search) {
                $query->where('username', 'LIKE', "%{$search}%")
                    ->orWhere('user_code', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('first_name', 'LIKE', "%{$search}%")
                    ->orWhere('last_name', 'LIKE', "%{$search}%");
            })
            ->paginate(10);

        return view('admin.usermanagementmarketingcoordinator', compact('marketing_coordinators', 'search'));
    }

    // Display a listing of the resource.
    public function index()
    {
        // Fetch users where role is 'Marketing Coordinator', sorted by newest first, with pagination
        $marketing_coordinators = User::whereHas('role', function ($query) {
            $query->where('role', 'Marketing Coordinator');
        })->orderBy('updated_at', 'desc')->paginate(10);

        return view('admin.usermanagementmarketingcoordinator', compact('marketing_coordinators'));
    }
}
