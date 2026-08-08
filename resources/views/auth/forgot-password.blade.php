@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
<section class="py-16 bg-gray-50 min-h-screen flex items-center">
    <div class="container mx-auto px-4">
        <div class="max-w-md mx-auto">
            <div class="card p-8">
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="bi bi-key text-3xl text-primary-600"></i>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Forgot Password?</h1>
                    <p class="text-gray-600">Enter your email address and we'll send you a link to reset your password.</p>
                </div>

                <form id="forgotPasswordForm" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" id="forgotEmail" class="form-input" placeholder="your@email.com" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-full">
                        <i class="bi bi-envelope"></i>
                        Send Reset Link
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
    document.getElementById('forgotPasswordForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const form = e.target;
        const submitBtn = form.querySelector('button[type="submit"]');
        const formData = new FormData(form);
        
        showLoader(submitBtn);
        
        try {
            const data = await window.ajax('{{ route("password.email") }}', 'POST', {
                email: formData.get('email'),
            });
            
            window.toast(data.message, 'success');
            
            // If in debug mode and reset URL is provided, show it
            if (data.reset_url) {
                setTimeout(() => {
                    const showUrl = confirm('Reset URL: ' + data.reset_url + '\n\nClick OK to open it, or Cancel to copy it.');
                    if (showUrl) {
                        window.open(data.reset_url, '_blank');
                    } else {
                        navigator.clipboard.writeText(data.reset_url);
                        window.toast('Reset URL copied to clipboard', 'info');
                    }
                }, 1000);
            }
            
            form.reset();
        } catch (error) {
            window.toast(error.message || 'Failed to send reset link', 'error');
        } finally {
            hideLoader(submitBtn);
        }
    });
</script>
@endpush

