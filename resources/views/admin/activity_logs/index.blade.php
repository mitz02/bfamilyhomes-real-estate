@extends('layouts.admin')

@section('title', 'Activity Logs')

@section('content')
<div class="mb-8">
    <div class="flex items-center gap-2 text-xs md:text-sm text-gray-500 mb-4 px-2 md:px-0">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-orange-600 transition-colors">
            <i class="bi bi-house-door mr-1"></i>B-Family
        </a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-orange-600 font-semibold">Activity Logs</span>
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

        <div class="relative flex items-start gap-4">
            <div class="w-14 h-14 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center shadow-sm flex-shrink-0 border border-white/10">
                <i class="bi bi-clock-history text-white text-2xl"></i>
            </div>
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-white">Activity Logs</h1>
                <p class="text-blue-100/80 text-sm mt-0.5">Audit trail of all system activities</p>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 mb-6">
    <form method="GET" class="flex flex-wrap gap-3">
        <div>
            <select name="action" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none">
                <option value="">All Actions</option>
                <option value="sale_recorded" {{ request('action') == 'sale_recorded' ? 'selected' : '' }}>Sale Recorded</option>
                <option value="payment_approved" {{ request('action') == 'payment_approved' ? 'selected' : '' }}>Payment Approved</option>
                <option value="payment_rejected" {{ request('action') == 'payment_rejected' ? 'selected' : '' }}>Payment Rejected</option>
                <option value="receipt_generated" {{ request('action') == 'receipt_generated' ? 'selected' : '' }}>Receipt Generated</option>
                <option value="property_sold" {{ request('action') == 'property_sold' ? 'selected' : '' }}>Property Sold</option>
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
        @if(request()->anyFilled(['action', 'date_from', 'date_to']))
        <a href="{{ route('admin.activity-logs') }}" class="px-4 py-2 bg-gray-100 text-gray-500 rounded-lg hover:bg-gray-200 text-sm transition-colors">
            Clear
        </a>
        @endif
    </form>
</div>

<div class="bg-white rounded-xl border border-gray-100 shadow-sm mx-1 md:mx-0">
    @if($logs->count() > 0)
        <div class="overflow-x-auto p-6" style="-webkit-overflow-scrolling: touch;">
            <table class="w-full" style="min-width: 800px;">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Time</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">User</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Action</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Description</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                    <tr class="border-b border-gray-50 last:border-0 hover:bg-gray-50/50 transition-colors">
                        <td class="py-4 px-4 whitespace-nowrap">
                            <p class="text-sm text-gray-900">{{ $log->created_at->format('M d, Y') }}</p>
                            <p class="text-xs text-gray-500">{{ $log->created_at->format('h:i A') }}</p>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            @if($log->user)
                                <p class="text-sm font-semibold text-gray-900">{{ $log->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $log->user->role }}</p>
                            @else
                                <p class="text-sm text-gray-400">System</p>
                            @endif
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            @php
                                $actionColors = [
                                    'sale_recorded' => 'green',
                                    'payment_approved' => 'green',
                                    'payment_rejected' => 'red',
                                    'receipt_generated' => 'blue',
                                    'property_sold' => 'orange',
                                ];
                                $color = $actionColors[$log->action] ?? 'gray';
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-{{ $color }}-100 text-{{ $color }}-700">
                                {{ str_replace('_', ' ', ucfirst($log->action)) }}
                            </span>
                        </td>
                        <td class="py-4 px-4">
                            <p class="text-sm text-gray-700">{{ $log->description }}</p>
                            @if($log->properties && isset($log->properties['amount']))
                                <p class="text-xs text-gray-500 mt-1">Amount: ₦{{ number_format($log->properties['amount'], 2) }}</p>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="px-6 pb-6">
            {{ $logs->appends(request()->query())->links() }}
        </div>
    @else
        <div class="text-center py-16">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="bi bi-clock-history text-3xl text-gray-300"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-1">No Activity Logs</h3>
            <p class="text-sm text-gray-500">Activity logs will appear here as actions are performed</p>
        </div>
    @endif
</div>
@endsection
