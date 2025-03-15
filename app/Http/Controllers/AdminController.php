<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditAccountSettingRequest;
use App\Models\PasswordResetRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // Display a listing of the resource (default listing)
    public function index()
    {
        $admins = User::whereHas('role', function ($query) {
            $query->where('role', 'Admin');
        })->orderBy('updated_at', 'desc')->paginate(10);

        return view('admin.usermanagement', compact('admins'));
    }

    // Search for admins based on the search query
    public function search(Request $request)
    {
        $search = $request->input('search');

        if (!$search) {
            return redirect()->route('admin.user-management');
        }

        $admins = User::whereHas('role', function ($query) {
            $query->where('role', 'Admin');
        })
            ->where(function ($query) use ($search) {
                $query->where('username', 'LIKE', "%{$search}%")
                    ->orWhere('user_code', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('first_name', 'LIKE', "%{$search}%")
                    ->orWhere('last_name', 'LIKE', "%{$search}%");
            })
            ->paginate(10);

        return view('admin.usermanagement', compact('admins', 'search'));
    }

    // Sort admins by last login date
    public function sortByLastLoginDate(Request $request)
    {
        $order = $request->input('order', 'asc'); // Default to ascending if not specified

        $admins = User::whereHas('role', function ($query) {
            $query->where('role', 'Admin');
        })
            ->orderBy('last_login_date', $order)
            ->paginate(10);

        return view('admin.usermanagement', compact('admins', 'order'));
    }
    public function accountSetting()
    {
        // Get the currently authenticated admin user
        $user = Auth::user();
        return view('admin.accountsetting', compact('user'));
    }

    // Update the admin's account settings
    public function updateAccountSetting(EditAccountSettingRequest $request, $id)
    {
        // Find the admin user by ID
        $user = User::findOrFail($id);

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete the old profile image if it exists
            if ($user->profile_image && Storage::exists('public/profile_images/' . $user->profile_image)) {
                Storage::delete('public/profile_images/' . $user->profile_image);
            }

            // Store the new profile image in the 'storage/app/public/profile_images' directory
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = basename($path); // Save only the filename
        }

        // Update the admin's personal details
        $user->username = $request->input('username');
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');

        // Save changes to the database
        $user->save();

        // Redirect back with a success message
        return redirect()->route('admin.account-setting')->with('success', 'Account settings updated successfully.');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
            'new_password_confirmation' => 'required', // Add this line
        ], [
            'new_password.confirmed' => 'The password confirmation does not match.',
            'new_password_confirmation.required' => 'Please confirm your password.',
        ]);

        $user = Auth::user();

        // Check if the old password matches
        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->back()->withErrors(['old_password' => 'The old password is incorrect.']);
        }

        // Update the password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Password changed successfully.');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'password' => 'required|min:6',
        ]);

        $user = User::where('user_id', $request->user_id)->first();
        $user->password = Hash::make($request->password);

        // Update the PasswordResetRequest status
        PasswordResetRequest::where('user_id', $request->user_id)
            ->where('status', 'Pending') // Ensure only pending requests are updated
            ->update(['status' => 'Completed']);

        $user->save();

        return redirect()->back()->with('success', 'Password reset successfully.');
    }
}
