@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-7xl">

{{-- Page Header --}}
<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

    <div>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white/90">
            {{ $isFavorite ? 'Favorite Links' : ($isTrash ? 'Trash' : 'All Links') }}
        </h1>

        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            {{ $isFavorite
                ? 'Manage your favorite links.'
                : ($isTrash
                    ? 'Manage deleted links.'
                    : 'Manage all short links across the system.')
            }}
        </p>
    </div>

    <div class="flex flex-wrap items-center gap-3">

        {{-- Back to Dashboard --}}
        <a
            href="{{ route('admin.dashboard') }}"
            class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
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
                    d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"
                />
            </svg>

            Admin Dashboard
        </a>


        {{-- Create Link --}}
        @if(!$isTrash)

            <a
                href="{{ route('admin.links.create') }}"
                class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-brand-600"
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

                Create Link
            </a>

        @endif

    </div>

</div>


{{-- Success Notification --}}
@if(session('success'))

    <div
        x-data="{ show: true }"
        x-show="show"
        x-transition
        class="fixed right-6 top-6 z-[9999] w-full max-w-3xl"
    >

        <div
            class="overflow-hidden rounded-2xl border-2 border-green-300 bg-white shadow-2xl dark:border-green-700 dark:bg-gray-800"
        >

            <div class="h-2 w-full bg-green-500">
                <div
                    class="notification-progress h-full bg-green-600"
                    style="animation-duration: 5s;"
                ></div>
            </div>

            <div class="flex min-h-[240px] items-center gap-5 px-8 py-10">

                <div class="flex h-[82px] w-[82px] shrink-0 items-center justify-center rounded-full bg-green-100 dark:bg-green-900/30">

                    <svg
                        class="h-11 w-11 text-green-600 dark:text-green-400"
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

                <div class="flex-1">

                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white">
                        Success
                    </h3>

                    <p class="mt-2 text-2xl text-gray-600 dark:text-gray-300">
                        {{ session('success') }}
                    </p>

                </div>

                <button
                    type="button"
                    @click="show = false"
                    class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full text-gray-400 hover:bg-gray-100 hover:text-gray-600 dark:hover:bg-gray-700 dark:hover:text-gray-200"
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
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>

            </div>

        </div>

    </div>

@endif


{{-- Error Notification --}}
@if(session('error'))

    <div
        x-data="{ show: true }"
        x-show="show"
        x-transition
        class="fixed right-6 top-6 z-[9999] w-full max-w-3xl"
    >

        <div
            class="overflow-hidden rounded-2xl border-2 border-red-300 bg-white shadow-2xl dark:border-red-700 dark:bg-gray-800"
        >

            <div class="h-2 w-full bg-red-500">
                <div
                    class="notification-progress h-full bg-red-600"
                    style="animation-duration: 5s;"
                ></div>
            </div>

            <div class="flex min-h-[240px] items-center gap-5 px-8 py-10">

                <div class="flex h-[82px] w-[82px] shrink-0 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/30">

                    <svg
                        class="h-11 w-11 text-red-600 dark:text-red-400"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 9v4m0 4h.01M10.29 3.86l-8.82 15a2 2 0 001.73 3h17.6a2 2 0 001.73-3l-8.82-15a2 2 0 00-3.42 0z"
                        />
                    </svg>

                </div>

                <div class="flex-1">

                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white">
                        Error
                    </h3>

                    <p class="mt-2 text-xl text-gray-600 dark:text-gray-300">
                        {{ session('error') }}
                    </p>

                </div>

                <button
                    type="button"
                    @click="show = false"
                    class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full text-gray-400 hover:bg-gray-100 hover:text-gray-600 dark:hover:bg-gray-700 dark:hover:text-gray-200"
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
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>

            </div>

        </div>

    </div>

@endif


{{-- Filters --}}
<div class="mb-6 rounded-xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-gray-900">

    <form
        method="GET"
        action="{{ route('admin.links.index') }}"
    >

        {{-- Preserve Favorite Filter --}}
        @if($isFavorite)

            <input
                type="hidden"
                name="favorite"
                value="1"
            >

        @endif


        {{-- Preserve Trash Filter --}}
        @if($isTrash)

            <input
                type="hidden"
                name="trash"
                value="1"
            >

        @endif


        <div class="grid grid-cols-1 gap-4 md:grid-cols-4">

            {{-- Search --}}
            <div>

                <label
                    for="search"
                    class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                >
                    Search
                </label>

                <input
                    type="text"
                    id="search"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search links..."
                    class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-800 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                >

            </div>


            {{-- User Filter --}}
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
                    class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-800 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                >

                    <option value="">
                        All Users
                    </option>

                    @foreach($users as $user)

                        <option
                            value="{{ $user->id }}"
                            @selected(request('user_id') == $user->id)
                        >
                            {{ $user->name }} — {{ $user->email }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Status Filter --}}
            @if(!$isTrash)

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
                        class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-800 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                    >

                        <option value="">
                            All Statuses
                        </option>

                        <option
                            value="active"
                            @selected(request('status') === 'active')
                        >
                            Active
                        </option>

                        <option
                            value="disabled"
                            @selected(request('status') === 'disabled')
                        >
                            Disabled
                        </option>

                        <option
                            value="expired"
                            @selected(request('status') === 'expired')
                        >
                            Expired
                        </option>

                    </select>

                </div>

            @else

                <div></div>

            @endif


            {{-- Filter Buttons --}}
            <div class="flex items-end gap-2">

                <button
                    type="submit"
                    class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-600"
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
                            d="M3 4h18M6 12h12M10 20h4"
                        />
                    </svg>

                    Filter

                </button>


                <a
                    href="{{ route('admin.links.index') }}"
                    class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
                >
                    Reset
                </a>

            </div>

        </div>

    </form>

</div>


{{-- Links Table --}}
<div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900">

    <div class="overflow-x-auto">

        <table class="w-full table-fixed">

            <thead class="border-b border-gray-200 bg-gray-50 dark:border-gray-800 dark:bg-gray-800/50">

                <tr>

                    <th class="w-[32%] px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                        Link
                    </th>

                    <th class="w-[18%] px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                        Owner
                    </th>

                    <th class="w-[10%] px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                        Clicks
                    </th>

                    <th class="w-[12%] px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                        Status
                    </th>

                    <th class="w-[13%] px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                        Created
                    </th>

                    <th class="w-[15%] px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                        Actions
                    </th>

                </tr>

            </thead>


            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">

                @forelse($links as $link)

                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">

                        {{-- Link Column --}}
                        <td class="px-6 py-4">

                            <div class="min-w-0">

                                {{-- Short URL --}}
                                <div class="flex min-w-0 items-center gap-2">

                                    @if($link->is_favorite)

                                        <svg
                                            class="h-5 w-5 shrink-0 fill-current text-yellow-500"
                                            viewBox="0 0 20 20"
                                            aria-hidden="true"
                                        >
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.539 1.118l-2.8-2.034a1 1 0 00-1.176 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L3.71 8.719c-.783-.57-.38-1.81.588-1.81H7.76a1 1 0 00.95-.69l1.07-3.292z" />
                                        </svg>

                                    @endif


                                    {{-- Display ONLY /short-code --}}
                                    <a
                                        href="{{ url($link->custom_alias ?: $link->short_code) }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        title="{{ url($link->custom_alias ?: $link->short_code) }}"
                                        class="block min-w-0 truncate font-medium text-brand-600 hover:text-brand-700 hover:underline dark:text-brand-400 dark:hover:text-brand-300"
                                    >
                                        /{{ $link->custom_alias ?: $link->short_code }}
                                    </a>

                                </div>


                                {{-- Original URL --}}
                                <a
                                    href="{{ $link->original_url }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    title="{{ $link->original_url }}"
                                    class="mt-1 block max-w-full truncate text-sm text-gray-500 hover:text-brand-600 hover:underline dark:text-gray-400 dark:hover:text-brand-400"
                                >
                                    {{ \Illuminate\Support\Str::limit($link->original_url, 55, '...') }}
                                </a>

                            </div>

                        </td>


                        {{-- Owner --}}
                        <td class="px-6 py-4">

                            <div class="min-w-0">

                                <p
                                    class="truncate text-sm font-medium text-gray-800 dark:text-white"
                                    title="{{ $link->user?->name ?? 'Unknown User' }}"
                                >
                                    {{ $link->user?->name ?? 'Unknown User' }}
                                </p>

                                <p
                                    class="truncate text-xs text-gray-500 dark:text-gray-400"
                                    title="{{ $link->user?->email ?? '—' }}"
                                >
                                    {{ $link->user?->email ?? '—' }}
                                </p>

                            </div>

                        </td>


                        {{-- Clicks --}}
                        <td class="px-6 py-4">

                            <span class="text-sm font-medium text-gray-800 dark:text-white">
                                {{ number_format($link->click_count) }}
                            </span>

                        </td>


                        {{-- Status --}}
                        <td class="px-6 py-4">

                            @if($link->isExpired())

                                <span class="inline-flex rounded-full bg-red-100 px-2.5 py-1 text-xs font-medium text-red-700 dark:bg-red-900/30 dark:text-red-400">
                                    Expired
                                </span>

                            @elseif($link->isScheduled())

                                <span class="inline-flex rounded-full bg-yellow-100 px-2.5 py-1 text-xs font-medium text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400">
                                    Scheduled
                                </span>

                            @elseif($link->status === 'disabled')

                                <span class="inline-flex rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                                    Disabled
                                </span>

                            @elseif($link->status === 'expired')

                                <span class="inline-flex rounded-full bg-red-100 px-2.5 py-1 text-xs font-medium text-red-700 dark:bg-red-900/30 dark:text-red-400">
                                    Expired
                                </span>

                            @else

                                <span class="inline-flex rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-700 dark:bg-green-900/30 dark:text-green-400">
                                    Active
                                </span>

                            @endif

                        </td>


                        {{-- Created --}}
                        <td class="px-6 py-4">

                            <span class="text-sm text-gray-600 dark:text-gray-400">
                                {{ $link->created_at?->format('M d, Y') }}
                            </span>

                        </td>


                        {{-- Actions --}}
                        <td class="px-6 py-4">

                            <div class="flex items-center justify-end gap-2">

                                @if(!$isTrash)

                                    {{-- View --}}
                                    <a
                                        href="{{ route('admin.links.show', $link->id) }}"
                                        title="View"
                                        class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-500 transition hover:border-blue-300 hover:bg-blue-50 hover:text-blue-600 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:border-blue-700 dark:hover:bg-blue-900/20 dark:hover:text-blue-400"
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
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                            />

                                            <circle
                                                cx="12"
                                                cy="12"
                                                r="3"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                            />
                                        </svg>

                                    </a>


                                    {{-- Edit --}}
                                    <a
                                        href="{{ route('admin.links.edit', $link->id) }}"
                                        title="Edit"
                                        class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-500 transition hover:border-brand-300 hover:bg-brand-50 hover:text-brand-600 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:border-brand-700 dark:hover:bg-brand-900/20 dark:hover:text-brand-400"
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
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5"
                                            />

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"
                                            />
                                        </svg>

                                    </a>


                                    {{-- Favorite / Unfavorite --}}
                                    <form
                                        method="POST"
                                        action="{{ route('admin.links.favorite', $link->id) }}"
                                        class="inline"
                                    >

                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            title="{{ $link->is_favorite ? 'Unfavorite' : 'Favorite' }}"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 bg-white transition dark:border-gray-700 dark:bg-gray-800
                                                {{ $link->is_favorite
                                                    ? 'text-yellow-500 hover:border-yellow-300 hover:bg-yellow-50 hover:text-yellow-600 dark:text-yellow-400 dark:hover:border-yellow-700 dark:hover:bg-yellow-900/20'
                                                    : 'text-gray-500 hover:border-yellow-300 hover:bg-yellow-50 hover:text-yellow-500 dark:text-gray-400 dark:hover:border-yellow-700 dark:hover:bg-yellow-900/20 dark:hover:text-yellow-400'
                                                }}"
                                        >

                                            @if($link->is_favorite)

                                                <svg
                                                    class="h-5 w-5 fill-current"
                                                    viewBox="0 0 20 20"
                                                >
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.539 1.118l-2.8-2.034a1 1 0 00-1.176 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L3.71 8.719c-.783-.57-.38-1.81.588-1.81H7.76a1 1 0 00.95-.69l1.07-3.292z" />
                                                </svg>

                                            @else

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
                                                        d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.539 1.118l-2.8-2.034a1 1 0 00-1.176 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L3.71 8.719c-.783-.57-.38-1.81.588-1.81H7.76a1 1 0 00.95-.69l1.07-3.292z"
                                                    />
                                                </svg>

                                            @endif

                                        </button>

                                    </form>


                                    {{-- Delete --}}
                                    <form
                                        method="POST"
                                        action="{{ route('admin.links.destroy', $link->id) }}"
                                        class="inline"
                                        onsubmit="return confirm('Are you sure you want to move this link to trash?');"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            title="Delete"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-500 transition hover:border-red-300 hover:bg-red-50 hover:text-red-600 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:border-red-700 dark:hover:bg-red-900/20 dark:hover:text-red-400"
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
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7"
                                                />

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3M4 7h16M10 11v6M14 11v6"
                                                />
                                            </svg>

                                        </button>

                                    </form>

                                @else

                                    {{-- Restore --}}
                                    <form
                                        method="POST"
                                        action="{{ route('admin.links.restore', $link->id) }}"
                                        class="inline"
                                    >

                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            title="Restore"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-500 transition hover:border-green-300 hover:bg-green-50 hover:text-green-600 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:border-green-700 dark:hover:bg-green-900/20 dark:hover:text-green-400"
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


                                    {{-- Permanent Delete --}}
                                    <form
                                        method="POST"
                                        action="{{ route('admin.links.force-delete', $link->id) }}"
                                        class="inline"
                                        onsubmit="return confirm('This will permanently delete the link. Continue?');"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            title="Delete Permanently"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-500 transition hover:border-red-300 hover:bg-red-50 hover:text-red-600 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:border-red-700 dark:hover:bg-red-900/20 dark:hover:text-red-400"
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
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7"
                                                />

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3M4 7h16M10 11v6M14 11v6"
                                                />
                                            </svg>

                                        </button>

                                    </form>

                                @endif

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="6"
                            class="px-6 py-12 text-center"
                        >

                            <div class="flex flex-col items-center justify-center">

                                <svg
                                    class="mb-4 h-12 w-12 text-gray-400"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.5"
                                        d="M13.5 3H6a2 2 0 00-2 2v14a2 2 0 002 2h12a2 2 0 002-2V8.5L13.5 3z"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.5"
                                        d="M13 3v6h6"
                                    />
                                </svg>

                                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                                    No links found
                                </h3>

                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    There are no links matching your current filters.
                                </p>

                            </div>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    {{-- Pagination --}}
    @if($links->hasPages())

        <div class="border-t border-gray-200 px-6 py-4 dark:border-gray-800">
            {{ $links->links() }}
        </div>

    @endif

</div>
</div>

<style>
    @keyframes notification-progress {
        from {
            width: 100%;
        }

        to {
            width: 0%;
        }
    }

    .notification-progress {
        animation-name: notification-progress;
        animation-timing-function: linear;
        animation-fill-mode: forwards;
    }
</style>

<script>
    setTimeout(() => {
        document.querySelectorAll('[x-data]').forEach((element) => {
            if (element.__x) {
                element.__x.$data.show = false;
            }
        });
    }, 5000);
</script>

@endsection
