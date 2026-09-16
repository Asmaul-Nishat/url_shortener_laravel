<!DOCTYPE html>

<html>
<head>
    <meta charset="UTF-8">

<title>{{ $report_name }}</title>

<style>
    @page {
        size: A4 landscape;
        margin: 12px 12px 14px 12px;
    }

    * {
        box-sizing: border-box;
    }

    html,
    body {
        margin: 0;
        padding: 0;
    }

    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 7px;
        color: #333333;
        background: #ffffff;
    }

    /*
    |--------------------------------------------------------------------------
    | Report Title
    |--------------------------------------------------------------------------
    */

    .report-title {
        margin: 5px 3px 6px 3px;
        font-size: 17px;
        font-weight: bold;
        line-height: 1.2;
    }

    /*
    |--------------------------------------------------------------------------
    | Report Meta Information
    |--------------------------------------------------------------------------
    */

    .meta {
        margin: 0 0 6px 0;
    }

    .meta-table {
        width: 98%;
        margin: 5px auto;
        border-collapse: collapse;
        table-layout: fixed;
    }

    .meta-table td {
        border: none;
        padding: 2px 0;
        font-size: 7px;
        line-height: 1.3;
        vertical-align: top;
    }

    .meta-left {
        width: 50%;
    }

    .meta-right {
        width: 50%;
    }

    .meta-label {
        font-weight: bold;
    }

    /*
    |--------------------------------------------------------------------------
    | Section Title
    |--------------------------------------------------------------------------
    */

    .section-title {
        width: 98%;
        margin: 6px auto 5px auto;
        font-size: 10px;
        font-weight: bold;
        line-height: 1.2;
    }

    /*
    |--------------------------------------------------------------------------
    | Main Analytics Table
    |--------------------------------------------------------------------------
    */

    .analytics-table {
        width: 98%;
        margin: 5px auto;
        border-collapse: collapse;
        table-layout: fixed;
    }

    .analytics-table thead {
        display: table-header-group;
    }

    .analytics-table tr {
        page-break-inside: avoid;
    }

    /*
    |--------------------------------------------------------------------------
    | Table Cells
    |--------------------------------------------------------------------------
    */

    .analytics-table th,
    .analytics-table td {
        border: 1px solid #cfcfcf;
        padding: 3px 4px;
        vertical-align: top;
    }

    /*
    |--------------------------------------------------------------------------
    | Table Header
    |--------------------------------------------------------------------------
    */

    .analytics-table th {
        background: #f1f3f5;
        color: #222222;
        font-size: 6.7px;
        font-weight: bold;
        text-align: left;

        /*
         * Keep every header on one line.
         */
        white-space: nowrap;
        word-break: keep-all;
        overflow: hidden;
    }

    /*
    |--------------------------------------------------------------------------
    | Table Body
    |--------------------------------------------------------------------------
    */

    .analytics-table td {
        font-size: 6.4px;
        line-height: 1.25;
        text-align: left;
    }

    /*
    |--------------------------------------------------------------------------
    | Column Widths
    |--------------------------------------------------------------------------
    |
    | Total = 100%
    |
    */

    .analytics-table th:nth-child(1),
    .analytics-table td:nth-child(1) {
        width: 12%;
    }

    .analytics-table th:nth-child(2),
    .analytics-table td:nth-child(2) {
        width: 25%;
    }

    .analytics-table th:nth-child(3),
    .analytics-table td:nth-child(3) {
        width: 7%;
    }

    .analytics-table th:nth-child(4),
    .analytics-table td:nth-child(4) {
        width: 9%;
    }

    .analytics-table th:nth-child(5),
    .analytics-table td:nth-child(5) {
        width: 23%;
    }

    .analytics-table th:nth-child(6),
    .analytics-table td:nth-child(6) {
        width: 10%;
    }

    .analytics-table th:nth-child(7),
    .analytics-table td:nth-child(7) {
        width: 14%;
    }

    /*
    |--------------------------------------------------------------------------
    | Short URL
    |--------------------------------------------------------------------------
    */

    .short-url {
        font-family: DejaVu Sans, sans-serif;
        font-size: 6.4px;
        line-height: 1.2;

        /*
         * Short URL stays on one line.
         */
        white-space: nowrap;
        word-break: keep-all;
        overflow: hidden;
    }

    /*
    |--------------------------------------------------------------------------
    | Original URL
    |--------------------------------------------------------------------------
    */

    .original-url {
        font-size: 6.3px;
        line-height: 1.25;

        /*
         * Long URLs are allowed to wrap.
         */
        white-space: normal;
        word-break: break-all;
        overflow-wrap: anywhere;
    }

    /*
    |--------------------------------------------------------------------------
    | Total Clicks
    |--------------------------------------------------------------------------
    */

    .total-clicks {
        text-align: center;
        font-size: 7px;
        font-weight: bold;
        white-space: nowrap;
    }

    /*
    |--------------------------------------------------------------------------
    | IP Address
    |--------------------------------------------------------------------------
    */

    .ip-address {
        font-family: DejaVu Sans Mono, monospace;
        font-size: 6.2px;
        line-height: 1.2;

        /*
         * Keep IP address on one line.
         */
        white-space: nowrap;
        word-break: keep-all;
    }

    /*
    |--------------------------------------------------------------------------
    | User Agent
    |--------------------------------------------------------------------------
    */

    .user-agent {
        font-size: 5.8px;
        line-height: 1.2;

        /*
         * User Agent can wrap because it is usually very long.
         */
        white-space: normal;
        word-break: break-word;
        overflow-wrap: break-word;
    }

    /*
    |--------------------------------------------------------------------------
    | Referer
    |--------------------------------------------------------------------------
    */

    .referer {
        font-size: 5.8px;
        line-height: 1.2;

        white-space: normal;
        word-break: break-all;
        overflow-wrap: break-word;
    }

    /*
    |--------------------------------------------------------------------------
    | Clicked At
    |--------------------------------------------------------------------------
    */

    .clicked-at {
        font-family: DejaVu Sans Mono, monospace;
        font-size: 5.9px;
        line-height: 1.2;

        /*
         * Keep the complete date and time together.
         */
        white-space: nowrap;
        word-break: keep-all;
        overflow: hidden;
    }

    /*
    |--------------------------------------------------------------------------
    | Empty State
    |--------------------------------------------------------------------------
    */

    .empty {
        text-align: center !important;
        padding: 10px !important;
        font-size: 7px !important;
    }

    /*
    |--------------------------------------------------------------------------
    | Alternate Rows
    |--------------------------------------------------------------------------
    */

    .row-alt {
        background: #fafafa;
    }

    /*
    |--------------------------------------------------------------------------
    | Summary
    |--------------------------------------------------------------------------
    */

    .summary {
        margin-top: 6px;
        font-size: 7px;
    }
</style>


</head>

<body>


{{-- Report Title --}}

<h1 class="report-title">
    Click Analytics Report
</h1>


{{-- Report Information --}}

<div class="meta">

    <table class="meta-table">

        <tr>

            <td class="meta-left">
                <span class="meta-label">
                    Report Type:
                </span>

                {{ $report_type }}
            </td>

            <td class="meta-right">
                <span class="meta-label">
                    Total Clicks:
                </span>

                {{ $total_clicks }}
            </td>

        </tr>


        <tr>

            <td class="meta-left">
                <span class="meta-label">
                    Date Range:
                </span>

                {{ $date_range }}
            </td>

            <td class="meta-right">
                <span class="meta-label">
                    Period:
                </span>

                {{ $start_date->format('M d, Y') }}
                -
                {{ $end_date->format('M d, Y') }}
            </td>

        </tr>


        <tr>

            <td class="meta-left">
                <span class="meta-label">
                    User:
                </span>

                {{ $selected_user?->name ?? 'All Users' }}
            </td>

            <td class="meta-right">
                <span class="meta-label">
                    Short Link:
                </span>

                {{ $short_url?->short_url ?? 'All Short Links' }}
            </td>

        </tr>

    </table>

</div>


{{-- Click Details --}}

<div class="section-title">
    Click Details
</div>


{{-- Analytics Table --}}

<table class="analytics-table">

    <thead>

        <tr>

            <th>
                Short URL
            </th>

            <th>
                Original URL
            </th>

            <th>
                Total Clicks
            </th>

            <th>
                IP Address
            </th>

            <th>
                User Agent
            </th>

            <th>
                Referer
            </th>

            <th>
                Clicked At
            </th>

        </tr>

    </thead>


    <tbody>

        @forelse($clicks as $index => $click)

            @php

                /*
                |--------------------------------------------------------------------------
                | Short URL
                |--------------------------------------------------------------------------
                */

                $shortUrlValue =
                    $click->shortUrl?->short_url
                    ?? '—';


                /*
                |--------------------------------------------------------------------------
                | Original URL
                |--------------------------------------------------------------------------
                */

                $originalUrl =
                    $click->shortUrl?->original_url
                    ?? '—';


                /*
                |--------------------------------------------------------------------------
                | Original URL Display
                |--------------------------------------------------------------------------
                |
                | Very long URLs are shortened for PDF display.
                | The database value is NOT changed.
                |
                */

                $displayOriginalUrl =
                    $originalUrl;

                if (
                    strlen($displayOriginalUrl) > 220
                ) {

                    $questionPosition =
                        strpos(
                            $displayOriginalUrl,
                            '?'
                        );

                    if (
                        $questionPosition !== false
                    ) {

                        $displayOriginalUrl =
                            substr(
                                $displayOriginalUrl,
                                0,
                                $questionPosition
                            ) .
                            '?...';

                    } else {

                        $displayOriginalUrl =
                            substr(
                                $displayOriginalUrl,
                                0,
                                220
                            ) .
                            '...';
                    }
                }


                /*
                |--------------------------------------------------------------------------
                | Total Clicks For This Short URL
                |--------------------------------------------------------------------------
                */

                $rowTotalClicks = 0;

                if ($click->shortUrl) {

                    $rowTotalClicks =
                        $click->shortUrl
                            ->clicks()
                            ->count();
                }


                /*
                |--------------------------------------------------------------------------
                | IP Address
                |--------------------------------------------------------------------------
                */

                $ipAddress =
                    $click->ip_address
                    ?? '—';


                /*
                |--------------------------------------------------------------------------
                | User Agent
                |--------------------------------------------------------------------------
                */

                $userAgent =
                    $click->user_agent
                    ?? '—';

                if (
                    strlen($userAgent) > 160
                ) {

                    $userAgent =
                        substr(
                            $userAgent,
                            0,
                            160
                        ) .
                        '...';
                }


                /*
                |--------------------------------------------------------------------------
                | Referer
                |--------------------------------------------------------------------------
                */

                $referer =
                    $click->referer
                    ?? '—';

                if (
                    strlen($referer) > 80
                ) {

                    $referer =
                        substr(
                            $referer,
                            0,
                            80
                        ) .
                        '...';
                }


                /*
                |--------------------------------------------------------------------------
                | Clicked At
                |--------------------------------------------------------------------------
                */

                $clickedAt =
                    $click->clicked_at
                    ? $click->clicked_at
                        ->format(
                            'Y-m-d H:i:s'
                        )
                    : '—';

            @endphp


            <tr
                class="{{ $index % 2 === 1 ? 'row-alt' : '' }}"
            >

                {{-- Short URL --}}

                <td>
                    <div class="short-url">
                        {{ $shortUrlValue }}
                    </div>
                </td>


                {{-- Original URL --}}

                <td>
                    <div class="original-url">
                        {{ $displayOriginalUrl }}
                    </div>
                </td>


                {{-- Total Clicks --}}

                <td>
                    <div class="total-clicks">
                        {{ $rowTotalClicks }}
                    </div>
                </td>


                {{-- IP Address --}}

                <td>
                    <div class="ip-address">
                        {{ $ipAddress }}
                    </div>
                </td>


                {{-- User Agent --}}

                <td>
                    <div class="user-agent">
                        {{ $userAgent }}
                    </div>
                </td>


                {{-- Referer --}}

                <td>
                    <div class="referer">
                        {{ $referer }}
                    </div>
                </td>


                {{-- Clicked At --}}

                <td>
                    <div class="clicked-at">
                        {{ $clickedAt }}
                    </div>
                </td>

            </tr>


        @empty

            <tr>

                <td
                    colspan="7"
                    class="empty"
                >
                    No click data found for this period.
                </td>

            </tr>

        @endforelse

    </tbody>

</table>

</body>
</html>
