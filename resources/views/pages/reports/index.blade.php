@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-7xl">

    {{-- Page Header --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white/90">
                Reports
            </h1>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Generate, export and manage performance reports for your short links.
            </p>
        </div>

        <button
            type="button"
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
                    d="M12 4v16m8-8H4"
                />
            </svg>

            Generate Report
        </button>

    </div>


    {{-- Report Summary --}}
    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        {{-- Total Reports --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Total Reports
                    </p>

                    <h3 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">
                        0
                    </h3>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-gray-100 dark:bg-white/[0.06]">
                    <svg
                        class="h-6 w-6 text-gray-600 dark:text-gray-300"
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
                            d="M15 3v5h5M9 13h6M9 17h6"
                        />
                    </svg>
                </div>

            </div>

        </div>


        {{-- This Month --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        This Month
                    </p>

                    <h3 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">
                        0
                    </h3>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-gray-100 dark:bg-white/[0.06]">
                    <svg
                        class="h-6 w-6 text-gray-600 dark:text-gray-300"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <rect
                            x="3"
                            y="4"
                            width="18"
                            height="17"
                            rx="2"
                        />
                        <path
                            stroke-linecap="round"
                            d="M16 2v4M8 2v4M3 10h18"
                        />
                    </svg>
                </div>

            </div>

        </div>


        {{-- CSV Reports --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        CSV Reports
                    </p>

                    <h3 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">
                        0
                    </h3>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-gray-100 dark:bg-white/[0.06]">
                    <svg
                        class="h-6 w-6 text-gray-600 dark:text-gray-300"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M5 4h14v16H5z"
                        />
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M8 8h8M8 12h8M8 16h5"
                        />
                    </svg>
                </div>

            </div>

        </div>


        {{-- PDF Reports --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        PDF Reports
                    </p>

                    <h3 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">
                        0
                    </h3>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-gray-100 dark:bg-white/[0.06]">
                    <svg
                        class="h-6 w-6 text-gray-600 dark:text-gray-300"
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
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M8 14h2M8 17h5"
                        />
                    </svg>
                </div>

            </div>

        </div>

    </div>


    {{-- Report Generator --}}
    <div class="mb-6 rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

        {{-- Header --}}
        <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">

            <div class="flex items-center gap-3">

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-gray-100 dark:bg-white/[0.06]">

                    <svg
                        class="h-6 w-6 text-gray-600 dark:text-gray-300"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M4 4h16v16H4z"
                        />
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M8 8h8M8 12h8M8 16h5"
                        />
                    </svg>

                </div>

                <div>

                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                        Generate Report
                    </h2>

                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Select the report type, date range and export format.
                    </p>

                </div>

            </div>

        </div>


        {{-- Form --}}
        <div class="p-6">

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">

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
                        class="h-11 w-full rounded-lg border border-gray-300 bg-white px-4 text-sm text-gray-800 outline-none transition focus:border-gray-500 focus:ring-1 focus:ring-gray-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                    >
                        <option>Link Performance</option>
                        <option>Click Analytics</option>
                        <option>Geographic Analytics</option>
                        <option>Device Analytics</option>
                        <option>Browser & OS Analytics</option>
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
                        class="h-11 w-full rounded-lg border border-gray-300 bg-white px-4 text-sm text-gray-800 outline-none transition focus:border-gray-500 focus:ring-1 focus:ring-gray-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                    >
                        <option>Last 7 Days</option>
                        <option>Last 30 Days</option>
                        <option>Last 90 Days</option>
                        <option>This Year</option>
                        <option>Custom Range</option>
                    </select>

                </div>


                {{-- Link --}}
                <div>

                    <label
                        for="report-link"
                        class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                    >
                        Short Link
                    </label>

                    <select
                        id="report-link"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-white px-4 text-sm text-gray-800 outline-none transition focus:border-gray-500 focus:ring-1 focus:ring-gray-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                    >
                        <option>All Links</option>
                        <option>/abc123 — example.com</option>
                        <option>/google1 — google.com</option>
                        <option>/github1 — github.com</option>
                    </select>

                </div>


                {{-- Format --}}
                <div>

                    <label
                        for="report-format"
                        class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                    >
                        Export Format
                    </label>

                    <select
                        id="report-format"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-white px-4 text-sm text-gray-800 outline-none transition focus:border-gray-500 focus:ring-1 focus:ring-gray-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                    >
                        <option>CSV</option>
                        <option>PDF</option>
                    </select>

                </div>

            </div>


            {{-- Generate Action --}}
            <div class="mt-6 flex flex-col gap-3 border-t border-gray-200 pt-6 sm:flex-row sm:justify-end dark:border-gray-800">

                <button
                    type="button"
                    class="inline-flex h-11 items-center justify-center gap-2 rounded-lg border border-gray-300 px-5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-white/[0.04]"
                >
                    Reset
                </button>

                <button
                    type="button"
                    class="inline-flex h-11 items-center justify-center gap-2 rounded-lg bg-gray-800 px-5 text-sm font-medium text-white transition hover:bg-gray-700 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-200"
                >
                    <svg
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M12 4v16m8-8H4"
                        />
                    </svg>

                    Generate Report
                </button>

            </div>

        </div>

    </div>


    {{-- Available Reports --}}
    <div class="mb-6 grid grid-cols-1 gap-6 lg:grid-cols-2">

        {{-- Link Performance --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="flex items-start gap-4">

                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-gray-100 dark:bg-white/[0.06]">

                    <svg
                        class="h-6 w-6 text-gray-600 dark:text-gray-300"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M4 19V5M4 19h16"
                        />
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M7 15l4-4 3 2 5-6"
                        />
                    </svg>

                </div>

                <div>

                    <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">
                        Link Performance
                    </h3>

                    <p class="mt-1 text-sm leading-6 text-gray-500 dark:text-gray-400">
                        Analyze clicks, active links, expired links and individual link performance.
                    </p>

                </div>

            </div>

            <div class="mt-5 flex flex-wrap gap-2">

                <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600 dark:bg-white/[0.06] dark:text-gray-300">
                    Clicks
                </span>

                <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600 dark:bg-white/[0.06] dark:text-gray-300">
                    Links
                </span>

                <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600 dark:bg-white/[0.06] dark:text-gray-300">
                    Status
                </span>

            </div>

        </div>


        {{-- Geographic Analytics --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="flex items-start gap-4">

                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-gray-100 dark:bg-white/[0.06]">

                    <svg
                        class="h-6 w-6 text-gray-600 dark:text-gray-300"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <circle
                            cx="12"
                            cy="12"
                            r="8"
                        />
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M4 12h16M12 4c2 2.2 3 4.9 3 8s-1 5.8-3 8c-2-2.2-3-4.9-3-8s1-5.8 3-8z"
                        />
                    </svg>

                </div>

                <div>

                    <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">
                        Geographic Analytics
                    </h3>

                    <p class="mt-1 text-sm leading-6 text-gray-500 dark:text-gray-400">
                        Understand where your visitors are coming from by country and region.
                    </p>

                </div>

            </div>

            <div class="mt-5 flex flex-wrap gap-2">

                <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600 dark:bg-white/[0.06] dark:text-gray-300">
                    Countries
                </span>

                <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600 dark:bg-white/[0.06] dark:text-gray-300">
                    Regions
                </span>

            </div>

        </div>


        {{-- Device Analytics --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="flex items-start gap-4">

                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-gray-100 dark:bg-white/[0.06]">

                    <svg
                        class="h-6 w-6 text-gray-600 dark:text-gray-300"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <rect
                            x="7"
                            y="3"
                            width="10"
                            height="18"
                            rx="2"
                        />
                        <path
                            stroke-linecap="round"
                            d="M10 18h4"
                        />
                    </svg>

                </div>

                <div>

                    <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">
                        Device Analytics
                    </h3>

                    <p class="mt-1 text-sm leading-6 text-gray-500 dark:text-gray-400">
                        Analyze visitors based on mobile, desktop and tablet devices.
                    </p>

                </div>

            </div>

            <div class="mt-5 flex flex-wrap gap-2">

                <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600 dark:bg-white/[0.06] dark:text-gray-300">
                    Desktop
                </span>

                <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600 dark:bg-white/[0.06] dark:text-gray-300">
                    Mobile
                </span>

                <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600 dark:bg-white/[0.06] dark:text-gray-300">
                    Tablet
                </span>

            </div>

        </div>


        {{-- Browser & OS --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="flex items-start gap-4">

                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-gray-100 dark:bg-white/[0.06]">

                    <svg
                        class="h-6 w-6 text-gray-600 dark:text-gray-300"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <rect
                            x="3"
                            y="4"
                            width="18"
                            height="13"
                            rx="2"
                        />
                        <path
                            stroke-linecap="round"
                            d="M8 21h8M12 17v4"
                        />
                    </svg>

                </div>

                <div>

                    <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">
                        Browser & OS Analytics
                    </h3>

                    <p class="mt-1 text-sm leading-6 text-gray-500 dark:text-gray-400">
                        See which browsers and operating systems your visitors use.
                    </p>

                </div>

            </div>

            <div class="mt-5 flex flex-wrap gap-2">

                <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600 dark:bg-white/[0.06] dark:text-gray-300">
                    Browser
                </span>

                <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600 dark:bg-white/[0.06] dark:text-gray-300">
                    Operating System
                </span>

            </div>

        </div>

    </div>


    {{-- Report History --}}
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

        {{-- Header --}}
        <div class="flex flex-col gap-4 border-b border-gray-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between dark:border-gray-800">

            <div>

                <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                    Report History
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    View and download previously generated reports.
                </p>

            </div>

            <div class="relative w-full sm:w-64">

                <svg
                    class="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="m21 21-4.35-4.35m2.35-5.65a8 8 0 11-16 0 8 8 0 0116 0Z"
                    />
                </svg>

                <input
                    type="text"
                    placeholder="Search reports..."
                    class="h-10 w-full rounded-lg border border-gray-300 bg-transparent pl-10 pr-4 text-sm text-gray-800 outline-none focus:border-gray-500 dark:border-gray-700 dark:text-white/90"
                />

            </div>

        </div>


        {{-- Table --}}
        <div class="overflow-x-auto">

            <table class="w-full min-w-[850px]">

                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-800">

                        <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Report
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Type
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Date Range
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Format
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Created
                        </th>

                        <th class="px-6 py-4 text-right text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Actions
                        </th>

                    </tr>
                </thead>


                <tbody>

                    {{-- Demo Row --}}
                    <tr class="border-b border-gray-100 dark:border-gray-800">

                        <td class="px-6 py-5">

                            <div class="flex items-center gap-3">

                                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gray-100 dark:bg-white/[0.06]">

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

                                <div>

                                    <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                                        Link Performance Report
                                    </p>

                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        All short links
                                    </p>

                                </div>

                            </div>

                        </td>


                        <td class="px-6 py-5">
                            <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600 dark:bg-white/[0.06] dark:text-gray-300">
                                Performance
                            </span>
                        </td>


                        <td class="px-6 py-5 text-sm text-gray-500 dark:text-gray-400">
                            Last 30 Days
                        </td>


                        <td class="px-6 py-5">

                            <span class="rounded-md bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-600 dark:bg-white/[0.06] dark:text-gray-300">
                                PDF
                            </span>

                        </td>


                        <td class="px-6 py-5 text-sm text-gray-500 dark:text-gray-400">
                            Sep 10, 2026
                        </td>


                        <td class="px-6 py-5">

                            <div class="flex justify-end gap-2">

                                <button
                                    type="button"
                                    title="Download"
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
                                </button>


                                <button
                                    type="button"
                                    title="Delete"
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

                            </div>

                        </td>

                    </tr>


                    {{-- Demo Row 2 --}}
                    <tr>

                        <td class="px-6 py-5">

                            <div class="flex items-center gap-3">

                                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gray-100 dark:bg-white/[0.06]">

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

                                <div>

                                    <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                                        Click Analytics Report
                                    </p>

                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        All short links
                                    </p>

                                </div>

                            </div>

                        </td>


                        <td class="px-6 py-5">
                            <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600 dark:bg-white/[0.06] dark:text-gray-300">
                                Analytics
                            </span>
                        </td>


                        <td class="px-6 py-5 text-sm text-gray-500 dark:text-gray-400">
                            Last 7 Days
                        </td>


                        <td class="px-6 py-5">

                            <span class="rounded-md bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-600 dark:bg-white/[0.06] dark:text-gray-300">
                                CSV
                            </span>

                        </td>


                        <td class="px-6 py-5 text-sm text-gray-500 dark:text-gray-400">
                            Sep 09, 2026
                        </td>


                        <td class="px-6 py-5">

                            <div class="flex justify-end gap-2">

                                <button
                                    type="button"
                                    title="Download"
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
                                </button>


                                <button
                                    type="button"
                                    title="Delete"
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

                            </div>

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>


        {{-- Footer --}}
        <div class="flex flex-col gap-3 border-t border-gray-200 px-6 py-4 sm:flex-row sm:items-center sm:justify-between dark:border-gray-800">

            <p class="text-sm text-gray-500 dark:text-gray-400">
                Showing 2 demo reports
            </p>

            <div class="flex gap-2">

                <button
                    type="button"
                    disabled
                    class="rounded-lg border border-gray-200 px-3 py-2 text-sm text-gray-400 dark:border-gray-800"
                >
                    Previous
                </button>

                <button
                    type="button"
                    disabled
                    class="rounded-lg border border-gray-200 px-3 py-2 text-sm text-gray-400 dark:border-gray-800"
                >
                    Next
                </button>

            </div>

        </div>

    </div>

</div>
@endsection