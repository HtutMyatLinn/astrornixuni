<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserEditRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class StudentController extends Controller
{
    public function update(UserEditRequest $request)
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = time() . '_' . $image->getClientOriginalName();

            // Define the path to store the image in the public folder
            $imagePath = public_path('profile_images');

            // Create the directory if it doesn't exist
            if (!File::isDirectory($imagePath)) {
                File::makeDirectory($imagePath, 0777, true, true);
            }

            // Move the image to the public folder
            $image->move($imagePath, $imageName);

            // Delete the old profile image if it exists
            if ($user->profile_image && File::exists(public_path('profile_images/' . $user->profile_image))) {
                File::delete(public_path('profile_images/' . $user->profile_image));
            }

            // Update user's profile image
            $user->profile_image = $imageName;
        }

        // Update user's personal details
        $user->username = $request->input('username');
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');

        // Save changes
        $user->save();

        // Flash a success message to the session
        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}
