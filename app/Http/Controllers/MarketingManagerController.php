<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MarketingManagerController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        // Fetch users where role is 'Marketing Manager', sorted by newest first, with pagination
        $marketing_managers = User::whereHas('role', function ($query) {
            $query->where('role', 'Marketing Manager');
        })->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.usermanagementmarketingmanager', compact('marketing_managers'));
    }
}
