@extends('layouts.dashboard')

@section('title', 'My Payments')

@php
use Illuminate\Support\Str;
@endphp

@section('content')
<div class="mb-6">
    <div class="relative bg-gradient-to-br from-blue-900 via-blue-800 to-blue-900 rounded-2xl p-6 md:p-8 shadow-lg overflow-hidden">
        <div class="absolute -top-10 -right-10 w-48 h-48 bg-white/5 rounded-full"></div>
        <div class="absolute -bottom-10 -left-10 w-36 h-36 bg-white/5 rounded-full"></div>
        <div class="absolute top-1/2 right-1/3 w-20 h-20 bg-white/5 rounded-full"></div>

        <div class="relative flex flex-col md:flex-row md:items-center gap-4">
            <div class="w-14 h-14 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center shadow-sm flex-shrink-0 border border-white/10">
                <i class="bi bi-credit-card text-white text-2xl"></i>
            </div>
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-white">My Payments</h1>
                <p class="text-blue-100/80 text-sm mt-0.5">View and manage your payment transactions</p>
            </div>
        </div>
    </div>
</div>

<!-- Bank Details -->
<div class="bg-gradient-to-r from-orange-500 to-yellow-500 rounded-xl p-6 mb-6 shadow-sm">
    <h3 class="text-lg font-bold text-white mb-4">Bank Transfer Details</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 border border-white/10">
            <p class="text-sm text-white/70 mb-1">Bank Name</p>
            <p class="font-bold text-white">{{ $bankDetails['name'] }}</p>
        </div>
        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 border border-white/10">
            <p class="text-sm text-white/70 mb-1">Account Number</p>
            <p class="font-bold text-white">{{ $bankDetails['account_number'] }}</p>
        </div>
        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 border border-white/10">
            <p class="text-sm text-white/70 mb-1">Account Name</p>
            <p class="font-bold text-white">{{ $bankDetails['account_name'] }}</p>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
    @if($payments->count() > 0)
        <div class="overflow-x-auto -mx-6 px-6 w-[95%] mx-auto" style="-webkit-overflow-scrolling: touch;">
            <table class="w-full" style="min-width: 800px;">
                <thead class="border-b border-gray-200">
                    <tr>
                        <th class="text-left py-3 px-4 text-gray-600 font-semibold whitespace-nowrap text-sm">Reference</th>
                        <th class="text-left py-3 px-4 text-gray-600 font-semibold whitespace-nowrap text-sm">Property</th>
                        <th class="text-left py-3 px-4 text-gray-600 font-semibold whitespace-nowrap text-sm">Amount</th>
                        <th class="text-left py-3 px-4 text-gray-600 font-semibold whitespace-nowrap text-sm">Status</th>
                        <th class="text-left py-3 px-4 text-gray-600 font-semibold whitespace-nowrap text-sm">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                    <tr class="border-b border-gray-100 last:border-0 hover:bg-orange-50/50">
                        <td class="py-4 px-4 whitespace-nowrap">
                            <p class="font-mono text-sm text-gray-900">{{ $payment->reference }}</p>
                            <p class="text-xs text-gray-400">{{ $payment->created_at->format('M d, Y') }}</p>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <div class="flex items-start gap-3">
                                @if($payment->property->first_image)
                                <img src="{{ $payment->property->first_image }}" 
                                     alt="{{ $payment->property->title }}"
                                     class="w-16 h-16 object-cover rounded-lg ring-2 ring-gray-100">
                                @endif
                                <div>
                                    <h4 class="font-semibold text-gray-900 text-sm mb-1">{{ $payment->property->title }}</h4>
                                    <p class="text-sm text-gray-500 mb-1">{{ ucfirst($payment->type) }}</p>
                                    @if($payment->installment_number && $payment->total_installments)
                                        <p class="text-xs text-gray-400">
                                            Installment {{ $payment->installment_number }} of {{ $payment->total_installments }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <p class="font-bold text-gray-900">{{ $payment->formatted_amount }}</p>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            @if($payment->status === 'pending')
                                @if($payment->proof_file)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold bg-blue-100 text-blue-700">
                                        <i class="bi bi-clock-history"></i> Awaiting Verification
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold bg-yellow-100 text-yellow-700">
                                        <i class="bi bi-hourglass-split"></i> Pending
                                    </span>
                                @endif
                            @elseif($payment->status === 'approved')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold bg-green-100 text-green-700">
                                    <i class="bi bi-check-circle"></i> Confirmed
                                </span>
                            @elseif($payment->status === 'rejected')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold bg-red-100 text-red-700">
                                    <i class="bi bi-x-circle"></i> Rejected
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <div class="flex flex-col gap-2">
                                @if($payment->status === 'pending')
                                    @if(!$payment->proof_file)
                                        <button onclick="openUploadModal({{ $payment->id }})" 
                                                class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-orange-500 to-yellow-500 text-white rounded-xl hover:from-orange-600 hover:to-yellow-600 font-semibold transition-all text-xs shadow-sm">
                                            <i class="bi bi-upload"></i>
                                            Upload Proof
                                        </button>
                                        <a href="{{ route('payments.instructions', $payment->id) }}" 
                                           class="text-orange-600 hover:text-orange-700 text-xs font-semibold text-center">
                                            View Instructions
                                        </a>
                                    @else
                                        <span class="inline-flex items-center gap-2 px-2.5 py-1 rounded-lg text-xs font-semibold bg-blue-100 text-blue-700">
                                            <i class="bi bi-clock-history"></i> Awaiting Verification
                                        </span>
                                        <button onclick="sendProofToWhatsApp({{ $payment->id }})" 
                                                class="text-green-600 hover:text-green-700 text-xs font-semibold"
                                                title="Send proof via WhatsApp">
                                            <i class="bi bi-whatsapp"></i> Send via WhatsApp
                                        </button>
                                    @endif
                                @elseif($payment->status === 'approved')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold bg-green-100 text-green-700">
                                        <i class="bi bi-check-circle"></i> Confirmed
                                    </span>
                                    @if($payment->receipt && $payment->receipt->file_path)
                                        <a href="{{ asset('storage/' . $payment->receipt->file_path) }}" target="_blank" 
                                           class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold bg-blue-100 text-blue-700 hover:bg-blue-200 transition-colors">
                                            <i class="bi bi-receipt"></i> Download Receipt
                                        </a>
                                    @endif
                                    @if($payment->installment_number && $payment->total_installments)
                                        @if($payment->installment_number < $payment->total_installments)
                                            <a href="{{ route('properties.show', $payment->property_id) }}" 
                                               class="text-orange-600 hover:text-orange-700 text-xs font-semibold mt-1">
                                                Pay Next Installment
                                            </a>
                                        @endif
                                    @endif
                                @elseif($payment->status === 'rejected')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold bg-red-100 text-red-700 mb-2">
                                        <i class="bi bi-x-circle"></i> Rejected
                                    </span>
                                    @if($payment->admin_notes)
                                        <p class="text-xs text-red-600 mt-1">{{ Str::limit($payment->admin_notes, 50) }}</p>
                                    @endif
                                    <button onclick="openUploadModal({{ $payment->id }})" 
                                            class="text-orange-600 hover:text-orange-700 text-xs font-semibold mt-1">
                                        Re-upload Proof
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $payments->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <i class="bi bi-credit-card-2-front text-6xl text-gray-200 mb-4"></i>
            <h3 class="text-xl font-bold text-gray-900 mb-2">No Payments Yet</h3>
            <p class="text-gray-500 mb-6 text-sm">Start exploring properties to make your first transaction</p>
            <a href="{{ route('properties.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-orange-500 to-yellow-500 text-white rounded-xl hover:from-orange-600 hover:to-yellow-600 font-semibold transition-all text-sm shadow-sm">
                Browse Properties
            </a>
        </div>
    @endif
</div>

<!-- Upload Proof Modal -->
<div id="uploadModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-xl border border-gray-100 shadow-lg max-w-md w-full p-6">
        <h3 class="text-xl font-bold text-gray-900 mb-4">Upload Payment Proof</h3>
        
        <form id="uploadProofForm" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <input type="hidden" id="paymentId" name="payment_id">
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Select File (JPG, PNG or PDF)</label>
                <input type="file" name="proof" accept=".jpg,.jpeg,.png,.pdf" 
                       class="w-full px-4 py-2.5 border border-gray-200 rounded-xl file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-orange-500/10 file:text-orange-600 hover:file:bg-orange-500/20 focus:ring-2 focus:ring-orange-500 focus:border-orange-500" required>
                <p class="text-xs text-gray-400 mt-1">Max file size: 5MB</p>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="flex-1 px-5 py-2.5 bg-gradient-to-r from-orange-500 to-yellow-500 text-white rounded-xl hover:from-orange-600 hover:to-yellow-600 font-semibold transition-all text-sm shadow-sm inline-flex items-center justify-center gap-2">
                    <i class="bi bi-upload"></i>
                    Upload
                </button>
                <button type="button" onclick="closeUploadModal()" class="flex-1 px-5 py-2.5 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 font-semibold transition-all text-sm">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openUploadModal(paymentId) {
        document.getElementById('paymentId').value = paymentId;
        document.getElementById('uploadModal').classList.remove('hidden');
    }

    function closeUploadModal() {
        document.getElementById('uploadModal').classList.add('hidden');
        document.getElementById('uploadProofForm').reset();
    }

    document.getElementById('uploadProofForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const form = e.target;
        const submitBtn = form.querySelector('button[type="submit"]');
        const formData = new FormData(form);
        const paymentId = formData.get('payment_id');
        
        showLoader(submitBtn);
        
        try {
            const data = await window.ajax(
                `{{ route("payments.upload-proof") }}`, 
                'POST', 
                formData
            );
            
            window.toast(data.message, 'success');
            closeUploadModal();
            setTimeout(() => window.location.reload(), 1500);
        } catch (error) {
            hideLoader(submitBtn);
            window.toast(error.message || 'Failed to upload proof', 'error');
        }
    });

    function sendProofToWhatsApp(paymentId) {
        const payment = @json($payments->items());
        const paymentData = payment.find(p => p.id === paymentId);
        
        if (!paymentData || !paymentData.proof_file) {
            window.toast('Payment proof not found', 'error');
            return;
        }

        const proofUrl = '{{ url("/storage") }}/' + paymentData.proof_file;
        const message = `Payment Proof for Payment Reference: ${paymentData.reference}\n\n` +
                       `Property: ${paymentData.property.title}\n` +
                       `Amount: ${paymentData.formatted_amount}\n` +
                       `Proof: ${proofUrl}`;
        
        const whatsappNumber = '{{ config("bfamily.company.whatsapp") }}';
        window.sendToWhatsApp(whatsappNumber, message);
    }
</script>
@endpush
