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
     PAGE HEADER
============================================================= --}}
<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

    <div>

        <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">
            Activity Logs
        </h1>

        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Monitor important actions performed by users and administrators.
        </p>

    </div>


    <div class="flex items-center gap-3">

        <a
            href="{{ route('activity-logs.export') }}"
            class="inline-flex items-center justify-center gap-2 rounded-lg bg-gray-800 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-gray-700 dark:bg-white dark:text-gray-800 dark:hover:bg-gray-100"
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

            Export Logs

        </a>

    </div>

</div>


{{-- ============================================================
     SUMMARY CARDS
============================================================= --}}
<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">


    {{-- Total Activities --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Total Activities
                </p>

                <h3 class="mt-2 text-2xl font-semibold text-gray-800 dark:text-white">
                    {{ number_format($totalActivities) }}
                </h3>

            </div>


            <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-gray-100 dark:bg-white/10">

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
                        d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                </svg>

            </div>

        </div>

    </div>


    {{-- Today --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Today
                </p>

                <h3 class="mt-2 text-2xl font-semibold text-gray-800 dark:text-white">
                    {{ number_format($today) }}
                </h3>

            </div>


            <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-gray-100 dark:bg-white/10">

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
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                    />
                </svg>

            </div>

        </div>

    </div>


    {{-- Successful --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Successful
                </p>

                <h3 class="mt-2 text-2xl font-semibold text-gray-800 dark:text-white">
                    {{ number_format($successful) }}
                </h3>

            </div>


            <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-gray-100 dark:bg-white/10">

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
                        d="M5 13l4 4L19 7"
                    />
                </svg>

            </div>

        </div>

    </div>


    {{-- Failed --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Failed
                </p>

                <h3 class="mt-2 text-2xl font-semibold text-gray-800 dark:text-white">
                    {{ number_format($failed) }}
                </h3>

            </div>


            <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-gray-100 dark:bg-white/10">

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
                        d="M12 9v4m0 4h.01M10.3 3.8L2.8 17a2 2 0 001.7 3h15a2 2 0 001.7 3L13.7 3.8a2 2 0 00-3.4 0z"
                    />
                </svg>

            </div>

        </div>

    </div>

</div>


{{-- ============================================================
     FILTERS
============================================================= --}}
<form
    method="GET"
    action="{{ route('activity-logs') }}"
    class="mt-6 rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]"
>

    <div class="mb-5">

        <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
            Activity History
        </h2>

        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Search and filter recent system activities.
        </p>

    </div>


    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">


        {{-- Search --}}
        <div>

            <label
                for="search"
                class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
            >
                Search
            </label>

            <input
                id="search"
                name="search"
                type="text"
                value="{{ $search }}"
                placeholder="Search user, activity..."
                class="h-11 w-full rounded-lg border border-gray-300 bg-white px-4 text-sm text-gray-800 outline-none transition focus:border-gray-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
            >

        </div>


        {{-- Activity Type --}}
        <div>

            <label
                for="type"
                class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
            >
                Activity Type
            </label>

            <select
                id="type"
                name="type"
                class="h-11 w-full rounded-lg border border-gray-300 bg-white px-4 text-sm text-gray-800 outline-none transition focus:border-gray-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
            >

                <option
                    value=""
                    @selected(!$type)
                >
                    All Activities
                </option>

                <option
                    value="Authentication"
                    @selected($type === 'Authentication')
                >
                    Authentication
                </option>

                <option
                    value="URL Management"
                    @selected($type === 'URL Management')
                >
                    URL Management
                </option>

                <option
                    value="QR Code"
                    @selected($type === 'QR Code')
                >
                    QR Code
                </option>

                <option
                    value="Analytics"
                    @selected($type === 'Analytics')
                >
                    Analytics
                </option>

                <option
                    value="Settings"
                    @selected($type === 'Settings')
                >
                    Settings
                </option>

                <option
                    value="Reports"
                    @selected($type === 'Reports')
                >
                    Reports
                </option>

                <option
                    value="User Management"
                    @selected($type === 'User Management')
                >
                    User Management
                </option>

            </select>

        </div>


        {{-- Status --}}
        <div>

            <label
                for="status"
                class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
            >
                Status
            </label>

            <select
                id="status"
                name="status"
                class="h-11 w-full rounded-lg border border-gray-300 bg-white px-4 text-sm text-gray-800 outline-none transition focus:border-gray-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
            >

                <option
                    value=""
                    @selected(!$status)
                >
                    All Status
                </option>

                <option
                    value="Successful"
                    @selected($status === 'Successful')
                >
                    Successful
                </option>

                <option
                    value="Failed"
                    @selected($status === 'Failed')
                >
                    Failed
                </option>

            </select>

        </div>


        {{-- Date Range --}}
        <div>

            <label
                for="date_range"
                class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
            >
                Date Range
            </label>

            <select
                id="date_range"
                name="date_range"
                class="h-11 w-full rounded-lg border border-gray-300 bg-white px-4 text-sm text-gray-800 outline-none transition focus:border-gray-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
            >

                <option
                    value="Last 7 Days"
                    @selected($dateRange === 'Last 7 Days')
                >
                    Last 7 Days
                </option>

                <option
                    value="Last 30 Days"
                    @selected($dateRange === 'Last 30 Days')
                >
                    Last 30 Days
                </option>

                <option
                    value="Last 90 Days"
                    @selected($dateRange === 'Last 90 Days')
                >
                    Last 90 Days
                </option>

                <option
                    value="This Year"
                    @selected($dateRange === 'This Year')
                >
                    This Year
                </option>

            </select>

        </div>

    </div>


    {{-- Filter Buttons --}}
    <div class="mt-5 flex flex-col gap-3 sm:flex-row sm:justify-end">

        <a
            href="{{ route('activity-logs') }}"
            class="inline-flex h-10 items-center justify-center rounded-lg border border-gray-300 px-4 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-white/5"
        >
            Clear Filters
        </a>

        <button
            type="submit"
            class="inline-flex h-10 items-center justify-center rounded-lg bg-gray-800 px-5 text-sm font-medium text-white transition hover:bg-gray-700 dark:bg-white dark:text-gray-800 dark:hover:bg-gray-100"
        >
            Apply Filters
        </button>

    </div>

</form>


{{-- ============================================================
     ACTIVITY TABLE
============================================================= --}}
<div class="mt-6 overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">


    {{-- Table Header --}}
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

        </div>

    </div>


    {{-- Table --}}
    <div class="overflow-x-auto">

        <table class="w-full min-w-[1100px] text-left">

            <thead class="border-b border-gray-200 bg-gray-50 dark:border-gray-800 dark:bg-white/[0.02]">

                <tr>

                    <th class="px-5 py-4 text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                        User
                    </th>

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

                </tr>

            </thead>


            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">


                @forelse($activities as $activity)

                    <tr class="transition hover:bg-gray-50 dark:hover:bg-white/[0.02]">


                        {{-- User --}}
                        <td class="px-5 py-4">

                            <div>

                                <p class="text-sm font-medium text-gray-800 dark:text-white">

                                    {{ $activity->user?->name ?? 'Deleted User' }}

                                </p>

                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">

                                    User ID:
                                    {{ $activity->user_id ?? 'N/A' }}

                                </p>

                            </div>

                        </td>


                        {{-- Activity --}}
                        <td class="px-5 py-4">

                            <div class="flex items-center gap-3">


                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-gray-100 dark:bg-white/10">

                                    @if($activity->status === 'Failed')

                                        <svg
                                            class="h-4 w-4 text-gray-600 dark:text-gray-300"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M12 9v4m0 4h.01M10.3 3.8L2.8 17a2 2 0 001.7 3h15a2 2 0 001.7 3L13.7 3.8a2 2 0 00-3.4 0z"
                                            />
                                        </svg>

                                    @else

                                        <svg
                                            class="h-4 w-4 text-gray-600 dark:text-gray-300"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M13 10V3L4 14h7v7l9-11h-7z"
                                            />
                                        </svg>

                                    @endif

                                </div>


                                <div>

                                    <p class="text-sm font-medium text-gray-800 dark:text-white">

                                        {{ $activity->activity }}

                                    </p>

                                    <p class="text-xs text-gray-500 dark:text-gray-400">

                                        {{ $activity->type }}

                                    </p>

                                </div>

                            </div>

                        </td>


                        {{-- Description --}}
                        <td class="max-w-xs px-5 py-4 text-sm text-gray-600 dark:text-gray-300">

                            {{ $activity->description ?: 'No description available.' }}

                        </td>


                        {{-- IP Address --}}
                        <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-300">

                            {{ $activity->ip_address ?: 'N/A' }}

                        </td>


                        {{-- Status --}}
                        <td class="px-5 py-4">

                            @if($activity->status === 'Successful')

                                <span class="rounded-full bg-green-50 px-3 py-1 text-xs font-medium text-green-700 dark:bg-green-500/10 dark:text-green-400">
                                    Successful
                                </span>

                            @else

                                <span class="rounded-full bg-red-50 px-3 py-1 text-xs font-medium text-red-700 dark:bg-red-500/10 dark:text-red-400">
                                    Failed
                                </span>

                            @endif

                        </td>


                        {{-- Date & Time --}}
                        <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-300">

                            @if($activity->created_at)

                                {{ $activity->created_at->format('M d, Y') }}

                                <span class="mt-1 block text-xs text-gray-400 dark:text-gray-500">

                                    {{ $activity->created_at->format('h:i A') }}

                                </span>

                            @else

                                N/A

                            @endif

                        </td>

                    </tr>


                @empty


                    {{-- Empty State --}}
                    <tr>

                        <td
                            colspan="6"
                            class="px-5 py-14 text-center"
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
                                            d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z"
                                        />
                                    </svg>

                                </div>


                                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    No activities found.
                                </p>


                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    Your system activities will appear here.
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
    @if($activities->hasPages())

        <div class="flex flex-col gap-3 border-t border-gray-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between dark:border-gray-800">

            <p class="text-sm text-gray-500 dark:text-gray-400">

                Showing

                {{ $activities->firstItem() ?? 0 }}

                to

                {{ $activities->lastItem() ?? 0 }}

                of

                {{ $activities->total() }}

                activities

            </p>


            <div>

                {{ $activities->links() }}

            </div>

        </div>

    @else

        @if($activities->total() > 0)

            <div class="border-t border-gray-200 px-5 py-4 dark:border-gray-800">

                <p class="text-sm text-gray-500 dark:text-gray-400">

                    Showing

                    {{ $activities->total() }}

                    activities

                </p>

            </div>

        @endif

    @endif

</div>

</div>

@endsection
