@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-7xl">

    <!-- Page Header -->
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white/90">
                Links
            </h1>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Manage, monitor and organize your short links.
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


    <!-- Summary Cards -->
    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">

        <!-- Total Links -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

            <p class="text-sm text-gray-500 dark:text-gray-400">
                Total Links
            </p>

            <h3 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">
                0
            </h3>

        </div>


        <!-- Active Links -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

            <p class="text-sm text-gray-500 dark:text-gray-400">
                Active Links
            </p>

            <h3 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">
                0
            </h3>

        </div>


        <!-- Expired Links -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

            <p class="text-sm text-gray-500 dark:text-gray-400">
                Expired Links
            </p>

            <h3 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">
                0
            </h3>

        </div>


        <!-- Total Clicks -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

            <p class="text-sm text-gray-500 dark:text-gray-400">
                Total Clicks
            </p>

            <h3 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">
                0
            </h3>

        </div>

    </div>


    <!-- Links Table -->
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

        <!-- Table Header -->
        <div class="flex flex-col gap-4 border-b border-gray-200 px-6 py-5 lg:flex-row lg:items-center lg:justify-between dark:border-gray-800">

            <div>
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                    All Links
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    View and manage all your short links.
                </p>
            </div>


            <!-- Search -->
            <div class="relative w-full lg:w-72">

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
                    placeholder="Search links..."
                    class="h-11 w-full rounded-lg border border-gray-300 bg-white pl-10 pr-4 text-sm text-gray-800 outline-none transition placeholder:text-gray-400 focus:border-brand-500 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-gray-500"
                >

            </div>

        </div>


        <!-- Filters -->
        <div class="flex flex-col gap-3 border-b border-gray-200 px-6 py-4 sm:flex-row sm:items-center dark:border-gray-800">

            <select
                class="h-10 rounded-lg border border-gray-300 bg-white px-3 text-sm text-gray-700 outline-none focus:border-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
            >
                <option>All Status</option>
                <option>Active</option>
                <option>Expired</option>
            </select>


            <select
                class="h-10 rounded-lg border border-gray-300 bg-white px-3 text-sm text-gray-700 outline-none focus:border-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
            >
                <option>All Links</option>
                <option>Favorites</option>
                <option>Recently Created</option>
            </select>

        </div>


        <!-- Responsive Table -->
        <div class="overflow-x-auto">

            <table class="w-full min-w-[1000px]">

                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-800">

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Short Link
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Original URL
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Clicks
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Status
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Expiry
                        </th>

                        <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Actions
                        </th>

                    </tr>
                </thead>


                <tbody>

                    <!-- Demo Row 1 -->
                    <tr class="border-b border-gray-200 dark:border-gray-800">

                        <!-- Short Link -->
                        <td class="px-6 py-5">

                            <div class="flex items-center gap-3">

                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-brand-50 text-brand-500 dark:bg-brand-500/10">

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
                                            d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71m2.12 2.12a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"
                                        />
                                    </svg>

                                </div>

                                <div>
                                    <p class="text-sm font-semibold text-gray-800 dark:text-white/90">
                                        /abc123
                                    </p>

                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        Created today
                                    </p>
                                </div>

                            </div>

                        </td>


                        <!-- Original URL -->
                        <td class="max-w-xs px-6 py-5">

                            <p class="truncate text-sm text-gray-600 dark:text-gray-300">
                                https://example.com/long-url
                            </p>

                        </td>


                        <!-- Clicks -->
                        <td class="px-6 py-5">

                            <span class="text-sm font-medium text-gray-800 dark:text-white/90">
                                0
                            </span>

                        </td>


                        <!-- Status -->
                        <td class="px-6 py-5">

                            <span class="inline-flex rounded-full bg-green-50 px-3 py-1 text-xs font-medium text-green-600 dark:bg-green-500/10 dark:text-green-400">
                                Active
                            </span>

                        </td>


                        <!-- Expiry -->
                        <td class="px-6 py-5">

                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                Never
                            </span>

                        </td>


                        <!-- Actions -->
                        <td class="px-6 py-5">

                            <div class="flex items-center justify-end gap-2">

                                <button
                                    type="button"
                                    title="Copy"
                                    class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-gray-300 text-gray-500 transition hover:bg-gray-50 hover:text-gray-700 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-gray-200"
                                >
                                    <svg
                                        class="h-4 w-4"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M8 8h8v8H8z M16 4h4v12 M4 16V4h12"
                                        />
                                    </svg>
                                </button>


                                <button
                                    type="button"
                                    title="More"
                                    class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-gray-300 text-gray-500 transition hover:bg-gray-50 hover:text-gray-700 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-gray-200"
                                >
                                    <svg
                                        class="h-4 w-4"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 6h.01M12 12h.01M12 18h.01"
                                        />
                                    </svg>
                                </button>

                            </div>

                        </td>

                    </tr>


                    <!-- Demo Row 2 -->
                    <tr class="border-b border-gray-200 dark:border-gray-800">

                        <td class="px-6 py-5">

                            <div class="flex items-center gap-3">

                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-brand-50 text-brand-500 dark:bg-brand-500/10">

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
                                            d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71m2.12 2.12a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"
                                        />
                                    </svg>

                                </div>

                                <div>
                                    <p class="text-sm font-semibold text-gray-800 dark:text-white/90">
                                        /google1
                                    </p>

                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        Created yesterday
                                    </p>
                                </div>

                            </div>

                        </td>


                        <td class="max-w-xs px-6 py-5">

                            <p class="truncate text-sm text-gray-600 dark:text-gray-300">
                                https://google.com
                            </p>

                        </td>


                        <td class="px-6 py-5">

                            <span class="text-sm font-medium text-gray-800 dark:text-white/90">
                                0
                            </span>

                        </td>


                        <td class="px-6 py-5">

                            <span class="inline-flex rounded-full bg-green-50 px-3 py-1 text-xs font-medium text-green-600 dark:bg-green-500/10 dark:text-green-400">
                                Active
                            </span>

                        </td>


                        <td class="px-6 py-5">

                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                Never
                            </span>

                        </td>


                        <td class="px-6 py-5">

                            <div class="flex items-center justify-end gap-2">

                                <button
                                    type="button"
                                    title="Copy"
                                    class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-gray-300 text-gray-500 transition hover:bg-gray-50 hover:text-gray-700 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-gray-200"
                                >
                                    <svg
                                        class="h-4 w-4"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M8 8h8v8H8z M16 4h4v12 M4 16V4h12"
                                        />
                                    </svg>
                                </button>


                                <button
                                    type="button"
                                    title="More"
                                    class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-gray-300 text-gray-500 transition hover:bg-gray-50 hover:text-gray-700 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-gray-200"
                                >
                                    <svg
                                        class="h-4 w-4"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 6h.01M12 12h.01M12 18h.01"
                                        />
                                    </svg>
                                </button>

                            </div>

                        </td>

                    </tr>


                    <!-- Demo Row 3 -->
                    <tr>

                        <td class="px-6 py-5">

                            <div class="flex items-center gap-3">

                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-brand-50 text-brand-500 dark:bg-brand-500/10">

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
                                            d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71m2.12 2.12a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"
                                        />
                                    </svg>

                                </div>

                                <div>
                                    <p class="text-sm font-semibold text-gray-800 dark:text-white/90">
                                        /github1
                                    </p>

                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        Created 2 days ago
                                    </p>
                                </div>

                            </div>

                        </td>


                        <td class="max-w-xs px-6 py-5">

                            <p class="truncate text-sm text-gray-600 dark:text-gray-300">
                                https://github.com
                            </p>

                        </td>


                        <td class="px-6 py-5">

                            <span class="text-sm font-medium text-gray-800 dark:text-white/90">
                                0
                            </span>

                        </td>


                        <td class="px-6 py-5">

                            <span class="inline-flex rounded-full bg-red-50 px-3 py-1 text-xs font-medium text-red-600 dark:bg-red-500/10 dark:text-red-400">
                                Expired
                            </span>

                        </td>


                        <td class="px-6 py-5">

                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                Sep 08, 2026
                            </span>

                        </td>


                        <td class="px-6 py-5">

                            <div class="flex items-center justify-end gap-2">

                                <button
                                    type="button"
                                    title="Copy"
                                    class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-gray-300 text-gray-500 transition hover:bg-gray-50 hover:text-gray-700 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-gray-200"
                                >
                                    <svg
                                        class="h-4 w-4"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M8 8h8v8H8z M16 4h4v12 M4 16V4h12"
                                        />
                                    </svg>
                                </button>


                                <button
                                    type="button"
                                    title="More"
                                    class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-gray-300 text-gray-500 transition hover:bg-gray-50 hover:text-gray-700 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-gray-200"
                                >
                                    <svg
                                        class="h-4 w-4"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 6h.01M12 12h.01M12 18h.01"
                                        />
                                    </svg>
                                </button>

                            </div>

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>


        <!-- Empty/Pagination Footer -->
        <div class="flex flex-col gap-3 border-t border-gray-200 px-6 py-4 sm:flex-row sm:items-center sm:justify-between dark:border-gray-800">

            <p class="text-sm text-gray-500 dark:text-gray-400">
                Showing 3 demo links
            </p>

            <div class="flex items-center gap-2">

                <button
                    type="button"
                    disabled
                    class="rounded-lg border border-gray-200 px-3 py-2 text-sm text-gray-400 dark:border-gray-700"
                >
                    Previous
                </button>

                <button
                    type="button"
                    disabled
                    class="rounded-lg border border-gray-200 px-3 py-2 text-sm text-gray-400 dark:border-gray-700"
                >
                    Next
                </button>

            </div>

        </div>

    </div>

</div>

@endsection