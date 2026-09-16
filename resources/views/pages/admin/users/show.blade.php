@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-7xl">

    {{-- =========================================================
        SUCCESS NOTIFICATION
    ========================================================== --}}
    @if(session('success'))

        <div
            x-data="{ show: true }"
            x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="translate-y-2 opacity-0"
            x-transition:enter-end="translate-y-0 opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="mb-6 flex items-center justify-between rounded-xl border border-success-200 bg-success-50 px-5 py-4 shadow-sm dark:border-success-500/20 dark:bg-success-500/10"
        >

            <div class="flex items-center gap-3">

                {{-- Success Icon --}}
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-success-500 text-white shadow-sm">

                    <svg
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M5 13l4 4L19 7"
                        />
                    </svg>

                </div>


                {{-- Message --}}
                <div>

                    <p class="text-sm font-bold text-success-700 dark:text-success-400">
                        {{ session('success') }}
                    </p>

                    <p class="mt-0.5 text-xs text-success-600/80 dark:text-success-400/70">
                        The changes have been saved successfully.
                    </p>

                </div>

            </div>


            {{-- Close --}}
            <button
                type="button"
                @click="show = false"
                class="ml-4 rounded-lg p-1.5 text-success-500 transition hover:bg-success-100 hover:text-success-700 dark:hover:bg-success-500/20 dark:hover:text-success-300"
            >

                <svg
                    class="h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M6 18L18 6M6 6l12 12"
                    />
                </svg>

            </button>

        </div>

    @endif


    {{-- =========================================================
        ERROR NOTIFICATION
    ========================================================== --}}
    @if(session('error'))

        <div
            x-data="{ show: true }"
            x-show="show"
            x-transition
            class="mb-6 flex items-center justify-between rounded-xl border border-error-200 bg-error-50 px-5 py-4 shadow-sm dark:border-error-500/20 dark:bg-error-500/10"
        >

            <div class="flex items-center gap-3">

                {{-- Error Icon --}}
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-error-500 text-white shadow-sm">

                    <svg
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
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

                        <circle
                            cx="12"
                            cy="12"
                            r="9"
                        />
                    </svg>

                </div>


                {{-- Message --}}
                <div>

                    <p class="text-sm font-bold text-error-700 dark:text-error-400">
                        {{ session('error') }}
                    </p>

                    <p class="mt-0.5 text-xs text-error-600/80 dark:text-error-400/70">
                        Please check the information and try again.
                    </p>

                </div>

            </div>


            {{-- Close --}}
            <button
                type="button"
                @click="show = false"
                class="ml-4 rounded-lg p-1.5 text-error-500 transition hover:bg-error-100 hover:text-error-700 dark:hover:bg-error-500/20 dark:hover:text-error-300"
            >

                <svg
                    class="h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M6 18L18 6M6 6l12 12"
                    />
                </svg>

            </button>

        </div>

    @endif


    {{-- =========================================================
        PAGE HEADER
    ========================================================== --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>

            <h1 class="text-2xl font-bold text-gray-800 dark:text-white/90">
                User Details
            </h1>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                View and manage this user's account information.
            </p>

        </div>


        <a
            href="{{ route('admin.users.index') }}"
            class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs transition hover:bg-gray-50 dark:border-gray-800 dark:bg-white/[0.03] dark:text-gray-300 dark:hover:bg-white/[0.05]"
        >

            <svg
                class="h-4 w-4"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="1.8"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M15 19l-7-7 7-7"
                />
            </svg>

            Back to Users

        </a>

    </div>


    {{-- =========================================================
        PROFILE HEADER
    ========================================================== --}}
    <div class="mb-6 rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

        <div class="p-5 lg:p-6">

            <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

                {{-- User --}}
                <div class="flex items-center gap-4">

                    {{-- Profile Photo --}}
                    <div class="relative shrink-0">

                        @if($user->profile_photo_path)

                            <img
                                src="{{ asset('storage/' . $user->profile_photo_path) }}"
                                alt="{{ $user->name }}"
                                class="h-16 w-16 rounded-full object-cover ring-2 ring-gray-100 dark:ring-gray-800"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                            >

                            <div
                                class="hidden h-16 w-16 items-center justify-center rounded-full bg-brand-50 text-xl font-semibold text-brand-600 ring-2 ring-gray-100 dark:bg-brand-500/10 dark:text-brand-400 dark:ring-gray-800"
                            >
                                {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                            </div>

                        @else

                            <div
                                class="flex h-16 w-16 items-center justify-center rounded-full bg-brand-50 text-xl font-semibold text-brand-600 ring-2 ring-gray-100 dark:bg-brand-500/10 dark:text-brand-400 dark:ring-gray-800"
                            >
                                {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                            </div>

                        @endif

                    </div>


                    {{-- Name --}}
                    <div class="min-w-0">

                        <h2 class="truncate text-xl font-semibold text-gray-800 dark:text-white/90">
                            {{ $user->name }}
                        </h2>

                        <p class="mt-1 truncate text-sm text-gray-500 dark:text-gray-400">
                            {{ $user->email }}
                        </p>


                        <div class="mt-3 flex flex-wrap items-center gap-2">

                            {{-- Role --}}
                            @if($user->role === 'admin')

                                <span class="inline-flex items-center rounded-full bg-brand-50 px-2.5 py-1 text-xs font-medium text-brand-600 dark:bg-brand-500/10 dark:text-brand-400">
                                    Administrator
                                </span>

                            @else

                                <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-600 dark:bg-gray-800 dark:text-gray-300">
                                    User
                                </span>

                            @endif


                            {{-- Status --}}
                            @if($user->status === 'active')

                                <span class="inline-flex items-center gap-1.5 rounded-full bg-success-50 px-2.5 py-1 text-xs font-medium text-success-600 dark:bg-success-500/10 dark:text-success-400">

                                    <span class="h-1.5 w-1.5 rounded-full bg-success-500"></span>

                                    Active

                                </span>

                            @else

                                <span class="inline-flex items-center gap-1.5 rounded-full bg-error-50 px-2.5 py-1 text-xs font-medium text-error-600 dark:bg-error-500/10 dark:text-error-400">

                                    <span class="h-1.5 w-1.5 rounded-full bg-error-500"></span>

                                    Inactive

                                </span>

                            @endif

                        </div>

                    </div>

                </div>


                {{-- Edit --}}
                <div class="shrink-0">

                    <a
                        href="{{ route('admin.users.edit', $user) }}"
                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white shadow-theme-xs transition hover:bg-brand-600"
                    >

                        <svg
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 20h9"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"
                            />
                        </svg>

                        Edit User

                    </a>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
        STATISTICS
    ========================================================== --}}
    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        {{-- Links --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Total Links
                    </p>

                    <p class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">
                        {{ $user->short_urls_count }}
                    </p>

                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-brand-50 text-brand-500 dark:bg-brand-500/10 dark:text-brand-400">

                    <svg
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M10 13a5 5 0 007.54.54l3-3a5 5 0 00-7.07-7.07l-1.72 1.71"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M14 11a5 5 0 00-7.54-.54l-3 3a5 5 0 007.07 7.07l1.71-1.71"
                        />
                    </svg>

                </div>

            </div>

        </div>


        {{-- Clicks --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Total Clicks
                    </p>

                    <p class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">
                        {{ number_format($totalClicks) }}
                    </p>

                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-success-50 text-success-500 dark:bg-success-500/10 dark:text-success-400">

                    <svg
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3 3v18h18"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M7 16l4-5 3 3 5-7"
                        />
                    </svg>

                </div>

            </div>

        </div>


        {{-- Role --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Account Role
                    </p>

                    <p class="mt-2 text-lg font-bold text-gray-800 dark:text-white/90">
                        {{ $user->role === 'admin' ? 'Administrator' : 'User' }}
                    </p>

                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-warning-50 text-warning-500 dark:bg-warning-500/10 dark:text-warning-400">

                    <svg
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 14a4 4 0 100-8 4 4 0 000 8z"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M4 21a8 8 0 0116 0"
                        />
                    </svg>

                </div>

            </div>

        </div>


        {{-- Joined --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Joined
                    </p>

                    <p class="mt-2 text-lg font-bold text-gray-800 dark:text-white/90">
                        {{ $user->created_at?->format('M d, Y') ?? '—' }}
                    </p>

                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400">

                    <svg
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <rect
                            x="3"
                            y="4"
                            width="18"
                            height="17"
                            rx="2"
                        />

                        <path
                            stroke-linecap="round"
                            d="M16 2v4M8 2v4M3 10h18"
                        />
                    </svg>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
        ACCOUNT INFORMATION + ACTIONS
    ========================================================== --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">


        {{-- Account Information --}}
        <div class="lg:col-span-2">

            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

                <div class="border-b border-gray-200 px-5 py-5 dark:border-gray-800 lg:px-6">

                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                        Account Information
                    </h3>

                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Personal and account details for this user.
                    </p>

                </div>


                <div class="grid grid-cols-1 gap-x-8 gap-y-6 p-5 sm:grid-cols-2 lg:p-6">

                    <div>

                        <p class="mb-1 text-xs font-medium uppercase tracking-wide text-gray-400 dark:text-gray-500">
                            First Name
                        </p>

                        <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                            {{ $user->first_name ?: '—' }}
                        </p>

                    </div>


                    <div>

                        <p class="mb-1 text-xs font-medium uppercase tracking-wide text-gray-400 dark:text-gray-500">
                            Last Name
                        </p>

                        <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                            {{ $user->last_name ?: '—' }}
                        </p>

                    </div>


                    <div>

                        <p class="mb-1 text-xs font-medium uppercase tracking-wide text-gray-400 dark:text-gray-500">
                            Full Name
                        </p>

                        <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                            {{ $user->name ?: '—' }}
                        </p>

                    </div>


                    <div>

                        <p class="mb-1 text-xs font-medium uppercase tracking-wide text-gray-400 dark:text-gray-500">
                            Email Address
                        </p>

                        <p class="break-all text-sm font-medium text-gray-800 dark:text-white/90">
                            {{ $user->email }}
                        </p>

                    </div>


                    <div>

                        <p class="mb-1 text-xs font-medium uppercase tracking-wide text-gray-400 dark:text-gray-500">
                            Phone
                        </p>

                        <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                            {{ $user->phone ?: '—' }}
                        </p>

                    </div>


                    <div>

                        <p class="mb-1 text-xs font-medium uppercase tracking-wide text-gray-400 dark:text-gray-500">
                            Country
                        </p>

                        <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                            {{ $user->country ?: '—' }}
                        </p>

                    </div>


                    <div>

                        <p class="mb-1 text-xs font-medium uppercase tracking-wide text-gray-400 dark:text-gray-500">
                            Timezone
                        </p>

                        <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                            {{ $user->timezone ?: '—' }}
                        </p>

                    </div>


                    <div>

                        <p class="mb-1 text-xs font-medium uppercase tracking-wide text-gray-400 dark:text-gray-500">
                            Email Verification
                        </p>

                        @if($user->email_verified_at)

                            <span class="inline-flex items-center gap-1.5 text-sm font-medium text-success-600 dark:text-success-400">

                                <svg
                                    class="h-4 w-4"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M5 13l4 4L19 7"
                                    />
                                </svg>

                                Verified

                            </span>

                        @else

                            <span class="text-sm font-medium text-warning-600 dark:text-warning-400">
                                Not Verified
                            </span>

                        @endif

                    </div>


                    <div>

                        <p class="mb-1 text-xs font-medium uppercase tracking-wide text-gray-400 dark:text-gray-500">
                            Account Created
                        </p>

                        <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                            {{ $user->created_at?->format('M d, Y h:i A') ?? '—' }}
                        </p>

                    </div>


                    <div>

                        <p class="mb-1 text-xs font-medium uppercase tracking-wide text-gray-400 dark:text-gray-500">
                            Last Updated
                        </p>

                        <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                            {{ $user->updated_at?->format('M d, Y h:i A') ?? '—' }}
                        </p>

                    </div>


                    <div class="sm:col-span-2">

                        <p class="mb-1 text-xs font-medium uppercase tracking-wide text-gray-400 dark:text-gray-500">
                            Bio
                        </p>

                        <p class="text-sm leading-6 text-gray-600 dark:text-gray-300">
                            {{ $user->bio ?: 'No bio has been added for this user.' }}
                        </p>

                    </div>

                </div>

            </div>

        </div>


        {{-- Account Actions --}}
        <div>

            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

                {{-- Header --}}
                <div class="border-b border-gray-200 px-5 py-5 dark:border-gray-800 lg:px-6">

                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                        Account Actions
                    </h3>

                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Manage this user's account.
                    </p>

                </div>


                {{-- Actions --}}
                <div class="p-4 lg:p-5">

                    <div class="space-y-2">


                        {{-- Edit User --}}
                        <a
                            href="{{ route('admin.users.edit', $user) }}"
                            class="group flex w-full items-center gap-4 rounded-xl p-3 transition hover:bg-gray-50 dark:hover:bg-white/[0.03]"
                        >

                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-brand-50 text-brand-500 transition group-hover:bg-brand-100 dark:bg-brand-500/10 dark:text-brand-400 dark:group-hover:bg-brand-500/20">

                                <svg
                                    class="h-5 w-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 20h9"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"
                                    />
                                </svg>

                            </div>


                            <div class="min-w-0 flex-1 text-left">

                                <p class="text-sm font-semibold text-gray-800 dark:text-white/90">
                                    Edit User
                                </p>

                                <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">
                                    Update profile and account information
                                </p>

                            </div>


                            <svg
                                class="h-5 w-5 shrink-0 text-gray-300 transition group-hover:translate-x-0.5 group-hover:text-gray-500 dark:text-gray-600 dark:group-hover:text-gray-400"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M9 5l7 7-7 7"
                                />
                            </svg>

                        </a>


                        {{-- Activate / Deactivate --}}
                        @if($user->id !== auth()->id())

                            <form
                                method="POST"
                                action="{{ route('admin.users.toggle-status', $user) }}"
                            >

                                @csrf
                                @method('PATCH')

                                <button
                                    type="submit"
                                    class="group flex w-full items-center gap-4 rounded-xl p-3 text-left transition hover:bg-gray-50 dark:hover:bg-white/[0.03]"
                                >

                                    <div
                                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl
                                        @if($user->status === 'active')
                                            bg-warning-50 text-warning-500 dark:bg-warning-500/10 dark:text-warning-400 dark:group-hover:bg-warning-500/20
                                        @else
                                            bg-success-50 text-success-500 dark:bg-success-500/10 dark:text-success-400 dark:group-hover:bg-success-500/20
                                        @endif"
                                    >

                                        @if($user->status === 'active')

                                            <svg
                                                class="h-5 w-5"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                                stroke-width="1.8"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M18.364 18.364A9 9 0 005.636 5.636"
                                                />

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M5.636 18.364A9 9 0 0118.364 5.636"
                                                />

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M5.636 5.636l12.728 12.728"
                                                />
                                            </svg>

                                        @else

                                            <svg
                                                class="h-5 w-5"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                                stroke-width="1.8"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M5 13l4 4L19 7"
                                                />
                                            </svg>

                                        @endif

                                    </div>


                                    <div class="min-w-0 flex-1">

                                        @if($user->status === 'active')

                                            <p class="text-sm font-semibold text-gray-800 dark:text-white/90">
                                                Deactivate User
                                            </p>

                                            <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">
                                                Temporarily disable this user's account
                                            </p>

                                        @else

                                            <p class="text-sm font-semibold text-gray-800 dark:text-white/90">
                                                Activate User
                                            </p>

                                            <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">
                                                Restore access to this user's account
                                            </p>

                                        @endif

                                    </div>


                                    <svg
                                        class="h-5 w-5 shrink-0 text-gray-300 transition group-hover:translate-x-0.5 group-hover:text-gray-500 dark:text-gray-600 dark:group-hover:text-gray-400"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M9 5l7 7-7 7"
                                        />
                                    </svg>

                                </button>

                            </form>

                        @endif


                        {{-- Divider --}}
                        @if($user->id !== auth()->id())

                            <div class="my-2 border-t border-gray-100 dark:border-gray-800"></div>

                        @endif


                        {{-- Delete User --}}
                        @if($user->id !== auth()->id())

                            <form
                                method="POST"
                                action="{{ route('admin.users.destroy', $user) }}"
                                onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');"
                            >

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="group flex w-full items-center gap-4 rounded-xl p-3 text-left transition hover:bg-error-50 dark:hover:bg-error-500/10"
                                >

                                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-error-50 text-error-500 transition group-hover:bg-error-100 dark:bg-error-500/10 dark:text-error-400 dark:group-hover:bg-error-500/20">

                                        <svg
                                            class="h-5 w-5"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M3 6h18"
                                            />

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2"
                                            />

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"
                                            />

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M10 11v6M14 11v6"
                                            />
                                        </svg>

                                    </div>


                                    <div class="min-w-0 flex-1">

                                        <p class="text-sm font-semibold text-error-600 dark:text-error-400">
                                            Delete User
                                        </p>

                                        <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">
                                            Permanently remove this user's account
                                        </p>

                                    </div>


                                    <svg
                                        class="h-5 w-5 shrink-0 text-error-300 transition group-hover:translate-x-0.5 group-hover:text-error-500 dark:text-error-500/40 dark:group-hover:text-error-400"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M9 5l7 7-7 7"
                                        />
                                    </svg>

                                </button>

                            </form>

                        @else

                            <div class="rounded-xl bg-gray-50 p-4 dark:bg-gray-800/50">

                                <div class="flex items-start gap-3">

                                    <svg
                                        class="mt-0.5 h-5 w-5 shrink-0 text-gray-400"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                    >
                                        <circle
                                            cx="12"
                                            cy="12"
                                            r="9"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            d="M12 11v5"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            d="M12 8h.01"
                                        />
                                    </svg>

                                    <p class="text-xs leading-5 text-gray-500 dark:text-gray-400">
                                        You cannot deactivate or delete your own administrator account.
                                    </p>

                                </div>

                            </div>

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
        RECENT LINKS
    ========================================================== --}}
    <div class="mt-6">

        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="flex flex-col gap-3 border-b border-gray-200 px-5 py-5 sm:flex-row sm:items-center sm:justify-between dark:border-gray-800 lg:px-6">

                <div>

                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                        Recent Links
                    </h3>

                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        The latest short links created by this user.
                    </p>

                </div>


                @if($user->short_urls_count > 0)

                    <a
                        href="{{ route('admin.links.index', ['user_id' => $user->id]) }}"
                        class="inline-flex items-center gap-1.5 text-sm font-medium text-brand-500 hover:text-brand-600"
                    >

                        View all links

                        <svg
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M9 5l7 7-7 7"
                            />
                        </svg>

                    </a>

                @endif

            </div>


            @if($recentLinks->count())

                <div class="overflow-x-auto">

                    <table class="w-full min-w-[700px]">

                        <thead>

                            <tr class="border-b border-gray-100 dark:border-gray-800">

                                <th class="px-5 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-400 dark:text-gray-500">
                                    Short Link
                                </th>

                                <th class="px-5 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-400 dark:text-gray-500">
                                    Destination
                                </th>

                                <th class="px-5 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-400 dark:text-gray-500">
                                    Clicks
                                </th>

                                <th class="px-5 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-400 dark:text-gray-500">
                                    Status
                                </th>

                                <th class="px-5 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-400 dark:text-gray-500">
                                    Created
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">

                            @foreach($recentLinks as $link)

                                <tr class="transition hover:bg-gray-50 dark:hover:bg-white/[0.02]">

                                    <td class="px-5 py-4">

                                        <div class="flex items-center gap-3">

                                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-brand-50 text-brand-500 dark:bg-brand-500/10 dark:text-brand-400">

                                                <svg
                                                    class="h-4 w-4"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor"
                                                    stroke-width="1.8"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M10 13a5 5 0 007.54.54l3-3a5 5 0 00-7.07-7.07l-1.72 1.71"
                                                    />

                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M14 11a5 5 0 00-7.54-.54l-3 3a5 5 0 007.07 7.07l1.71-1.71"
                                                    />
                                                </svg>

                                            </div>


                                            <div class="min-w-0">

                                                <p class="truncate text-sm font-medium text-gray-800 dark:text-white/90">
                                                    {{ $link->custom_alias ?: $link->short_code }}
                                                </p>

                                                <p class="truncate text-xs text-gray-400 dark:text-gray-500">
                                                    /{{ $link->custom_alias ?: $link->short_code }}
                                                </p>

                                            </div>

                                        </div>

                                    </td>


                                    <td class="max-w-xs px-5 py-4">

                                        <p
                                            class="truncate text-sm text-gray-600 dark:text-gray-300"
                                            title="{{ $link->original_url }}"
                                        >
                                            {{ $link->original_url }}
                                        </p>

                                    </td>


                                    <td class="px-5 py-4">

                                        <span class="text-sm font-semibold text-gray-800 dark:text-white/90">
                                            {{ number_format($link->click_count) }}
                                        </span>

                                    </td>


                                    <td class="px-5 py-4">

                                        @if($link->status === 'active')

                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-success-50 px-2.5 py-1 text-xs font-medium text-success-600 dark:bg-success-500/10 dark:text-success-400">

                                                <span class="h-1.5 w-1.5 rounded-full bg-success-500"></span>

                                                Active

                                            </span>

                                        @elseif($link->status === 'expired')

                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-warning-50 px-2.5 py-1 text-xs font-medium text-warning-600 dark:bg-warning-500/10 dark:text-warning-400">

                                                <span class="h-1.5 w-1.5 rounded-full bg-warning-500"></span>

                                                Expired

                                            </span>

                                        @else

                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-600 dark:bg-gray-800 dark:text-gray-300">

                                                <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span>

                                                Disabled

                                            </span>

                                        @endif

                                    </td>


                                    <td class="px-5 py-4 text-right">

                                        <span class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $link->created_at?->format('M d, Y') ?? '—' }}
                                        </span>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="px-5 py-12 text-center lg:px-6">

                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 text-gray-400 dark:bg-gray-800">

                        <svg
                            class="h-6 w-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M10 13a5 5 0 007.54.54l3-3a5 5 0 00-7.07-7.07l-1.72 1.71"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M14 11a5 5 0 00-7.54-.54l-3 3a5 5 0 007.07 7.07l1.71-1.71"
                            />
                        </svg>

                    </div>

                    <h4 class="mt-4 text-sm font-semibold text-gray-800 dark:text-white/90">
                        No links yet
                    </h4>

                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        This user has not created any short links.
                    </p>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection