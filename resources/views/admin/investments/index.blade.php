@extends('layouts.admin')

@section('title', 'Investment Management')

@section('content')
<div class="mb-8">
    <div class="flex items-center gap-2 text-xs md:text-sm text-gray-500 mb-4 px-2 md:px-0">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-orange-600 transition-colors">
            <i class="bi bi-house-door mr-1"></i>B-Family
        </a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-orange-600 font-semibold">Investments</span>
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
                    <i class="bi bi-graph-up-arrow text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-bold text-white">Investment Management</h1>
                    <p class="text-blue-100/80 text-sm mt-0.5">{{ $greeting }}, {{ auth()->user()->name }}!</p>
                    <p class="text-blue-300/60 text-xs mt-0.5">{{ now()->format('l, F j, Y') }}</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/10 backdrop-blur-sm rounded-lg text-white/80 text-xs border border-white/10">
                    <i class="bi bi-graph-up"></i>
                    {{ $investmentStats['all'] }} Total
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-24 h-24 bg-orange-500/10 rounded-full -mr-12 -mt-12"></div>
        <div class="relative">
            <div class="flex items-center justify-between mb-4">
                <i class="bi bi-graph-up-arrow text-orange-500 animate-float"></i>
            </div>
            <h3 class="text-gray-500 text-sm font-medium mb-1">Total Investments</h3>
            <p class="text-2xl font-bold text-gray-900 mb-1">{{ $investmentStats['all'] }}</p>
            <p class="text-xs text-gray-400 mb-3">All time investments</p>
            <div class="w-full bg-gray-100 rounded-full h-1.5">
                @php
                    $totalProgress = $investmentStats['all'] > 0 ? min(100, ($investmentStats['active'] / $investmentStats['all']) * 100) : 0;
                @endphp
                <div class="bg-gradient-to-r from-orange-500 to-yellow-500 h-1.5 rounded-full" style="width: {{ $totalProgress }}%"></div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-24 h-24 bg-orange-500/10 rounded-full -mr-12 -mt-12"></div>
        <div class="relative">
            <div class="flex items-center justify-between mb-4">
                <i class="bi bi-check-circle text-orange-500 animate-pulse-soft"></i>
            </div>
            <h3 class="text-gray-500 text-sm font-medium mb-1">Active</h3>
            <p class="text-2xl font-bold text-gray-900 mb-1">{{ $investmentStats['active'] }}</p>
            <p class="text-xs text-gray-400 mb-3">Currently running</p>
            <div class="w-full bg-gray-100 rounded-full h-1.5">
                @php
                    $activeProgress = $investmentStats['all'] > 0 ? min(100, ($investmentStats['active'] / $investmentStats['all']) * 100) : 0;
                @endphp
                <div class="bg-gradient-to-r from-orange-500 to-yellow-500 h-1.5 rounded-full" style="width: {{ $activeProgress }}%"></div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-24 h-24 bg-orange-500/10 rounded-full -mr-12 -mt-12"></div>
        <div class="relative">
            <div class="flex items-center justify-between mb-4">
                <i class="bi bi-currency-dollar text-orange-500 animate-wiggle"></i>
            </div>
            <h3 class="text-gray-500 text-sm font-medium mb-1">Total Invested</h3>
            <p class="text-2xl font-bold text-gray-900 mb-1">₦{{ number_format($investmentStats['total_invested'], 0) }}</p>
            <p class="text-xs text-gray-400 mb-3">Capital invested</p>
            <div class="w-full bg-gray-100 rounded-full h-1.5">
                @php
                    $investedProgress = $investmentStats['total_invested'] > 0 ? min(100, ($investmentStats['total_invested'] / max(10000000, $investmentStats['total_invested'])) * 100) : 0;
                @endphp
                <div class="bg-gradient-to-r from-orange-500 to-yellow-500 h-1.5 rounded-full" style="width: {{ $investedProgress }}%"></div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-24 h-24 bg-orange-500/10 rounded-full -mr-12 -mt-12"></div>
        <div class="relative">
            <div class="flex items-center justify-between mb-4">
                <i class="bi bi-graph-up text-orange-500 animate-glow"></i>
            </div>
            <h3 class="text-gray-500 text-sm font-medium mb-1">Total Returns</h3>
            <p class="text-2xl font-bold text-gray-900 mb-1">₦{{ number_format($investmentStats['total_returns'], 0) }}</p>
            <p class="text-xs text-gray-400 mb-3">Total earnings</p>
            <div class="w-full bg-gray-100 rounded-full h-1.5">
                @php
                    $returnsProgress = $investmentStats['total_invested'] > 0 ? min(100, ($investmentStats['total_returns'] / max($investmentStats['total_invested'], 1)) * 100) : 0;
                @endphp
                <div class="bg-gradient-to-r from-orange-500 to-yellow-500 h-1.5 rounded-full" style="width: {{ $returnsProgress }}%"></div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Tabs -->
<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-3 md:p-4 mb-6 mx-1 md:mx-0">
    <div class="flex flex-wrap items-center gap-2">
        <a href="{{ route('admin.investments') }}" 
           class="px-4 py-2 rounded-lg font-semibold transition-all text-sm shadow-sm {{ !request('status') ? 'bg-gradient-to-r from-orange-500 to-yellow-500 text-white shadow-md' : 'bg-gray-50 text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
            All ({{ $investmentStats['all'] }})
        </a>
        <a href="{{ route('admin.investments', ['status' => 'active']) }}" 
           class="px-4 py-2 rounded-lg font-semibold transition-all text-sm shadow-sm {{ request('status') === 'active' ? 'bg-gradient-to-r from-orange-500 to-yellow-500 text-white shadow-md' : 'bg-gray-50 text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
            Active ({{ $investmentStats['active'] }})
        </a>
        <a href="{{ route('admin.investments', ['status' => 'completed']) }}" 
           class="px-4 py-2 rounded-lg font-semibold transition-all text-sm shadow-sm {{ request('status') === 'completed' ? 'bg-gradient-to-r from-orange-500 to-yellow-500 text-white shadow-md' : 'bg-gray-50 text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
            Completed ({{ $investmentStats['completed'] }})
        </a>
        <a href="{{ route('admin.investments', ['status' => 'withdrawn']) }}" 
           class="px-4 py-2 rounded-lg font-semibold transition-all text-sm shadow-sm {{ request('status') === 'withdrawn' ? 'bg-gradient-to-r from-orange-500 to-yellow-500 text-white shadow-md' : 'bg-gray-50 text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
            Withdrawal Requests ({{ $investmentStats['withdrawn'] }})
        </a>
    </div>
</div>

<!-- Search and Filters -->
<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 md:p-6 mb-6 mx-1 md:mx-0">
    <div class="flex items-center gap-2 mb-4">
        <div class="w-8 h-8 bg-orange-500/10 rounded-lg flex items-center justify-center">
            <i class="bi bi-funnel-fill text-orange-500 text-sm"></i>
        </div>
        <h3 class="font-bold text-gray-900 text-sm md:text-base">Search & Filter Investments</h3>
    </div>
    <form method="GET" action="{{ route('admin.investments') }}" class="grid grid-cols-1 md:grid-cols-3 gap-3 md:gap-4">
        <div class="relative">
            <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="Search by reference, investor, property..." 
                   class="w-full pl-10 pr-3 py-2.5 text-sm border border-gray-200 rounded-lg focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all">
        </div>
        <div class="relative">
            <i class="bi bi-check-circle absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <select name="status" class="w-full pl-10 pr-3 py-2.5 text-sm border border-gray-200 rounded-lg focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all bg-white appearance-none">
                <option value="">All Status</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="withdrawn" {{ request('status') === 'withdrawn' ? 'selected' : '' }}>Withdrawal Request</option>
            </select>
        </div>
        <button type="submit" class="px-4 py-2.5 bg-gradient-to-r from-orange-500 to-yellow-500 text-white rounded-lg hover:from-orange-600 hover:to-yellow-600 font-semibold transition-all text-sm shadow-sm flex items-center justify-center gap-2">
            <i class="bi bi-funnel"></i>
            Filter
        </button>
    </form>
</div>

<!-- Investments Table -->
<div class="bg-white rounded-xl border border-gray-100 shadow-sm mx-1 md:mx-0">
    @if($investments->count() > 0)
        <div class="overflow-x-auto p-6" style="-webkit-overflow-scrolling: touch;">
            <table class="w-full" style="min-width: 1100px;">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Reference</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Investor</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Property</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Amount</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">ROI</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Returns</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Status</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($investments as $investment)
                    <tr class="border-b border-gray-50 last:border-0 hover:bg-gray-50/50 transition-colors">
                        <td class="py-4 px-4 whitespace-nowrap">
                            <p class="font-mono text-sm text-gray-900">{{ $investment->reference }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ $investment->created_at->format('M d, Y') }}</p>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <p class="font-semibold text-gray-900 text-sm">{{ $investment->investor->name }}</p>
                            <p class="text-xs text-gray-500">{{ $investment->investor->email }}</p>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <p class="font-semibold text-gray-900 text-sm">{{ Str::limit($investment->property->title, 25) }}</p>
                            <p class="text-xs text-gray-500">{{ $investment->property->location }}</p>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <p class="font-bold text-gray-900">{{ $investment->formatted_amount }}</p>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <p class="font-bold text-orange-600">{{ $investment->roi_percentage }}%</p>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <p class="font-bold text-orange-600">₦{{ number_format($investment->total_return, 2) }}</p>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold {{ 
                                $investment->status === 'active' ? 'bg-green-100 text-green-700' : 
                                ($investment->status === 'completed' ? 'bg-blue-100 text-blue-700' : 
                                ($investment->status === 'withdrawn' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-700'))
                            }}">
                                {{ ucfirst($investment->status) }}
                            </span>
                            @if($investment->maturity_date)
                            <p class="text-xs text-gray-500 mt-1">
                                Matures: {{ $investment->maturity_date->format('M d, Y') }}
                            </p>
                            @endif
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <div class="relative action-menu">
                                <button onclick="toggleActionMenu(this)" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 transition-colors">
                                    <i class="bi bi-three-dots-vertical text-gray-400"></i>
                                </button>
                                <div class="hidden absolute right-0 top-full mt-1 bg-white rounded-xl border border-gray-100 shadow-lg py-1 min-w-[180px] z-50">
                                    @if($investment->withdrawal_status === 'requested')
                                    <button onclick="approveWithdrawal({{ $investment->id }})" 
                                            class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-green-700 hover:bg-green-50 transition-colors text-left">
                                        <i class="bi bi-check-circle"></i> Approve Withdrawal
                                    </button>
                                    <button onclick="rejectWithdrawal({{ $investment->id }})" 
                                            class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-red-700 hover:bg-red-50 transition-colors text-left">
                                        <i class="bi bi-x-circle"></i> Reject Withdrawal
                                    </button>
                                    @elseif($investment->withdrawal_status === 'approved')
                                    <button onclick="markWithdrawalPaid({{ $investment->id }})" 
                                            class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-blue-700 hover:bg-blue-50 transition-colors text-left">
                                        <i class="bi bi-cash-coin"></i> Mark as Paid
                                    </button>
                                    @else
                                    <span class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-400">
                                        <i class="bi bi-dash-circle"></i> No actions available
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="px-6 pb-6">
            {{ $investments->links() }}
        </div>
    @else
        <div class="text-center py-16">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="bi bi-graph-up text-3xl text-gray-300"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-1">No Investments</h3>
            <p class="text-sm text-gray-500">No investments have been made yet</p>
        </div>
    @endif
</div>

<!-- Reject Withdrawal Modal -->
<div id="rejectModal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                <i class="bi bi-x-circle text-red-600"></i>
            </div>
            <div>
                <h3 class="font-bold text-gray-900">Reject Withdrawal</h3>
                <p class="text-sm text-gray-500">Provide a reason for rejection</p>
            </div>
        </div>
        <form id="rejectForm" class="space-y-4">
            @csrf
            <input type="hidden" id="rejectInvestmentId" name="investment_id">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Rejection Reason *</label>
                <textarea id="rejectionReason" name="reason" rows="4" 
                          class="w-full border border-gray-200 rounded-lg p-3 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all" required></textarea>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="flex-1 px-4 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 font-semibold transition-all text-sm">
                    Reject Withdrawal
                </button>
                <button type="button" onclick="closeRejectModal()" class="flex-1 px-4 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-semibold transition-all text-sm">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function toggleActionMenu(btn) {
        var menu = btn.nextElementSibling;
        var isHidden = menu.classList.contains('hidden');
        closeAllMenus();
        if (isHidden) {
            menu.classList.remove('hidden');
        }
    }

    function closeAllMenus() {
        document.querySelectorAll('.action-menu > div:last-child').forEach(function(m) {
            m.classList.add('hidden');
        });
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.action-menu')) {
            closeAllMenus();
        }
    });

    async function approveWithdrawal(id) {
        if (!confirm('Are you sure you want to approve this withdrawal request?')) return;
        
        try {
            const data = await window.ajax(`{{ route("admin.investments.approve-withdrawal", ":id") }}`.replace(':id', id), 'POST');
            window.toast(data.message, 'success');
            setTimeout(() => window.location.reload(), 1000);
        } catch (error) {
            window.toast(error.message || 'Failed to approve withdrawal', 'error');
        }
    }

    async function markWithdrawalPaid(id) {
        if (!confirm('Confirm that the withdrawal amount has been paid to the investor?')) return;
        
        try {
            const data = await window.ajax(`{{ route("admin.investments.mark-paid", ":id") }}`.replace(':id', id), 'POST');
            window.toast(data.message, 'success');
            setTimeout(() => window.location.reload(), 1000);
        } catch (error) {
            window.toast(error.message || 'Failed to mark withdrawal as paid', 'error');
        }
    }

    function rejectWithdrawal(id) {
        document.getElementById('rejectInvestmentId').value = id;
        document.getElementById('rejectModal').classList.remove('hidden');
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
        document.getElementById('rejectForm').reset();
    }

    document.getElementById('rejectForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const form = e.target;
        const submitBtn = form.querySelector('button[type="submit"]');
        const formData = new FormData(form);
        
        showLoader(submitBtn);
        
        try {
            const investmentId = formData.get('investment_id');
            const data = await window.ajax(`{{ route("admin.investments.reject-withdrawal", ":id") }}`.replace(':id', investmentId), 'POST', {
                reason: formData.get('reason'),
            });
            window.toast(data.message, 'success');
            closeRejectModal();
            setTimeout(() => window.location.reload(), 1000);
        } catch (error) {
            hideLoader(submitBtn);
            window.toast(error.message || 'Failed to reject withdrawal', 'error');
        }
    });
</script>
@endpush

