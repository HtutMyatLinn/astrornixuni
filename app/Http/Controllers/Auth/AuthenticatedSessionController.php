<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        // Get the authenticated user
        $user = $request->user();

        // Increase login count
        $user->increment('login_count');

        // Change the user's status to active (1)
        $user->status = 1;
        $user->save();

        // Check if the user has a role assigned
        if ($user->role) {
            // Get the role name from the role relationship
            $roleName = $user->role->role;

            // Redirect based on role
            switch ($roleName) {
                case 'Admin':
                    return redirect('admin/dashboard');
                case 'Marketing Manager':
                    return redirect('marketingmanager/dashboard');
                case 'Marketing Coordinator':
                    return redirect('marketingcoordinator/dashboard');
                case 'Student':
                    return redirect('student/dashboard');
                default:
                    return redirect('/');
            }
        }

        // If the user has no role assigned, redirect to home
        return redirect('/');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
