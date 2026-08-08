@extends('layouts.admin')

@section('title', 'Sale History')

@section('content')
<div class="mb-8">
    <div class="flex items-center gap-2 text-xs md:text-sm text-gray-500 mb-4 px-2 md:px-0">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-orange-600 transition-colors">
            <i class="bi bi-house-door mr-1"></i>B-Family
        </a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-orange-600 font-semibold">Sale History</span>
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

        <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-start gap-4">
                <div class="w-14 h-14 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center shadow-sm flex-shrink-0 border border-white/10">
                    <i class="bi bi-receipt text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-bold text-white">Sale History</h1>
                    <p class="text-blue-100/80 text-sm mt-0.5">{{ $greeting }}, {{ auth()->user()->name }}!</p>
                    <p class="text-blue-300/60 text-xs mt-0.5">{{ now()->format('l, F j, Y') }}</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.sales.create') }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 bg-white text-blue-900 rounded-lg hover:bg-blue-50 font-semibold transition-all text-sm shadow-sm">
                    <i class="bi bi-plus-lg"></i>
                    Record Sale
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 px-1 md:px-0">
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
        <p class="text-xs text-gray-500 mb-1">Total Sales</p>
        <p class="text-xl font-bold text-gray-900">₦{{ number_format($stats['total_sales'], 2) }}</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
        <p class="text-xs text-gray-500 mb-1">Transactions</p>
        <p class="text-xl font-bold text-gray-900">{{ $stats['total_transactions'] }}</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
        <p class="text-xs text-gray-500 mb-1">This Month</p>
        <p class="text-xl font-bold text-gray-900">₦{{ number_format($stats['this_month'], 2) }}</p>
    </div>
</div>

<!-- Search -->
<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 mb-6">
    <form method="GET" class="flex flex-wrap gap-3">
        <div class="flex-1 min-w-[200px]">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search by buyer, reference, property, amount..."
                   class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none">
        </div>
        <div>
            <input type="date" name="date_from" value="{{ request('date_from') }}"
                   class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none">
        </div>
        <div>
            <input type="date" name="date_to" value="{{ request('date_to') }}"
                   class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none">
        </div>
        <button type="submit" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-semibold text-sm transition-colors">
            <i class="bi bi-search"></i> Filter
        </button>
        @if(request()->anyFilled(['search', 'date_from', 'date_to']))
        <a href="{{ route('admin.sale-history') }}" class="px-4 py-2 bg-gray-100 text-gray-500 rounded-lg hover:bg-gray-200 text-sm transition-colors">
            Clear
        </a>
        @endif
    </form>
</div>

<!-- Table -->
<div class="bg-white rounded-xl border border-gray-100 shadow-sm mx-1 md:mx-0">
    @if($sales->count() > 0)
        <div class="overflow-x-auto p-6" style="-webkit-overflow-scrolling: touch;">
            <table class="w-full" style="min-width: 1000px;">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Receipt</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Buyer</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Property</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Amount</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Sale Date</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Processed By</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sales as $payment)
                    <tr class="border-b border-gray-50 last:border-0 hover:bg-gray-50/50 transition-colors">
                        <td class="py-4 px-4 whitespace-nowrap">
                            <p class="font-mono text-sm text-gray-900">{{ $payment->receipt?->receipt_number ?? 'N/A' }}</p>
                            <p class="text-xs text-gray-500">{{ $payment->reference }}</p>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <p class="font-semibold text-gray-900 text-sm">{{ $payment->buyer_name }}</p>
                            @if($payment->buyer_email)
                                <p class="text-xs text-gray-500">{{ $payment->buyer_email }}</p>
                            @elseif($payment->buyer_phone)
                                <p class="text-xs text-gray-500">{{ $payment->buyer_phone }}</p>
                            @else
                                <p class="text-xs text-gray-400 italic">Walk-in buyer</p>
                            @endif
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <p class="font-medium text-gray-900 text-sm">{{ Str::limit($payment->property->title, 30) }}</p>
                            <p class="text-xs text-gray-500">{{ $payment->property->location }}</p>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <p class="font-bold text-gray-900">{{ $payment->formatted_amount }}</p>
                            <p class="text-xs text-gray-500">{{ ucfirst($payment->payment_method ?: 'bank_transfer') }}</p>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <p class="text-sm text-gray-900">{{ $payment->sale_date ? $payment->sale_date->format('M d, Y') : $payment->created_at->format('M d, Y') }}</p>
                            <p class="text-xs text-gray-500">{{ $payment->sale_date ? $payment->sale_date->format('h:i A') : '' }}</p>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <p class="text-sm text-gray-900">{{ $payment->approver?->name ?? 'System' }}</p>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.sales.show', $payment) }}"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 bg-gray-100 text-gray-700 rounded-lg text-xs font-semibold hover:bg-gray-200 transition-colors">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <div class="relative action-menu">
                                    <button onclick="toggleActionMenu(this)" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 transition-colors">
                                        <i class="bi bi-three-dots-vertical text-gray-400"></i>
                                    </button>
                                    <div class="hidden absolute right-0 top-full mt-1 bg-white rounded-xl border border-gray-100 shadow-lg py-1 min-w-[170px] max-w-[calc(100vw-16px)] z-50">
                                        <div class="flex items-center justify-between px-3 py-1.5 border-b border-gray-50">
                                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Actions</span>
                                            <button type="button" onclick="closeAllMenus()" class="w-6 h-6 flex items-center justify-center rounded-md hover:bg-gray-100 text-gray-400 hover:text-gray-700 transition-colors" title="Close">
                                                <i class="bi bi-x-lg text-sm"></i>
                                            </button>
                                        </div>
                                        <a href="{{ route('admin.sales.receipt.print', $payment) }}" target="_blank" onclick="closeAllMenus()"
                                           class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                            <i class="bi bi-printer text-gray-400"></i> Print Invoice
                                        </a>
                                        @if($payment->receipt?->file_path)
                                        <a href="{{ route('admin.sales.receipt.download', $payment) }}" target="_blank" onclick="closeAllMenus()"
                                           class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-blue-700 hover:bg-blue-50 transition-colors">
                                            <i class="bi bi-receipt text-gray-400"></i> Download Receipt
                                        </a>
                                        <button type="button" onclick="shareReceiptImage({{ $payment->id }}, '{{ $payment->receipt->receipt_number }}')"
                                                class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors text-left">
                                            <i class="bi bi-whatsapp text-green-500"></i> Share via WhatsApp
                                        </button>
                                        <button type="button" onclick="copyReceiptLink('{{ asset('storage/' . $payment->receipt->file_path) }}')"
                                                class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors text-left">
                                            <i class="bi bi-link-45deg text-gray-500"></i> Copy Receipt Link
                                        </button>
                                        @endif
                                        <div class="border-t border-gray-50 my-1"></div>
                                        <form method="POST" action="{{ route('admin.sales.destroy', $payment) }}" class="m-0" onsubmit="return confirm('Are you sure you want to delete this sale? The property will be marked as Available and the receipt removed.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="closeAllMenus()"
                                                    class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-red-700 hover:bg-red-50 transition-colors text-left">
                                                <i class="bi bi-trash"></i> Delete Sale
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="px-6 pb-6">
            {{ $sales->appends(request()->query())->links() }}
        </div>
    @else
        <div class="text-center py-16">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="bi bi-receipt text-3xl text-gray-300"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-1">No Sales Yet</h3>
            <p class="text-sm text-gray-500 mb-4">Start by recording a new sale</p>
            <a href="{{ route('admin.sales.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 font-semibold text-sm transition-colors">
                <i class="bi bi-plus-lg"></i> Record First Sale
            </a>
        </div>
    @endif
</div>
@push('scripts')
<script>
    function toggleActionMenu(btn) {
        var menu = btn.nextElementSibling;
        var isHidden = menu.classList.contains('hidden');
        closeAllMenus();
        if (isHidden) {
            menu.classList.remove('hidden');
            positionMenu(menu, btn);
        }
    }

    function positionMenu(menu, btn) {
        var rect = btn.getBoundingClientRect();
        var menuWidth = menu.offsetWidth || 180;
        var menuHeight = menu.offsetHeight || 220;
        var top = rect.bottom + 6;
        var left = rect.right - menuWidth;
        left = Math.max(8, Math.min(left, window.innerWidth - menuWidth - 8));
        if (top + menuHeight > window.innerHeight - 8) {
            top = Math.max(8, rect.top - menuHeight - 6);
        }
        menu.style.position = 'fixed';
        menu.style.top = top + 'px';
        menu.style.left = left + 'px';
        menu.style.right = 'auto';
        menu.style.zIndex = '50';
    }

    function closeAllMenus() {
        document.querySelectorAll('.action-menu > div:last-child').forEach(function(m) {
            m.classList.add('hidden');
            m.style.position = '';
            m.style.top = '';
            m.style.left = '';
            m.style.right = '';
            m.style.zIndex = '';
        });
    }

    async function copyReceiptLink(url) {
        closeAllMenus();
        try {
            await navigator.clipboard.writeText(url);
            window.toast('Receipt link copied to clipboard', 'success');
        } catch (e) {
            window.toast('Could not copy link. Please try again.', 'error');
        }
    }

    async function shareReceiptImage(paymentId, receiptNumber) {
        closeAllMenus();
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

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.action-menu')) {
            closeAllMenus();
        }
    });

    window.addEventListener('resize', closeAllMenus);
    window.addEventListener('scroll', closeAllMenus, true);
</script>
@endpush
@endsection
