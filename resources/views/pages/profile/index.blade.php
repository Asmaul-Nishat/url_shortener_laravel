@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-7xl">

    {{-- ========================================================= --}}
    {{-- SUCCESS MESSAGE --}}
    {{-- ========================================================= --}}

    @if (session('success'))
        <div class="mb-6 rounded-lg border border-gray-200 bg-white px-4 py-3 text-sm text-gray-700 dark:border-gray-800 dark:bg-white/[0.03] dark:text-gray-300">
            {{ session('success') }}
        </div>
    @endif


    {{-- ========================================================= --}}
    {{-- VALIDATION ERRORS --}}
    {{-- ========================================================= --}}

    @if ($errors->any())
        <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 dark:border-red-900/50 dark:bg-red-500/10 dark:text-red-400">

            <ul class="list-disc space-y-1 pl-5">

                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>
    @endif


    {{-- ========================================================= --}}
    {{-- PAGE HEADER --}}
    {{-- ========================================================= --}}

    <div class="mb-6">

        <h1 class="text-2xl font-semibold text-gray-800 dark:text-white/90">
            Edit Profile
        </h1>

        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Manage your personal information and profile details.
        </p>

    </div>


    {{-- ========================================================= --}}
    {{-- MAIN GRID --}}
    {{-- ========================================================= --}}

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">


        {{-- ===================================================== --}}
        {{-- PROFILE CARD --}}
        {{-- ===================================================== --}}

        <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="text-center">


                {{-- ================================================= --}}
                {{-- PROFILE PHOTO --}}
                {{-- ================================================= --}}

                <div class="relative mx-auto h-28 w-28">

                    @if ($user->profile_photo_path)

                        <img
                            src="{{ asset('storage/' . $user->profile_photo_path) }}"
                            alt="Profile Photo"
                            class="h-28 w-28 rounded-full object-cover"
                        />

                    @else

                        <img
                            src="{{ asset('images/user/owner.png') }}"
                            alt="Profile Photo"
                            class="h-28 w-28 rounded-full object-cover"
                        />

                    @endif


                    {{-- Camera Button --}}
                    <button
                        type="button"
                        onclick="document.getElementById('profile_photo').click()"
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


                {{-- ================================================= --}}
                {{-- USER NAME --}}
                {{-- ================================================= --}}

                <h2 class="mt-4 text-lg font-semibold text-gray-800 dark:text-white/90">
                    {{ $user->name }}
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    URL Shortener User
                </p>


                {{-- ================================================= --}}
                {{-- CHANGE PHOTO --}}
                {{-- ================================================= --}}

                <button
                    type="button"
                    onclick="document.getElementById('profile_photo').click()"
                    class="mt-5 inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-white/[0.03] dark:text-gray-300 dark:hover:bg-white/[0.05]"
                >
                    Change Photo
                </button>


                <p class="mt-3 text-xs text-gray-400 dark:text-gray-500">
                    JPG, PNG or WEBP. Maximum size 2MB.
                </p>


                {{-- Selected File Name --}}
                <p
                    id="selected-photo-name"
                    class="mt-2 hidden break-all text-xs text-gray-500 dark:text-gray-400"
                ></p>

            </div>

        </div>


        {{-- ===================================================== --}}
        {{-- PERSONAL INFORMATION --}}
        {{-- ===================================================== --}}

        <div class="lg:col-span-2">

            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">


                {{-- ================================================= --}}
                {{-- CARD HEADER --}}
                {{-- ================================================= --}}

                <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">

                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                        Personal Information
                    </h2>

                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Update your name, contact information and other personal details.
                    </p>

                </div>


                {{-- ================================================= --}}
                {{-- FORM --}}
                {{-- ================================================= --}}

                <div class="p-6">

                    <form
                        method="POST"
                        action="{{ route('profile.update') }}"
                        enctype="multipart/form-data"
                    >

                        @csrf
                        @method('PATCH')


                        {{-- Hidden Photo Input --}}
                        <input
                            id="profile_photo"
                            name="profile_photo"
                            type="file"
                            accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                            class="hidden"
                            onchange="showSelectedPhoto(this)"
                        />


                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">


                            {{-- ================================================= --}}
                            {{-- FIRST NAME --}}
                            {{-- ================================================= --}}

                            <div>

                                <label
                                    for="first_name"
                                    class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                                >
                                    First Name
                                </label>

                                <input
                                    id="first_name"
                                    name="first_name"
                                    type="text"
                                    value="{{ old('first_name', $user->first_name) }}"
                                    placeholder="Enter your first name"
                                    required
                                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-gray-500"
                                />

                            </div>


                            {{-- ================================================= --}}
                            {{-- LAST NAME --}}
                            {{-- ================================================= --}}

                            <div>

                                <label
                                    for="last_name"
                                    class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                                >
                                    Last Name
                                </label>

                                <input
                                    id="last_name"
                                    name="last_name"
                                    type="text"
                                    value="{{ old('last_name', $user->last_name) }}"
                                    placeholder="Enter your last name"
                                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-gray-500"
                                />

                            </div>


                            {{-- ================================================= --}}
                            {{-- EMAIL --}}
                            {{-- ================================================= --}}

                            <div>

                                <label
                                    for="email"
                                    class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                                >
                                    Email Address
                                </label>

                                <input
                                    id="email"
                                    name="email"
                                    type="email"
                                    value="{{ old('email', $user->email) }}"
                                    placeholder="Enter your email"
                                    required
                                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-gray-500"
                                />

                            </div>


                            {{-- ================================================= --}}
                            {{-- PHONE --}}
                            {{-- ================================================= --}}

                            <div>

                                <label
                                    for="phone"
                                    class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                                >
                                    Phone Number
                                </label>

                                <input
                                    id="phone"
                                    name="phone"
                                    type="tel"
                                    value="{{ old('phone', $user->phone) }}"
                                    placeholder="Enter your phone number"
                                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-gray-500"
                                />

                            </div>


                            {{-- ================================================= --}}
                            {{-- COUNTRY --}}
                            {{-- ================================================= --}}

                            <div>

                                <label
                                    for="country"
                                    class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                                >
                                    Country
                                </label>

                                <select
                                    id="country"
                                    name="country"
                                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                                >

                                    <option value="">
                                        Select country
                                    </option>

                                    <option
                                        value="Bangladesh"
                                        @selected(old('country', $user->country) === 'Bangladesh')
                                    >
                                        Bangladesh
                                    </option>

                                    <option
                                        value="India"
                                        @selected(old('country', $user->country) === 'India')
                                    >
                                        India
                                    </option>

                                    <option
                                        value="Pakistan"
                                        @selected(old('country', $user->country) === 'Pakistan')
                                    >
                                        Pakistan
                                    </option>

                                    <option
                                        value="United Kingdom"
                                        @selected(old('country', $user->country) === 'United Kingdom')
                                    >
                                        United Kingdom
                                    </option>

                                    <option
                                        value="United States"
                                        @selected(old('country', $user->country) === 'United States')
                                    >
                                        United States
                                    </option>

                                    <option
                                        value="Canada"
                                        @selected(old('country', $user->country) === 'Canada')
                                    >
                                        Canada
                                    </option>

                                    <option
                                        value="Australia"
                                        @selected(old('country', $user->country) === 'Australia')
                                    >
                                        Australia
                                    </option>

                                </select>

                            </div>


                            {{-- ================================================= --}}
                            {{-- TIMEZONE --}}
                            {{-- ================================================= --}}

                            <div>

                                <label
                                    for="timezone"
                                    class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                                >
                                    Timezone
                                </label>

                                <select
                                    id="timezone"
                                    name="timezone"
                                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                                >

                                    <option
                                        value="Asia/Dhaka"
                                        @selected(old('timezone', $user->timezone) === 'Asia/Dhaka')
                                    >
                                        Asia/Dhaka (GMT+6)
                                    </option>

                                    <option
                                        value="Asia/Kolkata"
                                        @selected(old('timezone', $user->timezone) === 'Asia/Kolkata')
                                    >
                                        Asia/Kolkata (GMT+5:30)
                                    </option>

                                    <option
                                        value="Europe/London"
                                        @selected(old('timezone', $user->timezone) === 'Europe/London')
                                    >
                                        Europe/London
                                    </option>

                                    <option
                                        value="America/New_York"
                                        @selected(old('timezone', $user->timezone) === 'America/New_York')
                                    >
                                        America/New_York
                                    </option>

                                    <option
                                        value="Australia/Sydney"
                                        @selected(old('timezone', $user->timezone) === 'Australia/Sydney')
                                    >
                                        Australia/Sydney
                                    </option>

                                </select>

                            </div>


                            {{-- ================================================= --}}
                            {{-- BIO --}}
                            {{-- ================================================= --}}

                            <div class="md:col-span-2">

                                <label
                                    for="bio"
                                    class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                                >
                                    Bio
                                </label>

                                <textarea
                                    id="bio"
                                    name="bio"
                                    rows="4"
                                    maxlength="1000"
                                    placeholder="Write a short description about yourself..."
                                    class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm text-gray-800 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-gray-500"
                                >{{ old('bio', $user->bio) }}</textarea>

                                <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">
                                    Maximum 1000 characters.
                                </p>

                            </div>

                        </div>


                        {{-- ================================================= --}}
                        {{-- FORM ACTIONS --}}
                        {{-- ================================================= --}}

                        <div class="mt-6 flex flex-wrap items-center justify-end gap-3 border-t border-gray-200 pt-5 dark:border-gray-800">

                            <a
                                href="{{ route('dashboard') }}"
                                class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-white/[0.03] dark:text-gray-300 dark:hover:bg-white/[0.05]"
                            >
                                Cancel
                            </a>

                            <button
                                type="submit"
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


    {{-- ========================================================= --}}
    {{-- ACCOUNT INFORMATION --}}
    {{-- ========================================================= --}}

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


            {{-- ================================================= --}}
            {{-- ACCOUNT STATUS --}}
            {{-- ================================================= --}}

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


            {{-- ================================================= --}}
            {{-- MEMBER SINCE --}}
            {{-- ================================================= --}}

            <div class="rounded-xl border border-gray-200 p-4 dark:border-gray-800">

                <p class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">
                    Member Since
                </p>

                <p class="mt-2 text-sm font-medium text-gray-800 dark:text-white/90">
                    {{ $user->created_at?->format('F Y') ?? 'N/A' }}
                </p>

            </div>


            {{-- ================================================= --}}
            {{-- ACCOUNT TYPE --}}
            {{-- ================================================= --}}

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


{{-- ========================================================= --}}
{{-- PROFILE PHOTO JAVASCRIPT --}}
{{-- ========================================================= --}}

<script>
    function showSelectedPhoto(input) {

        const fileNameElement =
            document.getElementById('selected-photo-name');

        if (input.files && input.files.length > 0) {

            fileNameElement.textContent =
                'Selected: ' + input.files[0].name;

            fileNameElement.classList.remove('hidden');

        } else {

            fileNameElement.textContent = '';

            fileNameElement.classList.add('hidden');
        }
    }
</script>

@endsection