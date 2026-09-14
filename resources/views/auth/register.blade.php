<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>Register | URL Shortener</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    <style>
        /* =========================================================
           REGISTER PAGE ONLY
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

        .register-page {
            min-height: 100vh;
            display: flex;
            background: #ffffff;
        }

        /* =========================================================
           LEFT SIDE
           ========================================================= */

        .register-visual {
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

        .register-visual::before {
            content: "";

            position: absolute;

            width: 520px;
            height: 520px;

            border-radius: 50%;

            background:
                rgba(255, 255, 255, 0.08);

            top: -180px;
            right: -180px;
        }

        .register-visual::after {
            content: "";

            position: absolute;

            width: 420px;
            height: 420px;

            border-radius: 50%;

            background:
                rgba(255, 255, 255, 0.06);

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

        /* =========================================================
           BRAND
           ========================================================= */

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

            background:
                rgba(255, 255, 255, 0.18);

            border:
                1px solid rgba(255, 255, 255, 0.25);

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

            color:
                rgba(255, 255, 255, 0.72);
        }

        /* =========================================================
           MAIN TEXT
           ========================================================= */

        .visual-heading {
            margin: 0;

            font-size:
                clamp(38px, 4vw, 60px);

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

            color:
                rgba(255, 255, 255, 0.78);
        }

        /* =========================================================
           FEATURES
           ========================================================= */

        .visual-features {
            display: grid;

            grid-template-columns:
                repeat(2, 1fr);

            gap: 14px;

            margin-top: 45px;
        }

        .visual-feature {
            display: flex;
            align-items: center;

            gap: 12px;

            padding: 15px 16px;

            border-radius: 14px;

            background:
                rgba(255, 255, 255, 0.10);

            border:
                1px solid rgba(255, 255, 255, 0.13);

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

            background:
                rgba(255, 255, 255, 0.16);

            font-size: 15px;
        }

        .feature-text {
            font-size: 13px;

            font-weight: 600;

            color:
                rgba(255, 255, 255, 0.9);
        }

        /* =========================================================
           RIGHT SIDE
           ========================================================= */

        .register-form-side {
            width: 50%;
            min-height: 100vh;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 40px 30px;

            background: #ffffff;
        }

        .register-card {
            width: 100%;
            max-width: 440px;
        }

        .mobile-brand {
            display: none;
        }

        /* =========================================================
           HEADING
           ========================================================= */

        .register-heading {
            margin: 0;

            font-size: 32px;

            line-height: 1.2;

            font-weight: 800;

            letter-spacing: -1px;

            color: #111827;
        }

        .register-subheading {
            margin-top: 10px;

            color: #6b7280;

            font-size: 15px;

            line-height: 1.6;
        }

        /* =========================================================
           ERROR
           ========================================================= */

        .register-error-box {
            margin-top: 25px;

            padding: 13px 15px;

            border-radius: 10px;

            background: #fef2f2;

            border:
                1px solid #fecaca;

            color: #b91c1c;

            font-size: 14px;
        }

        /* =========================================================
           FORM
           ========================================================= */

        .register-form {
            margin-top: 30px;
        }

        .form-group {
            margin-bottom: 19px;
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

            height: 49px;

            padding: 0 15px;

            border:
                1px solid #d1d5db;

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
                0 0 0 3px
                rgba(79, 70, 229, 0.10);
        }

        .input-error {
            margin-top: 7px;

            color: #dc2626;

            font-size: 12px;
        }

        /* =========================================================
           REGISTER BUTTON
           ========================================================= */

        .register-button {
            width: 100%;

            height: 50px;

            margin-top: 5px;

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
                0 8px 20px
                rgba(79, 70, 229, 0.22);

            transition:
                transform 0.2s ease,
                box-shadow 0.2s ease;
        }

        .register-button:hover {
            transform: translateY(-1px);

            box-shadow:
                0 12px 25px
                rgba(79, 70, 229, 0.28);
        }

        .register-button:active {
            transform: translateY(0);
        }

        /* =========================================================
           LOGIN SECTION
           ========================================================= */

        .login-section {
            margin-top: 28px;

            padding-top: 24px;

            border-top:
                1px solid #e5e7eb;

            text-align: center;
        }

        .login-text {
            color: #6b7280;

            font-size: 13px;
        }

        .login-link {
            display: inline-block;

            margin-top: 7px;

            color: #4f46e5;

            font-size: 13px;

            font-weight: 700;

            text-decoration: none;
        }

        .login-link:hover {
            color: #4338ca;

            text-decoration: underline;
        }

        /* =========================================================
           SECURITY
           ========================================================= */

        .security-note {
            display: flex;

            align-items: center;

            justify-content: center;

            gap: 7px;

            margin-top: 25px;

            color: #9ca3af;

            font-size: 11px;
        }

        /* =========================================================
           RESPONSIVE
           ========================================================= */

        @media (max-width: 1000px) {

            .register-visual {
                width: 45%;
                padding: 40px;
            }

            .register-form-side {
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

            .register-page {
                display: block;
            }

            .register-visual {
                display: none;
            }

            .register-form-side {
                width: 100%;

                min-height: 100vh;

                padding: 30px 22px;

                align-items: flex-start;
            }

            .register-card {
                max-width: 480px;

                margin: 0 auto;

                padding-top: 15px;
            }

            .mobile-brand {
                display: flex;

                align-items: center;

                justify-content: center;

                gap: 10px;

                margin-bottom: 40px;
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

            .register-heading {
                font-size: 29px;
            }
        }

        @media (max-width: 420px) {

            .register-form-side {
                padding: 28px 18px;
            }

            .register-heading {
                font-size: 27px;
            }

            .register-subheading {
                font-size: 14px;
            }
        }
    </style>
</head>

<body>

<div class="register-page">

    <!-- =========================================================
         LEFT VISUAL SECTION
         ========================================================= -->

    <section class="register-visual">

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
                Build.
                <br>
                Manage.
                <br>
                <span>Grow.</span>
            </h1>

            <p class="visual-description">
                Create your account and start managing
                your short URLs, QR codes, analytics,
                and link performance from one powerful platform.
            </p>


            <!-- Features -->

            <div class="visual-features">

                <div class="visual-feature">

                    <div class="feature-icon">
                        ↗
                    </div>

                    <div class="feature-text">
                        Create Smart Links
                    </div>

                </div>


                <div class="visual-feature">

                    <div class="feature-icon">
                        ◔
                    </div>

                    <div class="feature-text">
                        Track Analytics
                    </div>

                </div>


                <div class="visual-feature">

                    <div class="feature-icon">
                        ▦
                    </div>

                    <div class="feature-text">
                        Generate QR Codes
                    </div>

                </div>


                <div class="visual-feature">

                    <div class="feature-icon">
                        ✓
                    </div>

                    <div class="feature-text">
                        Secure Your Links
                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- =========================================================
         RIGHT REGISTER SECTION
         ========================================================= -->

    <section class="register-form-side">

        <div class="register-card">

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

            <h2 class="register-heading">
                Create your account
            </h2>

            <p class="register-subheading">
                Join URL Shortener and start managing
                your smart links today.
            </p>


            <!-- General Errors -->

            @if ($errors->any())

                <div class="register-error-box">
                    Please check the information below
                    and correct the highlighted fields.
                </div>

            @endif


            <!-- Register Form -->

            <form
                method="POST"
                action="{{ route('register') }}"
                class="register-form"
            >

                @csrf


                <!-- Name -->

                <div class="form-group">

                    <label
                        for="name"
                        class="form-label"
                    >
                        Full name
                    </label>

                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        class="form-input"
                        placeholder="Enter your full name"
                        required
                        autofocus
                        autocomplete="name"
                    >

                    @if ($errors->get('name'))

                        <div class="input-error">
                            {{ $errors->first('name') }}
                        </div>

                    @endif

                </div>


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

                    <label
                        for="password"
                        class="form-label"
                    >
                        Password
                    </label>

                    <input
                        id="password"
                        type="password"
                        name="password"
                        class="form-input"
                        placeholder="Create a password"
                        required
                        autocomplete="new-password"
                    >

                    @if ($errors->get('password'))

                        <div class="input-error">
                            {{ $errors->first('password') }}
                        </div>

                    @endif

                </div>


                <!-- Confirm Password -->

                <div class="form-group">

                    <label
                        for="password_confirmation"
                        class="form-label"
                    >
                        Confirm password
                    </label>

                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        class="form-input"
                        placeholder="Confirm your password"
                        required
                        autocomplete="new-password"
                    >

                    @if ($errors->get('password_confirmation'))

                        <div class="input-error">
                            {{ $errors->first('password_confirmation') }}
                        </div>

                    @endif

                </div>


                <!-- Register Button -->

                <button
                    type="submit"
                    class="register-button"
                >
                    Create my account
                </button>

            </form>


            <!-- Login -->

            <div class="login-section">

                <div class="login-text">
                    Already have an account?
                </div>

                @if (Route::has('login'))

                    <a
                        href="{{ route('login') }}"
                        class="login-link"
                    >
                        Sign in to your account →
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