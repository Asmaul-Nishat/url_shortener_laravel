<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use App\Models\SystemSetting;
use App\Models\UrlClick;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RedirectController extends Controller
{
    /**
     * Handle a short URL.
     *
     * The URL can belong to:
     *
     * 1. An authenticated user's database record
     * 2. A temporary guest URL stored in Cache
     */
    public function redirect(
        Request $request,
        string $shortCode
    ): View|RedirectResponse|Response {
        /*
        |--------------------------------------------------------------------------
        | First: Find Database Short URL
        |--------------------------------------------------------------------------
        */
        $shortUrl = ShortUrl::where(
            'short_code',
            $shortCode
        )
            ->orWhere(
                'custom_alias',
                $shortCode
            )
            ->first();

        /*
        |--------------------------------------------------------------------------
        | Database URL Found
        |--------------------------------------------------------------------------
        */
        if ($shortUrl) {
            return $this->handleDatabaseShortUrl(
                $request,
                $shortUrl
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Database URL Not Found
        |--------------------------------------------------------------------------
        | Check temporary guest URL in Cache.
        |--------------------------------------------------------------------------
        */
        $guestUrl = Cache::get(
            'guest_short_url:' . $shortCode
        );

        /*
        |--------------------------------------------------------------------------
        | Guest URL Not Found
        |--------------------------------------------------------------------------
        */
        if (!$guestUrl) {
            abort(404);
        }

        /*
        |--------------------------------------------------------------------------
        | Handle Guest URL
        |--------------------------------------------------------------------------
        */
        return $this->handleGuestShortUrl(
            $request,
            $guestUrl
        );
    }

    /**
     * Handle a database short URL.
     */
    private function handleDatabaseShortUrl(
        Request $request,
        ShortUrl $shortUrl
    ): View|RedirectResponse|Response {
        /*
        |--------------------------------------------------------------------------
        | Check Scheduled Activation
        |--------------------------------------------------------------------------
        */
        if ($shortUrl->isScheduled()) {
            return response()->view(
                'pages.links.scheduled',
                compact('shortUrl'),
                403
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Check Expiration
        |--------------------------------------------------------------------------
        */
        if ($shortUrl->isExpired()) {
            $shortUrl->update([
                'status' => 'expired',
            ]);

            return response()->view(
                'pages.links.expired',
                compact('shortUrl'),
                410
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Check Link Status
        |--------------------------------------------------------------------------
        */
        if ($shortUrl->status !== 'active') {
            abort(404);
        }

        /*
        |--------------------------------------------------------------------------
        | Check Password Protection
        |--------------------------------------------------------------------------
        */
        if ($shortUrl->isPasswordProtected()) {
            return view(
                'pages.links.password',
                compact('shortUrl')
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Complete Database Redirect
        |--------------------------------------------------------------------------
        */
        return $this->completeDatabaseRedirect(
            $request,
            $shortUrl
        );
    }

    /**
     * Handle a temporary guest short URL.
     */
    private function handleGuestShortUrl(
        Request $request,
        array $guestUrl
    ): View|RedirectResponse|Response {
        /*
        |--------------------------------------------------------------------------
        | Scheduled Activation
        |--------------------------------------------------------------------------
        */
        if (!empty($guestUrl['scheduled_at'])) {
            $scheduledAt = Carbon::parse(
                $guestUrl['scheduled_at']
            );

            if (now()->lt($scheduledAt)) {
                return response()->view(
                    'pages.links.guest-scheduled',
                    [
                        'guestUrl' => $guestUrl,
                    ],
                    403
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Expiration
        |--------------------------------------------------------------------------
        */
        if (!empty($guestUrl['expires_at'])) {
            $expiresAt = Carbon::parse(
                $guestUrl['expires_at']
            );

            if (now()->gte($expiresAt)) {
                return response()->view(
                    'pages.links.guest-expired',
                    [
                        'guestUrl' => $guestUrl,
                    ],
                    410
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Check Link Status
        |--------------------------------------------------------------------------
        */
        if (
            isset($guestUrl['status'])
            &&
            $guestUrl['status'] !== 'active'
        ) {
            abort(404);
        }

        /*
        |--------------------------------------------------------------------------
        | Password Protection
        |--------------------------------------------------------------------------
        */
        if (!empty($guestUrl['password'])) {
            return view(
                'pages.links.guest-password',
                [
                    'guestUrl' => $guestUrl,
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Complete Guest Redirect
        |--------------------------------------------------------------------------
        */
        return redirect()->away(
            $guestUrl['original_url']
        );
    }

    /**
     * Verify password for a password-protected database URL.
     */
    public function verifyPassword(
        Request $request,
        string $shortCode
    ): View|RedirectResponse|Response {
        /*
        |--------------------------------------------------------------------------
        | Find Database URL
        |--------------------------------------------------------------------------
        */
        $shortUrl = ShortUrl::where(
            'short_code',
            $shortCode
        )
            ->orWhere(
                'custom_alias',
                $shortCode
            )
            ->first();

        /*
        |--------------------------------------------------------------------------
        | Database URL Not Found
        |--------------------------------------------------------------------------
        | Check guest cache.
        |--------------------------------------------------------------------------
        */
        if (!$shortUrl) {
            $guestUrl = Cache::get(
                'guest_short_url:' . $shortCode
            );

            if (!$guestUrl) {
                abort(404);
            }

            return $this->verifyGuestPassword(
                $request,
                $guestUrl
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Database URL
        |--------------------------------------------------------------------------
        */
        if ($shortUrl->isScheduled()) {
            return response()->view(
                'pages.links.scheduled',
                compact('shortUrl'),
                403
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Check Expiration
        |--------------------------------------------------------------------------
        */
        if ($shortUrl->isExpired()) {
            $shortUrl->update([
                'status' => 'expired',
            ]);

            return response()->view(
                'pages.links.expired',
                compact('shortUrl'),
                410
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Check Status
        |--------------------------------------------------------------------------
        */
        if ($shortUrl->status !== 'active') {
            abort(404);
        }

        /*
        |--------------------------------------------------------------------------
        | No Password
        |--------------------------------------------------------------------------
        */
        if (!$shortUrl->isPasswordProtected()) {
            return $this->completeDatabaseRedirect(
                $request,
                $shortUrl
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Validate Password
        |--------------------------------------------------------------------------
        */
        $validated = $request->validate([
            'password' => [
                'required',
                'string',
            ],
        ], [
            'password.required' =>
                'Please enter the password.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Check Password
        |--------------------------------------------------------------------------
        */
        if (!Hash::check(
            $validated['password'],
            $shortUrl->password
        )) {
            return back()
                ->withErrors([
                    'password' =>
                        'Incorrect password. Please try again.',
                ])
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | Password Correct
        |--------------------------------------------------------------------------
        */
        return $this->completeDatabaseRedirect(
            $request,
            $shortUrl
        );
    }

    /**
     * Verify password for a guest URL.
     */
    private function verifyGuestPassword(
        Request $request,
        array $guestUrl
    ): RedirectResponse|View|Response {
        /*
        |--------------------------------------------------------------------------
        | Scheduled Activation
        |--------------------------------------------------------------------------
        */
        if (!empty($guestUrl['scheduled_at'])) {
            $scheduledAt = Carbon::parse(
                $guestUrl['scheduled_at']
            );

            if (now()->lt($scheduledAt)) {
                return response()->view(
                    'pages.links.guest-scheduled',
                    [
                        'guestUrl' => $guestUrl,
                    ],
                    403
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Expiration
        |--------------------------------------------------------------------------
        */
        if (!empty($guestUrl['expires_at'])) {
            $expiresAt = Carbon::parse(
                $guestUrl['expires_at']
            );

            if (now()->gte($expiresAt)) {
                return response()->view(
                    'pages.links.guest-expired',
                    [
                        'guestUrl' => $guestUrl,
                    ],
                    410
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Status
        |--------------------------------------------------------------------------
        */
        if (
            isset($guestUrl['status'])
            &&
            $guestUrl['status'] !== 'active'
        ) {
            abort(404);
        }

        /*
        |--------------------------------------------------------------------------
        | Check Password
        |--------------------------------------------------------------------------
        */
        if (empty($guestUrl['password'])) {
            return redirect()->away(
                $guestUrl['original_url']
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Validate Password
        |--------------------------------------------------------------------------
        */
        $validated = $request->validate([
            'password' => [
                'required',
                'string',
            ],
        ], [
            'password.required' =>
                'Please enter the password.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Verify Password
        |--------------------------------------------------------------------------
        */
        if (!Hash::check(
            $validated['password'],
            $guestUrl['password']
        )) {
            return back()
                ->withErrors([
                    'password' =>
                        'Incorrect password. Please try again.',
                ])
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | Successful Guest Redirect
        |--------------------------------------------------------------------------
        */
        return redirect()->away(
            $guestUrl['original_url']
        );
    }

    /**
     * Complete a database redirect and optionally record analytics.
     */
    private function completeDatabaseRedirect(
        Request $request,
        ShortUrl $shortUrl
    ): RedirectResponse {
        $settings = SystemSetting::current();

        /*
        |--------------------------------------------------------------------------
        | Analytics Setting
        |--------------------------------------------------------------------------
        |
        | When analytics is enabled:
        |
        | - Increase click_count
        | - Create UrlClick record
        |
        | When disabled:
        |
        | - Do not increase click_count
        | - Do not create UrlClick record
        |
        | Existing analytics data remains untouched.
        |
        */
        if ($settings->enable_analytics) {
            /*
            |--------------------------------------------------------------------------
            | Increase Click Count
            |--------------------------------------------------------------------------
            */
            $shortUrl->increment(
                'click_count'
            );

            /*
            |--------------------------------------------------------------------------
            | Store Click Analytics
            |--------------------------------------------------------------------------
            */
            UrlClick::create([
                'short_url_id' =>
                    $shortUrl->id,
                'ip_address' =>
                    $request->ip(),
                'user_agent' =>
                    $request->userAgent(),
                'referer' =>
                    $request->header('referer'),
                'clicked_at' =>
                    now(),
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */
        return redirect()->away(
            $shortUrl->original_url
        );
    }
}