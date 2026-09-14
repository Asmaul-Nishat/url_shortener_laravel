@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-7xl">

{{-- ========================================================= --}}
{{-- Page Header --}}
{{-- ========================================================= --}}
<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

    <div>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white/90">
            Create Short Link
        </h1>

        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Create a short, shareable link from your long URL.
        </p>
    </div>

    {{-- Guest: Login | Authenticated: Back to Links --}}
    <div class="flex items-center gap-3">

        @guest

            <a
                href="{{ route('login') }}"
                class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
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
                        d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-9A2.25 2.25 0 0 0 2.25 5.25v13.5A2.25 2.25 0 0 0 4.5 21h9a2.25 2.25 0 0 0 2.25-2.25V15m3-6 3 3m0 0-3 3m3-3H9"
                    />
                </svg>

                Login
            </a>

        @else

            <a
                href="{{ route('links.index') }}"
                class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
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
                        d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"
                    />
                </svg>

                Back to Links
            </a>

        @endguest

    </div>

</div>


{{-- ========================================================= --}}
{{-- Success Message --}}
{{-- ========================================================= --}}
@if(session('success'))

    <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-5 py-4 dark:border-green-900/50 dark:bg-green-900/20">

        <div class="flex items-start gap-3">

            <svg
                class="mt-0.5 h-5 w-5 shrink-0 text-green-600 dark:text-green-400"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                />
            </svg>

            <div>
                <p class="text-sm font-medium text-green-800 dark:text-green-300">
                    {{ session('success') }}
                </p>
            </div>

        </div>

    </div>

@endif


{{-- ========================================================= --}}
{{-- Generated Short URL --}}
{{-- ========================================================= --}}
@if(session('guest_short_url') || session('short_url'))

    <div
        x-data="{
            copied: false,

            copyUrl() {
                const url = '{{ session('guest_short_url') ?? session('short_url') }}';

                if (navigator.clipboard && window.isSecureContext) {

                    navigator.clipboard.writeText(url).then(() => {
                        this.copied = true;

                        setTimeout(() => {
                            this.copied = false;
                        }, 2000);
                    });

                } else {

                    const textarea = document.createElement('textarea');

                    textarea.value = url;
                    textarea.style.position = 'fixed';
                    textarea.style.opacity = '0';

                    document.body.appendChild(textarea);

                    textarea.focus();
                    textarea.select();

                    try {
                        document.execCommand('copy');

                        this.copied = true;

                        setTimeout(() => {
                            this.copied = false;
                        }, 2000);

                    } finally {
                        document.body.removeChild(textarea);
                    }
                }
            }
        }"
        class="mb-6 rounded-2xl border border-brand-200 bg-brand-50 p-5 dark:border-brand-500/30 dark:bg-brand-500/10"
    >

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div class="min-w-0">

                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                    Your Short URL
                </p>

                <a
                    href="{{ session('guest_short_url') ?? session('short_url') }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="mt-1 block truncate text-lg font-semibold text-brand-600 hover:underline dark:text-brand-400"
                >
                    {{ session('guest_short_url') ?? session('short_url') }}
                </a>

                @if(session('guest_short_url'))

                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                        This guest link is temporary and is not saved to your account.
                    </p>

                @else

                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                        This link has been saved to your account.
                    </p>

                @endif

            </div>


            <button
                type="button"
                @click="copyUrl()"
                class="inline-flex h-11 shrink-0 items-center justify-center gap-2 rounded-lg bg-brand-500 px-5 text-sm font-medium text-white transition hover:bg-brand-600"
            >

                <template x-if="!copied">

                    <span class="flex items-center gap-2">

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
                                d="M8.25 8.25h-1.5A2.25 2.25 0 0 0 4.5 10.5v9A2.25 2.25 0 0 0 6.75 21.75h9A2.25 2.25 0 0 0 18 19.5V18"
                            />
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M15.75 3h1.5A2.25 2.25 0 0 1 19.5 5.25v9A2.25 2.25 0 0 1 17.25 16.5h-9A2.25 2.25 0 0 1 6 14.25v-9A2.25 2.25 0 0 1 8.25 3h7.5Z"
                            />
                        </svg>

                        Copy URL

                    </span>

                </template>


                <template x-if="copied">

                    <span class="flex items-center gap-2">

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
                                d="m4.5 12.75 6 6 9-13.5"
                            />
                        </svg>

                        Copied!

                    </span>

                </template>

            </button>

        </div>

    </div>

@endif


{{-- ========================================================= --}}
{{-- Main Content --}}
{{-- ========================================================= --}}
<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">


    {{-- ===================================================== --}}
    {{-- Link Form --}}
    {{-- ===================================================== --}}
    <div class="lg:col-span-2">

        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

            {{-- Card Header --}}
            <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">

                <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                    Link Details
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Enter the destination URL and configure your short link.
                </p>

            </div>


            {{-- Form --}}
            <form
                method="POST"
                action="{{ route('links.store') }}"
                class="p-6"
            >

                @csrf


                {{-- ================================================= --}}
                {{-- Original URL --}}
                {{-- ================================================= --}}
                <div class="mb-6">

                    <label
                        for="original_url"
                        class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                    >
                        Original URL
                        <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="url"
                        id="original_url"
                        name="original_url"
                        value="{{ old('original_url') }}"
                        placeholder="https://example.com/your-long-url"
                        required
                        class="h-11 w-full rounded-lg border border-gray-300 bg-white px-4 text-sm text-gray-800 outline-none transition placeholder:text-gray-400 focus:border-brand-500 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-gray-500"
                    >

                    @error('original_url')

                        <p class="mt-2 text-xs text-red-500">
                            {{ $message }}
                        </p>

                    @else

                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                            Enter the full URL you want to shorten.
                        </p>

                    @enderror

                </div>


                {{-- ================================================= --}}
                {{-- Custom Alias --}}
                {{-- ================================================= --}}
                <div class="mb-6">

                    <label
                        for="custom_alias"
                        class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                    >
                        Custom Alias
                        <span class="text-xs font-normal text-gray-400">
                            (Optional)
                        </span>
                    </label>

                    <div class="flex">

                        <span
                            class="inline-flex h-11 items-center rounded-l-lg border border-r-0 border-gray-300 bg-gray-50 px-4 text-sm text-gray-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400"
                        >
                            {{ url('/') }}/
                        </span>

                        <input
                            type="text"
                            id="custom_alias"
                            name="custom_alias"
                            value="{{ old('custom_alias') }}"
                            placeholder="my-link"
                            class="h-11 min-w-0 flex-1 rounded-r-lg border border-gray-300 bg-white px-4 text-sm text-gray-800 outline-none transition placeholder:text-gray-400 focus:border-brand-500 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-gray-500"
                        >

                    </div>

                    @error('custom_alias')

                        <p class="mt-2 text-xs text-red-500">
                            {{ $message }}
                        </p>

                    @else

                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                            Leave empty to generate a random short code automatically.
                        </p>

                    @enderror

                </div>


                {{-- ================================================= --}}
                {{-- Expiration --}}
                {{-- ================================================= --}}
                <div class="mb-6">

                    <label
                        for="expires_at"
                        class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                    >
                        Expiration
                        <span class="text-xs font-normal text-gray-400">
                            (Optional)
                        </span>
                    </label>

                    <input
                        type="datetime-local"
                        id="expires_at"
                        name="expires_at"
                        value="{{ old('expires_at') }}"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-white px-4 text-sm text-gray-800 outline-none transition focus:border-brand-500 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                    >

                    @error('expires_at')

                        <p class="mt-2 text-xs text-red-500">
                            {{ $message }}
                        </p>

                    @else

                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                            The short link will stop working after this date and time.
                        </p>

                    @enderror

                </div>


                {{-- ================================================= --}}
                {{-- Advanced Options --}}
                {{-- ================================================= --}}
                <div
                    x-data="{ open: false }"
                    class="mb-6 rounded-xl border border-gray-200 dark:border-gray-700"
                >

                    <button
                        type="button"
                        @click="open = !open"
                        class="flex w-full items-center justify-between px-4 py-3 text-left"
                    >

                        <div>

                            <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                                Advanced Options
                            </p>

                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                Additional settings for this link
                            </p>

                        </div>


                        <svg
                            class="h-5 w-5 text-gray-500 transition-transform"
                            :class="{ 'rotate-180': open }"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="m19 9-7 7-7-7"
                            />
                        </svg>

                    </button>


                    <div
                        x-show="open"
                        x-collapse
                        class="border-t border-gray-200 px-4 py-4 dark:border-gray-700"
                    >

                        {{-- Password --}}
                        <div class="mb-5">

                            <label
                                for="password"
                                class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                            >
                                Password Protection
                            </label>

                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Optional password"
                                class="h-11 w-full rounded-lg border border-gray-300 bg-white px-4 text-sm text-gray-800 outline-none transition placeholder:text-gray-400 focus:border-brand-500 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-gray-500"
                            >

                            @error('password')

                                <p class="mt-2 text-xs text-red-500">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>


                        {{-- Scheduled Activation --}}
                        <div>

                            <label
                                for="scheduled_at"
                                class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                            >
                                Schedule Activation
                            </label>

                            <input
                                type="datetime-local"
                                id="scheduled_at"
                                name="scheduled_at"
                                value="{{ old('scheduled_at') }}"
                                class="h-11 w-full rounded-lg border border-gray-300 bg-white px-4 text-sm text-gray-800 outline-none transition focus:border-brand-500 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                            >

                            @error('scheduled_at')

                                <p class="mt-2 text-xs text-red-500">
                                    {{ $message }}
                                </p>

                            @else

                                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                    Optional. Activate this short link at a specific date and time.
                                </p>

                            @enderror

                        </div>

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- Form Buttons --}}
                {{-- ================================================= --}}
                <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">

                    @auth

                        <a
                            href="{{ route('dashboard') }}"
                            class="inline-flex h-11 items-center justify-center rounded-lg border border-gray-300 bg-white px-5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
                        >
                            Cancel
                        </a>

                    @else

                        <a
                            href="{{ route('links.create') }}"
                            class="inline-flex h-11 items-center justify-center rounded-lg border border-gray-300 bg-white px-5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
                        >
                            Clear
                        </a>

                    @endauth


                    <button
                        type="submit"
                        class="inline-flex h-11 items-center justify-center gap-2 rounded-lg bg-brand-500 px-5 text-sm font-medium text-white transition hover:bg-brand-600"
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

                    </button>

                </div>

            </form>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- How It Works --}}
    {{-- ========================================================= --}}
    <div class="lg:col-span-1">

        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">

                <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                    How it works
                </h2>

            </div>


            <div class="space-y-6 p-6">

                {{-- Step 1 --}}
                <div class="flex gap-4">

                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-brand-50 text-sm font-semibold text-brand-500 dark:bg-brand-500/10">
                        1
                    </div>

                    <div>

                        <h3 class="text-sm font-semibold text-gray-800 dark:text-white/90">
                            Enter your URL
                        </h3>

                        <p class="mt-1 text-xs leading-5 text-gray-500 dark:text-gray-400">
                            Paste the long URL that you want to shorten.
                        </p>

                    </div>

                </div>


                {{-- Step 2 --}}
                <div class="flex gap-4">

                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-brand-50 text-sm font-semibold text-brand-500 dark:bg-brand-500/10">
                        2
                    </div>

                    <div>

                        <h3 class="text-sm font-semibold text-gray-800 dark:text-white/90">
                            Customize
                        </h3>

                        <p class="mt-1 text-xs leading-5 text-gray-500 dark:text-gray-400">
                            Choose a custom alias or expiration date if needed.
                        </p>

                    </div>

                </div>


                {{-- Step 3 --}}
                <div class="flex gap-4">

                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-brand-50 text-sm font-semibold text-brand-500 dark:bg-brand-500/10">
                        3
                    </div>

                    <div>

                        <h3 class="text-sm font-semibold text-gray-800 dark:text-white/90">
                            Generate
                        </h3>

                        <p class="mt-1 text-xs leading-5 text-gray-500 dark:text-gray-400">
                            Generate your short link and start sharing it.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


</div>

@endsection