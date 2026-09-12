@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-7xl">

    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-white/90">
            Edit Profile
        </h1>

        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Manage your personal information and profile details.
        </p>
    </div>


    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

        <!-- =========================================
             Profile Card
        ========================================== -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="text-center">

                <!-- Profile Photo -->
                <div class="relative mx-auto h-28 w-28">

                    <img
                        src="/images/user/owner.png"
                        alt="Profile Photo"
                        class="h-28 w-28 rounded-full object-cover"
                    />

                    <!-- Camera Button -->
                    <button
                        type="button"
                        class="absolute bottom-0 right-0 flex h-9 w-9 items-center justify-center rounded-full border-4 border-white bg-brand-500 text-white hover:bg-brand-600 dark:border-gray-900"
                        title="Change profile photo"
                    >
                        <svg
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M3 8.5A2.5 2.5 0 015.5 6h2l1-1.5h7L16.5 6h2A2.5 2.5 0 0121 8.5v9A2.5 2.5 0 0118.5 20h-13A2.5 2.5 0 013 17.5v-9z"
                            />
                            <circle
                                cx="12"
                                cy="13"
                                r="3.2"
                                stroke-width="1.8"
                            />
                        </svg>
                    </button>

                </div>


                <!-- User Name -->
                <h2 class="mt-4 text-lg font-semibold text-gray-800 dark:text-white/90">
                    User
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    URL Shortener User
                </p>


                <!-- Change Photo -->
                <button
                    type="button"
                    class="mt-5 inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-white/[0.03] dark:text-gray-300 dark:hover:bg-white/[0.05]"
                >
                    Change Photo
                </button>

                <p class="mt-3 text-xs text-gray-400 dark:text-gray-500">
                    JPG, PNG or WEBP. Maximum size 2MB.
                </p>

            </div>

        </div>


        <!-- =========================================
             Personal Information
        ========================================== -->
        <div class="lg:col-span-2">

            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

                <!-- Card Header -->
                <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">

                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                        Personal Information
                    </h2>

                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Update your name, contact information and other personal details.
                    </p>

                </div>


                <!-- Form -->
                <div class="p-6">

                    <form>

                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                            <!-- First Name -->
                            <div>
                                <label
                                    for="first_name"
                                    class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                                >
                                    First Name
                                </label>

                                <input
                                    id="first_name"
                                    type="text"
                                    value="User"
                                    placeholder="Enter your first name"
                                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-gray-500"
                                />
                            </div>


                            <!-- Last Name -->
                            <div>
                                <label
                                    for="last_name"
                                    class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                                >
                                    Last Name
                                </label>

                                <input
                                    id="last_name"
                                    type="text"
                                    placeholder="Enter your last name"
                                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-gray-500"
                                />
                            </div>


                            <!-- Email -->
                            <div>
                                <label
                                    for="email"
                                    class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                                >
                                    Email Address
                                </label>

                                <input
                                    id="email"
                                    type="email"
                                    value="user@example.com"
                                    placeholder="Enter your email"
                                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-gray-500"
                                />
                            </div>


                            <!-- Phone -->
                            <div>
                                <label
                                    for="phone"
                                    class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                                >
                                    Phone Number
                                </label>

                                <input
                                    id="phone"
                                    type="tel"
                                    placeholder="Enter your phone number"
                                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-gray-500"
                                />
                            </div>


                            <!-- Country -->
                            <div>
                                <label
                                    for="country"
                                    class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                                >
                                    Country
                                </label>

                                <select
                                    id="country"
                                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                                >
                                    <option value="">Select country</option>
                                    <option value="bangladesh">Bangladesh</option>
                                    <option value="india">India</option>
                                    <option value="pakistan">Pakistan</option>
                                    <option value="united-kingdom">United Kingdom</option>
                                    <option value="united-states">United States</option>
                                    <option value="canada">Canada</option>
                                    <option value="australia">Australia</option>
                                </select>
                            </div>


                            <!-- Timezone -->
                            <div>
                                <label
                                    for="timezone"
                                    class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                                >
                                    Timezone
                                </label>

                                <select
                                    id="timezone"
                                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                                >
                                    <option value="asia-dhaka">
                                        Asia/Dhaka (GMT+6)
                                    </option>

                                    <option value="asia-kolkata">
                                        Asia/Kolkata (GMT+5:30)
                                    </option>

                                    <option value="europe-london">
                                        Europe/London
                                    </option>

                                    <option value="america-new-york">
                                        America/New_York
                                    </option>

                                    <option value="australia-sydney">
                                        Australia/Sydney
                                    </option>
                                </select>
                            </div>


                            <!-- Bio -->
                            <div class="md:col-span-2">

                                <label
                                    for="bio"
                                    class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                                >
                                    Bio
                                </label>

                                <textarea
                                    id="bio"
                                    rows="4"
                                    placeholder="Write a short description about yourself..."
                                    class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm text-gray-800 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-gray-500"
                                ></textarea>

                            </div>

                        </div>


                        <!-- Form Actions -->
                        <div class="mt-6 flex flex-wrap items-center justify-end gap-3 border-t border-gray-200 pt-5 dark:border-gray-800">

                            <a
                                href="/dashboard"
                                class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-white/[0.03] dark:text-gray-300 dark:hover:bg-white/[0.05]"
                            >
                                Cancel
                            </a>

                            <button
                                type="button"
                                class="inline-flex items-center justify-center rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white hover:bg-brand-600"
                            >
                                Save Changes
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>


    <!-- =========================================
         Account Information
    ========================================== -->
    <div class="mt-6 rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

        <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">

            <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                Account Information
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Basic information about your URL Shortener account.
            </p>

        </div>


        <div class="grid grid-cols-1 gap-5 p-6 md:grid-cols-3">

            <!-- Account Status -->
            <div class="rounded-xl border border-gray-200 p-4 dark:border-gray-800">

                <p class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">
                    Account Status
                </p>

                <div class="mt-2 flex items-center gap-2">

                    <span class="h-2 w-2 rounded-full bg-success-500"></span>

                    <span class="text-sm font-medium text-gray-800 dark:text-white/90">
                        Active
                    </span>

                </div>

            </div>


            <!-- Member Since -->
            <div class="rounded-xl border border-gray-200 p-4 dark:border-gray-800">

                <p class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">
                    Member Since
                </p>

                <p class="mt-2 text-sm font-medium text-gray-800 dark:text-white/90">
                    September 2026
                </p>

            </div>


            <!-- Account Type -->
            <div class="rounded-xl border border-gray-200 p-4 dark:border-gray-800">

                <p class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">
                    Account Type
                </p>

                <p class="mt-2 text-sm font-medium text-gray-800 dark:text-white/90">
                    Standard User
                </p>

            </div>

        </div>

    </div>

</div>

@endsection