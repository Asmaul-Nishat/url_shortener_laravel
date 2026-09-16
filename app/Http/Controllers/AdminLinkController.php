<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogger;
use App\Models\ShortUrl;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminLinkController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Admin Links - Create
    |--------------------------------------------------------------------------
    */

    public function create(): View
    {
        $users = User::where('status', 'active')
            ->orderBy('name')
            ->get([
                'id',
                'name',
                'email',
            ]);

        return view('pages.admin.links.create', [
            'users' => $users,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Admin Links - Store
    |--------------------------------------------------------------------------
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

            'password' => [
                'nullable',
                'string',
                'min:4',
                'max:255',
            ],

            'scheduled_at' => [
                'nullable',
                'date',
                'after:now',
            ],

            'status' => [
                'required',
                'in:active,expired,disabled',
            ],

            'is_favorite' => [
                'nullable',
                'boolean',
            ],
        ], [
            'user_id.required' =>
                'Please select a user.',

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

            'password.min' =>
                'Password must be at least 4 characters.',

            'scheduled_at.after' =>
                'Scheduled activation must be in the future.',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Make sure scheduled time is before expiration
        |--------------------------------------------------------------------------
        */

        if (
            !empty($validated['scheduled_at']) &&
            !empty($validated['expires_at'])
        ) {
            $scheduledAt = Carbon::parse(
                $validated['scheduled_at']
            );

            $expiresAt = Carbon::parse(
                $validated['expires_at']
            );

            if ($scheduledAt->greaterThanOrEqualTo($expiresAt)) {
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
        | Make sure selected user is active
        |--------------------------------------------------------------------------
        */

        $user = User::findOrFail(
            $validated['user_id']
        );

        if (!$user->isActive()) {
            return back()
                ->withInput()
                ->withErrors([
                    'user_id' =>
                        'You can only create links for an active user.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Generate unique short code
        |--------------------------------------------------------------------------
        */

        do {
            $shortCode = Str::lower(
                Str::random(6)
            );

        } while (
            ShortUrl::withTrashed()
                ->where('short_code', $shortCode)
                ->exists()
        );


        /*
        |--------------------------------------------------------------------------
        | Hash password if provided
        |--------------------------------------------------------------------------
        */

        $hashedPassword = null;

        if (!empty($validated['password'])) {
            $hashedPassword = Hash::make(
                $validated['password']
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Create short URL
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

            'password' =>
                $hashedPassword,

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

        ActivityLogger::log(
            'created',
            'Admin created short URL: ' .
            $shortUrl->short_code .
            ' for user: ' .
            $user->email
        );


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'admin.links.show',
                $shortUrl
            )
            ->with(
                'success',
                'Short URL created successfully for ' .
                $user->name .
                '.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Admin Links - Index
    |--------------------------------------------------------------------------
    */

    public function index(Request $request): View
    {
        $query = ShortUrl::with('user');

        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($query) use ($search) {
                $query
                    ->where(
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
                        $userQuery
                            ->where(
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

        if ($request->filled('user_id')) {
            $query->where(
                'user_id',
                $request->input('user_id')
            );
        }

        if ($request->filled('status')) {
            $status = $request->input('status');

            if ($status === 'active') {
                $query->where(function ($query) {
                    $query
                        ->whereNull('expires_at')
                        ->orWhere(
                            'expires_at',
                            '>',
                            now()
                        );
                });
            }

            if ($status === 'expired') {
                $query
                    ->whereNotNull('expires_at')
                    ->where(
                        'expires_at',
                        '<=',
                        now()
                    );
            }

            if ($status === 'disabled') {
                $query->where(
                    'status',
                    'disabled'
                );
            }
        }

        if ($request->input('favorite') === '1') {
            $query->where(
                'is_favorite',
                true
            );
        }

        if ($request->input('trash') === '1') {
            $query->onlyTrashed();
        }

        $links = $query
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $users = User::orderBy('name')
            ->get([
                'id',
                'name',
                'email',
            ]);

        return view(
            'pages.admin.links.index',
            [
                'links' => $links,
                'users' => $users,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Admin Links - Show
    |--------------------------------------------------------------------------
    */

    public function show(
        ShortUrl $shortUrl
    ): View {
        $shortUrl->load([
            'user',
            'clicks',
            'qrCodes',
        ]);

        return view(
            'pages.admin.links.show',
            [
                'shortUrl' => $shortUrl,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Admin Links - Edit
    |--------------------------------------------------------------------------
    */

    public function edit(
        ShortUrl $shortUrl
    ): View {
        $users = User::orderBy('name')
            ->get([
                'id',
                'name',
                'email',
                'status',
            ]);

        return view(
            'pages.admin.links.edit',
            [
                'shortUrl' => $shortUrl,
                'users' => $users,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Admin Links - Update
    |--------------------------------------------------------------------------
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
                'unique:short_urls,custom_alias,' .
                    $shortUrl->id,
            ],

            'expires_at' => [
                'nullable',
                'date',
            ],

            'password' => [
                'nullable',
                'string',
                'min:4',
                'max:255',
            ],

            'scheduled_at' => [
                'nullable',
                'date',
            ],

            'status' => [
                'required',
                'in:active,expired,disabled',
            ],

            'is_favorite' => [
                'nullable',
                'boolean',
            ],
        ], [
            'original_url.required' =>
                'Please enter a URL.',

            'original_url.url' =>
                'Please enter a valid URL.',

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
        | Validate expiration
        |--------------------------------------------------------------------------
        */

        if (!empty($validated['expires_at'])) {
            $expiresAt = Carbon::parse(
                $validated['expires_at']
            );

            if (
                $expiresAt->lessThanOrEqualTo(now()) &&
                $validated['status'] !== 'expired'
            ) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'expires_at' =>
                            'Expiration date must be in the future unless the link status is expired.',
                    ]);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Validate scheduled time
        |--------------------------------------------------------------------------
        */

        if (!empty($validated['scheduled_at'])) {
            $scheduledAt = Carbon::parse(
                $validated['scheduled_at']
            );

            if (
                $scheduledAt->lessThanOrEqualTo(now())
            ) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'scheduled_at' =>
                            'Scheduled activation must be in the future.',
                    ]);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Scheduled time must be before expiration
        |--------------------------------------------------------------------------
        */

        if (
            !empty($validated['scheduled_at']) &&
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
        | Validate selected user
        |--------------------------------------------------------------------------
        */

        $user = User::findOrFail(
            $validated['user_id']
        );


        /*
        |--------------------------------------------------------------------------
        | Prepare update data
        |--------------------------------------------------------------------------
        */

        $updateData = [
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
        ];


        /*
        |--------------------------------------------------------------------------
        | Update password only when a new password is entered
        |--------------------------------------------------------------------------
        */

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make(
                $validated['password']
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Update
        |--------------------------------------------------------------------------
        */

        $shortUrl->update(
            $updateData
        );


        /*
        |--------------------------------------------------------------------------
        | Activity Log
        |--------------------------------------------------------------------------
        */

        ActivityLogger::log(
            'updated',
            'Admin updated short URL: ' .
            $shortUrl->short_code
        );


        return redirect()
            ->route(
                'admin.links.show',
                $shortUrl
            )
            ->with(
                'success',
                'Link updated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Admin Links - Move to Trash
    |--------------------------------------------------------------------------
    */

    public function destroy(
        ShortUrl $shortUrl
    ): RedirectResponse {
        $shortUrl->delete();

        ActivityLogger::log(
            'deleted',
            'Admin moved short URL to trash: ' .
            $shortUrl->short_code
        );

        return redirect()
            ->route('admin.links.index')
            ->with(
                'success',
                'Link moved to trash successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Admin Links - Restore
    |--------------------------------------------------------------------------
    */

    public function restore(
        string $id
    ): RedirectResponse {
        $shortUrl = ShortUrl::onlyTrashed()
            ->findOrFail($id);

        $shortUrl->restore();

        ActivityLogger::log(
            'restored',
            'Admin restored short URL: ' .
            $shortUrl->short_code
        );

        return redirect()
            ->route(
                'admin.links.index',
                [
                    'trash' => '1',
                ]
            )
            ->with(
                'success',
                'Link restored successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Admin Links - Permanent Delete
    |--------------------------------------------------------------------------
    */

    public function forceDelete(
        string $id
    ): RedirectResponse {
        $shortUrl = ShortUrl::onlyTrashed()
            ->findOrFail($id);

        $shortCode = $shortUrl->short_code;

        $shortUrl->forceDelete();

        ActivityLogger::log(
            'force_deleted',
            'Admin permanently deleted short URL: ' .
            $shortCode
        );

        return redirect()
            ->route(
                'admin.links.index',
                [
                    'trash' => '1',
                ]
            )
            ->with(
                'success',
                'Link permanently deleted.'
            );
    }
}