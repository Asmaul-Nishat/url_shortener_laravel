<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile page.
     */
    public function edit(Request $request): View
    {
        return view(
            'pages.profile.index',
            [
                'user' => $request->user(),
            ]
        );
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'first_name' => [
                'required',
                'string',
                'max:100',
            ],

            'last_name' => [
                'nullable',
                'string',
                'max:100',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email,' . $user->id,
            ],

            'phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'country' => [
                'nullable',
                'string',
                'max:100',
            ],

            'timezone' => [
                'required',
                'string',
                'max:100',
            ],

            'bio' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'profile_photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Build Full Name
        |--------------------------------------------------------------------------
        */

        $fullName = trim(
            $validated['first_name'] .
            ' ' .
            ($validated['last_name'] ?? '')
        );

        /*
        |--------------------------------------------------------------------------
        | Update Profile Photo
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('profile_photo')) {

            if ($user->profile_photo_path) {
                Storage::disk('public')->delete(
                    $user->profile_photo_path
                );
            }

            $photoPath = $request
                ->file('profile_photo')
                ->store('profile-photos', 'public');

            $user->profile_photo_path = $photoPath;
        }

        /*
        |--------------------------------------------------------------------------
        | Update User
        |--------------------------------------------------------------------------
        */

        $user->first_name = $validated['first_name'];

        $user->last_name = $validated['last_name'] ?? null;

        $user->name = $fullName;

        $user->email = $validated['email'];

        $user->phone = $validated['phone'] ?? null;

        $user->country = $validated['country'] ?? null;

        $user->timezone = $validated['timezone'];

        $user->bio = $validated['bio'] ?? null;

        $user->save();

        return redirect()
            ->route('profile.edit')
            ->with(
                'success',
                'Profile updated successfully.'
            );
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag(
            'userDeletion',
            [
                'password' => [
                    'required',
                    'current_password',
                ],
            ]
        );

        $user = $request->user();

        Auth::logout();

        if ($user->profile_photo_path) {
            Storage::disk('public')->delete(
                $user->profile_photo_path
            );
        }

        $user->delete();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}