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
                $query->where('is_favorite', true);
            }
        }

        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($query) use ($search) {
                $query
                    ->where('short_code', 'like', "%{$search}%")
                    ->orWhere('custom_alias', 'like', "%{$search}%")
                    ->orWhere('original_url', 'like', "%{$search}%");
            });
        }

        if ($request->filled('user_id')) {
            $query->where(
                'user_id',
                $request->input('user_id')
            );
        }

        if (
            $request->filled('status') &&
            !$isTrash
        ) {
            $query->where(
                'status',
                $request->input('status')
            );
        }

        $links = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

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


    public function create(): View
    {
        $users = User::query()
            ->select([
                'id',
                'name',
                'email',
            ])
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        return view(
            'pages.admin.links.create',
            [
                'users' => $users,
            ]
        );
    }


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

            'password' => [
                'nullable',
                'string',
                'min:4',
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


        if (
            !empty($validated['scheduled_at']) &&
            !empty($validated['expires_at'])
        ) {
            $scheduledAt = \Carbon\Carbon::parse(
                $validated['scheduled_at']
            );

            $expiresAt = \Carbon\Carbon::parse(
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


        $shortUrl = ShortUrl::create([
            'user_id' => $validated['user_id'],

            'original_url' => $validated['original_url'],

            'short_code' => $shortCode,

            'custom_alias' =>
                $validated['custom_alias'] ?? null,

            'click_count' => 0,

            'expires_at' =>
                $validated['expires_at'] ?? null,

            'password' =>
                !empty($validated['password'])
                    ? bcrypt($validated['password'])
                    : null,

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


    /*
    |--------------------------------------------------------------------------
    | Favorite / Undo Favorite
    |--------------------------------------------------------------------------
    */

    public function toggleFavorite(int $id): RedirectResponse
    {
        $shortUrl = ShortUrl::findOrFail($id);

        $shortUrl->update([
            'is_favorite' => !$shortUrl->is_favorite,
        ]);

        if ($shortUrl->is_favorite) {

            ActivityLogger::log(
                'admin_favorited',
                'Admin favorited short URL: ' .
                $shortUrl->short_code
            );

            return back()->with(
                'success',
                'Link added to favorites.'
            );
        }


        ActivityLogger::log(
            'admin_unfavorited',
            'Admin removed short URL from favorites: ' .
            $shortUrl->short_code
        );

        return back()->with(
            'success',
            'Link removed from favorites.'
        );
    }


    public function edit(int $id): View
    {
        $shortUrl = ShortUrl::withTrashed()
            ->with('user')
            ->findOrFail($id);

        return view(
            'pages.admin.links.edit',
            [
                'shortUrl' => $shortUrl,
            ]
        );
    }


    public function update(
        Request $request,
        int $id
    ): RedirectResponse {

        $shortUrl = ShortUrl::withTrashed()
            ->findOrFail($id);


        $validated = $request->validate([
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
                )->ignore($shortUrl->id),
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


        if (
            !empty($validated['scheduled_at']) &&
            !empty($validated['expires_at'])
        ) {
            $scheduledAt = \Carbon\Carbon::parse(
                $validated['scheduled_at']
            );

            $expiresAt = \Carbon\Carbon::parse(
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


        $shortUrl->update([
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


    public function destroy(int $id): RedirectResponse
    {
        $shortUrl = ShortUrl::findOrFail($id);

        $shortCode = $shortUrl->short_code;

        $shortUrl->delete();


        ActivityLogger::log(
            'admin_deleted',
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


    public function restore(int $id): RedirectResponse
    {
        $shortUrl = ShortUrl::onlyTrashed()
            ->findOrFail($id);

        $shortCode = $shortUrl->short_code;

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


    public function forceDelete(int $id): RedirectResponse
    {
        $shortUrl = ShortUrl::onlyTrashed()
            ->with('qrCodes')
            ->findOrFail($id);

        $shortCode = $shortUrl->short_code;


        foreach ($shortUrl->qrCodes as $qrCode) {

            if (
                $qrCode->logo_path &&
                Storage::disk('public')->exists(
                    $qrCode->logo_path
                )
            ) {
                Storage::disk('public')->delete(
                    $qrCode->logo_path
                );
            }

        }


        $shortUrl->qrCodes()->delete();

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
