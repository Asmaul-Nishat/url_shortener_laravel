@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-7xl">

{{-- Page Header --}}
<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

    <div>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white/90">
            Users
        </h1>

        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Manage all registered users and administrator accounts.
        </p>
    </div>

    <div>
        <span class="inline-flex items-center rounded-full bg-brand-50 px-3 py-1 text-xs font-medium text-brand-600 dark:bg-brand-500/10 dark:text-brand-400">
            Administrator
        </span>
    </div>

</div>


{{-- Flash Messages --}}
@if(session('success'))
    <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 dark:border-green-900/50 dark:bg-green-900/20 dark:text-green-400">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 dark:border-red-900/50 dark:bg-red-900/20 dark:text-red-400">
        {{ session('error') }}
    </div>
@endif

@if($errors->has('user'))
    <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 dark:border-red-900/50 dark:bg-red-900/20 dark:text-red-400">
        {{ $errors->first('user') }}
    </div>
@endif


{{-- Filters --}}
<div class="mb-6 rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">

    <form
        method="GET"
        action="{{ route('admin.users.index') }}"
        class="grid grid-cols-1 gap-4 md:grid-cols-4"
    >

        {{-- Search --}}
        <div class="md:col-span-2">

            <label
                for="search"
                class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
            >
                Search
            </label>

            <input
                type="text"
                id="search"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search by name or email..."
                class="h-11 w-full rounded-lg border border-gray-300 bg-white px-4 text-sm text-gray-800 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
            >

        </div>


        {{-- Role --}}
        <div>

            <label
                for="role"
                class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
            >
                Role
            </label>

            <select
                id="role"
                name="role"
                class="h-11 w-full rounded-lg border border-gray-300 bg-white px-4 text-sm text-gray-800 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
            >
                <option value="">All Roles</option>

                <option
                    value="user"
                    @selected(request('role') === 'user')
                >
                    User
                </option>

                <option
                    value="admin"
                    @selected(request('role') === 'admin')
                >
                    Admin
                </option>
            </select>

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
                class="h-11 w-full rounded-lg border border-gray-300 bg-white px-4 text-sm text-gray-800 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
            >
                <option value="">All Statuses</option>

                <option
                    value="active"
                    @selected(request('status') === 'active')
                >
                    Active
                </option>

                <option
                    value="inactive"
                    @selected(request('status') === 'inactive')
                >
                    Inactive
                </option>
            </select>

        </div>


        {{-- Buttons --}}
        <div class="flex items-end gap-3 md:col-span-4">

            <button
                type="submit"
                class="inline-flex h-11 items-center justify-center rounded-lg bg-brand-500 px-5 text-sm font-medium text-white transition hover:bg-brand-600"
            >
                Filter Users
            </button>

            <a
                href="{{ route('admin.users.index') }}"
                class="inline-flex h-11 items-center justify-center rounded-lg border border-gray-300 px-5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800"
            >
                Reset
            </a>

        </div>

    </form>

</div>


{{-- Users Table --}}
<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

    {{-- Table Header --}}
    <div class="border-b border-gray-200 px-5 py-4 dark:border-gray-800">

        <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
            All Users
        </h2>

        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            {{ $users->total() }} total users
        </p>

    </div>


    {{-- Table --}}
    <div class="overflow-x-auto">

        <table class="w-full min-w-[1050px]">

            <thead>

                <tr class="border-b border-gray-200 dark:border-gray-800">

                    <th class="px-5 py-4 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                        User
                    </th>

                    <th class="px-5 py-4 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                        Email
                    </th>

                    <th class="px-5 py-4 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                        Role
                    </th>

                    <th class="px-5 py-4 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                        Status
                    </th>

                    <th class="px-5 py-4 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                        Joined
                    </th>

                    <th class="px-5 py-4 text-right text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                        Actions
                    </th>

                </tr>

            </thead>


            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">

                @forelse($users as $user)

                    <tr class="transition hover:bg-gray-50 dark:hover:bg-white/[0.02]">

                        {{-- User --}}
                        <td class="px-5 py-4">

                            <div>

                                <p class="font-medium text-gray-800 dark:text-white/90">
                                    {{ $user->name }}
                                </p>

                                @if($user->phone)

                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        {{ $user->phone }}
                                    </p>

                                @endif

                            </div>

                        </td>


                        {{-- Email --}}
                        <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-300">
                            {{ $user->email }}
                        </td>


                        {{-- Role --}}
                        <td class="px-5 py-4">

                            @if($user->role === 'admin')

                                <span class="inline-flex rounded-full bg-purple-50 px-3 py-1 text-xs font-medium text-purple-600 dark:bg-purple-500/10 dark:text-purple-400">
                                    Admin
                                </span>

                            @else

                                <span class="inline-flex rounded-full bg-blue-50 px-3 py-1 text-xs font-medium text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                                    User
                                </span>

                            @endif

                        </td>


                        {{-- Status --}}
                        <td class="px-5 py-4">

                            @if($user->status === 'active')

                                <span class="inline-flex rounded-full bg-green-50 px-3 py-1 text-xs font-medium text-green-600 dark:bg-green-500/10 dark:text-green-400">
                                    Active
                                </span>

                            @else

                                <span class="inline-flex rounded-full bg-red-50 px-3 py-1 text-xs font-medium text-red-600 dark:bg-red-500/10 dark:text-red-400">
                                    Inactive
                                </span>

                            @endif

                        </td>


                        {{-- Joined --}}
                        <td class="px-5 py-4 text-sm text-gray-500 dark:text-gray-400">
                            {{ $user->created_at?->format('M d, Y') }}
                        </td>


                        {{-- Actions --}}
                        <td class="px-5 py-4">

                            <div class="flex items-center justify-end gap-2">

                                {{-- View --}}
                                <a
                                    href="{{ route('admin.users.show', $user) }}"
                                    class="inline-flex h-9 items-center justify-center rounded-lg border border-gray-300 px-3 text-xs font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800"
                                >
                                    View
                                </a>


                                {{-- Edit --}}
                                <a
                                    href="{{ route('admin.users.edit', $user) }}"
                                    class="inline-flex h-9 items-center justify-center rounded-lg border border-blue-300 px-3 text-xs font-medium text-blue-600 transition hover:bg-blue-50 dark:border-blue-800 dark:text-blue-400 dark:hover:bg-blue-900/20"
                                >
                                    Edit
                                </a>


                                {{-- Delete --}}
                                @if(auth()->id() !== $user->id)

                                    <form
                                        method="POST"
                                        action="{{ route('admin.users.destroy', $user) }}"
                                        onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.')"
                                    >

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="inline-flex h-9 items-center justify-center rounded-lg border border-red-300 px-3 text-xs font-medium text-red-600 transition hover:bg-red-50 dark:border-red-800 dark:text-red-400 dark:hover:bg-red-900/20"
                                        >
                                            Delete
                                        </button>

                                    </form>

                                @endif

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="6"
                            class="px-5 py-12 text-center"
                        >

                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                No users found
                            </p>

                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Try changing your search or filters.
                            </p>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    {{-- Pagination --}}
    @if($users->hasPages())

        <div class="border-t border-gray-200 px-5 py-4 dark:border-gray-800">

            {{ $users->links() }}

        </div>

    @endif

</div>

</div>

@endsection
