@extends('layouts.app')

@section('content')

<div class="space-y-6">

    <!-- Page Header -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white/90">
                URL Shortener Dashboard
            </h1>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Create, manage and analyze your short links.
            </p>
        </div>

        <!-- Generate Short URL Button -->
        <a
            href="{{ url('/links/create') }}"
            class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-5 py-3 text-sm font-medium text-white shadow-theme-xs transition hover:bg-brand-600">

            <!-- Plus Icon -->
            <svg
                width="20"
                height="20"
                viewBox="0 0 20 20"
                fill="none"
                xmlns="http://www.w3.org/2000/svg">

                <path
                    d="M10 4.16669V15.8334M4.16669 10H15.8334"
                    stroke="currentColor"
                    stroke-width="1.5"
                    stroke-linecap="round"
                    stroke-linejoin="round" />

            </svg>

            Generate Short URL
        </a>

    </div>


    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        <!-- Total Links -->
        <div
            class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Total Links
                    </p>

                    <h3 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">
                        {{ $totalLinks }}
                    </h3>
                </div>

                <div
                    class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 text-gray-700 dark:bg-white/[0.05] dark:text-gray-300">

                    <svg
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg">

                        <path
                            d="M10 13C10.4295 13.5741 10.9854 14.0429 11.6234 14.3682C12.2614 14.6935 12.9669 14.864 13.6833 14.864C14.3997 14.864 15.1052 14.6935 15.7432 14.3682C16.3812 14.0429 16.9371 13.5741 17.3667 13L18.3667 12C19.1243 11.2424 19.5501 10.2148 19.5501 9.14333C19.5501 8.07187 19.1243 7.04424 18.3667 6.28667C17.6091 5.52909 16.5815 5.10327 15.51 5.10327C14.4385 5.10327 13.4109 5.52909 12.6533 6.28667L11.08 7.86"
                            stroke="currentColor"
                            stroke-width="1.5"
                            stroke-linecap="round"
                            stroke-linejoin="round" />

                        <path
                            d="M14 11C13.5705 10.4259 13.0146 9.9571 12.3766 9.63181C11.7386 9.30652 11.0331 9.13603 10.3167 9.13603C9.60032 9.13603 8.89483 9.30652 8.25676 9.63181C7.61869 9.9571 7.06282 10.4259 6.63333 11L5.63333 12C4.87576 12.7576 4.44995 13.7851 5.63333 17.7133C6.39091 18.4709 7.41853 18.8967 8.49 18.8967C9.56147 18.8967 10.5891 18.4709 11.3467 17.7133L12.92 16.14"
                            stroke="currentColor"
                            stroke-width="1.5"
                            stroke-linecap="round"
                            stroke-linejoin="round" />

                    </svg>

                </div>

            </div>

        </div>


        <!-- Total Clicks -->
        <div
            class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Total Clicks
                    </p>

                    <h3 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">
                        {{ $totalClicks }}
                    </h3>
                </div>

                <div
                    class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 text-gray-700 dark:bg-white/[0.05] dark:text-gray-300">

                    <svg
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg">

                        <path
                            d="M4 19V5"
                            stroke="currentColor"
                            stroke-width="1.5"
                            stroke-linecap="round" />

                        <path
                            d="M4 19H20"
                            stroke="currentColor"
                            stroke-width="1.5"
                            stroke-linecap="round" />

                        <path
                            d="M7 15L10 11L13 13L18 7"
                            stroke="currentColor"
                            stroke-width="1.5"
                            stroke-linecap="round"
                            stroke-linejoin="round" />

                    </svg>

                </div>

            </div>

        </div>


        <!-- Active Links -->
        <div
            class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Active Links
                    </p>

                    <h3 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">
                        {{ $activeLinks }}
                    </h3>
                </div>

                <div
                    class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 text-gray-700 dark:bg-white/[0.05] dark:text-gray-300">

                    <svg
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg">

                        <path
                            d="M12 3.5C7.30558 3.5 3.5 7.30558 3.5 12C3.5 16.6944 7.30558 20.5 12 20.5C16.6944 20.5 20.5 16.6944 20.5 12C20.5 7.30558 16.6944 3.5 12 3.5Z"
                            stroke="currentColor"
                            stroke-width="1.5" />

                        <path
                            d="M8.5 12L10.75 14.25L15.5 9.5"
                            stroke="currentColor"
                            stroke-width="1.5"
                            stroke-linecap="round"
                            stroke-linejoin="round" />

                    </svg>

                </div>

            </div>

        </div>


        <!-- Expired Links -->
        <div
            class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Expired Links
                    </p>

                    <h3 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">
                        {{ $expiredLinks }}
                    </h3>
                </div>

                <div
                    class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 text-gray-700 dark:bg-white/[0.05] dark:text-gray-300">

                    <svg
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg">

                        <path
                            d="M12 8V12L14.5 14.5"
                            stroke="currentColor"
                            stroke-width="1.5"
                            stroke-linecap="round"
                            stroke-linejoin="round" />

                        <path
                            d="M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21Z"
                            stroke="currentColor"
                            stroke-width="1.5" />

                    </svg>

                </div>

            </div>

        </div>

    </div>

<!-- Main Dashboard Content -->
<div class="space-y-6">

    <!-- Click Analytics -->
    <div
        class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">

        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                    Click Analytics
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Track clicks on your short links over time.
                </p>
            </div>

            <select
                class="h-10 rounded-lg border border-gray-200 bg-white px-3 text-sm text-gray-700 outline-none dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300">

                <option>Last 7 Days</option>
                <option>Last 30 Days</option>
                <option>Last 90 Days</option>

            </select>

        </div>


        <!-- Analytics -->
        <div class="mt-6">

            @if($totalClicks > 0)

                <div class="h-72 w-full">

                    <div class="flex h-full items-end justify-between gap-2">

                        @php
                            $maxClicks = max($analyticsData);
                        @endphp

                        @foreach($analyticsData as $index => $clicks)

                            @php
                                $height = $maxClicks > 0
                                    ? max(8, ($clicks / $maxClicks) * 100)
                                    : 8;
                            @endphp

                            <div
                                class="flex h-full flex-1 flex-col items-center justify-end gap-2">

                                <div class="flex h-full w-full items-end justify-center">

                                    <div
                                        class="w-full max-w-10 rounded-t-md bg-brand-500 transition-all"
                                        style="height: {{ $height }}%;"
                                        title="{{ $clicks }} clicks">
                                    </div>

                                </div>

                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $analyticsLabels[$index] }}
                                </span>

                            </div>

                        @endforeach

                    </div>

                </div>

            @else

                <div
                    class="flex h-72 items-center justify-center rounded-xl border border-dashed border-gray-200 bg-gray-50 dark:border-gray-800 dark:bg-white/[0.02]">

                    <div class="text-center">

                        <div
                            class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-gray-100 text-gray-500 dark:bg-white/[0.05] dark:text-gray-400">

                            <svg
                                width="28"
                                height="28"
                                viewBox="0 0 24 24"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg">

                                <path
                                    d="M4 19V5"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                    stroke-linecap="round" />

                                <path
                                    d="M4 19H20"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                    stroke-linecap="round" />

                                <path
                                    d="M7 15L10 11L13 13L18 7"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                    stroke-linecap="round"
                                    stroke-linejoin="round" />

                            </svg>

                        </div>

                        <p class="mt-4 text-sm font-medium text-gray-700 dark:text-gray-300">
                            No click data available
                        </p>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Analytics will appear here after your links receive clicks.
                        </p>

                    </div>

                </div>

            @endif

        </div>

    </div>


    <!-- Recent Links -->
    <div
        class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">

        <div class="flex items-center justify-between">

            <div>
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                    Recent Links
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Your latest short links.
                </p>
            </div>

            <a
                href="{{ url('/links') }}"
                class="text-sm font-medium text-brand-500 hover:text-brand-600">
                View All
            </a>

        </div>


        @forelse($recentLinks as $link)

            @php
                $shortCode = $link->custom_alias ?: $link->short_code;
                $isExpired = $link->isExpired();
            @endphp

            <div
                class="border-b border-gray-100 py-4 last:border-b-0 dark:border-gray-800">

                <p
                    class="truncate text-sm font-medium text-gray-800 dark:text-white/90"
                    title="{{ $link->original_url }}">

                    {{ $link->original_url }}

                </p>

                <div class="mt-2 flex items-center justify-between gap-3">

                    <p
                        class="truncate text-xs text-gray-500 dark:text-gray-400"
                        title="{{ $link->short_url }}">

                        /{{ $shortCode }}

                    </p>

                    <span
                        class="shrink-0 rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-600 dark:bg-white/[0.05] dark:text-gray-400">

                        {{ $link->click_count }}
                        {{ $link->click_count == 1 ? 'click' : 'clicks' }}

                    </span>

                </div>

                <div class="mt-2 flex items-center justify-between">

                    @if($isExpired)

                        <span class="text-xs font-medium text-red-500">
                            Expired
                        </span>

                    @else

                        <span class="text-xs font-medium text-green-500">
                            Active
                        </span>

                    @endif

                    @if($link->expires_at)

                        <span class="text-xs text-gray-400">
                            Expires {{ $link->expires_at->format('M d, Y') }}
                        </span>

                    @endif

                </div>

            </div>

        @empty

            <div class="py-10 text-center">

                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                    No links yet
                </p>

                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    Create your first short URL to see it here.
                </p>

            </div>

        @endforelse

    </div>

</div>


@endsection
