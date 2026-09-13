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
                Manage links that have been moved to Trash.
            </p>

        </div>


        @if($trashedLinks->count() > 0)

            <form
                method="POST"
                action="{{ route('links.empty-trash') }}"
                onsubmit="return confirm('Are you sure you want to permanently delete all links in Trash? This action cannot be undone.')"
            >

                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-600 transition hover:bg-red-100 dark:border-red-500/20 dark:bg-red-500/10 dark:text-red-400 dark:hover:bg-red-500/20"
                >

                    <svg
                        class="h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-8 0h10"
                        />

                    </svg>

                    Empty Trash

                </button>

            </form>

        @endif

    </div>


    <!-- Success Message -->

    @if(session('success'))

        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 dark:border-green-500/20 dark:bg-green-500/10 dark:text-green-400">

            {{ session('success') }}

        </div>

    @endif


    <!-- Trash Card -->

    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">


        <!-- Header -->

        <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">

            <div class="flex items-center justify-between">

                <div>

                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                        Deleted Links
                    </h2>

                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Deleted links are kept here until permanently removed.
                    </p>

                </div>


                <div class="rounded-full bg-gray-100 px-3 py-1.5 text-sm font-medium text-gray-600 dark:bg-gray-800 dark:text-gray-400">

                    {{ $trashedLinks->total() }}

                    {{ $trashedLinks->total() === 1 ? 'link' : 'links' }}

                </div>

            </div>

        </div>


        <!-- Table -->

        <div class="overflow-x-auto">

            <table class="min-w-full">

                <thead>

                    <tr class="border-b border-gray-200 dark:border-gray-800">

                        <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Short Link
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Original URL
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Clicks
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Deleted At
                        </th>

                        <th class="px-6 py-4 text-right text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-200 dark:divide-gray-800">


                    @forelse($trashedLinks as $shortUrl)

                        <tr class="transition hover:bg-gray-50 dark:hover:bg-white/[0.02]">


                            <!-- Short Link -->

                            <td class="whitespace-nowrap px-6 py-5">

                                <div class="flex items-center gap-3">

                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-800">

                                        <svg
                                            class="h-5 w-5 text-gray-500 dark:text-gray-400"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="1.8"
                                                d="M13.19 8.688l.086-.086a2.828 2.828 0 114 4l-3.5 3.5a2.828 2.828 0 01-4 0"
                                            />

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="1.8"
                                                d="M10.81 15.312l-.086.086a2.828 2.828 0 11-4-4l3.5-3.5a2.828 2.828 0 014 0"
                                            />

                                        </svg>

                                    </div>


                                    <div>

                                        <p class="font-medium text-gray-800 dark:text-white/90">
                                            {{ $shortUrl->custom_alias ?: $shortUrl->short_code }}
                                        </p>

                                        <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">
                                            {{ url($shortUrl->custom_alias ?: $shortUrl->short_code) }}
                                        </p>

                                    </div>

                                </div>

                            </td>


                            <!-- Original URL -->

                            <td class="max-w-xs px-6 py-5">

                                <p
                                    class="truncate text-sm text-gray-600 dark:text-gray-400"
                                    title="{{ $shortUrl->original_url }}"
                                >
                                    {{ $shortUrl->original_url }}
                                </p>

                            </td>


                            <!-- Clicks -->

                            <td class="whitespace-nowrap px-6 py-5">

                                <span class="text-sm font-medium text-gray-800 dark:text-white/90">
                                    {{ number_format($shortUrl->click_count) }}
                                </span>

                            </td>


                            <!-- Deleted At -->

                            <td class="whitespace-nowrap px-6 py-5">

                                <span class="text-sm text-gray-600 dark:text-gray-400">

                                    {{ $shortUrl->deleted_at->format('d M Y, h:i A') }}

                                </span>

                            </td>


                            <!-- Actions -->

                            <td class="whitespace-nowrap px-6 py-5">

                                <div class="flex items-center justify-end gap-2">


                                    <!-- Restore -->

                                    <form
                                        method="POST"
                                        action="{{ route('links.restore', $shortUrl->id) }}"
                                    >

                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            title="Restore link"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-green-200 text-green-600 transition hover:bg-green-50 dark:border-green-500/20 dark:text-green-400 dark:hover:bg-green-500/10"
                                        >

                                            <svg
                                                class="h-4 w-4"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M3 12a9 9 0 109-9 9.75 9.75 0 00-6.74 2.74L3 8"
                                                />

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M3 3v5h5"
                                                />

                                            </svg>

                                        </button>

                                    </form>


                                    <!-- Permanent Delete -->

                                    <form
                                        method="POST"
                                        action="{{ route('links.force-delete', $shortUrl->id) }}"
                                        onsubmit="return confirm('Permanently delete this link? This action cannot be undone.')"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            title="Delete permanently"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-red-200 text-red-500 transition hover:bg-red-50 dark:border-red-500/20 dark:text-red-400 dark:hover:bg-red-500/10"
                                        >

                                            <svg
                                                class="h-4 w-4"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m-7 0V4a1 1 0 011-1h4a1 1 0 011 1v3"
                                                />

                                            </svg>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="5"
                                class="px-6 py-16 text-center"
                            >

                                <div class="mx-auto flex max-w-sm flex-col items-center">

                                    <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">

                                        <svg
                                            class="h-8 w-8 text-gray-400"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 24 24"
                                        >

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="1.5"
                                                d="M3 7h18M5 7l1 13h12l1-13M9 7V4h6v3"
                                            />

                                        </svg>

                                    </div>


                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                                        Trash is empty
                                    </h3>

                                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                        Links you delete will appear here.
                                    </p>


                                    <a
                                        href="{{ route('links.index') }}"
                                        class="mt-5 inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-brand-600"
                                    >

                                        <svg
                                            class="h-4 w-4"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M15 19l-7-7 7-7"
                                            />

                                        </svg>

                                        Back to Links

                                    </a>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        <!-- Pagination -->

        @if($trashedLinks->hasPages())

            <div class="border-t border-gray-200 px-6 py-4 dark:border-gray-800">

                {{ $trashedLinks->links() }}

            </div>

        @endif


        @if($trashedLinks->count() > 0)

            <div class="border-t border-gray-200 px-6 py-4 dark:border-gray-800">

                <p class="text-sm text-gray-500 dark:text-gray-400">

                    Showing

                    <span class="font-medium text-gray-700 dark:text-gray-300">
                        {{ $trashedLinks->firstItem() }}
                    </span>

                    to

                    <span class="font-medium text-gray-700 dark:text-gray-300">
                        {{ $trashedLinks->lastItem() }}
                    </span>

                    of

                    <span class="font-medium text-gray-700 dark:text-gray-300">
                        {{ $trashedLinks->total() }}
                    </span>

                    deleted links.

                </p>

            </div>

        @endif

    </div>

</div>

@endsection