@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-7xl">

    {{-- Page Header --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
<!-- 
        <div>
            <div class="mb-2 flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                <a
                    href="{{ route('admin.dashboard') }}"
                    class="hover:text-brand-500"
                >
                    Admin Dashboard
                </a>

                <span>/</span>

                <a
                    href="{{ route('admin.links.index') }}"
                    class="hover:text-brand-500"
                >
                    Links
                </a>

                <span>/</span>

                <span>Create Link</span>
            </div> -->

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


    {{-- Success Message --}}
    @if(session('success'))
        <div class="mb-6 rounded-lg border border-success-200 bg-success-50 px-4 py-3 text-sm text-success-700 dark:border-success-500/30 dark:bg-success-500/10 dark:text-success-400">
            {{ session('success') }}
        </div>
    @endif


    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="mb-6 rounded-lg border border-error-200 bg-error-50 px-4 py-3 dark:border-error-500/30 dark:bg-error-500/10">
            <p class="mb-2 text-sm font-semibold text-error-700 dark:text-error-400">
                Please fix the following errors:
            </p>

            <ul class="list-disc space-y-1 pl-5 text-sm text-error-600 dark:text-error-400">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


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

@endsection