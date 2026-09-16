<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>
        {{ $report_name }}
    </title>

    <style>

        @page {
            size: A4 landscape;
            margin: 20px 18px 20px 18px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9px;
            color: #1f2937;
            margin: 0;
            padding: 0;
        }

        /*
        |--------------------------------------------------------------------------
        | Report Header
        |--------------------------------------------------------------------------
        */

        h1 {
            font-size: 18px;
            margin: 0 0 12px 0;
            color: #111827;
        }

        /*
        |--------------------------------------------------------------------------
        | Report Information
        |--------------------------------------------------------------------------
        */

        .meta {
            width: 100%;
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #d1d5db;
            background: #f9fafb;
        }

        .meta table {
            width: 100%;
            border-collapse: collapse;
        }

        .meta td {
            border: none;
            padding: 3px 5px;
            vertical-align: top;
            font-size: 9px;
        }

        .meta-label {
            width: 13%;
            font-weight: bold;
            color: #374151;
        }

        .meta-value {
            width: 37%;
            color: #111827;
        }

        /*
        |--------------------------------------------------------------------------
        | Click Details Table
        |--------------------------------------------------------------------------
        */

        .click-table {
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
            margin-top: 8px;
        }

        .click-table th,
        .click-table td {
            border: 1px solid #9ca3af;
            padding: 5px;
            vertical-align: top;
            text-align: left;
            font-size: 7.5px;

            /*
            | Important for long URLs / browser strings
            */

            word-wrap: break-word;
            overflow-wrap: break-word;
            word-break: break-word;
        }

        .click-table th {
            background: #e5e7eb;
            color: #111827;
            font-weight: bold;
            font-size: 8px;
        }

        /*
        |--------------------------------------------------------------------------
        | Column Widths
        |--------------------------------------------------------------------------
        |
        | Total = 100%
        |
        */

        .col-short-url {
            width: 12%;
        }

        .col-original-url {
            width: 25%;
        }

        .col-total-clicks {
            width: 8%;
            text-align: center !important;
        }

        .col-ip {
            width: 9%;
        }

        .col-user-agent {
            width: 23%;
        }

        .col-referer {
            width: 13%;
        }

        .col-clicked-at {
            width: 10%;
        }

        /*
        |--------------------------------------------------------------------------
        | Total Clicks Cell
        |--------------------------------------------------------------------------
        */

        .total-clicks-cell {
            text-align: center !important;
            font-weight: bold;
            white-space: nowrap;
        }

        /*
        |--------------------------------------------------------------------------
        | Empty State
        |--------------------------------------------------------------------------
        */

        .no-records {
            text-align: center !important;
            padding: 15px !important;
            font-size: 9px !important;
        }

        /*
        |--------------------------------------------------------------------------
        | URL Styling
        |--------------------------------------------------------------------------
        */

        .url {
            word-wrap: break-word;
            overflow-wrap: break-word;
            word-break: break-all;
        }

        /*
        |--------------------------------------------------------------------------
        | Footer
        |--------------------------------------------------------------------------
        */

        .footer {
            margin-top: 12px;
            font-size: 7px;
            color: #6b7280;
            text-align: right;
        }

    </style>

</head>

<body>

    {{-- =========================================================
         REPORT TITLE
    ========================================================== --}}

    <h1>
        {{ $report_name }}
    </h1>


    {{-- =========================================================
         REPORT INFORMATION
    ========================================================== --}}

    <div class="meta">

        <table>

            <tr>

                <td class="meta-label">
                    Report Type:
                </td>

                <td class="meta-value">
                    {{ $report_type }}
                </td>

                <td class="meta-label">
                    Total Clicks:
                </td>

                <td class="meta-value">
                    {{ number_format($total_clicks) }}
                </td>

            </tr>


            <tr>

                <td class="meta-label">
                    Date Range:
                </td>

                <td class="meta-value">
                    {{ $date_range }}
                </td>

                <td class="meta-label">
                    Period:
                </td>

                <td class="meta-value">
                    {{ $start_date->format('M d, Y') }}
                    -
                    {{ $end_date->format('M d, Y') }}
                </td>

            </tr>


            <tr>

                <td class="meta-label">
                    User:
                </td>

                <td class="meta-value">

                    {{ $selected_user?->name ?? 'All Users' }}

                    @if ($selected_user)
                        ({{ $selected_user->email }})
                    @endif

                </td>

                <td class="meta-label">
                    Short Link:
                </td>

                <td class="meta-value">

                    @if ($short_url)

                        {{ url(
                            $short_url->custom_alias
                                ?: $short_url->short_code
                        ) }}

                    @else

                        All Short Links

                    @endif

                </td>

            </tr>

        </table>

    </div>


    {{-- =========================================================
         CLICK DETAILS
    ========================================================== --}}

    <table class="click-table">

        <thead>

            <tr>

                <th class="col-short-url">
                    Short URL
                </th>

                <th class="col-original-url">
                    Original URL
                </th>

                <th class="col-total-clicks">
                    Total Clicks
                </th>

                <th class="col-ip">
                    IP Address
                </th>

                <th class="col-user-agent">
                    User Agent
                </th>

                <th class="col-referer">
                    Referer
                </th>

                <th class="col-clicked-at">
                    Clicked At
                </th>

            </tr>

        </thead>


        <tbody>

            @forelse ($clicks as $click)

                @php
                    $shortUrl = $click->shortUrl;

                    $shortUrlText = $shortUrl
                        ? url(
                            $shortUrl->custom_alias
                                ?: $shortUrl->short_code
                        )
                        : '-';

                    $originalUrl = $shortUrl
                        ? $shortUrl->original_url
                        : '-';

                    /*
                    |--------------------------------------------------------------------------
                    | Total clicks for this short URL
                    |--------------------------------------------------------------------------
                    */

                    $shortUrlTotalClicks = $shortUrl
                        ? $shortUrl->clicks()->count()
                        : 0;
                @endphp


                <tr>

                    {{-- Short URL --}}

                    <td class="url">

                        {{ $shortUrlText }}

                    </td>


                    {{-- Original URL --}}

                    <td class="url">

                        {{ $originalUrl }}

                    </td>


                    {{-- Total Clicks --}}

                    <td class="total-clicks-cell">

                        {{ number_format($shortUrlTotalClicks) }}

                    </td>


                    {{-- IP Address --}}

                    <td>

                        {{ $click->ip_address ?? '-' }}

                    </td>


                    {{-- User Agent --}}

                    <td>

                        {{ $click->user_agent ?? '-' }}

                    </td>


                    {{-- Referer --}}

                    <td class="url">

                        {{ $click->referer ?? '-' }}

                    </td>


                    {{-- Clicked At --}}

                    <td>

                        {{ $click->clicked_at
                            ? $click->clicked_at->format(
                                'Y-m-d H:i:s'
                            )
                            : '-'
                        }}

                    </td>

                </tr>

            @empty

                <tr>

                    <td
                        colspan="7"
                        class="no-records"
                    >

                        No click records found for the selected filters.

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>


    {{-- =========================================================
         FOOTER
    ========================================================== --}}

    <div class="footer">

        Generated on
        {{ now()->format('M d, Y H:i:s') }}

    </div>

</body>

</html>
