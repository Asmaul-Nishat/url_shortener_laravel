@extends('layouts.app')

@section('content')

<div class="space-y-6">

    {{-- =========================================================
        Page Header
    ========================================================== --}}

    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white/90">
                Admin Dashboard
            </h1>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Monitor and manage your entire URL Shortener platform.
            </p>
        </div>

        {{-- Admin Badge --}}

        <div
            class="inline-flex w-fit items-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] dark:text-gray-300">

            <svg
                width="18"
                height="18"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg">

                <path
                    d="M12 3L20 6V11C20 16.25 16.5 20.5 12 21C7.5 20.5 4 16.25 4 11V6L12 3Z"
                    stroke="currentColor"
                    stroke-width="1.5"
                    stroke-linecap="round"
                    stroke-linejoin="round" />

                <path
                    d="M9 12L11 14L15 10"
                    stroke="currentColor"
                    stroke-width="1.5"
                    stroke-linecap="round"
                    stroke-linejoin="round" />

            </svg>

            Administrator
        </div>

    </div>


    {{-- =========================================================
        Statistics Cards
    ========================================================== --}}

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-5">

        {{-- Total Users --}}

        <div
            class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Total Users
                    </p>

                    <h3 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">
                        {{ $totalUsers }}
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
                            d="M16 21V19C16 16.7909 14.2091 15 12 15H6C3.79086 15 2 16.7909 2 19V21"
                            stroke="currentColor"
                            stroke-width="1.5"
                            stroke-linecap="round"
                            stroke-linejoin="round" />

                        <circle
                            cx="9"
                            cy="7"
                            r="4"
                            stroke="currentColor"
                            stroke-width="1.5" />

                        <path
                            d="M22 21V19C21.9999 17.1771 20.765 15.5857 19 15.13"
                            stroke="currentColor"
                            stroke-width="1.5"
                            stroke-linecap="round" />

                        <path
                            d="M16 3.13C17.7699 3.58317 19.0098 5.17799 19.0098 7C19.0098 8.82201 17.7699 10.4168 16 10.87"
                            stroke="currentColor"
                            stroke-width="1.5"
                            stroke-linecap="round" />

                    </svg>

                </div>

            </div>

        </div>


        {{-- Total Links --}}

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
                            d="M10 13C10.4295 13.5741 10.9854 13.0429 11.6234 13.3682C12.2614 13.6935 12.9669 13.864 13.6833 13.864C14.3997 13.864 15.1052 13.6935 15.7432 13.3682C16.3812 13.0429 16.9371 12.5741 17.3667 12L18.3667 11C19.1243 10.2424 19.5501 9.2148 19.5501 8.14333C19.5501 7.07187 19.1243 6.04424 18.3667 5.28667C17.6091 4.52909 16.5815 4.10327 15.51 4.10327C14.4385 4.10327 13.4109 4.52909 12.6533 5.28667L11.08 6.86"
                            stroke="currentColor"
                            stroke-width="1.5"
                            stroke-linecap="round"
                            stroke-linejoin="round" />

                        <path
                            d="M14 10C13.5705 9.4259 13.0146 8.9571 12.3766 8.63181C11.7386 8.30652 11.0331 8.13603 10.3167 8.13603C9.60032 8.13603 8.89483 8.30652 8.25676 8.63181C7.61869 8.9571 7.06282 9.4259 6.63333 10L5.63333 11C4.87576 11.7576 4.44995 12.7851 4.44995 13.8567C4.44995 14.9281 4.87576 15.9557 5.63333 16.7133C6.39091 17.4709 7.41853 17.8967 8.49 17.8967C9.56147 17.8967 10.5891 17.4709 11.3467 16.7133L12.92 15.14"
                            stroke="currentColor"
                            stroke-width="1.5"
                            stroke-linecap="round"
                            stroke-linejoin="round" />

                    </svg>

                </div>

            </div>

        </div>


        {{-- Total Clicks --}}

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


        {{-- Active Links --}}

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


        {{-- Expired Links --}}

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


    {{-- =========================================================
        Recent Users + Recent Links
    ========================================================== --}}

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">

        {{-- Recent Users --}}

        <div
            class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="flex items-center justify-between">

                <div>
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                        Recent Users
                    </h2>

                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Recently registered users.
                    </p>
                </div>

            </div>


            <div class="mt-5">

                @forelse($recentUsers as $user)

                    <div
                        class="flex items-center justify-between gap-4 border-b border-gray-100 py-4 last:border-b-0 dark:border-gray-800">

                        <div class="min-w-0">

                            <p class="truncate text-sm font-medium text-gray-800 dark:text-white/90">
                                {{ $user->name }}
                            </p>

                            <p class="mt-1 truncate text-xs text-gray-500 dark:text-gray-400">
                                {{ $user->email }}
                            </p>

                        </div>


                        <div class="shrink-0">

                            @if($user->role === 'admin')

                                <span
                                    class="rounded-full bg-brand-50 px-2.5 py-1 text-xs font-medium text-brand-600 dark:bg-brand-500/10 dark:text-brand-400">
                                    Admin
                                </span>

                            @else

                                <span
                                    class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-600 dark:bg-white/[0.05] dark:text-gray-400">
                                    User
                                </span>

                            @endif

                        </div>

                    </div>

                @empty

                    <div class="py-10 text-center">

                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                            No users found
                        </p>

                    </div>

                @endforelse

            </div>

        </div>


        {{-- Recent Links --}}

        <div
            class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="flex items-center justify-between">

                <div>
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                        Recent Links
                    </h2>

                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Recently created links across all users.
                    </p>
                </div>

            </div>


            <div class="mt-5">

                @forelse($recentLinks as $link)

                    @php
                        $shortCode = $link->custom_alias ?: $link->short_code;
                        $isExpired = $link->isExpired();
                    @endphp

                    <div
                        class="border-b border-gray-100 py-4 last:border-b-0 dark:border-gray-800">

                        <div class="flex items-start justify-between gap-4">

                            <div class="min-w-0">

                                <p
                                    class="truncate text-sm font-medium text-gray-800 dark:text-white/90"
                                    title="{{ $link->original_url }}">

                                    {{ $link->original_url }}

                                </p>

                                <p
                                    class="mt-1 truncate text-xs text-gray-500 dark:text-gray-400"
                                    title="{{ $link->short_url }}">

                                    /{{ $shortCode }}

                                </p>

                                <p class="mt-1 text-xs text-gray-400">

                                    Owner:
                                    {{ $link->user?->name ?? 'Unknown' }}

                                </p>

                            </div>


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

                                    Expires
                                    {{ $link->expires_at->format('M d, Y') }}

                                </span>

                            @endif

                        </div>

                    </div>

                @empty

                    <div class="py-10 text-center">

                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                            No links found
                        </p>

                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Links created by users will appear here.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>

    </div>


    {{-- =========================================================
        Admin Quick Actions
    ========================================================== --}}

    <div
        class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">

        <div>

            <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                Quick Actions
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Manage the platform from one place.
            </p>

        </div>


        <div class="mt-5 grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4">

            <a
                href="{{ url('/links') }}"
                class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-3 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-800 dark:bg-white/[0.03] dark:text-gray-300 dark:hover:bg-white/[0.05]">

                Manage Links

            </a>


            <a
                href="{{ url('/analytics') }}"
                class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-3 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-800 dark:bg-white/[0.03] dark:text-gray-300 dark:hover:bg-white/[0.05]">

                View Analytics

            </a>


            <a
                href="{{ url('/reports') }}"
                class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-3 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-800 dark:bg-white/[0.03] dark:text-gray-300 dark:hover:bg-white/[0.05]">

                Reports

            </a>


            <a
                href="{{ url('/activity-logs') }}"
                class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-3 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-800 dark:bg-white/[0.03] dark:text-gray-300 dark:hover:bg-white/[0.05]">

                Activity Logs

            </a>

        </div>

    </div>

</div>

@endsection