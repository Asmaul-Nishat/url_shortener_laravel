@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-screen-2xl">

    {{-- ============================================================
         PAGE HEADER
    ============================================================= --}}

    <div class="mb-6">

        <h1 class="text-2xl font-bold text-gray-800 dark:text-white/90">
            Admin Dashboard
        </h1>

        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Monitor users, links, clicks, and anonymous platform activity.
        </p>

    </div>


    {{-- ============================================================
         SUCCESS MESSAGE
    ============================================================= --}}

    @if(session('success'))

        <div
            class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 dark:border-green-500/30 dark:bg-green-500/10 dark:text-green-400"
        >
            {{ session('success') }}
        </div>

    @endif


    {{-- ============================================================
         ERROR MESSAGE
    ============================================================= --}}

    @if(session('error'))

        <div
            class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 dark:border-red-500/30 dark:bg-red-500/10 dark:text-red-400"
        >
            {{ session('error') }}
        </div>

    @endif


    {{-- ============================================================
         MAIN SYSTEM STATISTICS
    ============================================================= --}}

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-5">


        {{-- Total Users --}}
        <div
            class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]"
        >

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Total Users
                    </p>

                    <h3 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">
                        {{ number_format($totalUsers) }}
                    </h3>

                </div>

                <div
                    class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400"
                >

                    <svg
                        class="h-6 w-6"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M17 20h5v-2a4 4 0 00-4-4h-1m-2-4a4 4 0 100-8 4 4 0 000 8zM3 20h10v-2a4 4 0 00-10 0v2zm5-10a4 4 0 100-8 4 4 0 000 8z"
                        />
                    </svg>

                </div>

            </div>

        </div>


        {{-- Total Links --}}
        <div
            class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]"
        >

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Total Links
                    </p>

                    <h3 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">
                        {{ number_format($totalLinks) }}
                    </h3>

                </div>

                <div
                    class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400"
                >

                    <svg
                        class="h-6 w-6"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M13.19 8.69l-7.5 7.5a2.25 2.25 0 103.182 3.182l7.5-7.5m-6.364-3.182l3.182-3.182a2.25 2.25 0 013.182 3.182l-3.182 3.182m-3.182-3.182l3.182 3.182"
                        />
                    </svg>

                </div>

            </div>

        </div>


        {{-- Total Clicks --}}
        <div
            class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]"
        >

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Total Clicks
                    </p>

                    <h3 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">
                        {{ number_format($totalClicks) }}
                    </h3>

                </div>

                <div
                    class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-50 text-purple-600 dark:bg-purple-500/10 dark:text-purple-400"
                >

                    <svg
                        class="h-6 w-6"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"
                        />
                    </svg>

                </div>

            </div>

        </div>


        {{-- Active Links --}}
        <div
            class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]"
        >

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Active Links
                    </p>

                    <h3 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">
                        {{ number_format($activeLinks) }}
                    </h3>

                </div>

                <div
                    class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-50 text-green-600 dark:bg-green-500/10 dark:text-green-400"
                >

                    <svg
                        class="h-6 w-6"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622C17.176 19.29 21 14.591 21 9c0-1.397-.238-2.74-.676-4.016z"
                        />
                    </svg>

                </div>

            </div>

        </div>


        {{-- Expired Links --}}
        <div
            class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]"
        >

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Expired Links
                    </p>

                    <h3 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">
                        {{ number_format($expiredLinks) }}
                    </h3>

                </div>

                <div
                    class="flex h-12 w-12 items-center justify-center rounded-xl bg-red-50 text-red-600 dark:bg-red-500/10 dark:text-red-400"
                >

                    <svg
                        class="h-6 w-6"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M12 9v3.75m0 3.75h.008M10.29 3.86l-8.01 13.5A1.75 1.75 0 003.79 20h16.42a1.75 1.75 0 001.5-2.64l-8.01-13.5a1.75 1.75 0 00-3.41 0z"
                        />
                    </svg>

                </div>

            </div>

        </div>

    </div>


    {{-- ============================================================
         ANONYMOUS GENERATION STATISTICS
    ============================================================= --}}

    <div class="mt-8">

        {{-- Section Header --}}
        <div class="mb-5">

            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
                Anonymous Generation Statistics
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Usage generated by visitors who are not logged in.
            </p>

        </div>


        {{-- ========================================================
             ALL-TIME ANONYMOUS STATISTICS
        ========================================================= --}}

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">


            {{-- Anonymous Short Links --}}
            <div
                class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]"
            >

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Anonymous Short Links
                        </p>

                        <h3 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">
                            {{ number_format($anonymousShortLinks) }}
                        </h3>

                    </div>

                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400"
                    >

                        <svg
                            class="h-6 w-6"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M13.19 8.69l-7.5 7.5a2.25 2.25 0 103.182 3.182l7.5-7.5m-6.364-3.182l3.182-3.182a2.25 2.25 0 013.182 3.182l-3.182 3.182m-3.182-3.182l3.182 3.182"
                            />
                        </svg>

                    </div>

                </div>

                <p class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                    Short links generated without an account
                </p>

            </div>


            {{-- Anonymous QR Codes --}}
            <div
                class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]"
            >

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Anonymous QR Codes
                        </p>

                        <h3 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">
                            {{ number_format($anonymousQrCodes) }}
                        </h3>

                    </div>

                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-50 text-purple-600 dark:bg-purple-500/10 dark:text-purple-400"
                    >

                        <svg
                            class="h-6 w-6"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M4 4h6v6H4V4zm10 0h6v6h-6V4zM4 14h6v6H4v-6zm10 1h2v2h-2v-2zm2 3h4v2h-4v-2zm0-4h4v2h-4v-2z"
                            />
                        </svg>

                    </div>

                </div>

                <p class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                    QR codes generated without an account
                </p>

            </div>


            {{-- Total Anonymous --}}
            <div
                class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]"
            >

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Total Anonymous Generations
                        </p>

                        <h3 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">
                            {{ number_format($totalAnonymousGenerations) }}
                        </h3>

                    </div>

                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-50 text-green-600 dark:bg-green-500/10 dark:text-green-400"
                    >

                        <svg
                            class="h-6 w-6"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622C17.176 19.29 21 14.591 21 9c0-1.397-.238-2.74-.676-4.016z"
                            />
                        </svg>

                    </div>

                </div>

                <p class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                    Anonymous short links and QR codes combined
                </p>

            </div>

        </div>


        {{-- ========================================================
             TIME-BASED ANONYMOUS STATISTICS
        ========================================================= --}}

        <div class="mt-6 grid grid-cols-1 gap-4 lg:grid-cols-3">


            {{-- TODAY --}}
            <div
                class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]"
            >

                <div class="flex items-center justify-between">

                    <div>

                        <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">
                            Today
                        </h3>

                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Anonymous activity today
                        </p>

                    </div>

                </div>


                <div class="mt-5 space-y-4">

                    {{-- Short Links --}}
                    <div class="flex items-center justify-between">

                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            Short Links
                        </span>

                        <span class="font-semibold text-gray-800 dark:text-white/90">
                            {{ number_format($anonymousShortLinksToday) }}
                        </span>

                    </div>


                    {{-- QR Codes --}}
                    <div class="flex items-center justify-between">

                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            QR Codes
                        </span>

                        <span class="font-semibold text-gray-800 dark:text-white/90">
                            {{ number_format($anonymousQrCodesToday) }}
                        </span>

                    </div>


                    {{-- Total --}}
                    <div class="border-t border-gray-100 pt-4 dark:border-gray-800">

                        <div class="flex items-center justify-between">

                            <span class="text-sm font-medium text-gray-600 dark:text-gray-300">
                                Total
                            </span>

                            <span class="text-lg font-bold text-gray-800 dark:text-white/90">
                                {{ number_format($totalAnonymousToday) }}
                            </span>

                        </div>

                    </div>

                </div>

            </div>


            {{-- THIS WEEK --}}
            <div
                class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]"
            >

                <div>

                    <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">
                        This Week
                    </h3>

                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        Anonymous activity this week
                    </p>

                </div>


                <div class="mt-5 space-y-4">

                    {{-- Short Links --}}
                    <div class="flex items-center justify-between">

                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            Short Links
                        </span>

                        <span class="font-semibold text-gray-800 dark:text-white/90">
                            {{ number_format($anonymousShortLinksThisWeek) }}
                        </span>

                    </div>


                    {{-- QR Codes --}}
                    <div class="flex items-center justify-between">

                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            QR Codes
                        </span>

                        <span class="font-semibold text-gray-800 dark:text-white/90">
                            {{ number_format($anonymousQrCodesThisWeek) }}
                        </span>

                    </div>


                    {{-- Total --}}
                    <div class="border-t border-gray-100 pt-4 dark:border-gray-800">

                        <div class="flex items-center justify-between">

                            <span class="text-sm font-medium text-gray-600 dark:text-gray-300">
                                Total
                            </span>

                            <span class="text-lg font-bold text-gray-800 dark:text-white/90">
                                {{ number_format($totalAnonymousThisWeek) }}
                            </span>

                        </div>

                    </div>

                </div>

            </div>


            {{-- THIS MONTH --}}
            <div
                class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]"
            >

                <div>

                    <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">
                        This Month
                    </h3>

                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        Anonymous activity this month
                    </p>

                </div>


                <div class="mt-5 space-y-4">

                    {{-- Short Links --}}
                    <div class="flex items-center justify-between">

                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            Short Links
                        </span>

                        <span class="font-semibold text-gray-800 dark:text-white/90">
                            {{ number_format($anonymousShortLinksThisMonth) }}
                        </span>

                    </div>


                    {{-- QR Codes --}}
                    <div class="flex items-center justify-between">

                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            QR Codes
                        </span>

                        <span class="font-semibold text-gray-800 dark:text-white/90">
                            {{ number_format($anonymousQrCodesThisMonth) }}
                        </span>

                    </div>


                    {{-- Total --}}
                    <div class="border-t border-gray-100 pt-4 dark:border-gray-800">

                        <div class="flex items-center justify-between">

                            <span class="text-sm font-medium text-gray-600 dark:text-gray-300">
                                Total
                            </span>

                            <span class="text-lg font-bold text-gray-800 dark:text-white/90">
                                {{ number_format($totalAnonymousThisMonth) }}
                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ============================================================
         RECENT USERS
    ============================================================= --}}

    <div class="mt-8">

        <div class="mb-5 flex items-center justify-between">

            <div>

                <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
                    Recent Users
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Recently registered users.
                </p>

            </div>

            <a
                href="{{ route('admin.users.index') }}"
                class="text-sm font-medium text-brand-600 hover:text-brand-700 dark:text-brand-400"
            >
                View All
            </a>

        </div>


        <div
            class="overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]"
        >

            <div class="overflow-x-auto">

                <table class="min-w-full">

                    <thead class="border-b border-gray-200 dark:border-gray-800">

                        <tr>

                            <th
                                class="px-5 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400"
                            >
                                User
                            </th>

                            <th
                                class="px-5 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400"
                            >
                                Email
                            </th>

                            <th
                                class="px-5 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400"
                            >
                                Role
                            </th>

                            <th
                                class="px-5 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400"
                            >
                                Status
                            </th>

                            <th
                                class="px-5 py-4 text-right text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400"
                            >
                                Action
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">

                        @forelse($recentUsers as $user)

                            <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02]">

                                <td class="px-5 py-4">

                                    <div class="flex items-center gap-3">

                                        <div
                                            class="flex h-9 w-9 items-center justify-center rounded-full bg-gray-100 text-sm font-semibold text-gray-600 dark:bg-gray-800 dark:text-gray-300"
                                        >
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>

                                        <div>

                                            <p class="font-medium text-gray-800 dark:text-white/90">
                                                {{ $user->name }}
                                            </p>

                                        </div>

                                    </div>

                                </td>


                                <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-400">
                                    {{ $user->email }}
                                </td>


                                <td class="px-5 py-4">

                                    @if($user->role === 'admin')

                                        <span
                                            class="inline-flex rounded-full bg-purple-50 px-2.5 py-1 text-xs font-medium text-purple-700 dark:bg-purple-500/10 dark:text-purple-400"
                                        >
                                            Admin
                                        </span>

                                    @else

                                        <span
                                            class="inline-flex rounded-full bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700 dark:bg-blue-500/10 dark:text-blue-400"
                                        >
                                            User
                                        </span>

                                    @endif

                                </td>


                                <td class="px-5 py-4">

                                    @if($user->status === 'active')

                                        <span
                                            class="inline-flex rounded-full bg-green-50 px-2.5 py-1 text-xs font-medium text-green-700 dark:bg-green-500/10 dark:text-green-400"
                                        >
                                            Active
                                        </span>

                                    @else

                                        <span
                                            class="inline-flex rounded-full bg-red-50 px-2.5 py-1 text-xs font-medium text-red-700 dark:bg-red-500/10 dark:text-red-400"
                                        >
                                            Inactive
                                        </span>

                                    @endif

                                </td>


                                <td class="px-5 py-4 text-right">

                                    <a
                                        href="{{ route('admin.users.show', $user) }}"
                                        class="text-sm font-medium text-brand-600 hover:text-brand-700 dark:text-brand-400"
                                    >
                                        View
                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="5"
                                    class="px-5 py-8 text-center text-sm text-gray-500 dark:text-gray-400"
                                >
                                    No users found.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    {{-- ============================================================
         RECENT LINKS
    ============================================================= --}}

    <div class="mt-8">

        <div class="mb-5 flex items-center justify-between">

            <div>

                <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
                    Recent Links
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Recently created short links across the system.
                </p>

            </div>

            <a
                href="{{ route('admin.links.index') }}"
                class="text-sm font-medium text-brand-600 hover:text-brand-700 dark:text-brand-400"
            >
                View All
            </a>

        </div>


        <div
            class="overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]"
        >

            <div class="overflow-x-auto">

                <table class="min-w-full">

                    <thead class="border-b border-gray-200 dark:border-gray-800">

                        <tr>

                            <th
                                class="px-5 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400"
                            >
                                Short URL
                            </th>

                            <th
                                class="px-5 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400"
                            >
                                Owner
                            </th>

                            <th
                                class="px-5 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400"
                            >
                                Clicks
                            </th>

                            <th
                                class="px-5 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400"
                            >
                                Status
                            </th>

                            <th
                                class="px-5 py-4 text-right text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400"
                            >
                                Action
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">

                        @forelse($recentLinks as $link)

                            <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02]">

                                <td class="px-5 py-4">

                                    <p class="font-medium text-gray-800 dark:text-white/90">
                                        {{ $link->custom_alias ?: $link->short_code }}
                                    </p>

                                    <p class="mt-1 max-w-xs truncate text-xs text-gray-500 dark:text-gray-400">
                                        {{ $link->original_url }}
                                    </p>

                                </td>


                                <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-400">

                                    {{ $link->user?->name ?? 'Unknown' }}

                                </td>


                                <td class="px-5 py-4 text-sm font-medium text-gray-800 dark:text-white/90">

                                    {{ number_format($link->click_count) }}

                                </td>


                                <td class="px-5 py-4">

                                    @if($link->isExpired())

                                        <span
                                            class="inline-flex rounded-full bg-red-50 px-2.5 py-1 text-xs font-medium text-red-700 dark:bg-red-500/10 dark:text-red-400"
                                        >
                                            Expired
                                        </span>

                                    @elseif($link->status === 'disabled')

                                        <span
                                            class="inline-flex rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-700 dark:bg-gray-800 dark:text-gray-300"
                                        >
                                            Disabled
                                        </span>

                                    @else

                                        <span
                                            class="inline-flex rounded-full bg-green-50 px-2.5 py-1 text-xs font-medium text-green-700 dark:bg-green-500/10 dark:text-green-400"
                                        >
                                            Active
                                        </span>

                                    @endif

                                </td>


                                <td class="px-5 py-4 text-right">

                                    <a
                                        href="{{ route('admin.links.show', $link) }}"
                                        class="text-sm font-medium text-brand-600 hover:text-brand-700 dark:text-brand-400"
                                    >
                                        View
                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="5"
                                    class="px-5 py-8 text-center text-sm text-gray-500 dark:text-gray-400"
                                >
                                    No links found.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    {{-- ============================================================
         QUICK ACTIONS
    ============================================================= --}}

    <div class="mt-8">

        <h2 class="mb-5 text-xl font-semibold text-gray-800 dark:text-white/90">
            Quick Actions
        </h2>


        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">


            {{-- Users --}}
            <a
                href="{{ route('admin.users.index') }}"
                class="rounded-2xl border border-gray-200 bg-white p-5 transition hover:border-brand-300 hover:shadow-sm dark:border-gray-800 dark:bg-white/[0.03] dark:hover:border-brand-500/50"
            >

                <p class="font-semibold text-gray-800 dark:text-white/90">
                    Manage Users
                </p>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    View and manage registered users.
                </p>

            </a>


            {{-- Links --}}
            <a
                href="{{ route('admin.links.index') }}"
                class="rounded-2xl border border-gray-200 bg-white p-5 transition hover:border-brand-300 hover:shadow-sm dark:border-gray-800 dark:bg-white/[0.03] dark:hover:border-brand-500/50"
            >

                <p class="font-semibold text-gray-800 dark:text-white/90">
                    Manage Links
                </p>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    View and manage all user links.
                </p>

            </a>


            {{-- Create Link --}}
            <a
                href="{{ route('admin.links.create') }}"
                class="rounded-2xl border border-gray-200 bg-white p-5 transition hover:border-brand-300 hover:shadow-sm dark:border-gray-800 dark:bg-white/[0.03] dark:hover:border-brand-500/50"
            >

                <p class="font-semibold text-gray-800 dark:text-white/90">
                    Create Link
                </p>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Create a short link for any user.
                </p>

            </a>


            {{-- Anonymous Activity --}}
            <div
                class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]"
            >

                <p class="font-semibold text-gray-800 dark:text-white/90">
                    Anonymous Activity
                </p>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Total anonymous generations.
                </p>

                <p class="mt-3 text-2xl font-bold text-gray-800 dark:text-white/90">
                    {{ number_format($totalAnonymousGenerations) }}
                </p>

            </div>

        </div>

    </div>

</div>

@endsection