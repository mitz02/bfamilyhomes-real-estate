@extends('layouts.agent')

@section('title', 'Transaction History')

@section('content')
<div class="mb-8">
    <div class="relative bg-gradient-to-br from-blue-900 via-blue-800 to-blue-900 rounded-2xl p-6 md:p-8 shadow-lg overflow-hidden">
        <div class="absolute -top-10 -right-10 w-48 h-48 bg-white/5 rounded-full"></div>
        <div class="absolute -bottom-10 -left-10 w-36 h-36 bg-white/5 rounded-full"></div>
        <div class="absolute top-1/2 right-1/3 w-20 h-20 bg-white/5 rounded-full"></div>

        <div class="relative flex flex-col md:flex-row md:items-center gap-4">
            <div class="w-14 h-14 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center shadow-sm flex-shrink-0 border border-white/10">
                <i class="bi bi-credit-card text-white text-2xl"></i>
            </div>
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-white">Transaction History</h1>
                <p class="text-blue-100/80 text-sm mt-0.5">All payments and sales recorded on your properties</p>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
    @if($payments->count() > 0)
        <div class="overflow-x-auto -mx-6 px-6 w-[95%] mx-auto" style="-webkit-overflow-scrolling: touch;">
            <table class="w-full" style="min-width: 900px;">
                <thead class="border-b border-gray-200">
                    <tr>
                        <th class="text-left py-3 px-4 text-gray-600 font-semibold whitespace-nowrap text-sm">Reference</th>
                        <th class="text-left py-3 px-4 text-gray-600 font-semibold whitespace-nowrap text-sm">Buyer</th>
                        <th class="text-left py-3 px-4 text-gray-600 font-semibold whitespace-nowrap text-sm">Property</th>
                        <th class="text-left py-3 px-4 text-gray-600 font-semibold whitespace-nowrap text-sm">Amount</th>
                        <th class="text-left py-3 px-4 text-gray-600 font-semibold whitespace-nowrap text-sm">Type</th>
                        <th class="text-left py-3 px-4 text-gray-600 font-semibold whitespace-nowrap text-sm">Status</th>
                        <th class="text-left py-3 px-4 text-gray-600 font-semibold whitespace-nowrap text-sm">Receipt</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                    <tr class="border-b border-gray-100 last:border-0 hover:bg-orange-50/50">
                        <td class="py-4 px-4 whitespace-nowrap">
                            <p class="font-mono text-sm text-gray-900">{{ $payment->reference }}</p>
                            <p class="text-xs text-gray-500">{{ $payment->created_at->format('M d, Y') }}</p>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <p class="font-semibold text-gray-900 text-sm">{{ $payment->buyer_name }}</p>
                            <p class="text-xs text-gray-500">{{ $payment->buyer_email ?? '—' }}</p>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <h4 class="font-semibold text-gray-900 text-sm">{{ Str::limit($payment->property->title ?? 'Property Deleted', 30) }}</h4>
                            <p class="text-xs text-gray-500">{{ $payment->property->location ?? '—' }}</p>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <p class="font-bold text-gray-900">{{ $payment->formatted_amount }}</p>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-gray-100 text-gray-700">{{ ucfirst($payment->type) }}</span>
                            @if($payment->schedule && $payment->schedule !== 'One-time')
                                <p class="text-xs text-gray-500 mt-1">{{ $payment->schedule }}</p>
                            @endif
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold {{ 
                                $payment->status === 'approved' ? 'bg-green-100 text-green-700' : 
                                ($payment->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700')
                            }}">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            @if($payment->status === 'approved' && $payment->receipt && $payment->receipt->file_path)
                            <a href="{{ asset('storage/' . $payment->receipt->file_path) }}" target="_blank"
                               class="w-9 h-9 bg-orange-500/10 text-orange-600 rounded-lg flex items-center justify-center hover:bg-orange-500/20 transition-colors text-sm" title="Download Receipt">
                                <i class="bi bi-receipt"></i>
                            </a>
                            @else
                                <span class="text-xs text-gray-400">—</span>
                            @endif
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
            <i class="bi bi-credit-card text-6xl text-gray-200 mb-4"></i>
            <h3 class="text-xl font-bold text-gray-900 mb-2">No Transactions Yet</h3>
            <p class="text-gray-500 text-sm">Payments recorded on your properties will appear here</p>
        </div>
    @endif
</div>
@endsection
