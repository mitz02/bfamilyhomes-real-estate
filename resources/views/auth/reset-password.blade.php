@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
<section class="py-16 bg-gray-50 min-h-screen flex items-center">
    <div class="container mx-auto px-4">
        <div class="max-w-md mx-auto">
            <div class="card p-8">
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="bi bi-key text-3xl text-primary-600"></i>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Reset Password</h1>
                    <p class="text-gray-600">Enter your new password below.</p>
                </div>

                <form id="resetPasswordForm" class="space-y-6">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ $email }}">
                    
                    <div>
                        <label class="form-label">New Password</label>
                        <input 
                            type="password" 
                            name="password" 
                            class="form-input" 
                            placeholder="Enter new password" 
                            required
                            minlength="8"
                        >
                        <p class="text-xs text-gray-500 mt-1">Must be at least 8 characters</p>
                    </div>

                    <div>
                        <label class="form-label">Confirm New Password</label>
                        <input 
                            type="password" 
                            name="password_confirmation" 
                            class="form-input" 
                            placeholder="Confirm new password" 
                            required
                            minlength="8"
                        >
                    </div>

                    <button type="submit" class="btn btn-primary w-full">
                        <i class="bi bi-check-circle"></i>
                        Reset Password
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <a href="{{ route('login') }}" class="text-primary-600 hover:text-primary-700 text-sm font-semibold">
                        <i class="bi bi-arrow-left"></i>
                        Back to Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.getElementById('resetPasswordForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const form = e.target;
        const submitBtn = form.querySelector('button[type="submit"]');
        const formData = new FormData(form);
        
        // Validate passwords match
        const password = formData.get('password');
        const passwordConfirmation = formData.get('password_confirmation');
        
        if (password !== passwordConfirmation) {
            window.toast('Passwords do not match', 'error');
            return;
        }
        
        if (password.length < 8) {
            window.toast('Password must be at least 8 characters', 'error');
            return;
        }
        
        showLoader(submitBtn);
        
        try {
            const data = await window.ajax('{{ route("password.update") }}', 'POST', {
                token: formData.get('token'),
                email: formData.get('email'),
                password: password,
                password_confirmation: passwordConfirmation,
            });
            
            window.toast(data.message, 'success');
            setTimeout(() => {
                window.location.href = data.redirect;
            }, 1500);
        } catch (error) {
            hideLoader(submitBtn);
            window.toast(error.message || 'Failed to reset password', 'error');
        }
    });
</script>
@endpush


