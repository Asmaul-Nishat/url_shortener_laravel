<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use App\Models\UrlClick;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AnalyticsController extends Controller
{
    public function index(Request $request): View
    {
        $userId = Auth::id();

        /*
        |--------------------------------------------------------------------------
        | Date Filter
        |--------------------------------------------------------------------------
        */

        $period = $request->get('period', '7');

        switch ($period) {
            case '30':
                $startDate = now()->subDays(29)->startOfDay();
                $periodLabel = 'Last 30 Days';
                break;

            case '90':
                $startDate = now()->subDays(89)->startOfDay();
                $periodLabel = 'Last 90 Days';
                break;

            case 'year':
                $startDate = now()->startOfYear();
                $periodLabel = 'This Year';
                break;

            default:
                $startDate = now()->subDays(6)->startOfDay();
                $period = '7';
                $periodLabel = 'Last 7 Days';
                break;
        }

        /*
        |--------------------------------------------------------------------------
        | User's Short URLs
        |--------------------------------------------------------------------------
        */

        $shortUrlIds = ShortUrl::where('user_id', $userId)
            ->pluck('id');

        /*
        |--------------------------------------------------------------------------
        | All Clicks
        |--------------------------------------------------------------------------
        */

        $allClicks = UrlClick::whereIn(
            'short_url_id',
            $shortUrlIds
        );

        /*
        |--------------------------------------------------------------------------
        | Overview Statistics
        |--------------------------------------------------------------------------
        */

        $totalClicks = (clone $allClicks)->count();

        $todayClicks = (clone $allClicks)
            ->whereDate('clicked_at', today())
            ->count();

        $yesterdayClicks = (clone $allClicks)
            ->whereDate(
                'clicked_at',
                now()->subDay()->toDateString()
            )
            ->count();

        $weekClicks = (clone $allClicks)
            ->whereBetween('clicked_at', [
                now()->startOfWeek(),
                now()->endOfWeek(),
            ])
            ->count();

        $monthClicks = (clone $allClicks)
            ->whereBetween('clicked_at', [
                now()->startOfMonth(),
                now()->endOfMonth(),
            ])
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Filtered Clicks
        |--------------------------------------------------------------------------
        */

        $filteredClicks = (clone $allClicks)
            ->where('clicked_at', '>=', $startDate)
            ->orderBy('clicked_at')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Daily Chart
        |--------------------------------------------------------------------------
        */

        $dailyLabels = [];
        $dailyData = [];

        $chartEnd = now()->endOfDay();

        $currentDate = $startDate->copy();

        while ($currentDate <= $chartEnd) {

            $date = $currentDate->toDateString();

            $dailyLabels[] = $currentDate->format('M d');

            $dailyData[] = $filteredClicks
                ->filter(function ($click) use ($date) {
                    return $click->clicked_at
                        && $click->clicked_at->toDateString() === $date;
                })
                ->count();

            $currentDate->addDay();
        }

        /*
        |--------------------------------------------------------------------------
        | Weekly Chart
        |--------------------------------------------------------------------------
        */

        $weeklyData = [];

        foreach ($filteredClicks->groupBy(function ($click) {
            return $click->clicked_at
                ? $click->clicked_at->startOfWeek()->format('Y-m-d')
                : null;
        }) as $week => $clicks) {

            if ($week) {
                $weeklyData[] = [
                    'label' => now()
                        ->parse($week)
                        ->format('M d'),
                    'count' => $clicks->count(),
                ];
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Monthly Chart
        |--------------------------------------------------------------------------
        */

        $monthlyData = [];

        foreach ($filteredClicks->groupBy(function ($click) {
            return $click->clicked_at
                ? $click->clicked_at->format('Y-m')
                : null;
        }) as $month => $clicks) {

            if ($month) {
                $monthlyData[] = [
                    'label' => now()
                        ->parse($month . '-01')
                        ->format('M Y'),
                    'count' => $clicks->count(),
                ];
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Device Analytics
        |--------------------------------------------------------------------------
        */

        $devices = [
            'Mobile' => 0,
            'Desktop' => 0,
            'Tablet' => 0,
            'Other' => 0,
        ];

        foreach ($filteredClicks as $click) {

            $userAgent = strtolower(
                $click->user_agent ?? ''
            );

            if (
                str_contains($userAgent, 'ipad') ||
                str_contains($userAgent, 'tablet') ||
                (
                    str_contains($userAgent, 'android') &&
                    !str_contains($userAgent, 'mobile')
                )
            ) {
                $devices['Tablet']++;
            } elseif (
                str_contains($userAgent, 'mobile') ||
                str_contains($userAgent, 'iphone') ||
                str_contains($userAgent, 'android')
            ) {
                $devices['Mobile']++;
            } elseif (
                str_contains($userAgent, 'windows') ||
                str_contains($userAgent, 'macintosh') ||
                str_contains($userAgent, 'linux') ||
                str_contains($userAgent, 'x11')
            ) {
                $devices['Desktop']++;
            } else {
                $devices['Other']++;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Browser Analytics
        |--------------------------------------------------------------------------
        */

        $browsers = [
            'Chrome' => 0,
            'Safari' => 0,
            'Firefox' => 0,
            'Edge' => 0,
            'Opera' => 0,
            'Other' => 0,
        ];

        foreach ($filteredClicks as $click) {

            $userAgent = strtolower(
                $click->user_agent ?? ''
            );

            if (str_contains($userAgent, 'edg/')) {
                $browsers['Edge']++;
            } elseif (
                str_contains($userAgent, 'opr/') ||
                str_contains($userAgent, 'opera')
            ) {
                $browsers['Opera']++;
            } elseif (str_contains($userAgent, 'firefox')) {
                $browsers['Firefox']++;
            } elseif (
                str_contains($userAgent, 'chrome') &&
                !str_contains($userAgent, 'edg/')
            ) {
                $browsers['Chrome']++;
            } elseif (
                str_contains($userAgent, 'safari') &&
                !str_contains($userAgent, 'chrome')
            ) {
                $browsers['Safari']++;
            } else {
                $browsers['Other']++;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Operating System Analytics
        |--------------------------------------------------------------------------
        */

        $operatingSystems = [
            'Windows' => 0,
            'macOS' => 0,
            'Android' => 0,
            'iOS' => 0,
            'Linux' => 0,
            'Other' => 0,
        ];

        foreach ($filteredClicks as $click) {

            $userAgent = strtolower(
                $click->user_agent ?? ''
            );

            if (str_contains($userAgent, 'windows')) {
                $operatingSystems['Windows']++;
            } elseif (
                str_contains($userAgent, 'iphone') ||
                str_contains($userAgent, 'ipad') ||
                str_contains($userAgent, 'ios')
            ) {
                $operatingSystems['iOS']++;
            } elseif (str_contains($userAgent, 'android')) {
                $operatingSystems['Android']++;
            } elseif (
                str_contains($userAgent, 'macintosh') ||
                str_contains($userAgent, 'mac os')
            ) {
                $operatingSystems['macOS']++;
            } elseif (str_contains($userAgent, 'linux')) {
                $operatingSystems['Linux']++;
            } else {
                $operatingSystems['Other']++;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Referrer Analytics
        |--------------------------------------------------------------------------
        */

        $referrers = $filteredClicks
            ->map(function ($click) {

                if (!$click->referer) {
                    return 'Direct';
                }

                $host = parse_url(
                    $click->referer,
                    PHP_URL_HOST
                );

                return $host ?: 'Direct';
            })
            ->countBy()
            ->sortDesc()
            ->take(10);

        /*
        |--------------------------------------------------------------------------
        | Top Performing Links
        |--------------------------------------------------------------------------
        */

        $topLinks = ShortUrl::where(
            'user_id',
            $userId
        )
        ->orderByDesc('click_count')
        ->take(10)
        ->get();

        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

        return view('pages.analytics.index', [
            'totalClicks' => $totalClicks,
            'todayClicks' => $todayClicks,
            'yesterdayClicks' => $yesterdayClicks,
            'weekClicks' => $weekClicks,
            'monthClicks' => $monthClicks,

            'period' => $period,
            'periodLabel' => $periodLabel,

            'dailyLabels' => $dailyLabels,
            'dailyData' => $dailyData,

            'weeklyData' => $weeklyData,
            'monthlyData' => $monthlyData,

            'devices' => $devices,
            'browsers' => $browsers,
            'operatingSystems' => $operatingSystems,

            'referrers' => $referrers,

            'topLinks' => $topLinks,
        ]);
    }
}