@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-7xl">

{{-- Page Header --}}
<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

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
                href="{{ route('admin.users.index') }}"
                class="hover:text-brand-500"
            >
                Users
            </a>

            <span>/</span>

            <span class="text-gray-700 dark:text-gray-300">
                Edit User
            </span>
        </div>

        <h1 class="text-2xl font-bold text-gray-800 dark:text-white/90">
            Edit User
        </h1>

        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Update this user's account information and permissions.
        </p>
    </div>

    <a
        href="{{ route('admin.users.show', $user) }}"
        class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/[0.03]"
    >
        Back to User
    </a>

</div>


{{-- Validation Errors --}}
@if($errors->any())
    <div class="mb-6 rounded-lg border border-error-200 bg-error-50 p-4 dark:border-error-500/30 dark:bg-error-500/10">
        <h3 class="text-sm font-semibold text-error-700 dark:text-error-400">
            Please correct the following errors:
        </h3>

        <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-error-600 dark:text-error-400">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


{{-- Edit Form --}}
<form
    method="POST"
    action="{{ route('admin.users.update', $user) }}"
>
    @csrf
    @method('PATCH')

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

        {{-- Main Information --}}
        <div class="lg:col-span-2 rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                    Personal Information
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Update the user's basic information.
                </p>
            </div>


            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                {{-- First Name --}}
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
                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 outline-none focus:border-brand-500 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                    >
                </div>


                {{-- Last Name --}}
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
                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 outline-none focus:border-brand-500 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                    >
                </div>


                {{-- Name --}}
                <div class="sm:col-span-2">
                    <label
                        for="name"
                        class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                    >
                        Display Name
                        <span class="text-error-500">*</span>
                    </label>

                    <input
                        id="name"
                        name="name"
                        type="text"
                        required
                        value="{{ old('name', $user->name) }}"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 outline-none focus:border-brand-500 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                    >
                </div>


                {{-- Email --}}
                <div class="sm:col-span-2">
                    <label
                        for="email"
                        class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                    >
                        Email
                        <span class="text-error-500">*</span>
                    </label>

                    <input
                        id="email"
                        name="email"
                        type="email"
                        required
                        value="{{ old('email', $user->email) }}"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 outline-none focus:border-brand-500 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                    >
                </div>


                {{-- Phone --}}
                <div>
                    <label
                        for="phone"
                        class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                    >
                        Phone
                    </label>

                    <input
                        id="phone"
                        name="phone"
                        type="text"
                        value="{{ old('phone', $user->phone) }}"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 outline-none focus:border-brand-500 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                    >
                </div>


                {{-- Country --}}
                <div>
                    <label
                        for="country"
                        class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                    >
                        Country
                    </label>

                    <input
                        id="country"
                        name="country"
                        type="text"
                        value="{{ old('country', $user->country) }}"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 outline-none focus:border-brand-500 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                    >
                </div>


                {{-- Timezone --}}
                <div>
                    <label
                        for="timezone"
                        class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                    >
                        Timezone
                    </label>

                    <input
                        id="timezone"
                        name="timezone"
                        type="text"
                        value="{{ old('timezone', $user->timezone) }}"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 outline-none focus:border-brand-500 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                    >
                </div>


                {{-- Bio --}}
                <div class="sm:col-span-2">
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
                        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm text-gray-800 outline-none focus:border-brand-500 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                    >{{ old('bio', $user->bio) }}</textarea>
                </div>

            </div>

        </div>


        {{-- Account Settings --}}
        <div class="space-y-6">

            {{-- Role & Status --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">

                <div class="mb-5">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                        Account Settings
                    </h2>

                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Manage role and account status.
                    </p>
                </div>


                {{-- Role --}}
                <div class="mb-5">
                    <label
                        for="role"
                        class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                    >
                        Role
                    </label>

                    <select
                        id="role"
                        name="role"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-white px-4 text-sm text-gray-800 outline-none focus:border-brand-500 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                        @if(auth()->id() === $user->id) disabled @endif
                    >
                        <option
                            value="user"
                            @selected(old('role', $user->role) === 'user')
                        >
                            User
                        </option>

                        <option
                            value="admin"
                            @selected(old('role', $user->role) === 'admin')
                        >
                            Administrator
                        </option>
                    </select>

                    @if(auth()->id() === $user->id)
                        <input
                            type="hidden"
                            name="role"
                            value="admin"
                        >

                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                            Your administrator role cannot be changed here.
                        </p>
                    @endif
                </div>


                {{-- Status --}}
                <div>
                    <label
                        for="status"
                        class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                    >
                        Status
                    </label>

                    <select
                        id="status"
                        name="status"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-white px-4 text-sm text-gray-800 outline-none focus:border-brand-500 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                        @if(auth()->id() === $user->id) disabled @endif
                    >
                        <option
                            value="active"
                            @selected(old('status', $user->status) === 'active')
                        >
                            Active
                        </option>

                        <option
                            value="inactive"
                            @selected(old('status', $user->status) === 'inactive')
                        >
                            Inactive
                        </option>
                    </select>

                    @if(auth()->id() === $user->id)
                        <input
                            type="hidden"
                            name="status"
                            value="active"
                        >

                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                            Your administrator account cannot be deactivated here.
                        </p>
                    @endif
                </div>

            </div>


            {{-- Password --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">

                <div class="mb-5">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                        Change Password
                    </h2>

                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Leave these fields empty to keep the current password.
                    </p>
                </div>


                {{-- Password --}}
                <div class="mb-5">
                    <label
                        for="password"
                        class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                    >
                        New Password
                    </label>

                    <input
                        id="password"
                        name="password"
                        type="password"
                        autocomplete="new-password"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 outline-none focus:border-brand-500 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                    >
                </div>


                {{-- Confirm Password --}}
                <div>
                    <label
                        for="password_confirmation"
                        class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                    >
                        Confirm New Password
                    </label>

                    <input
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        autocomplete="new-password"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 outline-none focus:border-brand-500 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                    >
                </div>

            </div>

        </div>

    </div>


    {{-- Form Actions --}}
    <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

        <a
            href="{{ route('admin.users.show', $user) }}"
            class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/[0.03]"
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
