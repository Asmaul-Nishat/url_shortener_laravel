<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    /**
     * Display the Admin Dashboard.
     */
    public function index(Request $request): View
    {
        /*
        |--------------------------------------------------------------------------
        | Total Users
        |--------------------------------------------------------------------------
        */

        $totalUsers = User::count();

        /*
        |--------------------------------------------------------------------------
        | Total Links
        |--------------------------------------------------------------------------
        */

        $totalLinks = ShortUrl::count();

        /*
        |--------------------------------------------------------------------------
        | Total Clicks
        |--------------------------------------------------------------------------
        */

        $totalClicks = ShortUrl::sum('click_count');

        /*
        |--------------------------------------------------------------------------
        | Active Links
        |--------------------------------------------------------------------------
        */

        $activeLinks = ShortUrl::where(function ($query) {
            $query->whereNull('expires_at')
                ->orWhere('expires_at', '>', now());
        })->count();

        /*
        |--------------------------------------------------------------------------
        | Expired Links
        |--------------------------------------------------------------------------
        */

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
        |
        | Admin can see links belonging to every user.
        |
        */

        $recentLinks = ShortUrl::with('user')
            ->latest()
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Admin Dashboard
        |--------------------------------------------------------------------------
        */

        return view('pages.admin.dashboard', [
            'totalUsers' => $totalUsers,
            'totalLinks' => $totalLinks,
            'totalClicks' => $totalClicks,
            'activeLinks' => $activeLinks,
            'expiredLinks' => $expiredLinks,
            'recentUsers' => $recentUsers,
            'recentLinks' => $recentLinks,
        ]);
    }
}