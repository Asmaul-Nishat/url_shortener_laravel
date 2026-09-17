@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-7xl">

    {{-- ============================= --}}
    {{-- Notification Alerts --}}
    {{-- ============================= --}}

    {{-- Success Notification --}}
    @if(session('success'))
        <div
            x-data="{ show: true }"
            x-show="show"
            x-transition
            x-init="setTimeout(() => show = false, 5000)"
            class="fixed right-6 top-6 z-[9999] w-full max-w-4xl"
        >
            <div
                class="relative overflow-hidden rounded-2xl border-2 border-green-300 bg-green-50 shadow-2xl dark:border-green-500/40 dark:bg-green-500/10"
            >

                {{-- Progress Bar --}}
                <div
                    class="absolute left-0 top-0 h-2 w-full bg-green-500"
                    style="animation: notification-progress 5s linear forwards;"
                ></div>

                <div class="flex min-h-[240px] items-center gap-5 px-8 py-10">

                    {{-- Icon --}}
                    <div
                        class="flex h-[82px] w-[82px] shrink-0 items-center justify-center rounded-full bg-green-100 dark:bg-green-500/20"
                    >
                        <svg
                            class="h-11 w-11 text-green-600 dark:text-green-400"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2.5"
                                d="M5 13l4 4L19 7"
                            />
                        </svg>
                    </div>

                    {{-- Message --}}
                    <div class="min-w-0 flex-1">

                        <h3 class="text-3xl font-bold text-green-800 dark:text-green-300">
                            Success
                        </h3>

                        <p class="mt-2 text-2xl font-medium leading-relaxed text-green-700 dark:text-green-400">
                            {{ session('success') }}
                        </p>

                    </div>

                    {{-- Close Button --}}
                    <button
                        type="button"
                        @click="show = false"
                        class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full text-green-600 transition hover:bg-green-100 hover:text-green-800 dark:text-green-400 dark:hover:bg-green-500/20 dark:hover:text-green-300"
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
    @if($errors->any())
        <div
            x-data="{ show: true }"
            x-show="show"
            x-transition
            x-init="setTimeout(() => show = false, 7000)"
            class="fixed right-6 top-6 z-[9999] w-full max-w-4xl"
        >
            <div
                class="relative overflow-hidden rounded-2xl border-2 border-red-300 bg-red-50 shadow-2xl dark:border-red-500/40 dark:bg-red-500/10"
            >

                {{-- Progress Bar --}}
                <div
                    class="absolute left-0 top-0 h-2 w-full bg-red-500"
                    style="animation: notification-progress 7s linear forwards;"
                ></div>

                <div class="flex min-h-[240px] items-center gap-5 px-8 py-10">

                    {{-- Icon --}}
                    <div
                        class="flex h-[82px] w-[82px] shrink-0 items-center justify-center rounded-full bg-red-100 dark:bg-red-500/20"
                    >
                        <svg
                            class="h-11 w-11 text-red-600 dark:text-red-400"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2.5"
                                d="M12 9v4m0 4h.01M10.29 3.86l-7.82 14a2 2 0 001.74 3h15.58a2 2 0 001.74-3l-7.82-14a2 2 0 00-3.42 0z"
                            />
                        </svg>
                    </div>

                    {{-- Message --}}
                    <div class="min-w-0 flex-1">

                        <h3 class="text-3xl font-bold text-red-800 dark:text-red-300">
                            Please Fix the Following Errors
                        </h3>

                        <ul class="mt-3 list-disc space-y-1 pl-5 text-xl font-medium leading-relaxed text-red-700 dark:text-red-400">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>

                    </div>

                    {{-- Close Button --}}
                    <button
                        type="button"
                        @click="show = false"
                        class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full text-red-600 transition hover:bg-red-100 hover:text-red-800 dark:text-red-400 dark:hover:bg-red-500/20 dark:hover:text-red-300"
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


    {{-- Page Header --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white/90">
                Create Link
            </h1>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Create a short URL for any user on the platform.
            </p>
        </div>

        <div>
            <a
                href="{{ route('admin.links.index') }}"
                class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/[0.05]"
            >
                Back to Links
            </a>
        </div>

    </div>


    {{-- Form --}}
    <form
        method="POST"
        action="{{ route('admin.links.store') }}"
        class="space-y-6"
    >

        @csrf


        {{-- Main Link Information --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                    Link Information
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Choose the user who will own this short URL and enter the destination URL.
                </p>
            </div>


            <div class="grid grid-cols-1 gap-6">


                {{-- User --}}
                <div>
                    <label
                        for="user_id"
                        class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                    >
                        Link Owner
                        <span class="text-error-500">*</span>
                    </label>

                    <select
                        id="user_id"
                        name="user_id"
                        required
                        class="h-11 w-full rounded-lg border border-gray-300 bg-white px-4 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                    >

                        <option value="">
                            Select a user
                        </option>

                        @foreach($users as $user)

                            <option
                                value="{{ $user->id }}"
                                @selected(old('user_id') == $user->id)
                            >
                                {{ $user->name }} — {{ $user->email }}
                            </option>

                        @endforeach

                    </select>

                    @error('user_id')
                        <p class="mt-1.5 text-sm text-error-500">
                            {{ $message }}
                        </p>
                    @enderror

                    <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">
                        Only active users are available for new links.
                    </p>
                </div>


                {{-- Original URL --}}
                <div>
                    <label
                        for="original_url"
                        class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                    >
                        Destination URL
                        <span class="text-error-500">*</span>
                    </label>

                    <input
                        type="url"
                        id="original_url"
                        name="original_url"
                        value="{{ old('original_url') }}"
                        required
                        placeholder="https://example.com/your-long-url"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-white px-4 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-gray-500"
                    >

                    @error('original_url')
                        <p class="mt-1.5 text-sm text-error-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Custom Alias --}}
                <div>
                    <label
                        for="custom_alias"
                        class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                    >
                        Custom Alias
                        <span class="ml-1 text-xs font-normal text-gray-400">
                            Optional
                        </span>
                    </label>

                    <div class="flex">

                        <span class="inline-flex items-center rounded-l-lg border border-r-0 border-gray-300 bg-gray-50 px-4 text-sm text-gray-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                            {{ url('/') }}/
                        </span>

                        <input
                            type="text"
                            id="custom_alias"
                            name="custom_alias"
                            value="{{ old('custom_alias') }}"
                            placeholder="my-link"
                            class="h-11 min-w-0 flex-1 rounded-r-lg border border-gray-300 bg-white px-4 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-gray-500"
                        >

                    </div>

                    @error('custom_alias')
                        <p class="mt-1.5 text-sm text-error-500">
                            {{ $message }}
                        </p>
                    @enderror

                    <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">
                        Use 3–100 characters. Letters, numbers, dashes and underscores are allowed.
                    </p>
                </div>

            </div>

        </div>


        {{-- Advanced Options --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                    Advanced Options
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Configure expiration, password protection, scheduling and link status.
                </p>
            </div>


            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">


                {{-- Expiration --}}
                <div>
                    <label
                        for="expires_at"
                        class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                    >
                        Expiration Date
                        <span class="ml-1 text-xs font-normal text-gray-400">
                            Optional
                        </span>
                    </label>

                    <input
                        type="datetime-local"
                        id="expires_at"
                        name="expires_at"
                        value="{{ old('expires_at') }}"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-white px-4 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                    >

                    @error('expires_at')
                        <p class="mt-1.5 text-sm text-error-500">
                            {{ $message }}
                        </p>
                    @enderror

                    <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">
                        Leave empty if the link should not expire.
                    </p>
                </div>


                {{-- Scheduled Activation --}}
                <div>
                    <label
                        for="scheduled_at"
                        class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                    >
                        Scheduled Activation
                        <span class="ml-1 text-xs font-normal text-gray-400">
                            Optional
                        </span>
                    </label>

                    <input
                        type="datetime-local"
                        id="scheduled_at"
                        name="scheduled_at"
                        value="{{ old('scheduled_at') }}"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-white px-4 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                    >

                    @error('scheduled_at')
                        <p class="mt-1.5 text-sm text-error-500">
                            {{ $message }}
                        </p>
                    @enderror

                    <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">
                        The scheduled time must be before the expiration time.
                    </p>
                </div>


                {{-- Password --}}
                <div>
                    <label
                        for="password"
                        class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                    >
                        Password Protection
                        <span class="ml-1 text-xs font-normal text-gray-400">
                            Optional
                        </span>
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        autocomplete="new-password"
                        placeholder="Enter password"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-white px-4 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-gray-500"
                    >

                    @error('password')
                        <p class="mt-1.5 text-sm text-error-500">
                            {{ $message }}
                        </p>
                    @enderror

                    <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">
                        Minimum 4 characters.
                    </p>
                </div>


                {{-- Status --}}
                <div>
                    <label
                        for="status"
                        class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                    >
                        Status
                        <span class="text-error-500">*</span>
                    </label>

                    <select
                        id="status"
                        name="status"
                        required
                        class="h-11 w-full rounded-lg border border-gray-300 bg-white px-4 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                    >

                        <option
                            value="active"
                            @selected(old('status', 'active') === 'active')
                        >
                            Active
                        </option>

                        <option
                            value="disabled"
                            @selected(old('status') === 'disabled')
                        >
                            Disabled
                        </option>

                        <option
                            value="expired"
                            @selected(old('status') === 'expired')
                        >
                            Expired
                        </option>

                    </select>

                    @error('status')
                        <p class="mt-1.5 text-sm text-error-500">
                            {{ $message }}
                        </p>
                    @enderror

                    <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">
                        Choose the initial status of the link.
                    </p>
                </div>

            </div>


            {{-- Favorite --}}
            <div class="mt-6 rounded-lg border border-gray-200 p-4 dark:border-gray-700">

                <label class="flex cursor-pointer items-start gap-3">

                    <input
                        type="checkbox"
                        name="is_favorite"
                        value="1"
                        @checked(old('is_favorite'))
                        class="mt-0.5 h-4 w-4 rounded border-gray-300 text-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-800"
                    >

                    <span>
                        <span class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Add to Favorites
                        </span>

                        <span class="mt-1 block text-xs text-gray-500 dark:text-gray-400">
                            The link will appear in the selected user's Favorites section.
                        </span>
                    </span>

                </label>

            </div>

        </div>


        {{-- Form Actions --}}
        <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

            <a
                href="{{ route('admin.links.index') }}"
                class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/[0.05]"
            >
                Cancel
            </a>

            <button
                type="submit"
                class="inline-flex items-center justify-center rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600 focus:outline-hidden focus:ring-3 focus:ring-brand-500/20"
            >
                Create Link
            </button>

        </div>

    </form>

</div>


{{-- Notification Progress Animation --}}
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
