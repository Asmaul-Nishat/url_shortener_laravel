@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-7xl">


{{-- ============================================================
    PAGE HEADER
============================================================ --}}
<div class="mb-6">



    {{-- Page Title --}}
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white/90">
        Generated Reports
    </h1>


    {{-- Page Description --}}
    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
        View, download, and manage generated reports.
    </p>

</div>


{{-- ============================================================
    SUCCESS MESSAGE
============================================================ --}}
@if(session('success'))

    <div class="mb-6 rounded-lg border border-success-200 bg-success-50 px-4 py-4 dark:border-success-500/30 dark:bg-success-500/10">

        <p class="text-sm font-medium text-success-700 dark:text-success-400">
            {{ session('success') }}
        </p>

    </div>

@endif


{{-- ============================================================
    ERROR MESSAGE
============================================================ --}}
@if(session('error'))

    <div class="mb-6 rounded-lg border border-error-200 bg-error-50 px-4 py-4 dark:border-error-500/30 dark:bg-error-500/10">

        <p class="text-sm font-medium text-error-700 dark:text-error-400">
            {{ session('error') }}
        </p>

    </div>

@endif


{{-- ============================================================
    VALIDATION ERRORS
============================================================ --}}
@if($errors->any())

    <div class="mb-6 rounded-lg border border-error-200 bg-error-50 px-4 py-4 dark:border-error-500/30 dark:bg-error-500/10">

        <p class="text-sm font-medium text-error-700 dark:text-error-400">
            Please correct the following errors:
        </p>


        <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-error-700 dark:text-error-400">

            @foreach($errors->all() as $error)

                <li>
                    {{ $error }}
                </li>

            @endforeach

        </ul>

    </div>

@endif


{{-- ============================================================
    GENERATED REPORTS
============================================================ --}}
<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

    {{-- Card Header --}}
    <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                    Generated Reports
                </h2>

            

            </div>


            {{-- Report Count --}}
            @if($reports->total() > 0)

                <div class="text-sm text-gray-500 dark:text-gray-400">

                    {{ $reports->total() }}

                    {{ $reports->total() === 1 ? 'report' : 'reports' }}

                </div>

            @endif

        </div>

    </div>


    {{-- ========================================================
        REPORT TABLE
    ========================================================= --}}
    @if($reports->count())

        <div class="overflow-x-auto">

            <table class="min-w-full">

                {{-- Table Header --}}
                <thead>

                    <tr class="border-b border-gray-200 dark:border-gray-800">

                        {{-- Report --}}
                        <th
                            class="whitespace-nowrap px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400"
                        >
                            Report
                        </th>


                        {{-- User --}}
                        <th
                            class="whitespace-nowrap px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400"
                        >
                            User
                        </th>


                        {{-- Type --}}
                        <th
                            class="whitespace-nowrap px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400"
                        >
                            Type
                        </th>


                        {{-- Date Range --}}
                        <th
                            class="whitespace-nowrap px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400"
                        >
                            Date Range
                        </th>


                        {{-- Format --}}
                        <th
                            class="whitespace-nowrap px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400"
                        >
                            Format
                        </th>


                        {{-- Clicks --}}
                        <th
                            class="whitespace-nowrap px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400"
                        >
                            Clicks
                        </th>


                        {{-- Created --}}
                        <th
                            class="whitespace-nowrap px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400"
                        >
                            Created
                        </th>


                        {{-- Download --}}
                        <th
                            class="whitespace-nowrap px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400"
                        >
                            Download
                        </th>


                        {{-- Delete --}}
                        <th
                            class="whitespace-nowrap px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400"
                        >
                            Delete
                        </th>

                    </tr>

                </thead>


                {{-- Table Body --}}
                <tbody class="divide-y divide-gray-200 dark:divide-gray-800">

                    @foreach($reports as $report)

                        <tr class="transition hover:bg-gray-50 dark:hover:bg-white/[0.02]">

                            {{-- =================================================
                                REPORT
                            ================================================== --}}
                            <td class="px-6 py-4">

                                <div class="min-w-[220px]">

                                    <p
                                        class="truncate text-sm font-medium text-gray-800 dark:text-white/90"
                                        title="{{ $report->name }}"
                                    >
                                        {{ $report->name }}
                                    </p>


                                    @if($report->shortUrl)

                                        <p
                                            class="mt-1 truncate text-xs text-gray-500 dark:text-gray-400"
                                            title="{{ $report->shortUrl->original_url }}"
                                        >
                                            {{ $report->shortUrl->short_url }}
                                        </p>

                                    @else

                                        <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">
                                            All Short Links
                                        </p>

                                    @endif

                                </div>

                            </td>


                            {{-- =================================================
                                USER
                            ================================================== --}}
                            <td class="px-6 py-4">

                                @if($report->user)

                                    <div class="flex items-center gap-3">

                                        {{-- Avatar --}}
                                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-brand-50 text-sm font-semibold text-brand-600 dark:bg-brand-500/10 dark:text-brand-400">

                                            {{ strtoupper(substr($report->user->name ?? 'U', 0, 1)) }}

                                        </div>


                                        {{-- User Information --}}
                                        <div class="min-w-0">

                                            <p class="truncate text-sm font-medium text-gray-800 dark:text-white/90">
                                                {{ $report->user->name }}
                                            </p>

                                            <p class="truncate text-xs text-gray-500 dark:text-gray-400">
                                                {{ $report->user->email }}
                                            </p>

                                        </div>

                                    </div>

                                @else

                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                        —
                                    </span>

                                @endif

                            </td>


                            {{-- =================================================
                                TYPE
                            ================================================== --}}
                            <td class="px-6 py-4">

                                <span class="inline-flex items-center rounded-full bg-brand-50 px-2.5 py-1 text-xs font-medium text-brand-700 dark:bg-brand-500/10 dark:text-brand-400">

                                    @if($report->type === 'click_analytics')

                                        Click Analytics

                                    @else

                                        {{ ucfirst(str_replace('_', ' ', $report->type)) }}

                                    @endif

                                </span>

                            </td>


                            {{-- =================================================
                                DATE RANGE
                            ================================================== --}}
                            <td class="px-6 py-4">

                                <div class="whitespace-nowrap">

                                    <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                                        {{ $report->date_range }}
                                    </p>


                                    @if($report->start_date)

                                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">

                                            {{ $report->start_date->format('M d, Y') }}

                                            @if($report->end_date)

                                                –

                                                {{ $report->end_date->format('M d, Y') }}

                                            @endif

                                        </p>

                                    @endif

                                </div>

                            </td>


                            {{-- =================================================
                                FORMAT
                            ================================================== --}}
                            <td class="px-6 py-4">

                                @if(strtoupper($report->format) === 'PDF')

                                    <span class="inline-flex items-center rounded-full bg-error-50 px-2.5 py-1 text-xs font-medium text-error-700 dark:bg-error-500/10 dark:text-error-400">
                                        PDF
                                    </span>

                                @elseif(strtoupper($report->format) === 'CSV')

                                    <span class="inline-flex items-center rounded-full bg-success-50 px-2.5 py-1 text-xs font-medium text-success-700 dark:bg-success-500/10 dark:text-success-400">
                                        CSV
                                    </span>

                                @else

                                    <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                                        {{ strtoupper($report->format) }}
                                    </span>

                                @endif

                            </td>


                            {{-- =================================================
                                CLICKS
                            ================================================== --}}
                            <td class="px-6 py-4 text-right">

                                <span class="text-sm font-semibold text-gray-800 dark:text-white/90">
                                    {{ number_format($report->total_clicks ?? 0) }}
                                </span>

                            </td>


                            {{-- =================================================
                                CREATED
                            ================================================== --}}
                            <td class="px-6 py-4">

                                <div class="whitespace-nowrap">

                                    <p class="text-sm text-gray-700 dark:text-gray-300">
                                        {{ $report->created_at?->format('M d, Y') }}
                                    </p>

                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        {{ $report->created_at?->format('h:i A') }}
                                    </p>

                                </div>

                            </td>


                            {{-- =================================================
                                DOWNLOAD
                            ================================================== --}}
                            <td class="px-6 py-4">

                                <div class="flex justify-end">

                                    <a
                                        href="{{ route('admin.reports.download', $report) }}"
                                        class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-3 py-2 text-xs font-medium text-white shadow-theme-xs transition hover:bg-brand-600"
                                    >

                                        <svg
                                            class="h-4 w-4"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M12 3v12m0 0l4-4m-4 4l-4-4m-5 8h18"
                                            />
                                        </svg>

                                        Download

                                    </a>

                                </div>

                            </td>


                            {{-- =================================================
                                DELETE
                            ================================================== --}}
                            <td class="px-6 py-4">

                                <div class="flex justify-end">

                                    <form
                                        method="POST"
                                        action="{{ route('admin.reports.destroy', $report) }}"
                                        onsubmit="return confirm('Are you sure you want to delete this generated report? The Short URL and click data will not be deleted.');"
                                    >

                                        @csrf

                                        @method('DELETE')


                                        <button
                                            type="submit"
                                            class="inline-flex items-center gap-2 rounded-lg border border-error-200 bg-error-50 px-3 py-2 text-xs font-medium text-error-700 transition hover:bg-error-100 dark:border-error-500/30 dark:bg-error-500/10 dark:text-error-400 dark:hover:bg-error-500/20"
                                        >

                                            <svg
                                                class="h-4 w-4"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M6 7h12M9 7V5a1 1 0 012-2h2a1 1 0 012 2v2m2 0v12a2 2 0 01-2 2H9a2 2 0 01-2-2V7m3 4v6m4-6v6"
                                                />
                                            </svg>

                                            Delete

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>


        {{-- ========================================================
            PAGINATION
        ========================================================= --}}
        @if($reports->hasPages())

            <div class="border-t border-gray-200 px-6 py-4 dark:border-gray-800">

                {{ $reports->links() }}

            </div>

        @endif


    @else

        {{-- ========================================================
            EMPTY STATE
        ========================================================= --}}
        <div class="px-6 py-16 text-center">

            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">

                <svg
                    class="h-7 w-7 text-gray-500 dark:text-gray-400"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 14h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414A1 1 0 0119 9.414V21a2 2 0 01-2 2z"
                    />
                </svg>

            </div>


            <h3 class="mt-4 text-sm font-semibold text-gray-800 dark:text-white/90">
                No generated reports
            </h3>


            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Generated reports will appear here.
            </p>

        </div>

    @endif

</div>

</div>

@endsection

