@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-7xl">

{{-- ============================================================
     SUCCESS MESSAGE
============================================================= --}}
@if (session('success'))
    <div class="mb-6 rounded-lg border border-gray-200 bg-white px-4 py-3 text-sm text-gray-700 dark:border-gray-800 dark:bg-white/[0.03] dark:text-gray-300">
        {{ session('success') }}
    </div>
@endif


{{-- ============================================================
     VALIDATION ERRORS
============================================================= --}}
@if ($errors->any())
    <div class="mb-6 rounded-lg border border-gray-200 bg-white px-4 py-3 dark:border-gray-800 dark:bg-white/[0.03]">

        <ul class="list-disc space-y-1 pl-5 text-sm text-gray-600 dark:text-gray-300">

            @foreach ($errors->all() as $error)
                <li>
                    {{ $error }}
                </li>
            @endforeach

        </ul>

    </div>
@endif


{{-- ============================================================
     PAGE HEADER
============================================================= --}}
<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

    <div>

        <h1 class="text-2xl font-bold text-gray-800 dark:text-white/90">
            Reports
        </h1>

        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Generate, export and manage performance reports for your short links.
        </p>

    </div>


    <a
        href="#report-generator"
        class="inline-flex h-11 items-center justify-center gap-2 rounded-lg bg-gray-800 px-5 text-sm font-medium text-white transition hover:bg-gray-700 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-200"
    >

        <svg
            class="h-5 w-5"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="1.8"
        >

            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M12 5v14m-7-7h14"
            />

        </svg>

        Generate Report

    </a>

</div>


{{-- ============================================================
     REPORT SUMMARY CARDS
============================================================= --}}
<div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">


    {{-- Total Reports --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    Total Reports
                </p>

                <h3 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">
                    {{ $totalReports }}
                </h3>

            </div>


            <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-gray-100 dark:bg-white/[0.06]">

                <svg
                    class="h-5 w-5 text-gray-600 dark:text-gray-300"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                >

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M7 3h8l4 4v14H7a2 2 0 01-2-2V5a2 2 0 012-2z"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15 3v5h5"
                    />

                </svg>

            </div>

        </div>

    </div>


    {{-- This Month --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    This Month
                </p>

                <h3 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">
                    {{ $thisMonth }}
                </h3>

            </div>


            <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-gray-100 dark:bg-white/[0.06]">

                <svg
                    class="h-5 w-5 text-gray-600 dark:text-gray-300"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                >

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M8 2v4m8-4v4M3 10h18"
                    />

                    <rect
                        x="3"
                        y="4"
                        width="18"
                        height="17"
                        rx="2"
                    />

                </svg>

            </div>

        </div>

    </div>


    {{-- CSV Reports --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    CSV Reports
                </p>

                <h3 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">
                    {{ $csvReports }}
                </h3>

            </div>


            <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-gray-100 dark:bg-white/[0.06]">

                <svg
                    class="h-5 w-5 text-gray-600 dark:text-gray-300"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                >

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M7 3h8l4 4v14H7a2 2 0 01-2-2V5a2 2 0 012-2z"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15 3v5h5"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M9 13h6M9 17h6"
                    />

                </svg>

            </div>

        </div>

    </div>


    {{-- PDF Reports --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    PDF Reports
                </p>

                <h3 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">
                    {{ $pdfReports }}
                </h3>

            </div>


            <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-gray-100 dark:bg-white/[0.06]">

                <svg
                    class="h-5 w-5 text-gray-600 dark:text-gray-300"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                >

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M7 3h8l4 4v14H7a2 2 0 01-2-2V5a2 2 0 012-2z"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15 3v5h5"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M9 13h6M9 17h4"
                    />

                </svg>

            </div>

        </div>

    </div>

</div>


{{-- ============================================================
     REPORT GENERATOR
============================================================= --}}
<div
    id="report-generator"
    class="mb-6 rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]"
>

    {{-- Generator Header --}}
    <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">

        <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
            Generate New Report
        </h2>

        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Select the report type, date range, link and export format.
        </p>

    </div>


    {{-- Generator Form --}}
    <div class="p-6">

        <form
            method="POST"
            action="{{ route('reports.generate') }}"
        >

            @csrf


            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">


                {{-- Report Type --}}
                <div>

                    <label
                        for="report-type"
                        class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                    >
                        Report Type
                    </label>

                    <select
                        id="report-type"
                        name="report_type"
                        required
                        class="h-11 w-full rounded-lg border border-gray-300 bg-white px-4 text-sm text-gray-700 outline-none transition focus:border-gray-500 focus:ring-1 focus:ring-gray-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-gray-400"
                    >

                        <option value="Link Performance">
                            Link Performance
                        </option>

                        <option value="Click Analytics">
                            Click Analytics
                        </option>

                        <option value="Geographic Analytics">
                            Geographic Analytics
                        </option>

                        <option value="Device Analytics">
                            Device Analytics
                        </option>

                        <option value="Browser & OS Analytics">
                            Browser & OS Analytics
                        </option>

                    </select>

                </div>


                {{-- Date Range --}}
                <div>

                    <label
                        for="date-range"
                        class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                    >
                        Date Range
                    </label>

                    <select
                        id="date-range"
                        name="date_range"
                        required
                        class="h-11 w-full rounded-lg border border-gray-300 bg-white px-4 text-sm text-gray-700 outline-none transition focus:border-gray-500 focus:ring-1 focus:ring-gray-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-gray-400"
                    >

                        <option value="Last 7 Days">
                            Last 7 Days
                        </option>

                        <option value="Last 30 Days">
                            Last 30 Days
                        </option>

                        <option value="Last 90 Days">
                            Last 90 Days
                        </option>

                        <option value="This Year">
                            This Year
                        </option>

                    </select>

                </div>


                {{-- Short Link --}}
                <div>

                    <label
                        for="report-link"
                        class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                    >
                        Short Link
                    </label>

                    <select
                        id="report-link"
                        name="short_url_id"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-white px-4 text-sm text-gray-700 outline-none transition focus:border-gray-500 focus:ring-1 focus:ring-gray-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-gray-400"
                    >

                        <option value="">
                            All Links
                        </option>

                        @foreach($shortUrls as $shortUrl)

                            <option value="{{ $shortUrl->id }}">

                                /{{ $shortUrl->custom_alias ?: $shortUrl->short_code }}

                                —
                                {{ \Illuminate\Support\Str::limit($shortUrl->original_url, 45) }}

                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- Export Format --}}
                <div>

                    <label
                        for="report-format"
                        class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                    >
                        Export Format
                    </label>

                    <select
                        id="report-format"
                        name="format"
                        required
                        class="h-11 w-full rounded-lg border border-gray-300 bg-white px-4 text-sm text-gray-700 outline-none transition focus:border-gray-500 focus:ring-1 focus:ring-gray-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-gray-400"
                    >

                        <option value="CSV">
                            CSV
                        </option>

                        <option value="PDF">
                            PDF
                        </option>

                    </select>

                </div>

            </div>


            {{-- Form Buttons --}}
            <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:justify-end">

                <button
                    type="reset"
                    class="inline-flex h-11 items-center justify-center rounded-lg border border-gray-300 px-5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-white/[0.05]"
                >
                    Reset
                </button>


                <button
                    type="submit"
                    class="inline-flex h-11 items-center justify-center gap-2 rounded-lg bg-gray-800 px-5 text-sm font-medium text-white transition hover:bg-gray-700 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-200"
                >

                    <svg
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 3v12m0 0l4-4m-4 4l-4-4M5 21h14"
                        />

                    </svg>

                    Generate Report

                </button>

            </div>

        </form>

    </div>

</div>


{{-- ============================================================
     REPORT HISTORY
============================================================= --}}
<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">


    {{-- History Header --}}
    <div class="flex flex-col gap-4 border-b border-gray-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between dark:border-gray-800">

        <div>

            <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                Report History
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Previously generated reports.
            </p>

        </div>


        {{-- Search Box --}}
        <div class="relative">

            <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2">

                <svg
                    class="h-5 w-5 text-gray-400"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                >

                    <circle
                        cx="11"
                        cy="11"
                        r="7"
                    />

                    <path
                        stroke-linecap="round"
                        d="m20 20-4-4"
                    />

                </svg>

            </span>


            <input
                type="text"
                id="report-search"
                placeholder="Search reports..."
                class="h-10 w-full rounded-lg border border-gray-300 bg-white pl-10 pr-4 text-sm text-gray-700 outline-none transition focus:border-gray-500 focus:ring-1 focus:ring-gray-500 sm:w-64 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-gray-400"
            >

        </div>

    </div>


    {{-- History Table --}}
    <div class="overflow-x-auto">

        <table class="w-full min-w-[900px]">

            <thead>

                <tr class="border-b border-gray-200 dark:border-gray-800">

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                        Report
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                        Type
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                        Date Range
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                        Format
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                        Created
                    </th>

                    <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                        Actions
                    </th>

                </tr>

            </thead>


            <tbody id="reports-table-body">

                @forelse($reports as $report)

                    <tr
                        class="report-row border-b border-gray-100 dark:border-gray-800"
                        data-report-name="{{ strtolower($report->name) }}"
                        data-report-type="{{ strtolower($report->type) }}"
                    >


                        {{-- Report Name --}}
                        <td class="px-6 py-5">

                            <div class="flex items-center gap-3">


                                {{-- Icon --}}
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-gray-100 dark:bg-white/[0.06]">

                                    <svg
                                        class="h-5 w-5 text-gray-600 dark:text-gray-300"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                    >

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M6 3h9l4 4v14H6a2 2 0 01-2-2V5a2 2 0 012-2z"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M15 3v5h5"
                                        />

                                    </svg>

                                </div>


                                <div class="min-w-0">

                                    <p class="truncate text-sm font-medium text-gray-800 dark:text-white/90">
                                        {{ $report->name }}
                                    </p>


                                    <p class="mt-1 truncate text-xs text-gray-500 dark:text-gray-400">

                                        @if($report->shortUrl)

                                            {{ $report->shortUrl->short_url }}

                                        @else

                                            All short links

                                        @endif

                                    </p>

                                </div>

                            </div>

                        </td>


                        {{-- Report Type --}}
                        <td class="px-6 py-5">

                            <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600 dark:bg-white/[0.06] dark:text-gray-300">

                                {{ $report->type }}

                            </span>

                        </td>


                        {{-- Date Range --}}
                        <td class="px-6 py-5 text-sm text-gray-500 dark:text-gray-400">

                            {{ $report->date_range }}

                        </td>


                        {{-- Format --}}
                        <td class="px-6 py-5">

                            @if($report->format === 'CSV')

                                <span class="inline-flex rounded-md bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-600 dark:bg-white/[0.06] dark:text-gray-300">
                                    CSV
                                </span>

                            @else

                                <span class="inline-flex rounded-md bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-600 dark:bg-white/[0.06] dark:text-gray-300">
                                    PDF
                                </span>

                            @endif

                        </td>


                        {{-- Created Date --}}
                        <td class="px-6 py-5 text-sm text-gray-500 dark:text-gray-400">

                            {{ $report->created_at->format('M d, Y') }}

                            <span class="mt-1 block text-xs text-gray-400 dark:text-gray-500">
                                {{ $report->created_at->format('h:i A') }}
                            </span>

                        </td>


                        {{-- Actions --}}
                        <td class="px-6 py-5">

                            <div class="flex justify-end gap-2">


                                {{-- Download --}}
                                <a
                                    href="{{ route('reports.download', $report->id) }}"
                                    title="Download Report"
                                    class="rounded-lg p-2 text-gray-500 transition hover:bg-gray-100 hover:text-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.05] dark:hover:text-white"
                                >

                                    <svg
                                        class="h-5 w-5"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                    >

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M12 3v12m0 0l4-4m-4 4l-4-4M5 21h14"
                                        />

                                    </svg>

                                </a>


                                {{-- Delete --}}
                                <form
                                    method="POST"
                                    action="{{ route('reports.destroy', $report->id) }}"
                                    onsubmit="return confirm('Are you sure you want to delete this report?');"
                                >

                                    @csrf

                                    @method('DELETE')


                                    <button
                                        type="submit"
                                        title="Delete Report"
                                        class="rounded-lg p-2 text-gray-500 transition hover:bg-gray-100 hover:text-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.05] dark:hover:text-white"
                                    >

                                        <svg
                                            class="h-5 w-5"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                        >

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M6 7h12M9 7V5h6v2m-7 0v12h8V7M10 11v5m4-5v5"
                                            />

                                        </svg>

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>


                @empty

                    {{-- No Reports --}}
                    <tr id="no-reports-row">

                        <td
                            colspan="6"
                            class="px-6 py-12 text-center"
                        >

                            <div class="flex flex-col items-center justify-center">


                                <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 dark:bg-white/[0.06]">

                                    <svg
                                        class="h-6 w-6 text-gray-500 dark:text-gray-400"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                    >

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M7 3h8l4 4v14H7a2 2 0 01-2-2V5a2 2 0 012-2z"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M15 3v5h5"
                                        />

                                    </svg>

                                </div>


                                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    No reports generated yet.
                                </p>


                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    Generate your first report using the form above.
                                </p>

                            </div>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    {{-- ========================================================
         PAGINATION
    ========================================================= --}}
    <div class="flex flex-col gap-3 border-t border-gray-200 px-6 py-4 sm:flex-row sm:items-center sm:justify-between dark:border-gray-800">

        <p class="text-sm text-gray-500 dark:text-gray-400">

            Showing

            {{ $reports->firstItem() ?? 0 }}

            to

            {{ $reports->lastItem() ?? 0 }}

            of

            {{ $reports->total() }}

            reports

        </p>


        <div>

            {{ $reports->links() }}

        </div>

    </div>

</div>

</div>


{{-- ================================================================
     REPORT SEARCH
================================================================= --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('report-search');

    const reportRows = document.querySelectorAll('.report-row');

    if (!searchInput) {
        return;
    }

    searchInput.addEventListener('input', function () {

        const searchTerm = this.value.toLowerCase().trim();

        reportRows.forEach(function (row) {

            const reportName = row.dataset.reportName || '';

            const reportType = row.dataset.reportType || '';

            const matches =
                reportName.includes(searchTerm) ||
                reportType.includes(searchTerm);

            row.style.display = matches ? '' : 'none';

        });

    });

});

</script>

@endsection