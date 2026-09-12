@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-7xl">

    <!-- Page Header -->
    <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white/90">
                Analytics
            </h1>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Analyze clicks and understand how your short links are performing.
            </p>
        </div>

        <div class="flex items-center gap-3">

            <select
                class="h-11 rounded-lg border border-gray-300 bg-white px-4 text-sm text-gray-700 outline-none transition focus:border-brand-500 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
            >
                <option>Last 7 Days</option>
                <option>Last 30 Days</option>
                <option>Last 90 Days</option>
                <option>This Year</option>
            </select>

        </div>

    </div>


    <!-- Overview Cards -->
    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-5">

        <!-- Total Clicks -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

            <p class="text-sm text-gray-500 dark:text-gray-400">
                Total Clicks
            </p>

            <h3 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">
                0
            </h3>

            <p class="mt-2 text-xs text-gray-400">
                All time
            </p>

        </div>


        <!-- Today -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

            <p class="text-sm text-gray-500 dark:text-gray-400">
                Today
            </p>

            <h3 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">
                0
            </h3>

            <p class="mt-2 text-xs text-gray-400">
                Clicks today
            </p>

        </div>


        <!-- Yesterday -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

            <p class="text-sm text-gray-500 dark:text-gray-400">
                Yesterday
            </p>

            <h3 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">
                0
            </h3>

            <p class="mt-2 text-xs text-gray-400">
                Previous day
            </p>

        </div>


        <!-- This Week -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

            <p class="text-sm text-gray-500 dark:text-gray-400">
                This Week
            </p>

            <h3 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">
                0
            </h3>

            <p class="mt-2 text-xs text-gray-400">
                Last 7 days
            </p>

        </div>


        <!-- This Month -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

            <p class="text-sm text-gray-500 dark:text-gray-400">
                This Month
            </p>

            <h3 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">
                0
            </h3>

            <p class="mt-2 text-xs text-gray-400">
                Current month
            </p>

        </div>

    </div>


    <!-- Click Analytics Chart -->
    <div class="mb-6 rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

        <div class="flex flex-col gap-3 border-b border-gray-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between dark:border-gray-800">

            <div>
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                    Click Analytics
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Track clicks on your short links over time.
                </p>
            </div>

            <div class="flex items-center gap-2">

                <button
                    type="button"
                    class="rounded-lg bg-brand-50 px-3 py-2 text-xs font-medium text-brand-500 dark:bg-brand-500/10"
                >
                    Daily
                </button>

                <button
                    type="button"
                    class="rounded-lg px-3 py-2 text-xs font-medium text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800"
                >
                    Weekly
                </button>

                <button
                    type="button"
                    class="rounded-lg px-3 py-2 text-xs font-medium text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800"
                >
                    Monthly
                </button>

            </div>

        </div>


        <!-- Chart Placeholder -->
        <div class="p-6">

            <div class="flex h-72 items-center justify-center rounded-xl border border-dashed border-gray-300 bg-gray-50 dark:border-gray-700 dark:bg-gray-900/50">

                <div class="text-center">

                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-brand-50 text-brand-500 dark:bg-brand-500/10">

                        <svg
                            class="h-7 w-7"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M4 19V5m0 14h16M7 15l3-4 3 2 5-7"
                            />
                        </svg>

                    </div>

                    <h3 class="mt-4 text-sm font-semibold text-gray-800 dark:text-white/90">
                        No click data available
                    </h3>

                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        Analytics data will appear here after your links receive clicks.
                    </p>

                </div>

            </div>

        </div>

    </div>


    <!-- Analytics Breakdown -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

        <!-- Devices -->
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">

                <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                    Devices
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    See which devices visitors use.
                </p>

            </div>


            <div class="p-6">

                <div class="flex h-48 items-center justify-center rounded-xl border border-dashed border-gray-300 bg-gray-50 dark:border-gray-700 dark:bg-gray-900/50">

                    <div class="text-center">

                        <svg
                            class="mx-auto h-10 w-10 text-gray-400"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M6 3h12a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Zm5 15h2"
                            />
                        </svg>

                        <p class="mt-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                            No device data
                        </p>

                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Mobile, desktop and tablet data will appear here.
                        </p>

                    </div>

                </div>

            </div>

        </div>


        <!-- Browsers -->
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">

                <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                    Browsers
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    See which browsers visitors use.
                </p>

            </div>


            <div class="p-6">

                <div class="flex h-48 items-center justify-center rounded-xl border border-dashed border-gray-300 bg-gray-50 dark:border-gray-700 dark:bg-gray-900/50">

                    <div class="text-center">

                        <svg
                            class="mx-auto h-10 w-10 text-gray-400"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M3 12a9 9 0 1 0 18 0H3Zm0 0a9 9 0 0 1 17.5-2.5M12 3v9m0 0 6 3"
                            />
                        </svg>

                        <p class="mt-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                            No browser data
                        </p>

                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Browser statistics will appear here.
                        </p>

                    </div>

                </div>

            </div>

        </div>


        <!-- Operating Systems -->
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">

                <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                    Operating Systems
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Understand visitor operating systems.
                </p>

            </div>


            <div class="p-6">

                <div class="flex h-48 items-center justify-center rounded-xl border border-dashed border-gray-300 bg-gray-50 dark:border-gray-700 dark:bg-gray-900/50">

                    <div class="text-center">

                        <svg
                            class="mx-auto h-10 w-10 text-gray-400"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M4 5h16v11H4zM8 21h8M12 16v5"
                            />
                        </svg>

                        <p class="mt-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                            No operating system data
                        </p>

                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Windows, macOS, Android, iOS and Linux data will appear here.
                        </p>

                    </div>

                </div>

            </div>

        </div>


        <!-- Countries -->
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">

                <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                    Countries
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    See where your visitors are located.
                </p>

            </div>


            <div class="p-6">

                <div class="flex h-48 items-center justify-center rounded-xl border border-dashed border-gray-300 bg-gray-50 dark:border-gray-700 dark:bg-gray-900/50">

                    <div class="text-center">

                        <svg
                            class="mx-auto h-10 w-10 text-gray-400"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M12 21s7-5.25 7-11a7 7 0 1 0-14 0c0 5.75 7 11 7 11Z"
                            />

                            <circle
                                cx="12"
                                cy="10"
                                r="2.5"
                                stroke-width="1.8"
                            />
                        </svg>

                        <p class="mt-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                            No country data
                        </p>

                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Visitor country information will appear here.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- Referrers -->
    <div class="mt-6 rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

        <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">

            <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                Top Referrers
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                See where visitors are coming from.
            </p>

        </div>


        <div class="p-6">

            <div class="flex h-36 items-center justify-center rounded-xl border border-dashed border-gray-300 bg-gray-50 dark:border-gray-700 dark:bg-gray-900/50">

                <div class="text-center">

                    <svg
                        class="mx-auto h-9 w-9 text-gray-400"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M13 5h6v6m0-6-8 8m-4-4H5a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2"
                        />
                    </svg>

                    <p class="mt-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                        No referrer data
                    </p>

                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        Referral sources will appear after your links receive visitors.
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection