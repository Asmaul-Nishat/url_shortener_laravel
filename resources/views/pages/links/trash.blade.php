@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-7xl">

    <!-- Page Header -->
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white/90">
                Trash
            </h1>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Manage deleted short links and restore them when needed.
            </p>
        </div>

        <a
            href="{{ url('/links') }}"
            class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
        >
            <svg
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M19 12H5m6 6-6-6 6-6"
                />
            </svg>

            Back to Links
        </a>

    </div>


    <!-- Trash Summary -->
    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2">

        <!-- Deleted Links -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="flex items-center gap-4">

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-red-50 text-red-500 dark:bg-red-500/10">

                    <svg
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M4 7h16m-10 4v6m4-6v6M9 7V4h6v3m-8 0 1 13h8l1-13"
                        />
                    </svg>

                </div>

                <div>

                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Deleted Links
                    </p>

                    <p class="mt-1 text-2xl font-bold text-gray-800 dark:text-white/90">
                        0
                    </p>

                </div>

            </div>

        </div>


        <!-- Auto Delete -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="flex items-center gap-4">

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400">

                    <svg
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M12 6v6l4 2m6-2a10 10 0 1 1-20 0 10 10 0 0 1 20 0Z"
                        />
                    </svg>

                </div>

                <div>

                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Permanent Deletion
                    </p>

                    <p class="mt-1 text-sm font-medium text-gray-700 dark:text-gray-300">
                        Not configured
                    </p>

                </div>

            </div>

        </div>

    </div>


    <!-- Trash Table -->
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

        <!-- Header -->
        <div class="flex flex-col gap-4 border-b border-gray-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between dark:border-gray-800">

            <div>
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                    Deleted Links
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Deleted links can later be restored or permanently removed.
                </p>
            </div>

            <div class="relative w-full sm:w-64">

                <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">

                    <svg
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="m21 21-4.35-4.35m1.35-5.4a6.75 6.75 0 1 1-13.5 0 6.75 6.75 0 0 1 13.5 0Z"
                        />
                    </svg>

                </span>

                <input
                    type="text"
                    placeholder="Search trash..."
                    class="h-11 w-full rounded-lg border border-gray-300 bg-white pl-10 pr-4 text-sm text-gray-800 outline-none transition placeholder:text-gray-400 focus:border-brand-500 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-gray-500"
                >

            </div>

        </div>


        <!-- Empty State -->
        <div class="px-6 py-16 text-center">

            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">

                <svg
                    class="h-8 w-8 text-gray-400"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.8"
                        d="M4 7h16m-10 4v6m4-6v6M9 7V4h6v3m-8 0 1 13h8l1-13"
                    />
                </svg>

            </div>


            <h3 class="mt-5 text-lg font-semibold text-gray-800 dark:text-white/90">
                Trash is empty
            </h3>

            <p class="mx-auto mt-2 max-w-md text-sm text-gray-500 dark:text-gray-400">
                Links that you delete will appear here. You can restore them or permanently delete them later.
            </p>


            <a
                href="{{ url('/links') }}"
                class="mt-6 inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
            >
                View All Links
            </a>

        </div>

    </div>

</div>

@endsection