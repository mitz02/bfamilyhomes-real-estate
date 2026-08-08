@extends('layouts.agent')

@section('title', 'Agent Dashboard')

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

<!-- Hero Header -->
<div class="mb-8">
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
                    <h1 class="text-xl md:text-2xl font-bold text-white">Agent Dashboard</h1>
                    <p class="text-blue-100/80 text-sm mt-0.5">Manage your properties and track performance</p>
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

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Properties -->
    <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100 relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-orange-500/15 to-transparent rounded-full -mr-16 -mt-16 opacity-50"></div>
        <div class="relative">
            <div class="flex items-center justify-between mb-4">
                <i class="bi bi-house-door text-orange-500"></i>
                <span class="text-xs text-orange-600">Total</span>
            </div>
            <h3 class="text-gray-500 text-sm mb-1 font-medium">Total Properties</h3>
            <p class="text-lg md:text-2xl font-bold text-gray-900 mb-2">{{ $stats['total_properties'] }}</p>
            <div class="w-full bg-gray-100 rounded-full h-1.5">
                <div class="bg-gradient-to-r from-orange-500 to-yellow-500 h-1.5 rounded-full" style="width: 100%"></div>
            </div>
        </div>
    </div>

    <!-- Approved Properties -->
    <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100 relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-orange-500/15 to-transparent rounded-full -mr-16 -mt-16 opacity-50"></div>
        <div class="relative">
            <div class="flex items-center justify-between mb-4">
                <i class="bi bi-check-circle text-orange-500"></i>
                <span class="text-xs text-orange-600">Approved</span>
            </div>
            <h3 class="text-gray-500 text-sm mb-1 font-medium">Approved Properties</h3>
            <p class="text-lg md:text-2xl font-bold text-gray-900 mb-2">{{ $stats['approved_properties'] }}</p>
            <div class="w-full bg-gray-100 rounded-full h-1.5">
                @php $approvedProgress = $stats['total_properties'] > 0 ? ($stats['approved_properties'] / $stats['total_properties']) * 100 : 0; @endphp
                <div class="bg-gradient-to-r from-orange-500 to-yellow-500 h-1.5 rounded-full" style="width: {{ $approvedProgress }}%"></div>
            </div>
        </div>
    </div>

    <!-- Pending Properties -->
    <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100 relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-orange-500/15 to-transparent rounded-full -mr-16 -mt-16 opacity-50"></div>
        <div class="relative">
            <div class="flex items-center justify-between mb-4">
                <i class="bi bi-clock-history text-orange-500"></i>
                <span class="text-xs text-orange-600">Pending</span>
            </div>
            <h3 class="text-gray-500 text-sm mb-1 font-medium">Pending Approval</h3>
            <p class="text-lg md:text-2xl font-bold text-gray-900 mb-2">{{ $stats['pending_properties'] }}</p>
            <div class="w-full bg-gray-100 rounded-full h-1.5">
                @php $pendingProgress = $stats['total_properties'] > 0 ? ($stats['pending_properties'] / $stats['total_properties']) * 100 : 0; @endphp
                <div class="bg-gradient-to-r from-orange-500 to-yellow-500 h-1.5 rounded-full" style="width: {{ $pendingProgress }}%"></div>
            </div>
        </div>
    </div>

    <!-- Total Inspections -->
    <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100 relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-orange-500/15 to-transparent rounded-full -mr-16 -mt-16 opacity-50"></div>
        <div class="relative">
            <div class="flex items-center justify-between mb-4">
                <i class="bi bi-calendar-check text-orange-500"></i>
                <span class="text-xs text-orange-600">Total</span>
            </div>
            <h3 class="text-gray-500 text-sm mb-1 font-medium">Total Inspections</h3>
            <p class="text-lg md:text-2xl font-bold text-gray-900 mb-2">{{ $stats['total_inspections'] }}</p>
            <div class="w-full bg-gray-100 rounded-full h-1.5">
                <div class="bg-gradient-to-r from-orange-500 to-yellow-500 h-1.5 rounded-full" style="width: 100%"></div>
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
            <p class="text-xs text-gray-500">Manage your properties and bookings</p>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <a href="{{ route('agent.properties.create') }}" class="px-4 py-3 bg-gradient-to-r from-orange-500 to-yellow-500 text-white rounded-xl hover:from-orange-600 hover:to-yellow-600 font-semibold transition-all text-sm shadow-sm flex items-center justify-center gap-2">
            <i class="bi bi-plus-circle"></i>
            Add New Property
        </a>
        <a href="{{ route('agent.properties.index') }}" class="px-4 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 font-semibold transition-all text-sm flex items-center justify-center gap-2">
            <i class="bi bi-house-door"></i>
            My Properties
        </a>
        <a href="{{ route('agent.bookings') }}" class="px-4 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 font-semibold transition-all text-sm flex items-center justify-center gap-2">
            <i class="bi bi-calendar-check"></i>
            View Bookings
        </a>
        <a href="{{ route('agent.inquiries') }}" class="px-4 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 font-semibold transition-all text-sm flex items-center justify-center gap-2">
            <i class="bi bi-chat-dots"></i>
            View Inquiries
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Recent Properties -->
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-gray-900">Recent Properties</h2>
            <a href="{{ route('agent.properties.index') }}" class="text-orange-600 hover:text-orange-700 text-sm font-semibold inline-flex items-center gap-1">
                View All <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        @if($recentProperties->count() > 0)
            <div class="space-y-4">
                @foreach($recentProperties as $property)
                <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                    <div class="flex items-center gap-3">
                        <img src="{{ $property->first_image }}" 
                             alt="{{ $property->title }}"
                             class="w-16 h-16 object-cover rounded-lg ring-2 ring-gray-100"
                             onerror="this.src='https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=100'">
                        <div>
                            <h4 class="font-semibold text-gray-900 text-sm">{{ Str::limit($property->title, 30) }}</h4>
                            <p class="text-sm text-gray-600">{{ $property->formatted_price }}</p>
                        </div>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold {{ 
                        $property->approval_status === 'approved' ? 'bg-green-100 text-green-700' : 
                        ($property->approval_status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700')
                    }}">
                        {{ ucfirst($property->approval_status) }}
                    </span>
                </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center py-8 text-sm">No properties yet</p>
        @endif
    </div>

    <!-- Recent Inspections -->
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
        <h2 class="text-lg font-bold text-gray-900 mb-4">Recent Inspections</h2>

        @if($recentInspections->count() > 0)
            <div class="space-y-4">
                @foreach($recentInspections as $inspection)
                <div class="py-3 border-b border-gray-100 last:border-0">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="font-semibold text-gray-900 text-sm">{{ $inspection->user->name }}</h4>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold {{ 
                            $inspection->status === 'confirmed' ? 'bg-green-100 text-green-700' : 
                            'bg-yellow-100 text-yellow-700'
                        }}">
                            {{ ucfirst($inspection->status) }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-600">{{ Str::limit($inspection->property->title, 40) }}</p>
                    <p class="text-xs text-gray-500">{{ $inspection->preferred_date->format('M d, Y') }} at {{ $inspection->preferred_time }}</p>
                </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center py-8 text-sm">No inspections yet</p>
        @endif
    </div>

    <!-- Recent Transactions -->
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-gray-900">Recent Transactions</h2>
            <a href="{{ route('agent.transactions') }}" class="text-orange-600 hover:text-orange-700 text-sm font-semibold inline-flex items-center gap-1">
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
                            <h4 class="font-semibold text-gray-900 text-sm truncate">{{ $payment->buyer_name }}</h4>
                            <p class="text-xs text-gray-400 truncate">{{ Str::limit($payment->property->title ?? 'Property', 35) }}</p>
                            <p class="text-xs text-gray-400">{{ $payment->created_at->format('M d, Y h:i A') }} · {{ ucfirst($payment->type) }}</p>
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
