@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-7xl">

    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">
            Settings
        </h1>

        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Manage your account, preferences, security and application settings.
        </p>
    </div>


    <!-- Settings Navigation -->
    <div class="mb-6 overflow-x-auto border-b border-gray-200 dark:border-gray-800">
        <div class="flex min-w-max gap-6">

            <button
                type="button"
                class="border-b-2 border-gray-800 px-1 pb-3 text-sm font-medium text-gray-800 dark:border-white dark:text-white"
            >
                General
            </button>

            <button
                type="button"
                class="px-1 pb-3 text-sm font-medium text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-white"
            >
                Profile
            </button>

            <button
                type="button"
                class="px-1 pb-3 text-sm font-medium text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-white"
            >
                Security
            </button>

            <button
                type="button"
                class="px-1 pb-3 text-sm font-medium text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-white"
            >
                Notifications
            </button>

            <button
                type="button"
                class="px-1 pb-3 text-sm font-medium text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-white"
            >
                API
            </button>

        </div>
    </div>


    <!-- General Settings -->
    <div class="space-y-6">

        <!-- Application Preferences -->
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="border-b border-gray-200 px-5 py-5 dark:border-gray-800">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
                    Application Preferences
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Configure how the URL Shortener platform behaves.
                </p>
            </div>


            <div class="divide-y divide-gray-200 dark:divide-gray-800">

                <!-- Language -->
                <div class="flex flex-col gap-4 px-5 py-5 sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <h3 class="text-sm font-medium text-gray-800 dark:text-white">
                            Language
                        </h3>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Select your preferred application language.
                        </p>
                    </div>

                    <select
                        class="h-10 w-full rounded-lg border border-gray-300 bg-white px-3 text-sm text-gray-800 outline-none focus:border-gray-500 sm:w-48 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                    >
                        <option>English</option>
                        <option>Bangla</option>
                    </select>

                </div>


                <!-- Timezone -->
                <div class="flex flex-col gap-4 px-5 py-5 sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <h3 class="text-sm font-medium text-gray-800 dark:text-white">
                            Timezone
                        </h3>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Set the timezone used for reports and activity logs.
                        </p>
                    </div>

                    <select
                        class="h-10 w-full rounded-lg border border-gray-300 bg-white px-3 text-sm text-gray-800 outline-none focus:border-gray-500 sm:w-64 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                    >
                        <option>Asia/Dhaka (UTC+06:00)</option>
                        <option>UTC</option>
                        <option>Asia/Kolkata (UTC+05:30)</option>
                        <option>Europe/London (UTC+00:00)</option>
                        <option>America/New_York (UTC-05:00)</option>
                    </select>

                </div>


                <!-- Date Format -->
                <div class="flex flex-col gap-4 px-5 py-5 sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <h3 class="text-sm font-medium text-gray-800 dark:text-white">
                            Date Format
                        </h3>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Choose how dates are displayed throughout the application.
                        </p>
                    </div>

                    <select
                        class="h-10 w-full rounded-lg border border-gray-300 bg-white px-3 text-sm text-gray-800 outline-none focus:border-gray-500 sm:w-48 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                    >
                        <option>MMM DD, YYYY</option>
                        <option>DD/MM/YYYY</option>
                        <option>MM/DD/YYYY</option>
                        <option>YYYY-MM-DD</option>
                    </select>

                </div>

            </div>

        </div>


        <!-- URL Settings -->
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="border-b border-gray-200 px-5 py-5 dark:border-gray-800">

                <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
                    URL Settings
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Configure default options for generated short URLs.
                </p>

            </div>


            <div class="divide-y divide-gray-200 dark:divide-gray-800">

                <!-- Default Expiration -->
                <div class="flex flex-col gap-4 px-5 py-5 sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <h3 class="text-sm font-medium text-gray-800 dark:text-white">
                            Default Link Expiration
                        </h3>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Set the default expiration period for newly created links.
                        </p>
                    </div>

                    <select
                        class="h-10 w-full rounded-lg border border-gray-300 bg-white px-3 text-sm text-gray-800 outline-none focus:border-gray-500 sm:w-48 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                    >
                        <option>Never</option>
                        <option>7 Days</option>
                        <option>30 Days</option>
                        <option>90 Days</option>
                        <option>1 Year</option>
                    </select>

                </div>


                <!-- Custom Alias -->
                <div class="flex flex-col gap-4 px-5 py-5 sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <h3 class="text-sm font-medium text-gray-800 dark:text-white">
                            Allow Custom Aliases
                        </h3>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Allow users to create personalized short URL aliases.
                        </p>
                    </div>

                    <label class="relative inline-flex cursor-pointer items-center">

                        <input
                            type="checkbox"
                            class="peer sr-only"
                            checked
                        >

                        <div class="h-6 w-11 rounded-full bg-gray-200 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-gray-800 peer-checked:after:translate-x-full peer-checked:after:border-white dark:bg-gray-700 dark:peer-checked:bg-white"></div>

                    </label>

                </div>


                <!-- Duplicate Detection -->
                <div class="flex flex-col gap-4 px-5 py-5 sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <h3 class="text-sm font-medium text-gray-800 dark:text-white">
                            Duplicate URL Detection
                        </h3>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Detect duplicate destination URLs before creating a new short link.
                        </p>
                    </div>

                    <label class="relative inline-flex cursor-pointer items-center">

                        <input
                            type="checkbox"
                            class="peer sr-only"
                        >

                        <div class="h-6 w-11 rounded-full bg-gray-200 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-gray-800 peer-checked:after:translate-x-full peer-checked:after:border-white dark:bg-gray-700 dark:peer-checked:bg-white"></div>

                    </label>

                </div>

            </div>

        </div>


        <!-- Security Settings -->
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="border-b border-gray-200 px-5 py-5">

                <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
                    Security
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Manage security preferences for your account.
                </p>

            </div>


            <div class="divide-y divide-gray-200 dark:divide-gray-800">

                <!-- Two Factor -->
                <div class="flex flex-col gap-4 px-5 py-5 sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <h3 class="text-sm font-medium text-gray-800 dark:text-white">
                            Two-Factor Authentication
                        </h3>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Add an additional layer of security to your account.
                        </p>
                    </div>

                    <button
                        type="button"
                        class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-white/5"
                    >
                        Configure
                    </button>

                </div>


                <!-- Password -->
                <div class="flex flex-col gap-4 px-5 py-5 sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <h3 class="text-sm font-medium text-gray-800 dark:text-white">
                            Password
                        </h3>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Update your account password regularly to keep your account secure.
                        </p>
                    </div>

                    <button
                        type="button"
                        class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-white/5"
                    >
                        Change Password
                    </button>

                </div>


                <!-- Login Sessions -->
                <div class="flex flex-col gap-4 px-5 py-5 sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <h3 class="text-sm font-medium text-gray-800 dark:text-white">
                            Active Sessions
                        </h3>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Review devices that are currently signed in to your account.
                        </p>
                    </div>

                    <button
                        type="button"
                        class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-white/5"
                    >
                        View Sessions
                    </button>

                </div>

            </div>

        </div>


        <!-- Notification Settings -->
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="border-b border-gray-200 px-5 py-5">

                <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
                    Notifications
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Choose which notifications you want to receive.
                </p>

            </div>


            <div class="divide-y divide-gray-200 dark:divide-gray-800">

                <!-- Link Expiration -->
                <div class="flex items-center justify-between px-5 py-5">

                    <div>
                        <h3 class="text-sm font-medium text-gray-800 dark:text-white">
                            Link Expiration Alerts
                        </h3>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Notify me when a short link is about to expire.
                        </p>
                    </div>

                    <label class="relative inline-flex cursor-pointer items-center">

                        <input
                            type="checkbox"
                            class="peer sr-only"
                            checked
                        >

                        <div class="h-6 w-11 rounded-full bg-gray-200 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-gray-800 peer-checked:after:translate-x-full peer-checked:after:border-white dark:bg-gray-700 dark:peer-checked:bg-white"></div>

                    </label>

                </div>


                <!-- Report Notifications -->
                <div class="flex items-center justify-between px-5 py-5">

                    <div>
                        <h3 class="text-sm font-medium text-gray-800 dark:text-white">
                            Report Notifications
                        </h3>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Notify me when a requested report is ready.
                        </p>
                    </div>

                    <label class="relative inline-flex cursor-pointer items-center">

                        <input
                            type="checkbox"
                            class="peer sr-only"
                        >

                        <div class="h-6 w-11 rounded-full bg-gray-200 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-gray-800 peer-checked:after:translate-x-full peer-checked:after:border-white dark:bg-gray-700 dark:peer-checked:bg-white"></div>

                    </label>

                </div>


                <!-- Security Alerts -->
                <div class="flex items-center justify-between px-5 py-5">

                    <div>
                        <h3 class="text-sm font-medium text-gray-800 dark:text-white">
                            Security Alerts
                        </h3>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Receive notifications about important security events.
                        </p>
                    </div>

                    <label class="relative inline-flex cursor-pointer items-center">

                        <input
                            type="checkbox"
                            class="peer sr-only"
                            checked
                        >

                        <div class="h-6 w-11 rounded-full bg-gray-200 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-gray-800 peer-checked:after:translate-x-full peer-checked:after:border-white dark:bg-gray-700 dark:peer-checked:bg-white"></div>

                    </label>

                </div>

            </div>

        </div>


        <!-- API Settings -->
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="border-b border-gray-200 px-5 py-5">

                <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
                    API Access
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Manage API access for external applications and integrations.
                </p>

            </div>


            <div class="px-5 py-5">

                <div class="rounded-lg border border-gray-200 bg-gray-50 p-4 dark:border-gray-800 dark:bg-white/[0.02]">

                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                        <div>
                            <h3 class="text-sm font-medium text-gray-800 dark:text-white">
                                API Keys
                            </h3>

                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Create and manage API keys for your applications.
                            </p>
                        </div>

                        <button
                            type="button"
                            class="rounded-lg bg-gray-800 px-4 py-2.5 text-sm font-medium text-white hover:bg-gray-700 dark:bg-white dark:text-gray-800 dark:hover:bg-gray-100"
                        >
                            Manage API Keys
                        </button>

                    </div>

                </div>

            </div>

        </div>


        <!-- Save Changes -->
        <div class="flex flex-col gap-3 border-t border-gray-200 pt-6 sm:flex-row sm:items-center sm:justify-end dark:border-gray-800">

            <button
                type="button"
                class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-white/5"
            >
                Cancel
            </button>

            <button
                type="button"
                class="rounded-lg bg-gray-800 px-5 py-2.5 text-sm font-medium text-white hover:bg-gray-700 dark:bg-white dark:text-gray-800 dark:hover:bg-gray-100"
            >
                Save Changes
            </button>

        </div>

    </div>

</div>

@endsection