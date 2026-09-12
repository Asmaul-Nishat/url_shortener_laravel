
<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status
        class="mb-4"
        :status="session('status')"
    />

    <!-- Login Form -->
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Page Heading -->
        <div class="mb-6">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">
               Login
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Sign in to your account to continue.
            </p>
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label
                for="email"
                :value="__('Email')"
            />

            <x-text-input
                id="email"
                class="block mt-1 w-full"
                type="email"
                name="email"
                :value="old('email')"
                required
                autofocus
                autocomplete="username"
            />

            <x-input-error
                :messages="$errors->get('email')"
                class="mt-2"
            />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label
                for="password"
                :value="__('Password')"
            />

            <x-text-input
                id="password"
                class="block mt-1 w-full"
                type="password"
                name="password"
                required
                autocomplete="current-password"
            />

            <x-input-error
                :messages="$errors->get('password')"
                class="mt-2"
            />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label
                for="remember_me"
                class="inline-flex items-center"
            >
                <input
                    id="remember_me"
                    type="checkbox"
                    name="remember"
                    class="rounded border-gray-300 bg-white text-indigo-600 shadow-sm
                           focus:ring-indigo-500
                           dark:border-gray-700 dark:bg-gray-900
                           dark:text-indigo-500 dark:focus:ring-indigo-600"
                >

                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Remember me') }}
                </span>
            </label>
        </div>

        <!-- Login Actions -->
        <div class="flex items-center justify-between mt-6">

            <!-- Forgot Password -->
            @if (Route::has('password.request'))
                <a
                    href="{{ route('password.request') }}"
                    class="text-sm font-medium text-indigo-600
                           hover:text-indigo-500
                           dark:text-indigo-400
                           dark:hover:text-indigo-300
                           focus:outline-none focus:ring-2
                           focus:ring-indigo-500
                           focus:ring-offset-2
                           dark:focus:ring-offset-gray-800"
                >
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <!-- Login Button -->
            <x-primary-button>
                {{ __('Log in') }}
            </x-primary-button>

        </div>
    </form>

    <!-- Register Section -->
    <div class="mt-8 border-t border-gray-200 pt-6 text-center dark:border-gray-700">

        <p class="text-sm text-gray-600 dark:text-gray-400">
            Don't have an account?
        </p>

        <a
            href="{{ route('register') }}"
            class="mt-2 inline-flex items-center justify-center rounded-lg
                   border border-gray-300 bg-white px-4 py-2
                   text-sm font-medium text-gray-700
                   shadow-sm transition
                   hover:bg-gray-50
                   focus:outline-none focus:ring-2
                   focus:ring-indigo-500
                   focus:ring-offset-2
                   dark:border-gray-600
                   dark:bg-gray-800
                   dark:text-gray-200
                   dark:hover:bg-gray-700
                   dark:focus:ring-offset-gray-800"
        >
            Create an account
        </a>

    </div>
</x-guest-layout>
