<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\ShortUrl;
use App\Models\SystemSetting;
use App\Models\UrlClick;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminReportController extends Controller
{
    /**
     * Display the admin report generation page.
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

        $shortUrlId = $request->input('short_url_id');

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
        */
        if ($userId) {
            $shortUrls = ShortUrl::with('user')
                ->where(
                    'user_id',
                    $userId
                )
                ->orderByDesc('id')
                ->get();
        } else {
            $shortUrls = ShortUrl::with('user')
                ->orderByDesc('id')
                ->get();
        }

        /*
        |--------------------------------------------------------------------------
        | Validate Selected Short URL
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
        | Clicks
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
        | Generated Report ID
        |--------------------------------------------------------------------------
        */
        $generatedReportId = session(
            'generated_report_id'
        );

        /*
        |--------------------------------------------------------------------------
        | Current Settings
        |--------------------------------------------------------------------------
        */
        $settings = SystemSetting::current();

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
                'generatedReportId',
                'settings'
            )
        );
    }

    /**
     * Generate and save a report.
     */
    public function generate(
        Request $request
    ): RedirectResponse {
        /*
        |--------------------------------------------------------------------------
        | Check Reports Setting
        |--------------------------------------------------------------------------
        */
        if (!SystemSetting::current()->enable_reports) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Report generation is currently disabled by the administrator.'
                );
        }

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
        | Validate User / Short URL Relationship
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
        | Generate CSV
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
            | Generate PDF
            |--------------------------------------------------------------------------
            */
            $pdf = $this->buildPdf(
                reportName: $reportName,
                reportType: $validated['report_type'],
                dateRange: $validated['date_range'],
                startDate: $startDate,
                endDate: $endDate,
                selectedUser: $selectedUser,
                selectedShortUrl: $selectedShortUrl,
                clicks: $clicks
            );

            /*
            |--------------------------------------------------------------------------
            | Store PDF
            |--------------------------------------------------------------------------
            */
            Storage::disk('local')->put(
                $filePath,
                $pdf->output()
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Save Report
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
        | Redirect
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
     * Download a filtered report directly.
     */
    public function downloadFiltered(
        Request $request
    ) {
        /*
        |--------------------------------------------------------------------------
        | Check Reports Setting
        |--------------------------------------------------------------------------
        */
        if (!SystemSetting::current()->enable_reports) {
            return back()->with(
                'error',
                'Report downloads are currently disabled by the administrator.'
            );
        }

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
        | Validate User / Short URL Relationship
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
        | CSV
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
        | Generate PDF
        |--------------------------------------------------------------------------
        */
        $pdf = $this->buildPdf(
            reportName: 'Click Analytics Report',
            reportType: 'click_analytics',
            dateRange: $dateRange,
            startDate: $startDate,
            endDate: $endDate,
            selectedUser: $selectedUser,
            selectedShortUrl: $selectedShortUrl,
            clicks: $clicks
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
        | Download
        |--------------------------------------------------------------------------
        */
        $fileName =
            'click-details-' .
            now()->format(
                'Y-m-d-H-i-s'
            ) .
            '.pdf';

        $pdfContent =
            $pdf->output();

        return response(
            $pdfContent,
            200,
            [
                'Content-Type' =>
                    'application/pdf',
                'Content-Disposition' =>
                    'attachment; filename="' .
                    $fileName .
                    '"',
                'Content-Length' =>
                    strlen($pdfContent),
                'Cache-Control' =>
                    'private, no-store, no-cache, must-revalidate',
                'Pragma' =>
                    'no-cache',
                'Expires' =>
                    '0',
            ]
        );
    }

    /**
     * Display all previously generated reports.
     */
    public function all(
        Request $request
    ): View {
        $reports = Report::with([
            'user',
            'shortUrl',
        ])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'pages.admin.reports.all',
            compact('reports')
        );
    }

    /**
     * Download a previously generated report.
     */
    public function download(
        Report $report
    ) {
        /*
        |--------------------------------------------------------------------------
        | Check Reports Setting
        |--------------------------------------------------------------------------
        */
        if (!SystemSetting::current()->enable_reports) {
            return back()->with(
                'error',
                'Report downloads are currently disabled by the administrator.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | CSV
        |--------------------------------------------------------------------------
        */
        if (
            strtoupper($report->format) === 'CSV'
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
                basename($fullPath),
                [
                    'Content-Type' =>
                        'text/csv; charset=UTF-8',
                    'Cache-Control' =>
                        'private, no-store, no-cache, must-revalidate',
                    'Pragma' =>
                        'no-cache',
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | PDF
        |--------------------------------------------------------------------------
        */
        if (
            strtoupper($report->format) === 'PDF'
        ) {
            /*
            |--------------------------------------------------------------------------
            | Report Dates
            |--------------------------------------------------------------------------
            */
            $startDate = $report->start_date
                ? now()->parse(
                    $report->start_date
                )
                : now()->startOfDay();

            $endDate = $report->end_date
                ? now()->parse(
                    $report->end_date
                )
                : now()->endOfDay();

            /*
            |--------------------------------------------------------------------------
            | Selected User
            |--------------------------------------------------------------------------
            */
            $selectedUser =
                $report->user;

            /*
            |--------------------------------------------------------------------------
            | Selected Short URL
            |--------------------------------------------------------------------------
            */
            $selectedShortUrl =
                $report->shortUrl;

            /*
            |--------------------------------------------------------------------------
            | Rebuild Click Query
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
            if ($selectedUser) {
                $clickQuery->whereHas(
                    'shortUrl',
                    function ($query) use ($selectedUser) {
                        $query->where(
                            'user_id',
                            $selectedUser->id
                        );
                    }
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Short URL Filter
            |--------------------------------------------------------------------------
            */
            if ($selectedShortUrl) {
                $clickQuery->where(
                    'short_url_id',
                    $selectedShortUrl->id
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Get Current Click Data
            |--------------------------------------------------------------------------
            */
            $clicks = $clickQuery
                ->latest('clicked_at')
                ->get();

            /*
            |--------------------------------------------------------------------------
            | Build PDF
            |--------------------------------------------------------------------------
            */
            $pdf = $this->buildPdf(
                reportName: $report->name,
                reportType: $report->type,
                dateRange: $report->date_range,
                startDate: $startDate,
                endDate: $endDate,
                selectedUser: $selectedUser,
                selectedShortUrl: $selectedShortUrl,
                clicks: $clicks
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
            | Generate Fresh PDF
            |--------------------------------------------------------------------------
            */
            $pdfContent =
                $pdf->output();

            /*
            |--------------------------------------------------------------------------
            | Download Fresh PDF
            |--------------------------------------------------------------------------
            */
            $fileName =
                pathinfo(
                    $report->file_path
                    ?? 'click_analytics_report.pdf',
                    PATHINFO_FILENAME
                ) .
                '.pdf';

            return response(
                $pdfContent,
                200,
                [
                    'Content-Type' =>
                        'application/pdf',
                    'Content-Disposition' =>
                        'attachment; filename="' .
                        $fileName .
                        '"',
                    'Content-Length' =>
                        strlen($pdfContent),
                    'Cache-Control' =>
                        'private, no-store, no-cache, must-revalidate',
                    'Pragma' =>
                        'no-cache',
                    'Expires' =>
                        '0',
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Unsupported Format
        |--------------------------------------------------------------------------
        */
        return back()->with(
            'error',
            'Unsupported report format.'
        );
    }

    /**
     * Delete a generated report.
     */
    public function destroy(
        Report $report
    ): RedirectResponse {
        /*
        |--------------------------------------------------------------------------
        | Delete Stored File
        |--------------------------------------------------------------------------
        */
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

        /*
        |--------------------------------------------------------------------------
        | Delete Database Record
        |--------------------------------------------------------------------------
        */
        $report->delete();

        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */
        return redirect()
            ->route(
                'admin.reports.all'
            )
            ->with(
                'success',
                'Report deleted successfully.'
            );
    }

    /**
     * Build a PDF using the current PDF Blade template.
     */
    private function buildPdf(
        string $reportName,
        string $reportType,
        string $dateRange,
        $startDate,
        $endDate,
        ?User $selectedUser,
        ?ShortUrl $selectedShortUrl,
        $clicks
    ) {
        return Pdf::loadView(
            'pages.admin.reports.pdf',
            [
                'report_name' =>
                    $reportName,
                'report_type' =>
                    $reportType,
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
                        ->endOfYear()
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
     * Create CSV content.
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

        /*
        |--------------------------------------------------------------------------
        | Return CSV
        |--------------------------------------------------------------------------
        */
        rewind($handle);

        $content =
            stream_get_contents(
                $handle
            );

        fclose($handle);

        return $content;
    }
}