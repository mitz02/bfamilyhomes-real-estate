<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Verify Your Email - B-Family Homes</title>
    
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon/favicon-16x16.png') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon/favicon.ico') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: .5;
            }
        }
        .checkmark-circle {
            animation: checkmark-circle 0.6s ease-in-out;
        }
        @keyframes checkmark-circle {
            0% {
                transform: scale(0);
            }
            100% {
                transform: scale(1);
            }
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    <!-- Background Image -->
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=1920&q=80');"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-primary-900/90 via-primary-800/85 to-primary-900/90"></div>
    
    <div id="toast-container" style="position: fixed; top: 1rem; right: 1rem; z-index: 9999; pointer-events: none;"></div>

    <div class="w-full max-w-2xl relative z-10">
        <div class="card p-8 md:p-12">
            <!-- Logo -->
            <div class="text-center mb-8">
                <div class="flex justify-center mb-6">
                    <img src="{{ asset('images/logo.png') }}" alt="B-Family Homes" class="h-20 w-auto">
                </div>
                
                <!-- Success Icon -->
                <div class="flex justify-center mb-6">
                    <div class="w-24 h-24 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center shadow-2xl checkmark-circle">
                        <i class="bi bi-check-lg text-white text-5xl"></i>
                    </div>
                </div>
                
                <h1 class="text-3xl md:text-4xl font-bold text-gradient mb-3">Registration Successful!</h1>
                <p class="text-gray-600 text-lg">Thank you for joining B-Family Homes, <strong>{{ session('user_name', 'User') }}</strong>!</p>
            </div>

            <!-- Instructions Card -->
            <div class="space-y-6">
                <!-- Step 1: Verify Email -->
                <div class="bg-gradient-to-br from-blue-50 to-purple-50 border-2 border-blue-200 rounded-xl p-6 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-200 rounded-full -mr-16 -mt-16 opacity-30"></div>
                    <div class="relative">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg flex-shrink-0">
                                <span class="text-white font-bold text-xl">1</span>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-gray-900 mb-2">
                                    <i class="bi bi-envelope-check text-blue-600"></i> Verify Your Email
                                </h3>
                                <p class="text-gray-700 mb-3">
                                    We've sent a verification link to <strong class="text-blue-600">{{ session('user_email', 'your email') }}</strong>
                                </p>
                                <p class="text-sm text-gray-600">
                                    <i class="bi bi-info-circle text-blue-500"></i>
                                    Please check your inbox (and spam folder) and click the verification link to activate your account.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                @if(session('requires_approval'))
                <!-- Step 2: Wait for Admin Approval -->
                <div class="bg-gradient-to-br from-yellow-50 to-orange-50 border-2 border-yellow-300 rounded-xl p-6 relative overflow-hidden">
                    <div class="absolute bottom-0 left-0 w-32 h-32 bg-orange-200 rounded-full -ml-16 -mb-16 opacity-20"></div>
                    <div class="relative">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg flex-shrink-0">
                                <span class="text-white font-bold text-xl">2</span>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-gray-900 mb-2">
                                    <i class="bi bi-hourglass-split text-yellow-600"></i> Admin Approval Required
                                </h3>
                                <p class="text-gray-700 mb-3">
                                    As a <strong class="text-orange-600">{{ ucfirst(session('user_role', 'user')) }}</strong>, your account requires admin approval before you can login.
                                </p>
                                <p class="text-sm text-gray-600 mb-2">
                                    <i class="bi bi-clock-history text-yellow-600"></i>
                                    Our team will review your application shortly and you'll receive an email notification once approved.
                                </p>
                                <div class="mt-3 p-3 bg-yellow-100 rounded-lg border border-yellow-300">
                                    <p class="text-xs text-yellow-800 font-semibold">
                                        <i class="bi bi-lightbulb-fill"></i> Typical approval time: 24-48 hours
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- What's Next -->
                <div class="bg-gradient-to-br from-green-50 to-teal-50 border-2 border-green-200 rounded-xl p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">
                        <i class="bi bi-rocket-takeoff-fill text-green-600"></i> What Happens Next?
                    </h3>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-3">
                            <i class="bi bi-check-circle-fill text-green-600 mt-1 flex-shrink-0"></i>
                            <span class="text-gray-700">Check your email and click the verification link</span>
                        </li>
                        @if(session('requires_approval'))
                        <li class="flex items-start gap-3">
                            <i class="bi bi-check-circle-fill text-green-600 mt-1 flex-shrink-0"></i>
                            <span class="text-gray-700">Wait for admin to review and approve your account</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="bi bi-check-circle-fill text-green-600 mt-1 flex-shrink-0"></i>
                            <span class="text-gray-700">You'll receive an approval email when your account is ready</span>
                        </li>
                        @endif
                        <li class="flex items-start gap-3">
                            <i class="bi bi-check-circle-fill text-green-600 mt-1 flex-shrink-0"></i>
                            <span class="text-gray-700">Login and start exploring B-Family Homes!</span>
                        </li>
                    </ul>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                    <button id="resendBtn" class="btn bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white flex-1 flex items-center justify-center gap-2 shadow-lg">
                        <i class="bi bi-envelope-paper"></i>
                        <span class="btn-text">Resend Verification Email</span>
                    </button>
                    <a href="{{ route('login') }}" class="btn bg-gray-100 hover:bg-gray-200 text-gray-700 flex-1 flex items-center justify-center gap-2">
                        <i class="bi bi-box-arrow-in-right"></i>
                        Go to Login
                    </a>
                </div>

                <!-- Help Text -->
                <div class="text-center pt-4 border-t border-gray-200">
                    <p class="text-sm text-gray-600">
                        Didn't receive the email? 
                        <button onclick="document.getElementById('resendBtn').click()" class="text-primary-600 hover:text-primary-700 font-semibold underline">
                            Click here to resend
                        </button>
                    </p>
                    <p class="text-sm text-gray-500 mt-2">
                        Need help? 
                        <a href="{{ route('contact') }}" class="text-primary-600 hover:text-primary-700 font-semibold">
                            Contact Support
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('resendBtn')?.addEventListener('click', async function(e) {
            e.preventDefault();
            
            const btn = this;
            const originalHTML = btn.innerHTML;
            
            // Disable button and show loading
            btn.disabled = true;
            btn.innerHTML = '<i class="bi bi-hourglass-split animate-spin"></i> <span>Sending...</span>';
            
            try {
                const response = await fetch('{{ route("verification.resend") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({
                        email: '{{ session("user_email", "") }}'
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    window.toast(data.message || 'Verification email sent!', 'success');
                } else {
                    window.toast(data.message || 'Failed to send email.', 'error');
                }
            } catch (error) {
                console.error('Resend error:', error);
                window.toast('Failed to send verification email. Please try again.', 'error');
            } finally {
                btn.disabled = false;
                btn.innerHTML = originalHTML;
            }
        });
    </script>
</body>
</html>

