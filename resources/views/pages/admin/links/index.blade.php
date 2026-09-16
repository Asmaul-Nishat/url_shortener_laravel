@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-7xl">
    
{{-- Page Header --}}
<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

    <div>

        <div class="mb-2 flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">

            <a
                href="{{ route('admin.dashboard') }}"
                class="hover:text-brand-500"
            >
                Admin Dashboard
            </a>

            <span>/</span>

            <span class="text-gray-700 dark:text-gray-300">
                Links
            </span>

        </div>


        <h1 class="text-2xl font-bold text-gray-800 dark:text-white/90">
            All Links
        </h1>

        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Manage short links created by all users.
        </p>

    </div>


    <div class="flex items-center gap-3">

        <a
            href="{{ route('admin.dashboard') }}"
            class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/[0.03]"
        >
            Admin Dashboard
        </a>

    </div>

</div>


{{-- Flash Messages --}}
@if(session('success'))

    <div class="mb-6 rounded-lg border border-success-200 bg-success-50 px-4 py-3 text-sm text-success-700 dark:border-success-500/30 dark:bg-success-500/10 dark:text-success-400">
        {{ session('success') }}
    </div>

@endif


@if(session('error'))

    <div class="mb-6 rounded-lg border border-error-200 bg-error-50 px-4 py-3 text-sm text-error-700 dark:border-error-500/30 dark:bg-error-500/10 dark:text-error-400">
        {{ session('error') }}
    </div>

@endif


{{-- Filters --}}
<div class="mb-6 rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

    <form
        method="GET"
        action="{{ route('admin.links.index') }}"
    >

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">

            {{-- Search --}}
            <div class="lg:col-span-2">

                <label
                    for="search"
                    class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                >
                    Search
                </label>

                <input
                    id="search"
                    name="search"
                    type="text"
                    value="{{ request('search') }}"
                    placeholder="URL, short code, user name or email"
                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 outline-none focus:border-brand-500 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                >

            </div>


            {{-- User --}}
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
                    class="h-11 w-full rounded-lg border border-gray-300 bg-white px-4 text-sm text-gray-800 outline-none focus:border-brand-500 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
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


            {{-- Status --}}
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
                    class="h-11 w-full rounded-lg border border-gray-300 bg-white px-4 text-sm text-gray-800 outline-none focus:border-brand-500 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                >

                    <option value="">
                        All
                    </option>

                    <option
                        value="active"
                        @selected(request('status') === 'active')
                    >
                        Active
                    </option>

                    <option
                        value="expired"
                        @selected(request('status') === 'expired')
                    >
                        Expired
                    </option>

                    <option
                        value="scheduled"
                        @selected(request('status') === 'scheduled')
                    >
                        Scheduled
                    </option>

                </select>

            </div>

        </div>


        <div class="mt-4 flex flex-wrap items-center gap-3">

            <button
                type="submit"
                class="inline-flex items-center justify-center rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600"
            >
                Filter Links
            </button>


            <a
                href="{{ route('admin.links.index') }}"
                class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/[0.03]"
            >
                Reset
            </a>


            <a
                href="{{ route('admin.links.index', ['trash' => '1']) }}"
                class="inline-flex items-center justify-center rounded-lg border border-error-300 bg-error-50 px-4 py-2.5 text-sm font-medium text-error-700 hover:bg-error-100 dark:border-error-500/30 dark:bg-error-500/10 dark:text-error-400"
            >
                View Trash
            </a>

        </div>

    </form>

</div>


{{-- Links Table --}}
<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

    <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">

        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                    All Short Links
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Links from every registered user.
                </p>

            </div>


            <span class="text-sm text-gray-500 dark:text-gray-400">
                {{ $links->total() }} total
            </span>

        </div>

    </div>


    @if($links->count())

        <div class="overflow-x-auto">

            <table class="min-w-full">

                <thead>

                    <tr class="border-b border-gray-200 dark:border-gray-800">

                        <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Link
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Owner
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Clicks
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Status
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Created
                        </th>

                        <th class="px-6 py-4 text-right text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-200 dark:divide-gray-800">

                    @foreach($links as $link)

                        <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02]">

                            {{-- Link --}}
                            <td class="px-6 py-4">

                                <div class="max-w-sm">

                                    <p class="truncate text-sm font-medium text-gray-800 dark:text-white/90">
                                        {{ $link->original_url }}
                                    </p>

                                    <p class="mt-1 text-xs text-brand-500">
                                        {{ $link->custom_alias ?: $link->short_code }}
                                    </p>

                                </div>

                            </td>


                            {{-- Owner --}}
                            <td class="px-6 py-4">

                                @if($link->user)

                                    <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                                        {{ $link->user->name }}
                                    </p>

                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        {{ $link->user->email }}
                                    </p>

                                @else

                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                        Unknown
                                    </span>

                                @endif

                            </td>


                            {{-- Clicks --}}
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                {{ number_format($link->click_count) }}
                            </td>


                            {{-- Status --}}
                            <td class="whitespace-nowrap px-6 py-4">

                                @if($link->isExpired())

                                    <span class="inline-flex rounded-full bg-error-50 px-3 py-1 text-xs font-medium text-error-700 dark:bg-error-500/10 dark:text-error-400">
                                        Expired
                                    </span>

                                @elseif($link->isScheduled())

                                    <span class="inline-flex rounded-full bg-warning-50 px-3 py-1 text-xs font-medium text-warning-700 dark:bg-warning-500/10 dark:text-warning-400">
                                        Scheduled
                                    </span>

                                @else

                                    <span class="inline-flex rounded-full bg-success-50 px-3 py-1 text-xs font-medium text-success-700 dark:bg-success-500/10 dark:text-success-400">
                                        Active
                                    </span>

                                @endif

                            </td>


                            {{-- Created --}}
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                {{ $link->created_at?->format('M d, Y') ?? '—' }}
                            </td>


                            {{-- Actions --}}
                            <td class="whitespace-nowrap px-6 py-4 text-right">

                                {{-- View --}}
                                <a
                                    href="{{ route('admin.links.show', $link) }}"
                                    class="text-sm font-medium text-brand-500 hover:text-brand-600"
                                >
                                    View
                                </a>


                                {{-- Edit --}}
                                @if(!$link->trashed())

                                    <a
                                        href="{{ route('admin.links.edit', $link) }}"
                                        class="ml-3 text-sm font-medium text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200"
                                    >
                                        Edit
                                    </a>

                                @endif


                                {{-- Delete --}}
                                @if(!$link->trashed())

                                    <form
                                        method="POST"
                                        action="{{ route('admin.links.destroy', $link) }}"
                                        class="ml-3 inline"
                                        onsubmit="return confirm('Move this link to trash?');"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="text-sm font-medium text-error-500 hover:text-error-600"
                                        >
                                            Delete
                                        </button>

                                    </form>

                                @endif

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>


        {{-- Pagination --}}
        @if($links->hasPages())

            <div class="border-t border-gray-200 px-6 py-4 dark:border-gray-800">
                {{ $links->links() }}
            </div>

        @endif

    @else

        <div class="px-6 py-12 text-center">

            <h3 class="text-sm font-medium text-gray-800 dark:text-white/90">
                No links found
            </h3>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                There are no links matching your current filters.
            </p>

        </div>

    @endif

</div>

</div>

@endsection
