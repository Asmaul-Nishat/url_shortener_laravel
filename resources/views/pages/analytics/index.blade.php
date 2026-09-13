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

    <!-- Period Filter -->
    <form method="GET" action="{{ route('analytics') }}">

        <select
            name="period"
            onchange="this.form.submit()"
            class="h-11 rounded-lg border border-gray-300 bg-white px-4 text-sm text-gray-700 outline-none transition focus:border-brand-500 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
        >

            <option
                value="7"
                {{ $period === '7' ? 'selected' : '' }}
            >
                Last 7 Days
            </option>

            <option
                value="30"
                {{ $period === '30' ? 'selected' : '' }}
            >
                Last 30 Days
            </option>

            <option
                value="90"
                {{ $period === '90' ? 'selected' : '' }}
            >
                Last 90 Days
            </option>

            <option
                value="year"
                {{ $period === 'year' ? 'selected' : '' }}
            >
                This Year
            </option>

        </select>

    </form>

</div>


<!-- Overview Cards -->
<div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-5">

    <!-- Total Clicks -->
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

        <p class="text-sm text-gray-500 dark:text-gray-400">
            Total Clicks
        </p>

        <h3 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">
            {{ number_format($totalClicks) }}
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
            {{ number_format($todayClicks) }}
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
            {{ number_format($yesterdayClicks) }}
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
            {{ number_format($weekClicks) }}
        </h3>

        <p class="mt-2 text-xs text-gray-400">
            Current week
        </p>

    </div>


    <!-- This Month -->
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

        <p class="text-sm text-gray-500 dark:text-gray-400">
            This Month
        </p>

        <h3 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">
            {{ number_format($monthClicks) }}
        </h3>

        <p class="mt-2 text-xs text-gray-400">
            Current month
        </p>

    </div>

</div>


<!-- Click Analytics -->
<div class="mb-6 rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

    <div class="flex flex-col gap-3 border-b border-gray-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between dark:border-gray-800">

        <div>
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                Click Analytics
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                {{ $periodLabel }}
            </p>
        </div>

    </div>


    <div class="p-6">

        <div class="relative h-80 w-full">

            <canvas id="clickAnalyticsChart"></canvas>

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

            <div class="space-y-4">

                @foreach($devices as $device => $count)

                    @php
                        $deviceTotal = array_sum($devices);

                        $percentage = $deviceTotal > 0
                            ? round(($count / $deviceTotal) * 100)
                            : 0;
                    @endphp

                    <div>

                        <div class="mb-2 flex items-center justify-between">

                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ $device }}
                            </span>

                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                {{ number_format($count) }}
                                ({{ $percentage }}%)
                            </span>

                        </div>

                        <div class="h-2 w-full rounded-full bg-gray-100 dark:bg-gray-800">

                            <div
                                class="h-2 rounded-full bg-brand-500"
                                style="width: {{ $percentage }}%"
                            ></div>

                        </div>

                    </div>

                @endforeach

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

            <div class="space-y-4">

                @foreach($browsers as $browser => $count)

                    @php
                        $browserTotal = array_sum($browsers);

                        $percentage = $browserTotal > 0
                            ? round(($count / $browserTotal) * 100)
                            : 0;
                    @endphp

                    <div>

                        <div class="mb-2 flex items-center justify-between">

                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ $browser }}
                            </span>

                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                {{ number_format($count) }}
                                ({{ $percentage }}%)
                            </span>

                        </div>

                        <div class="h-2 w-full rounded-full bg-gray-100 dark:bg-gray-800">

                            <div
                                class="h-2 rounded-full bg-brand-500"
                                style="width: {{ $percentage }}%"
                            ></div>

                        </div>

                    </div>

                @endforeach

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

            <div class="space-y-4">

                @foreach($operatingSystems as $os => $count)

                    @php
                        $osTotal = array_sum($operatingSystems);

                        $percentage = $osTotal > 0
                            ? round(($count / $osTotal) * 100)
                            : 0;
                    @endphp

                    <div>

                        <div class="mb-2 flex items-center justify-between">

                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ $os }}
                            </span>

                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                {{ number_format($count) }}
                                ({{ $percentage }}%)
                            </span>

                        </div>

                        <div class="h-2 w-full rounded-full bg-gray-100 dark:bg-gray-800">

                            <div
                                class="h-2 rounded-full bg-brand-500"
                                style="width: {{ $percentage }}%"
                            ></div>

                        </div>

                    </div>

                @endforeach

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
                        Country analytics coming soon
                    </p>

                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        IP-based location tracking will be added later.
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>


<!-- Top Referrers -->
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

        @if($referrers->count())

            <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-gray-800">

                <table class="w-full text-left">

                    <thead class="bg-gray-50 dark:bg-gray-900">

                        <tr>

                            <th class="px-4 py-3 text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                                Source
                            </th>

                            <th class="px-4 py-3 text-right text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                                Clicks
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">

                        @foreach($referrers as $referrer => $count)

                            <tr>

                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                                    {{ $referrer }}
                                </td>

                                <td class="px-4 py-3 text-right text-sm font-semibold text-gray-800 dark:text-white/90">
                                    {{ number_format($count) }}
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="flex h-36 items-center justify-center rounded-xl border border-dashed border-gray-300 bg-gray-50 dark:border-gray-700 dark:bg-gray-900/50">

                <div class="text-center">

                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        No referrer data
                    </p>

                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        Referral sources will appear after your links receive visitors.
                    </p>

                </div>

            </div>

        @endif

    </div>

</div>


<!-- Top Performing Links -->
<div class="mt-6 rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

    <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">

        <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
            Top Performing Links
        </h2>

        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Your most clicked short links.
        </p>

    </div>


    <div class="overflow-x-auto">

        <table class="w-full min-w-[700px]">

            <thead>

                <tr class="border-b border-gray-200 dark:border-gray-800">

                    <th class="px-6 py-4 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                        Short Link
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                        Destination
                    </th>

                    <th class="px-6 py-4 text-right text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                        Clicks
                    </th>

                </tr>

            </thead>


            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">

                @forelse($topLinks as $link)

                    <tr>

                        <td class="px-6 py-4">

                            <a
                                href="{{ $link->short_url }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="text-sm font-medium text-brand-500 hover:underline"
                            >
                                {{ $link->short_url }}
                            </a>

                        </td>


                        <td class="max-w-md truncate px-6 py-4 text-sm text-gray-500 dark:text-gray-400">

                            {{ $link->original_url }}

                        </td>


                        <td class="px-6 py-4 text-right text-sm font-semibold text-gray-800 dark:text-white/90">

                            {{ number_format($link->click_count) }}

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="3"
                            class="px-6 py-10 text-center text-sm text-gray-500 dark:text-gray-400"
                        >
                            No links available yet.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

</div>

<!-- Chart.js -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

    document.addEventListener('DOMContentLoaded', function () {

        const canvas = document.getElementById(
            'clickAnalyticsChart'
        );

        if (!canvas) {
            return;
        }


        const chartLabels = @json($dailyLabels);

        const chartData = @json($dailyData);


        const ctx = canvas.getContext('2d');


        new Chart(ctx, {

            type: 'line',

            data: {

                labels: chartLabels,

                datasets: [

                    {
                        label: 'Clicks',

                        data: chartData,

                        borderWidth: 2,

                        tension: 0.4,

                        fill: true,

                        pointRadius: 3,

                        pointHoverRadius: 5
                    }

                ]

            },


            options: {

                responsive: true,

                maintainAspectRatio: false,


                plugins: {

                    legend: {
                        display: false
                    }

                },


                scales: {

                    x: {

                        grid: {
                            display: false
                        }

                    },


                    y: {

                        beginAtZero: true,

                        ticks: {
                            precision: 0
                        }

                    }

                }

            }

        });

    });

</script>

@endsection
