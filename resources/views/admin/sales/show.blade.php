@extends('layouts.admin')

@section('title', 'Sale Details')

@php
    $shareUrl = $payment->receipt?->file_path ? asset('storage/' . $payment->receipt->file_path) : null;
    $shareTitle = $payment->receipt ? ('Receipt ' . $payment->receipt->receipt_number . ' - ' . config('bfamily.company.name')) : 'Payment Receipt - ' . config('bfamily.company.name');
    $shareBody = ($payment->receipt ? ('Receipt: ' . $payment->receipt->receipt_number . "\n") : '') .
        config('bfamily.company.name') . "\n" .
        'Amount: ' . $payment->formatted_amount . "\n" .
        'Property: ' . $payment->property->title . "\n" .
        'Buyer: ' . $payment->buyer_name . "\n" .
        $shareUrl;
    $mailUrl = 'mailto:?subject=' . rawurlencode($shareTitle) . '&body=' . rawurlencode($shareBody);
@endphp

@section('content')
<div class="mb-8">
    <div class="flex items-center gap-2 text-xs md:text-sm text-gray-500 mb-4 px-2 md:px-0">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-orange-600 transition-colors">
            <i class="bi bi-house-door mr-1"></i>B-Family
        </a>
        <i class="bi bi-chevron-right text-xs"></i>
        <a href="{{ route('admin.sales') }}" class="hover:text-orange-600 transition-colors">Sales</a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-orange-600 font-semibold">#{{ $payment->receipt?->receipt_number ?? $payment->reference }}</span>
    </div>

    <div class="relative bg-gradient-to-br from-blue-900 via-blue-800 to-blue-900 rounded-2xl p-6 md:p-8 shadow-lg overflow-hidden">
        <div class="absolute -top-10 -right-10 w-48 h-48 bg-white/5 rounded-full"></div>
        <div class="absolute -bottom-10 -left-10 w-36 h-36 bg-white/5 rounded-full"></div>

        <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-start gap-4">
                <div class="w-14 h-14 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center shadow-sm flex-shrink-0 border border-white/10">
                    <i class="bi bi-receipt text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-bold text-white">Sale Details</h1>
                    <p class="text-blue-100/80 text-sm mt-0.5">Receipt: {{ $payment->receipt?->receipt_number ?? 'N/A' }}</p>
                </div>
            </div>
            <div class="flex items-center gap-2 flex-wrap">
                <a href="{{ route('admin.sales.receipt.print', $payment) }}" target="_blank"
                   class="inline-flex items-center gap-1.5 px-4 py-2 bg-white text-orange-600 rounded-lg hover:bg-orange-50 font-semibold transition-all text-sm shadow-sm">
                    <i class="bi bi-printer"></i>
                    Print Receipt
                </a>
                @if($payment->receipt?->file_path)
                <a href="{{ route('admin.sales.receipt.download', $payment) }}" target="_blank"
                   class="inline-flex items-center gap-1.5 px-4 py-2 bg-white text-blue-900 rounded-lg hover:bg-blue-50 font-semibold transition-all text-sm shadow-sm">
                    <i class="bi bi-download"></i>
                    Download Receipt
                </a>
                <div class="relative">
                    <button onclick="toggleShareMenu()" type="button"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-white text-blue-900 rounded-lg hover:bg-blue-50 font-semibold transition-all text-sm shadow-sm">
                        <i class="bi bi-share-fill"></i>
                        Share
                    </button>
                    <div id="shareMenu" class="hidden absolute right-0 top-full mt-2 bg-white rounded-xl border border-gray-100 shadow-lg py-1 min-w-[230px] z-50">
                        <div class="flex items-center justify-between px-3 py-2 border-b border-gray-50">
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Share Receipt</span>
                            <button type="button" onclick="toggleShareMenu()" class="w-6 h-6 flex items-center justify-center rounded-md hover:bg-gray-100 text-gray-400 hover:text-gray-700 transition-colors">
                                <i class="bi bi-x-lg text-sm"></i>
                            </button>
                        </div>
                        <button type="button" onclick="shareReceiptImage({{ $payment->id }}, '{{ $payment->receipt->receipt_number }}')"
                                class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors text-left">
                            <i class="bi bi-whatsapp text-green-500"></i> WhatsApp (Image)
                        </button>
                        <a href="{{ $mailUrl }}" onclick="closeShareMenu()"
                           class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                            <i class="bi bi-envelope-fill text-blue-500"></i> Email
                        </a>
                        <button type="button" onclick="copyReceiptLink('{{ $shareUrl }}')"
                                class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors text-left">
                            <i class="bi bi-link-45deg text-gray-500"></i> Copy Link
                        </button>
                        <button type="button" onclick="shareReceiptFile('{{ $shareUrl }}', '{{ $shareTitle }}')"
                                class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors text-left">
                            <i class="bi bi-share text-orange-500"></i> Share PDF File
                        </button>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Sale Information -->
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
        <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
            <i class="bi bi-info-circle text-orange-500"></i>
            Sale Information
        </h3>
        <dl class="space-y-3">
            <div class="flex justify-between">
                <dt class="text-sm text-gray-500">Receipt Number</dt>
                <dd class="text-sm font-semibold text-gray-900">{{ $payment->receipt?->receipt_number ?? 'N/A' }}</dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-sm text-gray-500">Payment Reference</dt>
                <dd class="text-sm font-mono font-semibold text-gray-900">{{ $payment->reference }}</dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-sm text-gray-500">Sale Date</dt>
                <dd class="text-sm font-semibold text-gray-900">{{ $payment->sale_date ? $payment->sale_date->format('M d, Y h:i A') : 'N/A' }}</dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-sm text-gray-500">Amount</dt>
                <dd class="text-sm font-bold text-gray-900">{{ $payment->formatted_amount }}</dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-sm text-gray-500">Payment Method</dt>
                <dd class="text-sm font-semibold text-gray-900 capitalize">{{ $payment->payment_method ? str_replace('_', ' ', $payment->payment_method) : 'Bank Transfer' }}</dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-sm text-gray-500">Sale Type</dt>
                <dd class="text-sm font-semibold text-gray-900 capitalize">{{ $payment->type }}</dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-sm text-gray-500">Processed By</dt>
                <dd class="text-sm font-semibold text-gray-900">{{ $payment->approver?->name ?? 'System' }}</dd>
            </div>
        </dl>
    </div>

    <!-- Buyer Information -->
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
        <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
            <i class="bi bi-person text-orange-500"></i>
            Buyer Information
        </h3>
        <dl class="space-y-3">
            <div class="flex justify-between">
                <dt class="text-sm text-gray-500">Name</dt>
                <dd class="text-sm font-semibold text-gray-900">{{ $payment->buyer_name }}</dd>
            </div>
            @if($payment->buyer_email)
            <div class="flex justify-between">
                <dt class="text-sm text-gray-500">Email</dt>
                <dd class="text-sm font-semibold text-gray-900">{{ $payment->buyer_email }}</dd>
            </div>
            @endif
            @if($payment->buyer_phone)
            <div class="flex justify-between">
                <dt class="text-sm text-gray-500">Phone</dt>
                <dd class="text-sm font-semibold text-gray-900">{{ $payment->buyer_phone }}</dd>
            </div>
            @endif
            @if($payment->buyer_address)
            <div class="flex justify-between">
                <dt class="text-sm text-gray-500">Address</dt>
                <dd class="text-sm font-semibold text-gray-900">{{ $payment->buyer_address }}</dd>
            </div>
            @endif
            @if(!$payment->user_id)
            <div class="flex justify-between">
                <dt class="text-sm text-gray-500">Account</dt>
                <dd class="text-sm">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-amber-100 text-amber-700">
                        <i class="bi bi-person-x mr-1"></i> Walk-in / Offline Buyer
                    </span>
                </dd>
            </div>
            @endif
        </dl>
    </div>

    <!-- Property Information -->
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
        <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
            <i class="bi bi-building text-orange-500"></i>
            Property Information
        </h3>
        <dl class="space-y-3">
            <div class="flex justify-between">
                <dt class="text-sm text-gray-500">Title</dt>
                <dd class="text-sm font-semibold text-gray-900 text-right">{{ $payment->property->title }}</dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-sm text-gray-500">Location</dt>
                <dd class="text-sm font-semibold text-gray-900 text-right">{{ $payment->property->location }}</dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-sm text-gray-500">Category</dt>
                <dd class="text-sm font-semibold text-gray-900 text-right capitalize">{{ $payment->property->category }}</dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-sm text-gray-500">Status</dt>
                <dd class="text-sm">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-green-100 text-green-700">
                        {{ $payment->property->status }}
                    </span>
                </dd>
            </div>
        </dl>
    </div>

    <!-- Staff Notes -->
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
        <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
            <i class="bi bi-chat-dots text-orange-500"></i>
            Staff Notes
        </h3>
        @if($payment->staff_notes)
            <p class="text-sm text-gray-700">{{ $payment->staff_notes }}</p>
        @else
            <p class="text-sm text-gray-400 italic">No staff notes recorded.</p>
        @endif

        <div class="mt-6 pt-4 border-t border-gray-100">
            <h4 class="text-sm font-semibold text-gray-700 mb-2">Receipt Preview</h4>
            @if($payment->receipt)
                <p class="text-sm text-gray-500">
                    Generated {{ $payment->receipt->generated_at?->diffForHumans() }}
                    by {{ $payment->receipt->generator?->name ?? 'System' }}
                </p>
            @else
                <p class="text-sm text-gray-400 italic">No receipt generated yet.</p>
            @endif
        </div>
    </div>
</div>

<div class="mt-6 flex items-center gap-3">
    <a href="{{ route('admin.sales') }}"
       class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-semibold text-sm transition-colors">
        <i class="bi bi-arrow-left"></i> Back to Sales
    </a>
    @if($payment->receipt?->file_path)
    <a href="{{ route('admin.sales.receipt.download', $payment) }}" target="_blank"
       class="px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 font-semibold text-sm transition-all inline-flex items-center gap-2">
        <i class="bi bi-download"></i> Download Receipt
    </a>
    @endif
</div>
@endsection

@push('scripts')
<script>
    function toggleShareMenu() {
        const menu = document.getElementById('shareMenu');
        const btn = document.querySelector('[onclick="toggleShareMenu()"]');
        if (!menu || !btn) return;

        if (menu.classList.contains('hidden')) {
            const rect = btn.getBoundingClientRect();
            const menuWidth = 230;
            menu.style.position = 'fixed';
            menu.style.top = (rect.bottom + 6) + 'px';
            menu.style.left = Math.max(8, Math.min(rect.right - menuWidth, window.innerWidth - menuWidth - 8)) + 'px';
            menu.classList.remove('hidden');
        } else {
            closeShareMenu();
        }
    }

    function closeShareMenu() {
        const menu = document.getElementById('shareMenu');
        if (!menu) return;
        menu.classList.add('hidden');
        menu.style.position = '';
        menu.style.top = '';
        menu.style.left = '';
    }

    document.addEventListener('click', function(e) {
        const menu = document.getElementById('shareMenu');
        if (!menu || menu.classList.contains('hidden')) return;
        if (!menu.contains(e.target) && !e.target.closest('[onclick="toggleShareMenu()"]')) {
            closeShareMenu();
        }
    });

    window.addEventListener('resize', closeShareMenu);
    window.addEventListener('scroll', closeShareMenu, true);

    async function copyReceiptLink(url) {
        closeShareMenu();
        try {
            await navigator.clipboard.writeText(url);
            window.toast('Receipt link copied to clipboard', 'success');
        } catch (e) {
            window.toast('Could not copy link. Please try again.', 'error');
        }
    }

    async function shareReceiptImage(paymentId, receiptNumber) {
        closeShareMenu();
        try {
            const base = '{{ route("admin.sales.receipt.share", ":id") }}'.replace(':id', paymentId);
            const data = await window.ajax(base, 'GET');
            if (!data.success || !data.url) throw new Error('Could not generate receipt image');

            const res = await fetch(data.url, { cache: 'no-store' });
            if (!res.ok) throw new Error('Could not load receipt image');
            const blob = await res.blob();
            const file = new File([blob], 'receipt-' + receiptNumber + '.png', { type: 'image/png' });

            if (navigator.canShare && navigator.canShare({ files: [file] })) {
                await navigator.share({
                    files: [file],
                    title: 'Receipt ' + receiptNumber,
                    text: 'Payment receipt ' + receiptNumber + ' - ' + '{{ config('bfamily.company.name') }}'
                });
                return;
            }

            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'receipt-' + receiptNumber + '.png';
            document.body.appendChild(link);
            link.click();
            link.remove();
            URL.revokeObjectURL(link.href);
            if (window.toast) window.toast('Receipt image downloaded - attach it in your WhatsApp chat.', 'success', 6000);
        } catch (error) {
            if (window.toast) window.toast(error.message || 'Failed to generate receipt image', 'error');
        }
    }

    async function shareReceiptFile(url, title) {
        closeShareMenu();
        try {
            if (navigator.canShare) {
                const res = await fetch(url);
                const blob = await res.blob();
                const file = new File([blob], 'receipt.pdf', { type: 'application/pdf' });
                if (navigator.canShare({ files: [file] })) {
                    await navigator.share({ files: [file], title: title, text: title });
                    return;
                }
            }
            if (navigator.share) {
                await navigator.share({ title: title, url: url });
                return;
            }
            await navigator.clipboard.writeText(url);
            window.toast('Receipt link copied to clipboard', 'success');
        } catch (error) {
            if (error && error.name === 'AbortError') return;
            window.toast(error.message || 'Sharing failed', 'error');
        }
    }
</script>
@endpush
