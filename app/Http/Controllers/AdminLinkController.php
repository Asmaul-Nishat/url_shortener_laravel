<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogger;
use App\Models\ShortUrl;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminLinkController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | All Links / Favorites / Trash
    |--------------------------------------------------------------------------
    */

    public function index(Request $request): View
    {
        $isTrash = $request->boolean('trash');
        $isFavorite = $request->boolean('favorite');

        /*
        |--------------------------------------------------------------------------
        | Trash
        |--------------------------------------------------------------------------
        */

        if ($isTrash) {

            $query = ShortUrl::onlyTrashed()
                ->with('user');

        } else {

            /*
            |--------------------------------------------------------------------------
            | Normal Links
            |--------------------------------------------------------------------------
            */

            $query = ShortUrl::with('user');

            /*
            |--------------------------------------------------------------------------
            | Favorites
            |--------------------------------------------------------------------------
            */

            if ($isFavorite) {

                $query->where(
                    'is_favorite',
                    true
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Search
            |--------------------------------------------------------------------------
            */

            if ($request->filled('search')) {

                $search = $request->input('search');

                $query->where(function ($query) use ($search) {

                    $query->where(
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
        | Users for Filter / Link Assignment
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

        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

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


    /*
    |--------------------------------------------------------------------------
    | Show Link
    |--------------------------------------------------------------------------
    */

    public function show(
        ShortUrl $shortUrl
    ): View {

        $shortUrl->load('user');

        return view(
            'pages.admin.links.show',
            [
                'shortUrl' => $shortUrl,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Create Link
    |--------------------------------------------------------------------------
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


    /*
    |--------------------------------------------------------------------------
    | Store Link
    |--------------------------------------------------------------------------
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

            'scheduled_at.after' =>
                'Scheduled activation must be in the future.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Validate Scheduled / Expiration Relationship
        |--------------------------------------------------------------------------
        */

        if (
            !empty($validated['scheduled_at'])
            &&
            !empty($validated['expires_at'])
        ) {

            if (
                \Carbon\Carbon::parse(
                    $validated['scheduled_at']
                )->greaterThanOrEqualTo(
                    \Carbon\Carbon::parse(
                        $validated['expires_at']
                    )
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
        |--------------------------------------------------------------------------
        |
        | IMPORTANT:
        | Password is intentionally NOT included.
        |
        | Admin cannot create or modify a user's password-protected
        | link password from the Admin Links section.
        |
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

        /*
        |--------------------------------------------------------------------------
        | Activity Log
        |--------------------------------------------------------------------------
        */

        ActivityLogger::log(
            'admin_created',
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
                'Short URL created successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Edit Link
    |--------------------------------------------------------------------------
    */

    public function edit(
        ShortUrl $shortUrl
    ): View {

        $shortUrl->load('user');

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


    /*
    |--------------------------------------------------------------------------
    | Update Link
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        ShortUrl $shortUrl
    ): RedirectResponse {

        /*
        |--------------------------------------------------------------------------
        | IMPORTANT SECURITY RULE
        |--------------------------------------------------------------------------
        |
        | There is intentionally NO password field here.
        |
        | Even if someone manually sends:
        |
        | password=...
        |
        | the password will not be updated because the update array
        | below contains only approved fields.
        |
        */

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
        ]);

        /*
        |--------------------------------------------------------------------------
        | Validate Scheduled / Expiration Relationship
        |--------------------------------------------------------------------------
        */

        if (
            !empty($validated['scheduled_at'])
            &&
            !empty($validated['expires_at'])
        ) {

            if (
                \Carbon\Carbon::parse(
                    $validated['scheduled_at']
                )->greaterThanOrEqualTo(
                    \Carbon\Carbon::parse(
                        $validated['expires_at']
                    )
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
        | Update ONLY Allowed Fields
        |--------------------------------------------------------------------------
        |
        | Password is deliberately omitted.
        |
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

        ActivityLogger::log(
            'admin_updated',
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
                'Short URL updated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Move Link to Trash
    |--------------------------------------------------------------------------
    */

    public function destroy(
        ShortUrl $shortUrl
    ): RedirectResponse {

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


    /*
    |--------------------------------------------------------------------------
    | Restore Link
    |--------------------------------------------------------------------------
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


    /*
    |--------------------------------------------------------------------------
    | Permanently Delete Link
    |--------------------------------------------------------------------------
    */

    public function forceDelete(
        int $id
    ): RedirectResponse {

        $shortUrl = ShortUrl::onlyTrashed()
            ->findOrFail($id);

        $shortCode =
            $shortUrl->short_code;

        /*
        |--------------------------------------------------------------------------
        | Delete QR Codes First
        |--------------------------------------------------------------------------
        |
        | This prevents orphan QR records if the relationship does not
        | have cascade delete configured at the database level.
        |
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