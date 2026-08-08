@extends('layouts.investor')

@section('title', 'Investment Instructions')

@section('content')
<div class="mb-8">
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
                    <i class="bi bi-info-circle text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-bold text-white">Investment Instructions</h1>
                    <p class="text-blue-100/80 text-sm mt-0.5">{{ $greeting }}, {{ auth()->user()->name }}!</p>
                    <p class="text-blue-300/60 text-xs mt-0.5">{{ now()->format('l, F j, Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mx-1 md:mx-0">
    <!-- Investment Reference Card -->
    <div class="bg-gradient-to-br from-blue-900 to-blue-800 rounded-xl p-6 mb-6 text-white shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-blue-200 mb-2">Investment Reference</p>
                <p class="text-3xl font-bold font-mono">{{ $investment->reference }}</p>
                <p class="text-sm text-blue-200 mt-2">Keep this reference for your records</p>
            </div>
            <button onclick="copyReference('{{ $investment->reference }}')" 
                    class="w-12 h-12 bg-white/10 hover:bg-white/20 rounded-lg flex items-center justify-center transition-colors backdrop-blur-sm border border-white/10">
                <i class="bi bi-copy text-xl"></i>
            </button>
        </div>
    </div>

    <!-- Investment Summary Card -->
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 mb-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Investment Summary</h3>
        <div class="flex items-start gap-4 mb-4">
            @if($investment->property->first_image)
            <img src="{{ $investment->property->first_image }}" 
                 alt="{{ $investment->property->title }}"
                 class="w-24 h-24 object-cover rounded-xl ring-2 ring-gray-100">
            @endif
            <div class="flex-1">
                <h4 class="font-bold text-gray-900 mb-1">{{ $investment->property->title }}</h4>
                <p class="text-sm text-gray-500">{{ $investment->property->location }}</p>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-gray-50 rounded-xl p-4">
                <p class="text-xs text-gray-500 mb-1">Investment Amount</p>
                <p class="text-xl font-bold text-gray-900">{{ $investment->formatted_amount }}</p>
            </div>
            <div class="bg-gray-50 rounded-xl p-4">
                <p class="text-xs text-gray-500 mb-1">Duration</p>
                <p class="text-xl font-bold text-gray-900">{{ $investment->duration_months }} Months</p>
            </div>
            <div class="bg-gray-50 rounded-xl p-4">
                <p class="text-xs text-gray-500 mb-1">ROI Percentage</p>
                <p class="text-xl font-bold text-orange-600">{{ number_format($investment->roi_percentage, 2) }}%</p>
            </div>
            <div class="bg-gray-50 rounded-xl p-4">
                <p class="text-xs text-gray-500 mb-1">Expected Return</p>
                <p class="text-xl font-bold text-green-600">₦{{ number_format($investment->total_return, 2) }}</p>
            </div>
        </div>
    </div>

    <!-- Payment Reference Card -->
    @if($investment->payment)
    <div class="bg-gradient-to-br from-green-50 to-green-100/50 rounded-xl p-6 mb-6 border border-green-200">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center">
                    <i class="bi bi-check-circle text-white text-sm"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Payment Reference</h3>
            </div>
            <button onclick="copyPaymentReference('{{ $investment->payment->reference }}')" 
                    class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold transition-all text-sm flex items-center gap-2 shadow-sm">
                <i class="bi bi-copy"></i>
                Copy Reference
            </button>
        </div>
        
        <div class="bg-white rounded-xl p-4 shadow-sm border border-blue-200">
            <p class="text-xs text-gray-500 mb-1">Payment Reference (Mandatory)</p>
            <p class="font-bold text-orange-600 text-xl font-mono" id="paymentRef">{{ $investment->payment->reference }}</p>
            <p class="text-xs text-gray-500 mt-2">⚠️ You must include this reference in your transfer</p>
        </div>
    </div>
    @endif

    <!-- Bank Details Card -->
    <div class="bg-gradient-to-br from-green-50 to-green-100/50 rounded-xl p-6 mb-6 border border-green-200">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center">
                    <i class="bi bi-bank text-white text-sm"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Bank Transfer Details</h3>
            </div>
            <button onclick="copyBankDetails()" 
                    class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold transition-all text-sm flex items-center gap-2 shadow-sm">
                <i class="bi bi-copy"></i>
                Copy All
            </button>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white rounded-xl p-4 shadow-sm">
                <p class="text-xs text-gray-500 mb-1">Bank Name</p>
                <p class="font-bold text-gray-900" id="bankName">{{ $bankDetails['name'] }}</p>
            </div>
            <div class="bg-white rounded-xl p-4 shadow-sm">
                <p class="text-xs text-gray-500 mb-1">Account Number</p>
                <p class="font-bold text-gray-900 font-mono" id="accountNumber">{{ $bankDetails['account_number'] }}</p>
            </div>
            <div class="bg-white rounded-xl p-4 shadow-sm">
                <p class="text-xs text-gray-500 mb-1">Account Name</p>
                <p class="font-bold text-gray-900" id="accountName">{{ $bankDetails['account_name'] }}</p>
            </div>
        </div>
    </div>

    <!-- Instructions Card -->
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 mb-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Payment Instructions</h3>
        <div class="space-y-4">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 bg-orange-500/10 rounded-lg flex items-center justify-center flex-shrink-0">
                    <span class="text-orange-600 font-bold text-sm">1</span>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900 mb-1">Make Bank Transfer</h4>
                    <p class="text-gray-600 text-sm">Transfer the investment amount <strong>{{ $investment->formatted_amount }}</strong> to the bank account details above.</p>
                </div>
            </div>
            
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 bg-orange-500/10 rounded-lg flex items-center justify-center flex-shrink-0">
                    <span class="text-orange-600 font-bold text-sm">2</span>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900 mb-1">Include Payment Reference</h4>
                    <p class="text-gray-600 text-sm">When making the transfer, <strong>include the payment reference: {{ $investment->payment->reference ?? 'N/A' }}</strong> in the transfer description/note.</p>
                </div>
            </div>
            
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 bg-orange-500/10 rounded-lg flex items-center justify-center flex-shrink-0">
                    <span class="text-orange-600 font-bold text-sm">3</span>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900 mb-1">Upload Proof of Payment</h4>
                    <p class="text-gray-600 text-sm">After making the transfer, go to <strong>Payments</strong> in your dashboard and upload a screenshot or PDF of your transfer receipt.</p>
                </div>
            </div>
            
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 bg-orange-500/10 rounded-lg flex items-center justify-center flex-shrink-0">
                    <span class="text-orange-600 font-bold text-sm">4</span>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900 mb-1">Wait for Verification</h4>
                    <p class="text-gray-600 text-sm">Our admin will verify your payment. Once confirmed, your investment will be activated and ROI tracking will begin.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex flex-col sm:flex-row gap-4">
        <a href="{{ route('payments.index') }}" 
           class="flex-1 px-4 py-2.5 bg-gradient-to-r from-orange-500 to-yellow-500 text-white rounded-lg hover:from-orange-600 hover:to-yellow-600 font-semibold transition-all text-sm shadow-sm flex items-center justify-center gap-2">
            <i class="bi bi-credit-card"></i>
            View Payments & Upload Proof
        </a>
        <a href="{{ route('investor.investments') }}" 
           class="flex-1 px-4 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-semibold transition-all text-sm flex items-center justify-center gap-2">
            <i class="bi bi-arrow-left"></i>
            Back to Investments
        </a>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function copyReference(reference) {
        navigator.clipboard.writeText(reference).then(() => {
            window.toast('Investment reference copied to clipboard!', 'success');
        });
    }

    function copyPaymentReference(reference) {
        navigator.clipboard.writeText(reference).then(() => {
            window.toast('Payment reference copied to clipboard!', 'success');
        });
    }

    function copyBankDetails() {
        const bankDetails = `Bank Name: {{ $bankDetails['name'] }}\nAccount Number: {{ $bankDetails['account_number'] }}\nAccount Name: {{ $bankDetails['account_name'] }}\nPayment Reference: {{ $investment->payment->reference ?? 'N/A' }}`;
        
        navigator.clipboard.writeText(bankDetails).then(() => {
            window.toast('Bank details copied to clipboard!', 'success');
        });
    }
</script>
@endpush
