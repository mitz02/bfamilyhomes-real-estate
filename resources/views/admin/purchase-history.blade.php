@extends('layouts.admin')

@section('title', 'Purchase History')

@section('content')
<div class="mb-8">
    <div class="flex items-center gap-2 text-xs md:text-sm text-gray-500 mb-4 px-2 md:px-0">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-orange-600 transition-colors">
            <i class="bi bi-house-door mr-1"></i>B-Family
        </a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-orange-600 font-semibold">Purchase History</span>
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
                    <i class="bi bi-cart-check text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-bold text-white">Purchase History</h1>
                    <p class="text-blue-100/80 text-sm mt-0.5">{{ $greeting }}, {{ auth()->user()->name }}!</p>
                    <p class="text-blue-300/60 text-xs mt-0.5">{{ now()->format('l, F j, Y') }}</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.finance.purchases.create') }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 bg-white text-blue-900 rounded-lg hover:bg-blue-50 font-semibold transition-all text-sm shadow-sm">
                    <i class="bi bi-plus-lg"></i>
                    Record Purchase
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 px-1 md:px-0">
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
        <p class="text-xs text-gray-500 mb-1">Total Purchases</p>
        <p class="text-xl font-bold text-gray-900">₦{{ number_format($stats['total_amount'], 2) }}</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
        <p class="text-xs text-gray-500 mb-1">Total Records</p>
        <p class="text-xl font-bold text-gray-900">{{ $stats['total_records'] }}</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
        <p class="text-xs text-gray-500 mb-1">This Month</p>
        <p class="text-xl font-bold text-gray-900">₦{{ number_format($stats['this_month'], 2) }}</p>
    </div>
</div>

<!-- Search & Filters -->
<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 mb-6">
    <form method="GET" class="flex flex-wrap gap-3">
        <div class="flex-1 min-w-[200px]">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search by title, category, reference, notes..."
                   class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none">
        </div>
        <div>
            <select name="category" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none">
                <option value="">All Categories</option>
                <option value="Land" {{ request('category') === 'Land' ? 'selected' : '' }}>Land</option>
                <option value="Building Materials" {{ request('category') === 'Building Materials' ? 'selected' : '' }}>Building Materials</option>
                <option value="Equipment" {{ request('category') === 'Equipment' ? 'selected' : '' }}>Equipment</option>
                <option value="Property" {{ request('category') === 'Property' ? 'selected' : '' }}>Property</option>
                <option value="Construction" {{ request('category') === 'Construction' ? 'selected' : '' }}>Construction</option>
                <option value="Other" {{ request('category') === 'Other' ? 'selected' : '' }}>Other</option>
            </select>
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
        @if(request()->anyFilled(['search', 'category', 'date_from', 'date_to']))
        <a href="{{ route('admin.purchase-history') }}" class="px-4 py-2 bg-gray-100 text-gray-500 rounded-lg hover:bg-gray-200 text-sm transition-colors">
            Clear
        </a>
        @endif
    </form>
</div>

<!-- Table -->
<div class="bg-white rounded-xl border border-gray-100 shadow-sm mx-1 md:mx-0">
    @if($purchases->count() > 0)
        <div class="overflow-x-auto p-6" style="-webkit-overflow-scrolling: touch;">
            <table class="w-full" style="min-width: 800px;">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Title</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Category</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Amount</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Purchase Date</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Payment Method</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Recorded By</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($purchases as $purchase)
                    <tr class="border-b border-gray-50 last:border-0 hover:bg-gray-50/50 transition-colors">
                        <td class="py-4 px-4">
                            <p class="font-semibold text-gray-900 text-sm">{{ Str::limit($purchase->title, 40) }}</p>
                            @if($purchase->reference)
                                <p class="text-xs text-gray-500 font-mono">{{ $purchase->reference }}</p>
                            @endif
                            @if($purchase->notes)
                                <p class="text-xs text-gray-400 mt-1">{{ Str::limit($purchase->notes, 50) }}</p>
                            @endif
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                {{ $purchase->category }}
                            </span>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <p class="font-bold text-gray-900">{{ $purchase->formatted_amount }}</p>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <p class="text-sm text-gray-900">{{ $purchase->purchase_date->format('M d, Y') }}</p>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <p class="text-sm text-gray-900">{{ ucfirst($purchase->payment_method ?: 'N/A') }}</p>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <p class="text-sm text-gray-900">{{ $purchase->recorder?->name ?? 'System' }}</p>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.finance.purchases.edit', $purchase) }}"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 bg-gray-100 text-gray-700 rounded-lg text-xs font-semibold hover:bg-gray-200 transition-colors">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form method="POST" action="{{ route('admin.purchase-history.destroy', $purchase) }}" class="m-0 inline"
                                      onsubmit="return confirm('Are you sure you want to delete this purchase record?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-50 text-red-700 rounded-lg text-xs font-semibold hover:bg-red-100 transition-colors">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="px-6 pb-6">
            {{ $purchases->appends(request()->query())->links() }}
        </div>
    @else
        <div class="text-center py-16">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="bi bi-cart-check text-3xl text-gray-300"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-1">No Purchases Yet</h3>
            <p class="text-sm text-gray-500 mb-4">Start by recording a new purchase</p>
            <a href="{{ route('admin.finance.purchases.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 font-semibold text-sm transition-colors">
                <i class="bi bi-plus-lg"></i> Record First Purchase
            </a>
        </div>
    @endif
</div>
@endsection
