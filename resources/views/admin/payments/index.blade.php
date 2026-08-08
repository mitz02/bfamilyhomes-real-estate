@extends('layouts.admin')

@section('title', 'Manage Payments')

@section('content')
<div class="mb-8">
    <div class="flex items-center gap-2 text-xs md:text-sm text-gray-500 mb-4 px-2 md:px-0">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-orange-600 transition-colors">
            <i class="bi bi-house-door mr-1"></i>B-Family
        </a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-orange-600 font-semibold">Manage Payments</span>
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
                    <i class="bi bi-credit-card-2-front text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-bold text-white">Manage Payments</h1>
                    <p class="text-blue-100/80 text-sm mt-0.5">{{ $greeting }}, {{ auth()->user()->name }}!</p>
                    <p class="text-blue-300/60 text-xs mt-0.5">{{ now()->format('l, F j, Y') }}</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/10 backdrop-blur-sm rounded-lg text-white/80 text-xs border border-white/10">
                    <i class="bi bi-credit-card"></i>
                    {{ $payments->count() }} Total
                </span>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl border border-gray-100 shadow-sm mx-1 md:mx-0">
    @if($payments->count() > 0)
        <div class="overflow-x-auto p-6" style="-webkit-overflow-scrolling: touch;">
            <table class="w-full" style="min-width: 1000px;">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Reference</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">User</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Property</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Amount</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Type</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Status</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                    <tr class="border-b border-gray-50 last:border-0 hover:bg-gray-50/50 transition-colors">
                        <td class="py-4 px-4 whitespace-nowrap">
                            <p class="font-mono text-sm text-gray-900">{{ $payment->reference }}</p>
                            <p class="text-xs text-gray-500">{{ $payment->created_at->format('M d, Y') }}</p>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <p class="font-semibold text-gray-900 text-sm">{{ $payment->buyer_name }}</p>
                            <p class="text-xs text-gray-500">{{ $payment->buyer_email ?? '—' }}</p>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <div class="flex items-start gap-3">
                                @if($payment->property->first_image)
                                <img src="{{ $payment->property->first_image }}" 
                                     alt="{{ $payment->property->title }}"
                                     class="w-14 h-14 object-cover rounded-lg ring-2 ring-gray-100">
                                @endif
                                <div>
                                    <h4 class="font-semibold text-gray-900 text-sm">{{ Str::limit($payment->property->title, 30) }}</h4>
                                    <p class="text-xs text-gray-500">{{ $payment->property->location }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <p class="font-bold text-gray-900">{{ $payment->formatted_amount }}</p>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-gray-100 text-gray-700 mb-1">{{ ucfirst($payment->type) }}</span>
                            @if($payment->schedule && $payment->schedule !== 'One-time')
                                <p class="text-xs text-gray-500">{{ $payment->schedule }}</p>
                            @endif
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            @if($payment->status === 'pending')
                                @if($payment->proof_file)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-blue-100 text-blue-700">
                                        <i class="bi bi-clock-history mr-1"></i> Awaiting Verification
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-yellow-100 text-yellow-700">
                                        <i class="bi bi-hourglass-split mr-1"></i> Pending
                                    </span>
                                @endif
                            @elseif($payment->status === 'approved')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-green-100 text-green-700">
                                    <i class="bi bi-check-circle mr-1"></i> Confirmed
                                </span>
                                @if($payment->approved_at)
                                    <p class="text-xs text-gray-500 mt-1">Approved {{ $payment->approved_at->diffForHumans() }}</p>
                                @endif
                            @elseif($payment->status === 'rejected')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-red-100 text-red-700">
                                    <i class="bi bi-x-circle mr-1"></i> Rejected
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <div class="relative action-menu">
                                <button onclick="toggleActionMenu(this)" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 transition-colors">
                                    <i class="bi bi-three-dots-vertical text-gray-400"></i>
                                </button>
                                <div class="hidden absolute right-0 top-full mt-1 bg-white rounded-xl border border-gray-100 shadow-lg py-1 min-w-[170px] z-50">
                                    @if($payment->proof_file)
                                    <a href="{{ asset('storage/' . $payment->proof_file) }}" target="_blank" 
                                       class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                        <i class="bi bi-file-earmark-image text-gray-400"></i> View Proof
                                    </a>
                                    @else
                                    <span class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-400">
                                        <i class="bi bi-file-earmark-image"></i> No Proof
                                    </span>
                                    @endif

                                    @if($payment->status === 'approved' && $payment->receipt && $payment->receipt->file_path)
                                    <a href="{{ asset('storage/' . $payment->receipt->file_path) }}" target="_blank" 
                                       class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-blue-700 hover:bg-blue-50 transition-colors">
                                        <i class="bi bi-receipt text-gray-400"></i> Download Receipt
                                    </a>
                                    <div class="border-t border-gray-50 my-1"></div>
                                    @endif

                                    @if($payment->status === 'pending')
                                    <div class="border-t border-gray-50 my-1"></div>
                                    <button onclick="approvePayment({{ $payment->id }})" 
                                            class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-green-700 hover:bg-green-50 transition-colors text-left">
                                        <i class="bi bi-check-circle"></i> Confirm Payment
                                    </button>
                                    <button onclick="rejectPayment({{ $payment->id }})" 
                                            class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-red-700 hover:bg-red-50 transition-colors text-left">
                                        <i class="bi bi-x-circle"></i> Reject Payment
                                    </button>
                                    @endif

                                    @if($payment->installment_number && $payment->total_installments)
                                    <div class="border-t border-gray-50 my-1 px-4 py-2 text-xs text-gray-500">
                                        Installment {{ $payment->installment_number }} of {{ $payment->total_installments }}
                                    </div>
                                    @endif

                                    <div class="border-t border-gray-50 my-1"></div>
                                    <button onclick="deletePayment({{ $payment->id }})" 
                                            class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-red-700 hover:bg-red-50 transition-colors text-left">
                                        <i class="bi bi-trash"></i> Delete Payment
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="px-6 pb-6">
            {{ $payments->links() }}
        </div>
    @else
        <div class="text-center py-16">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="bi bi-credit-card text-3xl text-gray-300"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-1">No Payments</h3>
            <p class="text-sm text-gray-500">No payments have been submitted yet</p>
        </div>
    @endif
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                <i class="bi bi-x-circle text-red-600"></i>
            </div>
            <div>
                <h3 class="font-bold text-gray-900">Reject Payment</h3>
                <p class="text-sm text-gray-500">Provide a reason for rejection</p>
            </div>
        </div>
        <form id="rejectForm" class="space-y-4">
            @csrf
            <input type="hidden" id="rejectPaymentId" name="payment_id">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Rejection Reason *</label>
                <textarea id="rejectionReason" name="admin_notes" rows="4" 
                          class="w-full border border-gray-200 rounded-lg p-3 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all" required></textarea>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="flex-1 px-4 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 font-semibold transition-all text-sm">
                    Reject Payment
                </button>
                <button type="button" onclick="closeRejectModal()" class="flex-1 px-4 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-semibold transition-all text-sm">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function toggleActionMenu(btn) {
        var menu = btn.nextElementSibling;
        var isHidden = menu.classList.contains('hidden');
        closeAllMenus();
        if (isHidden) {
            menu.classList.remove('hidden');
        }
    }

    function closeAllMenus() {
        document.querySelectorAll('.action-menu > div:last-child').forEach(function(m) {
            m.classList.add('hidden');
        });
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.action-menu')) {
            closeAllMenus();
        }
    });

    async function approvePayment(id) {
        if (!confirm('Are you sure you want to approve this payment?')) return;
        
        try {
            const data = await window.ajax(`{{ route("admin.payments.approve", ":id") }}`.replace(':id', id), 'POST');
            window.toast(data.message, 'success');
            setTimeout(() => window.location.reload(), 1000);
        } catch (error) {
            window.toast(error.message || 'Failed to approve payment', 'error');
        }
    }

    function rejectPayment(id) {
        document.getElementById('rejectPaymentId').value = id;
        document.getElementById('rejectModal').classList.remove('hidden');
    }

    async function deletePayment(id) {
        if (!confirm('Are you sure you want to delete this payment? This will remove its receipt and revert any linked property/investment changes.')) return;

        try {
            const data = await window.ajax(`{{ route("admin.payments.destroy", ":id") }}`.replace(':id', id), 'DELETE');
            window.toast(data.message, 'success');
            setTimeout(() => window.location.reload(), 1000);
        } catch (error) {
            window.toast(error.message || 'Failed to delete payment', 'error');
        }
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
        document.getElementById('rejectForm').reset();
    }

    document.getElementById('rejectForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const form = e.target;
        const submitBtn = form.querySelector('button[type="submit"]');
        const formData = new FormData(form);
        
        showLoader(submitBtn);
        
        try {
            const paymentId = formData.get('payment_id');
            const data = await window.ajax(`{{ route("admin.payments.reject", ":id") }}`.replace(':id', paymentId), 'POST', {
                admin_notes: formData.get('admin_notes'),
            });
            window.toast(data.message, 'success');
            closeRejectModal();
            setTimeout(() => window.location.reload(), 1000);
        } catch (error) {
            hideLoader(submitBtn);
            window.toast(error.message || 'Failed to reject payment', 'error');
        }
    });
</script>
@endpush
