<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogger;
use App\Models\AnonymousGeneration;
use App\Models\ShortUrl;
use App\Models\SystemSetting;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
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
    | Create Page
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
    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $settings = SystemSetting::current();

        /*
        |--------------------------------------------------------------------------
        | Guest URL
        |--------------------------------------------------------------------------
        */
        if (!Auth::check()) {

            /*
            |--------------------------------------------------------------------------
            | Check Guest Short URL Setting
            |--------------------------------------------------------------------------
            */
            if (!$settings->allow_guest_short_urls) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' =>
                            'Guest short URL creation is currently disabled by the administrator.',
                    ], 403);
                }

                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Guest short URL creation is currently disabled by the administrator.'
                    );
            }

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
            | Generate Unique Guest Short Code
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
            | Default Guest Expiration
            |--------------------------------------------------------------------------
            */
            $expiresAt = null;

            if ($settings->default_expiration_days > 0) {
                $expiresAt = now()
                    ->addDays($settings->default_expiration_days)
                    ->toDateTimeString();
            }

            /*
            |--------------------------------------------------------------------------
            | Guest Cache Lifetime
            |--------------------------------------------------------------------------
            |
            | Guest URLs previously lived for 24 hours.
            |
            | If the administrator configured a longer default expiration,
            | keep the cache alive until that expiration.
            |
            */
            $cacheUntil = now()->addHours(24);

            if ($expiresAt !== null) {
                $configuredExpiration = Carbon::parse($expiresAt);

                if ($configuredExpiration->greaterThan($cacheUntil)) {
                    $cacheUntil = $configuredExpiration;
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Store Guest URL Temporarily
            |--------------------------------------------------------------------------
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
                    'expires_at' =>
                        $expiresAt,
                    'status' =>
                        $settings->default_link_status,
                ],
                $cacheUntil
            );

            $shortUrl = url('/' . $shortCode);

            /*
            |--------------------------------------------------------------------------
            | Store Anonymous Short URL Generation
            |--------------------------------------------------------------------------
            */
            AnonymousGeneration::create([
                'type' => 'short_url',
            ]);

            /*
            |--------------------------------------------------------------------------
            | AJAX / Fetch Request
            |--------------------------------------------------------------------------
            */
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' =>
                        'Short URL created successfully.',
                    'short_url' =>
                        $shortUrl,
                    'short_code' =>
                        $shortCode,
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Normal Browser Request
            |--------------------------------------------------------------------------
            */
            return redirect()
                ->route('home')
                ->with(
                    'guest_short_url',
                    $shortUrl
                )
                ->with(
                    'success',
                    'Short URL created successfully.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Authenticated User URL
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
        | Apply Default Expiration
        |--------------------------------------------------------------------------
        |
        | User supplied expiration always takes priority.
        |
        | If no expiration was supplied and the administrator configured
        | a default expiration, automatically apply it.
        |
        */
        $expiresAt = null;

        if (!empty($validated['expires_at'])) {
            $expiresAt = Carbon::parse(
                $validated['expires_at']
            );
        } elseif ($settings->default_expiration_days > 0) {
            $expiresAt = now()->addDays(
                $settings->default_expiration_days
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Scheduled Date Must Be Before Expiration
        |--------------------------------------------------------------------------
        */
        if (
            !empty($validated['scheduled_at'])
            &&
            $expiresAt !== null
        ) {
            $scheduledAt = Carbon::parse(
                $validated['scheduled_at']
            );

            if (
                $scheduledAt->greaterThanOrEqualTo(
                    $expiresAt
                )
            ) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' =>
                            'Scheduled activation must be before the expiration date.',
                        'errors' => [
                            'scheduled_at' => [
                                'Scheduled activation must be before the expiration date.'
                            ],
                        ],
                    ], 422);
                }

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
        | Create Short URL
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
                $expiresAt,
            'password' =>
                $hashedPassword,
            'scheduled_at' =>
                $validated['scheduled_at'] ?? null,
            'status' =>
                $settings->default_link_status,
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
        | Generated URL
        |--------------------------------------------------------------------------
        */
        $generatedUrl = url(
            '/' .
            (
                $shortUrl->custom_alias
                ?: $shortUrl->short_code
            )
        );

        /*
        |--------------------------------------------------------------------------
        | AJAX / Fetch Response
        |--------------------------------------------------------------------------
        */
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' =>
                    'Short URL created successfully.',
                'short_url' =>
                    $generatedUrl,
                'short_code' =>
                    $shortUrl->short_code,
                'custom_alias' =>
                    $shortUrl->custom_alias,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Normal Browser Response
        |--------------------------------------------------------------------------
        */
        return redirect()
            ->route('links.create')
            ->with(
                'short_url',
                $generatedUrl
            )
            ->with(
                'success',
                'Short URL created successfully.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | User Links
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
        $trashedLinks = ShortUrl::onlyTrashed()
            ->where(
                'user_id',
                Auth::id()
            )
            ->latest()
            ->paginate(10);

        return view(
            'pages.links.trash',
            compact('trashedLinks')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Move To Trash
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
    | Permanent Delete
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

        $shortCode =
            $url->short_code;

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