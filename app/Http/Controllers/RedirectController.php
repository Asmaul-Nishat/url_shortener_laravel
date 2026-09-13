<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use App\Models\UrlClick;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RedirectController extends Controller
{
    /**
     * Handle a short URL.
     *
     * Examples:
     * /feed
     * /v84PVp
     */
    public function redirect(
        Request $request,
        string $shortCode
    ): View|RedirectResponse|Response {

        /*
        |--------------------------------------------------------------------------
        | Find Short URL
        |--------------------------------------------------------------------------
        |
        | The short URL can be accessed using either:
        |
        | 1. short_code
        | 2. custom_alias
        |
        */

        $shortUrl = $this->findShortUrl($shortCode);


        /*
        |--------------------------------------------------------------------------
        | Check Scheduled Activation
        |--------------------------------------------------------------------------
        |
        | If scheduled_at is set and the scheduled time has not arrived,
        | the link is not active yet.
        |
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
        |
        | If expires_at exists and the current time is after it,
        | the link has expired.
        |
        | HTTP status: 410 Gone
        |
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
        |
        | Only active links can be redirected.
        |
        */

        if ($shortUrl->status !== 'active') {

            abort(404);
        }


        /*
        |--------------------------------------------------------------------------
        | Check Password Protection
        |--------------------------------------------------------------------------
        |
        | Password is optional.
        |
        | No password:
        |     redirect immediately.
        |
        | Password exists:
        |     show password page.
        |
        */

        if ($shortUrl->isPasswordProtected()) {

            return view(
                'pages.links.password',
                compact('shortUrl')
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Complete Normal Redirect
        |--------------------------------------------------------------------------
        */

        return $this->completeRedirect(
            $request,
            $shortUrl
        );
    }


    /**
     * Verify password for a password-protected short URL.
     */
    public function verifyPassword(
        Request $request,
        string $shortCode
    ): View|RedirectResponse|Response {

        /*
        |--------------------------------------------------------------------------
        | Find Short URL
        |--------------------------------------------------------------------------
        */

        $shortUrl = $this->findShortUrl($shortCode);


        /*
        |--------------------------------------------------------------------------
        | Check Scheduled Activation
        |--------------------------------------------------------------------------
        |
        | Scheduled links cannot be accessed before their activation time.
        |
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
        |
        | Expired links cannot be accessed.
        |
        | HTTP status: 410 Gone
        |
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
        | Check Whether Password Exists
        |--------------------------------------------------------------------------
        |
        | Password protection is optional.
        |
        | If the link has no password, redirect normally.
        |
        */

        if (!$shortUrl->isPasswordProtected()) {

            return $this->completeRedirect(
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
        |
        | Only a successful password verification counts as a click.
        |
        */

        return $this->completeRedirect(
            $request,
            $shortUrl
        );
    }


    /**
     * Complete the redirect and record the click.
     */
    private function completeRedirect(
        Request $request,
        ShortUrl $shortUrl
    ): RedirectResponse {

        /*
        |--------------------------------------------------------------------------
        | Increase Click Count
        |--------------------------------------------------------------------------
        */

        $shortUrl->increment('click_count');


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


        /*
        |--------------------------------------------------------------------------
        | Redirect To Original URL
        |--------------------------------------------------------------------------
        */

        return redirect()->away(
            $shortUrl->original_url
        );
    }


    /**
     * Find a short URL using either short_code or custom_alias.
     */
    private function findShortUrl(
        string $shortCode
    ): ShortUrl {

        return ShortUrl::where(
            'short_code',
            $shortCode
        )
            ->orWhere(
                'custom_alias',
                $shortCode
            )
            ->firstOrFail();
    }
}