<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
     *
     * Admin can update user profile information,
     * role, and account status.
     *
     * Password cannot be viewed or changed by admin.
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
        ]);

        /*
        |--------------------------------------------------------------------------
        | Protect Current Admin Account
        |--------------------------------------------------------------------------
        |
        | The logged-in admin cannot remove their own admin role
        | or deactivate their own account.
        |
        */

        if ($user->id === $request->user()->id) {
            $validated['role'] = 'admin';
            $validated['status'] = 'active';
        }

        /*
        |--------------------------------------------------------------------------
        | Password Protection
        |--------------------------------------------------------------------------
        |
        | Password is intentionally NOT included here.
        |
        | Admin cannot:
        | - View a password
        | - Change a password
        | - Set a new password
        | - Reset a password
        |
        */

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
        | Prevent Self-Deactivation
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
        | Prevent Self-Deletion
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
        | Prevent Deleting the Last Administrator
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

        /*
        |--------------------------------------------------------------------------
        | Delete User
        |--------------------------------------------------------------------------
        */

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with(
                'success',
                'User deleted successfully.'
            );
    }
}