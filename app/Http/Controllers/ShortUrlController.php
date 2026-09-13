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
    | Create
    |--------------------------------------------------------------------------
    */

    public function create(): View
    {
        return view('pages.links.create');
    }


    /*
    |--------------------------------------------------------------------------
    | Store
    |--------------------------------------------------------------------------
    */

    public function store(Request $request): RedirectResponse
    {
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

            'custom_alias.alpha_dash' =>
                'The custom alias may only contain letters, numbers, dashes, and underscores.',

            'custom_alias.unique' =>
                'This custom alias is already in use.',

            'expires_at.after' =>
                'The expiration date must be in the future.',

            'scheduled_at.after' =>
                'The activation date must be in the future.',

            'password.min' =>
                'The password must be at least 4 characters.',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Validate Schedule and Expiration
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

            if ($scheduledAt->gte($expiresAt)) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'scheduled_at' =>
                            'The activation date must be before the expiration date.',
                    ]);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Generate Unique Short Code
        |--------------------------------------------------------------------------
        |
        | The generated code must not exist in:
        |
        | 1. short_urls.short_code
        | 2. short_urls.custom_alias
        |
        | 3. temporary guest URLs
        |
        */

        do {
            $shortCode = Str::random(6);

            $existsInDatabase = ShortUrl::where(
                'short_code',
                $shortCode
            )
                ->orWhere(
                    'custom_alias',
                    $shortCode
                )
                ->exists();

            $existsInGuestCache = Cache::has(
                'guest_short_url:' . $shortCode
            );

        } while (
            $existsInDatabase ||
            $existsInGuestCache
        );


        /*
        |--------------------------------------------------------------------------
        | Password
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
        | Guest User
        |--------------------------------------------------------------------------
        |
        | IMPORTANT:
        |
        | Guest URLs are NOT saved in the short_urls table.
        |
        | They are temporarily stored in Laravel Cache so the
        | generated short URL can still redirect correctly.
        |
        */

        if (!Auth::check()) {

            /*
            |--------------------------------------------------------------------------
            | Guest Short Code
            |--------------------------------------------------------------------------
            */

            $guestCode =
                $validated['custom_alias']
                ?? $shortCode;


            /*
            |--------------------------------------------------------------------------
            | Guest Expiration
            |--------------------------------------------------------------------------
            |
            | Default guest URL lifetime:
            | 24 hours.
            |
            | If expires_at is provided, use that instead.
            |
            */

            if (!empty($validated['expires_at'])) {
                $expiresAt = Carbon::parse(
                    $validated['expires_at']
                );

                $seconds = max(
                    60,
                    now()->diffInSeconds($expiresAt, false)
                );
            } else {
                $seconds = 60 * 60 * 24;
            }


            /*
            |--------------------------------------------------------------------------
            | Save Guest URL Temporarily
            |--------------------------------------------------------------------------
            */

            Cache::put(
                'guest_short_url:' . $guestCode,
                [
                    'original_url' =>
                        $validated['original_url'],

                    'short_code' =>
                        $guestCode,

                    'password' =>
                        $hashedPassword,

                    'scheduled_at' =>
                        $validated['scheduled_at'] ?? null,

                    'expires_at' =>
                        $validated['expires_at'] ?? null,

                    'created_at' =>
                        now()->toDateTimeString(),
                ],
                $seconds
            );


            /*
            |--------------------------------------------------------------------------
            | Guest Short URL
            |--------------------------------------------------------------------------
            */

            $shortUrl =
                url('/' . $guestCode);


            /*
            |--------------------------------------------------------------------------
            | Return to Create Page
            |--------------------------------------------------------------------------
            */

            return redirect()
                ->route('links.create')
                ->with('guest_short_url', $shortUrl)
                ->with(
                    'success',
                    'Your short URL has been created successfully.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Authenticated User
        |--------------------------------------------------------------------------
        |
        | Only authenticated users are saved in short_urls.
        |
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
            'Short URL Created',
            'URL Management',
            'Created short URL: ' .
            ($shortUrl->custom_alias ?: $shortUrl->short_code)
        );


        /*
        |--------------------------------------------------------------------------
        | Authenticated User Result
        |--------------------------------------------------------------------------
        |
        | We do NOT immediately send the user to /links.
        |
        | We return to the create page and show the generated URL.
        |
        */

        return redirect()
            ->route('links.create')
            ->with(
                'short_url',
                url(
                    '/' .
                    (
                        $shortUrl->custom_alias
                        ?: $shortUrl->short_code
                    )
                )
            )
            ->with(
                'success',
                'Short URL created successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | All Links
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
        $favoriteLinks = ShortUrl::where(
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
            compact('favoriteLinks')
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

        if ($shortUrl->user_id !== Auth::id()) {
            abort(403);
        }

        $shortUrl->update([
            'is_favorite' =>
                !$shortUrl->is_favorite,
        ]);

        ActivityLogger::log(
            $shortUrl->is_favorite
                ? 'Added to Favorites'
                : 'Removed from Favorites',
            'URL Management',
            $shortUrl->is_favorite
                ? 'Added short URL to favorites: ' .
                    (
                        $shortUrl->custom_alias
                        ?: $shortUrl->short_code
                    )
                : 'Removed short URL from favorites: ' .
                    (
                        $shortUrl->custom_alias
                        ?: $shortUrl->short_code
                    )
        );

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
        $trashedLinks = ShortUrl::onlyTrashed()
            ->where(
                'user_id',
                Auth::id()
            )
            ->latest('deleted_at')
            ->paginate(10);

        return view(
            'pages.links.trash',
            compact('trashedLinks')
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

        if ($shortUrl->user_id !== Auth::id()) {
            abort(403);
        }

        $shortUrlName =
            $shortUrl->custom_alias
            ?: $shortUrl->short_code;

        $shortUrl->delete();

        ActivityLogger::log(
            'Short URL Deleted',
            'URL Management',
            'Moved short URL to trash: ' .
            $shortUrlName
        );

        return redirect()
            ->route('links.index')
            ->with(
                'success',
                'Link moved to Trash.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Restore Link
    |--------------------------------------------------------------------------
    */

    public function restore(
        int $shortUrl
    ): RedirectResponse {

        $link = ShortUrl::onlyTrashed()
            ->where(
                'id',
                $shortUrl
            )
            ->where(
                'user_id',
                Auth::id()
            )
            ->firstOrFail();

        $shortUrlName =
            $link->custom_alias
            ?: $link->short_code;

        $link->restore();

        ActivityLogger::log(
            'Short URL Restored',
            'URL Management',
            'Restored short URL: ' .
            $shortUrlName
        );

        return redirect()
            ->route('links.trash')
            ->with(
                'success',
                'Link restored successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Permanently Delete
    |--------------------------------------------------------------------------
    */

    public function forceDelete(
        int $shortUrl
    ): RedirectResponse {

        $link = ShortUrl::onlyTrashed()
            ->where(
                'id',
                $shortUrl
            )
            ->where(
                'user_id',
                Auth::id()
            )
            ->firstOrFail();

        $shortUrlName =
            $link->custom_alias
            ?: $link->short_code;

        $link->forceDelete();

        ActivityLogger::log(
            'Short URL Permanently Deleted',
            'URL Management',
            'Permanently deleted short URL: ' .
            $shortUrlName
        );

        return redirect()
            ->route('links.trash')
            ->with(
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
        $trashedLinks = ShortUrl::onlyTrashed()
            ->where(
                'user_id',
                Auth::id()
            )
            ->get();

        $deletedCount =
            $trashedLinks->count();

        ShortUrl::onlyTrashed()
            ->where(
                'user_id',
                Auth::id()
            )
            ->forceDelete();

        if ($deletedCount > 0) {

            ActivityLogger::log(
                'Trash Emptied',
                'URL Management',
                'Permanently deleted ' .
                $deletedCount .
                ' short URL(s) from trash.'
            );
        }

        return redirect()
            ->route('links.trash')
            ->with(
                'success',
                'Trash emptied successfully.'
            );
    }
}