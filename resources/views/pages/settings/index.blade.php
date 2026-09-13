@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-7xl">

{{-- Success Message --}}
@if (session('success'))
    <div class="mb-6 rounded-lg border border-gray-200 bg-white px-4 py-3 text-sm text-gray-700 dark:border-gray-800 dark:bg-white/[0.03] dark:text-gray-300">
        {{ session('success') }}
    </div>
@endif

{{-- Validation Errors --}}
@if ($errors->any())
    <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 dark:border-red-900/50 dark:bg-red-500/10 dark:text-red-400">
        <ul class="list-disc space-y-1 pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- Page Header --}}
<div class="mb-6">
    <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">
        {{ __('messages.settings') }}
    </h1>

    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
        {{ __('messages.manage_account') }}
    </p>
</div>


{{-- ========================================================= --}}
{{-- SETTINGS NAVIGATION --}}
{{-- ========================================================= --}}

<div class="mb-6 overflow-x-auto border-b border-gray-200 dark:border-gray-800">

    <div class="flex min-w-max gap-6">

        {{-- General --}}
        <a
            href="{{ route('settings', ['tab' => 'general']) }}"
            class="border-b-2 px-1 pb-3 text-sm font-medium
            {{ $tab === 'general'
                ? 'border-gray-800 text-gray-800 dark:border-white dark:text-white'
                : 'border-transparent text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-white'
            }}"
        >
            {{ __('messages.general') }}
        </a>

        {{-- Profile --}}
        <a
            href="{{ route('settings', ['tab' => 'profile']) }}"
            class="border-b-2 px-1 pb-3 text-sm font-medium
            {{ $tab === 'profile'
                ? 'border-gray-800 text-gray-800 dark:border-white dark:text-white'
                : 'border-transparent text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-white'
            }}"
        >
            {{ __('messages.profile') }}
        </a>

        {{-- Security --}}
        <a
            href="{{ route('settings', ['tab' => 'security']) }}"
            class="border-b-2 px-1 pb-3 text-sm font-medium
            {{ $tab === 'security'
                ? 'border-gray-800 text-gray-800 dark:border-white dark:text-white'
                : 'border-transparent text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-white'
            }}"
        >
            {{ __('messages.security') }}
        </a>

        {{-- Notifications --}}
        <a
            href="{{ route('settings', ['tab' => 'notifications']) }}"
            class="border-b-2 px-1 pb-3 text-sm font-medium
            {{ $tab === 'notifications'
                ? 'border-gray-800 text-gray-800 dark:border-white dark:text-white'
                : 'border-transparent text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-white'
            }}"
        >
            {{ __('messages.notifications') }}
        </a>

        {{-- API --}}
        <a
            href="{{ route('settings', ['tab' => 'api']) }}"
            class="border-b-2 px-1 pb-3 text-sm font-medium
            {{ $tab === 'api'
                ? 'border-gray-800 text-gray-800 dark:border-white dark:text-white'
                : 'border-transparent text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-white'
            }}"
        >
            {{ __('messages.api') }}
        </a>

    </div>

</div>


{{-- ========================================================= --}}
{{-- GENERAL TAB --}}
{{-- ========================================================= --}}

@if ($tab === 'general')

    <form
        method="POST"
        action="{{ route('settings.update') }}"
        class="space-y-6"
    >

        @csrf
        @method('PATCH')


        {{-- ================================================= --}}
        {{-- APPLICATION PREFERENCES --}}
        {{-- ================================================= --}}

        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="border-b border-gray-200 px-5 py-5 dark:border-gray-800">

                <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
                    {{ __('messages.application_preferences') }}
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ __('messages.configure_platform') }}
                </p>

            </div>


            <div class="divide-y divide-gray-200 dark:divide-gray-800">

                {{-- Language --}}
                <div class="flex flex-col gap-4 px-5 py-5 sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <h3 class="text-sm font-medium text-gray-800 dark:text-white">
                            {{ __('messages.language') }}
                        </h3>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            {{ __('messages.language_description') }}
                        </p>
                    </div>


                    <select
                        name="language"
                        class="h-10 w-full rounded-lg border border-gray-300 bg-white px-3 text-sm text-gray-800 outline-none focus:border-gray-500 sm:w-48 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                    >

                        <option
                            value="English"
                            @selected($settings->language === 'English')
                        >
                            {{ __('messages.english') }}
                        </option>

                        <option
                            value="Bangla"
                            @selected($settings->language === 'Bangla')
                        >
                            {{ __('messages.bangla') }}
                        </option>

                    </select>

                </div>


                {{-- Timezone --}}
                <div class="flex flex-col gap-4 px-5 py-5 sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <h3 class="text-sm font-medium text-gray-800 dark:text-white">
                            {{ __('messages.timezone') }}
                        </h3>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            {{ __('messages.timezone_description') }}
                        </p>
                    </div>


                    <select
                        name="timezone"
                        class="h-10 w-full rounded-lg border border-gray-300 bg-white px-3 text-sm text-gray-800 outline-none focus:border-gray-500 sm:w-64 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                    >

                        <option
                            value="Asia/Dhaka"
                            @selected($settings->timezone === 'Asia/Dhaka')
                        >
                            Asia/Dhaka (UTC+06:00)
                        </option>

                        <option
                            value="UTC"
                            @selected($settings->timezone === 'UTC')
                        >
                            UTC
                        </option>

                        <option
                            value="Asia/Kolkata"
                            @selected($settings->timezone === 'Asia/Kolkata')
                        >
                            Asia/Kolkata (UTC+05:30)
                        </option>

                        <option
                            value="Europe/London"
                            @selected($settings->timezone === 'Europe/London')
                        >
                            Europe/London (UTC+00:00)
                        </option>

                        <option
                            value="America/New_York"
                            @selected($settings->timezone === 'America/New_York')
                        >
                            America/New_York (UTC-05:00)
                        </option>

                    </select>

                </div>


                {{-- Date Format --}}
                <div class="flex flex-col gap-4 px-5 py-5 sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <h3 class="text-sm font-medium text-gray-800 dark:text-white">
                            {{ __('messages.date_format') }}
                        </h3>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            {{ __('messages.date_format_description') }}
                        </p>
                    </div>


                    <select
                        name="date_format"
                        class="h-10 w-full rounded-lg border border-gray-300 bg-white px-3 text-sm text-gray-800 outline-none focus:border-gray-500 sm:w-48 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                    >

                        <option
                            value="MMM DD, YYYY"
                            @selected($settings->date_format === 'MMM DD, YYYY')
                        >
                            {{ __('messages.date_format_mmm_dd_yyyy') }}
                        </option>

                        <option
                            value="DD/MM/YYYY"
                            @selected($settings->date_format === 'DD/MM/YYYY')
                        >
                            {{ __('messages.date_format_dd_mm_yyyy') }}
                        </option>

                        <option
                            value="MM/DD/YYYY"
                            @selected($settings->date_format === 'MM/DD/YYYY')
                        >
                            {{ __('messages.date_format_mm_dd_yyyy') }}
                        </option>

                        <option
                            value="YYYY-MM-DD"
                            @selected($settings->date_format === 'YYYY-MM-DD')
                        >
                            {{ __('messages.date_format_yyyy_mm_dd') }}
                        </option>

                    </select>

                </div>

            </div>

        </div>


        {{-- ================================================= --}}
        {{-- URL SETTINGS --}}
        {{-- ================================================= --}}

        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="border-b border-gray-200 px-5 py-5 dark:border-gray-800">

                <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
                    {{ __('messages.url_settings') }}
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ __('messages.url_settings_description') }}
                </p>

            </div>


            <div class="divide-y divide-gray-200 dark:divide-gray-800">

                {{-- Default Expiration --}}
                <div class="flex flex-col gap-4 px-5 py-5 sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <h3 class="text-sm font-medium text-gray-800 dark:text-white">
                            {{ __('messages.default_expiration') }}
                        </h3>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            {{ __('messages.default_expiration_description') }}
                        </p>
                    </div>


                    <select
                        name="default_expiration"
                        class="h-10 w-full rounded-lg border border-gray-300 bg-white px-3 text-sm text-gray-800 outline-none focus:border-gray-500 sm:w-48 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                    >

                        <option
                            value="Never"
                            @selected($settings->default_expiration === 'Never')
                        >
                            {{ __('messages.never') }}
                        </option>

                        <option
                            value="7 Days"
                            @selected($settings->default_expiration === '7 Days')
                        >
                            {{ __('messages.seven_days') }}
                        </option>

                        <option
                            value="30 Days"
                            @selected($settings->default_expiration === '30 Days')
                        >
                            {{ __('messages.thirty_days') }}
                        </option>

                        <option
                            value="90 Days"
                            @selected($settings->default_expiration === '90 Days')
                        >
                            {{ __('messages.ninety_days') }}
                        </option>

                        <option
                            value="1 Year"
                            @selected($settings->default_expiration === '1 Year')
                        >
                            {{ __('messages.one_year') }}
                        </option>

                    </select>

                </div>


                {{-- Custom Alias --}}
                <div class="flex flex-col gap-4 px-5 py-5 sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <h3 class="text-sm font-medium text-gray-800 dark:text-white">
                            {{ __('messages.allow_custom_aliases') }}
                        </h3>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            {{ __('messages.allow_custom_aliases_description') }}
                        </p>
                    </div>


                    <label class="relative inline-flex cursor-pointer items-center">

                        <input
                            type="checkbox"
                            name="allow_custom_aliases"
                            value="1"
                            class="peer sr-only"
                            @checked($settings->allow_custom_aliases)
                        >

                        <div class="h-6 w-11 rounded-full bg-gray-200 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-gray-800 peer-checked:after:translate-x-full peer-checked:after:border-white dark:bg-gray-700 dark:peer-checked:bg-white"></div>

                    </label>

                </div>


                {{-- Duplicate Detection --}}
                <div class="flex flex-col gap-4 px-5 py-5 sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <h3 class="text-sm font-medium text-gray-800 dark:text-white">
                            {{ __('messages.duplicate_detection') }}
                        </h3>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            {{ __('messages.duplicate_detection_description') }}
                        </p>
                    </div>


                    <label class="relative inline-flex cursor-pointer items-center">

                        <input
                            type="checkbox"
                            name="duplicate_detection"
                            value="1"
                            class="peer sr-only"
                            @checked($settings->duplicate_detection)
                        >

                        <div class="h-6 w-11 rounded-full bg-gray-200 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-gray-800 peer-checked:after:translate-x-full peer-checked:after:border-white dark:bg-gray-700 dark:peer-checked:bg-white"></div>

                    </label>

                </div>

            </div>

        </div>


        {{-- ================================================= --}}
        {{-- NOTIFICATIONS --}}
        {{-- ================================================= --}}

        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="border-b border-gray-200 px-5 py-5 dark:border-gray-800">

                <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
                    {{ __('messages.notifications') }}
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ __('messages.notifications_description') }}
                </p>

            </div>


            <div class="divide-y divide-gray-200 dark:divide-gray-800">

                {{-- Link Expiration --}}
                <div class="flex items-center justify-between px-5 py-5">

                    <div>
                        <h3 class="text-sm font-medium text-gray-800 dark:text-white">
                            {{ __('messages.link_expiration_alerts') }}
                        </h3>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            {{ __('messages.link_expiration_alerts_description') }}
                        </p>
                    </div>


                    <label class="relative inline-flex cursor-pointer items-center">

                        <input
                            type="checkbox"
                            name="link_expiration_alerts"
                            value="1"
                            class="peer sr-only"
                            @checked($settings->link_expiration_alerts)
                        >

                        <div class="h-6 w-11 rounded-full bg-gray-200 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-gray-800 peer-checked:after:translate-x-full peer-checked:after:border-white dark:bg-gray-700 dark:peer-checked:bg-white"></div>

                    </label>

                </div>


                {{-- Report Notifications --}}
                <div class="flex items-center justify-between px-5 py-5">

                    <div>
                        <h3 class="text-sm font-medium text-gray-800 dark:text-white">
                            {{ __('messages.report_notifications') }}
                        </h3>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            {{ __('messages.report_notifications_description') }}
                        </p>
                    </div>


                    <label class="relative inline-flex cursor-pointer items-center">

                        <input
                            type="checkbox"
                            name="report_notifications"
                            value="1"
                            class="peer sr-only"
                            @checked($settings->report_notifications)
                        >

                        <div class="h-6 w-11 rounded-full bg-gray-200 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-gray-800 peer-checked:after:translate-x-full peer-checked:after:border-white dark:bg-gray-700 dark:peer-checked:bg-white"></div>

                    </label>

                </div>


                {{-- Security Alerts --}}
                <div class="flex items-center justify-between px-5 py-5">

                    <div>
                        <h3 class="text-sm font-medium text-gray-800 dark:text-white">
                            {{ __('messages.security_alerts') }}
                        </h3>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            {{ __('messages.security_alerts_description') }}
                        </p>
                    </div>


                    <label class="relative inline-flex cursor-pointer items-center">

                        <input
                            type="checkbox"
                            name="security_alerts"
                            value="1"
                            class="peer sr-only"
                            @checked($settings->security_alerts)
                        >

                        <div class="h-6 w-11 rounded-full bg-gray-200 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-gray-800 peer-checked:after:translate-x-full peer-checked:after:border-white dark:bg-gray-700 dark:peer-checked:bg-white"></div>

                    </label>

                </div>

            </div>

        </div>


        {{-- ================================================= --}}
        {{-- SAVE CHANGES --}}
        {{-- ================================================= --}}

        <div class="flex flex-col gap-3 border-t border-gray-200 pt-6 sm:flex-row sm:items-center sm:justify-end dark:border-gray-800">

            <a
                href="{{ route('settings') }}"
                class="rounded-lg border border-gray-300 px-5 py-2.5 text-center text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-white/5"
            >
                {{ __('messages.cancel') }}
            </a>

            <button
                type="submit"
                class="rounded-lg bg-gray-800 px-5 py-2.5 text-sm font-medium text-white hover:bg-gray-700 dark:bg-white dark:text-gray-800 dark:hover:bg-gray-100"
            >
                {{ __('messages.save_changes') }}
            </button>

        </div>

    </form>

@endif


{{-- ========================================================= --}}
{{-- PROFILE TAB --}}
{{-- ========================================================= --}}

@if ($tab === 'profile')

    <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">

        <div class="mb-6">

            <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
                {{ __('messages.profile_settings') }}
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                {{ __('messages.profile_description') }}
            </p>

        </div>


        <div class="flex flex-col gap-4 sm:flex-row">

            <a
                href="{{ route('profile.edit') }}"
                class="inline-flex items-center justify-center rounded-lg bg-gray-800 px-5 py-2.5 text-sm font-medium text-white hover:bg-gray-700 dark:bg-white dark:text-gray-800 dark:hover:bg-gray-100"
            >
                {{ __('messages.manage_profile') }}
            </a>

        </div>

    </div>

@endif


{{-- ========================================================= --}}
{{-- SECURITY TAB --}}
{{-- ========================================================= --}}

@if ($tab === 'security')

    <div class="space-y-6">

        {{-- Password --}}
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="border-b border-gray-200 px-5 py-5 dark:border-gray-800">

                <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
                    {{ __('messages.password') }}
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ __('messages.password_description') }}
                </p>

            </div>


            <div class="px-5 py-5">

                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                    <div>

                        <h3 class="text-sm font-medium text-gray-800 dark:text-white">
                            {{ __('messages.change_password') }}
                        </h3>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            {{ __('messages.change_password_description') }}
                        </p>

                    </div>


                    <a
                        href="{{ route('profile.edit') }}"
                        class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-white/5"
                    >
                        {{ __('messages.change_password') }}
                    </a>

                </div>

            </div>

        </div>


        {{-- Active Sessions --}}
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="border-b border-gray-200 px-5 py-5 dark:border-gray-800">

                <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
                    {{ __('messages.active_sessions') }}
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ __('messages.active_sessions_description') }}
                </p>

            </div>


            <div class="px-5 py-5">

                <p class="text-sm text-gray-600 dark:text-gray-300">
                    {{ __('messages.active_sessions_info') }}
                </p>

            </div>

        </div>


        {{-- Two Factor Authentication --}}
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="border-b border-gray-200 px-5 py-5 dark:border-gray-800">

                <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
                    {{ __('messages.two_factor') }}
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ __('messages.two_factor_description') }}
                </p>

            </div>


            <div class="px-5 py-5">

                <p class="text-sm text-gray-600 dark:text-gray-300">
                    {{ __('messages.two_factor_info') }}
                </p>

            </div>

        </div>

    </div>

@endif


{{-- ========================================================= --}}
{{-- NOTIFICATIONS TAB --}}
{{-- ========================================================= --}}

@if ($tab === 'notifications')

    <form
        method="POST"
        action="{{ route('settings.update') }}"
        class="space-y-6"
    >

        @csrf
        @method('PATCH')


        {{-- Hidden values required by validation --}}
        <input
            type="hidden"
            name="language"
            value="{{ $settings->language }}"
        >

        <input
            type="hidden"
            name="timezone"
            value="{{ $settings->timezone }}"
        >

        <input
            type="hidden"
            name="date_format"
            value="{{ $settings->date_format }}"
        >

        <input
            type="hidden"
            name="default_expiration"
            value="{{ $settings->default_expiration }}"
        >


        {{-- Notification Preferences --}}
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="border-b border-gray-200 px-5 py-5 dark:border-gray-800">

                <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
                    {{ __('messages.notification_preferences') }}
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ __('messages.notifications_description') }}
                </p>

            </div>


            <div class="divide-y divide-gray-200 dark:divide-gray-800">

                {{-- Link Expiration --}}
                <div class="flex items-center justify-between px-5 py-5">

                    <div>

                        <h3 class="text-sm font-medium text-gray-800 dark:text-white">
                            {{ __('messages.link_expiration_alerts') }}
                        </h3>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            {{ __('messages.link_expiration_alerts_description') }}
                        </p>

                    </div>


                    <label class="relative inline-flex cursor-pointer items-center">

                        <input
                            type="checkbox"
                            name="link_expiration_alerts"
                            value="1"
                            class="peer sr-only"
                            @checked($settings->link_expiration_alerts)
                        >

                        <div class="h-6 w-11 rounded-full bg-gray-200 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-gray-800 peer-checked:after:translate-x-full peer-checked:after:border-white dark:bg-gray-700 dark:peer-checked:bg-white"></div>

                    </label>

                </div>


                {{-- Report Notifications --}}
                <div class="flex items-center justify-between px-5 py-5">

                    <div>

                        <h3 class="text-sm font-medium text-gray-800 dark:text-white">
                            {{ __('messages.report_notifications') }}
                        </h3>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            {{ __('messages.report_notifications_description') }}
                        </p>

                    </div>


                    <label class="relative inline-flex cursor-pointer items-center">

                        <input
                            type="checkbox"
                            name="report_notifications"
                            value="1"
                            class="peer sr-only"
                            @checked($settings->report_notifications)
                        >

                        <div class="h-6 w-11 rounded-full bg-gray-200 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-gray-800 peer-checked:after:translate-x-full peer-checked:after:border-white dark:bg-gray-700 dark:peer-checked:bg-white"></div>

                    </label>

                </div>


                {{-- Security Alerts --}}
                <div class="flex items-center justify-between px-5 py-5">

                    <div>

                        <h3 class="text-sm font-medium text-gray-800 dark:text-white">
                            {{ __('messages.security_alerts') }}
                        </h3>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            {{ __('messages.security_alerts_description') }}
                        </p>

                    </div>


                    <label class="relative inline-flex cursor-pointer items-center">

                        <input
                            type="checkbox"
                            name="security_alerts"
                            value="1"
                            class="peer sr-only"
                            @checked($settings->security_alerts)
                        >

                        <div class="h-6 w-11 rounded-full bg-gray-200 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-gray-800 peer-checked:after:translate-x-full peer-checked:after:border-white dark:bg-gray-700 dark:peer-checked:bg-white"></div>

                    </label>

                </div>

            </div>

        </div>


        {{-- Save Notifications --}}
        <div class="flex justify-end border-t border-gray-200 pt-6 dark:border-gray-800">

            <button
                type="submit"
                class="rounded-lg bg-gray-800 px-5 py-2.5 text-sm font-medium text-white hover:bg-gray-700 dark:bg-white dark:text-gray-800 dark:hover:bg-gray-100"
            >
                {{ __('messages.save_notifications') }}
            </button>

        </div>

    </form>

@endif


{{-- ========================================================= --}}
{{-- API TAB --}}
{{-- ========================================================= --}}

@if ($tab === 'api')

    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

        <div class="border-b border-gray-200 px-5 py-5 dark:border-gray-800">

            <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
                {{ __('messages.api_access') }}
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                {{ __('messages.api_access_description') }}
            </p>

        </div>


        <div class="px-5 py-5">

            {{-- API Keys --}}
            <div class="rounded-lg border border-gray-200 bg-gray-50 p-5 dark:border-gray-800 dark:bg-white/[0.02]">

                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                    <div>

                        <h3 class="text-sm font-medium text-gray-800 dark:text-white">
                            {{ __('messages.api_keys') }}
                        </h3>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            {{ __('messages.api_keys_description') }}
                        </p>

                    </div>


                    <button
                        type="button"
                        disabled
                        class="cursor-not-allowed rounded-lg bg-gray-300 px-4 py-2.5 text-sm font-medium text-gray-500 dark:bg-gray-700 dark:text-gray-400"
                    >
                        {{ __('messages.manage_api_keys') }}
                    </button>

                </div>

            </div>


            {{-- API Information --}}
            <div class="mt-4 rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.02]">

                <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ __('messages.api_keys_info') }}
                </p>

            </div>

        </div>

    </div>

@endif

</div>

@endsection
