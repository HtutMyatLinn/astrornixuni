<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditAccountSettingRequest;
use App\Models\PasswordResetRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class MarketingManagerController extends Controller
{
    public function marketingmanagerAccountSetting()
    {
        return view('marketingmanager.accountsetting');
    }
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
    public function updateAccountSetting(EditAccountSettingRequest $request, $id)
    {
        // Find the user by ID
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

        // Update the user's personal details
        $user->username = $request->input('username');
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');

        // Save changes to the database
        $user->save();

        // Redirect back with a success message
        return redirect()->route('marketingmanager.account-setting')->with('success', 'Account settings updated successfully.');
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
