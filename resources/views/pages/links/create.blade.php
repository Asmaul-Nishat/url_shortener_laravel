@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-7xl">

<!-- Page Header -->
<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

    <div>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white/90">
            Create Short Link
        </h1>

        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Create a short, shareable link from your long URL.
        </p>
    </div>

    <a
        href="{{ url('/links') }}"
        class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
    >
        Back to Links
    </a>

</div>


<!-- Main Content -->
<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

    <!-- Create Link Form -->
    <div class="lg:col-span-2">

        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

            <!-- Card Header -->
            <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                    Link Details
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Enter the destination URL and configure your short link.
                </p>
            </div>


            <!-- Form -->
            <form
                method="POST"
                action="{{ route('links.store') }}"
                class="p-6"
            >
                @csrf

                <!-- Original URL -->
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


                <!-- Custom Alias -->
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

                        <span class="inline-flex h-11 items-center rounded-l-lg border border-r-0 border-gray-300 bg-gray-50 px-4 text-sm text-gray-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
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


                <!-- Expiration -->
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


                <!-- Advanced Options -->
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

                        <!-- Password Protection -->
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

                        </div>


                        <!-- Scheduled URL -->
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

                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                Optional. Activate this short link at a specific date and time.
                            </p>

                        </div>

                    </div>

                </div>


                <!-- Buttons -->
                <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">

                    <a
                        href="{{ url('/dashboard') }}"
                        class="inline-flex h-11 items-center justify-center rounded-lg border border-gray-300 bg-white px-5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
                    >
                        Cancel
                    </a>

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


    <!-- Right Side Information -->
    <div class="lg:col-span-1">

        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">

                <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                    How it works
                </h2>

            </div>


            <div class="space-y-6 p-6">

                <!-- Step 1 -->
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


                <!-- Step 2 -->
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


                <!-- Step 3 -->
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
