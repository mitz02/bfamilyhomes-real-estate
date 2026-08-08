<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - B-Family Homes</title>
    
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
            box-shadow: 0 2px 12px rgba(0,0,0,0.05), 0 0 0 1px rgba(0,0,0,0.02) inset;
        }

        /* Step Indicator */
        .step-track {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0;
            margin-bottom: 28px;
        }
        .step-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            flex: 1;
        }
        .step-circle {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #e5e7eb;
            color: #9ca3af;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
            transition: all 0.35s cubic-bezier(0.4,0,0.2,1);
            position: relative;
            z-index: 2;
            border: 2.5px solid transparent;
        }
        .step-item.active .step-circle {
            background: linear-gradient(135deg, #f97316, #ea580c);
            color: white;
            box-shadow: 0 4px 14px rgba(249,115,22,0.45);
            border-color: transparent;
        }
        .step-item.completed .step-circle {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            box-shadow: 0 4px 14px rgba(16,185,129,0.35);
        }
        .step-label {
            font-size: 10px;
            font-weight: 600;
            color: #9ca3af;
            margin-top: 5px;
            text-align: center;
            letter-spacing: 0.02em;
        }
        .step-item.active .step-label { color: #f97316; }
        .step-item.completed .step-label { color: #10b981; }
        .step-connector {
            flex: 1;
            height: 2px;
            background: #e5e7eb;
            margin-bottom: 22px;
            transition: background 0.35s;
            position: relative;
            z-index: 1;
        }
        .step-connector.done { background: linear-gradient(90deg, #10b981, #f97316); }

        /* Form step animation */
        .form-step { display: none; }
        .form-step.active {
            display: block;
            animation: slideUp 0.3s cubic-bezier(0.4,0,0.2,1);
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Input */
        .auth-input-wrap { position: relative; }
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
        .auth-input-wrap:focus-within .auth-input-icon { color: #f97316; }
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
        .auth-input.border-red-500 {
            border-color: #ef4444 !important;
            box-shadow: 0 0 0 3px rgba(239,68,68,0.1);
        }
        .auth-select {
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
            appearance: none;
            cursor: pointer;
        }
        .auth-select:focus {
            border-color: #f97316;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(249,115,22,0.12);
        }
        .select-arrow {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
            pointer-events: none;
            z-index: 2;
            font-size: 12px;
        }
        .auth-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }

        /* Role cards */
        .role-grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 8px; }
        @media (max-width: 400px) { .role-grid { grid-template-columns: 1fr; } }
        .role-card {
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 12px 8px;
            cursor: pointer;
            text-align: center;
            transition: all 0.2s;
            background: #f9fafb;
            user-select: none;
        }
        .role-card:hover { border-color: #f97316; background: #fff7ed; }
        .role-card.selected { border-color: #f97316; background: #fff7ed; box-shadow: 0 0 0 3px rgba(249,115,22,0.15); }
        .role-card i { font-size: 22px; margin-bottom: 5px; display: block; }
        .role-card span { font-size: 11px; font-weight: 600; color: #374151; }
        .role-card.selected i, .role-card.selected span { color: #ea580c; }

        /* Buttons */
        .auth-btn-primary {
            padding: 13px 22px;
            background: linear-gradient(135deg, #f97316, #ea580c);
            color: #fff;
            font-weight: 700;
            font-size: 14px;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.25s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 4px 16px rgba(249,115,22,0.35);
        }
        .auth-btn-primary:hover { box-shadow: 0 6px 20px rgba(249,115,22,0.48); transform: translateY(-1px); }
        .auth-btn-primary:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }

        .auth-btn-outline {
            padding: 13px 22px;
            background: transparent;
            color: #374151;
            font-weight: 700;
            font-size: 14px;
            border: 2px solid #d1d5db;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .auth-btn-outline:hover { border-color: #9ca3af; background: #f9fafb; }

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

        /* Terms box */
        .terms-box {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 14px;
            background: #f0fdf4;
            border: 1.5px solid #bbf7d0;
            border-radius: 12px;
        }
        .terms-box input[type="checkbox"] { margin-top: 2px; accent-color: #10b981; width: 16px; height: 16px; flex-shrink: 0; }

        /* Wrapper */
        .auth-wrap {
            width: 98%;
            max-width: 560px;
        }
        @media (max-width: 640px) {
            .auth-wrap { max-width: 98%; }
            .auth-card { border-radius: 10px; }
        }

        /* Turnstile */
        .cf-turnstile { margin: 0 auto; max-width: 100%; overflow: hidden; }
    </style>
</head>
<body class="min-h-screen relative overflow-y-auto" style="padding: 20px 0;">

    <!-- Background -->
    <div class="auth-bg"></div>

    <div id="toast-container" style="position: fixed; top: 1rem; right: 1rem; z-index: 9999; pointer-events: none;"></div>

    <!-- Auth Card -->
    <div class="auth-wrap mx-auto relative z-10" style="padding: 0 0 24px;">
        <div class="auth-card p-6 sm:p-8">

            <!-- Logo -->
            <div class="text-center mb-6">
                <img src="{{ asset('images/logo.png') }}" alt="B-Family Homes" class="h-10 md:h-12 w-auto mx-auto mb-4">
                <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Create your account</h1>
                <p class="text-gray-500 text-sm mt-1 font-medium">Join thousands of Nigerians finding their dream home</p>
            </div>

            <!-- Step Indicator -->
            <div class="step-track">
                <div class="step-item active" data-step="1">
                    <div class="step-circle">1</div>
                    <div class="step-label">Personal</div>
                </div>
                <div class="step-connector" id="conn1"></div>
                <div class="step-item" data-step="2">
                    <div class="step-circle">2</div>
                    <div class="step-label">Security</div>
                </div>
                <div class="step-connector" id="conn2"></div>
                <div class="step-item" data-step="3">
                    <div class="step-circle">3</div>
                    <div class="step-label">Role & Terms</div>
                </div>
            </div>

            <!-- Register Form -->
            <form id="registerForm">
                @csrf

                <!-- Honeypot -->
                <div style="position: absolute; left: -9999px;" aria-hidden="true">
                    <label for="website">Website</label>
                    <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                </div>

                <!-- STEP 1: Personal Info -->
                <div class="form-step active" data-step="1">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-7 h-7 rounded-full flex items-center justify-center text-white text-xs font-bold" style="background:linear-gradient(135deg,#f97316,#ea580c);">1</div>
                        <h3 class="text-base font-bold text-gray-900">Personal Information</h3>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label for="name" class="auth-label">Full Name <span class="text-red-400">*</span></label>
                            <div class="auth-input-wrap">
                                <i class="bi bi-person auth-input-icon"></i>
                                <input type="text" id="name" name="name" class="auth-input" required placeholder="John Doe">
                            </div>
                        </div>

                        <div>
                            <label for="email" class="auth-label">Email Address <span class="text-red-400">*</span></label>
                            <div class="auth-input-wrap">
                                <i class="bi bi-envelope auth-input-icon"></i>
                                <input type="email" id="email" name="email" class="auth-input" required placeholder="you@example.com">
                            </div>
                        </div>

                        <div>
                            <label for="phone" class="auth-label">Phone Number <span class="text-red-400">*</span></label>
                            <div class="auth-input-wrap">
                                <i class="bi bi-telephone auth-input-icon"></i>
                                <input type="tel" id="phone" name="phone" class="auth-input" required placeholder="+234 801 234 5678">
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end mt-6">
                        <button type="button" onclick="nextStep()" class="auth-btn-primary">
                            Continue <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <!-- STEP 2: Account Security -->
                <div class="form-step" data-step="2">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-7 h-7 rounded-full flex items-center justify-center text-white text-xs font-bold" style="background:linear-gradient(135deg,#f97316,#ea580c);">2</div>
                        <h3 class="text-base font-bold text-gray-900">Account Security</h3>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label for="password" class="auth-label">Password <span class="text-red-400">*</span></label>
                            <div class="auth-input-wrap">
                                <i class="bi bi-lock auth-input-icon"></i>
                                <input type="password" id="password" name="password" class="auth-input" required placeholder="Min. 8 characters" minlength="8" style="padding-right:44px;">
                                <button type="button" class="toggle-pw-btn" onclick="togglePw('password','togglePw1')" tabindex="-1" style="position:absolute;right:14px;top:50%;transform:translateY(-50%);color:#9ca3af;cursor:pointer;background:none;border:none;padding:0;">
                                    <i class="bi bi-eye" id="togglePw1" style="font-size:16px;"></i>
                                </button>
                            </div>
                            <div id="pw-strength" class="mt-2 hidden">
                                <div class="flex gap-1 mb-1">
                                    <div class="h-1 flex-1 rounded-full bg-gray-200" id="s1"></div>
                                    <div class="h-1 flex-1 rounded-full bg-gray-200" id="s2"></div>
                                    <div class="h-1 flex-1 rounded-full bg-gray-200" id="s3"></div>
                                    <div class="h-1 flex-1 rounded-full bg-gray-200" id="s4"></div>
                                </div>
                                <p id="pw-strength-label" class="text-xs text-gray-400"></p>
                            </div>
                        </div>

                        <div>
                            <label for="password_confirmation" class="auth-label">Confirm Password <span class="text-red-400">*</span></label>
                            <div class="auth-input-wrap">
                                <i class="bi bi-lock-fill auth-input-icon"></i>
                                <input type="password" id="password_confirmation" name="password_confirmation" class="auth-input" required placeholder="Re-enter password" minlength="8" style="padding-right:44px;">
                                <button type="button" onclick="togglePw('password_confirmation','togglePw2')" tabindex="-1" style="position:absolute;right:14px;top:50%;transform:translateY(-50%);color:#9ca3af;cursor:pointer;background:none;border:none;padding:0;">
                                    <i class="bi bi-eye" id="togglePw2" style="font-size:16px;"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between mt-6">
                        <button type="button" onclick="prevStep()" class="auth-btn-outline">
                            <i class="bi bi-arrow-left"></i> Back
                        </button>
                        <button type="button" onclick="nextStep()" class="auth-btn-primary">
                            Continue <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <!-- STEP 3: Role & Terms -->
                <div class="form-step" data-step="3">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-7 h-7 rounded-full flex items-center justify-center text-white text-xs font-bold" style="background:linear-gradient(135deg,#f97316,#ea580c);">3</div>
                        <h3 class="text-base font-bold text-gray-900">Account Type</h3>
                    </div>

                    <!-- Hidden role field -->
                    <input type="hidden" id="role" name="role" value="user">

                    <div class="mb-4">
                        <label class="auth-label">I want to register as <span class="text-red-400">*</span></label>
                        <div class="role-grid">
                            <div class="role-card selected" onclick="selectRole('user', this)">
                                <i class="bi bi-person-circle text-gray-500"></i>
                                <span>Regular User</span>
                            </div>
                            <div class="role-card" onclick="selectRole('agent', this)">
                                <i class="bi bi-briefcase text-gray-500"></i>
                                <span>Agent</span>
                            </div>
                            <div class="role-card" onclick="selectRole('investor', this)">
                                <i class="bi bi-graph-up-arrow text-gray-500"></i>
                                <span>Investor</span>
                            </div>
                        </div>
                        <p class="text-xs text-gray-400 mt-2">
                            <i class="bi bi-info-circle"></i> Agent &amp; Investor roles require admin approval
                        </p>
                    </div>

                    <!-- Terms -->
                    <div class="terms-box mb-4">
                        <input type="checkbox" id="terms" name="terms" required>
                        <label for="terms" class="text-sm text-gray-600 leading-snug">
                            I agree to the
                            <a href="{{ route('terms') }}" target="_blank" class="font-bold text-green-600 hover:text-green-700 underline">Terms & Conditions</a>
                            and
                            <a href="{{ route('privacy') }}" target="_blank" class="font-bold text-green-600 hover:text-green-700 underline">Privacy Policy</a>
                        </label>
                    </div>

                    <!-- Cloudflare Turnstile -->
                    <div class="mb-5">
                        <div class="cf-turnstile" data-sitekey="{{ config('services.turnstile.site_key') }}" data-theme="light"></div>
                    </div>

                    <div class="flex justify-between mt-2">
                        <button type="button" onclick="prevStep()" class="auth-btn-outline">
                            <i class="bi bi-arrow-left"></i> Back
                        </button>
                        <button type="submit" id="submitBtn" class="auth-btn-primary">
                            <span class="btn-text">Create Account</span>
                            <i class="bi bi-check2-circle btn-icon"></i>
                        </button>
                    </div>
                </div>
            </form>

            <!-- Footer -->
            <div class="text-center mt-6 pt-5 border-t border-gray-100">
                <p class="text-sm text-gray-500 font-medium">
                    Already have an account?
                    <a href="{{ route('login') }}" class="font-bold text-orange-500 hover:text-orange-600 ml-1 transition-colors">
                        Sign in →
                    </a>
                </p>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-xs text-gray-400 hover:text-gray-600 mt-3 transition-colors">
                    <i class="bi bi-arrow-left"></i> Back to Homepage
                </a>
            </div>
        </div>
    </div>

    @if(config('services.turnstile.site_key'))
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    @endif

    <script>
        let currentStep = 1;
        const totalSteps = 3;

        function updateStepUI() {
            document.querySelectorAll('.step-item').forEach((item, i) => {
                const n = i + 1;
                item.classList.remove('active', 'completed');
                if (n < currentStep) item.classList.add('completed');
                else if (n === currentStep) item.classList.add('active');
                // Update circle content for completed
                const circle = item.querySelector('.step-circle');
                if (n < currentStep) {
                    circle.innerHTML = '<i class="bi bi-check2" style="font-size:16px;"></i>';
                } else {
                    circle.textContent = n;
                }
            });
            // Update connectors
            const conn1 = document.getElementById('conn1');
            const conn2 = document.getElementById('conn2');
            if (conn1) conn1.className = 'step-connector' + (currentStep > 1 ? ' done' : '');
            if (conn2) conn2.className = 'step-connector' + (currentStep > 2 ? ' done' : '');
        }

        function showStep(step) {
            document.querySelectorAll('.form-step').forEach(s => s.classList.remove('active'));
            document.querySelector(`.form-step[data-step="${step}"]`).classList.add('active');
            updateStepUI();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function validateStep(step) {
            const stepEl = document.querySelector(`.form-step[data-step="${step}"]`);
            const required = stepEl.querySelectorAll('[required]');
            let valid = true;

            required.forEach(field => {
                if (field.type === 'checkbox') {
                    if (!field.checked) {
                        valid = false;
                        field.closest('.terms-box')?.classList.add('border-red-400');
                    } else {
                        field.closest('.terms-box')?.classList.remove('border-red-400');
                    }
                } else if (!field.value.trim()) {
                    valid = false;
                    field.classList.add('border-red-500');
                } else {
                    field.classList.remove('border-red-500');
                }
            });

            if (step === 2) {
                const pw = document.getElementById('password').value;
                const pwc = document.getElementById('password_confirmation').value;
                if (pw.length < 8) {
                    window.toast('Password must be at least 8 characters', 'error');
                    valid = false;
                } else if (pw !== pwc && pw.length >= 8) {
                    window.toast('Passwords do not match', 'error');
                    valid = false;
                }
            }

            if (!valid && step !== 2) {
                window.toast('Please fill in all required fields', 'error');
            }
            return valid;
        }

        function nextStep() {
            if (validateStep(currentStep) && currentStep < totalSteps) {
                currentStep++;
                showStep(currentStep);
            }
        }

        function prevStep() {
            if (currentStep > 1) {
                currentStep--;
                showStep(currentStep);
            }
        }

        function selectRole(role, el) {
            document.querySelectorAll('.role-card').forEach(c => c.classList.remove('selected'));
            el.classList.add('selected');
            document.getElementById('role').value = role;
        }

        function togglePw(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('bi-eye-slash', 'bi-eye');
            }
        }

        // Password strength
        document.getElementById('password')?.addEventListener('input', function() {
            const pw = this.value;
            const strengthBar = document.getElementById('pw-strength');
            if (!pw) { strengthBar.classList.add('hidden'); return; }
            strengthBar.classList.remove('hidden');

            let score = 0;
            if (pw.length >= 8) score++;
            if (/[A-Z]/.test(pw)) score++;
            if (/[0-9]/.test(pw)) score++;
            if (/[^A-Za-z0-9]/.test(pw)) score++;

            const colors = ['bg-red-400', 'bg-orange-400', 'bg-yellow-400', 'bg-green-500'];
            const labels = ['Weak', 'Fair', 'Good', 'Strong'];
            const labelColors = ['text-red-500', 'text-orange-500', 'text-yellow-600', 'text-green-600'];

            for (let i = 1; i <= 4; i++) {
                const bar = document.getElementById('s' + i);
                bar.className = 'h-1 flex-1 rounded-full ' + (i <= score ? colors[score - 1] : 'bg-gray-200');
            }
            const label = document.getElementById('pw-strength-label');
            label.textContent = score > 0 ? 'Strength: ' + labels[score - 1] : '';
            label.className = 'text-xs ' + (score > 0 ? labelColors[score - 1] : 'text-gray-400');
        });

        // Form submission
        document.getElementById('registerForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const form = e.target;
            const submitBtn = document.getElementById('submitBtn');
            const originalHTML = submitBtn.innerHTML;

            // Validate all steps
            let hasErrors = false;
            for (let s = 1; s <= totalSteps; s++) {
                if (!validateStep(s)) {
                    showStep(s);
                    currentStep = s;
                    hasErrors = true;
                    break;
                }
            }
            if (hasErrors) return;

            const pw = document.getElementById('password').value;
            const pwc = document.getElementById('password_confirmation').value;
            if (pw !== pwc) {
                showStep(2); currentStep = 2;
                window.toast('Passwords do not match', 'error');
                return;
            }

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="btn-text">Creating Account...</span><span class="btn-loader"></span>';

            const formData = new FormData(form);

            try {
                const turnstileResponse = formData.get('cf-turnstile-response');
                const data = await window.ajax('{{ route("register.post") }}', 'POST', {
                    name: formData.get('name'),
                    email: formData.get('email'),
                    phone: formData.get('phone'),
                    password: formData.get('password'),
                    password_confirmation: formData.get('password_confirmation'),
                    role: formData.get('role'),
                    ...(turnstileResponse ? { 'cf-turnstile-response': turnstileResponse } : {}),
                });

                window.toast(data.message, 'success');
                setTimeout(() => { window.location.href = data.redirect; }, 1000);

            } catch (error) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalHTML;

                let errorMessage = '';
                if (error.errors) {
                    const msgs = Object.values(error.errors).flat();
                    errorMessage = msgs[0] || 'Registration failed. Please check your inputs.';
                    Object.keys(error.errors).forEach(field => {
                        const input = document.getElementById(field);
                        if (input) input.classList.add('border-red-500');
                    });
                } else {
                    errorMessage = error.message || 'Registration failed. Please try again.';
                }
                window.toast(errorMessage, 'error');
            }
        });

        // Init
        updateStepUI();
    </script>
</body>
</html>
