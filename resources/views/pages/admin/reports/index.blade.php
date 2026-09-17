@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-7xl space-y-6">

{{-- ========================================================= --}}
{{-- PAGE HEADER --}}
{{-- ========================================================= --}}

<div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

    <div>

        <h1 class="text-2xl font-bold text-gray-800 dark:text-white/90">
            Generate Report
        </h1>

    </div>

</div>


{{-- ========================================================= --}}
{{-- SUCCESS --}}
{{-- ========================================================= --}}

@if(session('success'))

    <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 dark:border-green-800 dark:bg-green-900/20 dark:text-green-400">
        {{ session('success') }}
    </div>

@endif


{{-- ========================================================= --}}
{{-- ERROR --}}
{{-- ========================================================= --}}

@if(session('error'))

    <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 dark:border-red-800 dark:bg-red-900/20 dark:text-red-400">
        {{ session('error') }}
    </div>

@endif


{{-- ========================================================= --}}
{{-- VALIDATION --}}
{{-- ========================================================= --}}

@if($errors->any())

    <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 dark:border-red-800 dark:bg-red-900/20 dark:text-red-400">

        <ul class="list-disc space-y-1 pl-5">

            @foreach($errors->all() as $error)

                <li>
                    {{ $error }}
                </li>

            @endforeach

        </ul>

    </div>

@endif


{{-- ========================================================= --}}
{{-- GENERATE REPORT CARD --}}
{{-- ========================================================= --}}

<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

    <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">

        <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
            Generate Report
        </h2>

        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Select the filters and format for your report.
        </p>

    </div>


    <form
        action="{{ route('admin.reports.generate') }}"
        method="POST"
        class="p-6"
    >

        @csrf


        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

            {{-- ================================================= --}}
            {{-- REPORT TYPE --}}
            {{-- ================================================= --}}

            <div>

                <label
                    for="report_type"
                    class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                >
                    Report Type
                </label>

                <select
                    id="report_type"
                    name="report_type"
                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-700 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                >

                    <option
                        value="click_analytics"
                        {{ old(
                            'report_type',
                            request('report_type', 'click_analytics')
                        ) === 'click_analytics'
                            ? 'selected'
                            : ''
                        }}
                    >
                        Click Analytics
                    </option>

                </select>

            </div>


            {{-- ================================================= --}}
            {{-- DATE RANGE --}}
            {{-- ================================================= --}}

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
                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-700 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                >

                    @foreach([
                        'Today',
                        'Yesterday',
                        'Last 7 Days',
                        'Last 30 Days',
                        'Last 90 Days',
                        'This Month',
                        'Last Month',
                        'This Year'
                    ] as $range)

                        <option
                            value="{{ $range }}"
                            {{ old(
                                'date_range',
                                request('date_range', 'Last 7 Days')
                            ) === $range
                                ? 'selected'
                                : ''
                            }}
                        >
                            {{ $range }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- ================================================= --}}
            {{-- USER --}}
            {{-- ================================================= --}}

            <div>

                <label
                    for="user_id"
                    class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                >
                    User
                </label>

                <select
                    id="user_id"
                    name="user_id"
                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-700 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                >

                    <option value="">
                        All Users
                    </option>

                    @foreach($users as $user)

                        <option
                            value="{{ $user->id }}"
                            {{ (string) old(
                                'user_id',
                                request('user_id')
                            ) === (string) $user->id
                                ? 'selected'
                                : ''
                            }}
                        >
                            {{ $user->name }}
                            —
                            {{ $user->email }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- ================================================= --}}
            {{-- SHORT LINK --}}
            {{-- ================================================= --}}

            <div>

                <label
                    for="short_url_id"
                    class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                >
                    Short Link
                </label>

                <select
                    id="short_url_id"
                    name="short_url_id"
                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-700 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                >

                    <option
                        value=""
                        data-user-id=""
                    >
                        All Short Links
                    </option>

                    @foreach($shortUrls as $shortUrl)

                        <option
                            value="{{ $shortUrl->id }}"
                            data-user-id="{{ $shortUrl->user_id }}"
                            {{ (string) old(
                                'short_url_id',
                                request('short_url_id')
                            ) === (string) $shortUrl->id
                                ? 'selected'
                                : ''
                            }}
                        >

                            /{{ $shortUrl->custom_alias ?: $shortUrl->short_code }}

                            @if($shortUrl->user)

                                —
                                {{ $shortUrl->user->name }}

                            @endif

                        </option>

                    @endforeach

                </select>

                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                    Selecting a user will show only that user's short links.
                </p>

            </div>


            {{-- ================================================= --}}
            {{-- FORMAT --}}
            {{-- ================================================= --}}

            <div class="md:col-span-2">

                <label class="mb-3 block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Format
                </label>

                <div class="flex flex-wrap gap-6">

                    {{-- PDF --}}

                    <label class="flex cursor-pointer items-center gap-2">

                        <input
                            type="radio"
                            name="format"
                            value="PDF"
                            {{ old('format', 'PDF') === 'PDF'
                                ? 'checked'
                                : ''
                            }}
                            class="h-4 w-4 border-gray-300 text-brand-500 focus:ring-brand-500"
                        >

                        <span class="text-sm text-gray-700 dark:text-gray-300">
                            PDF
                        </span>

                    </label>


                    {{-- CSV --}}

                    <label class="flex cursor-pointer items-center gap-2">

                        <input
                            type="radio"
                            name="format"
                            value="CSV"
                            {{ old('format') === 'CSV'
                                ? 'checked'
                                : ''
                            }}
                            class="h-4 w-4 border-gray-300 text-brand-500 focus:ring-brand-500"
                        >

                        <span class="text-sm text-gray-700 dark:text-gray-300">
                            CSV
                        </span>

                    </label>

                </div>

            </div>

        </div>


        {{-- ================================================= --}}
        {{-- ACTION BUTTONS --}}
        {{-- ================================================= --}}

        <div class="mt-6 flex flex-wrap items-center justify-end gap-3">

            {{-- DOWNLOAD GENERATED REPORTS --}}

            <a
                href="{{ route('admin.reports.all') }}"
                class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:hover:bg-gray-800"
            >
                Download Generated Reports
            </a>


            {{-- GENERATE REPORT --}}

            <button
                type="submit"
                class="inline-flex items-center justify-center rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-brand-500/30"
            >
                Generate Report
            </button>

        </div>

    </form>

</div>


{{-- ========================================================= --}}
{{-- VIEW ALL BUTTON --}}
{{-- ========================================================= --}}

@if(!$showAll && $totalClicks > 0)

    <div class="flex justify-center">

        <a
            href="{{ route(
                'admin.reports',
                array_merge(
                    request()->query(),
                    [
                        'show_all' => 1
                    ]
                )
            ) }}"
            class="inline-flex items-center justify-center rounded-lg bg-brand-500 px-6 py-2.5 text-sm font-medium text-white transition hover:bg-brand-600"
        >
            View All Clicks
        </a>

    </div>

@endif


{{-- ========================================================= --}}
{{-- CLICK DETAILS --}}
{{-- ========================================================= --}}

@if($showAll)

    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

        <div class="flex flex-col gap-4 border-b border-gray-200 px-6 py-5 lg:flex-row lg:items-center lg:justify-between dark:border-gray-800">

            <div>

                <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                    Click Details
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">

                    Showing
                    {{ number_format($clicks->count()) }}
                    of
                    {{ number_format($totalClicks) }}
                    click records.

                </p>

            </div>

        </div>


        {{-- TABLE --}}

        <div class="overflow-x-auto">

            <table class="min-w-[1300px] w-full">

                <thead>

                    <tr class="border-b border-gray-200 dark:border-gray-800">

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Short URL
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Original URL
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            IP Address
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            User Agent
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Referer
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Clicked At
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-200 dark:divide-gray-800">

                    @forelse($clicks as $click)

                        <tr class="transition hover:bg-gray-50 dark:hover:bg-white/[0.02]">

                            {{-- SHORT URL --}}

                            <td class="px-6 py-4">

                                @if($click->shortUrl)

                                    <a
                                        href="{{ url(
                                            $click->shortUrl->custom_alias
                                            ?: $click->shortUrl->short_code
                                        ) }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="break-all text-sm font-medium text-brand-500 hover:text-brand-600"
                                    >
                                        /{{ $click->shortUrl->custom_alias ?: $click->shortUrl->short_code }}
                                    </a>

                                @else

                                    <span class="text-sm text-gray-400">
                                        —
                                    </span>

                                @endif

                            </td>


                            {{-- ORIGINAL URL --}}

                            <td class="px-6 py-4">

                                @if($click->shortUrl)

                                    <a
                                        href="{{ $click->shortUrl->original_url }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="block max-w-[350px] break-all text-sm text-gray-600 hover:text-brand-500 dark:text-gray-400"
                                    >
                                        {{ $click->shortUrl->original_url }}
                                    </a>

                                @else

                                    <span class="text-sm text-gray-400">
                                        —
                                    </span>

                                @endif

                            </td>


                            {{-- IP --}}

                            <td class="px-6 py-4">

                                <span class="font-mono text-sm text-gray-600 dark:text-gray-400">
                                    {{ $click->ip_address ?: '—' }}
                                </span>

                            </td>


                            {{-- USER AGENT --}}

                            <td class="px-6 py-4">

                                <p
                                    class="max-w-[320px] break-words text-sm leading-6 text-gray-600 dark:text-gray-400"
                                    title="{{ $click->user_agent }}"
                                >
                                    {{ $click->user_agent ?: '—' }}
                                </p>

                            </td>


                            {{-- REFERER --}}

                            <td class="px-6 py-4">

                                @if($click->referer)

                                    <p
                                        class="max-w-[280px] break-all text-sm text-gray-600 dark:text-gray-400"
                                        title="{{ $click->referer }}"
                                    >
                                        {{ $click->referer }}
                                    </p>

                                @else

                                    <span class="text-sm text-gray-400">
                                        —
                                    </span>

                                @endif

                            </td>


                            {{-- CLICKED AT --}}

                            <td class="whitespace-nowrap px-6 py-4">

                                @if($click->clicked_at)

                                    <div>

                                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                            {{ $click->clicked_at->format('Y-m-d') }}
                                        </p>

                                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                            {{ $click->clicked_at->format('H:i:s') }}
                                        </p>

                                    </div>

                                @else

                                    <span class="text-sm text-gray-400">
                                        —
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="px-6 py-12 text-center"
                            >

                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    No click records found.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- SHOW LESS --}}

        <div class="flex justify-center border-t border-gray-200 px-6 py-5 dark:border-gray-800">

            <a
                href="{{ route(
                    'admin.reports',
                    request()->except('show_all')
                ) }}"
                class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:hover:bg-white/[0.03]"
            >
                Show Less
            </a>

        </div>

    </div>

@endif


</div>

{{-- ========================================================= --}}
{{-- USER → SHORT LINK FILTER --}}
{{-- ========================================================= --}}

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const userSelect = document.getElementById('user_id');
        const shortUrlSelect = document.getElementById('short_url_id');

        if (!userSelect || !shortUrlSelect) {
            return;
        }

        const allOptions = Array.from(
            shortUrlSelect.options
        );

        function filterShortUrls() {

            const selectedUserId = userSelect.value;

            const currentShortUrlId = shortUrlSelect.value;

            shortUrlSelect.innerHTML = '';

            /*
            |--------------------------------------------------------------------------
            | All Users
            |--------------------------------------------------------------------------
            */

            if (selectedUserId === '') {

                allOptions.forEach(function (option) {

                    shortUrlSelect.appendChild(
                        option.cloneNode(true)
                    );

                });

                shortUrlSelect.value = currentShortUrlId;

                return;
            }

            /*
            |--------------------------------------------------------------------------
            | Specific User
            |--------------------------------------------------------------------------
            */

            allOptions.forEach(function (option) {

                const optionUserId =
                    option.getAttribute('data-user-id');

                /*
                | Always show "All Short Links"
                */

                if (
                    optionUserId === '' ||
                    optionUserId === selectedUserId
                ) {

                    shortUrlSelect.appendChild(
                        option.cloneNode(true)
                    );

                }

            });

            /*
            |--------------------------------------------------------------------------
            | Keep selected link only if it belongs to selected user
            |--------------------------------------------------------------------------
            */

            const selectedOption =
                Array.from(
                    shortUrlSelect.options
                ).find(function (option) {
                    return option.value === currentShortUrlId;
                });

            if (selectedOption) {

                shortUrlSelect.value =
                    currentShortUrlId;

            } else {

                shortUrlSelect.value = '';

            }

        }

        /*
        |--------------------------------------------------------------------------
        | Filter when user changes
        |--------------------------------------------------------------------------
        */

        userSelect.addEventListener(
            'change',
            filterShortUrls
        );

        /*
        |--------------------------------------------------------------------------
        | Filter on initial page load
        |--------------------------------------------------------------------------
        */

        filterShortUrls();

    });
</script>

@endsection
