<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogger;
use App\Models\ShortUrl;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminLinkController extends Controller
{
    /**
     * Display all links in the system.
     */
    public function index(Request $request): View
    {
        $query = ShortUrl::with('user');

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($query) use ($search) {
                $query->where(
                    'original_url',
                    'like',
                    "%{$search}%"
                )
                    ->orWhere(
                        'short_code',
                        'like',
                        "%{$search}%"
                    )
                    ->orWhere(
                        'custom_alias',
                        'like',
                        "%{$search}%"
                    )
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where(
                            'name',
                            'like',
                            "%{$search}%"
                        )
                            ->orWhere(
                                'email',
                                'like',
                                "%{$search}%"
                            );
                    });
            });
        }

        /*
        |--------------------------------------------------------------------------
        | User Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('user_id')) {
            $query->where(
                'user_id',
                $request->input('user_id')
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {
            $query->where(
                'status',
                $request->input('status')
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Favorite Filter
        |--------------------------------------------------------------------------
        */

        if ($request->boolean('favorite')) {
            $query->where(
                'is_favorite',
                true
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Trash Filter
        |--------------------------------------------------------------------------
        */

        if ($request->boolean('trash')) {
            $query->onlyTrashed();
        }

        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $shortUrls = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $users = User::query()
            ->orderBy('name')
            ->get([
                'id',
                'name',
                'email',
            ]);

        return view(
            'pages.admin.links.index',
            [
                'shortUrls' => $shortUrls,
                'users' => $users,
            ]
        );
    }


    /**
     * Show the create link page.
     */
    public function create(): View
    {
        $users = User::query()
            ->orderBy('name')
            ->get([
                'id',
                'name',
                'email',
            ]);

        return view(
            'pages.admin.links.create',
            [
                'users' => $users,
            ]
        );
    }


    /**
     * Store a new link created by an administrator.
     *
     * Admin-created links do not accept a password.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => [
                'required',
                'integer',
                'exists:users,id',
            ],

            'original_url' => [
                'required',
                'url',
                'max:2048',
            ],

            'custom_alias' => [
                'nullable',
                'string',
                'min:3',
                'max:100',
                'alpha_dash',
                'unique:short_urls,custom_alias',
            ],

            'expires_at' => [
                'nullable',
                'date',
                'after:now',
            ],

            'scheduled_at' => [
                'nullable',
                'date',
                'after:now',
            ],

            'status' => [
                'required',
                Rule::in([
                    'active',
                    'disabled',
                    'expired',
                ]),
            ],

            'is_favorite' => [
                'nullable',
                'boolean',
            ],
        ], [
            'user_id.required' =>
                'Please select a link owner.',

            'user_id.exists' =>
                'The selected user does not exist.',

            'original_url.required' =>
                'Please enter a URL.',

            'original_url.url' =>
                'Please enter a valid URL.',

            'original_url.max' =>
                'The URL cannot be longer than 2048 characters.',

            'custom_alias.min' =>
                'Custom alias must be at least 3 characters.',

            'custom_alias.max' =>
                'Custom alias cannot exceed 100 characters.',

            'custom_alias.alpha_dash' =>
                'Custom alias may only contain letters, numbers, dashes and underscores.',

            'custom_alias.unique' =>
                'This custom alias is already in use.',

            'expires_at.after' =>
                'Expiration date must be in the future.',

            'scheduled_at.after' =>
                'Scheduled activation must be in the future.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Scheduled Time Must Be Before Expiration
        |--------------------------------------------------------------------------
        */

        if (
            !empty($validated['scheduled_at'])
            &&
            !empty($validated['expires_at'])
        ) {
            $scheduledAt = Carbon::parse(
                $validated['scheduled_at']
            );

            $expiresAt = Carbon::parse(
                $validated['expires_at']
            );

            if (
                $scheduledAt->greaterThanOrEqualTo(
                    $expiresAt
                )
            ) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'scheduled_at' =>
                            'Scheduled activation must be before the expiration date.',
                    ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Generate Unique Short Code
        |--------------------------------------------------------------------------
        */

        do {
            $shortCode = strtolower(
                \Illuminate\Support\Str::random(6)
            );
        } while (
            ShortUrl::where(
                'short_code',
                $shortCode
            )->exists()
        );

        /*
        |--------------------------------------------------------------------------
        | Create Link
        |
        | IMPORTANT:
        | No password is accepted or written here.
        |--------------------------------------------------------------------------
        */

        $shortUrl = ShortUrl::create([
            'user_id' =>
                $validated['user_id'],

            'original_url' =>
                $validated['original_url'],

            'short_code' =>
                $shortCode,

            'custom_alias' =>
                $validated['custom_alias'] ?? null,

            'click_count' =>
                0,

            'expires_at' =>
                $validated['expires_at'] ?? null,

            'scheduled_at' =>
                $validated['scheduled_at'] ?? null,

            'status' =>
                $validated['status'],

            'is_favorite' =>
                $request->boolean('is_favorite'),
        ]);

        ActivityLogger::log(
            'created',
            'Admin created short URL: ' .
            $shortUrl->short_code
        );

        return redirect()
            ->route(
                'admin.links.show',
                $shortUrl
            )
            ->with(
                'success',
                'Short link created successfully.'
            );
    }


    /**
     * Display a specific link.
     */
    public function show(
        ShortUrl $shortUrl
    ): View {
        $shortUrl->load([
            'user',
            'clicks' => function ($query) {
                $query->latest()->take(20);
            },
            'qrCodes',
        ]);

        return view(
            'pages.admin.links.show',
            [
                'shortUrl' => $shortUrl,
            ]
        );
    }


    /**
     * Show the edit page for any user's link.
     */
    public function edit(
        ShortUrl $shortUrl
    ): View {
        $users = User::query()
            ->orderBy('name')
            ->get([
                'id',
                'name',
                'email',
            ]);

        return view(
            'pages.admin.links.edit',
            [
                'shortUrl' => $shortUrl,
                'users' => $users,
            ]
        );
    }


    /**
     * Update any user's link.
     *
     * IMPORTANT:
     * The password is intentionally NOT accepted here.
     *
     * Even if someone manually submits:
     *
     * password=some-password
     *
     * it will be ignored because it is not part of the
     * validated data and is never passed to update().
     */
    public function update(
        Request $request,
        ShortUrl $shortUrl
    ): RedirectResponse {
        $validated = $request->validate([
            'user_id' => [
                'required',
                'integer',
                'exists:users,id',
            ],

            'original_url' => [
                'required',
                'url',
                'max:2048',
            ],

            'custom_alias' => [
                'nullable',
                'string',
                'min:3',
                'max:100',
                'alpha_dash',
                Rule::unique(
                    'short_urls',
                    'custom_alias'
                )->ignore(
                    $shortUrl->id
                ),
            ],

            'expires_at' => [
                'nullable',
                'date',
            ],

            'scheduled_at' => [
                'nullable',
                'date',
            ],

            'status' => [
                'required',
                Rule::in([
                    'active',
                    'disabled',
                    'expired',
                ]),
            ],

            'is_favorite' => [
                'nullable',
                'boolean',
            ],
        ], [
            'user_id.required' =>
                'Please select a link owner.',

            'user_id.exists' =>
                'The selected user does not exist.',

            'original_url.required' =>
                'Please enter a URL.',

            'original_url.url' =>
                'Please enter a valid URL.',

            'original_url.max' =>
                'The URL cannot be longer than 2048 characters.',

            'custom_alias.min' =>
                'Custom alias must be at least 3 characters.',

            'custom_alias.max' =>
                'Custom alias cannot exceed 100 characters.',

            'custom_alias.alpha_dash' =>
                'Custom alias may only contain letters, numbers, dashes and underscores.',

            'custom_alias.unique' =>
                'This custom alias is already in use.',

        ]);

        /*
        |--------------------------------------------------------------------------
        | Expiration Validation
        |--------------------------------------------------------------------------
        |
        | An existing expiration date can remain in the past when the
        | administrator explicitly chooses "expired".
        |
        | If a new expiration date is supplied, it must be in the future.
        |--------------------------------------------------------------------------
        */

        if (!empty($validated['expires_at'])) {
            $expiresAt = Carbon::parse(
                $validated['expires_at']
            );

            if (
                $expiresAt->isPast()
                &&
                $validated['status'] !== 'expired'
            ) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'expires_at' =>
                            'Expiration date must be in the future unless the link status is Expired.',
                    ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Scheduled Time Validation
        |--------------------------------------------------------------------------
        */

        if (!empty($validated['scheduled_at'])) {
            $scheduledAt = Carbon::parse(
                $validated['scheduled_at']
            );

            if (
                $scheduledAt->isPast()
                &&
                $validated['status'] === 'active'
            ) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'scheduled_at' =>
                            'Scheduled activation must be in the future for an active link.',
                    ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Scheduled Time Must Be Before Expiration
        |--------------------------------------------------------------------------
        */

        if (
            !empty($validated['scheduled_at'])
            &&
            !empty($validated['expires_at'])
        ) {
            $scheduledAt = Carbon::parse(
                $validated['scheduled_at']
            );

            $expiresAt = Carbon::parse(
                $validated['expires_at']
            );

            if (
                $scheduledAt->greaterThanOrEqualTo(
                    $expiresAt
                )
            ) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'scheduled_at' =>
                            'Scheduled activation must be before the expiration date.',
                    ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Capture Old Values For Activity Log
        |--------------------------------------------------------------------------
        */

        $oldOwnerId = $shortUrl->user_id;
        $oldStatus = $shortUrl->status;
        $oldFavorite = $shortUrl->is_favorite;

        /*
        |--------------------------------------------------------------------------
        | Update Link
        |
        | IMPORTANT:
        |
        | There is NO password field here.
        |
        | The existing password remains exactly as it is.
        |
        | We deliberately do not use:
        |
        | $request->all()
        |
        | or:
        |
        | $request->only(...)
        |
        | with password.
        |--------------------------------------------------------------------------
        */

        $shortUrl->update([
            'user_id' =>
                $validated['user_id'],

            'original_url' =>
                $validated['original_url'],

            'custom_alias' =>
                $validated['custom_alias'] ?? null,

            'expires_at' =>
                $validated['expires_at'] ?? null,

            'scheduled_at' =>
                $validated['scheduled_at'] ?? null,

            'status' =>
                $validated['status'],

            'is_favorite' =>
                $request->boolean('is_favorite'),
        ]);

        /*
        |--------------------------------------------------------------------------
        | Activity Log
        |--------------------------------------------------------------------------
        */

        $changes = [];

        if ($oldOwnerId != $shortUrl->user_id) {
            $changes[] = 'owner changed';
        }

        if ($oldStatus !== $shortUrl->status) {
            $changes[] =
                'status changed from ' .
                $oldStatus .
                ' to ' .
                $shortUrl->status;
        }

        if (
            (bool) $oldFavorite !==
            (bool) $shortUrl->is_favorite
        ) {
            $changes[] =
                $shortUrl->is_favorite
                    ? 'added to favorites'
                    : 'removed from favorites';
        }

        if (empty($changes)) {
            $changes[] = 'link configuration updated';
        }

        ActivityLogger::log(
            'updated',
            'Admin updated short URL: ' .
            $shortUrl->short_code .
            ' (' .
            implode(', ', $changes) .
            ')'
        );

        return redirect()
            ->route(
                'admin.links.show',
                $shortUrl
            )
            ->with(
                'success',
                'Short link updated successfully.'
            );
    }


    /**
     * Move any user's link to trash.
     */
    public function destroy(
        ShortUrl $shortUrl
    ): RedirectResponse {
        $shortCode = $shortUrl->short_code;

        $shortUrl->delete();

        ActivityLogger::log(
            'deleted',
            'Admin moved short URL to trash: ' .
            $shortCode
        );

        return redirect()
            ->route('admin.links.index')
            ->with(
                'success',
                'Link moved to trash successfully.'
            );
    }


    /**
     * Restore any trashed link.
     */
    public function restore(
        int $id
    ): RedirectResponse {
        $shortUrl = ShortUrl::onlyTrashed()
            ->where(
                'id',
                $id
            )
            ->firstOrFail();

        $shortUrl->restore();

        ActivityLogger::log(
            'restored',
            'Admin restored short URL: ' .
            $shortUrl->short_code
        );

        return back()->with(
            'success',
            'Link restored successfully.'
        );
    }


    /**
     * Permanently delete any trashed link.
     */
    public function forceDelete(
        int $id
    ): RedirectResponse {
        $shortUrl = ShortUrl::onlyTrashed()
            ->where(
                'id',
                $id
            )
            ->firstOrFail();

        $shortCode = $shortUrl->short_code;

        $shortUrl->forceDelete();

        ActivityLogger::log(
            'force_deleted',
            'Admin permanently deleted short URL: ' .
            $shortCode
        );

        return back()->with(
            'success',
            'Link permanently deleted.'
        );
    }
}
