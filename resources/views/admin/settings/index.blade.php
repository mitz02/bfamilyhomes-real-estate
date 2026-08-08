@extends('layouts.admin')

@section('title', 'System Settings')

@section('content')
<div class="mb-8">
    <div class="flex items-center gap-2 text-xs md:text-sm text-gray-500 mb-4 px-2 md:px-0">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-orange-600 transition-colors">
            <i class="bi bi-house-door mr-1"></i>B-Family
        </a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-orange-600 font-semibold">System Settings</span>
    </div>

    @php
        $hour = now()->hour;
        if ($hour < 12) $greeting = 'Good Morning';
        elseif ($hour < 17) $greeting = 'Good Afternoon';
        else $greeting = 'Good Evening';
    @endphp
    <div class="relative bg-gradient-to-br from-blue-900 via-blue-800 to-blue-900 rounded-2xl p-6 md:p-8 shadow-lg overflow-hidden">
        <div class="absolute -top-10 -right-10 w-48 h-48 bg-white/5 rounded-full"></div>
        <div class="absolute -bottom-10 -left-10 w-36 h-36 bg-white/5 rounded-full"></div>
        <div class="absolute top-1/2 right-1/3 w-20 h-20 bg-white/5 rounded-full"></div>

        <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-start gap-4">
                <div class="w-14 h-14 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center shadow-sm flex-shrink-0 border border-white/10">
                    <i class="bi bi-gear-wide-connected text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-bold text-white">System Settings</h1>
                    <p class="text-blue-100/80 text-sm mt-0.5">{{ $greeting }}, {{ auth()->user()->name }}!</p>
                    <p class="text-blue-300/60 text-xs mt-0.5">{{ now()->format('l, F j, Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<form id="settingsForm" class="space-y-6 mx-1 md:mx-0">
    @csrf
    
    <!-- Company Information -->
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
        <div class="flex items-center gap-2 mb-6">
            <div class="w-8 h-8 bg-orange-500/10 rounded-lg flex items-center justify-center">
                <i class="bi bi-building text-orange-500 text-sm"></i>
            </div>
            <h2 class="text-lg font-bold text-gray-900">Company Information</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Company Name</label>
                <input type="text" name="company_name" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all" 
                       value="{{ $settings['company_name'] ?? 'B-Family Homes Limited' }}">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Company Email</label>
                <input type="email" name="company_email" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all" 
                       value="{{ $settings['company_email'] ?? '' }}">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Company Phone</label>
                <input type="tel" name="company_phone" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all" 
                       value="{{ $settings['company_phone'] ?? '' }}">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Company Address</label>
                <input type="text" name="company_address" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all" 
                       value="{{ $settings['company_address'] ?? '' }}">
            </div>
        </div>
    </div>

    <!-- Payment Settings -->
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
        <div class="flex items-center gap-2 mb-6">
            <div class="w-8 h-8 bg-orange-500/10 rounded-lg flex items-center justify-center">
                <i class="bi bi-credit-card text-orange-500 text-sm"></i>
            </div>
            <h2 class="text-lg font-bold text-gray-900">Payment Settings</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Bank Name</label>
                <input type="text" name="bank_name" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all" 
                       value="{{ $settings['bank_name'] ?? '' }}">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Account Number</label>
                <input type="text" name="bank_account_number" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all" 
                       value="{{ $settings['bank_account_number'] ?? '' }}">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Account Name</label>
                <input type="text" name="bank_account_name" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all" 
                       value="{{ $settings['bank_account_name'] ?? '' }}">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Investor Upgrade Amount (₦)</label>
                <input type="number" name="investor_upgrade_amount" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all" 
                       value="{{ $settings['investor_upgrade_amount'] ?? '1000000' }}" min="0" step="0.01">
            </div>
        </div>
        <div class="mt-6">
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Payment Instructions</label>
            <textarea name="payment_instructions" rows="5" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all">{{ $settings['payment_instructions'] ?? '' }}</textarea>
        </div>
    </div>

    <div class="flex gap-4">
        <button type="submit" class="px-4 py-2.5 bg-gradient-to-r from-orange-500 to-yellow-500 text-white rounded-lg hover:from-orange-600 hover:to-yellow-600 font-semibold transition-all text-sm shadow-sm flex items-center gap-2">
            <i class="bi bi-check-circle"></i>
            Save Settings
        </button>
        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-semibold transition-all text-sm">
            Cancel
        </a>
    </div>
</form>
@endsection

@push('scripts')
<script>
    document.getElementById('settingsForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const form = e.target;
        const submitBtn = form.querySelector('button[type="submit"]');
        const formData = new FormData(form);
        
        showLoader(submitBtn);
        
        try {
            const data = await window.ajax('{{ route("admin.settings.update") }}', 'POST', {
                company_name: formData.get('company_name'),
                company_email: formData.get('company_email'),
                company_phone: formData.get('company_phone'),
                company_address: formData.get('company_address'),
                bank_name: formData.get('bank_name'),
                bank_account_number: formData.get('bank_account_number'),
                bank_account_name: formData.get('bank_account_name'),
                investor_upgrade_amount: formData.get('investor_upgrade_amount'),
                payment_instructions: formData.get('payment_instructions'),
            });
            window.toast(data.message, 'success');
        } catch (error) {
            hideLoader(submitBtn);
            window.toast(error.message || 'Failed to update settings', 'error');
        }
    });
</script>
@endpush
