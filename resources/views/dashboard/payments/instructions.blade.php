@extends('layouts.dashboard')

@section('title', 'Payment Instructions')

@section('content')
<div class="mb-6">
    <div class="relative bg-gradient-to-br from-blue-900 via-blue-800 to-blue-900 rounded-2xl p-6 md:p-8 shadow-lg overflow-hidden">
        <div class="absolute -top-10 -right-10 w-48 h-48 bg-white/5 rounded-full"></div>
        <div class="absolute -bottom-10 -left-10 w-36 h-36 bg-white/5 rounded-full"></div>
        <div class="absolute top-1/2 right-1/3 w-20 h-20 bg-white/5 rounded-full"></div>

        <div class="relative flex flex-col md:flex-row md:items-center gap-4">
            <div class="w-14 h-14 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center shadow-sm flex-shrink-0 border border-white/10">
                <i class="bi bi-info-circle text-white text-2xl"></i>
            </div>
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-white">Payment Instructions</h1>
                <p class="text-blue-100/80 text-sm mt-0.5">Follow these instructions to complete your payment</p>
            </div>
        </div>
    </div>
</div>

<!-- Payment Reference Card -->
<div class="bg-gradient-to-r from-orange-500 to-yellow-500 rounded-xl p-6 mb-6 shadow-sm">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-white/70 mb-2">Payment Reference</p>
            <p class="text-3xl font-bold font-mono text-white">{{ $payment->reference }}</p>
            <p class="text-sm text-white/60 mt-2">Keep this reference for your records</p>
        </div>
        <button onclick="copyReference('{{ $payment->reference }}')" 
                class="w-12 h-12 bg-white/20 hover:bg-white/30 rounded-lg flex items-center justify-center transition-colors backdrop-blur-sm border border-white/10">
            <i class="bi bi-copy text-xl text-white"></i>
        </button>
    </div>
</div>

<!-- Property Info Card -->
<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 mb-6">
    <h3 class="text-lg font-bold text-gray-900 mb-4">Property Details</h3>
    <div class="flex items-start gap-4">
        @if($payment->property->first_image)
        <img src="{{ $payment->property->first_image }}" 
             alt="{{ $payment->property->title }}"
             class="w-24 h-24 object-cover rounded-lg ring-2 ring-gray-100">
        @endif
        <div class="flex-1">
            <h4 class="font-bold text-gray-900 text-lg mb-1">{{ $payment->property->title }}</h4>
            <p class="text-sm text-gray-500 mb-2">{{ $payment->property->location }}</p>
            <div class="flex items-center gap-4 text-sm">
                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-orange-100 text-orange-700">{{ ucfirst($payment->type) }}</span>
                <span class="text-gray-500">Amount: <strong class="text-gray-900">{{ $payment->formatted_amount }}</strong></span>
            </div>
        </div>
    </div>
</div>

<!-- Bank Details Card -->
<div class="bg-white rounded-xl border border-green-100 shadow-sm p-6 mb-6 bg-gradient-to-br from-green-50 to-green-100/50">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-bold text-gray-900">Bank Transfer Details</h3>
        <button onclick="copyBankDetails()" 
                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-xl font-semibold transition-all text-sm flex items-center gap-2 shadow-sm">
            <i class="bi bi-copy"></i>
            Copy All
        </button>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-100">
            <p class="text-sm text-gray-500 mb-1">Bank Name</p>
            <p class="font-bold text-gray-900 text-lg" id="bankName">{{ $bankDetails['name'] }}</p>
        </div>
        <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-100">
            <p class="text-sm text-gray-500 mb-1">Account Number</p>
            <p class="font-bold text-gray-900 text-lg font-mono" id="accountNumber">{{ $bankDetails['account_number'] }}</p>
        </div>
        <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-100">
            <p class="text-sm text-gray-500 mb-1">Account Name</p>
            <p class="font-bold text-gray-900 text-lg" id="accountName">{{ $bankDetails['account_name'] }}</p>
        </div>
    </div>

    <!-- Payment Reference Display -->
    <div class="bg-white rounded-lg p-4 shadow-sm border-2 border-orange-200">
        <p class="text-sm text-gray-500 mb-1">Payment Reference (Mandatory)</p>
        <p class="font-bold text-orange-600 text-xl font-mono" id="paymentRef">{{ $payment->reference }}</p>
        <p class="text-xs text-gray-400 mt-2">⚠️ You must include this reference in your transfer</p>
    </div>
</div>

<!-- Instructions -->
<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 mb-6">
    <h3 class="text-lg font-bold text-gray-900 mb-4">Payment Instructions</h3>
    <div class="space-y-4">
        <div class="flex items-start gap-3">
            <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0">
                <span class="text-orange-600 font-bold text-sm">1</span>
            </div>
            <div>
                <h4 class="font-semibold text-gray-900 text-sm mb-1">Make Bank Transfer</h4>
                <p class="text-gray-500 text-sm">Transfer the amount <strong class="text-gray-900">{{ $payment->formatted_amount }}</strong> to the bank account details above.</p>
            </div>
        </div>
        
        <div class="flex items-start gap-3">
            <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0">
                <span class="text-orange-600 font-bold text-sm">2</span>
            </div>
            <div>
                <h4 class="font-semibold text-gray-900 text-sm mb-1">Include Payment Reference</h4>
                <p class="text-gray-500 text-sm">When making the transfer, <strong class="text-gray-900">include the payment reference: {{ $payment->reference }}</strong> in the transfer description/note.</p>
            </div>
        </div>
        
        <div class="flex items-start gap-3">
            <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0">
                <span class="text-orange-600 font-bold text-sm">3</span>
            </div>
            <div>
                <h4 class="font-semibold text-gray-900 text-sm mb-1">Upload Proof of Payment</h4>
                <p class="text-gray-500 text-sm">After making the transfer, go to <strong class="text-gray-900">Payments</strong> in your dashboard and upload a screenshot or PDF of your transfer receipt.</p>
            </div>
        </div>
        
        <div class="flex items-start gap-3">
            <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0">
                <span class="text-orange-600 font-bold text-sm">4</span>
            </div>
            <div>
                <h4 class="font-semibold text-gray-900 text-sm mb-1">Wait for Verification</h4>
                <p class="text-gray-500 text-sm">Our admin will verify your payment and update the status. You'll be notified once it's confirmed.</p>
            </div>
        </div>
    </div>
</div>

<!-- Action Buttons -->
<div class="flex flex-col sm:flex-row gap-4">
    <a href="{{ route('payments.index') }}" 
       class="flex-1 px-5 py-3 bg-gradient-to-r from-orange-500 to-yellow-500 text-white rounded-xl hover:from-orange-600 hover:to-yellow-600 font-semibold transition-all text-sm shadow-sm inline-flex items-center justify-center gap-2">
        <i class="bi bi-credit-card"></i>
        View All Payments
    </a>
    <a href="{{ route('properties.show', $payment->property_id) }}" 
       class="flex-1 px-5 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 font-semibold transition-all text-sm inline-flex items-center justify-center gap-2">
        <i class="bi bi-arrow-left"></i>
        Back to Property
    </a>
</div>
@endsection

@push('scripts')
<script>
    function copyReference(reference) {
        navigator.clipboard.writeText(reference).then(() => {
            window.toast('Payment reference copied to clipboard!', 'success');
        });
    }

    function copyBankDetails() {
        const bankDetails = `Bank Name: {{ $bankDetails['name'] }}\nAccount Number: {{ $bankDetails['account_number'] }}\nAccount Name: {{ $bankDetails['account_name'] }}\nPayment Reference: {{ $payment->reference }}`;
        
        navigator.clipboard.writeText(bankDetails).then(() => {
            window.toast('Bank details copied to clipboard!', 'success');
        });
    }
</script>
@endpush
