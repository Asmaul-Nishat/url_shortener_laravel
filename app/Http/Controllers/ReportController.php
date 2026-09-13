<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\ShortUrl;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    /**
     * Display reports page.
     */
    public function index()
    {
        $userId = Auth::id();

        $shortUrls = ShortUrl::where('user_id', $userId)
            ->latest()
            ->get();

        $reports = Report::with('shortUrl')
            ->where('user_id', $userId)
            ->latest()
            ->paginate(10);

        $totalReports = Report::where('user_id', $userId)
            ->count();

        $thisMonth = Report::where('user_id', $userId)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $csvReports = Report::where('user_id', $userId)
            ->where('format', 'CSV')
            ->count();

        $pdfReports = Report::where('user_id', $userId)
            ->where('format', 'PDF')
            ->count();

        return view('pages.reports.index', compact(
            'shortUrls',
            'reports',
            'totalReports',
            'thisMonth',
            'csvReports',
            'pdfReports'
        ));
    }

    /**
     * Generate a report.
     */
    public function generate(Request $request)
    {
        $validated = $request->validate([
            'report_type' => [
                'required',
                'in:Link Performance,Click Analytics,Geographic Analytics,Device Analytics,Browser & OS Analytics',
            ],

            'date_range' => [
                'required',
                'in:Last 7 Days,Last 30 Days,Last 90 Days,This Year',
            ],

            'short_url_id' => [
                'nullable',
                'integer',
            ],

            'format' => [
                'required',
                'in:CSV,PDF',
            ],
        ]);

        $userId = Auth::id();

        /*
        |--------------------------------------------------------------------------
        | Check selected link
        |--------------------------------------------------------------------------
        */

        $shortUrl = null;

        if (!empty($validated['short_url_id'])) {
            $shortUrl = ShortUrl::where('id', $validated['short_url_id'])
                ->where('user_id', $userId)
                ->firstOrFail();
        }

        /*
        |--------------------------------------------------------------------------
        | Determine date range
        |--------------------------------------------------------------------------
        */

        switch ($validated['date_range']) {
            case 'Last 7 Days':
                $startDate = now()->subDays(6)->startOfDay();
                $endDate = now()->endOfDay();
                break;

            case 'Last 30 Days':
                $startDate = now()->subDays(29)->startOfDay();
                $endDate = now()->endOfDay();
                break;

            case 'Last 90 Days':
                $startDate = now()->subDays(89)->startOfDay();
                $endDate = now()->endOfDay();
                break;

            case 'This Year':
                $startDate = now()->startOfYear();
                $endDate = now()->endOfYear();
                break;

            default:
                abort(422);
        }

        /*
        |--------------------------------------------------------------------------
        | Get click data
        |--------------------------------------------------------------------------
        */

        $clickQuery = \App\Models\UrlClick::query()
            ->whereHas('shortUrl', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->whereBetween('clicked_at', [
                $startDate,
                $endDate,
            ]);

        if ($shortUrl) {
            $clickQuery->where(
                'short_url_id',
                $shortUrl->id
            );
        }

        $clicks = $clickQuery
            ->with('shortUrl')
            ->latest('clicked_at')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Report name
        |--------------------------------------------------------------------------
        */

        $reportName = $validated['report_type']
            . ' Report';

        if ($shortUrl) {
            $reportName .= ' - '
                . ($shortUrl->custom_alias
                    ?: $shortUrl->short_code);
        }

        /*
        |--------------------------------------------------------------------------
        | Build report data
        |--------------------------------------------------------------------------
        */

        $reportData = [
            'report_name' => $reportName,
            'report_type' => $validated['report_type'],
            'date_range' => $validated['date_range'],
            'start_date' => $startDate,
            'end_date' => $endDate,
            'short_url' => $shortUrl,
            'clicks' => $clicks,
            'total_clicks' => $clicks->count(),
        ];

        /*
        |--------------------------------------------------------------------------
        | Generate filename
        |--------------------------------------------------------------------------
        */

        $filename = 'reports/'
            . now()->format('Y/m/')
            . str($reportName)
                ->slug('_')
            . '_'
            . now()->format('Ymd_His')
            . '.'
            . strtolower($validated['format']);

        /*
        |--------------------------------------------------------------------------
        | CSV
        |--------------------------------------------------------------------------
        */

        if ($validated['format'] === 'CSV') {
            $csvContent = $this->createCsv(
                $reportData
            );

            Storage::disk('local')->put(
                $filename,
                $csvContent
            );
        }

        /*
        |--------------------------------------------------------------------------
        | PDF
        |--------------------------------------------------------------------------
        */

        if ($validated['format'] === 'PDF') {
            $pdf = Pdf::loadView(
                'pages.reports.pdf',
                $reportData
            );

            Storage::disk('local')->put(
                $filename,
                $pdf->output()
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Save report history
        |--------------------------------------------------------------------------
        */

        $report = Report::create([
            'user_id' => $userId,

            'short_url_id' => $shortUrl?->id,

            'name' => $reportName,

            'type' => $validated['report_type'],

            'date_range' => $validated['date_range'],

            'start_date' => $startDate->toDateString(),

            'end_date' => $endDate->toDateString(),

            'format' => $validated['format'],

            'file_path' => $filename,

            'total_clicks' => $clicks->count(),
        ]);

        return redirect()
            ->route('reports')
            ->with(
                'success',
                'Report generated successfully.'
            );
    }

    /**
     * Download report.
     */
    public function download(Report $report)
    {
        abort_unless(
            $report->user_id === Auth::id(),
            403
        );

        abort_unless(
            Storage::disk('local')->exists(
                $report->file_path
            ),
            404
        );

        return Storage::disk('local')->download(
            $report->file_path,
            basename($report->file_path)
        );
    }

    /**
     * Delete report.
     */
    public function destroy(Report $report)
    {
        abort_unless(
            $report->user_id === Auth::id(),
            403
        );

        if (
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
            ->route('reports')
            ->with(
                'success',
                'Report deleted successfully.'
            );
    }

    /**
     * Create CSV.
     */
    private function createCsv(array $reportData): string
    {
        $handle = fopen('php://temp', 'r+');

        fputcsv($handle, [
            'Report',
            'Type',
            'Date Range',
            'Short URL',
            'Original URL',
            'IP Address',
            'User Agent',
            'Referer',
            'Clicked At',
        ]);

        foreach ($reportData['clicks'] as $click) {
            fputcsv($handle, [
                $reportData['report_name'],
                $reportData['report_type'],
                $reportData['date_range'],

                $click->shortUrl
                    ? $click->shortUrl->short_url
                    : '',

                $click->shortUrl
                    ? $click->shortUrl->original_url
                    : '',

                $click->ip_address,
                $click->user_agent,
                $click->referer,
                $click->clicked_at,
            ]);
        }

        rewind($handle);

        $content = stream_get_contents($handle);

        fclose($handle);

        return $content;
    }
}