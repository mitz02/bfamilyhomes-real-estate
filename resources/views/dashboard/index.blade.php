@extends('layouts.dashboard')

@section('title', 'My Dashboard')

@section('content')
<!-- Notifications Bar -->
@if($unreadNotifications > 0)
<div class="mb-6">
    <div class="p-4 md:p-5 bg-gradient-to-br from-orange-50 to-yellow-50 border border-orange-200 rounded-xl shadow-sm">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-full flex items-center justify-center shadow-sm flex-shrink-0">
                    <i class="bi bi-bell-fill text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 text-sm md:text-base">You have {{ $unreadNotifications }} unread notification{{ $unreadNotifications > 1 ? 's' : '' }}</h3>
                    <p class="text-xs md:text-sm text-gray-500">Click to view all notifications</p>
                </div>
            </div>
            <a href="{{ route('notifications.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-orange-500 to-yellow-500 text-white rounded-xl hover:from-orange-600 hover:to-yellow-600 font-semibold transition-all duration-200 shadow-sm hover:shadow-md text-sm flex-shrink-0">
                <i class="bi bi-bell"></i>
                View All
                @if($unreadNotifications > 0)
                <span class="w-5 h-5 bg-white/30 rounded-full flex items-center justify-center text-xs font-bold">{{ $unreadNotifications }}</span>
                @endif
            </a>
        </div>
        
        @if($recentNotifications->count() > 0)
        <div class="mt-4 space-y-2">
            @foreach($recentNotifications as $notification)
            <div class="flex items-start gap-3 p-3 bg-white rounded-lg hover:bg-orange-50 transition-colors cursor-pointer border border-gray-100" onclick="markAsRead({{ $notification->id }})">
                <div class="w-8 h-8 rounded-full flex items-center justify-center bg-orange-100 flex-shrink-0">
                    <i class="bi {{ $notification->icon ?? 'bi-info-circle' }} text-orange-600"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="font-semibold text-gray-900 text-sm">{{ $notification->title }}</h4>
                    <p class="text-xs text-gray-500">{{ $notification->message }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
@endif

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Inspections -->
    <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100 relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-orange-500/15 to-transparent rounded-full -mr-16 -mt-16 opacity-50"></div>
        <div class="relative">
            <div class="flex items-center justify-between mb-4">
                <i class="bi bi-calendar-check text-orange-500"></i>
                <span class="text-xs text-orange-600">Total</span>
            </div>
            <h3 class="text-gray-500 text-sm mb-1 font-medium">Total Inspections</h3>
            <p class="text-lg md:text-2xl font-bold text-gray-900 mb-2">{{ $stats['inspections'] }}</p>
            <div class="w-full bg-gray-100 rounded-full h-1.5">
                <div class="bg-gradient-to-r from-orange-500 to-yellow-500 h-1.5 rounded-full" style="width: 100%"></div>
            </div>
        </div>
    </div>

    <!-- Available Properties -->
    <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100 relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-orange-500/15 to-transparent rounded-full -mr-16 -mt-16 opacity-50"></div>
        <div class="relative">
            <div class="flex items-center justify-between mb-4">
                <i class="bi bi-house-door text-orange-500"></i>
                <span class="text-xs text-orange-600">Available</span>
            </div>
            <h3 class="text-gray-500 text-sm mb-1 font-medium">Available Properties</h3>
            <p class="text-lg md:text-2xl font-bold text-gray-900 mb-2">{{ $stats['properties'] }}</p>
            <div class="w-full bg-gray-100 rounded-full h-1.5">
                <div class="bg-gradient-to-r from-orange-500 to-yellow-500 h-1.5 rounded-full" style="width: 100%"></div>
            </div>
        </div>
    </div>

    <!-- Total Payments -->
    <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100 relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-orange-500/15 to-transparent rounded-full -mr-16 -mt-16 opacity-50"></div>
        <div class="relative">
            <div class="flex items-center justify-between mb-4">
                <i class="bi bi-credit-card text-orange-500"></i>
                <span class="text-xs text-orange-600">Total</span>
            </div>
            <h3 class="text-gray-500 text-sm mb-1 font-medium">Total Payments</h3>
            <p class="text-lg md:text-2xl font-bold text-gray-900 mb-2">{{ $stats['payments'] }}</p>
            <div class="w-full bg-gray-100 rounded-full h-1.5">
                <div class="bg-gradient-to-r from-orange-500 to-yellow-500 h-1.5 rounded-full" style="width: 100%"></div>
            </div>
        </div>
    </div>

    <!-- Pending Payments -->
    <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100 relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-orange-500/15 to-transparent rounded-full -mr-16 -mt-16 opacity-50"></div>
        <div class="relative">
            <div class="flex items-center justify-between mb-4">
                <i class="bi bi-clock-history text-orange-500"></i>
                <span class="text-xs text-orange-600">Pending</span>
            </div>
            <h3 class="text-gray-500 text-sm mb-1 font-medium">Pending Payments</h3>
            <p class="text-lg md:text-2xl font-bold text-gray-900 mb-2">{{ $stats['pending_payments'] }}</p>
            <div class="w-full bg-gray-100 rounded-full h-1.5">
                <div class="bg-gradient-to-r from-orange-500 to-yellow-500 h-1.5 rounded-full" style="width: {{ $stats['payments'] > 0 ? ($stats['pending_payments'] / $stats['payments']) * 100 : 0 }}%"></div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 md:p-6 mb-8">
    <div class="flex items-center gap-3 mb-4">
        <div class="w-10 h-10 bg-orange-500/10 rounded-lg flex items-center justify-center">
            <i class="bi bi-lightning-charge-fill text-orange-500"></i>
        </div>
        <div>
            <h2 class="text-lg font-bold text-gray-900">Quick Actions</h2>
            <p class="text-xs text-gray-500">Navigate to your most used sections</p>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="{{ route('properties.index') }}" class="px-4 py-3 bg-gradient-to-r from-orange-500 to-yellow-500 text-white rounded-xl hover:from-orange-600 hover:to-yellow-600 font-semibold transition-all text-sm shadow-sm flex items-center justify-center gap-2">
            <i class="bi bi-search"></i>
            Browse Properties
        </a>
        <a href="{{ route('inspections.index') }}" class="px-4 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 font-semibold transition-all text-sm flex items-center justify-center gap-2">
            <i class="bi bi-calendar-check"></i>
            My Inspections
        </a>
        <a href="{{ route('payments.index') }}" class="px-4 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 font-semibold transition-all text-sm flex items-center justify-center gap-2">
            <i class="bi bi-credit-card"></i>
            My Payments
        </a>
    </div>
</div>

<!-- Upgrade to Investor -->
@if(!auth()->user()->isInvestor() && !auth()->user()->investor_requested_at)
<div id="investorRequestCard" class="bg-gradient-to-r from-orange-500 to-yellow-500 rounded-xl p-6 mb-8 shadow-sm">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-lg md:text-2xl font-bold text-white mb-2">Become an Investor</h3>
            <p class="text-white/80 text-sm mb-4">
                Unlock exclusive investment opportunities and earn returns on your capital.
            </p>
            <button id="requestInvestorBtn" class="px-5 py-2.5 bg-white text-orange-600 rounded-xl hover:bg-gray-100 font-semibold transition-all text-sm inline-flex items-center gap-2 shadow-sm">
                <i class="bi bi-arrow-up-circle"></i>
                Request Upgrade
            </button>
        </div>
        <i class="bi bi-graph-up-arrow text-6xl opacity-20 hidden md:block"></i>
    </div>
</div>
@elseif(auth()->user()->investor_requested_at && !auth()->user()->investor_approved_at)
<div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 mb-8">
    <div class="flex items-center gap-3">
        <i class="bi bi-clock-history text-3xl text-yellow-600"></i>
        <div>
            <h3 class="font-bold text-gray-900">Investor Upgrade Pending</h3>
            <p class="text-gray-500 text-sm">Your upgrade request is under review. We'll notify you once approved.</p>
        </div>
    </div>
</div>
@endif

<!-- Upgrade to Agent -->
@if(!auth()->user()->isAgent() && !auth()->user()->agent_requested_at)
<div id="agentRequestCard" class="bg-gradient-to-r from-orange-500 to-yellow-500 rounded-xl p-6 mb-8 shadow-sm">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-lg md:text-2xl font-bold text-white mb-2">Become an Agent</h3>
            <p class="text-white/80 text-sm mb-4">
                List your properties and reach more clients by becoming a partner agent.
            </p>
            <button id="requestAgentBtn" class="px-5 py-2.5 bg-white text-orange-600 rounded-xl hover:bg-gray-100 font-semibold transition-all text-sm inline-flex items-center gap-2 shadow-sm">
                <i class="bi bi-person-plus"></i>
                Request Agent Status
            </button>
        </div>
        <i class="bi bi-person-badge text-6xl opacity-20 hidden md:block"></i>
    </div>
</div>
@elseif(auth()->user()->agent_requested_at && !auth()->user()->agent_approved_at)
<div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 mb-8">
    <div class="flex items-center gap-3">
        <i class="bi bi-clock-history text-3xl text-yellow-600"></i>
        <div>
            <h3 class="font-bold text-gray-900">Agent Status Pending</h3>
            <p class="text-gray-500 text-sm">Your agent status request is under review. We'll notify you once approved.</p>
        </div>
    </div>
</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Recent Inspections -->
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-gray-900">Recent Inspections</h2>
            <a href="{{ route('inspections.index') }}" class="text-orange-600 hover:text-orange-700 text-sm font-semibold inline-flex items-center gap-1">
                View All <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        @if($recentInspections->count() > 0)
            <div class="space-y-4">
                @foreach($recentInspections as $inspection)
                <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                    <div>
                        <h4 class="font-semibold text-gray-900 text-sm">{{ $inspection->property->title }}</h4>
                        <p class="text-sm text-gray-500">
                            {{ $inspection->preferred_date->format('M d, Y') }} at {{ $inspection->preferred_time }}
                        </p>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold {{ 
                        $inspection->status === 'confirmed' ? 'bg-green-100 text-green-700' : 
                        ($inspection->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-700')
                    }}">
                        {{ ucfirst($inspection->status) }}
                    </span>
                </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center py-8 text-sm">No inspections yet</p>
        @endif
    </div>

    <!-- Transaction History -->
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-gray-900">Transaction History</h2>
            <a href="{{ route('payments.index') }}" class="text-orange-600 hover:text-orange-700 text-sm font-semibold inline-flex items-center gap-1">
                View All <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        @if($recentPayments->count() > 0)
            <div class="space-y-4">
                @foreach($recentPayments as $payment)
                <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0 gap-3">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 {{ 
                            $payment->status === 'approved' ? 'bg-green-100 text-green-600' : 
                            ($payment->status === 'pending' ? 'bg-yellow-100 text-yellow-600' : 'bg-red-100 text-red-600')
                        }}">
                            <i class="bi {{ $payment->status === 'approved' ? 'bi-check-circle' : ($payment->status === 'pending' ? 'bi-clock-history' : 'bi-x-circle') }}"></i>
                        </div>
                        <div class="min-w-0">
                            <h4 class="font-semibold text-gray-900 text-sm truncate">{{ $payment->property->title ?? 'Property' }}</h4>
                            <p class="text-xs text-gray-400">{{ $payment->created_at->format('M d, Y h:i A') }} · {{ ucfirst($payment->type) }}</p>
                            <p class="text-xs text-gray-400">Ref: {{ $payment->reference }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 flex-shrink-0">
                        @if($payment->status === 'approved' && $payment->receipt && $payment->receipt->file_path)
                        <a href="{{ asset('storage/' . $payment->receipt->file_path) }}" target="_blank" title="Download Receipt"
                           class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:bg-gray-100 hover:text-gray-700 transition-colors">
                            <i class="bi bi-receipt"></i>
                        </a>
                        @endif
                        <div class="text-right">
                            <p class="font-bold text-gray-900 text-sm">{{ $payment->formatted_amount }}</p>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold mt-1 {{ 
                                $payment->status === 'approved' ? 'bg-green-100 text-green-700' : 
                                ($payment->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700')
                            }}">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center py-8 text-sm">No transactions yet</p>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    function renderPendingCard(icon, title, message) {
        return `
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 mb-8">
                <div class="flex items-center gap-3">
                    <i class="bi ${icon} text-3xl text-yellow-600"></i>
                    <div>
                        <h3 class="font-bold text-gray-900">${title}</h3>
                        <p class="text-gray-500 text-sm">${message}</p>
                    </div>
                </div>
            </div>`;
    }

    document.getElementById('requestInvestorBtn')?.addEventListener('click', async function() {
        const btn = this;
        showLoader(btn);
        
        try {
            const data = await window.ajax('{{ route("dashboard.request-investor") }}', 'POST');
            hideLoader(btn);
            const card = document.getElementById('investorRequestCard');
            if (card) {
                card.outerHTML = renderPendingCard(
                    'bi-clock-history',
                    'Investor Upgrade Pending',
                    'Your upgrade request is under review. We\'ll notify you once approved.'
                );
            }
            window.toast(data.message, 'success');
        } catch (error) {
            hideLoader(btn);
            window.toast(error.message || 'Failed to submit request', 'error');
        }
    });

    document.getElementById('requestAgentBtn')?.addEventListener('click', async function() {
        const btn = this;
        showLoader(btn);
        
        try {
            const data = await window.ajax('{{ route("dashboard.request-agent") }}', 'POST');
            hideLoader(btn);
            const card = document.getElementById('agentRequestCard');
            if (card) {
                card.outerHTML = renderPendingCard(
                    'bi-clock-history',
                    'Agent Status Pending',
                    'Your agent status request is under review. We\'ll notify you once approved.'
                );
            }
            window.toast(data.message, 'success');
        } catch (error) {
            hideLoader(btn);
            window.toast(error.message || 'Failed to submit request', 'error');
        }
    });
</script>
@endpush
