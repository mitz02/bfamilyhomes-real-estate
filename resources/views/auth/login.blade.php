<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - B-Family Homes</title>
    
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon/favicon-16x16.png') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon/favicon.ico') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }

        /* Background */
        .auth-bg {
            background: #f3f3f3;
            position: fixed;
            inset: 0;
            z-index: 0;
            overflow: hidden;
        }

        /* Card */
        .auth-card {
            background: rgba(255, 255, 255, 0.97);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(255,255,255,0.6);
            border-radius: 12px;
            box-shadow:
                0 2px 12px rgba(0,0,0,0.05),
                0 0 0 1px rgba(0,0,0,0.02) inset;
        }

        /* Input field */
        .auth-input-wrap {
            position: relative;
        }
        .auth-input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 15px;
            pointer-events: none;
            transition: color 0.2s;
            z-index: 2;
        }
        .auth-input {
            width: 100%;
            padding: 13px 14px 13px 42px;
            border: 1.5px solid #e5e7eb;
            border-radius: 12px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            color: #111827;
            background: #f9fafb;
            transition: all 0.25s;
            outline: none;
        }
        .auth-input:focus {
            border-color: #f97316;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(249,115,22,0.12);
        }
        .auth-input:focus ~ .auth-input-icon,
        .auth-input-wrap:focus-within .auth-input-icon {
            color: #f97316;
        }
        .auth-input.has-right-icon { padding-right: 44px; }
        .auth-input.border-red-500 {
            border-color: #ef4444 !important;
            box-shadow: 0 0 0 3px rgba(239,68,68,0.1);
        }
        .toggle-pw-btn {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            cursor: pointer;
            transition: color 0.2s;
            z-index: 2;
            background: none;
            border: none;
            padding: 0;
            line-height: 1;
        }
        .toggle-pw-btn:hover { color: #f97316; }

        /* Divider */
        .auth-divider {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #9ca3af;
            font-size: 12px;
            margin: 6px 0;
        }
        .auth-divider::before, .auth-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e5e7eb;
        }

        /* Submit button */
        .auth-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            color: #fff;
            font-weight: 700;
            font-size: 15px;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.25s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 16px rgba(249,115,22,0.35);
            letter-spacing: 0.01em;
        }
        .auth-btn:hover {
            background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%);
            box-shadow: 0 6px 24px rgba(249,115,22,0.5);
            transform: translateY(-1px);
        }
        .auth-btn:active { transform: translateY(0); }
        .auth-btn:disabled { opacity: 0.65; cursor: not-allowed; transform: none; }

        /* Spinner */
        .btn-loader {
            display: inline-block;
            width: 16px; height: 16px;
            border: 2px solid rgba(255,255,255,0.4);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.65s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* Form label */
        .auth-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }

        /* Remember row */
        .auth-check { accent-color: #f97316; }

        /* Trust badges */
        .trust-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }
        .trust-item {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            color: #6b7280;
            font-weight: 500;
        }
        .trust-item i { color: #10b981; font-size: 13px; }

        /* Wrapper: 98% on mobile, max-w on desktop */
        .auth-wrap {
            width: 98%;
            max-width: 440px;
        }
        @media (max-width: 640px) {
            .auth-wrap { max-width: 98%; }
            .auth-card { border-radius: 10px; }
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center relative overflow-hidden" style="padding: 16px 0;">

    <!-- Background -->
    <div class="auth-bg"></div>

    <div id="toast-container" style="position: fixed; top: 1rem; right: 1rem; z-index: 9999; pointer-events: none;"></div>

    <!-- Auth Card -->
    <div class="auth-wrap relative z-10 mx-auto" style="padding: 8px;">
        <div class="auth-card p-7 sm:p-9">

            <!-- Logo -->
            <div class="text-center mb-7">
                <img src="{{ asset('images/logo.png') }}" alt="B-Family Homes" class="h-10 md:h-12 w-auto mx-auto mb-5">
                <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Welcome back</h1>
                <p class="text-gray-500 text-sm mt-1 font-medium">Sign in to your B-Family Homes account</p>
            </div>

            <!-- Login Form -->
            <form id="loginForm" class="space-y-5">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="auth-label">Email Address</label>
                    <div class="auth-input-wrap">
                        <i class="bi bi-envelope auth-input-icon"></i>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="auth-input"
                            required
                            placeholder="you@example.com"
                            autocomplete="email"
                        >
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="auth-label">Password</label>
                    <div class="auth-input-wrap">
                        <i class="bi bi-lock auth-input-icon"></i>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="auth-input has-right-icon"
                            required
                            placeholder="••••••••"
                            autocomplete="current-password"
                        >
                        <button type="button" class="toggle-pw-btn" onclick="togglePassword()" tabindex="-1">
                            <i class="bi bi-eye" id="passwordToggleIcon" style="font-size:16px;"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember & Forgot -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="auth-check w-4 h-4 rounded">
                        <span class="text-sm text-gray-600 font-medium">Remember me</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-sm font-semibold text-orange-500 hover:text-orange-600 transition-colors">
                        Forgot password?
                    </a>
                </div>

                <!-- Submit -->
                <button type="submit" id="submitBtn" class="auth-btn" style="margin-top: 4px;">
                    <span class="btn-text">Sign In</span>
                    <i class="bi bi-arrow-right btn-icon" style="font-size:16px;"></i>
                </button>
            </form>

            <!-- Divider -->
            <div class="auth-divider mt-6">Trusted by thousands of Nigerians</div>

            <!-- Trust badges -->
            <div class="trust-row mt-3 mb-6">
                <div class="trust-item"><i class="bi bi-shield-check"></i> Secure Login</div>
                <div class="trust-item"><i class="bi bi-lock-fill"></i> Encrypted</div>
                <div class="trust-item"><i class="bi bi-patch-check-fill"></i> Verified</div>
            </div>

            <!-- Register Link -->
            <div class="text-center pt-5 border-t border-gray-100">
                <p class="text-sm text-gray-500 font-medium">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="font-bold text-orange-500 hover:text-orange-600 ml-1 transition-colors">
                        Create one free →
                    </a>
                </p>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-xs text-gray-400 hover:text-gray-600 mt-3 transition-colors">
                    <i class="bi bi-arrow-left"></i> Back to Homepage
                </a>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('passwordToggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.replace('bi-eye-slash', 'bi-eye');
            }
        }

        async function resendVerificationEmail(email) {
            try {
                const response = await fetch('{{ route("verification.resend") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({ email: email })
                });
                const data = await response.json();
                if (data.success) {
                    window.toast(data.message || 'Verification email sent!', 'success');
                } else {
                    window.toast(data.message || 'Failed to send verification email.', 'error');
                }
            } catch (error) {
                window.toast('Failed to send verification email. Please try again.', 'error');
            }
        }

        document.getElementById('loginForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const form = e.target;
            const submitBtn = document.getElementById('submitBtn');
            const originalHTML = submitBtn.innerHTML;

            form.querySelectorAll('.auth-input').forEach(input => {
                input.classList.remove('border-red-500');
            });

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="btn-text">Signing in...</span><span class="btn-loader"></span>';

            const formData = new FormData(form);
            const email = formData.get('email');
            const password = formData.get('password');

            if (!email || !email.trim()) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalHTML;
                window.toast('Please enter your email address', 'error');
                document.getElementById('email').classList.add('border-red-500');
                document.getElementById('email').focus();
                return;
            }

            if (!password || !password.trim()) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalHTML;
                window.toast('Please enter your password', 'error');
                document.getElementById('password').classList.add('border-red-500');
                document.getElementById('password').focus();
                return;
            }

            try {
                const response = await fetch('{{ route("login.post") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({
                        email: email,
                        password: password,
                        remember: formData.get('remember') === 'on',
                    })
                });

                const data = await response.json();

                if (!response.ok) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalHTML;

                    if (data.requires_verification) {
                        window.toast(data.message || 'Please verify your email address.', 'error');
                        setTimeout(() => {
                            if (confirm('Would you like to resend the verification email?')) {
                                resendVerificationEmail(email);
                            }
                        }, 2000);
                        return;
                    }

                    let errorMessage = '';
                    if (data.errors) {
                        const errorMessages = Object.values(data.errors).flat();
                        errorMessage = errorMessages[0] || data.message || 'Invalid credentials. Please try again.';
                        Object.keys(data.errors).forEach(field => {
                            const input = document.getElementById(field);
                            if (input) input.classList.add('border-red-500');
                        });
                    } else if (data.message) {
                        errorMessage = data.message;
                    } else {
                        errorMessage = 'Invalid credentials. Please try again.';
                    }

                    if (errorMessage) window.toast(errorMessage, 'error');
                    return;
                }

                window.toast(data.message || 'Login successful!', 'success');
                setTimeout(() => {
                    window.location.href = data.redirect || '{{ route("dashboard") }}';
                }, 1000);

            } catch (error) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalHTML;
                window.toast('Network error. Please check your connection and try again.', 'error');
            }
        });
    </script>
</body>
</html>
