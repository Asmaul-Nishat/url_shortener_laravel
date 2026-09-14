<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>Login | URL Shortener</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    <style>
        /* =========================================================
           LOGIN PAGE ONLY
           ========================================================= */

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family:
                Inter,
                ui-sans-serif,
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;
            background: #f8fafc;
        }

        .login-page {
            min-height: 100vh;
            display: flex;
            background: #ffffff;
        }

        /* =========================================================
           LEFT SIDE
           ========================================================= */

        .login-visual {
            position: relative;
            width: 50%;
            min-height: 100vh;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px;
            background:
                linear-gradient(
                    135deg,
                    #2563eb 0%,
                    #4f46e5 45%,
                    #7c3aed 100%
                );
        }

        .login-visual::before {
            content: "";
            position: absolute;
            width: 520px;
            height: 520px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            top: -180px;
            right: -180px;
        }

        .login-visual::after {
            content: "";
            position: absolute;
            width: 420px;
            height: 420px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.06);
            bottom: -180px;
            left: -150px;
        }

        .visual-content {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 560px;
            color: white;
        }

        /* Brand */

        .visual-brand {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 70px;
        }

        .visual-logo {
            width: 52px;
            height: 52px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.18);
            border: 1px solid rgba(255, 255, 255, 0.25);
            font-size: 25px;
            font-weight: 800;
            backdrop-filter: blur(10px);
        }

        .visual-brand-name {
            font-size: 20px;
            font-weight: 700;
            letter-spacing: -0.3px;
        }

        .visual-brand-subtitle {
            margin-top: 2px;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.72);
        }

        /* Main text */

        .visual-heading {
            margin: 0;
            font-size: clamp(38px, 4vw, 60px);
            line-height: 1.08;
            letter-spacing: -2px;
            font-weight: 800;
        }

        .visual-heading span {
            color: #bfdbfe;
        }

        .visual-description {
            max-width: 500px;
            margin-top: 24px;
            font-size: 17px;
            line-height: 1.7;
            color: rgba(255, 255, 255, 0.78);
        }

        /* Features */

        .visual-features {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 14px;
            margin-top: 45px;
        }

        .visual-feature {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px 16px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.10);
            border: 1px solid rgba(255, 255, 255, 0.13);
            backdrop-filter: blur(8px);
        }

        .feature-icon {
            width: 34px;
            height: 34px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.16);
            font-size: 15px;
        }

        .feature-text {
            font-size: 13px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.9);
        }

        /* =========================================================
           RIGHT SIDE
           ========================================================= */

        .login-form-side {
            width: 50%;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 50px 30px;
            background: #ffffff;
        }

        .login-card {
            width: 100%;
            max-width: 440px;
        }

        .mobile-brand {
            display: none;
        }

        .login-heading {
            margin: 0;
            font-size: 32px;
            line-height: 1.2;
            font-weight: 800;
            letter-spacing: -1px;
            color: #111827;
        }

        .login-subheading {
            margin-top: 10px;
            color: #6b7280;
            font-size: 15px;
            line-height: 1.6;
        }

        /* Status */

        .status-message {
            margin-bottom: 22px;
            padding: 12px 14px;
            border-radius: 10px;
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #047857;
            font-size: 14px;
        }

        /* General error */

        .login-error-box {
            margin-bottom: 22px;
            padding: 13px 15px;
            border-radius: 10px;
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #b91c1c;
            font-size: 14px;
        }

        /* Form */

        .login-form {
            margin-top: 34px;
        }

        .form-group {
            margin-bottom: 21px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
        }

        .form-input {
            width: 100%;
            height: 50px;
            padding: 0 15px;
            border: 1px solid #d1d5db;
            border-radius: 11px;
            background: #ffffff;
            color: #111827;
            font-size: 14px;
            outline: none;
            transition:
                border-color 0.2s ease,
                box-shadow 0.2s ease;
        }

        .form-input::placeholder {
            color: #9ca3af;
        }

        .form-input:hover {
            border-color: #9ca3af;
        }

        .form-input:focus {
            border-color: #4f46e5;
            box-shadow:
                0 0 0 3px rgba(79, 70, 229, 0.10);
        }

        .input-error {
            margin-top: 7px;
            color: #dc2626;
            font-size: 12px;
        }

        /* Password row */

        .password-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .password-header .form-label {
            margin-bottom: 0;
        }

        .forgot-link {
            color: #4f46e5;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
        }

        .forgot-link:hover {
            color: #4338ca;
            text-decoration: underline;
        }

        /* Remember */

        .remember-row {
            display: flex;
            align-items: center;
            gap: 9px;
            margin-top: 5px;
        }

        .remember-checkbox {
            width: 16px;
            height: 16px;
            accent-color: #4f46e5;
            cursor: pointer;
        }

        .remember-label {
            color: #6b7280;
            font-size: 13px;
            cursor: pointer;
        }

        /* Login button */

        .login-button {
            width: 100%;
            height: 50px;
            margin-top: 25px;
            border: none;
            border-radius: 11px;
            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #4f46e5
                );
            color: white;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            box-shadow:
                0 8px 20px rgba(79, 70, 229, 0.22);
            transition:
                transform 0.2s ease,
                box-shadow 0.2s ease;
        }

        .login-button:hover {
            transform: translateY(-1px);
            box-shadow:
                0 12px 25px rgba(79, 70, 229, 0.28);
        }

        .login-button:active {
            transform: translateY(0);
        }

        /* Register */

        .register-section {
            margin-top: 30px;
            padding-top: 26px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
        }

        .register-text {
            color: #6b7280;
            font-size: 13px;
        }

        .register-link {
            display: inline-block;
            margin-top: 7px;
            color: #4f46e5;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
        }

        .register-link:hover {
            color: #4338ca;
            text-decoration: underline;
        }

        /* Security text */

        .security-note {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            margin-top: 30px;
            color: #9ca3af;
            font-size: 11px;
        }

        /* =========================================================
           RESPONSIVE
           ========================================================= */

        @media (max-width: 1000px) {

            .login-visual {
                width: 45%;
                padding: 40px;
            }

            .login-form-side {
                width: 55%;
            }

            .visual-heading {
                font-size: 40px;
            }

            .visual-features {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 760px) {

            .login-page {
                display: block;
            }

            .login-visual {
                display: none;
            }

            .login-form-side {
                width: 100%;
                min-height: 100vh;
                padding: 35px 22px;
                align-items: flex-start;
            }

            .login-card {
                max-width: 480px;
                margin: 0 auto;
                padding-top: 15px;
            }

            .mobile-brand {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
                margin-bottom: 45px;
            }

            .mobile-logo {
                width: 42px;
                height: 42px;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                background:
                    linear-gradient(
                        135deg,
                        #2563eb,
                        #7c3aed
                    );
                color: white;
                font-size: 19px;
                font-weight: 800;
            }

            .mobile-brand-name {
                font-size: 17px;
                font-weight: 700;
                color: #111827;
            }

            .login-heading {
                font-size: 29px;
            }
        }

        @media (max-width: 420px) {

            .login-form-side {
                padding: 30px 18px;
            }

            .login-heading {
                font-size: 27px;
            }

            .login-subheading {
                font-size: 14px;
            }
        }
    </style>
</head>

<body>

<div class="login-page">

    <!-- =========================================================
         LEFT VISUAL SECTION
         ========================================================= -->

    <section class="login-visual">

        <div class="visual-content">

            <!-- Brand -->

            <div class="visual-brand">

                <div class="visual-logo">
                    Q
                </div>

                <div>

                    <div class="visual-brand-name">
                        URL Shortener
                    </div>

                    <div class="visual-brand-subtitle">
                        Smart Link Management
                    </div>

                </div>

            </div>


            <!-- Main Message -->

            <h1 class="visual-heading">
                Shorten.
                <br>
                Share.
                <br>
                <span>Grow.</span>
            </h1>

            <p class="visual-description">
                Manage your links with a powerful URL shortening
                platform built for simple sharing, detailed
                analytics, and smarter link management.
            </p>


            <!-- Features -->

            <div class="visual-features">

                <div class="visual-feature">

                    <div class="feature-icon">
                        ↗
                    </div>

                    <div class="feature-text">
                        Smart Short Links
                    </div>

                </div>


                <div class="visual-feature">

                    <div class="feature-icon">
                        ◔
                    </div>

                    <div class="feature-text">
                        Powerful Analytics
                    </div>

                </div>


                <div class="visual-feature">

                    <div class="feature-icon">
                        ▦
                    </div>

                    <div class="feature-text">
                        QR Code Generation
                    </div>

                </div>


                <div class="visual-feature">

                    <div class="feature-icon">
                        ✓
                    </div>

                    <div class="feature-text">
                        Secure Link Management
                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- =========================================================
         RIGHT LOGIN SECTION
         ========================================================= -->

    <section class="login-form-side">

        <div class="login-card">

            <!-- Mobile Brand -->

            <div class="mobile-brand">

                <div class="mobile-logo">
                    Q
                </div>

                <div class="mobile-brand-name">
                    URL Shortener
                </div>

            </div>


            <!-- Heading -->

            <h2 class="login-heading">
                Welcome back
            </h2>

            <p class="login-subheading">
                Sign in to your account to continue managing
                your smart links.
            </p>


            <!-- Session Status -->

            @if (session('status'))

                <div class="status-message">
                    {{ session('status') }}
                </div>

            @endif


            <!-- General Errors -->

            @if ($errors->any())

                <div class="login-error-box">
                    Please check the information you entered
                    and try again.
                </div>

            @endif


            <!-- Login Form -->

            <form
                method="POST"
                action="{{ route('login') }}"
                class="login-form"
            >

                @csrf


                <!-- Email -->

                <div class="form-group">

                    <label
                        for="email"
                        class="form-label"
                    >
                        Email address
                    </label>

                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="form-input"
                        placeholder="Enter your email"
                        required
                        autofocus
                        autocomplete="username"
                    >

                    @if ($errors->get('email'))

                        <div class="input-error">
                            {{ $errors->first('email') }}
                        </div>

                    @endif

                </div>


                <!-- Password -->

                <div class="form-group">

                    <div class="password-header">

                        <label
                            for="password"
                            class="form-label"
                        >
                            Password
                        </label>

                        @if (Route::has('password.request'))

                            <a
                                href="{{ route('password.request') }}"
                                class="forgot-link"
                            >
                                Forgot password?
                            </a>

                        @endif

                    </div>


                    <input
                        id="password"
                        type="password"
                        name="password"
                        class="form-input"
                        placeholder="Enter your password"
                        required
                        autocomplete="current-password"
                    >

                    @if ($errors->get('password'))

                        <div class="input-error">
                            {{ $errors->first('password') }}
                        </div>

                    @endif

                </div>


                <!-- Remember Me -->

                <div class="remember-row">

                    <input
                        id="remember_me"
                        type="checkbox"
                        name="remember"
                        class="remember-checkbox"
                    >

                    <label
                        for="remember_me"
                        class="remember-label"
                    >
                        Remember me
                    </label>

                </div>


                <!-- Login Button -->

                <button
                    type="submit"
                    class="login-button"
                >
                    Sign in to your account
                </button>

            </form>


            <!-- Register -->

            <div class="register-section">

                <div class="register-text">
                    Don't have an account?
                </div>

                @if (Route::has('register'))

                    <a
                        href="{{ route('register') }}"
                        class="register-link"
                    >
                        Create an account →
                    </a>

                @endif

            </div>


            <!-- Security -->

            <div class="security-note">

                <span>🔒</span>

                <span>
                    Your account information is securely protected
                </span>

            </div>

        </div>

    </section>

</div>

</body>

</html>