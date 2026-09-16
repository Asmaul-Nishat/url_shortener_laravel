<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogger;
use App\Models\ShortUrl;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminLinkController extends Controller
{
    /**
     * Display all links, favorite links, or trashed links.
     */
    public function index(Request $request): View
    {
        $isTrash = $request->boolean('trash');
        $isFavorite = $request->boolean('favorite');

        if ($isTrash) {
            $query = ShortUrl::onlyTrashed()
                ->with('user');
        } else {
            $query = ShortUrl::with('user');

            if ($isFavorite) {
                $query->where(
                    'is_favorite',
                    true
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($query) use ($search) {
                $query
                    ->where(
                        'short_code',
                        'like',
                        "%{$search}%"
                    )
                    ->orWhere(
                        'custom_alias',
                        'like',
                        "%{$search}%"
                    )
                    ->orWhere(
                        'original_url',
                        'like',
                        "%{$search}%"
                    );
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Filter by User
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
        | Filter by Status
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled('status')
            &&
            !$isTrash
        ) {
            $query->where(
                'status',
                $request->input('status')
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $links = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Users
        |--------------------------------------------------------------------------
        */

        $users = User::query()
            ->select([
                'id',
                'name',
                'email',
            ])
            ->orderBy('name')
            ->get();

        return view(
            'pages.admin.links.index',
            [
                'links' => $links,
                'users' => $users,
                'isTrash' => $isTrash,
                'isFavorite' => $isFavorite,
            ]
        );
    }

    /**
     * Display one link.
     *
     * withTrashed() is important because Admin can view
     * links that are currently in Trash.
     */
    public function show(int $id): View
    {
        $shortUrl = ShortUrl::withTrashed()
            ->with('user')
            ->findOrFail($id);

        $shortUrl->load([
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
     * Show create link page.
     */
    public function create(): View
    {
        $users = User::query()
            ->select([
                'id',
                'name',
                'email',
            ])
            ->orderBy('name')
            ->get();

        return view(
            'pages.admin.links.create',
            [
                'users' => $users,
            ]
        );
    }

    /**
     * Store a new link.
     */
    public function store(
        Request $request
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
        ]);

        /*
        |--------------------------------------------------------------------------
        | Validate Scheduled Time
        |--------------------------------------------------------------------------
        */

        if (
            !empty($validated['scheduled_at'])
            &&
            !empty($validated['expires_at'])
        ) {
            $scheduledAt = \Carbon\Carbon::parse(
                $validated['scheduled_at']
            );

            $expiresAt = \Carbon\Carbon::parse(
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
            $shortCode = Str::lower(
                Str::random(6)
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
            'admin_created',
            'Admin created short URL: ' .
            $shortUrl->short_code
        );

        return redirect()
            ->route(
                'admin.links.show',
                $shortUrl->id
            )
            ->with(
                'success',
                'Short URL created successfully.'
            );
    }

    /**
     * Show edit page.
     */
    public function edit(
        int $id
    ): View {

        $shortUrl = ShortUrl::withTrashed()
            ->with('user')
            ->findOrFail($id);

        $users = User::query()
            ->select([
                'id',
                'name',
                'email',
            ])
            ->orderBy('name')
            ->get();

        return view(
            'pages.admin.links.edit',
            [
                'shortUrl' => $shortUrl,
                'users' => $users,
            ]
        );
    }

    /**
     * Update a link.
     *
     * Admin does NOT change the link password.
     */
    public function update(
        Request $request,
        int $id
    ): RedirectResponse {

        $shortUrl = ShortUrl::withTrashed()
            ->findOrFail($id);

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
        ]);

        /*
        |--------------------------------------------------------------------------
        | Validate Scheduled Time
        |--------------------------------------------------------------------------
        */

        if (
            !empty($validated['scheduled_at'])
            &&
            !empty($validated['expires_at'])
        ) {
            $scheduledAt = \Carbon\Carbon::parse(
                $validated['scheduled_at']
            );

            $expiresAt = \Carbon\Carbon::parse(
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
        | Update Link
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

        ActivityLogger::log(
            'admin_updated',
            'Admin updated short URL: ' .
            $shortUrl->short_code
        );

        return redirect()
            ->route(
                'admin.links.show',
                $shortUrl->id
            )
            ->with(
                'success',
                'Short URL updated successfully.'
            );
    }

    /**
     * Move link to Trash.
     */
    public function destroy(
        int $id
    ): RedirectResponse {

        $shortUrl = ShortUrl::findOrFail($id);

        $shortCode =
            $shortUrl->short_code;

        $shortUrl->delete();

        ActivityLogger::log(
            'admin_deleted',
            'Admin moved short URL to trash: ' .
            $shortCode
        );

        return redirect()
            ->route(
                'admin.links.index'
            )
            ->with(
                'success',
                'Link moved to trash successfully.'
            );
    }

    /**
     * Restore a trashed link.
     */
    public function restore(
        int $id
    ): RedirectResponse {

        $shortUrl = ShortUrl::onlyTrashed()
            ->findOrFail($id);

        $shortCode =
            $shortUrl->short_code;

        $shortUrl->restore();

        ActivityLogger::log(
            'admin_restored',
            'Admin restored short URL: ' .
            $shortCode
        );

        return redirect()
            ->route(
                'admin.links.index',
                [
                    'trash' => 1,
                ]
            )
            ->with(
                'success',
                'Link restored successfully.'
            );
    }

    /**
     * Permanently delete a trashed link.
     */
    public function forceDelete(
        int $id
    ): RedirectResponse {

        $shortUrl = ShortUrl::onlyTrashed()
            ->with('qrCodes')
            ->findOrFail($id);

        $shortCode =
            $shortUrl->short_code;

        /*
        |--------------------------------------------------------------------------
        | Delete QR logos
        |--------------------------------------------------------------------------
        */

        foreach (
            $shortUrl->qrCodes as $qrCode
        ) {
            if (
                $qrCode->logo_path
                &&
                Storage::disk('public')->exists(
                    $qrCode->logo_path
                )
            ) {
                Storage::disk('public')->delete(
                    $qrCode->logo_path
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Delete QR records
        |--------------------------------------------------------------------------
        */

        $shortUrl->qrCodes()->delete();

        /*
        |--------------------------------------------------------------------------
        | Permanently Delete Link
        |--------------------------------------------------------------------------
        */

        $shortUrl->forceDelete();

        ActivityLogger::log(
            'admin_force_deleted',
            'Admin permanently deleted short URL: ' .
            $shortCode
        );

        return redirect()
            ->route(
                'admin.links.index',
                [
                    'trash' => 1,
                ]
            )
            ->with(
                'success',
                'Link permanently deleted.'
            );
    }
}
