<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Generate a unique user_code
        $user_code = $this->generateUniqueUserId();

        $user = User::create([
            'user_code' => $user_code,
            'username' => $request->username,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'last_login_date' => now(),
            'last_password_changed_date' => now(),
            'password_expired_date' => now()->addMonths(2),
            'login_count' => 0,
            'status' => false,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('/', absolute: false));
    }

    /**
     * Generate a unique user_code.
     */
    private function generateUniqueUserId(): string
    {
        $lastUser = User::orderBy('user_code', 'desc')->first();

        // If no users exist, start with U000001
        if (!$lastUser) {
            return 'U000001';
        }

        // Extract the numeric part of the last user_code
        $lastUserId = intval(substr($lastUser->user_code, 1));

        // Increment the numeric part
        $newNumericPart = $lastUserId + 1;

        // Generate the new user_id
        $user_code = 'U' . str_pad($newNumericPart, 6, '0', STR_PAD_LEFT);

        // Check if the generated user_id already exists
        while (User::where('user_code', $user_code)->exists()) {
            $newNumericPart++;
            $user_code = 'U' . str_pad($newNumericPart, 6, '0', STR_PAD_LEFT);
        }

        return $user_code;
    }
}
