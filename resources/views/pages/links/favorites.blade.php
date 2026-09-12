@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-7xl">

    <!-- Page Header -->
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white/90">
                Favorite Links
            </h1>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Quickly access and manage your favorite short links.
            </p>
        </div>

        <a
            href="{{ url('/links/create') }}"
            class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-brand-600"
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
                    d="M12 4v16m8-8H4"
                />
            </svg>

            Generate Short URL
        </a>

    </div>


    <!-- Summary -->
    <div class="mb-6 rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">

        <div class="flex items-center gap-4">

            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-yellow-50 text-yellow-500 dark:bg-yellow-500/10">

                <svg
                    class="h-6 w-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="m12 3 2.78 5.63 6.22.9-4.5 4.38 1.06 6.19L12 17.18l-5.56 2.92 1.06-6.19L3 9.53l6.22-.9L12 3Z"
                    />
                </svg>

            </div>

            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Favorite Links
                </p>

                <p class="mt-1 text-2xl font-bold text-gray-800 dark:text-white/90">
                    0
                </p>
            </div>

        </div>

    </div>


    <!-- Favorites Table -->
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

        <!-- Header -->
        <div class="flex flex-col gap-4 border-b border-gray-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between dark:border-gray-800">

            <div>
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                    Favorite Links
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Your saved favorite links will appear here.
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
                    placeholder="Search favorites..."
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
                        d="m12 3 2.78 5.63 6.22.9-4.5 4.38 1.06 6.19L12 17.18l-5.56 2.92 1.06-6.19L3 9.53l6.22-.9L12 3Z"
                    />
                </svg>

            </div>


            <h3 class="mt-5 text-lg font-semibold text-gray-800 dark:text-white/90">
                No favorite links yet
            </h3>

            <p class="mx-auto mt-2 max-w-md text-sm text-gray-500 dark:text-gray-400">
                Favorite links that you use frequently will appear here for quick access.
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