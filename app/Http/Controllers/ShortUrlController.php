<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogger;
use App\Models\ShortUrl;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ShortUrlController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Create Short URL Page
    |--------------------------------------------------------------------------
    */

    public function create(): View
    {
        return view('pages.links.create');
    }


    /*
    |--------------------------------------------------------------------------
    | Store Short URL
    |--------------------------------------------------------------------------
    */

    public function store(Request $request): RedirectResponse
    {
        /*
        |--------------------------------------------------------------------------
        | GUEST USER
        |--------------------------------------------------------------------------
        */

        if (!Auth::check()) {

            $validated = $request->validate([
                'original_url' => [
                    'required',
                    'url',
                    'max:2048',
                ],
            ], [
                'original_url.required' =>
                    'Please enter a URL.',

                'original_url.url' =>
                    'Please enter a valid URL.',

                'original_url.max' =>
                    'The URL cannot be longer than 2048 characters.',
            ]);


            /*
            |--------------------------------------------------------------------------
            | Generate unique guest short code
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
                ||
                Cache::has(
                    'guest_short_url:' . $shortCode
                )
            );


            /*
            |--------------------------------------------------------------------------
            | Store guest short URL in cache
            |--------------------------------------------------------------------------
            |
            | Guest URLs are not stored in the database.
            | They remain available for 24 hours.
            |
            */

            Cache::put(
                'guest_short_url:' . $shortCode,
                [
                    'original_url' =>
                        $validated['original_url'],

                    'short_code' =>
                        $shortCode,

                    'created_at' =>
                        now()->toDateTimeString(),
                ],
                now()->addHours(24)
            );


            /*
            |--------------------------------------------------------------------------
            | IMPORTANT
            |--------------------------------------------------------------------------
            |
            | Do NOT create guest_qr here.
            |
            | Shortening a URL should NOT automatically show
            | the QR Code result.
            |
            */


            /*
            |--------------------------------------------------------------------------
            | Return to landing page
            |--------------------------------------------------------------------------
            */

            return redirect()
                ->route('home')
                ->with(
                    'guest_short_url',
                    url('/' . $shortCode)
                )
                ->with(
                    'success',
                    'Short URL created successfully.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | AUTHENTICATED USER
        |--------------------------------------------------------------------------
        */

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
        ], [
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
        | Validate scheduled activation against expiration
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
        | Generate unique short code
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
        | Password
        |--------------------------------------------------------------------------
        */

        $hashedPassword = null;

        if (
            !empty($validated['password'])
        ) {
            $hashedPassword = Hash::make(
                $validated['password']
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Create authenticated short URL
        |--------------------------------------------------------------------------
        */

        $shortUrl = ShortUrl::create([
            'user_id' =>
                Auth::id(),

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
                'active',

            'is_favorite' =>
                false,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Activity Log
        |--------------------------------------------------------------------------
        */

        ActivityLogger::log(
            'created',
            'Created short URL: ' .
            $shortUrl->short_code
        );


        /*
        |--------------------------------------------------------------------------
        | Redirect authenticated user
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('links.create')
            ->with(
                'short_url',
                url('/' . $shortUrl->short_code)
            )
            ->with(
                'success',
                'Short URL created successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Links Index
    |--------------------------------------------------------------------------
    */

    public function index(): View
    {
        $shortUrls = ShortUrl::where(
            'user_id',
            Auth::id()
        )
            ->latest()
            ->paginate(10);

        return view(
            'pages.links.index',
            compact('shortUrls')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Favorites
    |--------------------------------------------------------------------------
    */

    public function favorites(): View
    {
        $shortUrls = ShortUrl::where(
            'user_id',
            Auth::id()
        )
            ->where(
                'is_favorite',
                true
            )
            ->latest()
            ->paginate(10);

        return view(
            'pages.links.favorites',
            compact('shortUrls')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Toggle Favorite
    |--------------------------------------------------------------------------
    */

    public function toggleFavorite(
        ShortUrl $shortUrl
    ): RedirectResponse {

        abort_unless(
            $shortUrl->user_id === Auth::id(),
            403
        );

        $shortUrl->update([
            'is_favorite' =>
                !$shortUrl->is_favorite,
        ]);

        return back()->with(
            'success',
            $shortUrl->is_favorite
                ? 'Link added to favorites.'
                : 'Link removed from favorites.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Trash
    |--------------------------------------------------------------------------
    */

    public function trash(): View
    {
        $shortUrls = ShortUrl::onlyTrashed()
            ->where(
                'user_id',
                Auth::id()
            )
            ->latest()
            ->paginate(10);

        return view(
            'pages.links.trash',
            compact('shortUrls')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Soft Delete
    |--------------------------------------------------------------------------
    */

    public function destroy(
        ShortUrl $shortUrl
    ): RedirectResponse {

        abort_unless(
            $shortUrl->user_id === Auth::id(),
            403
        );

        $shortUrl->delete();

        ActivityLogger::log(
            'deleted',
            'Moved short URL to trash: ' .
            $shortUrl->short_code
        );

        return back()->with(
            'success',
            'Link moved to trash.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Restore
    |--------------------------------------------------------------------------
    */

    public function restore(
        int $shortUrl
    ): RedirectResponse {

        $url = ShortUrl::onlyTrashed()
            ->where(
                'id',
                $shortUrl
            )
            ->where(
                'user_id',
                Auth::id()
            )
            ->firstOrFail();

        $url->restore();

        ActivityLogger::log(
            'restored',
            'Restored short URL: ' .
            $url->short_code
        );

        return back()->with(
            'success',
            'Link restored successfully.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Force Delete
    |--------------------------------------------------------------------------
    */

    public function forceDelete(
        int $shortUrl
    ): RedirectResponse {

        $url = ShortUrl::onlyTrashed()
            ->where(
                'id',
                $shortUrl
            )
            ->where(
                'user_id',
                Auth::id()
            )
            ->firstOrFail();

        $shortCode = $url->short_code;

        $url->forceDelete();

        ActivityLogger::log(
            'force_deleted',
            'Permanently deleted short URL: ' .
            $shortCode
        );

        return back()->with(
            'success',
            'Link permanently deleted.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Empty Trash
    |--------------------------------------------------------------------------
    */

    public function emptyTrash(): RedirectResponse
    {
        $urls = ShortUrl::onlyTrashed()
            ->where(
                'user_id',
                Auth::id()
            )
            ->get();

        foreach ($urls as $url) {

            ActivityLogger::log(
                'force_deleted',
                'Permanently deleted short URL: ' .
                $url->short_code
            );

            $url->forceDelete();
        }

        return back()->with(
            'success',
            'Trash emptied successfully.'
        );
    }
}