@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-7xl">

    {{-- ============================================================
        PAGE HEADER
    ============================================================ --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>

            <h1 class="text-2xl font-bold text-gray-800 dark:text-white/90">
                All Reports
            </h1>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                View and manage all generated reports.
            </p>

        </div>


        <div>

            <a
                href="{{ route('admin.reports') }}"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-brand-600"
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

            </a>

        </div>

    </div>


    {{-- ============================================================
        FILTER BY USER
    ============================================================ --}}
    <div class="mb-6 rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

        <form
            method="GET"
            action="{{ route('admin.reports.all') }}"
        >

            <div class="flex flex-col gap-4 lg:flex-row lg:items-end">

                {{-- User --}}
                <div class="w-full lg:max-w-md">

                    <label
                        for="user_id"
                        class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                    >
                        Filter by User
                    </label>


                    <select
                        id="user_id"
                        name="user_id"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-white px-4 text-sm text-gray-700 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                    >

                        <option value="">
                            All Users
                        </option>


                        @foreach($users as $user)

                            <option
                                value="{{ $user->id }}"
                                @selected(
                                    (string) $userId ===
                                    (string) $user->id
                                )
                            >
                                {{ $user->name }} — {{ $user->email }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- Filter --}}
                <button
                    type="submit"
                    class="inline-flex h-11 items-center justify-center gap-2 rounded-lg bg-brand-500 px-5 text-sm font-medium text-white transition hover:bg-brand-600"
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
                            d="M3 5h18M6 12h12M10 19h4"
                        />
                    </svg>

                    Filter

                </button>


                {{-- Clear Filter --}}
                @if($userId)

                    <a
                        href="{{ route('admin.reports.all') }}"
                        class="inline-flex h-11 items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-transparent dark:text-gray-300 dark:hover:bg-white/5"
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
                                d="M6 6l12 12M18 6L6 18"
                            />
                        </svg>

                        Clear Filter

                    </a>

                @endif

            </div>

        </form>

    </div>


    {{-- ============================================================
        ACTIVE FILTER
    ============================================================ --}}
    @if($userId)

        @php
            $selectedUser = $users->firstWhere(
                'id',
                (int) $userId
            );
        @endphp

        @if($selectedUser)

            <div class="mb-6 flex items-center gap-3 rounded-xl border border-brand-200 bg-brand-50 px-4 py-3 dark:border-brand-500/20 dark:bg-brand-500/10">

                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-brand-100 text-brand-600 dark:bg-brand-500/20 dark:text-brand-400">

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
                            d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"
                        />

                        <circle
                            cx="9"
                            cy="7"
                            r="4"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M22 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"
                        />
                    </svg>

                </div>


                <div class="min-w-0">

                    <p class="text-xs font-medium text-brand-600 dark:text-brand-400">
                        Showing reports for
                    </p>

                    <p class="truncate text-sm font-semibold text-brand-700 dark:text-brand-300">
                        {{ $selectedUser->name }}
                        <span class="font-normal">
                            — {{ $selectedUser->email }}
                        </span>
                    </p>

                </div>

            </div>

        @endif

    @endif


    {{-- ============================================================
        SUCCESS / ERROR NOTIFICATIONS
    ============================================================ --}}
    @if(session('success') || session('error') || $errors->any())

        <div class="mb-6">

            @if(session('success'))

                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    class="relative overflow-hidden rounded-2xl border border-green-200 bg-green-50 px-5 py-4 dark:border-green-500/20 dark:bg-green-500/10"
                >

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-green-100 text-green-600 dark:bg-green-500/20 dark:text-green-400">

                            <svg
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M5 13l4 4L19 7"
                                />
                            </svg>

                        </div>


                        <div class="min-w-0 flex-1">

                            <p class="text-sm font-semibold text-green-800 dark:text-green-300">
                                Success
                            </p>

                            <p class="mt-0.5 text-sm text-green-700 dark:text-green-400">
                                {{ session('success') }}
                            </p>

                        </div>


                        <button
                            type="button"
                            @click="show = false"
                            class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg text-green-600 transition hover:bg-green-100 dark:text-green-400 dark:hover:bg-green-500/20"
                        >

                            <svg
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>

                        </button>

                    </div>

                </div>

            @endif


            @if(session('error'))

                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    class="relative overflow-hidden rounded-2xl border border-red-200 bg-red-50 px-5 py-4 dark:border-red-500/20 dark:bg-red-500/10"
                >

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-red-100 text-red-600 dark:bg-red-500/20 dark:text-red-400">

                            <svg
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 9v4m0 4h.01M10.29 3.86l-8.2 14A2 2 0 003.82 21h16.36a2 2 0 001.73-3.14l-8.2-14a2 2 0 00-3.42 0z"
                                />
                            </svg>

                        </div>


                        <div class="min-w-0 flex-1">

                            <p class="text-sm font-semibold text-red-800 dark:text-red-300">
                                Error
                            </p>

                            <p class="mt-0.5 text-sm text-red-700 dark:text-red-400">
                                {{ session('error') }}
                            </p>

                        </div>


                        <button
                            type="button"
                            @click="show = false"
                            class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg text-red-600 transition hover:bg-red-100 dark:text-red-400 dark:hover:bg-red-500/20"
                        >

                            <svg
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>

                        </button>

                    </div>

                </div>

            @endif


            @if($errors->any())

                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    class="relative mt-3 overflow-hidden rounded-2xl border border-red-200 bg-red-50 px-5 py-4 dark:border-red-500/20 dark:bg-red-500/10"
                >

                    <div class="flex items-start gap-3">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-red-100 text-red-600 dark:bg-red-500/20 dark:text-red-400">

                            <svg
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 9v4m0 4h.01M10.29 3.86l-8.2 14A2 2 0 003.82 21h16.36a2 2 0 001.73-3.14l-8.2-14a2 2 0 00-3.42 0z"
                                />
                            </svg>

                        </div>


                        <div class="min-w-0 flex-1">

                            <p class="text-sm font-semibold text-red-800 dark:text-red-300">
                                Please check the following:
                            </p>


                            <ul class="mt-1 list-disc pl-5 text-sm text-red-700 dark:text-red-400">

                                @foreach($errors->all() as $error)

                                    <li>
                                        {{ $error }}
                                    </li>

                                @endforeach

                            </ul>

                        </div>


                        <button
                            type="button"
                            @click="show = false"
                            class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg text-red-600 transition hover:bg-red-100 dark:text-red-400 dark:hover:bg-red-500/20"
                        >

                            <svg
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>

                        </button>

                    </div>

                </div>

            @endif

        </div>

    @endif


    {{-- ============================================================
        SUMMARY CARDS
    ============================================================ --}}
    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        {{-- Total Reports --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Total Reports
                    </p>

                    <h3 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">
                        {{ number_format($totalReports) }}
                    </h3>

                </div>


                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-brand-50 text-brand-500 dark:bg-brand-500/10">

                    <svg
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.7"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6 3.75h8.5L19 8.25v12H6v-16.5z"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M14 3.75v4.5h5"
                        />

                        <path
                            stroke-linecap="round"
                            d="M9 12h6M9 15h6M9 18h3"
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
                        {{ number_format($pdfReports) }}
                    </h3>

                </div>


                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-red-50 text-red-500 dark:bg-red-500/10">

                    <svg
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.7"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6 3.75h8.5L19 8.25v12H6v-16.5z"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M14 3.75v4.5h5"
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
                        {{ number_format($csvReports) }}
                    </h3>

                </div>


                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-50 text-green-600 dark:bg-green-500/10">

                    <svg
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.7"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6 3.75h8.5L19 8.25v12H6v-16.5z"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M14 3.75v4.5h5"
                        />

                    </svg>

                </div>

            </div>

        </div>


        {{-- Total Clicks --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Total Clicks
                    </p>

                    <h3 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">
                        {{ number_format($totalClicks) }}
                    </h3>

                </div>


                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/10">

                    <svg
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.7"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M4 19V5"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M4 19h16"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M7 15l4-4 3 3 5-7"
                        />

                    </svg>

                </div>

            </div>

        </div>

    </div>


    {{-- ============================================================
        REPORTS TABLE
    ============================================================ --}}
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

        {{-- Table Header --}}
        <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                <div>

                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                        Generated Reports
                    </h2>

                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        All reports generated by administrators.
                    </p>

                </div>


                @if($reports->total() > 0)

                    <span class="inline-flex w-fit items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600 dark:bg-white/5 dark:text-gray-300">

                        {{ $reports->total() }}

                        {{ $reports->total() === 1
                            ? 'Report'
                            : 'Reports'
                        }}

                    </span>

                @endif

            </div>

        </div>


        @if($reports->count())

            <div class="overflow-x-auto">

                <table class="w-full min-w-[1050px]">

                    <thead>

                        <tr class="border-b border-gray-200 bg-gray-50 dark:border-gray-800 dark:bg-white/[0.02]">

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Report
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                User
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Type
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Date Range
                            </th>

                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Format
                            </th>

                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Clicks
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Created
                            </th>

                            <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-gray-200 dark:divide-gray-800">

                        @foreach($reports as $report)

                            <tr class="transition hover:bg-gray-50 dark:hover:bg-white/[0.02]">

                                {{-- Report --}}
                                <td class="px-6 py-4">

                                    <div class="flex min-w-[220px] items-center gap-3">

                                        <div
                                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg
                                            {{
                                                strtoupper($report->format) === 'PDF'
                                                    ? 'bg-red-50 text-red-500 dark:bg-red-500/10 dark:text-red-400'
                                                    : 'bg-green-50 text-green-600 dark:bg-green-500/10 dark:text-green-400'
                                            }}"
                                        >

                                            @if(strtoupper($report->format) === 'PDF')

                                                <svg
                                                    class="h-5 w-5"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor"
                                                    stroke-width="1.7"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M6 3.75h8.5L19 8.25v12H6v-16.5z"
                                                    />

                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M14 3.75v4.5h5"
                                                    />
                                                </svg>

                                            @else

                                                <svg
                                                    class="h-5 w-5"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor"
                                                    stroke-width="1.7"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M7 4h10M7 8h10M7 12h10M7 16h6"
                                                    />

                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M5 2.75h14c.69 0 1.25.56 1.25 1.25v16c0 .69-.56 1.25-1.25 1.25H5c-.69 0-1.25-.56-1.25-1.25V4c0-.69.56-1.25 1.25-1.25z"
                                                    />
                                                </svg>

                                            @endif

                                        </div>


                                        <div class="min-w-0">

                                            <p
                                                class="max-w-[260px] truncate text-sm font-semibold text-gray-800 dark:text-white/90"
                                                title="{{ $report->name }}"
                                            >
                                                {{ $report->name }}
                                            </p>


                                            @if($report->shortUrl)

                                                <p
                                                    class="mt-1 max-w-[260px] truncate text-xs text-gray-500 dark:text-gray-400"
                                                    title="{{ $report->shortUrl->original_url }}"
                                                >
                                                    /
                                                    {{ $report->shortUrl->custom_alias ?: $report->shortUrl->short_code }}
                                                </p>

                                            @else

                                                <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">
                                                    All links
                                                </p>

                                            @endif

                                        </div>

                                    </div>

                                </td>


                                {{-- User --}}
                                <td class="px-6 py-4">

                                    @if($report->user)

                                        <div class="min-w-[150px]">

                                            <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                                                {{ $report->user->name }}
                                            </p>

                                            <p class="mt-1 max-w-[180px] truncate text-xs text-gray-500 dark:text-gray-400">
                                                {{ $report->user->email }}
                                            </p>

                                        </div>

                                    @else

                                        <span class="text-sm text-gray-400">
                                            —
                                        </span>

                                    @endif

                                </td>


                                {{-- Type --}}
                                <td class="px-6 py-4">

                                    <span class="inline-flex max-w-[180px] rounded-full bg-brand-50 px-3 py-1 text-xs font-medium text-brand-600 dark:bg-brand-500/10 dark:text-brand-400">

                                        {{ $report->type }}

                                    </span>

                                </td>


                                {{-- Date Range --}}
                                <td class="px-6 py-4">

                                    <div class="min-w-[130px]">

                                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                            {{ $report->date_range }}
                                        </p>


                                        @if($report->start_date && $report->end_date)

                                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">

                                                {{ $report->start_date->format('M d, Y') }}

                                                –

                                                {{ $report->end_date->format('M d, Y') }}

                                            </p>

                                        @endif

                                    </div>

                                </td>


                                {{-- Format --}}
                                <td class="px-6 py-4 text-center">

                                    @if(strtoupper($report->format) === 'PDF')

                                        <span class="inline-flex items-center rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-600 dark:bg-red-500/10 dark:text-red-400">
                                            PDF
                                        </span>

                                    @else

                                        <span class="inline-flex items-center rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-600 dark:bg-green-500/10 dark:text-green-400">
                                            CSV
                                        </span>

                                    @endif

                                </td>


                                {{-- Clicks --}}
                                <td class="px-6 py-4 text-center">

                                    <span class="text-sm font-semibold text-gray-800 dark:text-white/90">
                                        {{ number_format($report->total_clicks ?? 0) }}
                                    </span>

                                </td>


                                {{-- Created --}}
                                <td class="px-6 py-4">

                                    <div class="min-w-[120px]">

                                        <p class="text-sm text-gray-700 dark:text-gray-300">
                                            {{ $report->created_at->format('M d, Y') }}
                                        </p>

                                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                            {{ $report->created_at->format('h:i A') }}
                                        </p>

                                    </div>

                                </td>


                                {{-- Actions --}}
                                <td class="px-6 py-4">

                                    <div class="flex items-center justify-end gap-2">

                                        {{-- Download --}}
                                        <a
                                            href="{{ route('admin.reports.download', $report) }}"
                                            title="Download report"
                                            class="inline-flex h-9 items-center justify-center gap-1.5 rounded-lg bg-brand-500 px-3 text-xs font-medium text-white transition hover:bg-brand-600"
                                        >

                                            <svg
                                                class="h-4 w-4"
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

                                            Download

                                        </a>


                                        {{-- Delete --}}
                                        <form
                                            method="POST"
                                            action="{{ route('admin.reports.destroy', $report) }}"
                                            onsubmit="return confirm('Are you sure you want to delete this report? This action cannot be undone.');"
                                        >

                                            @csrf

                                            @method('DELETE')


                                            <button
                                                type="submit"
                                                title="Delete report"
                                                class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-red-200 text-red-500 transition hover:bg-red-50 dark:border-red-500/20 dark:text-red-400 dark:hover:bg-red-500/10"
                                            >

                                                <svg
                                                    class="h-4 w-4"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor"
                                                    stroke-width="1.8"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M6 7h12M9 7V4.5h6V7m-8 0l.75 12.25h8.5L17 7M10 10.5v5.5M14 10.5v5.5"
                                                    />
                                                </svg>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            {{-- ====================================================
                PAGINATION
            ===================================================== --}}
            @if($reports->hasPages())

                <div class="border-t border-gray-200 px-6 py-4 dark:border-gray-800">

                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                        <p class="text-sm text-gray-500 dark:text-gray-400">

                            Showing

                            <span class="font-medium text-gray-700 dark:text-gray-300">
                                {{ $reports->firstItem() }}
                            </span>

                            to

                            <span class="font-medium text-gray-700 dark:text-gray-300">
                                {{ $reports->lastItem() }}
                            </span>

                            of

                            <span class="font-medium text-gray-700 dark:text-gray-300">
                                {{ $reports->total() }}
                            </span>

                            reports

                        </p>


                        <div>
                            {{ $reports->links() }}
                        </div>

                    </div>

                </div>

            @endif


        @else

            {{-- ====================================================
                EMPTY STATE
            ===================================================== --}}
            <div class="px-6 py-16">

                <div class="mx-auto flex max-w-md flex-col items-center text-center">

                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gray-100 text-gray-500 dark:bg-white/5 dark:text-gray-400">

                        <svg
                            class="h-8 w-8"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.5"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6 3.75h8.5L19 8.25v12H6v-16.5z"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M14 3.75v4.5h5"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M9 12h6M9 15h6M9 18h3"
                            />
                        </svg>

                    </div>


                    <h3 class="mt-5 text-lg font-semibold text-gray-800 dark:text-white/90">

                        @if($userId)
                            No reports found for this user.
                        @else
                            No reports found.
                        @endif

                    </h3>


                    <p class="mt-2 text-sm leading-6 text-gray-500 dark:text-gray-400">

                        @if($userId)
                            This user has no generated reports yet.
                        @else
                            No reports have been generated yet. Generate your first report to see it here.
                        @endif

                    </p>


                    @if($userId)

                        <a
                            href="{{ route('admin.reports.all') }}"
                            class="mt-6 inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-transparent dark:text-gray-300 dark:hover:bg-white/5"
                        >

                            Clear Filter

                        </a>

                    @else

                        <a
                            href="{{ route('admin.reports') }}"
                            class="mt-6 inline-flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-brand-600"
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

                        </a>

                    @endif

                </div>

            </div>

        @endif

    </div>

</div>

@endsection