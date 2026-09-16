@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-5xl">

{{-- Page Header --}}
<div class="mb-6">

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

        <a
            href="{{ route('admin.links.show', $shortUrl) }}"
            class="hover:text-brand-500"
        >
            Link Details
        </a>

        <span>/</span>

        <span class="text-gray-700 dark:text-gray-300">
            Edit
        </span>

    </div>

    <h1 class="text-2xl font-bold text-gray-800 dark:text-white/90">
        Edit Link
    </h1>

    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
        Update this short link and manage its configuration.
    </p>

</div>


{{-- Validation Errors --}}
@if($errors->any())

    <div class="mb-6 rounded-lg border border-error-200 bg-error-50 px-4 py-4 dark:border-error-500/30 dark:bg-error-500/10">

        <p class="text-sm font-medium text-error-700 dark:text-error-400">
            Please correct the following errors:
        </p>

        <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-error-700 dark:text-error-400">

            @foreach($errors->all() as $error)

                <li>
                    {{ $error }}
                </li>

            @endforeach

        </ul>

    </div>

@endif


{{-- Edit Form --}}
<form
    method="POST"
    action="{{ route('admin.links.update', $shortUrl) }}"
>

    @csrf
    @method('PATCH')


    {{-- Link Information --}}
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

        <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">

            <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                Link Information
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Update the destination and owner of this link.
            </p>

        </div>


        <div class="space-y-6 p-6">

            {{-- Owner --}}
            <div>

                <label
                    for="user_id"
                    class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                >
                    Link Owner
                </label>

                <select
                    id="user_id"
                    name="user_id"
                    required
                    class="h-11 w-full rounded-lg border border-gray-300 bg-white px-4 text-sm text-gray-800 outline-none focus:border-brand-500 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                >

                    @foreach($users as $user)

                        <option
                            value="{{ $user->id }}"
                            @selected(old('user_id', $shortUrl->user_id) == $user->id)
                        >
                            {{ $user->name }} — {{ $user->email }}
                        </option>

                    @endforeach

                </select>

                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                    Administrators can transfer this link to another user.
                </p>

            </div>


            {{-- Original URL --}}
            <div>

                <label
                    for="original_url"
                    class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                >
                    Original URL
                </label>

                <input
                    id="original_url"
                    name="original_url"
                    type="url"
                    value="{{ old('original_url', $shortUrl->original_url) }}"
                    required
                    maxlength="2048"
                    placeholder="https://example.com"
                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 outline-none focus:border-brand-500 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90"
                >

            </div>


            {{-- Custom Alias --}}
            <div>

                <label
                    for="custom_alias"
                    class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                >
                    Custom Alias
                </label>

                <input
                    id="custom_alias"
                    name="custom_alias"
                    type="text"
                    value="{{ old('custom_alias', $shortUrl->custom_alias) }}"
                    minlength="3"
                    maxlength="100"
                    placeholder="my-link"
                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 outline-none focus:border-brand-500 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90"
                >

                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                    Letters, numbers, dashes and underscores only.
                </p>

            </div>


            {{-- Short Code --}}
            <div>

                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Short Code
                </label>

                <div class="rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-700 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                    {{ $shortUrl->short_code }}
                </div>

                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                    The generated short code cannot be changed from this form.
                </p>

            </div>

        </div>

    </div>


    {{-- Advanced Options --}}
    <div class="mt-6 rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

        <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">

            <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                Advanced Options
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Configure expiration, scheduling, status and favorite settings.
            </p>

        </div>


        <div class="space-y-6 p-6">

            {{-- Expiration --}}
            <div>

                <label
                    for="expires_at"
                    class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                >
                    Expiration Date
                </label>

                <input
                    id="expires_at"
                    name="expires_at"
                    type="datetime-local"
                    value="{{ old('expires_at', $shortUrl->expires_at?->format('Y-m-d\TH:i')) }}"
                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 outline-none focus:border-brand-500 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90"
                >

                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                    Leave empty if this link should never expire.
                </p>

            </div>


            {{-- Scheduled --}}
            <div>

                <label
                    for="scheduled_at"
                    class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                >
                    Scheduled Activation
                </label>

                <input
                    id="scheduled_at"
                    name="scheduled_at"
                    type="datetime-local"
                    value="{{ old('scheduled_at', $shortUrl->scheduled_at?->format('Y-m-d\TH:i')) }}"
                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 outline-none focus:border-brand-500 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90"
                >

                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                    Leave empty if the link should be available immediately.
                </p>

            </div>


            {{-- Password Protection Information --}}
            <div class="rounded-lg border border-warning-200 bg-warning-50 px-4 py-4 dark:border-warning-500/30 dark:bg-warning-500/10">

                <div class="flex items-start gap-3">

                    <div class="mt-0.5 shrink-0">
                        <svg
                            class="h-5 w-5 text-warning-600 dark:text-warning-400"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-7a2 2 0 00-2-2H6a2 2 0 00-2 2v7a2 2 0 002 2zm10-11V7a4 4 0 00-8 0v1h8z"
                            />
                        </svg>
                    </div>

                    <div>

                        <p class="text-sm font-medium text-warning-800 dark:text-warning-300">
                            Password Protected
                        </p>

                        <p class="mt-1 text-xs text-warning-700 dark:text-warning-400">
                            The link password is private and cannot be viewed or changed by an administrator.
                        </p>

                        @if($shortUrl->isPasswordProtected())

                            <p class="mt-2 text-xs font-medium text-warning-800 dark:text-warning-300">
                                This link currently has password protection enabled.
                            </p>

                        @else

                            <p class="mt-2 text-xs font-medium text-gray-600 dark:text-gray-400">
                                This link currently does not have password protection.
                            </p>

                        @endif

                    </div>

                </div>

            </div>


            {{-- Status --}}
            <div>

                <label
                    for="status"
                    class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                >
                    Link Status
                </label>

                <select
                    id="status"
                    name="status"
                    required
                    class="h-11 w-full rounded-lg border border-gray-300 bg-white px-4 text-sm text-gray-800 outline-none focus:border-brand-500 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                >

                    <option
                        value="active"
                        @selected(old('status', $shortUrl->status) === 'active')
                    >
                        Active
                    </option>

                    <option
                        value="disabled"
                        @selected(old('status', $shortUrl->status) === 'disabled')
                    >
                        Disabled
                    </option>

                    <option
                        value="expired"
                        @selected(old('status', $shortUrl->status) === 'expired')
                    >
                        Expired
                    </option>

                </select>

                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                    Disabled links cannot be used until they are activated again.
                </p>

            </div>


            {{-- Favorite --}}
            <div>

                <label class="inline-flex items-center gap-3">

                    <input
                        type="checkbox"
                        name="is_favorite"
                        value="1"
                        @checked(old('is_favorite', $shortUrl->is_favorite))
                        class="h-4 w-4 rounded border-gray-300 text-brand-500 focus:ring-brand-500 dark:border-gray-700"
                    >

                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        Mark this link as favorite
                    </span>

                </label>

            </div>

        </div>

    </div>


    {{-- Form Actions --}}
    <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

        <a
            href="{{ route('admin.links.show', $shortUrl) }}"
            class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/[0.03]"
        >
            Cancel
        </a>

        <button
            type="submit"
            class="inline-flex items-center justify-center rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600"
        >
            Save Changes
        </button>

    </div>

</form>

</div>

@endsection
