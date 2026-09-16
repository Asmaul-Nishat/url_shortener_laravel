@extends('layouts.app')

@section('content')

{{-- ============================================================
TOP-RIGHT NOTIFICATIONS
============================================================ --}}

<div class="fixed right-6 top-6 z-[9999] w-full max-w-3xl space-y-4">

{{-- SUCCESS NOTIFICATION --}}
@if(session('success'))

    <div
        x-data="{ show: true }"
        x-show="show"
        x-init="setTimeout(() => show = false, 5000)"
        x-transition:enter="transform transition ease-out duration-300"
        x-transition:enter-start="translate-y-4 opacity-0 scale-95"
        x-transition:enter-end="translate-y-0 opacity-100 scale-100"
        x-transition:leave="transform transition ease-in duration-200"
        x-transition:leave-start="translate-y-0 opacity-100 scale-100"
        x-transition:leave-end="translate-y-2 opacity-0 scale-95"
        class="relative overflow-hidden rounded-2xl border-2 border-green-300 bg-green-50 shadow-[0_8px_30px_rgba(0,0,0,0.12)] dark:border-green-700 dark:bg-green-950/40"
    >

        {{-- Progress Bar --}}
        <div
            class="absolute left-0 top-0 h-2 w-full bg-green-500"
            style="animation: notification-progress 5s linear forwards;"
        ></div>

        <div class="flex min-h-[240px] items-start gap-5 px-8 py-10">

            {{-- Success Icon --}}
            <div class="flex h-[88px] w-[88px] shrink-0 items-center justify-center rounded-full bg-[#52AD82] text-white">

                <svg
                    class="h-12 w-12"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2.5"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M5 13l4 4L19 7"
                    />
                </svg>

            </div>

            {{-- Success Content --}}
            <div class="min-w-0 flex-1 pt-1">

                <h3 class="text-4xl font-semibold tracking-wide text-green-800 dark:text-green-300">
                    Success
                </h3>

                <p class="mt-3 max-w-2xl text-3xl font-light leading-relaxed tracking-wider text-green-700 dark:text-green-200">
                    {{ session('success') }}
                </p>

            </div>

            {{-- Close Button --}}
            <button
                type="button"
                @click="show = false"
                class="shrink-0 text-green-700 transition hover:text-green-900 dark:text-green-300 dark:hover:text-white"
            >

                <svg
                    class="h-8 w-8"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M6 18L18 6M6 6l12 12"
                    />
                </svg>

            </button>

        </div>

    </div>

@endif


{{-- ERROR NOTIFICATION --}}
@if(session('error'))

    <div
        x-data="{ show: true }"
        x-show="show"
        x-init="setTimeout(() => show = false, 7000)"
        x-transition:enter="transform transition ease-out duration-300"
        x-transition:enter-start="translate-y-4 opacity-0 scale-95"
        x-transition:enter-end="translate-y-0 opacity-100 scale-100"
        x-transition:leave="transform transition ease-in duration-200"
        x-transition:leave-start="translate-y-0 opacity-100 scale-100"
        x-transition:leave-end="translate-y-2 opacity-0 scale-95"
        class="relative overflow-hidden rounded-2xl border-2 border-red-300 bg-red-50 shadow-[0_8px_30px_rgba(0,0,0,0.12)] dark:border-red-700 dark:bg-red-950/40"
    >

        {{-- Progress Bar --}}
        <div
            class="absolute left-0 top-0 h-2 w-full bg-red-500"
            style="animation: notification-progress 7s linear forwards;"
        ></div>

        <div class="flex min-h-[240px] items-start gap-5 px-8 py-10">

            {{-- Error Icon --}}
            <div class="flex h-[88px] w-[88px] shrink-0 items-center justify-center rounded-full bg-red-500 text-white">

                <svg
                    class="h-12 w-12"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2.5"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 9v4"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 17h.01"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"
                    />
                </svg>

            </div>

            {{-- Error Content --}}
            <div class="min-w-0 flex-1 pt-1">

                <h3 class="text-4xl font-semibold tracking-wide text-red-800 dark:text-red-300">
                    Error
                </h3>

                <div class="mt-3 space-y-2">

                    {{ session('error') }}

                </div>

            </div>

            {{-- Close Button --}}
            <button
                type="button"
                @click="show = false"
                class="shrink-0 text-red-700 transition hover:text-red-900 dark:text-red-300 dark:hover:text-white"
            >

                <svg
                    class="h-8 w-8"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M6 18L18 6M6 6l12 12"
                    />
                </svg>

            </button>

        </div>

    </div>

@endif

</div>

{{-- ============================================================
PAGE CONTENT
============================================================ --}}

<div class="mx-auto max-w-7xl">

{{-- Page Header --}}

<div class="mb-6">

<div class="mb-2 flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">


</div>


<div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

    <div>

        <h1 class="text-2xl font-bold text-gray-800 dark:text-white/90">
            Link Details
        </h1>

        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            View complete information about this short link.
        </p>

    </div>


    <div class="flex flex-wrap items-center gap-3">

        {{-- Back to Links --}}
        <a
            href="{{ route('admin.links.index') }}"
            class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/[0.03]"
        >
            Back to Links
        </a>


        {{-- Edit Link --}}
        @if(!$shortUrl->trashed())

            <a
                href="{{ route('admin.links.edit', $shortUrl) }}"
                class="inline-flex items-center justify-center rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600"
            >
                Edit Link
            </a>

        @endif


        {{-- Move to Trash --}}
        @if(!$shortUrl->trashed())

            <form
                method="POST"
                action="{{ route('admin.links.destroy', $shortUrl) }}"
                onsubmit="return confirm('Move this link to trash?');"
            >

                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-lg bg-error-500 px-4 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-error-600"
                >
                    Move to Trash
                </button>

            </form>

        @endif

    </div>

</div>

</div>

<div class="grid grid-cols-1 gap-6 xl:grid-cols-3">


{{-- Main Link Information --}}
<div class="xl:col-span-2">

    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

        <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">

            <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                Link Information
            </h2>

        </div>


        <div class="p-6">

            <div class="space-y-6">

                {{-- Original URL --}}
                <div>

                    <label class="mb-2 block text-sm font-medium text-gray-500 dark:text-gray-400">
                        Original URL
                    </label>

                    <div class="rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 dark:border-gray-700 dark:bg-gray-900">

                        <a
                            href="{{ $shortUrl->original_url }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="break-all text-sm font-medium text-brand-500 hover:text-brand-600"
                        >
                            {{ $shortUrl->original_url }}
                        </a>

                    </div>

                </div>


                {{-- Short URL --}}
                <div>

                    <label class="mb-2 block text-sm font-medium text-gray-500 dark:text-gray-400">
                        Short URL
                    </label>

                    <div class="flex flex-col gap-3 sm:flex-row">

                        <div class="flex-1 rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 dark:border-gray-700 dark:bg-gray-900">

                            <a
                                href="{{ $shortUrl->short_url }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="break-all text-sm font-medium text-brand-500 hover:text-brand-600"
                            >
                                {{ $shortUrl->short_url }}
                            </a>

                        </div>


                        <button
                            type="button"
                            onclick="navigator.clipboard.writeText(@js($shortUrl->short_url)); this.innerText='Copied'; setTimeout(() => this.innerText='Copy', 1500);"
                            class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/[0.03]"
                        >
                            Copy
                        </button>

                    </div>

                </div>


                {{-- Alias / Code --}}
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">

                    {{-- Custom Alias --}}
                    <div>

                        <label class="mb-2 block text-sm font-medium text-gray-500 dark:text-gray-400">
                            Custom Alias
                        </label>

                        <div class="rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                            {{ $shortUrl->custom_alias ?: 'Not set' }}
                        </div>

                    </div>


                    {{-- Short Code --}}
                    <div>

                        <label class="mb-2 block text-sm font-medium text-gray-500 dark:text-gray-400">
                            Short Code
                        </label>

                        <div class="rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                            {{ $shortUrl->short_code }}
                        </div>

                    </div>

                </div>


                {{-- Clicks / Favorite / Password --}}
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">

                    {{-- Total Clicks --}}
                    <div>

                        <label class="mb-2 block text-sm font-medium text-gray-500 dark:text-gray-400">
                            Total Clicks
                        </label>

                        <div class="text-2xl font-bold text-gray-800 dark:text-white/90">
                            {{ number_format($shortUrl->click_count) }}
                        </div>

                    </div>


                    {{-- Favorite --}}
                    <div>

                        <label class="mb-2 block text-sm font-medium text-gray-500 dark:text-gray-400">
                            Favorite
                        </label>

                        @if($shortUrl->is_favorite)

                            <span class="inline-flex rounded-full bg-warning-50 px-3 py-1 text-xs font-medium text-warning-700 dark:bg-warning-500/10 dark:text-warning-400">
                                Yes
                            </span>

                        @else

                            <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600 dark:bg-gray-800 dark:text-gray-400">
                                No
                            </span>

                        @endif

                    </div>


                    {{-- Password Protection --}}
                    <div>

                        <label class="mb-2 block text-sm font-medium text-gray-500 dark:text-gray-400">
                            Password Protection
                        </label>

                        @if($shortUrl->isPasswordProtected())

                            <span class="inline-flex rounded-full bg-warning-50 px-3 py-1 text-xs font-medium text-warning-700 dark:bg-warning-500/10 dark:text-warning-400">
                                Protected
                            </span>

                        @else

                            <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600 dark:bg-gray-800 dark:text-gray-400">
                                Not Protected
                            </span>

                        @endif

                    </div>

                </div>


                {{-- Dates --}}
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">

                    {{-- Created --}}
                    <div>

                        <label class="mb-2 block text-sm font-medium text-gray-500 dark:text-gray-400">
                            Created
                        </label>

                        <p class="text-sm text-gray-800 dark:text-white/90">
                            {{ $shortUrl->created_at?->format('M d, Y h:i A') ?? '—' }}
                        </p>

                    </div>


                    {{-- Expires --}}
                    <div>

                        <label class="mb-2 block text-sm font-medium text-gray-500 dark:text-gray-400">
                            Expires At
                        </label>

                        <p class="text-sm text-gray-800 dark:text-white/90">
                            {{ $shortUrl->expires_at?->format('M d, Y h:i A') ?? 'Never' }}
                        </p>

                    </div>


                    {{-- Scheduled --}}
                    <div>

                        <label class="mb-2 block text-sm font-medium text-gray-500 dark:text-gray-400">
                            Scheduled At
                        </label>

                        <p class="text-sm text-gray-800 dark:text-white/90">
                            {{ $shortUrl->scheduled_at?->format('M d, Y h:i A') ?? 'Not scheduled' }}
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Recent Clicks --}}
    <div class="mt-6 rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

        <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">

            <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                Recent Clicks
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Recent activity for this short link.
            </p>

        </div>


        @if($shortUrl->clicks->count())

            <div class="overflow-x-auto">

                <table class="min-w-full">

                    <thead>

                        <tr class="border-b border-gray-200 dark:border-gray-800">

                            <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                IP Address
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Referrer
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                User Agent
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Clicked At
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-gray-200 dark:divide-gray-800">

                        @foreach($shortUrl->clicks->sortByDesc('clicked_at')->take(10) as $click)

                            <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02]">

                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-800 dark:text-white/90">
                                    {{ $click->ip_address ?: '—' }}
                                </td>


                                <td class="max-w-xs px-6 py-4">

                                    @if($click->referer)

                                        <p class="truncate text-sm text-gray-700 dark:text-gray-300">
                                            {{ $click->referer }}
                                        </p>

                                    @else

                                        <span class="text-sm text-gray-500 dark:text-gray-400">
                                            Direct
                                        </span>

                                    @endif

                                </td>


                                <td class="max-w-sm px-6 py-4">

                                    <p
                                        class="truncate text-sm text-gray-700 dark:text-gray-300"
                                        title="{{ $click->user_agent }}"
                                    >
                                        {{ $click->user_agent ?: '—' }}
                                    </p>

                                </td>


                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                    {{ $click->clicked_at?->format('M d, Y h:i A') ?? '—' }}
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="px-6 py-10 text-center">

                <h3 class="text-sm font-medium text-gray-800 dark:text-white/90">
                    No clicks yet
                </h3>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    This link has not received any tracked clicks.
                </p>

            </div>

        @endif

    </div>

</div>


{{-- Sidebar --}}
<div class="space-y-6">

    {{-- Owner --}}
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

        <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">

            <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                Link Owner
            </h2>

        </div>


        <div class="p-6">

            @if($shortUrl->user)

                <div class="space-y-4">

                    <div>

                        <p class="text-sm font-semibold text-gray-800 dark:text-white/90">
                            {{ $shortUrl->user->name }}
                        </p>

                        <p class="mt-1 break-all text-sm text-gray-500 dark:text-gray-400">
                            {{ $shortUrl->user->email }}
                        </p>

                    </div>


                    <div class="flex flex-wrap gap-2">

                        <span class="inline-flex rounded-full bg-brand-50 px-3 py-1 text-xs font-medium text-brand-700 dark:bg-brand-500/10 dark:text-brand-400">
                            {{ ucfirst($shortUrl->user->role) }}
                        </span>


                        @if($shortUrl->user->status === 'active')

                            <span class="inline-flex rounded-full bg-success-50 px-3 py-1 text-xs font-medium text-success-700 dark:bg-success-500/10 dark:text-success-400">
                                Active
                            </span>

                        @else

                            <span class="inline-flex rounded-full bg-error-50 px-3 py-1 text-xs font-medium text-error-700 dark:bg-error-500/10 dark:text-error-400">
                                Inactive
                            </span>

                        @endif

                    </div>


                    <a
                        href="{{ route('admin.users.show', $shortUrl->user) }}"
                        class="inline-flex w-full items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/[0.03]"
                    >
                        View Owner
                    </a>

                </div>

            @else

                <p class="text-sm text-gray-500 dark:text-gray-400">
                    This link does not currently have an associated user.
                </p>

            @endif

        </div>

    </div>


    {{-- Status --}}
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

        <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">

            <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                Link Status
            </h2>

        </div>


        <div class="p-6">

            @if($shortUrl->trashed())

                <span class="inline-flex rounded-full bg-error-50 px-3 py-1 text-xs font-medium text-error-700 dark:bg-error-500/10 dark:text-error-400">
                    In Trash
                </span>

            @elseif($shortUrl->isExpired())

                <span class="inline-flex rounded-full bg-error-50 px-3 py-1 text-xs font-medium text-error-700 dark:bg-error-500/10 dark:text-error-400">
                    Expired
                </span>

            @elseif($shortUrl->isScheduled())

                <span class="inline-flex rounded-full bg-warning-50 px-3 py-1 text-xs font-medium text-warning-700 dark:bg-warning-500/10 dark:text-warning-400">
                    Scheduled
                </span>

            @else

                <span class="inline-flex rounded-full bg-success-50 px-3 py-1 text-xs font-medium text-success-700 dark:bg-success-500/10 dark:text-success-400">
                    Active
                </span>

            @endif

        </div>

    </div>


    {{-- System Information --}}
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

        <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">

            <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                System Information
            </h2>

        </div>


        <div class="space-y-4 p-6">

            {{-- Link ID --}}
            <div>

                <p class="text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                    Link ID
                </p>

                <p class="mt-1 text-sm text-gray-800 dark:text-white/90">
                    #{{ $shortUrl->id }}
                </p>

            </div>


            {{-- Created At --}}
            <div>

                <p class="text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                    Created At
                </p>

                <p class="mt-1 text-sm text-gray-800 dark:text-white/90">
                    {{ $shortUrl->created_at?->format('M d, Y h:i A') ?? '—' }}
                </p>

            </div>


            {{-- Updated At --}}
            <div>

                <p class="text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                    Updated At
                </p>

                <p class="mt-1 text-sm text-gray-800 dark:text-white/90">
                    {{ $shortUrl->updated_at?->format('M d, Y h:i A') ?? '—' }}
                </p>

            </div>

        </div>

    </div>

</div>

</div>

</div>

{{-- ============================================================
NOTIFICATION PROGRESS BAR ANIMATION
============================================================ --}}

<style>
    @keyframes notification-progress {
        from {
            width: 100%;
        }

        to {
            width: 0%;
        }
    }
</style>

@endsection