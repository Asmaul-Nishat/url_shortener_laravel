@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-7xl">

<!-- Page Header -->

<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

    <div>

        <h1 class="text-2xl font-bold text-gray-800 dark:text-white/90">
            Favorites
        </h1>

        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Quickly access your favorite short links.
        </p>

    </div>


    <a
        href="{{ route('links.create') }}"
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


<!-- Success Message -->

@if(session('success'))

    <div
        class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 dark:border-green-500/20 dark:bg-green-500/10 dark:text-green-400"
    >
        {{ session('success') }}
    </div>

@endif


<!-- Favorites Card -->

<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">


    <!-- Card Header -->

    <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">

        <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
            Favorite Links
        </h2>

        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Your saved favorite links appear here.
        </p>

    </div>


    <!-- Table -->

    <div class="overflow-x-auto">

        <table class="w-full min-w-[900px]">

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

                    <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                        Actions
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse($favoriteLinks as $shortUrl)

                    @php
                        $isExpired = $shortUrl->isExpired();

                        if ($isExpired && $shortUrl->status === 'active') {
                            $displayStatus = 'expired';
                        } else {
                            $displayStatus = $shortUrl->status;
                        }
                    @endphp


                    <tr class="border-b border-gray-200 transition hover:bg-gray-50 dark:border-gray-800 dark:hover:bg-white/[0.02]">


                        <!-- Short Link -->

                        <td class="px-6 py-5">

                            <div class="flex items-center gap-3">

                                <!-- Star -->

                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-yellow-50 text-yellow-500 dark:bg-yellow-500/10">

                                    <svg
                                        class="h-5 w-5"
                                        fill="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            d="M12 2.5l2.93 5.94 6.56.95-4.75 4.63 1.12 6.54L12 17.47l-5.86 3.09 1.12-6.54L2.51 9.39l6.56-.95L12 2.5z"
                                        />
                                    </svg>

                                </div>


                                <div>

                                    <a
                                        href="{{ $shortUrl->short_url }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="text-sm font-semibold text-brand-500 hover:underline"
                                    >
                                        /{{ $shortUrl->custom_alias ?: $shortUrl->short_code }}
                                    </a>

                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        {{ $shortUrl->created_at->diffForHumans() }}
                                    </p>

                                </div>

                            </div>

                        </td>


                        <!-- Original URL -->

                        <td class="max-w-xs px-6 py-5">

                            <a
                                href="{{ $shortUrl->original_url }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                title="{{ $shortUrl->original_url }}"
                                class="block max-w-xs truncate text-sm text-gray-600 hover:text-brand-500 dark:text-gray-300"
                            >
                                {{ $shortUrl->original_url }}
                            </a>

                        </td>


                        <!-- Clicks -->

                        <td class="px-6 py-5">

                            <span class="text-sm font-medium text-gray-800 dark:text-white/90">
                                {{ number_format($shortUrl->click_count) }}
                            </span>

                        </td>


                        <!-- Status -->

                        <td class="px-6 py-5">

                            @if($displayStatus === 'active')

                                <span class="inline-flex rounded-full bg-green-50 px-3 py-1 text-xs font-medium text-green-600 dark:bg-green-500/10 dark:text-green-400">
                                    Active
                                </span>

                            @elseif($displayStatus === 'expired')

                                <span class="inline-flex rounded-full bg-red-50 px-3 py-1 text-xs font-medium text-red-600 dark:bg-red-500/10 dark:text-red-400">
                                    Expired
                                </span>

                            @else

                                <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600 dark:bg-gray-500/10 dark:text-gray-400">
                                    Disabled
                                </span>

                            @endif

                        </td>


                        <!-- Actions -->

                        <td class="px-6 py-5">

                            <div class="flex items-center justify-end gap-2">


                                <!-- Unfavorite -->

                                <form
                                    method="POST"
                                    action="{{ route('links.favorite', $shortUrl) }}"
                                >

                                    @csrf

                                    <button
                                        type="submit"
                                        title="Remove from favorites"
                                        class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-yellow-300 text-yellow-500 transition hover:bg-yellow-50 dark:border-yellow-500/30 dark:hover:bg-yellow-500/10"
                                    >

                                        <svg
                                            class="h-4 w-4"
                                            fill="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                d="M12 2.5l2.93 5.94 6.56.95-4.75 4.63 1.12 6.54L12 17.47l-5.86 3.09 1.12-6.54L2.51 9.39l6.56-.95L12 2.5z"
                                            />
                                        </svg>

                                    </button>

                                </form>


                                <!-- Copy -->

                                <button
                                    type="button"
                                    title="Copy"
                                    onclick="copyShortUrl('{{ $shortUrl->short_url }}', this)"
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


                                <!-- Open -->

                                <a
                                    href="{{ $shortUrl->short_url }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    title="Open"
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
                                            d="M10 6H6a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-4M14 4h6m0 0v6m0-6L10 14"
                                        />
                                    </svg>

                                </a>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="5"
                            class="px-6 py-16 text-center"
                        >

                            <div class="flex flex-col items-center justify-center">

                                <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-gray-100 text-gray-400 dark:bg-gray-800">

                                    <svg
                                        class="h-7 w-7"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 2.5l2.93 5.94 6.56.95-4.75 4.63 1.12 6.54L12 17.47l-5.86 3.09 1.12-6.54L2.51 9.39l6.56-.95L12 2.5z"
                                        />
                                    </svg>

                                </div>


                                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                                    No favorite links
                                </h3>


                                <p class="mt-1 max-w-md text-sm text-gray-500 dark:text-gray-400">
                                    You have not added any links to your favorites yet.
                                </p>


                                <a
                                    href="{{ route('links.index') }}"
                                    class="mt-5 inline-flex items-center justify-center rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-brand-600"
                                >
                                    View All Links
                                </a>

                            </div>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    <!-- Pagination -->

    @if($favoriteLinks->total() > 0)

        <div class="flex flex-col gap-3 border-t border-gray-200 px-6 py-4 sm:flex-row sm:items-center sm:justify-between dark:border-gray-800">

            <p class="text-sm text-gray-500 dark:text-gray-400">

                Showing
                <span class="font-medium text-gray-700 dark:text-gray-300">
                    {{ $favoriteLinks->firstItem() }}
                </span>

                to

                <span class="font-medium text-gray-700 dark:text-gray-300">
                    {{ $favoriteLinks->lastItem() }}
                </span>

                of

                <span class="font-medium text-gray-700 dark:text-gray-300">
                    {{ $favoriteLinks->total() }}
                </span>

                favorite links

            </p>


            <div>
                {{ $favoriteLinks->links() }}
            </div>

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
                    class="h-4 w-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M5 13l4 4L19 7"
                    />
                </svg>
            `;

            button.setAttribute('title', 'Copied');

            setTimeout(function () {

                button.innerHTML = originalHtml;

                button.setAttribute('title', 'Copy');

            }, 1500);

        })
        .catch(function () {

            alert('Unable to copy the URL.');

        });

}

</script>

@endsection
