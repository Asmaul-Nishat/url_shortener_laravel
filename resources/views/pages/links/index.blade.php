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
                Manage and monitor all your shortened URLs.
            </p>
        </div>

        <a
            href="{{ route('links.create') }}"
            class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-4 py-3 text-sm font-medium text-white shadow-theme-xs transition hover:bg-brand-600"
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
                    d="M12 4v16m8-8H4"
                />
            </svg>

            Generate Short URL
        </a>

    </div>


    <!-- Success Message -->
    @if(session('success'))

        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 dark:border-green-500/20 dark:bg-green-500/10 dark:text-green-400">
            {{ session('success') }}
        </div>

    @endif


    <!-- Validation Errors -->
    @if($errors->any())

        <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 dark:border-red-500/20 dark:bg-red-500/10 dark:text-red-400">

            <ul class="list-inside list-disc space-y-1">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    <!-- Summary Cards -->

    @php

        $allLinks = \App\Models\ShortUrl::where(
            'user_id',
            auth()->id()
        )->get();

        $totalLinks = $allLinks->count();

        $activeLinks = $allLinks
            ->where('status', 'active')
            ->filter(function ($link) {
                return !$link->isExpired();
            })
            ->count();

        $expiredLinks = $allLinks
            ->filter(function ($link) {
                return $link->isExpired()
                    || $link->status === 'expired';
            })
            ->count();

        $totalClicks = $allLinks->sum('click_count');

    @endphp


    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">

        <!-- Total Links -->

        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Total Links
                    </p>

                    <h3 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">
                        {{ $totalLinks }}
                    </h3>

                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 dark:bg-blue-500/10">

                    <svg
                        class="h-6 w-6 text-blue-500"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M13.19 8.688l.086-.086a2.828 2.828 0 114 4l-3.5 3.5a2.828 2.828 0 01-4 0"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M10.81 15.312l-.086.086a2.828 2.828 0 11-4-4l3.5-3.5a2.828 2.828 0 014 0"
                        />
                    </svg>

                </div>

            </div>

        </div>


        <!-- Active Links -->

        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Active Links
                    </p>

                    <h3 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">
                        {{ $activeLinks }}
                    </h3>

                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-50 dark:bg-green-500/10">

                    <svg
                        class="h-6 w-6 text-green-500"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M5 13l4 4L19 7"
                        />
                    </svg>

                </div>

            </div>

        </div>


        <!-- Expired Links -->

        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Expired Links
                    </p>

                    <h3 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">
                        {{ $expiredLinks }}
                    </h3>

                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-red-50 dark:bg-red-500/10">

                    <svg
                        class="h-6 w-6 text-red-500"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 9v4m0 4h.01M10.29 3.86L2.82 17a2 2 0 001.74 3h14.88a2 2 0 001.74 3L13.71 3.86a2 2 0 00-3.42 0z"
                        />
                    </svg>

                </div>

            </div>

        </div>


        <!-- Total Clicks -->

        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Total Clicks
                    </p>

                    <h3 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">
                        {{ number_format($totalClicks) }}
                    </h3>

                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-50 dark:bg-purple-500/10">

                    <svg
                        class="h-6 w-6 text-purple-500"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M3 12h4l3-9 4 18 3-9h4"
                        />
                    </svg>

                </div>

            </div>

        </div>

    </div>


    <!-- Links Table Card -->

    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">


        <!-- Table Header -->

        <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">

            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                <div>

                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                        Your Short Links
                    </h2>

                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        View, manage and monitor your shortened URLs.
                    </p>

                </div>


                <!-- Search -->

                <div class="relative">

                    <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2">

                        <svg
                            class="h-5 w-5 text-gray-400"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M21 21l-4.35-4.35m2.35-5.65a8 8 0 11-16 0 8 8 0 0116 0z"
                            />
                        </svg>

                    </span>

                    <input
                        type="text"
                        id="linkSearch"
                        placeholder="Search links..."
                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent py-2.5 pl-10 pr-4 text-sm text-gray-800 outline-none transition placeholder:text-gray-400 focus:border-brand-500 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-gray-500 sm:w-72"
                    >

                </div>

            </div>


            <!-- Filters -->

            <div class="mt-4 flex flex-wrap gap-3">

                <select
                    id="statusFilter"
                    class="h-10 rounded-lg border border-gray-300 bg-transparent px-3 text-sm text-gray-700 outline-none focus:border-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                >

                    <option value="all">
                        All Status
                    </option>

                    <option value="active">
                        Active
                    </option>

                    <option value="expired">
                        Expired
                    </option>

                    <option value="disabled">
                        Disabled
                    </option>

                </select>


                <select
                    id="favoriteFilter"
                    class="h-10 rounded-lg border border-gray-300 bg-transparent px-3 text-sm text-gray-700 outline-none focus:border-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                >

                    <option value="all">
                        All Links
                    </option>

                    <option value="favorite">
                        Favorites
                    </option>

                    <option value="normal">
                        Non-Favorites
                    </option>

                </select>

            </div>

        </div>


        <!-- Table -->

        <div class="overflow-x-auto">

            <table
                id="linksTable"
                class="min-w-full"
            >

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
                            Status
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Expiry
                        </th>

                        <th class="px-6 py-4 text-right text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-200 dark:divide-gray-800">


                    @forelse($shortUrls as $shortUrl)

                        @php

                            $isExpired = $shortUrl->isExpired();

                            $displayStatus = $isExpired
                                ? 'expired'
                                : $shortUrl->status;

                        @endphp


                        <tr
                            class="link-row transition hover:bg-gray-50 dark:hover:bg-white/[0.02]"
                            data-status="{{ $displayStatus }}"
                            data-favorite="{{ $shortUrl->is_favorite ? 'favorite' : 'normal' }}"
                            data-search="{{ strtolower(
                                ($shortUrl->custom_alias ?: $shortUrl->short_code)
                                . ' '
                                . $shortUrl->original_url
                            ) }}"
                        >


                            <!-- Short Link -->

                            <td class="whitespace-nowrap px-6 py-5">

                                <div class="flex items-center gap-3">

                                    <!-- Favorite -->

                                    <form
                                        method="POST"
                                        action="{{ route('links.favorite', $shortUrl) }}"
                                    >

                                        @csrf

                                        <button
                                            type="submit"
                                            title="{{ $shortUrl->is_favorite ? 'Remove from favorites' : 'Add to favorites' }}"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg border transition
                                            {{ $shortUrl->is_favorite
                                                ? 'border-yellow-300 text-yellow-500 hover:bg-yellow-50 dark:border-yellow-500/30 dark:hover:bg-yellow-500/10'
                                                : 'border-gray-300 text-gray-500 hover:bg-gray-50 hover:text-yellow-500 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-yellow-400'
                                            }}"
                                        >

                                            <svg
                                                class="h-4 w-4"
                                                fill="{{ $shortUrl->is_favorite ? 'currentColor' : 'none' }}"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                                stroke-width="1.8"
                                            >

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M12 2.5l2.93 5.94 6.56.95-4.75 4.63 1.12 6.54L12 17.47l-5.86 3.09 1.12-6.54L2.51 9.39l6.56-.95L12 2.5z"
                                                />

                                            </svg>

                                        </button>

                                    </form>


                                    <div>

                                        <div class="flex items-center gap-2">

                                            <a
                                                href="{{ $shortUrl->short_url }}"
                                                target="_blank"
                                                class="font-medium text-brand-500 hover:underline"
                                            >
                                                {{ $shortUrl->custom_alias ?: $shortUrl->short_code }}
                                            </a>

                                        </div>

                                        <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">
                                            {{ $shortUrl->short_url }}
                                        </p>

                                    </div>

                                </div>

                            </td>


                            <!-- Original URL -->

                            <td class="max-w-xs px-6 py-5">

                                <a
                                    href="{{ $shortUrl->original_url }}"
                                    target="_blank"
                                    class="block truncate text-sm text-gray-600 hover:text-brand-500 dark:text-gray-400"
                                    title="{{ $shortUrl->original_url }}"
                                >
                                    {{ $shortUrl->original_url }}
                                </a>

                            </td>


                            <!-- Clicks -->

                            <td class="whitespace-nowrap px-6 py-5">

                                <span class="text-sm font-medium text-gray-800 dark:text-white/90">
                                    {{ number_format($shortUrl->click_count) }}
                                </span>

                            </td>


                            <!-- Status -->

                            <td class="whitespace-nowrap px-6 py-5">

                                @if($displayStatus === 'active')

                                    <span class="inline-flex items-center rounded-full bg-green-50 px-3 py-1 text-xs font-medium text-green-600 dark:bg-green-500/10 dark:text-green-400">

                                        <span class="mr-1.5 h-1.5 w-1.5 rounded-full bg-green-500"></span>

                                        Active

                                    </span>

                                @elseif($displayStatus === 'expired')

                                    <span class="inline-flex items-center rounded-full bg-red-50 px-3 py-1 text-xs font-medium text-red-600 dark:bg-red-500/10 dark:text-red-400">

                                        <span class="mr-1.5 h-1.5 w-1.5 rounded-full bg-red-500"></span>

                                        Expired

                                    </span>

                                @else

                                    <span class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600 dark:bg-gray-500/10 dark:text-gray-400">

                                        <span class="mr-1.5 h-1.5 w-1.5 rounded-full bg-gray-500"></span>

                                        Disabled

                                    </span>

                                @endif

                            </td>


                            <!-- Expiry -->

                            <td class="whitespace-nowrap px-6 py-5">

                                @if($shortUrl->expires_at)

                                    @if($isExpired)

                                        <span class="text-sm text-red-500">
                                            Expired
                                        </span>

                                    @else

                                        <span class="text-sm text-gray-600 dark:text-gray-400">
                                            {{ $shortUrl->expires_at->format('d M Y, h:i A') }}
                                        </span>

                                    @endif

                                @else

                                    <span class="text-sm text-gray-400">
                                        Never
                                    </span>

                                @endif

                            </td>


                            <!-- Actions -->

                            <td class="whitespace-nowrap px-6 py-5">

                                <div class="flex items-center justify-end gap-2">


                                    <!-- Copy -->

                                    <button
                                        type="button"
                                        onclick="copyShortUrl('{{ $shortUrl->short_url }}', this)"
                                        title="Copy short URL"
                                        class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-gray-300 text-gray-500 transition hover:bg-gray-50 hover:text-brand-500 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-brand-400"
                                    >

                                        <svg
                                            class="copy-icon h-4 w-4"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 4h8a2 2 0 012 2v6a2 2 0 01-2 2h-8a2 2 0 01-2-2v-6a2 2 0 012-2z"
                                            />

                                        </svg>

                                    </button>


                                    <!-- Open -->

                                    <a
                                        href="{{ $shortUrl->short_url }}"
                                        target="_blank"
                                        title="Open short URL"
                                        class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-gray-300 text-gray-500 transition hover:bg-gray-50 hover:text-brand-500 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-brand-400"
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
                                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4"
                                            />

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M14 4h6m0 0v6m0-6L10 14"
                                            />

                                        </svg>

                                    </a>


                                    <!-- Delete / Move to Trash -->

                                    <form
                                        method="POST"
                                        action="{{ route('links.destroy', $shortUrl) }}"
                                        onsubmit="return confirm('Move this link to Trash?')"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            title="Move to Trash"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-red-200 text-red-500 transition hover:bg-red-50 hover:text-red-600 dark:border-red-500/20 dark:text-red-400 dark:hover:bg-red-500/10"
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
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7"
                                                />

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"
                                                />

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M4 7h16"
                                                />

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M10 11v6m4-6v6"
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
                                colspan="6"
                                class="px-6 py-16 text-center"
                            >

                                <div class="mx-auto flex max-w-sm flex-col items-center">

                                    <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">

                                        <svg
                                            class="h-8 w-8 text-gray-400"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="1.5"
                                                d="M13.19 8.688l.086-.086a2.828 2.828 0 114 4l-3.5 3.5a2.828 2.828 0 01-4 0"
                                            />

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="1.5"
                                                d="M10.81 15.312l-.086.086a2.828 2.828 0 11-4-4l3.5-3.5a2.828 2.828 0 014 0"
                                            />

                                        </svg>

                                    </div>


                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                                        No short links yet
                                    </h3>

                                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                        Create your first short URL to start managing your links.
                                    </p>


                                    <a
                                        href="{{ route('links.create') }}"
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
                                                d="M12 4v16m8-8H4"
                                            />

                                        </svg>

                                        Create Short URL

                                    </a>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        <!-- Pagination -->

        @if($shortUrls->hasPages())

            <div class="border-t border-gray-200 px-6 py-4 dark:border-gray-800">

                {{ $shortUrls->links() }}

            </div>

        @endif


        @if($shortUrls->count() > 0)

            <div class="border-t border-gray-200 px-6 py-4 dark:border-gray-800">

                <p class="text-sm text-gray-500 dark:text-gray-400">

                    Showing

                    <span class="font-medium text-gray-700 dark:text-gray-300">
                        {{ $shortUrls->firstItem() }}
                    </span>

                    to

                    <span class="font-medium text-gray-700 dark:text-gray-300">
                        {{ $shortUrls->lastItem() }}
                    </span>

                    of

                    <span class="font-medium text-gray-700 dark:text-gray-300">
                        {{ $shortUrls->total() }}
                    </span>

                    links

                </p>

            </div>

        @endif

    </div>

</div>


<!-- Copy URL Script -->

<script>

function copyShortUrl(url, button) {

    navigator.clipboard.writeText(url)
        .then(function () {

            const originalHtml = button.innerHTML;

            button.innerHTML = `
                <svg
                    class="h-4 w-4 text-green-500"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M5 13l4 4L19 7"
                    />
                </svg>
            `;

            button.title = 'Copied!';

            setTimeout(function () {

                button.innerHTML = originalHtml;

                button.title = 'Copy short URL';

            }, 1500);

        })
        .catch(function () {

            alert('Unable to copy the URL.');

        });

}


/*
|--------------------------------------------------------------------------
| Search
|--------------------------------------------------------------------------
*/

document
    .getElementById('linkSearch')
    .addEventListener('input', function () {

        applyFilters();

    });


/*
|--------------------------------------------------------------------------
| Status Filter
|--------------------------------------------------------------------------
*/

document
    .getElementById('statusFilter')
    .addEventListener('change', function () {

        applyFilters();

    });


/*
|--------------------------------------------------------------------------
| Favorite Filter
|--------------------------------------------------------------------------
*/

document
    .getElementById('favoriteFilter')
    .addEventListener('change', function () {

        applyFilters();

    });


/*
|--------------------------------------------------------------------------
| Apply Search + Filters
|--------------------------------------------------------------------------
*/

function applyFilters() {

    const searchValue =
        document
            .getElementById('linkSearch')
            .value
            .toLowerCase()
            .trim();

    const status =
        document
            .getElementById('statusFilter')
            .value;

    const favorite =
        document
            .getElementById('favoriteFilter')
            .value;


    document
        .querySelectorAll('.link-row')
        .forEach(function (row) {

            const searchableText =
                row.dataset.search || '';

            const rowStatus =
                row.dataset.status || '';

            const rowFavorite =
                row.dataset.favorite || 'normal';


            const matchesSearch =
                searchableText.includes(searchValue);

            const matchesStatus =
                status === 'all'
                || rowStatus === status;

            const matchesFavorite =
                favorite === 'all'
                || rowFavorite === favorite;


            row.style.display =
                matchesSearch
                && matchesStatus
                && matchesFavorite
                    ? ''
                    : 'none';

        });

}

</script>

@endsection