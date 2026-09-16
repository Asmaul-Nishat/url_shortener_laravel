<?php

namespace App\Http\Controllers;

use App\Models\AnonymousGeneration;
use App\Models\ShortUrl;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Admin Dashboard
    |--------------------------------------------------------------------------
    */

    public function index(Request $request): View
    {
        /*
        |--------------------------------------------------------------------------
        | Main System Statistics
        |--------------------------------------------------------------------------
        */

        $totalUsers = User::count();

        $totalLinks = ShortUrl::count();

        $totalClicks = ShortUrl::sum('click_count');

        $activeLinks = ShortUrl::where(function ($query) {
            $query->whereNull('expires_at')
                ->orWhere('expires_at', '>', now());
        })->count();

        $expiredLinks = ShortUrl::whereNotNull('expires_at')
            ->where('expires_at', '<=', now())
            ->count();


        /*
        |--------------------------------------------------------------------------
        | Recent Users
        |--------------------------------------------------------------------------
        */

        $recentUsers = User::latest()
            ->take(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Recent Links
        |--------------------------------------------------------------------------
        */

        $recentLinks = ShortUrl::with('user')
            ->latest()
            ->take(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Anonymous Generation Statistics
        |--------------------------------------------------------------------------
        |
        | These records are created only when a guest/anonymous visitor
        | successfully generates a short URL or QR code.
        |
        */

        $anonymousShortLinks = AnonymousGeneration::where(
            'type',
            'short_url'
        )->count();

        $anonymousQrCodes = AnonymousGeneration::where(
            'type',
            'qr_code'
        )->count();

        $totalAnonymousGenerations = AnonymousGeneration::count();


        /*
        |--------------------------------------------------------------------------
        | Anonymous Statistics - Today
        |--------------------------------------------------------------------------
        */

        $anonymousShortLinksToday = AnonymousGeneration::where(
            'type',
            'short_url'
        )
            ->whereDate(
                'created_at',
                today()
            )
            ->count();

        $anonymousQrCodesToday = AnonymousGeneration::where(
            'type',
            'qr_code'
        )
            ->whereDate(
                'created_at',
                today()
            )
            ->count();

        $totalAnonymousToday = AnonymousGeneration::whereDate(
            'created_at',
            today()
        )->count();


        /*
        |--------------------------------------------------------------------------
        | Anonymous Statistics - This Week
        |--------------------------------------------------------------------------
        */

        $anonymousShortLinksThisWeek = AnonymousGeneration::where(
            'type',
            'short_url'
        )
            ->whereBetween(
                'created_at',
                [
                    now()->startOfWeek(),
                    now()->endOfWeek(),
                ]
            )
            ->count();

        $anonymousQrCodesThisWeek = AnonymousGeneration::where(
            'type',
            'qr_code'
        )
            ->whereBetween(
                'created_at',
                [
                    now()->startOfWeek(),
                    now()->endOfWeek(),
                ]
            )
            ->count();

        $totalAnonymousThisWeek = AnonymousGeneration::whereBetween(
            'created_at',
            [
                now()->startOfWeek(),
                now()->endOfWeek(),
            ]
        )->count();


        /*
        |--------------------------------------------------------------------------
        | Anonymous Statistics - This Month
        |--------------------------------------------------------------------------
        */

        $anonymousShortLinksThisMonth = AnonymousGeneration::where(
            'type',
            'short_url'
        )
            ->whereBetween(
                'created_at',
                [
                    now()->startOfMonth(),
                    now()->endOfMonth(),
                ]
            )
            ->count();

        $anonymousQrCodesThisMonth = AnonymousGeneration::where(
            'type',
            'qr_code'
        )
            ->whereBetween(
                'created_at',
                [
                    now()->startOfMonth(),
                    now()->endOfMonth(),
                ]
            )
            ->count();

        $totalAnonymousThisMonth = AnonymousGeneration::whereBetween(
            'created_at',
            [
                    now()->startOfMonth(),
                    now()->endOfMonth(),
            ]
        )->count();


        /*
        |--------------------------------------------------------------------------
        | Return Dashboard
        |--------------------------------------------------------------------------
        */

        return view(
            'pages.admin.dashboard',
            [
                /*
                | Main statistics
                */
                'totalUsers' =>
                    $totalUsers,

                'totalLinks' =>
                    $totalLinks,

                'totalClicks' =>
                    $totalClicks,

                'activeLinks' =>
                    $activeLinks,

                'expiredLinks' =>
                    $expiredLinks,


                /*
                | Recent data
                */
                'recentUsers' =>
                    $recentUsers,

                'recentLinks' =>
                    $recentLinks,


                /*
                | Anonymous all-time statistics
                */
                'anonymousShortLinks' =>
                    $anonymousShortLinks,

                'anonymousQrCodes' =>
                    $anonymousQrCodes,

                'totalAnonymousGenerations' =>
                    $totalAnonymousGenerations,


                /*
                | Anonymous today statistics
                */
                'anonymousShortLinksToday' =>
                    $anonymousShortLinksToday,

                'anonymousQrCodesToday' =>
                    $anonymousQrCodesToday,

                'totalAnonymousToday' =>
                    $totalAnonymousToday,


                /*
                | Anonymous week statistics
                */
                'anonymousShortLinksThisWeek' =>
                    $anonymousShortLinksThisWeek,

                'anonymousQrCodesThisWeek' =>
                    $anonymousQrCodesThisWeek,

                'totalAnonymousThisWeek' =>
                    $totalAnonymousThisWeek,


                /*
                | Anonymous month statistics
                */
                'anonymousShortLinksThisMonth' =>
                    $anonymousShortLinksThisMonth,

                'anonymousQrCodesThisMonth' =>
                    $anonymousQrCodesThisMonth,

                'totalAnonymousThisMonth' =>
                    $totalAnonymousThisMonth,
            ]
        );
    }
}