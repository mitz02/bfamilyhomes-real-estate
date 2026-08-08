@extends('layouts.investor')

@section('title', 'Investor Dashboard')

@push('styles')
<style>
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-6px); }
    }
    @keyframes pulse-soft {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.08); }
    }
    @keyframes wiggle {
        0%, 100% { transform: rotate(0deg); }
        25% { transform: rotate(-4deg); }
        75% { transform: rotate(4deg); }
    }
    @keyframes glow {
        0%, 100% { box-shadow: 0 0 8px rgba(30, 58, 95, 0.3); }
        50% { box-shadow: 0 0 20px rgba(30, 58, 95, 0.6); }
    }
    .animate-float { animation: float 3s ease-in-out infinite; }
    .animate-pulse-soft { animation: pulse-soft 2s ease-in-out infinite; }
    .animate-wiggle { animation: wiggle 2s ease-in-out infinite; }
    .animate-glow { animation: glow 2s ease-in-out infinite; }
</style>
@endpush

@section('content')
<!-- Notifications Bar -->
@if(isset($unreadNotifications) && $unreadNotifications > 0)
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

        @if(isset($recentNotifications) && $recentNotifications->count() > 0)
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
        <div class="absolute bottom-1/4 left-1/4 w-16 h-16 bg-white/[0.03] rounded-full"></div>

        <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-start gap-4">
                <div class="w-14 h-14 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center shadow-sm flex-shrink-0 border border-white/10">
                    <i class="bi bi-graph-up-arrow text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-bold text-white">Investor Dashboard</h1>
                    <p class="text-blue-100/80 text-sm mt-0.5">{{ $greeting }}, {{ auth()->user()->name }}!</p>
                    <p class="text-blue-300/60 text-xs mt-0.5">{{ now()->format('l, F j, Y') }}</p>
                </div>
            </div>
            <div class="hidden md:flex items-center gap-3">
                <div class="text-right">
                    <p class="text-white/50 text-xs">Last updated</p>
                    <p class="text-white/80 text-sm font-medium">{{ now()->format('g:i A') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Stats Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100 relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-orange-500/15 to-transparent rounded-full -mr-16 -mt-16 opacity-50"></div>
        <div class="relative">
            <div class="flex items-center justify-between mb-4">
                <i class="bi bi-graph-up text-orange-500 animate-float"></i>
                <span class="text-xs text-orange-600">All Time</span>
            </div>
            <h3 class="text-gray-500 text-sm mb-1 font-medium">Total Investments</h3>
            <p class="text-lg md:text-2xl font-bold text-gray-900 mb-2">{{ $stats['total_investments'] }}</p>
            <div class="w-full bg-gray-100 rounded-full h-1.5">
                <div class="bg-gradient-to-r from-orange-500 to-yellow-500 h-1.5 rounded-full" style="width: 100%"></div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100 relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-orange-500/15 to-transparent rounded-full -mr-16 -mt-16 opacity-50"></div>
        <div class="relative">
            <div class="flex items-center justify-between mb-4">
                <i class="bi bi-check-circle text-orange-500 animate-pulse-soft"></i>
                <span class="text-xs text-orange-600">Active</span>
            </div>
            <h3 class="text-gray-500 text-sm mb-1 font-medium">Active Investments</h3>
            <p class="text-lg md:text-2xl font-bold text-gray-900 mb-2">{{ $stats['active_investments'] }}</p>
            <div class="w-full bg-gray-100 rounded-full h-1.5">
                @php $activeProgress = $stats['total_investments'] > 0 ? ($stats['active_investments'] / $stats['total_investments']) * 100 : 0; @endphp
                <div class="bg-gradient-to-r from-orange-500 to-yellow-500 h-1.5 rounded-full" style="width: {{ $activeProgress }}%"></div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100 relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-orange-500/15 to-transparent rounded-full -mr-16 -mt-16 opacity-50"></div>
        <div class="relative">
            <div class="flex items-center justify-between mb-4">
                <i class="bi bi-wallet2 text-orange-500 animate-wiggle"></i>
                <span class="text-xs text-orange-600">Balance</span>
            </div>
            <h3 class="text-gray-500 text-sm mb-1 font-medium">Wallet Balance</h3>
            <p class="text-lg md:text-2xl font-bold text-gray-900 mb-2">₦{{ number_format($stats['total_invested'], 0) }}</p>
            <div class="w-full bg-gray-100 rounded-full h-1.5">
                <div class="bg-gradient-to-r from-orange-500 to-yellow-500 h-1.5 rounded-full" style="width: 100%"></div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100 relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-orange-500/15 to-transparent rounded-full -mr-16 -mt-16 opacity-50"></div>
        <div class="relative">
            <div class="flex items-center justify-between mb-4">
                <i class="bi bi-star text-orange-500 animate-glow"></i>
                <span class="text-xs text-orange-600">Average</span>
            </div>
            <h3 class="text-gray-500 text-sm mb-1 font-medium">Avg Rating</h3>
            <p class="text-lg md:text-2xl font-bold text-gray-900 mb-2">{{ $stats['total_investments'] > 0 ? number_format($stats['average_roi'], 1) : '0.0' }}</p>
            <div class="w-full bg-gray-100 rounded-full h-1.5">
                @php $ratingProgress = $stats['total_investments'] > 0 ? min(100, $stats['average_roi'] * 10) : 0; @endphp
                <div class="bg-gradient-to-r from-orange-500 to-yellow-500 h-1.5 rounded-full" style="width: {{ $ratingProgress }}%"></div>
            </div>
        </div>
    </div>
</div>

<!-- Secondary Stats -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-gradient-to-br from-orange-50 to-white rounded-xl p-6 shadow-sm hover:shadow-md transition-all duration-300 border border-orange-100 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-24 h-24 bg-orange-200 rounded-full -mr-12 -mt-12 opacity-30"></div>
        <div class="relative flex items-center justify-between">
            <div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">Total Profit</h3>
                <p class="text-lg md:text-2xl font-bold text-gray-900 mb-1">₦{{ number_format($stats['total_profit'], 2) }}</p>
                <p class="text-xs text-gray-400">All time earnings</p>
            </div>
            <i class="bi bi-arrow-up-circle text-orange-500 animate-pulse-soft"></i>
        </div>
    </div>

    <div class="bg-gradient-to-br from-yellow-50 to-white rounded-xl p-6 shadow-sm hover:shadow-md transition-all duration-300 border border-yellow-100 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-24 h-24 bg-yellow-200 rounded-full -mr-12 -mt-12 opacity-30"></div>
        <div class="relative flex items-center justify-between">
            <div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">Average ROI</h3>
                <p class="text-lg md:text-2xl font-bold text-gray-900 mb-1">{{ number_format($stats['average_roi'], 2) }}%</p>
                <p class="text-xs text-gray-400">Return rate</p>
            </div>
            <i class="bi bi-graph-up text-orange-500 animate-wiggle"></i>
        </div>
    </div>

    <div class="bg-gradient-to-br from-green-50 to-white rounded-xl p-6 shadow-sm hover:shadow-md transition-all duration-300 border border-green-100 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-24 h-24 bg-green-200 rounded-full -mr-12 -mt-12 opacity-30"></div>
        <div class="relative flex items-center justify-between">
            <div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">Completed</h3>
                <p class="text-lg md:text-2xl font-bold text-gray-900 mb-1">{{ $stats['completed_investments'] }}</p>
                <p class="text-xs text-gray-400">Successfully closed</p>
            </div>
            <i class="bi bi-check-circle text-orange-500 animate-glow"></i>
        </div>
    </div>

    <div class="bg-gradient-to-br from-orange-50 to-white rounded-xl p-6 shadow-sm hover:shadow-md transition-all duration-300 border border-orange-100 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-24 h-24 bg-orange-200 rounded-full -mr-12 -mt-12 opacity-30"></div>
        <div class="relative flex flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <i class="bi bi-calendar-event text-orange-500 text-2xl"></i>
                <div>
                    <h3 class="text-gray-500 text-sm font-medium">Upcoming Maturities</h3>
                    <p class="text-lg md:text-2xl font-bold text-gray-900">{{ $stats['upcoming_maturities'] }}</p>
                </div>
            </div>
            <span class="text-xs text-gray-400">Due within 30 days</span>
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
            <p class="text-xs text-gray-500">Get started with your next move</p>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <a href="#investmentOpportunities" onclick="document.getElementById('investmentOpportunities').scrollIntoView({ behavior: 'smooth' })" 
           class="px-4 py-3 bg-gradient-to-r from-orange-500 to-yellow-500 text-white rounded-xl hover:from-orange-600 hover:to-yellow-600 font-semibold transition-all text-sm shadow-sm flex items-center justify-center gap-2">
            <i class="bi bi-plus-circle"></i>
            New Investment
        </a>
        <a href="{{ route('investor.investments') }}" class="px-4 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 font-semibold transition-all text-sm flex items-center justify-center gap-2">
            <i class="bi bi-list-ul"></i>
            View All Investments
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Recent Investments -->
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-gray-900">Recent Investments</h2>
            <a href="{{ route('investor.investments') }}" class="text-orange-600 hover:text-orange-700 text-sm font-semibold inline-flex items-center gap-1">
                View All <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        @if($recentInvestments->count() > 0)
            <div class="space-y-4">
                @foreach($recentInvestments as $investment)
                <div class="border border-gray-100 rounded-xl p-4 hover:bg-gray-50/50 transition-colors">
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="font-semibold text-gray-900 text-sm">{{ $investment->property ? Str::limit($investment->property->title, 30) : 'Property Deleted' }}</h4>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold {{ 
                            $investment->status === 'active' ? 'bg-green-100 text-green-700' : 
                            ($investment->status === 'completed' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700')
                        }}">
                            {{ ucfirst($investment->status) }}
                        </span>
                    </div>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-500 text-xs">Invested</p>
                            <p class="font-bold text-gray-900">{{ $investment->formatted_amount }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs">ROI</p>
                            <p class="font-bold text-green-600">{{ $investment->roi_percentage }}%</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center py-8 text-sm">No investments yet</p>
        @endif
    </div>

    <!-- Investment Performance -->
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
        <h2 class="text-lg font-bold text-gray-900 mb-4">Investment Performance</h2>
        
        <div class="space-y-4">
            <div class="flex items-center justify-between p-4 bg-orange-50 rounded-xl">
                <div>
                    <p class="text-xs text-gray-500 mb-1">Total Profit</p>
                    <p class="text-xl font-bold text-gray-900">₦{{ number_format($stats['total_profit'], 2) }}</p>
                </div>
                <i class="bi bi-arrow-up-circle text-blue-900 text-xl"></i>
            </div>

            <div class="flex items-center justify-between p-4 bg-yellow-50 rounded-xl">
                <div>
                    <p class="text-xs text-gray-500 mb-1">Average ROI</p>
                    <p class="text-xl font-bold text-gray-900">{{ number_format($stats['average_roi'], 2) }}%</p>
                </div>
                <i class="bi bi-graph-up text-blue-900 text-xl"></i>
            </div>

            <div class="flex items-center justify-between p-4 bg-green-50 rounded-xl">
                <div>
                    <p class="text-xs text-gray-500 mb-1">Completed</p>
                    <p class="text-xl font-bold text-gray-900">{{ $stats['completed_investments'] }}</p>
                </div>
                <i class="bi bi-check-circle text-blue-900 text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Recent Transactions -->
<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 mb-8">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-bold text-gray-900">Recent Transactions</h2>
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

<!-- Analytics Charts Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-gray-900">Investment Trend (Last 12 Months)</h2>
            <div class="flex items-center gap-2 px-3 py-1.5 bg-gray-100 rounded-lg text-sm">
                <i class="bi bi-calendar text-gray-500"></i>
                <span class="text-gray-700 font-medium">Monthly</span>
            </div>
        </div>
        <div class="flex items-center gap-4 mb-4">
            <div class="flex items-center gap-2">
                <div class="w-3 h-3 rounded-full" style="background: #1e3a5f"></div>
                <span class="text-sm text-gray-500">Amount Invested</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-3 h-3 rounded-full bg-green-500"></div>
                <span class="text-sm text-gray-500">Count</span>
            </div>
        </div>
        <div class="h-80">
            <canvas id="investmentTrendChart"></canvas>
        </div>
    </div>

    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-gray-900">Investment Status</h2>
        </div>
        <div class="h-80 flex items-center justify-center">
            <canvas id="statusChart"></canvas>
        </div>
    </div>
</div>

<!-- ROI Distribution & Upcoming Maturities -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
        <h2 class="text-lg font-bold text-gray-900 mb-4">ROI Distribution</h2>
        <div class="space-y-3">
            @foreach($roiRanges as $range => $count)
            <div>
                <div class="flex items-center justify-between mb-1">
                    <span class="text-sm font-semibold text-gray-700">{{ $range }}</span>
                    <span class="text-xs text-gray-500">{{ $count }} investment{{ $count !== 1 ? 's' : '' }}</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-2">
                    <div class="bg-gradient-to-r from-orange-500 to-yellow-500 h-2 rounded-full" style="width: {{ $stats['total_investments'] > 0 ? ($count / $stats['total_investments']) * 100 : 0 }}%"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-gray-900">Upcoming Maturities</h2>
            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-yellow-100 text-yellow-700">{{ $stats['upcoming_maturities'] }}</span>
        </div>
        
        @if($upcomingMaturities->count() > 0)
            <div class="space-y-3">
                @foreach($upcomingMaturities as $investment)
                <div class="border border-gray-100 rounded-xl p-4 hover:bg-gray-50/50 transition-colors">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="font-semibold text-gray-900 text-sm">{{ $investment->property ? Str::limit($investment->property->title, 30) : 'Property Deleted' }}</h4>
                        <span class="text-xs text-gray-500">{{ $investment->maturity_date->diffForHumans() }}</span>
                    </div>
                    <div class="grid grid-cols-2 gap-2 text-sm">
                        <div>
                            <p class="text-gray-500 text-xs">Amount</p>
                            <p class="font-bold text-gray-900">{{ $investment->formatted_amount }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs">Expected Return</p>
                            <p class="font-bold text-green-600">₦{{ number_format($investment->total_return, 2) }}</p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">
                        <i class="bi bi-calendar"></i> Matures: {{ $investment->maturity_date->format('M d, Y') }}
                    </p>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="bi bi-calendar-check text-gray-400"></i>
                </div>
                <p class="text-sm text-gray-500">No upcoming maturities in the next 30 days</p>
            </div>
        @endif
    </div>
</div>

<!-- Investment Opportunities -->
<div id="investmentOpportunities" class="mb-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl md:text-2xl font-bold text-gray-900 mb-1">Investment Opportunities</h2>
            <p class="text-sm text-gray-500">Discover properties with high ROI potential</p>
        </div>
        <div class="hidden md:flex items-center gap-2 text-sm text-gray-500">
            <i class="bi bi-info-circle text-blue-900"></i>
            <span>{{ $investmentProperties->count() }} available</span>
        </div>
    </div>
    
    @if($investmentProperties->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($investmentProperties as $property)
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-lg transition-all duration-300 group">
                <div class="relative overflow-hidden">
                    <img src="{{ $property->first_image }}" 
                         alt="{{ $property->title }}"
                         class="w-full h-56 object-cover group-hover:scale-105 transition-transform duration-500"
                         onerror="this.src='https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=600'">
                    <div class="absolute top-4 right-4">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-green-500 text-white shadow-sm">Investment</span>
                    </div>
                    <div class="absolute bottom-4 left-4">
                        <span class="bg-white/95 backdrop-blur-sm px-3 py-1.5 rounded-lg shadow-sm">
                            <span class="text-xs text-gray-500">From</span>
                            <p class="text-lg font-bold text-blue-900">{{ $property->formatted_price }}</p>
                        </span>
                    </div>
                </div>
                
                <div class="p-5">
                    <h3 class="font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-blue-900 transition-colors">{{ $property->title }}</h3>
                    <p class="text-gray-500 text-sm mb-4 line-clamp-2">{{ $property->description }}</p>
                    
                    <div class="flex items-center gap-2 text-sm text-gray-500 mb-3 pb-3 border-b border-gray-100">
                        <i class="bi bi-geo-alt-fill text-blue-900"></i>
                        <span>{{ $property->location }}</span>
                    </div>
                    
                    @if($property->roi_percentage && $property->investment_duration)
                    <div class="grid grid-cols-2 gap-3 mb-4">
                        <div class="bg-green-50 rounded-xl p-3 text-center">
                            <p class="text-xs text-gray-500 mb-1">ROI</p>
                            <p class="text-lg font-bold text-green-600">{{ $property->roi_percentage }}%</p>
                        </div>
                        <div class="bg-blue-50 rounded-xl p-3 text-center">
                            <p class="text-xs text-gray-500 mb-1">Duration</p>
                            <p class="text-lg font-bold text-blue-600">{{ $property->investment_duration }}M</p>
                        </div>
                    </div>
                    @else
                    <div class="mb-4 p-3 bg-yellow-50 rounded-xl border border-yellow-200">
                        <p class="text-xs text-yellow-800 text-center"><i class="bi bi-exclamation-triangle"></i> ROI & Duration not configured</p>
                    </div>
                    @endif

                    <button onclick="openInvestModal({{ $property->id }}, '{{ addslashes($property->title) }}', {{ $property->price }}, {{ $property->roi_percentage ?? 'null' }}, {{ $property->investment_duration ?? 'null' }})" 
                            class="w-full px-4 py-2.5 bg-gradient-to-r from-orange-500 to-yellow-500 text-white rounded-xl hover:from-orange-600 hover:to-yellow-600 font-semibold transition-all text-sm shadow-sm flex items-center justify-center gap-2 {{ !$property->roi_percentage || !$property->investment_duration ? 'opacity-50 cursor-not-allowed' : '' }}"
                            {{ !$property->roi_percentage || !$property->investment_duration ? 'disabled' : '' }}>
                        <i class="bi bi-cash-coin"></i>
                        Invest Now
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-xl border-2 border-dashed border-gray-200 p-12 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="bi bi-graph-up text-3xl text-gray-300"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-1">No Investment Opportunities</h3>
            <p class="text-sm text-gray-500">Check back later for new investment properties</p>
        </div>
    @endif
</div>

<!-- Investment Modal -->
@php $minInvestment = (float) (\App\Models\Setting::get('investor_upgrade_amount', config('bfamily.investor.upgrade_amount', 100000)) ?? 100000); @endphp
<div id="investModal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-orange-500/10 rounded-lg flex items-center justify-center">
                <i class="bi bi-cash-coin text-orange-500"></i>
            </div>
            <div>
                <h3 class="font-bold text-gray-900">Make Investment</h3>
                <p class="text-sm text-gray-500">Confirm your investment details</p>
            </div>
        </div>
        
        <form id="investForm" class="space-y-4">
            @csrf
            <input type="hidden" id="propertyId" name="property_id">
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Property</label>
                <input type="text" id="propertyTitle" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm bg-gray-50 text-gray-700" readonly>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Investment Amount (₦) *</label>
                <input type="number" id="investAmount" name="amount" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all" required 
                       min="{{ $minInvestment }}" step="0.01" oninput="calculateReturn()">
                <p class="text-xs text-gray-500 mt-1">Minimum: ₦{{ number_format($minInvestment, 2) }}</p>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">ROI Percentage</label>
                <div class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm bg-gray-50 flex items-center justify-between">
                    <span class="text-gray-700 font-semibold" id="roiPercentageDisplay">--</span>
                    <span class="text-xs text-gray-500">Set by Admin</span>
                </div>
                <p class="text-xs text-gray-500 mt-1"><i class="bi bi-info-circle"></i> ROI is set by the administrator</p>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Expected Return</label>
                <div class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm bg-green-50 text-green-700 font-bold" id="expectedReturn">₦0.00</div>
                <p class="text-xs text-gray-500 mt-1">Calculated based on investment amount and property ROI</p>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Investment Duration</label>
                <div class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm bg-gray-50 flex items-center justify-between">
                    <span class="text-gray-700 font-semibold" id="durationMonthsDisplay">--</span>
                    <span class="text-xs text-gray-500">Set by Admin</span>
                </div>
            </div>
            
            <input type="hidden" id="roiPercentage" name="roi_percentage">
            <input type="hidden" id="durationMonths" name="duration_months">

            <div class="flex gap-3 pt-2">
                <button type="submit" class="flex-1 px-4 py-2.5 bg-gradient-to-r from-orange-500 to-yellow-500 text-white rounded-xl hover:from-orange-600 hover:to-yellow-600 font-semibold transition-all text-sm shadow-sm flex items-center justify-center gap-2">
                    <i class="bi bi-check-circle"></i>
                    Confirm Investment
                </button>
                <button type="button" onclick="closeInvestModal()" class="flex-1 px-4 py-2.5 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 font-semibold transition-all text-sm">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    const trendCtx = document.getElementById('investmentTrendChart');
    if (trendCtx) {
        const trendData = @json($monthlyData);
        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: trendData.map(d => d.month),
                datasets: [{
                    label: 'Amount Invested (₦)',
                    data: trendData.map(d => d.invested),
                    borderColor: '#1e3a5f',
                    backgroundColor: 'rgba(30, 58, 95, 0.1)',
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'Number of Investments',
                    data: trendData.map(d => d.count),
                    borderColor: '#22c55e',
                    backgroundColor: 'rgba(34, 197, 94, 0.1)',
                    tension: 0.4,
                    fill: true,
                    yAxisID: 'y1'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: true, position: 'top' },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                if (context.datasetIndex === 0) {
                                    return 'Amount: ₦' + context.parsed.y.toLocaleString();
                                }
                                return 'Count: ' + context.parsed.y;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { callback: function(value) { return '₦' + value.toLocaleString(); } }
                    },
                    y1: {
                        type: 'linear', display: true, position: 'right', beginAtZero: true,
                        grid: { drawOnChartArea: false }
                    }
                }
            }
        });
    }

    const statusCtx = document.getElementById('statusChart');
    if (statusCtx) {
        const statusData = @json($statusData);
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: Object.keys(statusData).map(s => s.charAt(0).toUpperCase() + s.slice(1)),
                datasets: [{
                    data: Object.values(statusData),
                    backgroundColor: ['rgba(34, 197, 94, 0.8)', 'rgba(30, 58, 95, 0.8)', 'rgba(156, 163, 175, 0.8)'],
                    borderColor: ['#22c55e', '#1e3a5f', '#9ca3af'],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                return label + ': ' + value + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });
    }

    function openInvestModal(propertyId, propertyTitle, price, roiPercentage, durationMonths) {
        document.getElementById('propertyId').value = propertyId;
        document.getElementById('propertyTitle').value = propertyTitle;
        if (!roiPercentage || !durationMonths) {
            window.toast('This investment property does not have ROI and duration configured. Please contact admin.', 'error');
            return;
        }
        document.getElementById('roiPercentage').value = roiPercentage;
        document.getElementById('roiPercentageDisplay').textContent = roiPercentage + '%';
        document.getElementById('durationMonths').value = durationMonths;
        document.getElementById('durationMonthsDisplay').textContent = durationMonths + ' Month' + (durationMonths !== 1 ? 's' : '');
        const minAmount = {{ $minInvestment }};
        document.getElementById('investAmount').value = Math.max(parseFloat(price) || 0, minAmount);
        document.getElementById('investModal').classList.remove('hidden');
        calculateReturn();
    }

    function calculateReturn() {
        const amount = parseFloat(document.getElementById('investAmount').value) || 0;
        const roi = parseFloat(document.getElementById('roiPercentage').value) || 0;
        if (roi === 0) { document.getElementById('expectedReturn').textContent = '₦0.00'; return; }
        document.getElementById('expectedReturn').textContent = '₦' + (amount + (amount * (roi / 100))).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    function closeInvestModal() {
        document.getElementById('investModal').classList.add('hidden');
        document.getElementById('investForm').reset();
    }

    document.getElementById('investForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const form = e.target;
        const submitBtn = form.querySelector('button[type="submit"]');
        const formData = new FormData(form);
        showLoader(submitBtn);
        try {
            const propertyId = formData.get('property_id');
            const amount = parseFloat(formData.get('amount'));
            const minAmount = {{ $minInvestment }};
            if (!propertyId) { window.toast('Please select a property', 'error'); hideLoader(submitBtn); return; }
            if (isNaN(amount) || amount < minAmount) { window.toast('Minimum amount is ₦' + minAmount.toLocaleString(), 'error'); hideLoader(submitBtn); return; }
            const data = await window.ajax('{{ route("investor.invest") }}', 'POST', { property_id: propertyId, amount: amount });
            window.toast(data.message, 'success');
            closeInvestModal();
            setTimeout(() => window.location.href = data.redirect, 1500);
        } catch (error) {
            hideLoader(submitBtn);
            if (error.errors) { Object.values(error.errors).flat().forEach(msg => window.toast(msg, 'error')); }
            else if (error.response?.errors) { Object.values(error.response.errors).flat().forEach(msg => window.toast(msg, 'error')); }
            else { window.toast(error.message || 'Failed to create investment', 'error'); }
        }
    });
</script>
@endpush
