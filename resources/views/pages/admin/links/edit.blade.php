@extends('layouts.app')

@section('content')

{{-- ============================================================
     TOP-RIGHT NOTIFICATIONS
     ============================================================ --}}

<div class="fixed right-6 top-6 z-[9999] w-full max-w-3xl space-y-4">

    {{-- ========================================================
         SUCCESS NOTIFICATION
         ======================================================== --}}
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


    {{-- ========================================================
         ERROR NOTIFICATION
         ======================================================== --}}
    @if($errors->any())

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

                        @foreach($errors->all() as $error)

                            <p class="text-2xl font-light leading-relaxed tracking-wide text-red-700 dark:text-red-200">
                                {{ $error }}
                            </p>

                        @endforeach

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

    {{-- ========================================================
         PAGE HEADER
         ======================================================== --}}

    <div class="mb-6">

        <div>

            <h1 class="text-2xl font-bold text-gray-800 dark:text-white/90">
                Edit Link
            </h1>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Update the short URL information and settings.
            </p>

        </div>

    </div>


    {{-- ========================================================
         EDIT FORM
         ======================================================== --}}

    <form
        method="POST"
        action="{{ route('admin.links.update', $shortUrl) }}"
    >

        @csrf
        @method('PATCH')


        {{-- ====================================================
             LINK INFORMATION CARD
             ==================================================== --}}

        <div class="mb-6 rounded-2xl border border-gray-200 bg-white shadow-theme-sm dark:border-gray-800 dark:bg-white/[0.03]">

            {{-- Card Header --}}
            <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">

                <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                    Link Information
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Basic information about this short URL.
                </p>

            </div>


            {{-- Card Body --}}
            <div class="space-y-6 p-6">


                {{-- =================================================
                     LINK OWNER
                     ================================================= --}}

                <div>

                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Link Owner
                    </label>

                    <div class="rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 dark:border-gray-700 dark:bg-gray-800/50">

                        @if($shortUrl->user)

                            <div class="flex items-center gap-3">

                                {{-- Avatar --}}
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-brand-100 text-sm font-semibold text-brand-600 dark:bg-brand-500/10 dark:text-brand-400">
                                    {{ strtoupper(substr($shortUrl->user->name, 0, 1)) }}
                                </div>

                                {{-- User Information --}}
                                <div>

                                    <p class="font-medium text-gray-800 dark:text-white/90">
                                        {{ $shortUrl->user->name }}
                                    </p>

                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $shortUrl->user->email }}
                                    </p>

                                </div>

                            </div>

                        @else

                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                No user assigned
                            </span>

                        @endif

                    </div>

                    <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">
                        The link owner cannot be changed after creation.
                    </p>

                </div>


                {{-- =================================================
                     ORIGINAL URL
                     ================================================= --}}

                <div>

                    <label
                        for="original_url"
                        class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                    >
                        Original URL

                        <span class="text-red-500">
                            *
                        </span>

                    </label>

                    <input
                        type="url"
                        id="original_url"
                        name="original_url"
                        value="{{ old('original_url', $shortUrl->original_url) }}"
                        required
                        placeholder="https://example.com/your-long-url"
                        class="h-11 w-full rounded-xl border border-gray-300 bg-white px-4 text-sm text-gray-800 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-gray-500 dark:focus:border-brand-500"
                    >

                    @error('original_url')

                        <p class="mt-1.5 text-sm text-red-500">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- =================================================
                     CUSTOM ALIAS
                     ================================================= --}}

                <div>

                    <label
                        for="custom_alias"
                        class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                    >
                        Custom Alias
                    </label>

                    <div class="flex">

                        {{-- Base URL --}}
                        <span class="inline-flex items-center rounded-l-xl border border-r-0 border-gray-300 bg-gray-50 px-4 text-sm text-gray-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                            {{ url('/') }}/
                        </span>

                        {{-- Alias --}}
                        <input
                            type="text"
                            id="custom_alias"
                            name="custom_alias"
                            value="{{ old('custom_alias', $shortUrl->custom_alias) }}"
                            placeholder="my-link"
                            class="h-11 min-w-0 flex-1 rounded-r-xl border border-gray-300 bg-white px-4 text-sm text-gray-800 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-gray-500 dark:focus:border-brand-500"
                        >

                    </div>

                    <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">
                        Use letters, numbers, hyphens, and underscores.
                    </p>

                    @error('custom_alias')

                        <p class="mt-1.5 text-sm text-red-500">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- =================================================
                     SHORT CODE
                     ================================================= --}}

                <div>

                    <label
                        for="short_code"
                        class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                    >
                        Short Code
                    </label>

                    <input
                        type="text"
                        id="short_code"
                        value="{{ $shortUrl->short_code }}"
                        readonly
                        class="h-11 w-full rounded-xl border border-gray-200 bg-gray-50 px-4 text-sm font-medium text-gray-600 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300"
                    >

                    <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">
                        The generated short code cannot be changed.
                    </p>

                </div>

            </div>

        </div>


        {{-- ========================================================
             ADVANCED OPTIONS CARD
             ======================================================== --}}

        <div class="mb-6 rounded-2xl border border-gray-200 bg-white shadow-theme-sm dark:border-gray-800 dark:bg-white/[0.03]">

            {{-- Card Header --}}
            <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">

                <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                    Advanced Options
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Configure expiration, scheduling, status, and other options.
                </p>

            </div>


            {{-- Card Body --}}
            <div class="space-y-6 p-6">


                {{-- =================================================
                     EXPIRATION DATE
                     ================================================= --}}

                <div>

                    <label
                        for="expires_at"
                        class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                    >
                        Expiration Date
                    </label>

                    <input
                        type="datetime-local"
                        id="expires_at"
                        name="expires_at"
                        value="{{ old('expires_at', $shortUrl->expires_at ? $shortUrl->expires_at->format('Y-m-d\TH:i') : '') }}"
                        class="h-11 w-full rounded-xl border border-gray-300 bg-white px-4 text-sm text-gray-800 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                    >

                    <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">
                        Leave empty if the link should never expire.
                    </p>

                    @error('expires_at')

                        <p class="mt-1.5 text-sm text-red-500">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- =================================================
                     SCHEDULED ACTIVATION
                     ================================================= --}}

                <div>

                    <label
                        for="scheduled_at"
                        class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                    >
                        Scheduled Activation
                    </label>

                    <input
                        type="datetime-local"
                        id="scheduled_at"
                        name="scheduled_at"
                        value="{{ old('scheduled_at', $shortUrl->scheduled_at ? $shortUrl->scheduled_at->format('Y-m-d\TH:i') : '') }}"
                        class="h-11 w-full rounded-xl border border-gray-300 bg-white px-4 text-sm text-gray-800 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                    >

                    <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">
                        The link will become active at the scheduled time.
                    </p>

                    @error('scheduled_at')

                        <p class="mt-1.5 text-sm text-red-500">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- =================================================
                     PASSWORD PROTECTION
                     ================================================= --}}

                <div>

                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Password Protection
                    </label>

                    <div class="rounded-xl border border-gray-200 bg-gray-50 px-4 py-4 dark:border-gray-700 dark:bg-gray-800/50">

                        <div class="flex items-start gap-3">

                            {{-- Lock Icon --}}
                            <div class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300">

                                <svg
                                    class="h-5 w-5"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <rect
                                        width="18"
                                        height="11"
                                        x="3"
                                        y="11"
                                        rx="2"
                                        ry="2"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M7 11V7a5 5 0 0110 0v4"
                                    />
                                </svg>

                            </div>

                            {{-- Password Information --}}
                            <div>

                                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Password protection
                                </p>

                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    Password protection can be managed from the link creation settings.
                                </p>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     STATUS
                     ================================================= --}}

                <div>

                    <label
                        for="status"
                        class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                    >
                        Status

                        <span class="text-red-500">
                            *
                        </span>

                    </label>

                    <select
                        id="status"
                        name="status"
                        required
                        class="h-11 w-full rounded-xl border border-gray-300 bg-white px-4 text-sm text-gray-800 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                    >

                        <option
                            value="active"
                            {{ old('status', $shortUrl->status) === 'active' ? 'selected' : '' }}
                        >
                            Active
                        </option>

                        <option
                            value="disabled"
                            {{ old('status', $shortUrl->status) === 'disabled' ? 'selected' : '' }}
                        >
                            Disabled
                        </option>

                        <option
                            value="expired"
                            {{ old('status', $shortUrl->status) === 'expired' ? 'selected' : '' }}
                        >
                            Expired
                        </option>

                    </select>

                    @error('status')

                        <p class="mt-1.5 text-sm text-red-500">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- =================================================
                     FAVORITE
                     ================================================= --}}

                <div>

                    <label class="flex cursor-pointer items-center gap-3">

                        {{-- Hidden value for unchecked state --}}
                        <input
                            type="hidden"
                            name="is_favorite"
                            value="0"
                        >

                        <input
                            type="checkbox"
                            name="is_favorite"
                            value="1"
                            {{ old('is_favorite', $shortUrl->is_favorite) ? 'checked' : '' }}
                            class="h-4 w-4 rounded border-gray-300 text-brand-600 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-800"
                        >

                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                            Mark as favorite
                        </span>

                    </label>

                </div>

            </div>

        </div>


        {{-- ========================================================
             FORM ACTIONS
             ======================================================== --}}

        <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

            {{-- Cancel --}}
            <a
                href="{{ route('admin.links.show', $shortUrl) }}"
                class="inline-flex h-11 items-center justify-center rounded-xl border border-gray-300 bg-white px-5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:hover:bg-white/[0.05]"
            >
                Cancel
            </a>


            {{-- Update --}}
            <button
                type="submit"
                class="inline-flex h-11 items-center justify-center rounded-xl bg-brand-500 px-5 text-sm font-medium text-white transition hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-brand-500/30"
            >
                Update Link
            </button>

        </div>

    </form>

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