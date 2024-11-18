<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profileNew.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
// app/Http/Controllers/ProfileController.php

public function update(ProfileUpdateRequest $request): RedirectResponse
{
    $user = $request->user();

    // Handle profile_picture upload
    if ($request->hasFile('profile_picture')) {
        // Delete old profile picture if exists
        if ($user->profile_picture) {
            Storage::disk('public')->delete($user->profile_picture);
        }

        // Store new profile picture
        $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
        $user->profile_picture = $profilePicturePath;
    }

    // Handle cover_photo upload
    if ($request->hasFile('cover_photo')) {
        // Delete old cover photo if exists
        if ($user->cover_photo) {
            Storage::disk('public')->delete($user->cover_photo);
        }

        // Store new cover photo
        $coverPhotoPath = $request->file('cover_photo')->store('cover_photos', 'public');
        $user->cover_photo = $coverPhotoPath;
    }

    // Update other user attributes
    $user->fill($request->except(['profile_picture', 'cover_photo']));

    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }

    $user->save();

    return Redirect::route('profile.edit')->with('status', 'profile-updated');
}


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
