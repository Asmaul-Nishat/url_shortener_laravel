@extends('layouts.app')

@section('content')

<div class="flex min-h-screen items-center justify-center bg-gray-50 px-4 py-10 dark:bg-gray-900">

<div class="w-full max-w-md">

    {{-- Card --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-white/[0.03] sm:p-8">

        {{-- Icon --}}
        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-brand-50 dark:bg-brand-500/10">

            <svg
                class="h-7 w-7 text-brand-500"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M16.5 10.5V6.75a4.5 4.5 0 0 0-9 0v3.75m-.75 0h10.5A2.25 2.25 0 0 1 19.5 12.75v6A2.25 2.25 0 0 1 17.25 21h-10.5a2.25 2.25 0 0 1-2.25-2.25v-6A2.25 2.25 0 0 1 6.75 10.5Z"
                />
            </svg>

        </div>


        {{-- Heading --}}
        <div class="mt-5 text-center">

            <h1 class="text-xl font-semibold text-gray-800 dark:text-white/90">
                Password Protected Link
            </h1>

            <p class="mt-2 text-sm leading-6 text-gray-500 dark:text-gray-400">
                This short link is protected by a password.
                Please enter the password to continue.
            </p>

        </div>


        {{-- Error --}}
        @if($errors->any())

            <div class="mt-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 dark:border-red-900/50 dark:bg-red-900/20">

                <div class="flex items-start gap-3">

                    <svg
                        class="mt-0.5 h-5 w-5 shrink-0 text-red-500"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 9v3.75m0 3h.007v.008H12v-.008ZM10.29 3.86 1.82 18a2 2 0 0 0 1.72 3h16.92a2 2 0 0 0 1.72-3L13.71 3.86a2 2 0 0 0-3.42 0Z"
                        />
                    </svg>

                    <p class="text-sm text-red-700 dark:text-red-300">
                        {{ $errors->first('password') }}
                    </p>

                </div>

            </div>

        @endif


        {{-- Password Form --}}
        <form
            method="POST"
            action="{{ route('short.password.verify', $guestUrl['short_code']) }}"
            class="mt-6"
        >

            @csrf

            <div>

                <label
                    for="password"
                    class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                >
                    Password
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    autocomplete="off"
                    autofocus
                    required
                    placeholder="Enter password"
                    class="h-11 w-full rounded-lg border border-gray-300 bg-white px-4 text-sm text-gray-800 outline-none transition placeholder:text-gray-400 focus:border-brand-500 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-gray-500"
                >

            </div>


            <button
                type="submit"
                class="mt-5 inline-flex h-11 w-full items-center justify-center gap-2 rounded-lg bg-brand-500 px-5 text-sm font-medium text-white transition hover:bg-brand-600"
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
                        d="M15.75 5.25a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 0 12 18.75a17.933 17.933 0 0 0-7.499 1.368Z"
                    />
                </svg>

                Continue

            </button>

        </form>


        {{-- Back --}}
        <div class="mt-6 text-center">

            <a
                href="{{ route('links.create') }}"
                class="text-sm font-medium text-brand-500 hover:text-brand-600 dark:text-brand-400 dark:hover:text-brand-300"
            >
                Create your own short link
            </a>

        </div>

    </div>

</div>

</div>

@endsection
