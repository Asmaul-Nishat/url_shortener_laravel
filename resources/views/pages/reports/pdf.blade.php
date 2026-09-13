<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <title>{{ $report_name }}</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }

        h1 {
            font-size: 22px;
            margin-bottom: 5px;
        }

        h2 {
            font-size: 16px;
            margin-top: 25px;
        }

        .meta {
            margin-bottom: 20px;
        }

        .meta p {
            margin: 4px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 7px;
            text-align: left;
            font-size: 9px;
        }

        th {
            background: #f3f4f6;
        }
    </style>
</head>

<body>

    <h1>{{ $report_name }}</h1>

    <div class="meta">

        <p>
            <strong>Type:</strong>
            {{ $report_type }}
        </p>

        <p>
            <strong>Date Range:</strong>
            {{ $date_range }}
        </p>

        <p>
            <strong>Period:</strong>
            {{ $start_date->format('M d, Y') }}
            -
            {{ $end_date->format('M d, Y') }}
        </p>

        <p>
            <strong>Total Clicks:</strong>
            {{ $total_clicks }}
        </p>

        <p>
            <strong>Short Link:</strong>
            {{ $short_url?->short_url ?? 'All Links' }}
        </p>

    </div>

    <h2>Click Details</h2>

    <table>

        <thead>
            <tr>
                <th>Short URL</th>
                <th>Original URL</th>
                <th>IP Address</th>
                <th>User Agent</th>
                <th>Referer</th>
                <th>Clicked At</th>
            </tr>
        </thead>

        <tbody>

            @forelse($clicks as $click)

                <tr>

                    <td>
                        {{ $click->shortUrl?->short_url }}
                    </td>

                    <td>
                        {{ $click->shortUrl?->original_url }}
                    </td>

                    <td>
                        {{ $click->ip_address }}
                    </td>

                    <td>
                        {{ $click->user_agent }}
                    </td>

                    <td>
                        {{ $click->referer }}
                    </td>

                    <td>
                        {{ $click->clicked_at }}
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="6">
                        No click data found for this period.
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>

</body>
</html>