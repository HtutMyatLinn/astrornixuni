<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Faculty;
use Illuminate\Http\Request;

class MarketingCoordinatorControllerr extends Controller
{
    public function search(Request $request)
    {
        $search = $request->input('search');
        $facultyId = $request->input('faculty');
        $sortOrder = $request->input('sort', 'desc');

        $coordinatorsQuery = User::whereHas('role', function ($query) {
            $query->where('role', 'Marketing Coordinator');
        });

        if ($search) {
            $coordinatorsQuery->where(function ($query) use ($search) {
                $query->where('username', 'LIKE', "%{$search}%")
                    ->orWhere('user_code', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('first_name', 'LIKE', "%{$search}%")
                    ->orWhere('last_name', 'LIKE', "%{$search}%");
            });
        }

        if ($facultyId) {
            $coordinatorsQuery->where('faculty_id', $facultyId);
        }

        $marketing_coordinators = $coordinatorsQuery->orderBy('last_login_date', $sortOrder)->paginate(10)->appends($request->all());
        $faculties = Faculty::all();

        return view('admin.usermanagementmarketingcoordinator', compact('marketing_coordinators', 'search', 'faculties', 'facultyId', 'sortOrder'));
    }

    public function index()
    {
        $marketing_coordinators = User::whereHas('role', function ($query) {
            $query->where('role', 'Marketing Coordinator');
        })->orderBy('last_login_date', 'desc')->paginate(10);

        $faculties = Faculty::all();

        return view('admin.usermanagementmarketingcoordinator', compact('marketing_coordinators', 'faculties'));
    }
}
