@extends('layouts.admin')

@section('title', 'Admin Dashboard')

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
        0%, 100% { box-shadow: 0 0 8px rgba(249, 115, 22, 0.3); }
        50% { box-shadow: 0 0 20px rgba(249, 115, 22, 0.6); }
    }
    .animate-float { animation: float 3s ease-in-out infinite; }
    .animate-pulse-soft { animation: pulse-soft 2s ease-in-out infinite; }
    .animate-wiggle { animation: wiggle 2s ease-in-out infinite; }
    .animate-glow { animation: glow 2s ease-in-out infinite; }
</style>
@endpush

@section('content')
<!-- Notifications Bar -->
@if($unreadNotifications > 0)
<div class="mb-6 mx-auto">
    <div class="p-4 md:p-5 bg-gradient-to-br from-orange-50 to-yellow-50 border border-orange-200 rounded-xl shadow-sm">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-full flex items-center justify-center shadow-sm flex-shrink-0">
                    <i class="bi bi-bell-fill text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900">You have {{ $unreadNotifications }} unread notification{{ $unreadNotifications > 1 ? 's' : '' }}</h3>
                    <p class="text-sm text-gray-500">Click to view all notifications</p>
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

<div class="mb-8">
    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 text-xs md:text-sm text-gray-500 mb-4 px-2 md:px-0">
        <a href="{{ route('home') }}" class="hover:text-orange-600 transition-colors">
            <i class="bi bi-house-door mr-1"></i>B-Family
        </a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-orange-600 font-semibold">Dashboard</span>
    </div>

    <!-- Hero Header -->
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
                    <i class="bi bi-speedometer2 text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-bold text-white">Dashboard</h1>
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

<!-- Pending Approvals Alert -->
@if($pendingApprovals['properties'] > 0 || $pendingApprovals['investor_requests'] > 0 || $pendingApprovals['agent_requests'] > 0 || $pendingApprovals['payments'] > 0)
<div class="mb-8">
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 p-4 md:p-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-orange-500/10 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="bi bi-exclamation-triangle text-orange-500"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 text-sm">Action Required</h3>
                    <p class="text-xs text-gray-500">Pending approvals need your attention</p>
                </div>
            </div>

            <div class="flex flex-wrap gap-2">
                @if($pendingApprovals['properties'] > 0)
                <a href="{{ route('admin.properties') }}?status=pending" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gradient-to-r from-orange-500 to-yellow-500 text-white rounded-lg hover:from-orange-600 hover:to-yellow-600 font-semibold transition-all text-xs shadow-sm">
                    <span>{{ $pendingApprovals['properties'] }}</span>
                    <span>Properties</span>
                </a>
                @endif
                @if($pendingApprovals['investor_requests'] > 0)
                <a href="{{ route('admin.users') }}?pending=investor" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gradient-to-r from-orange-500 to-yellow-500 text-white rounded-lg hover:from-orange-600 hover:to-yellow-600 font-semibold transition-all text-xs shadow-sm">
                    <span>{{ $pendingApprovals['investor_requests'] }}</span>
                    <span>Investors</span>
                </a>
                @endif
                @if($pendingApprovals['agent_requests'] > 0)
                <a href="{{ route('admin.users') }}?pending=agent" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gradient-to-r from-orange-500 to-yellow-500 text-white rounded-lg hover:from-orange-600 hover:to-yellow-600 font-semibold transition-all text-xs shadow-sm">
                    <span>{{ $pendingApprovals['agent_requests'] }}</span>
                    <span>Agents</span>
                </a>
                @endif
                @if($pendingApprovals['payments'] > 0)
                <a href="{{ route('admin.payments') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gradient-to-r from-orange-500 to-yellow-500 text-white rounded-lg hover:from-orange-600 hover:to-yellow-600 font-semibold transition-all text-xs shadow-sm">
                    <span>{{ $pendingApprovals['payments'] }}</span>
                    <span>Payments</span>
                </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endif

<!-- Main Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Revenue -->
    <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100 relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-900/15 to-transparent rounded-full -mr-16 -mt-16 opacity-50"></div>
        <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <i class="bi bi-currency-dollar text-orange-500 animate-float"></i>
                    <span class="text-xs text-blue-700">All Time</span>
                </div>
                <h3 class="text-gray-500 text-sm mb-1 font-medium">Total Revenue</h3>
            <p class="text-2xl font-bold text-gray-900 mb-2">₦{{ number_format($stats['total_revenue'], 0) }}</p>
            <div class="w-full bg-gray-100 rounded-full h-1.5">
                <div class="bg-gradient-to-r from-orange-500 to-yellow-500 h-1.5 rounded-full" style="width: 100%"></div>
            </div>
        </div>
    </div>

    <!-- Total Users -->
    <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100 relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-900/15 to-transparent rounded-full -mr-16 -mt-16 opacity-50"></div>
        <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <i class="bi bi-people-fill text-orange-500 animate-pulse-soft"></i>
                    <span class="text-xs text-blue-700">Current</span>
                </div>
                <h3 class="text-gray-500 text-sm mb-1 font-medium">Total Users</h3>
            <p class="text-2xl font-bold text-gray-900 mb-2">{{ number_format($stats['total_users']) }}</p>
            <div class="w-full bg-gray-100 rounded-full h-1.5">
                @php
                    $userProgress = min(100, ($stats['total_users'] / max(1000, $stats['total_users'])) * 100);
                @endphp
                <div class="bg-gradient-to-r from-orange-500 to-yellow-500 h-1.5 rounded-full" style="width: {{ $userProgress }}%"></div>
            </div>
        </div>
    </div>

    <!-- New Properties -->
    <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100 relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-900/15 to-transparent rounded-full -mr-16 -mt-16 opacity-50"></div>
        <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <i class="bi bi-building-check text-orange-500 animate-wiggle"></i>
                    <span class="text-xs text-blue-700">This Month</span>
                </div>
                <h3 class="text-gray-500 text-sm mb-1 font-medium">New Properties</h3>
            <p class="text-2xl font-bold text-gray-900 mb-2">{{ $analytics['new_properties'] }}</p>
            <div class="w-full bg-gray-100 rounded-full h-1.5">
                @php
                    $propertyProgress = min(100, ($analytics['new_properties'] / max(50, $analytics['new_properties'])) * 100);
                @endphp
                <div class="bg-gradient-to-r from-orange-500 to-yellow-500 h-1.5 rounded-full" style="width: {{ $propertyProgress }}%"></div>
            </div>
        </div>
    </div>

    <!-- Inspections -->
    <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100 relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-900/15 to-transparent rounded-full -mr-16 -mt-16 opacity-50"></div>
        <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <i class="bi bi-calendar-check-fill text-orange-500 animate-glow"></i>
                    <span class="text-xs text-blue-700">Active</span>
                </div>
                <h3 class="text-gray-500 text-sm mb-1 font-medium">Inspections</h3>
            <p class="text-2xl font-bold text-gray-900 mb-2">{{ number_format($stats['total_inspections']) }}</p>
            <div class="w-full bg-gray-100 rounded-full h-1.5">
                @php
                    $inspectionProgress = $stats['total_inspections'] > 0 ? min(100, ($stats['confirmed_inspections'] / $stats['total_inspections']) * 100) : 0;
                @endphp
                <div class="bg-gradient-to-r from-orange-500 to-yellow-500 h-1.5 rounded-full" style="width: {{ $inspectionProgress }}%"></div>
            </div>
        </div>
    </div>
</div>

<!-- Secondary Stats -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-gradient-to-br from-orange-50 to-white rounded-xl p-6 shadow-sm hover:shadow-md transition-all duration-300 border border-orange-100 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-24 h-24 bg-orange-200 rounded-full -mr-12 -mt-12 opacity-30"></div>
        <div class="relative flex items-center justify-between">
            <div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">Active Investments</h3>
                <p class="text-2xl font-bold text-gray-900 mb-1">{{ $stats['active_investments'] }}</p>
                <p class="text-xs text-gray-400">Currently active</p>
            </div>
            <i class="bi bi-graph-up-arrow text-orange-500 animate-pulse-soft"></i>
        </div>
    </div>

    <div class="bg-gradient-to-br from-yellow-50 to-white rounded-xl p-6 shadow-sm hover:shadow-md transition-all duration-300 border border-yellow-100 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-24 h-24 bg-yellow-200 rounded-full -mr-12 -mt-12 opacity-30"></div>
        <div class="relative flex items-center justify-between">
            <div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">Featured Properties</h3>
                <p class="text-2xl font-bold text-gray-900 mb-1">{{ \App\Models\Property::where('is_featured', true)->count() }}</p>
                <p class="text-xs text-gray-400">Premium listings</p>
            </div>
            <i class="bi bi-star-fill text-orange-500 animate-wiggle"></i>
        </div>
    </div>

    <div class="bg-gradient-to-br from-orange-50 to-white rounded-xl p-6 shadow-sm hover:shadow-md transition-all duration-300 border border-orange-100 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-24 h-24 bg-orange-200 rounded-full -mr-12 -mt-12 opacity-30"></div>
        <div class="relative flex items-center justify-between">
            <div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">Pending Properties</h3>
                <p class="text-2xl font-bold text-gray-900 mb-1">{{ $stats['pending_properties'] }}</p>
                <p class="text-xs text-gray-400">Awaiting approval</p>
            </div>
            <i class="bi bi-hourglass-split text-orange-500 animate-float"></i>
        </div>
    </div>

    <div class="bg-gradient-to-br from-yellow-50 to-white rounded-xl p-6 shadow-sm hover:shadow-md transition-all duration-300 border border-yellow-100 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-24 h-24 bg-yellow-200 rounded-full -mr-12 -mt-12 opacity-30"></div>
        <div class="relative flex items-center justify-between">
            <div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">Total Payments</h3>
                <p class="text-2xl font-bold text-gray-900 mb-1">{{ $stats['total_payments'] }}</p>
                <p class="text-xs text-gray-400">All transactions</p>
            </div>
            <i class="bi bi-credit-card-2-front-fill text-orange-500 animate-glow"></i>
        </div>
    </div>
</div>

<!-- Analytics Charts Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Monthly Income Chart -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-gray-900">Monthly Avg. Income</h2>
            <div class="flex items-center gap-2 px-3 py-1.5 bg-gray-100 rounded-lg text-sm">
                <i class="bi bi-calendar text-gray-500"></i>
                <span class="text-gray-700 font-medium">This Month</span>
                <i class="bi bi-chevron-down text-xs text-gray-500"></i>
            </div>
        </div>
        <div class="flex items-center gap-4 mb-4">
            <div class="flex items-center gap-2">
                <div class="w-3 h-3 rounded-full" style="background: #f97316"></div>
                <span class="text-sm text-gray-500">New Visits</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-3 h-3 bg-gray-400 rounded-full"></div>
                <span class="text-sm text-gray-500">Unique Visits</span>
            </div>
        </div>
        <div class="h-80">
            <canvas id="growthChart"></canvas>
        </div>
    </div>

    <!-- Customers Chart -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-gray-900">Customers</h2>
        </div>

        <div class="h-80 flex items-center justify-center">
            <canvas id="customersChart" style="max-width: 300px; max-height: 300px;"></canvas>
        </div>
        <div class="mt-4 flex items-center justify-center gap-2 text-sm text-gray-500">
            <i class="bi bi-calendar"></i>
            <span>01 January {{ now()->year }} to 31 December {{ now()->year }}</span>
        </div>
    </div>
</div>

<!-- Financial Overview -->
<div class="bg-white rounded-xl border border-gray-100 shadow-sm mb-6 mx-1 md:mx-0">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 p-6 pb-5 border-b border-gray-100">
        <div>
            <h2 class="text-lg font-bold text-gray-900"><i class="bi bi-cash-stack mr-2 text-orange-500"></i>Financial Overview</h2>
            <p class="text-xs text-gray-400 mt-0.5">Profit = Total Sales − Total Purchases − Total Expenses</p>
        </div>
        <a href="{{ route('admin.finance') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-900 text-white rounded-lg hover:bg-blue-800 text-sm font-semibold transition-all shadow-sm">
            <i class="bi bi-bar-chart-line"></i> Finance & Reports
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 p-6">
        <div class="rounded-xl p-5 border relative overflow-hidden bg-gradient-to-br from-green-50 to-white border-green-100">
            <div class="relative">
                <div class="flex items-center justify-between mb-2">
                    <i class="bi bi-graph-up-arrow text-green-600"></i>
                    <span class="text-xs text-green-600 font-medium bg-green-100 px-2 py-0.5 rounded-full">All Time</span>
                </div>
                <h3 class="text-gray-500 text-xs font-medium mb-1">Total Sales</h3>
                <p class="text-xl font-bold text-gray-900">₦{{ number_format($finance['total_sales'], 0) }}</p>
            </div>
        </div>
        <div class="rounded-xl p-5 border relative overflow-hidden bg-gradient-to-br from-blue-50 to-white border-blue-100">
            <div class="relative">
                <div class="flex items-center justify-between mb-2">
                    <i class="bi bi-cart-check text-blue-600"></i>
                    <span class="text-xs text-blue-600 font-medium bg-blue-100 px-2 py-0.5 rounded-full">All Time</span>
                </div>
                <h3 class="text-gray-500 text-xs font-medium mb-1">Total Purchases</h3>
                <p class="text-xl font-bold text-gray-900">₦{{ number_format($finance['total_purchases'], 0) }}</p>
            </div>
        </div>
        <div class="rounded-xl p-5 border relative overflow-hidden bg-gradient-to-br from-rose-50 to-white border-rose-100">
            <div class="relative">
                <div class="flex items-center justify-between mb-2">
                    <i class="bi bi-receipt-cutoff text-rose-600"></i>
                    <span class="text-xs text-rose-600 font-medium bg-rose-100 px-2 py-0.5 rounded-full">All Time</span>
                </div>
                <h3 class="text-gray-500 text-xs font-medium mb-1">Total Expenses</h3>
                <p class="text-xl font-bold text-gray-900">₦{{ number_format($finance['total_expenses'], 0) }}</p>
            </div>
        </div>
        <div class="rounded-xl p-5 border relative overflow-hidden {{ $finance['net_profit'] >= 0 ? 'bg-gradient-to-br from-blue-900 to-blue-800 border-blue-900' : 'bg-gradient-to-br from-rose-600 to-rose-700 border-rose-600' }}">
            <div class="relative">
                <div class="flex items-center justify-between mb-2">
                    <i class="bi bi-piggy-bank text-white"></i>
                    <span class="text-xs bg-white/15 text-white px-2 py-0.5 rounded-full">All Time</span>
                </div>
                <h3 class="text-blue-100/70 text-xs font-medium mb-1">Net Profit</h3>
                <p class="text-xl font-bold text-white">₦{{ number_format($finance['net_profit'], 0) }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 p-6 pt-0">
        <div class="bg-gray-50/60 rounded-xl p-5 border border-gray-100">
            <h3 class="font-bold text-gray-900 text-sm mb-4">Sales vs Purchases vs Expenses <span class="text-gray-400 font-normal">(last 6 months)</span></h3>
            <div class="h-64">
                <canvas id="financeChart"></canvas>
            </div>
        </div>
        <div class="bg-gray-50/60 rounded-xl p-5 border border-gray-100">
            <h3 class="font-bold text-gray-900 text-sm mb-4">Expense Breakdown <span class="text-gray-400 font-normal">(all time)</span></h3>
            <div class="h-64 flex items-center justify-center">
                <canvas id="financeExpenseChart" style="max-width: 240px; max-height: 240px;"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <a href="{{ route('admin.properties') }}?status=pending" class="group bg-gradient-to-br from-orange-50 to-white rounded-xl p-6 hover:shadow-md transition-all duration-300 hover:-translate-y-0.5 border border-orange-100 shadow-sm relative overflow-hidden">
        <div class="absolute top-0 right-0 w-20 h-20 bg-orange-200 rounded-full -mr-10 -mt-10 opacity-30"></div>
        <div class="relative flex items-center justify-between">
            <div>
                <h3 class="font-bold text-gray-900 text-sm mb-1">Pending Properties</h3>
                <p class="text-2xl font-bold text-orange-600 mb-1">{{ $stats['pending_properties'] }}</p>
                <p class="text-xs text-gray-400">Awaiting approval</p>
            </div>
            <i class="bi bi-house-exclamation text-orange-500 animate-float"></i>
        </div>
    </a>

    <a href="{{ route('admin.users') }}?pending=agent" class="group bg-gradient-to-br from-yellow-50 to-white rounded-xl p-6 hover:shadow-md transition-all duration-300 hover:-translate-y-0.5 border border-yellow-100 shadow-sm relative overflow-hidden">
        <div class="absolute top-0 right-0 w-20 h-20 bg-yellow-200 rounded-full -mr-10 -mt-10 opacity-30"></div>
        <div class="relative flex items-center justify-between">
            <div>
                <h3 class="font-bold text-gray-900 text-sm mb-1">Agent Requests</h3>
                <p class="text-2xl font-bold text-orange-600 mb-1">{{ $pendingApprovals['agent_requests'] }}</p>
                <p class="text-xs text-gray-400">Pending verification</p>
            </div>
            <i class="bi bi-person-badge-fill text-orange-500 animate-pulse-soft"></i>
        </div>
    </a>

    <a href="{{ route('admin.users') }}?pending=investor" class="group bg-gradient-to-br from-orange-50 to-white rounded-xl p-6 hover:shadow-md transition-all duration-300 hover:-translate-y-0.5 border border-orange-100 shadow-sm relative overflow-hidden">
        <div class="absolute top-0 right-0 w-20 h-20 bg-orange-200 rounded-full -mr-10 -mt-10 opacity-30"></div>
        <div class="relative flex items-center justify-between">
            <div>
                <h3 class="font-bold text-gray-900 text-sm mb-1">Investor Requests</h3>
                <p class="text-2xl font-bold text-orange-600 mb-1">{{ $pendingApprovals['investor_requests'] }}</p>
                <p class="text-xs text-gray-400">Awaiting approval</p>
            </div>
            <i class="bi bi-graph-up-arrow text-orange-500 animate-wiggle"></i>
        </div>
    </a>

    <a href="{{ route('admin.payments') }}" class="group bg-gradient-to-br from-yellow-50 to-white rounded-xl p-6 hover:shadow-md transition-all duration-300 hover:-translate-y-0.5 border border-yellow-100 shadow-sm relative overflow-hidden">
        <div class="absolute top-0 right-0 w-20 h-20 bg-yellow-200 rounded-full -mr-10 -mt-10 opacity-30"></div>
        <div class="relative flex items-center justify-between">
            <div>
                <h3 class="font-bold text-gray-900 text-sm mb-1">Pending Payments</h3>
                <p class="text-2xl font-bold text-orange-600 mb-1">{{ $pendingApprovals['payments'] }}</p>
                <p class="text-xs text-gray-400">Awaiting processing</p>
            </div>
            <i class="bi bi-credit-card-2-front-fill text-orange-500 animate-glow"></i>
        </div>
    </a>
</div>

<!-- Management Sections -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <a href="{{ route('admin.users') }}" class="bg-white rounded-xl p-6 hover:shadow-md transition-all duration-300 hover:-translate-y-0.5 group border border-gray-100 shadow-sm">
        <div class="flex items-center gap-4">
            <i class="bi bi-people-fill text-orange-500 animate-pulse-soft"></i>
            <div>
                <h3 class="font-bold text-gray-900 text-lg">Manage Users</h3>
                <p class="text-sm text-gray-500">View, filter & manage all users</p>
            </div>
        </div>
    </a>

    <a href="{{ route('admin.properties') }}" class="bg-white rounded-xl p-6 hover:shadow-md transition-all duration-300 hover:-translate-y-0.5 group border border-gray-100 shadow-sm">
        <div class="flex items-center gap-4">
            <i class="bi bi-building-check text-orange-500 animate-float"></i>
            <div>
                <h3 class="font-bold text-gray-900 text-lg">Manage Properties</h3>
                <p class="text-sm text-gray-500">Approve or reject listings</p>
            </div>
        </div>
    </a>

    <a href="{{ route('admin.bookings') }}" class="bg-white rounded-xl p-6 hover:shadow-md transition-all duration-300 hover:-translate-y-0.5 group border border-gray-100 shadow-sm">
        <div class="flex items-center gap-4">
            <i class="bi bi-calendar-check-fill text-orange-500 animate-wiggle"></i>
            <div>
                <h3 class="font-bold text-gray-900 text-lg">Manage Inspections</h3>
                <p class="text-sm text-gray-500">Assign & track bookings</p>
            </div>
        </div>
    </a>

    <a href="{{ route('admin.payments') }}" class="bg-white rounded-xl p-6 hover:shadow-md transition-all duration-300 hover:-translate-y-0.5 group border border-gray-100 shadow-sm">
        <div class="flex items-center gap-4">
            <i class="bi bi-credit-card-2-front-fill text-orange-500 animate-glow"></i>
            <div>
                <h3 class="font-bold text-gray-900 text-lg">Manage Payments</h3>
                <p class="text-sm text-gray-500">Approve payment proofs</p>
            </div>
        </div>
    </a>

    <a href="{{ route('admin.investments') }}" class="bg-white rounded-xl p-6 hover:shadow-md transition-all duration-300 hover:-translate-y-0.5 group border border-gray-100 shadow-sm">
        <div class="flex items-center gap-4">
            <i class="bi bi-graph-up-arrow text-orange-500 animate-pulse-soft"></i>
            <div>
                <h3 class="font-bold text-gray-900 text-lg">Manage Investments</h3>
                <p class="text-sm text-gray-500">Track ROI & withdrawals</p>
            </div>
        </div>
    </a>

    <a href="{{ route('admin.settings') }}" class="bg-white rounded-xl p-6 hover:shadow-md transition-all duration-300 hover:-translate-y-0.5 group border border-gray-100 shadow-sm">
        <div class="flex items-center gap-4">
            <i class="bi bi-gear-wide-connected text-orange-500 animate-wiggle"></i>
            <div>
                <h3 class="font-bold text-gray-900 text-lg">System Settings</h3>
                <p class="text-sm text-gray-500">Configure platform settings</p>
            </div>
        </div>
    </a>
</div>

<!-- Recent Activity -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Properties -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-gray-900">Recent Properties</h3>
            <a href="{{ route('admin.properties') }}" class="text-orange-600 hover:text-orange-700 text-sm font-semibold flex items-center gap-1">
                View All <i class="bi bi-arrow-right"></i>
            </a>
        </div>
        <div class="space-y-4">
            @forelse($recentProperties as $property)
            <div class="flex items-center gap-4 pb-4 border-b border-gray-100 last:border-0 hover:bg-gray-50 p-3 rounded-lg transition-colors">
                <img src="{{ $property->first_image ?? 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=100' }}"
                     alt="{{ $property->title }}"
                     class="w-14 h-14 object-cover rounded-xl shadow-sm">
                <div class="flex-1 min-w-0">
                    <h4 class="font-semibold text-gray-900 truncate mb-1">{{ $property->title }}</h4>
                    <p class="text-sm text-gray-500 mb-2">By {{ $property->agent->name }}</p>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $property->approval_status === 'approved' ? 'bg-orange-100 text-orange-700' : ($property->approval_status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-600') }}">
                        {{ ucfirst($property->approval_status) }}
                    </span>
                </div>
            </div>
            @empty
            <p class="text-gray-500 text-center py-8">No recent properties</p>
            @endforelse
        </div>
    </div>

    <!-- Recent Users -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-gray-900">Recent Users</h3>
            <a href="{{ route('admin.users') }}" class="text-orange-600 hover:text-orange-700 text-sm font-semibold flex items-center gap-1">
                View All <i class="bi bi-arrow-right"></i>
            </a>
        </div>
        <div class="space-y-4">
            @forelse($recentUsers as $user)
            <div class="flex items-center justify-between pb-4 border-b border-gray-100 last:border-0 hover:bg-gray-50 p-3 rounded-lg transition-colors">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-full flex items-center justify-center text-white font-bold shadow-sm">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">{{ $user->name }}</h4>
                        <p class="text-sm text-gray-500">{{ Str::limit($user->email, 25) }}</p>
                    </div>
                </div>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-700">
                    {{ ucfirst($user->role) }}
                </span>
            </div>
            @empty
            <p class="text-gray-500 text-center py-8">No recent users</p>
            @endforelse
        </div>
    </div>

    <!-- Top Agents -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-gray-900">Top Agents</h3>
            <a href="{{ route('admin.users') }}?role=agent" class="text-orange-600 hover:text-orange-700 text-sm font-semibold flex items-center gap-1">
                View All <i class="bi bi-arrow-right"></i>
            </a>
        </div>
        <div class="space-y-4">
            @forelse($topAgents as $agent)
            <div class="flex items-center justify-between pb-4 border-b border-gray-100 last:border-0 hover:bg-gray-50 p-3 rounded-lg transition-colors">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-full flex items-center justify-center text-white font-bold shadow-sm">
                        {{ substr($agent->name, 0, 1) }}
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">{{ $agent->name }}</h4>
                        <p class="text-sm text-gray-500">{{ $agent->properties_count }} Properties</p>
                    </div>
                </div>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-700">
                    Active
                </span>
            </div>
            @empty
            <p class="text-gray-500 text-center py-8">No agents yet</p>
            @endforelse
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-gray-900">Recent Transactions</h3>
            <a href="{{ route('admin.payments') }}" class="text-orange-600 hover:text-orange-700 text-sm font-semibold flex items-center gap-1">
                View All <i class="bi bi-arrow-right"></i>
            </a>
        </div>
        <div class="space-y-4">
            @forelse($recentPayments as $payment)
            <div class="flex items-center gap-4 pb-4 border-b border-gray-100 last:border-0 hover:bg-gray-50 p-3 rounded-lg transition-colors">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 {{ 
                    $payment->status === 'approved' ? 'bg-green-100 text-green-600' : 
                    ($payment->status === 'pending' ? 'bg-yellow-100 text-yellow-600' : 'bg-red-100 text-red-600')
                }}">
                    <i class="bi {{ $payment->status === 'approved' ? 'bi-check-circle' : ($payment->status === 'pending' ? 'bi-clock-history' : 'bi-x-circle') }}"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between gap-2">
                        <h4 class="font-semibold text-gray-900 text-sm truncate">{{ Str::limit($payment->property->title ?? 'Property', 26) }}</h4>
                        <span class="font-bold text-gray-900 text-sm flex-shrink-0">{{ $payment->formatted_amount }}</span>
                    </div>
                    <div class="flex items-center justify-between gap-2 mt-1">
                        <p class="text-xs text-gray-500 truncate">
                            {{ $payment->buyer_name }} · {{ $payment->created_at->format('M d, Y') }} · {{ ucfirst($payment->type) }}
                        </p>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium flex-shrink-0 {{ 
                            $payment->status === 'approved' ? 'bg-green-100 text-green-700' : 
                            ($payment->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700')
                        }}">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </div>
                </div>
            </div>
            @empty
            <p class="text-gray-500 text-center py-8">No transactions yet</p>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Monthly Income Chart (Area Chart)
    const growthCtx = document.getElementById('growthChart');
    if (growthCtx) {
        new Chart(growthCtx, {
            type: 'line',
            data: {
                labels: @json(array_column($monthlyData, 'month')),
                datasets: [
                    {
                        label: 'New Visits',
                        data: @json(array_column($monthlyData, 'users')),
                        borderColor: '#f97316',
                        backgroundColor: 'rgba(249, 115, 22, 0.15)',
                        tension: 0.4,
                        fill: true,
                        pointRadius: 0,
                        pointHoverRadius: 5,
                    },
                    {
                        label: 'Unique Visits',
                        data: @json(array_column($monthlyData, 'properties')),
                        borderColor: 'rgba(156, 163, 175, 0.6)',
                        backgroundColor: 'rgba(156, 163, 175, 0.08)',
                        tension: 0.4,
                        fill: true,
                        pointRadius: 0,
                        pointHoverRadius: 5,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleFont: { size: 14 },
                        bodyFont: { size: 13 },
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 250,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                        }
                    }
                }
            }
        });
    }

    // Customers Donut Chart
    const customersCtx = document.getElementById('customersChart');
    if (customersCtx) {
        const totalUsers = {{ $stats['total_users'] }};
        const newUsers = {{ $analytics['new_users'] }};
        const activeUsers = {{ $stats['total_agents'] + $stats['total_investors'] }};
        const retargetedUsers = totalUsers - newUsers - activeUsers;

        new Chart(customersCtx, {
            type: 'doughnut',
            data: {
                labels: ['Current', 'New', 'Retargeted'],
                datasets: [{
                    data: [activeUsers, newUsers, Math.max(0, retargetedUsers)],
                    backgroundColor: [
                        '#f97316',
                        'rgba(234, 179, 8, 0.8)',
                        'rgba(156, 163, 175, 0.5)'
                    ],
                    borderWidth: 0,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            usePointStyle: true,
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                    }
                }
            }
        });
    }

    // Financial Performance Chart (Grouped Bar)
    const financeCtx = document.getElementById('financeChart');
    if (financeCtx) {
        new Chart(financeCtx, {
            type: 'bar',
            data: {
                labels: @json(array_column($financeMonthly, 'month')),
                datasets: [
                    {
                        label: 'Sales',
                        data: @json(array_column($financeMonthly, 'sales')),
                        backgroundColor: 'rgba(16, 185, 129, 0.85)',
                        borderRadius: 6,
                    },
                    {
                        label: 'Purchases',
                        data: @json(array_column($financeMonthly, 'purchases')),
                        backgroundColor: 'rgba(37, 99, 235, 0.85)',
                        borderRadius: 6,
                    },
                    {
                        label: 'Expenses',
                        data: @json(array_column($financeMonthly, 'expenses')),
                        backgroundColor: 'rgba(225, 29, 72, 0.85)',
                        borderRadius: 6,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { padding: 12, usePointStyle: true, font: { size: 12 } }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        callbacks: {
                            label: function(ctx) { return ' ' + ctx.dataset.label + ': ₦' + Number(ctx.parsed.y).toLocaleString(); }
                        }
                    }
                },
                scales: {
                    y: { beginAtZero: true, grid: { color: 'rgba(0, 0, 0, 0.05)' }, ticks: { callback: function(v) { return '₦' + (v >= 1000 ? (v / 1000) + 'k' : v); } } },
                    x: { grid: { display: false } }
                }
            }
        });
    }

    // Financial Expense Breakdown (Donut)
    const financeExpenseCtx = document.getElementById('financeExpenseChart');
    if (financeExpenseCtx) {
        const breakdown = @json($expenseBreakdown);
        const hasData = breakdown.length > 0 && breakdown.some(b => Number(b.total) > 0);
        new Chart(financeExpenseCtx, {
            type: 'doughnut',
            data: {
                labels: hasData ? breakdown.map(b => b.category) : ['No expenses'],
                datasets: [{
                    data: hasData ? breakdown.map(b => Number(b.total)) : [1],
                    backgroundColor: hasData
                        ? ['#f97316', '#eab308', '#1e3a8a', '#10b981', '#e11d48', '#8b5cf6'].slice(0, breakdown.length)
                        : ['#e5e7eb'],
                    borderWidth: 2,
                    borderColor: '#fff',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                cutout: '62%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { padding: 10, usePointStyle: true, font: { size: 11 } }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        callbacks: {
                            label: function(ctx) { return ' ' + ctx.label + ': ₦' + Number(ctx.parsed).toLocaleString(); }
                        }
                    }
                }
            }
        });
    }

    // Mark notification as read
    async function markAsRead(notificationId) {
        try {
            const data = await window.ajax(`{{ route("notifications.read", ":id") }}`.replace(':id', notificationId), 'POST');
            if (data.success) {
                setTimeout(() => window.location.reload(), 500);
            }
        } catch (error) {
            console.error('Failed to mark notification as read', error);
        }
    }
</script>
@endpush