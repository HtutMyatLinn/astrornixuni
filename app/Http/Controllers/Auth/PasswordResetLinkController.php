<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PasswordResetRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ]);

        // Retrieve the user by email
        $user = User::where('email', $request->email)->first();

        if ($user) {
            // Store the password reset request with user_id
            $passwordReset = new PasswordResetRequest();
            $passwordReset->user_id = $user->user_id;  // Store user_id
            $passwordReset->save();

            return redirect()->back()->with('success', 'Your password reset request is sent to the admin.');
        }

        return redirect()->back()->withErrors(['email' => 'User not found.']);
    }
}
