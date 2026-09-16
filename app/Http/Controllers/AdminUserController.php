<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    /**
     * Display all users.
     */
    public function index(Request $request): View
    {
        $query = User::query();

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Role Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('role')) {
            $query->where('role', $request->input('role'));
        }

        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $users = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('pages.admin.users.index', [
            'users' => $users,
        ]);
    }

    /**
     * Display a specific user.
     */
    public function show(User $user): View
    {
        $user->loadCount('shortUrls');

        $totalClicks = $user->shortUrls()->sum('click_count');

        $recentLinks = $user->shortUrls()
            ->latest()
            ->take(5)
            ->get();

        return view('pages.admin.users.show', [
            'user' => $user,
            'totalClicks' => $totalClicks,
            'recentLinks' => $recentLinks,
        ]);
    }

    /**
     * Display the edit form.
     */
    public function edit(User $user): View
    {
        return view('pages.admin.users.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update a user.
     */
    public function update(
        Request $request,
        User $user
    ): RedirectResponse {
        $validated = $request->validate([
            'first_name' => [
                'nullable',
                'string',
                'max:100',
            ],

            'last_name' => [
                'nullable',
                'string',
                'max:100',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique('users', 'email')
                    ->ignore($user->id),
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
                'nullable',
                'string',
                'max:100',
            ],

            'bio' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'role' => [
                'required',
                Rule::in(['user', 'admin']),
            ],

            'status' => [
                'required',
                Rule::in(['active', 'inactive']),
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Protect the current admin account
        |--------------------------------------------------------------------------
        |
        | An admin should not accidentally remove their own admin access.
        |
        */

        if ($user->id === $request->user()->id) {
            $validated['role'] = 'admin';
            $validated['status'] = 'active';
        }

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make(
                $validated['password']
            );
        }

        $user->update($validated);

        return redirect()
            ->route('admin.users.show', $user)
            ->with(
                'success',
                'User updated successfully.'
            );
    }

    /**
     * Activate or deactivate a user.
     */
    public function toggleStatus(
        Request $request,
        User $user
    ): RedirectResponse {
        /*
        |--------------------------------------------------------------------------
        | Prevent self-deactivation
        |--------------------------------------------------------------------------
        */

        if ($user->id === $request->user()->id) {
            return back()->with(
                'error',
                'You cannot deactivate your own account.'
            );
        }

        $user->update([
            'status' => $user->status === 'active'
                ? 'inactive'
                : 'active',
        ]);

        $message = $user->status === 'active'
            ? 'User activated successfully.'
            : 'User deactivated successfully.';

        return back()->with('success', $message);
    }

    /**
     * Delete a user.
     */
    public function destroy(
        Request $request,
        User $user
    ): RedirectResponse {
        /*
        |--------------------------------------------------------------------------
        | Prevent self-deletion
        |--------------------------------------------------------------------------
        */

        if ($user->id === $request->user()->id) {
            return back()->with(
                'error',
                'You cannot delete your own account.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Prevent deleting the last administrator
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'admin') {
            $adminCount = User::where('role', 'admin')->count();

            if ($adminCount <= 1) {
                return back()->with(
                    'error',
                    'The last administrator cannot be deleted.'
                );
            }
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with(
                'success',
                'User deleted successfully.'
            );
    }
}