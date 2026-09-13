<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        /*
        |--------------------------------------------------------------------------
        | User's Links
        |--------------------------------------------------------------------------
        */

        $links = $user->shortUrls();


        /*
        |--------------------------------------------------------------------------
        | Total Links
        |--------------------------------------------------------------------------
        */

        $totalLinks = $links->count();


        /*
        |--------------------------------------------------------------------------
        | Total Clicks
        |--------------------------------------------------------------------------
        */

        $totalClicks = $links->sum('click_count');


        /*
        |--------------------------------------------------------------------------
        | Active Links
        |--------------------------------------------------------------------------
        */

        $activeLinks = $user->shortUrls()
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->count();


        /*
        |--------------------------------------------------------------------------
        | Expired Links
        |--------------------------------------------------------------------------
        */

        $expiredLinks = $user->shortUrls()
            ->whereNotNull('expires_at')
            ->where('expires_at', '<=', now())
            ->count();


        /*
        |--------------------------------------------------------------------------
        | Recent Links
        |--------------------------------------------------------------------------
        */

        $recentLinks = $user->shortUrls()
            ->latest()
            ->take(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Click Analytics - Last 7 Days
        |--------------------------------------------------------------------------
        */

        $startDate = Carbon::now()
            ->subDays(6)
            ->startOfDay();

        $endDate = Carbon::now()
            ->endOfDay();


        /*
        |--------------------------------------------------------------------------
        | Get clicks for current user's links
        |--------------------------------------------------------------------------
        */

        $clicks = \App\Models\UrlClick::whereHas(
            'shortUrl',
            function ($query) use ($user) {
                $query->where('user_id', $user->id);
            }
        )
            ->whereBetween('clicked_at', [
                $startDate,
                $endDate
            ])
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Prepare chart data
        |--------------------------------------------------------------------------
        */

        $analyticsLabels = [];

        $analyticsData = [];


        for ($i = 6; $i >= 0; $i--) {

            $date = Carbon::now()
                ->subDays($i)
                ->startOfDay();


            $analyticsLabels[] = $date->format('M d');


            $analyticsData[] = $clicks
                ->filter(function ($click) use ($date) {

                    return Carbon::parse(
                        $click->clicked_at
                    )->isSameDay($date);

                })
                ->count();
        }


        /*
        |--------------------------------------------------------------------------
        | Send data to Dashboard
        |--------------------------------------------------------------------------
        */

        return view('pages.dashboard.index', [

            'totalLinks' => $totalLinks,

            'totalClicks' => $totalClicks,

            'activeLinks' => $activeLinks,

            'expiredLinks' => $expiredLinks,

            'recentLinks' => $recentLinks,

            'analyticsLabels' => $analyticsLabels,

            'analyticsData' => $analyticsData,

        ]);
    }
}