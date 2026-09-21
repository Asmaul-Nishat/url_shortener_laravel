@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-5xl">


{{-- Page Header --}}
<div class="mb-6">

    <div class="mb-2 flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">

        <a
            href="{{ route('admin.dashboard') }}"
            class="transition hover:text-brand-500"
        >
            Admin Dashboard
        </a>

        <span>/</span>

        <span class="text-gray-700 dark:text-gray-300">
            Settings
        </span>

    </div>

    <h1 class="text-2xl font-bold text-gray-800 dark:text-white/90">
        System Settings
    </h1>

    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
        Manage system-wide settings for the URL Shortener platform.
    </p>

</div>


{{-- Success Message --}}
@if(session('success'))

    <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-5 py-4 dark:border-green-900/50 dark:bg-green-900/20">

        <p class="text-sm font-medium text-green-700 dark:text-green-400">
            {{ session('success') }}
        </p>

    </div>

@endif


{{-- Error Message --}}
@if(session('error'))

    <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 dark:border-red-900/50 dark:bg-red-900/20">

        <p class="text-sm font-medium text-red-700 dark:text-red-400">
            {{ session('error') }}
        </p>

    </div>

@endif


{{-- Validation Errors --}}
@if($errors->any())

    <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 dark:border-red-900/50 dark:bg-red-900/20">

        <p class="text-sm font-medium text-red-700 dark:text-red-400">
            Please correct the following errors:
        </p>

        <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-700 dark:text-red-400">

            @foreach($errors->all() as $error)

                <li>
                    {{ $error }}
                </li>

            @endforeach

        </ul>

    </div>

@endif


{{-- Settings Form --}}
<form
    method="POST"
    action="{{ route('admin.settings.update') }}"
>

    @csrf
    @method('PATCH')


    {{-- ===================================================== --}}
    {{-- General Settings --}}
    {{-- ===================================================== --}}

    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

        <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">

            <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                General Settings
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Configure default behavior for newly created links.
            </p>

        </div>


        <div class="space-y-6 p-6">

            {{-- Default Link Status --}}
            <div>

                <label
                    for="default_link_status"
                    class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                >
                    Default Link Status
                </label>

                <select
                    id="default_link_status"
                    name="default_link_status"
                    required
                    class="h-11 w-full rounded-lg border border-gray-300 bg-white px-4 text-sm text-gray-800 outline-none transition focus:border-brand-500 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                >

                    <option
                        value="active"
                        @selected(
                            old(
                                'default_link_status',
                                $settings->default_link_status
                            ) === 'active'
                        )
                    >
                        Active
                    </option>

                    <option
                        value="disabled"
                        @selected(
                            old(
                                'default_link_status',
                                $settings->default_link_status
                            ) === 'disabled'
                        )
                    >
                        Disabled
                    </option>

                </select>

                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                    Determines the default status assigned to newly created links.
                </p>

            </div>


            {{-- Default Expiration --}}
            <div>

                <label
                    for="default_expiration_days"
                    class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                >
                    Default Link Expiration
                </label>

                <div class="flex">

                    <input
                        id="default_expiration_days"
                        name="default_expiration_days"
                        type="number"
                        min="0"
                        max="3650"
                        required
                        value="{{ old('default_expiration_days', $settings->default_expiration_days) }}"
                        class="h-11 min-w-0 flex-1 rounded-l-lg border border-gray-300 bg-white px-4 text-sm text-gray-800 outline-none transition focus:border-brand-500 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                    >

                    <span class="inline-flex h-11 items-center rounded-r-lg border border-l-0 border-gray-300 bg-gray-50 px-4 text-sm text-gray-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                        days
                    </span>

                </div>

                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                    Enter 0 to disable automatic expiration.
                </p>

            </div>

        </div>

    </div>


    {{-- ===================================================== --}}
    {{-- Guest Access --}}
    {{-- ===================================================== --}}

    <div class="mt-6 rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

        <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">

            <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                Guest Access
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Control which features are available to visitors without an account.
            </p>

        </div>


        <div class="divide-y divide-gray-200 dark:divide-gray-800">


            {{-- ================================================= --}}
            {{-- Guest Short URLs --}}
            {{-- ================================================= --}}

            <div
                x-data="{ enabled: {{ old('allow_guest_short_urls', $settings->allow_guest_short_urls) ? 'true' : 'false' }} }"
                class="flex items-center justify-between gap-6 px-6 py-5"
            >

                <div class="min-w-0">

                    <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                        Allow Guest Short URLs
                    </p>

                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        Allow visitors to create short URLs without registering.
                    </p>

                </div>


                <div class="shrink-0">

                    <input
                        type="hidden"
                        name="allow_guest_short_urls"
                        value="0"
                    >

                    <button
                        type="button"
                        role="switch"
                        :aria-checked="enabled.toString()"
                        @click="enabled = !enabled"
                        class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900"
                        :class="enabled ? 'bg-brand-500' : 'bg-gray-300 dark:bg-gray-700'"
                    >

                        <span
                            class="inline-block h-4 w-4 transform rounded-full bg-white shadow-sm transition-transform duration-200"
                            :class="enabled ? 'translate-x-6' : 'translate-x-1'"
                        ></span>

                    </button>

                    <input
                        x-show="enabled"
                        type="hidden"
                        name="allow_guest_short_urls"
                        value="1"
                    >

                </div>

            </div>


            {{-- ================================================= --}}
            {{-- Guest QR Codes --}}
            {{-- ================================================= --}}

            <div
                x-data="{ enabled: {{ old('allow_guest_qr_codes', $settings->allow_guest_qr_codes) ? 'true' : 'false' }} }"
                class="flex items-center justify-between gap-6 px-6 py-5"
            >

                <div class="min-w-0">

                    <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                        Allow Guest QR Codes
                    </p>

                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        Allow visitors to generate QR codes without registering.
                    </p>

                </div>


                <div class="shrink-0">

                    <input
                        type="hidden"
                        name="allow_guest_qr_codes"
                        value="0"
                    >

                    <button
                        type="button"
                        role="switch"
                        :aria-checked="enabled.toString()"
                        @click="enabled = !enabled"
                        class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900"
                        :class="enabled ? 'bg-brand-500' : 'bg-gray-300 dark:bg-gray-700'"
                    >

                        <span
                            class="inline-block h-4 w-4 transform rounded-full bg-white shadow-sm transition-transform duration-200"
                            :class="enabled ? 'translate-x-6' : 'translate-x-1'"
                        ></span>

                    </button>

                    <input
                        x-show="enabled"
                        type="hidden"
                        name="allow_guest_qr_codes"
                        value="1"
                    >

                </div>

            </div>

        </div>

    </div>


    {{-- ===================================================== --}}
    {{-- Platform Features --}}
    {{-- ===================================================== --}}

    <div class="mt-6 rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

        <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">

            <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                Platform Features
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Enable or disable major platform features.
            </p>

        </div>


        <div class="divide-y divide-gray-200 dark:divide-gray-800">


            {{-- ================================================= --}}
            {{-- Analytics --}}
            {{-- ================================================= --}}

            <div
                x-data="{ enabled: {{ old('enable_analytics', $settings->enable_analytics) ? 'true' : 'false' }} }"
                class="flex items-center justify-between gap-6 px-6 py-5"
            >

                <div class="min-w-0">

                    <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                        Analytics
                    </p>

                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        Enable or disable new click tracking.
                    </p>

                </div>


                <div class="shrink-0">

                    <input
                        type="hidden"
                        name="enable_analytics"
                        value="0"
                    >

                    <button
                        type="button"
                        role="switch"
                        :aria-checked="enabled.toString()"
                        @click="enabled = !enabled"
                        class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900"
                        :class="enabled ? 'bg-brand-500' : 'bg-gray-300 dark:bg-gray-700'"
                    >

                        <span
                            class="inline-block h-4 w-4 transform rounded-full bg-white shadow-sm transition-transform duration-200"
                            :class="enabled ? 'translate-x-6' : 'translate-x-1'"
                        ></span>

                    </button>

                    <input
                        x-show="enabled"
                        type="hidden"
                        name="enable_analytics"
                        value="1"
                    >

                </div>

            </div>


            {{-- ================================================= --}}
            {{-- Reports --}}
            {{-- ================================================= --}}

            <div
                x-data="{ enabled: {{ old('enable_reports', $settings->enable_reports) ? 'true' : 'false' }} }"
                class="flex items-center justify-between gap-6 px-6 py-5"
            >

                <div class="min-w-0">

                    <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                        Reports
                    </p>

                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        Enable or disable report generation and downloads.
                    </p>

                </div>


                <div class="shrink-0">

                    <input
                        type="hidden"
                        name="enable_reports"
                        value="0"
                    >

                    <button
                        type="button"
                        role="switch"
                        :aria-checked="enabled.toString()"
                        @click="enabled = !enabled"
                        class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900"
                        :class="enabled ? 'bg-brand-500' : 'bg-gray-300 dark:bg-gray-700'"
                    >

                        <span
                            class="inline-block h-4 w-4 transform rounded-full bg-white shadow-sm transition-transform duration-200"
                            :class="enabled ? 'translate-x-6' : 'translate-x-1'"
                        ></span>

                    </button>

                    <input
                        x-show="enabled"
                        type="hidden"
                        name="enable_reports"
                        value="1"
                    >

                </div>

            </div>


            {{-- ================================================= --}}
            {{-- Activity Logs --}}
            {{-- ================================================= --}}

            <div
                x-data="{ enabled: {{ old('enable_activity_logs', $settings->enable_activity_logs) ? 'true' : 'false' }} }"
                class="flex items-center justify-between gap-6 px-6 py-5"
            >

                <div class="min-w-0">

                    <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                        Activity Logs
                    </p>

                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        Enable or disable recording of new user and administrative activities.
                    </p>

                </div>


                <div class="shrink-0">

                    <input
                        type="hidden"
                        name="enable_activity_logs"
                        value="0"
                    >

                    <button
                        type="button"
                        role="switch"
                        :aria-checked="enabled.toString()"
                        @click="enabled = !enabled"
                        class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900"
                        :class="enabled ? 'bg-brand-500' : 'bg-gray-300 dark:bg-gray-700'"
                    >

                        <span
                            class="inline-block h-4 w-4 transform rounded-full bg-white shadow-sm transition-transform duration-200"
                            :class="enabled ? 'translate-x-6' : 'translate-x-1'"
                        ></span>

                    </button>

                    <input
                        x-show="enabled"
                        type="hidden"
                        name="enable_activity_logs"
                        value="1"
                    >

                </div>

            </div>

        </div>

    </div>


    {{-- ===================================================== --}}
    {{-- Save Button --}}
    {{-- ===================================================== --}}

    <div class="mt-6 flex justify-end">

        <button
            type="submit"
            class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white shadow-theme-xs transition hover:bg-brand-600"
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
                    d="M5 13l4 4L19 7"
                />
            </svg>

            Save Settings

        </button>

    </div>

</form>

</div>

@endsection
