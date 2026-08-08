@extends('layouts.admin')

@section('title', 'User Profile - ' . $user->name)

@section('content')
<div class="mb-8">
    <div class="flex items-center gap-2 text-xs md:text-sm text-gray-500 mb-4 px-2 md:px-0">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-orange-600 transition-colors">
            <i class="bi bi-house-door mr-1"></i>B-Family
        </a>
        <i class="bi bi-chevron-right text-xs"></i>
        <a href="{{ route('admin.users') }}" class="hover:text-orange-600 transition-colors">Manage Users</a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-orange-600 font-semibold">User Profile</span>
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
                    <i class="bi bi-person-badge text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-bold text-white">{{ $user->name }}</h1>
                    <p class="text-blue-100/80 text-sm mt-0.5">{{ $greeting }}, {{ auth()->user()->name }}!</p>
                    <p class="text-blue-300/60 text-xs mt-0.5">{{ now()->format('l, F j, Y') }}</p>
                </div>
            </div>
            <a href="{{ route('admin.users') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-white text-blue-900 rounded-lg hover:bg-blue-50 font-semibold transition-all text-sm shadow-sm">
                <i class="bi bi-arrow-left"></i>
                Back to Users
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mx-1 md:mx-0">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Personal Information -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-6">Personal Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Full Name</label>
                    <p class="text-gray-900 font-semibold mt-1">{{ $user->name }}</p>
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Email Address</label>
                    <p class="text-gray-900 font-semibold mt-1">
                        <a href="mailto:{{ $user->email }}" class="text-orange-600 hover:text-orange-700">
                            {{ $user->email }}
                        </a>
                    </p>
                </div>

                @if($user->phone)
                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Phone Number</label>
                    <p class="text-gray-900 font-semibold mt-1">
                        <a href="tel:{{ $user->phone }}" class="text-orange-600 hover:text-orange-700">
                            {{ $user->phone }}
                        </a>
                    </p>
                </div>
                @endif

                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Role</label>
                    <p class="mt-1">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold {{ 
                            $user->role === 'admin' ? 'bg-orange-500/10 text-orange-600' : 
                            ($user->role === 'agent' ? 'bg-orange-500/10 text-orange-600' : 
                            ($user->role === 'investor' ? 'bg-orange-500/10 text-orange-600' : 'bg-gray-100 text-gray-700'))
                        }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </p>
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</label>
                    <p class="mt-1">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold {{ 
                            $user->status === 'active' ? 'bg-green-100 text-green-700' : 
                            ($user->status === 'blocked' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700')
                        }}">
                            {{ ucfirst($user->status) }}
                        </span>
                    </p>
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Member Since</label>
                    <p class="text-gray-900 font-semibold mt-1">{{ $user->created_at->format('F d, Y') }}</p>
                </div>

                @if($user->address)
                <div class="md:col-span-2">
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Address</label>
                    <p class="text-gray-900 mt-1">{{ $user->address }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Role-Specific Information -->
        @if($user->isAgent())
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-6">Agent Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Agent Requested</label>
                    <p class="text-gray-900 font-semibold mt-1">
                        {{ $user->agent_requested_at ? $user->agent_requested_at->format('F d, Y') : 'N/A' }}
                    </p>
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Agent Approved</label>
                    <p class="text-gray-900 font-semibold mt-1">
                        {{ $user->agent_approved_at ? $user->agent_approved_at->format('F d, Y') : 'Not Approved' }}
                    </p>
                </div>
            </div>
        </div>
        @endif

        @if($user->isInvestor())
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-6">Investor Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Investor Requested</label>
                    <p class="text-gray-900 font-semibold mt-1">
                        {{ $user->investor_requested_at ? $user->investor_requested_at->format('F d, Y') : 'N/A' }}
                    </p>
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Investor Approved</label>
                    <p class="text-gray-900 font-semibold mt-1">
                        {{ $user->investor_approved_at ? $user->investor_approved_at->format('F d, Y') : 'Not Approved' }}
                    </p>
                </div>
            </div>
        </div>
        @endif

        <!-- Statistics -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-6">Statistics</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($stats as $key => $value)
                <div class="text-center p-4 bg-gray-50 rounded-xl">
                    <p class="text-2xl font-bold text-orange-600">{{ $value }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ ucfirst(str_replace('_', ' ', $key)) }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Recent Properties -->
        @if($user->isAgent() && $user->properties->count() > 0)
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-6">Recent Properties</h2>
            <div class="space-y-4">
                @foreach($user->properties->take(5) as $property)
                <div class="flex items-center gap-4 p-4 border border-gray-100 rounded-xl">
                    @if($property->first_image)
                    <img src="{{ $property->first_image }}" 
                         alt="{{ $property->title }}"
                         class="w-16 h-16 object-cover rounded-lg ring-2 ring-gray-100"
                         onerror="this.src='https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=100';">
                    @endif
                    <div class="flex-1">
                        <h4 class="font-semibold text-gray-900 text-sm">{{ $property->title }}</h4>
                        <p class="text-xs text-gray-500">{{ $property->location }}</p>
                        <p class="text-xs text-gray-500 mt-1">
                            Status: 
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ 
                                $property->approval_status === 'approved' ? 'bg-green-100 text-green-700' : 
                                ($property->approval_status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700')
                            }}">
                                {{ ucfirst($property->approval_status) }}
                            </span>
                        </p>
                    </div>
                    <a href="{{ route('admin.properties') }}?search={{ $property->id }}" 
                       class="text-orange-600 hover:text-orange-700">
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Recent Investments -->
        @if($user->isInvestor() && $user->investments->count() > 0)
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-6">Recent Investments</h2>
            <div class="space-y-4">
                @foreach($user->investments->take(5) as $investment)
                <div class="flex items-center justify-between p-4 border border-gray-100 rounded-xl">
                    <div>
                        <h4 class="font-semibold text-gray-900 text-sm">
                            {{ $investment->property ? $investment->property->title : 'Property Deleted' }}
                        </h4>
                        <p class="text-sm text-gray-500">₦{{ number_format($investment->amount, 2) }}</p>
                        <p class="text-xs text-gray-500 mt-1">
                            Status: 
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ 
                                $investment->status === 'active' ? 'bg-green-100 text-green-700' : 
                                ($investment->status === 'completed' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700')
                            }}">
                                {{ ucfirst($investment->status) }}
                            </span>
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Profile Picture -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 text-center">
            @if($user->avatar)
            <img src="{{ asset('storage/' . $user->avatar) }}" 
                 alt="{{ $user->name }}"
                 class="w-28 h-28 rounded-full mx-auto object-cover mb-4 ring-4 ring-gray-100">
            @else
            <div class="w-28 h-28 bg-blue-900 rounded-full flex items-center justify-center text-white text-4xl font-bold mx-auto mb-4 ring-4 ring-blue-100">
                {{ substr($user->name, 0, 1) }}
            </div>
            @endif
            <h3 class="text-lg font-bold text-gray-900">{{ $user->name }}</h3>
            <p class="text-sm text-gray-500">{{ ucfirst($user->role) }}</p>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Quick Actions</h2>
            <div class="space-y-2">
                <button onclick="toggleStatus({{ $user->id }}, '{{ $user->status }}')" 
                        class="w-full px-4 py-2.5 {{ $user->status === 'active' ? 'bg-gray-100 text-gray-700 hover:bg-gray-200' : 'bg-gradient-to-r from-orange-500 to-yellow-500 text-white hover:from-orange-600 hover:to-yellow-600' }} rounded-lg font-semibold transition-all text-sm flex items-center justify-center gap-2">
                    <i class="bi bi-{{ $user->status === 'active' ? 'x-circle' : 'check-circle' }}"></i>
                    {{ $user->status === 'active' ? 'Deactivate' : 'Activate' }} User
                </button>

                @if($user->isAgent() && !$user->agent_approved_at)
                <button onclick="approveAgent({{ $user->id }})" class="w-full px-4 py-2.5 bg-gradient-to-r from-orange-500 to-yellow-500 text-white rounded-lg hover:from-orange-600 hover:to-yellow-600 font-semibold transition-all text-sm flex items-center justify-center gap-2">
                    <i class="bi bi-check-circle"></i>
                    Approve as Agent
                </button>
                @endif

                @if($user->isInvestor() && !$user->investor_approved_at)
                <button onclick="approveInvestor({{ $user->id }})" class="w-full px-4 py-2.5 bg-gradient-to-r from-orange-500 to-yellow-500 text-white rounded-lg hover:from-orange-600 hover:to-yellow-600 font-semibold transition-all text-sm flex items-center justify-center gap-2">
                    <i class="bi bi-check-circle"></i>
                    Approve as Investor
                </button>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function toggleStatus(userId, currentStatus) {
        const action = currentStatus === 'active' ? 'deactivate' : 'activate';
        if (!confirm(`Are you sure you want to ${action} this user?`)) return;
        
        const route = currentStatus === 'active' 
            ? '{{ route("admin.users.deactivate", ":id") }}'
            : '{{ route("admin.users.activate", ":id") }}';
        
        window.ajax(route.replace(':id', userId), 'POST')
            .then(data => {
                window.toast(data.message, 'success');
                setTimeout(() => window.location.reload(), 1000);
            })
            .catch(error => window.toast(error.message || 'Failed to update status', 'error'));
    }

    function approveAgent(userId) {
        if (!confirm('Approve this user as an agent?')) return;
        window.ajax('{{ route("admin.users.approve-agent", ":id") }}'.replace(':id', userId), 'POST')
            .then(data => {
                window.toast(data.message, 'success');
                setTimeout(() => window.location.reload(), 1000);
            })
            .catch(error => window.toast(error.message || 'Failed to approve agent', 'error'));
    }

    function approveInvestor(userId) {
        if (!confirm('Approve this user as an investor?')) return;
        window.ajax('{{ route("admin.users.approve-investor", ":id") }}'.replace(':id', userId), 'POST')
            .then(data => {
                window.toast(data.message, 'success');
                setTimeout(() => window.location.reload(), 1000);
            })
            .catch(error => window.toast(error.message || 'Failed to approve investor', 'error'));
    }
</script>
@endpush
