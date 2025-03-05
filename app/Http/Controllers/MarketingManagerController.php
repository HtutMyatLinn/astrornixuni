<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MarketingManagerController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->input('search');
        $sortOrder = $request->input('sort', 'desc');

        $managersQuery = User::whereHas('role', function ($query) {
            $query->where('role', 'Marketing Manager');
        });

        if ($search) {
            $managersQuery->where(function ($query) use ($search) {
                $query->where('username', 'LIKE', "%{$search}%")
                    ->orWhere('user_code', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('first_name', 'LIKE', "%{$search}%")
                    ->orWhere('last_name', 'LIKE', "%{$search}%");
            });
        }

        $marketing_managers = $managersQuery
            ->orderBy('last_login_date', $sortOrder)
            ->paginate(10)
            ->appends($request->all());

        return view('admin.usermanagementmarketingmanager', compact('marketing_managers', 'search', 'sortOrder'));
    }

    public function index(Request $request)
    {
        $sortOrder = $request->input('sort', 'desc');

        $marketing_managers = User::whereHas('role', function ($query) {
            $query->where('role', 'Marketing Manager');
        })
            ->orderBy('last_login_date', $sortOrder)
            ->paginate(10)
            ->appends($request->all());

        return view('admin.usermanagementmarketingmanager', compact('marketing_managers', 'sortOrder'));
    }
}
