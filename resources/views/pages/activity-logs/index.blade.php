@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-7xl">

    <!-- Page Header -->
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">
                Activity Logs
            </h1>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Monitor account activity and important actions performed in the system.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <button
                type="button"
                class="inline-flex items-center justify-center rounded-lg bg-gray-800 px-4 py-2.5 text-sm font-medium text-white hover:bg-gray-700 dark:bg-white dark:text-gray-800 dark:hover:bg-gray-100"
            >
                Export Logs
            </button>
        </div>
    </div>


    <!-- Summary Cards -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        <!-- Total Activities -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Total Activities
                    </p>

                    <h3 class="mt-2 text-2xl font-semibold text-gray-800 dark:text-white">
                        0
                    </h3>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-gray-100 dark:bg-white/10">
                    <svg class="h-5 w-5 text-gray-600 dark:text-gray-300"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="1.8"
                              d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>


        <!-- Today -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Today
                    </p>

                    <h3 class="mt-2 text-2xl font-semibold text-gray-800 dark:text-white">
                        0
                    </h3>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-gray-100 dark:bg-white/10">
                    <svg class="h-5 w-5 text-gray-600 dark:text-gray-300"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="1.8"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>


        <!-- Successful -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Successful
                    </p>

                    <h3 class="mt-2 text-2xl font-semibold text-gray-800 dark:text-white">
                        0
                    </h3>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-gray-100 dark:bg-white/10">
                    <svg class="h-5 w-5 text-gray-600 dark:text-gray-300"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="1.8"
                              d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
            </div>
        </div>


        <!-- Failed -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Failed
                    </p>

                    <h3 class="mt-2 text-2xl font-semibold text-gray-800 dark:text-white">
                        0
                    </h3>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-gray-100 dark:bg-white/10">
                    <svg class="h-5 w-5 text-gray-600 dark:text-gray-300"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="1.8"
                              d="M12 9v4m0 4h.01M10.3 3.8L2.8 17a2 2 0 001.7 3h15a2 2 0 001.7-3L13.7 3.8a2 2 0 00-3.4 0z"/>
                    </svg>
                </div>
            </div>
        </div>

    </div>


    <!-- Filters -->
    <div class="mt-6 rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

        <div class="mb-5">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
                Activity History
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Search and filter recent system activities.
            </p>
        </div>


        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">

            <!-- Search -->
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Search
                </label>

                <input
                    type="text"
                    placeholder="Search activities..."
                    class="h-11 w-full rounded-lg border border-gray-300 bg-white px-4 text-sm text-gray-800 outline-none focus:border-gray-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                >
            </div>


            <!-- Activity Type -->
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Activity Type
                </label>

                <select
                    class="h-11 w-full rounded-lg border border-gray-300 bg-white px-4 text-sm text-gray-800 outline-none focus:border-gray-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                >
                    <option>All Activities</option>
                    <option>Authentication</option>
                    <option>URL Management</option>
                    <option>QR Code</option>
                    <option>Analytics</option>
                    <option>Settings</option>
                    <option>Reports</option>
                </select>
            </div>


            <!-- Status -->
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Status
                </label>

                <select
                    class="h-11 w-full rounded-lg border border-gray-300 bg-white px-4 text-sm text-gray-800 outline-none focus:border-gray-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                >
                    <option>All Status</option>
                    <option>Successful</option>
                    <option>Failed</option>
                </select>
            </div>


            <!-- Date -->
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Date Range
                </label>

                <select
                    class="h-11 w-full rounded-lg border border-gray-300 bg-white px-4 text-sm text-gray-800 outline-none focus:border-gray-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                >
                    <option>Last 7 Days</option>
                    <option>Last 30 Days</option>
                    <option>Last 90 Days</option>
                    <option>This Year</option>
                    <option>Custom Range</option>
                </select>
            </div>

        </div>

    </div>


    <!-- Activity Table -->
    <div class="mt-6 overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

        <div class="border-b border-gray-200 px-5 py-4 dark:border-gray-800">
            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
                        Recent Activities
                    </h2>

                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        A record of important actions performed in the platform.
                    </p>
                </div>

                <button
                    type="button"
                    class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-white/5"
                >
                    Clear Filters
                </button>

            </div>
        </div>


        <div class="overflow-x-auto">

            <table class="w-full min-w-[900px] text-left">

                <thead class="border-b border-gray-200 bg-gray-50 dark:border-gray-800 dark:bg-white/[0.02]">

                    <tr>
                        <th class="px-5 py-4 text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                            Activity
                        </th>

                        <th class="px-5 py-4 text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                            Description
                        </th>

                        <th class="px-5 py-4 text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                            IP Address
                        </th>

                        <th class="px-5 py-4 text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                            Status
                        </th>

                        <th class="px-5 py-4 text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                            Date & Time
                        </th>

                        <th class="px-5 py-4 text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                            Action
                        </th>
                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-200 dark:divide-gray-800">

                    <!-- Demo Row 1 -->
                    <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02]">

                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">

                                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gray-100 dark:bg-white/10">
                                    <svg class="h-4 w-4 text-gray-600 dark:text-gray-300"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="1.8"
                                              d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                </div>

                                <div>
                                    <p class="text-sm font-medium text-gray-800 dark:text-white">
                                        URL Created
                                    </p>

                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        URL Management
                                    </p>
                                </div>

                            </div>
                        </td>

                        <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-300">
                            Created short URL /abc123
                        </td>

                        <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-300">
                            192.168.1.10
                        </td>

                        <td class="px-5 py-4">
                            <span class="rounded-full bg-green-50 px-3 py-1 text-xs font-medium text-green-700 dark:bg-green-500/10 dark:text-green-400">
                                Successful
                            </span>
                        </td>

                        <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-300">
                            Sep 10, 2026 10:20 AM
                        </td>

                        <td class="px-5 py-4">
                            <button
                                type="button"
                                class="text-sm font-medium text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white"
                            >
                                View
                            </button>
                        </td>

                    </tr>


                    <!-- Demo Row 2 -->
                    <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02]">

                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">

                                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gray-100 dark:bg-white/10">
                                    <svg class="h-4 w-4 text-gray-600 dark:text-gray-300"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="1.8"
                                              d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>

                                <div>
                                    <p class="text-sm font-medium text-gray-800 dark:text-white">
                                        QR Code Generated
                                    </p>

                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        QR Code
                                    </p>
                                </div>

                            </div>
                        </td>

                        <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-300">
                            Generated QR code for /google1
                        </td>

                        <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-300">
                            192.168.1.10
                        </td>

                        <td class="px-5 py-4">
                            <span class="rounded-full bg-green-50 px-3 py-1 text-xs font-medium text-green-700 dark:bg-green-500/10 dark:text-green-400">
                                Successful
                            </span>
                        </td>

                        <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-300">
                            Sep 09, 2026 03:45 PM
                        </td>

                        <td class="px-5 py-4">
                            <button
                                type="button"
                                class="text-sm font-medium text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white"
                            >
                                View
                            </button>
                        </td>

                    </tr>


                    <!-- Demo Row 3 -->
                    <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02]">

                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">

                                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gray-100 dark:bg-white/10">
                                    <svg class="h-4 w-4 text-gray-600 dark:text-gray-300"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="1.8"
                                              d="M12 9v4m0 4h.01M10.3 3.8L2.8 17a2 2 0 001.7 3h15a2 2 0 001.7-3L13.7 3.8a2 2 0 00-3.4 0z"/>
                                    </svg>
                                </div>

                                <div>
                                    <p class="text-sm font-medium text-gray-800 dark:text-white">
                                        Login Attempt
                                    </p>

                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        Authentication
                                    </p>
                                </div>

                            </div>
                        </td>

                        <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-300">
                            Failed login attempt
                        </td>

                        <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-300">
                            192.168.1.25
                        </td>

                        <td class="px-5 py-4">
                            <span class="rounded-full bg-red-50 px-3 py-1 text-xs font-medium text-red-700 dark:bg-red-500/10 dark:text-red-400">
                                Failed
                            </span>
                        </td>

                        <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-300">
                            Sep 09, 2026 11:10 AM
                        </td>

                        <td class="px-5 py-4">
                            <button
                                type="button"
                                class="text-sm font-medium text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white"
                            >
                                View
                            </button>
                        </td>

                    </tr>


                    <!-- Demo Row 4 -->
                    <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02]">

                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">

                                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gray-100 dark:bg-white/10">
                                    <svg class="h-4 w-4 text-gray-600 dark:text-gray-300"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="1.8"
                                              d="M12 6v6h4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>

                                <div>
                                    <p class="text-sm font-medium text-gray-800 dark:text-white">
                                        Report Generated
                                    </p>

                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        Reports
                                    </p>
                                </div>

                            </div>
                        </td>

                        <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-300">
                            Generated Click Analytics report
                        </td>

                        <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-300">
                            192.168.1.10
                        </td>

                        <td class="px-5 py-4">
                            <span class="rounded-full bg-green-50 px-3 py-1 text-xs font-medium text-green-700 dark:bg-green-500/10 dark:text-green-400">
                                Successful
                            </span>
                        </td>

                        <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-300">
                            Sep 08, 2026 05:30 PM
                        </td>

                        <td class="px-5 py-4">
                            <button
                                type="button"
                                class="text-sm font-medium text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white"
                            >
                                View
                            </button>
                        </td>

                    </tr>

                </tbody>

            </table>

        </div>


        <!-- Footer -->
        <div class="flex flex-col gap-3 border-t border-gray-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between dark:border-gray-800">

            <p class="text-sm text-gray-500 dark:text-gray-400">
                Showing 4 of 4 activities
            </p>

            <div class="flex items-center gap-2">

                <button
                    type="button"
                    disabled
                    class="rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-400 dark:border-gray-700"
                >
                    Previous
                </button>

                <button
                    type="button"
                    class="rounded-lg bg-gray-800 px-3 py-2 text-sm font-medium text-white dark:bg-white dark:text-gray-800"
                >
                    1
                </button>

                <button
                    type="button"
                    disabled
                    class="rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-400 dark:border-gray-700"
                >
                    Next
                </button>

            </div>

        </div>

    </div>

</div>

@endsection