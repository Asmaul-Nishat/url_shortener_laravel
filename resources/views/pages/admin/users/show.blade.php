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
                View User
            </span>
        </div>

        <h1 class="text-2xl font-bold text-gray-800 dark:text-white/90">
            User Details
        </h1>

        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            View and manage this user's account information.
        </p>
    </div>

    <div class="flex flex-wrap items-center gap-3">

        <a
            href="{{ route('admin.users.index') }}"
            class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/[0.03]"
        >
            Back to Users
        </a>

        <a
            href="{{ route('admin.users.edit', $user) }}"
            class="inline-flex items-center justify-center rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600"
        >
            Edit User
        </a>

    </div>
</div>


{{-- Flash Messages --}}
@if(session('success'))
    <div class="mb-6 rounded-lg border border-success-200 bg-success-50 px-4 py-3 text-sm text-success-700 dark:border-success-500/30 dark:bg-success-500/10 dark:text-success-400">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="mb-6 rounded-lg border border-error-200 bg-error-50 px-4 py-3 text-sm text-error-700 dark:border-error-500/30 dark:bg-error-500/10 dark:text-error-400">
        {{ session('error') }}
    </div>
@endif


{{-- User Overview --}}
<div class="mb-6 grid grid-cols-1 gap-6 lg:grid-cols-3">

    {{-- Profile Card --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">

        <div class="flex flex-col items-center text-center">

            {{-- Avatar --}}
            <div class="mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-brand-100 text-2xl font-semibold text-brand-600 dark:bg-brand-500/10 dark:text-brand-400">
                {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
            </div>

            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
                {{ $user->name }}
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                {{ $user->email }}
            </p>

            {{-- Role --}}
            <div class="mt-4">
                @if($user->role === 'admin')
                    <span class="inline-flex rounded-full bg-brand-50 px-3 py-1 text-xs font-medium text-brand-600 dark:bg-brand-500/10 dark:text-brand-400">
                        Administrator
                    </span>
                @else
                    <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600 dark:bg-gray-800 dark:text-gray-300">
                        User
                    </span>
                @endif
            </div>

            {{-- Status --}}
            <div class="mt-2">
                @if($user->status === 'active')
                    <span class="inline-flex rounded-full bg-success-50 px-3 py-1 text-xs font-medium text-success-700 dark:bg-success-500/10 dark:text-success-400">
                        Active
                    </span>
                @else
                    <span class="inline-flex rounded-full bg-error-50 px-3 py-1 text-xs font-medium text-error-700 dark:bg-error-500/10 dark:text-error-400">
                        Inactive
                    </span>
                @endif
            </div>

        </div>

    </div>


    {{-- Account Information --}}
    <div class="lg:col-span-2 rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">

        <div class="mb-5">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                Account Information
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Basic information about this account.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    First Name
                </p>

                <p class="mt-1 font-medium text-gray-800 dark:text-white/90">
                    {{ $user->first_name ?: '—' }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Last Name
                </p>

                <p class="mt-1 font-medium text-gray-800 dark:text-white/90">
                    {{ $user->last_name ?: '—' }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Email
                </p>

                <p class="mt-1 font-medium text-gray-800 dark:text-white/90 break-all">
                    {{ $user->email }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Phone
                </p>

                <p class="mt-1 font-medium text-gray-800 dark:text-white/90">
                    {{ $user->phone ?: '—' }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Country
                </p>

                <p class="mt-1 font-medium text-gray-800 dark:text-white/90">
                    {{ $user->country ?: '—' }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Timezone
                </p>

                <p class="mt-1 font-medium text-gray-800 dark:text-white/90">
                    {{ $user->timezone ?: '—' }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Role
                </p>

                <p class="mt-1 font-medium capitalize text-gray-800 dark:text-white/90">
                    {{ $user->role }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Joined
                </p>

                <p class="mt-1 font-medium text-gray-800 dark:text-white/90">
                    {{ $user->created_at?->format('M d, Y') ?? '—' }}
                </p>
            </div>

        </div>

        {{-- Bio --}}
        <div class="mt-6 border-t border-gray-200 pt-6 dark:border-gray-800">

            <p class="text-sm text-gray-500 dark:text-gray-400">
                Bio
            </p>

            <p class="mt-2 text-sm leading-6 text-gray-700 dark:text-gray-300">
                {{ $user->bio ?: 'No bio has been added.' }}
            </p>

        </div>

    </div>

</div>


{{-- Statistics --}}
<div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2">

    {{-- Total Links --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
            Total Links
        </p>

        <p class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">
            {{ $user->short_urls_count }}
        </p>
    </div>

    {{-- Total Clicks --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
            Total Clicks
        </p>

        <p class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">
            {{ number_format($totalClicks) }}
        </p>
    </div>

</div>


{{-- Recent Links --}}
<div class="mb-6 rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

    <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">

        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                    Recent Links
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Recently created links by this user.
                </p>
            </div>

            <span class="text-sm text-gray-500 dark:text-gray-400">
                {{ $user->short_urls_count }} total
            </span>

        </div>

    </div>


    @if($recentLinks->count())

        <div class="overflow-x-auto">

            <table class="min-w-full">

                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-800">

                        <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Original URL
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Short Code
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Clicks
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Created
                        </th>

                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 dark:divide-gray-800">

                    @foreach($recentLinks as $link)

                        <tr>

                            <td class="px-6 py-4">

                                <p class="max-w-md truncate text-sm font-medium text-gray-800 dark:text-white/90">
                                    {{ $link->original_url }}
                                </p>

                            </td>

                            <td class="whitespace-nowrap px-6 py-4">

                                <span class="rounded-md bg-gray-100 px-2.5 py-1 text-sm font-medium text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                                    {{ $link->custom_alias ?: $link->short_code }}
                                </span>

                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                {{ number_format($link->click_count) }}
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                {{ $link->created_at?->format('M d, Y') ?? '—' }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    @else

        <div class="px-6 py-12 text-center">

            <h3 class="text-sm font-medium text-gray-800 dark:text-white/90">
                No links found
            </h3>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                This user has not created any short links yet.
            </p>

        </div>

    @endif

</div>


{{-- Account Actions --}}
@if(auth()->id() !== $user->id)

    <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">

        <div class="mb-5">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                Account Actions
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Manage this user's account.
            </p>
        </div>

        <div class="flex flex-wrap gap-3">

            {{-- Activate / Deactivate --}}
            <form
                method="POST"
                action="{{ route('admin.users.toggle-status', $user) }}"
            >
                @csrf
                @method('PATCH')

                @if($user->status === 'active')
                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-lg border border-warning-300 bg-warning-50 px-4 py-2.5 text-sm font-medium text-warning-700 hover:bg-warning-100 dark:border-warning-500/30 dark:bg-warning-500/10 dark:text-warning-400"
                    >
                        Deactivate User
                    </button>
                @else
                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-lg border border-success-300 bg-success-50 px-4 py-2.5 text-sm font-medium text-success-700 hover:bg-success-100 dark:border-success-500/30 dark:bg-success-500/10 dark:text-success-400"
                    >
                        Activate User
                    </button>
                @endif

            </form>


            {{-- Delete --}}
            <form
                method="POST"
                action="{{ route('admin.users.destroy', $user) }}"
                onsubmit="return confirm('Are you sure you want to delete this user?');"
            >
                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-lg border border-error-300 bg-error-50 px-4 py-2.5 text-sm font-medium text-error-700 hover:bg-error-100 dark:border-error-500/30 dark:bg-error-500/10 dark:text-error-400"
                >
                    Delete User
                </button>

            </form>

        </div>

    </div>

@else

    <div class="rounded-2xl border border-brand-200 bg-brand-50 p-5 dark:border-brand-500/30 dark:bg-brand-500/10">

        <p class="text-sm font-medium text-brand-700 dark:text-brand-400">
            This is your administrator account. Self-deactivation and self-deletion are disabled for security.
        </p>

    </div>

@endif

</div>
@endsection
