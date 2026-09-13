@extends('layouts.app')

@section('content')

<div class="flex min-h-screen items-center justify-center bg-gray-50 px-4 py-10 dark:bg-gray-900">

<div class="w-full max-w-md">

    {{-- Card --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-6 text-center shadow-sm dark:border-gray-800 dark:bg-white/[0.03] sm:p-8">

        {{-- Icon --}}
        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-red-50 dark:bg-red-500/10">

            <svg
                class="h-7 w-7 text-red-500"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 6v6l4 2m6-2a10 10 0 1 1-20 0 10 10 0 0 1 20 0Z"
                />
            </svg>

        </div>


        {{-- Heading --}}
        <h1 class="mt-5 text-xl font-semibold text-gray-800 dark:text-white/90">
            Link Expired
        </h1>


        <p class="mt-2 text-sm leading-6 text-gray-500 dark:text-gray-400">
            This short link is no longer available because its expiration time has passed.
        </p>


        {{-- Expiration Time --}}
        @if(!empty($guestUrl['expires_at']))

            <div class="mt-6 rounded-xl border border-gray-200 bg-gray-50 px-5 py-4 dark:border-gray-700 dark:bg-gray-800/50">

                <p class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">
                    Expired On
                </p>

                <p class="mt-2 text-base font-semibold text-gray-800 dark:text-white/90">
                    {{ \Carbon\Carbon::parse($guestUrl['expires_at'])->format('F j, Y, g:i A') }}
                </p>

            </div>

        @endif


        {{-- Message --}}
        <p class="mt-5 text-xs leading-5 text-gray-500 dark:text-gray-400">
            The owner of this link may create a new short link if access is still required.
        </p>


        {{-- Button --}}
        <a
            href="{{ route('links.create') }}"
            class="mt-6 inline-flex h-11 w-full items-center justify-center gap-2 rounded-lg bg-brand-500 px-5 text-sm font-medium text-white transition hover:bg-brand-600"
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
                    d="M12 4v16m8-8H4"
                />
            </svg>

            Create a New Short Link

        </a>

    </div>

</div>

</div>

@endsection
