<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\ShortUrl;
use App\Models\UrlClick;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminReportController extends Controller
{
    /**
     * Display the admin reports page.
     */
    public function index(Request $request): View
    {
        $reportType = $request->input(
            'report_type',
            'click_analytics'
        );

        $dateRange = $request->input(
            'date_range',
            'Last 7 Days'
        );

        $userId = $request->input('user_id');

        $shortUrlId = $request->input(
            'short_url_id'
        );

        /*
        |--------------------------------------------------------------------------
        | Date Range
        |--------------------------------------------------------------------------
        */

        [$startDate, $endDate] = $this->getDateRange(
            $dateRange
        );

        /*
        |--------------------------------------------------------------------------
        | Users
        |--------------------------------------------------------------------------
        */

        $users = User::orderBy('name')->get();

        /*
        |--------------------------------------------------------------------------
        | Short URLs
        |--------------------------------------------------------------------------
        |
        | Load all links because the Blade dropdown filters them
        | dynamically according to the selected user.
        |
        */

        $shortUrls = ShortUrl::with('user')
            ->orderByDesc('id')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Validate Selected Short URL
        |--------------------------------------------------------------------------
        |
        | If a user is selected, the selected short URL must belong
        | to that user.
        |
        */

        if ($userId && $shortUrlId) {
            $shortUrlBelongsToUser = ShortUrl::where(
                'id',
                $shortUrlId
            )
                ->where(
                    'user_id',
                    $userId
                )
                ->exists();

            if (!$shortUrlBelongsToUser) {
                $shortUrlId = null;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Click Query
        |--------------------------------------------------------------------------
        */

        $clickQuery = UrlClick::with(
            'shortUrl.user'
        )->whereBetween(
            'clicked_at',
            [
                $startDate->copy()->startOfDay(),
                $endDate->copy()->endOfDay(),
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | User Filter
        |--------------------------------------------------------------------------
        */

        if ($userId) {
            $clickQuery->whereHas(
                'shortUrl',
                function ($query) use ($userId) {
                    $query->where(
                        'user_id',
                        $userId
                    );
                }
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Short URL Filter
        |--------------------------------------------------------------------------
        */

        if ($shortUrlId) {
            $clickQuery->where(
                'short_url_id',
                $shortUrlId
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Total Clicks
        |--------------------------------------------------------------------------
        */

        $totalClicks = (clone $clickQuery)->count();

        /*
        |--------------------------------------------------------------------------
        | Show All
        |--------------------------------------------------------------------------
        */

        $showAll = $request->boolean(
            'show_all'
        );

        if ($showAll) {
            $clicks = $clickQuery
                ->latest('clicked_at')
                ->get();
        } else {
            $clicks = $clickQuery
                ->latest('clicked_at')
                ->limit(10)
                ->get();
        }

        /*
        |--------------------------------------------------------------------------
        | Generated Reports
        |--------------------------------------------------------------------------
        */

        $reports = Report::with([
            'user',
            'shortUrl',
        ])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        $totalReports = Report::count();

        $totalGeneratedClicks = Report::sum(
            'total_clicks'
        );

        $pdfReports = Report::where(
            'format',
            'PDF'
        )->count();

        $csvReports = Report::where(
            'format',
            'CSV'
        )->count();

        /*
        |--------------------------------------------------------------------------
        | Newly Generated Report
        |--------------------------------------------------------------------------
        */

        $generatedReportId = session(
            'generated_report_id'
        );

        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

        return view(
            'pages.admin.reports.index',
            compact(
                'reportType',
                'dateRange',
                'userId',
                'shortUrlId',
                'startDate',
                'endDate',
                'users',
                'shortUrls',
                'clicks',
                'totalClicks',
                'showAll',
                'reports',
                'totalReports',
                'totalGeneratedClicks',
                'pdfReports',
                'csvReports',
                'generatedReportId'
            )
        );
    }

    /**
     * Generate a report.
     */
    public function generate(
        Request $request
    ): RedirectResponse {
        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'report_type' => [
                'required',
                'string',
                'in:click_analytics',
            ],

            'date_range' => [
                'required',
                'string',
                'in:Today,Yesterday,Last 7 Days,Last 30 Days,Last 90 Days,This Month,Last Month,This Year',
            ],

            'user_id' => [
                'nullable',
                'exists:users,id',
            ],

            'short_url_id' => [
                'nullable',
                'exists:short_urls,id',
            ],

            'format' => [
                'required',
                'string',
                'in:PDF,CSV',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Verify User + Short Link Relationship
        |--------------------------------------------------------------------------
        */

        if (
            !empty($validated['user_id']) &&
            !empty($validated['short_url_id'])
        ) {
            $shortUrlBelongsToUser = ShortUrl::where(
                'id',
                $validated['short_url_id']
            )
                ->where(
                    'user_id',
                    $validated['user_id']
                )
                ->exists();

            if (!$shortUrlBelongsToUser) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'short_url_id' =>
                            'The selected short link does not belong to the selected user.',
                    ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Date Range
        |--------------------------------------------------------------------------
        */

        [$startDate, $endDate] = $this->getDateRange(
            $validated['date_range']
        );

        /*
        |--------------------------------------------------------------------------
        | Click Query
        |--------------------------------------------------------------------------
        */

        $clickQuery = UrlClick::with(
            'shortUrl.user'
        )->whereBetween(
            'clicked_at',
            [
                $startDate->copy()->startOfDay(),
                $endDate->copy()->endOfDay(),
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | User Filter
        |--------------------------------------------------------------------------
        */

        if (!empty($validated['user_id'])) {
            $clickQuery->whereHas(
                'shortUrl',
                function ($query) use ($validated) {
                    $query->where(
                        'user_id',
                        $validated['user_id']
                    );
                }
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Short URL Filter
        |--------------------------------------------------------------------------
        */

        if (!empty($validated['short_url_id'])) {
            $clickQuery->where(
                'short_url_id',
                $validated['short_url_id']
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Get Clicks
        |--------------------------------------------------------------------------
        */

        $clicks = $clickQuery
            ->latest('clicked_at')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Selected User
        |--------------------------------------------------------------------------
        */

        $selectedUser = !empty(
            $validated['user_id']
        )
            ? User::find(
                $validated['user_id']
            )
            : null;

        /*
        |--------------------------------------------------------------------------
        | Selected Short URL
        |--------------------------------------------------------------------------
        */

        $selectedShortUrl = !empty(
            $validated['short_url_id']
        )
            ? ShortUrl::with('user')
                ->find(
                    $validated['short_url_id']
                )
            : null;

        /*
        |--------------------------------------------------------------------------
        | Report Name
        |--------------------------------------------------------------------------
        */

        $reportName =
            'Click Analytics Report - ' .
            now()->format('Y-m-d H:i:s');

        /*
        |--------------------------------------------------------------------------
        | File Name
        |--------------------------------------------------------------------------
        */

        $extension = strtolower(
            $validated['format']
        );

        $fileName =
            'click_analytics_' .
            now()->format('Y_m_d_H_i_s') .
            '_' .
            uniqid() .
            '.' .
            $extension;

        $filePath =
            'reports/' .
            $fileName;

        /*
        |--------------------------------------------------------------------------
        | Generate File
        |--------------------------------------------------------------------------
        */

        if ($validated['format'] === 'CSV') {
            $csvContent = $this->createCsv(
                $clicks
            );

            Storage::disk('local')->put(
                $filePath,
                $csvContent
            );
        } else {
            /*
            |--------------------------------------------------------------------------
            | Generate REAL PDF using Blade PDF view
            |--------------------------------------------------------------------------
            */

            $pdf = Pdf::loadView(
                'pages.admin.reports.pdf',
                [
                    'report_name' =>
                        $reportName,

                    'report_type' =>
                        $validated['report_type'],

                    'date_range' =>
                        $validated['date_range'],

                    'start_date' =>
                        $startDate,

                    'end_date' =>
                        $endDate,

                    'selected_user' =>
                        $selectedUser,

                    'short_url' =>
                        $selectedShortUrl,

                    'total_clicks' =>
                        $clicks->count(),

                    'clicks' =>
                        $clicks,
                ]
            );

            /*
            |--------------------------------------------------------------------------
            | Landscape A4
            |--------------------------------------------------------------------------
            */

            $pdf->setPaper(
                'a4',
                'landscape'
            );

            Storage::disk('local')->put(
                $filePath,
                $pdf->output()
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Save Report Database Record
        |--------------------------------------------------------------------------
        */

        $report = Report::create([
            'user_id' =>
                $selectedUser?->id
                ?? Auth::id(),

            'short_url_id' =>
                $selectedShortUrl?->id,

            'name' =>
                $reportName,

            'type' =>
                $validated['report_type'],

            'date_range' =>
                $validated['date_range'],

            'start_date' =>
                $startDate->toDateString(),

            'end_date' =>
                $endDate->toDateString(),

            'format' =>
                $validated['format'],

            'file_path' =>
                $filePath,

            'total_clicks' =>
                $clicks->count(),
        ]);

        /*
        |--------------------------------------------------------------------------
        | Redirect Back to Reports
        |--------------------------------------------------------------------------
        */

        return redirect()->route(
            'admin.reports',
            array_filter([
                'report_type' =>
                    $validated['report_type'],

                'date_range' =>
                    $validated['date_range'],

                'user_id' =>
                    $validated['user_id']
                    ?? null,

                'short_url_id' =>
                    $validated['short_url_id']
                    ?? null,

                'show_all' =>
                    1,
            ])
        )
            ->with(
                'success',
                $validated['format'] .
                ' Click Analytics report generated successfully.'
            )
            ->with(
                'generated_report_id',
                $report->id
            );
    }

    /**
     * Download filtered report.
     */
    public function downloadFiltered(
        Request $request
    ) {
        $format = strtoupper(
            $request->input(
                'format',
                'PDF'
            )
        );

        $dateRange = $request->input(
            'date_range',
            'Last 7 Days'
        );

        $userId = $request->input(
            'user_id'
        );

        $shortUrlId = $request->input(
            'short_url_id'
        );

        /*
        |--------------------------------------------------------------------------
        | Verify User + Short URL Relationship
        |--------------------------------------------------------------------------
        */

        if ($userId && $shortUrlId) {
            $shortUrlBelongsToUser = ShortUrl::where(
                'id',
                $shortUrlId
            )
                ->where(
                    'user_id',
                    $userId
                )
                ->exists();

            if (!$shortUrlBelongsToUser) {
                $shortUrlId = null;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Date Range
        |--------------------------------------------------------------------------
        */

        [$startDate, $endDate] =
            $this->getDateRange(
                $dateRange
            );

        /*
        |--------------------------------------------------------------------------
        | Click Query
        |--------------------------------------------------------------------------
        */

        $clickQuery = UrlClick::with(
            'shortUrl.user'
        )->whereBetween(
            'clicked_at',
            [
                $startDate->copy()->startOfDay(),
                $endDate->copy()->endOfDay(),
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | User Filter
        |--------------------------------------------------------------------------
        */

        if ($userId) {
            $clickQuery->whereHas(
                'shortUrl',
                function ($query) use ($userId) {
                    $query->where(
                        'user_id',
                        $userId
                    );
                }
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Short URL Filter
        |--------------------------------------------------------------------------
        */

        if ($shortUrlId) {
            $clickQuery->where(
                'short_url_id',
                $shortUrlId
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Get Clicks
        |--------------------------------------------------------------------------
        */

        $clicks = $clickQuery
            ->latest('clicked_at')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | CSV Download
        |--------------------------------------------------------------------------
        */

        if ($format === 'CSV') {
            $fileName =
                'click-details-' .
                now()->format(
                    'Y-m-d-H-i-s'
                ) .
                '.csv';

            return response()->streamDownload(
                function () use ($clicks) {
                    echo $this->createCsv(
                        $clicks
                    );
                },
                $fileName,
                [
                    'Content-Type' =>
                        'text/csv; charset=UTF-8',
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Selected User
        |--------------------------------------------------------------------------
        */

        $selectedUser = $userId
            ? User::find($userId)
            : null;

        /*
        |--------------------------------------------------------------------------
        | Selected Short URL
        |--------------------------------------------------------------------------
        */

        $selectedShortUrl = $shortUrlId
            ? ShortUrl::with('user')
                ->find($shortUrlId)
            : null;

        /*
        |--------------------------------------------------------------------------
        | Generate REAL PDF
        |--------------------------------------------------------------------------
        */

        $pdf = Pdf::loadView(
            'pages.admin.reports.pdf',
            [
                'report_name' =>
                    'Click Analytics Report',

                'report_type' =>
                    'click_analytics',

                'date_range' =>
                    $dateRange,

                'start_date' =>
                    $startDate,

                'end_date' =>
                    $endDate,

                'selected_user' =>
                    $selectedUser,

                'short_url' =>
                    $selectedShortUrl,

                'total_clicks' =>
                    $clicks->count(),

                'clicks' =>
                    $clicks,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Landscape A4
        |--------------------------------------------------------------------------
        */

        $pdf->setPaper(
            'a4',
            'landscape'
        );

        /*
        |--------------------------------------------------------------------------
        | Download PDF
        |--------------------------------------------------------------------------
        */

        $fileName =
            'click-details-' .
            now()->format(
                'Y-m-d-H-i-s'
            ) .
            '.pdf';

        return response(
            $pdf->output(),
            200,
            [
                'Content-Type' =>
                    'application/pdf',

                'Content-Disposition' =>
                    'attachment; filename="' .
                    $fileName .
                    '"',
            ]
        );
    }

    /**
     * Show all click details.
     */
    public function all(
        Request $request
    ): View {
        $request->merge([
            'show_all' => 1,
        ]);

        return $this->index(
            $request
        );
    }

    /**
     * Download saved report.
     */
    public function download(
        Report $report
    ) {
        if (
            !$report->file_path ||
            !Storage::disk('local')->exists(
                $report->file_path
            )
        ) {
            return back()->with(
                'error',
                'The report file could not be found.'
            );
        }

        $fullPath =
            Storage::disk('local')->path(
                $report->file_path
            );

        return response()->download(
            $fullPath,
            basename($fullPath)
        );
    }

    /**
     * Delete report.
     */
    public function destroy(
        Report $report
    ): RedirectResponse {
        if (
            $report->file_path &&
            Storage::disk('local')->exists(
                $report->file_path
            )
        ) {
            Storage::disk('local')->delete(
                $report->file_path
            );
        }

        $report->delete();

        return redirect()
            ->route('admin.reports')
            ->with(
                'success',
                'Report deleted successfully.'
            );
    }

    /**
     * Get report date range.
     */
    private function getDateRange(
        string $dateRange
    ): array {
        $now = now();

        switch ($dateRange) {
            case 'Today':

                $startDate =
                    $now->copy()
                        ->startOfDay();

                $endDate =
                    $now->copy()
                        ->endOfDay();

                break;

            case 'Yesterday':

                $startDate =
                    $now->copy()
                        ->subDay()
                        ->startOfDay();

                $endDate =
                    $now->copy()
                        ->subDay()
                        ->endOfDay();

                break;

            case 'Last 30 Days':

                $startDate =
                    $now->copy()
                        ->subDays(29)
                        ->startOfDay();

                $endDate =
                    $now->copy()
                        ->endOfDay();

                break;

            case 'Last 90 Days':

                $startDate =
                    $now->copy()
                        ->subDays(89)
                        ->startOfDay();

                $endDate =
                    $now->copy()
                        ->endOfDay();

                break;

            case 'This Month':

                $startDate =
                    $now->copy()
                        ->startOfMonth()
                        ->startOfDay();

                $endDate =
                    $now->copy()
                        ->endOfDay();

                break;

            case 'Last Month':

                $startDate =
                    $now->copy()
                        ->subMonth()
                        ->startOfMonth()
                        ->startOfDay();

                $endDate =
                    $now->copy()
                        ->subMonth()
                        ->endOfMonth()
                        ->endOfDay();

                break;

            case 'This Year':

                $startDate =
                    $now->copy()
                        ->startOfYear()
                        ->startOfDay();

                $endDate =
                    $now->copy()
                        ->endOfDay();

                break;

            case 'Last 7 Days':

            default:

                $startDate =
                    $now->copy()
                        ->subDays(6)
                        ->startOfDay();

                $endDate =
                    $now->copy()
                        ->endOfDay();

                break;
        }

        return [
            $startDate,
            $endDate,
        ];
    }

    /**
     * Create CSV.
     */
    private function createCsv(
        $clicks
    ): string {
        $handle = fopen(
            'php://temp',
            'r+'
        );

        /*
        |--------------------------------------------------------------------------
        | UTF-8 BOM
        |--------------------------------------------------------------------------
        */

        fwrite(
            $handle,
            "\xEF\xBB\xBF"
        );

        /*
        |--------------------------------------------------------------------------
        | Header
        |--------------------------------------------------------------------------
        */

        fputcsv(
            $handle,
            [
                'Short URL',
                'Original URL',
                'IP Address',
                'User Agent',
                'Referer',
                'Clicked At',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Rows
        |--------------------------------------------------------------------------
        */

        foreach ($clicks as $click) {
            $shortUrl =
                $click->shortUrl;

            $shortUrlValue = '';

            if ($shortUrl) {
                $shortUrlValue =
                    $shortUrl->short_url;
            }

            $originalUrl = '';

            if ($shortUrl) {
                $originalUrl =
                    $shortUrl->original_url;
            }

            fputcsv(
                $handle,
                [
                    $shortUrlValue,

                    $originalUrl,

                    $click->ip_address
                        ?? '',

                    $click->user_agent
                        ?? '',

                    $click->referer
                        ?? '',

                    $click->clicked_at
                        ? $click->clicked_at
                            ->format(
                                'Y-m-d H:i:s'
                            )
                        : '',
                ]
            );
        }

        rewind($handle);

        $content =
            stream_get_contents(
                $handle
            );

        fclose($handle);

        return $content;
    }
}