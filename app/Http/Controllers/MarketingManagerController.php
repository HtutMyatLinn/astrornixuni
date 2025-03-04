<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MarketingManagerController extends Controller
{
    // Search for marketing managers based on the search query
    public function search(Request $request)
    {
        $search = $request->input('search');

        if (!$search) {
            return redirect()->route('admin.user-management.marketing-manager');
        }

        $marketing_managers = User::whereHas('role', function ($query) {
            $query->where('role', 'Marketing Manager');
        })
            ->where(function ($query) use ($search) {
                $query->where('username', 'LIKE', "%{$search}%")
                    ->orWhere('user_code', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('first_name', 'LIKE', "%{$search}%")
                    ->orWhere('last_name', 'LIKE', "%{$search}%");
            })
            ->paginate(10);

        return view('admin.usermanagementmarketingmanager', compact('marketing_managers', 'search'));
    }

    // Display a listing of the resource.
    public function index()
    {
        // Fetch users where role is 'Marketing Manager', sorted by newest first, with pagination
        $marketing_managers = User::whereHas('role', function ($query) {
            $query->where('role', 'Marketing Manager');
        })->orderBy('updated_at', 'desc')->paginate(10);

        return view('admin.usermanagementmarketingmanager', compact('marketing_managers'));
    }
}
