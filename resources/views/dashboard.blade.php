@extends('layouts.app')

@section('content')

<div class="space-y-6">

    <div>
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">
            Dashboard
        </h1>

        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Welcome back! Here's an overview of your URL Shortener.
        </p>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Total Links
            </p>

            <h3 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white">
                0
            </h3>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Total Clicks
            </p>

            <h3 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white">
                0
            </h3>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
            <p class="text-sm text-gray-500 dark:text-gray-400">
                QR Codes
            </p>

            <h3 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white">
                0
            </h3>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Active Links
            </p>

            <h3 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white">
                0
            </h3>
        </div>

    </div>

</div>

@endsection