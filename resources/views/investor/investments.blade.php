@extends('layouts.investor')

@section('title', 'My Investments')

@section('content')
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

        <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-start gap-4">
                <div class="w-14 h-14 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center shadow-sm flex-shrink-0 border border-white/10">
                    <i class="bi bi-graph-up-arrow text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-bold text-white">My Investments</h1>
                    <p class="text-blue-100/80 text-sm mt-0.5">{{ $greeting }}, {{ auth()->user()->name }}!</p>
                    <p class="text-blue-300/60 text-xs mt-0.5">{{ now()->format('l, F j, Y') }}</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('investor.dashboard') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-white text-orange-600 rounded-lg hover:bg-orange-50 font-semibold transition-all text-sm shadow-sm">
                    <i class="bi bi-plus-circle"></i>
                    New Investment
                </a>
            </div>
        </div>
    </div>
</div>

<div class="flex flex-col lg:flex-row gap-6">
    <!-- Main Content -->
    <div class="lg:flex-1 min-w-0">
        @if($investments->count() > 0)
        <div class="grid grid-cols-1 gap-6">
            @foreach($investments as $investment)
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 hover:shadow-md transition-all duration-300 border-l-4 {{ 
                $investment->status === 'active' ? 'border-green-500' : 
                ($investment->status === 'completed' ? 'border-blue-900' : 
                ($investment->status === 'withdrawn' ? 'border-yellow-500' : 'border-gray-400'))
            }}">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold {{ 
                                $investment->status === 'active' ? 'bg-green-100 text-green-700' : 
                                ($investment->status === 'completed' ? 'bg-blue-100 text-blue-700' : 
                                ($investment->status === 'withdrawn' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-700'))
                            }}">
                                {{ ucfirst($investment->status) }}
                            </span>
                            <span class="text-xs text-gray-500 font-mono">{{ $investment->reference }}</span>
                        </div>
                        <h3 class="font-bold text-gray-900 mb-1">
                            {{ $investment->property ? Str::limit($investment->property->title, 50) : 'Property Deleted' }}
                        </h3>
                        @if($investment->property)
                        <p class="text-sm text-gray-500 flex items-center gap-1">
                            <i class="bi bi-geo-alt-fill text-orange-500"></i>
                            {{ $investment->property->location }}
                        </p>
                        @endif
                    </div>
                    @if($investment->property)
                        @php
                            $propertyImage = $investment->property->first_image ?? 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=200';
                        @endphp
                        <img src="{{ $propertyImage }}" 
                             alt="{{ $investment->property->title }}"
                             class="w-20 h-20 rounded-xl object-cover flex-shrink-0 ring-2 ring-gray-100 ml-4"
                             onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=200';">
                    @endif
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4 p-4 bg-gray-50 rounded-xl">
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Investment Amount</p>
                        <p class="text-lg font-bold text-gray-900">{{ $investment->formatted_amount }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">ROI Percentage</p>
                        <p class="text-lg font-bold text-green-600">{{ $investment->roi_percentage }}%</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Expected Returns</p>
                        <p class="text-lg font-bold text-orange-600">₦{{ number_format($investment->total_return, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Profit</p>
                        <p class="text-lg font-bold text-green-600">
                            ₦{{ number_format($investment->total_return - $investment->amount, 2) }}
                        </p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pt-4 border-t border-gray-100">
                    <div class="space-y-1">
                        @if($investment->start_date)
                        <p class="text-xs text-gray-500">
                            <i class="bi bi-calendar-check text-orange-500"></i>
                            Started: {{ $investment->start_date->format('M d, Y') }}
                        </p>
                        @endif
                        @if($investment->maturity_date)
                        <p class="text-xs text-gray-500">
                            <i class="bi bi-calendar-event text-orange-500"></i>
                            Matures: {{ $investment->maturity_date->format('M d, Y') }}
                            <span class="ml-2 text-orange-600 font-semibold">
                                ({{ $investment->maturity_date->diffForHumans() }})
                            </span>
                        </p>
                        @endif
                        @if(!$investment->start_date && !$investment->maturity_date)
                        <p class="text-xs text-gray-500">
                            <i class="bi bi-hourglass-split text-orange-500"></i>
                            Will start once your payment is confirmed by admin
                        </p>
                        @endif
                    </div>
                    @if($investment->status === 'active')
                        <div class="flex flex-col sm:flex-row gap-2">
                            @if($investment->maturity_date && $investment->maturity_date <= now())
                            <button onclick="reinvestInvestment({{ $investment->id }})" 
                                    class="px-4 py-2 bg-white text-green-600 border border-green-200 rounded-lg hover:bg-green-50 hover:border-green-300 font-semibold transition-all text-sm flex items-center gap-2">
                                <i class="bi bi-arrow-repeat"></i>
                                Reinvest
                            </button>
                            @endif
                            <button onclick="withdrawInvestment({{ $investment->id }})" 
                                    class="px-4 py-2 bg-white text-red-600 border border-red-200 rounded-lg hover:bg-red-50 hover:border-red-300 font-semibold transition-all text-sm flex items-center gap-2">
                                <i class="bi bi-arrow-down-circle"></i>
                                Request Withdrawal
                            </button>
                        </div>
                    @elseif($investment->status === 'withdrawn')
                        <span class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-yellow-600 bg-yellow-50 rounded-lg">
                            <i class="bi bi-hourglass-split"></i>
                            Withdrawal pending admin approval
                        </span>
                    @elseif($investment->status === 'pending')
                        <span class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-gray-600 bg-gray-50 rounded-lg">
                            <i class="bi bi-clock-history"></i>
                            Awaiting payment confirmation
                        </span>
                    @else
                        <span class="text-sm text-gray-400 italic">Investment completed</span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $investments->links() }}
        </div>
        @else
        <div class="bg-white rounded-xl border-2 border-dashed border-gray-200 p-12 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="bi bi-graph-up text-3xl text-gray-300"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">No Investments Yet</h3>
            <p class="text-sm text-gray-500 mb-6 max-w-md mx-auto">Start building your investment portfolio today and watch your wealth grow</p>
            <a href="{{ route('investor.dashboard') }}" class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-gradient-to-r from-orange-500 to-yellow-500 text-white rounded-lg hover:from-orange-600 hover:to-yellow-600 font-semibold transition-all text-sm shadow-sm">
                <i class="bi bi-search"></i>
                Browse Investment Opportunities
            </a>
        </div>
        @endif
    </div>

    <!-- Filter Sidebar -->
    <div id="filterSidebar" class="lg:w-80 fixed lg:relative inset-0 lg:inset-auto z-50 lg:z-auto transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
        <div onclick="toggleFilterSidebar()" class="lg:hidden fixed inset-0 bg-black bg-opacity-50 z-40"></div>
        
        <div class="bg-white rounded-xl border border-gray-100 shadow-lg h-screen lg:h-auto overflow-y-auto lg:overflow-visible z-50 p-4 md:p-6">
            <div class="lg:hidden flex items-center justify-between mb-6 pb-4 border-b border-gray-100 sticky top-0 bg-white z-10">
                <h3 class="text-lg font-bold text-gray-900">Filter Investments</h3>
                <button onclick="toggleFilterSidebar()" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                    <i class="bi bi-x-lg text-gray-600"></i>
                </button>
            </div>
            
            <div class="hidden lg:flex items-center gap-2 mb-6">
                <div class="w-8 h-8 bg-orange-500/10 rounded-lg flex items-center justify-center">
                    <i class="bi bi-funnel-fill text-orange-500 text-sm"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Filter Investments</h3>
            </div>
            
            <form method="GET" action="{{ route('investor.investments') }}" class="space-y-6">
                <div>
                    <h4 class="font-semibold text-gray-900 text-sm mb-3">Status</h4>
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 cursor-pointer hover:bg-gray-50 p-2 rounded-lg transition-colors">
                            <input type="radio" name="status" value="active" 
                                   {{ request('status') === 'active' ? 'checked' : '' }}
                                   class="text-orange-500 focus:ring-orange-500">
                            <span class="text-sm text-gray-700">Active</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer hover:bg-gray-50 p-2 rounded-lg transition-colors">
                            <input type="radio" name="status" value="completed" 
                                   {{ request('status') === 'completed' ? 'checked' : '' }}
                                   class="text-orange-500 focus:ring-orange-500">
                            <span class="text-sm text-gray-700">Completed</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer hover:bg-gray-50 p-2 rounded-lg transition-colors">
                            <input type="radio" name="status" value="pending" 
                                   {{ request('status') === 'pending' ? 'checked' : '' }}
                                   class="text-orange-500 focus:ring-orange-500">
                            <span class="text-sm text-gray-700">Pending</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer hover:bg-gray-50 p-2 rounded-lg transition-colors">
                            <input type="radio" name="status" value="withdrawn" 
                                   {{ request('status') === 'withdrawn' ? 'checked' : '' }}
                                   class="text-orange-500 focus:ring-orange-500">
                            <span class="text-sm text-gray-700">Withdrawn</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer hover:bg-gray-50 p-2 rounded-lg transition-colors">
                            <input type="radio" name="status" value="" 
                                   {{ !request('status') ? 'checked' : '' }}
                                   class="text-orange-500 focus:ring-orange-500">
                            <span class="text-sm text-gray-700">All</span>
                        </label>
                    </div>
                </div>

                <div>
                    <h4 class="font-semibold text-gray-900 text-sm mb-3">Property Category</h4>
                    <div class="space-y-2 max-h-60 overflow-y-auto">
                        @php
                            $categories = config('bfamily.property.categories', ['Land', '1 Bedroom', '2 Bedroom', '3 Bedroom', 'Duplex', 'Commercial']);
                            $categoryCounts = [];
                            foreach($categories as $cat) {
                                $categoryCounts[$cat] = \App\Models\Investment::where('investor_id', auth()->id())
                                    ->whereHas('property', function($q) use ($cat) {
                                        $q->where('category', $cat);
                                    })
                                    ->count();
                            }
                        @endphp
                        @foreach($categories as $category)
                        <label class="flex items-center justify-between cursor-pointer hover:bg-gray-50 p-2 rounded-lg transition-colors">
                            <div class="flex items-center gap-2">
                                <input type="checkbox" name="categories[]" value="{{ $category }}" 
                                       {{ in_array($category, (array)request('categories', [])) ? 'checked' : '' }}
                                       class="rounded text-blue-900 focus:ring-blue-900">
                                <span class="text-sm text-gray-700">{{ $category }}</span>
                            </div>
                            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-0.5 rounded-full">{{ $categoryCounts[$category] ?? 0 }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div>
                    <h4 class="font-semibold text-gray-900 text-sm mb-3">Investment Amount (₦)</h4>
                    <div class="flex items-center gap-2 mb-2">
                        <input type="number" name="amount_min" value="{{ request('amount_min', 5000) }}" 
                               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all" placeholder="Min" min="0">
                        <span class="text-gray-500">-</span>
                        <input type="number" name="amount_max" value="{{ request('amount_max', 50000000) }}" 
                               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all" placeholder="Max" min="0">
                    </div>
                    <div class="text-xs text-gray-500 mb-2 text-center">
                        <span>₦{{ number_format(request('amount_min', 5000)) }}</span>
                        <span class="mx-2">to</span>
                        <span>₦{{ number_format(request('amount_max', 50000000)) }}</span>
                    </div>
                </div>

                <div>
                    <h4 class="font-semibold text-gray-900 text-sm mb-3">ROI Range (%)</h4>
                    <div class="flex items-center gap-2 mb-2">
                        <input type="number" name="roi_min" value="{{ request('roi_min') }}" 
                               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all" placeholder="Min" min="0" max="100">
                        <span class="text-gray-500">-</span>
                        <input type="number" name="roi_max" value="{{ request('roi_max') }}" 
                               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all" placeholder="Max" min="0" max="100">
                    </div>
                </div>

                <div>
                    <h4 class="font-semibold text-gray-900 text-sm mb-3">Investment Date</h4>
                    <div class="space-y-2">
                        <div>
                            <label class="text-xs text-gray-500 mb-1 block">From</label>
                            <input type="date" name="date_from" value="{{ request('date_from') }}" 
                                   class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all">
                        </div>
                        <div>
                            <label class="text-xs text-gray-500 mb-1 block">To</label>
                            <input type="date" name="date_to" value="{{ request('date_to') }}" 
                                   class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all">
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full px-4 py-2.5 bg-gradient-to-r from-orange-500 to-yellow-500 text-white rounded-lg hover:from-orange-600 hover:to-yellow-600 font-semibold transition-all text-sm shadow-sm flex items-center justify-center gap-2">
                    <i class="bi bi-funnel"></i>
                    Apply Filters
                </button>

                <a href="{{ route('investor.investments') }}" class="w-full px-4 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-semibold transition-all text-sm flex items-center justify-center gap-2">
                    <i class="bi bi-x-circle"></i>
                    Clear Filters
                </a>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function toggleFilterSidebar() {
        const sidebar = document.getElementById('filterSidebar');
        const body = document.body;
        
        if (sidebar.classList.contains('-translate-x-full')) {
            sidebar.classList.remove('-translate-x-full');
            body.style.overflow = 'hidden';
        } else {
            sidebar.classList.add('-translate-x-full');
            body.style.overflow = '';
        }
    }

    document.addEventListener('click', function(e) {
        const sidebar = document.getElementById('filterSidebar');
        const toggleBtn = e.target.closest('[onclick="toggleFilterSidebar()"]');
        
        if (window.innerWidth < 1024 && !sidebar.contains(e.target) && !toggleBtn && !sidebar.classList.contains('-translate-x-full')) {
            toggleFilterSidebar();
        }
    });

    document.querySelector('#filterSidebar form')?.addEventListener('submit', function() {
        if (window.innerWidth < 1024) {
            setTimeout(() => toggleFilterSidebar(), 100);
        }
    });

    async function withdrawInvestment(id) {
        if (!confirm('Are you sure you want to request withdrawal for this investment?')) return;
        
        try {
            const data = await window.ajax(`{{ route("investor.withdraw", ":id") }}`.replace(':id', id), 'POST');
            window.toast(data.message, 'success');
            setTimeout(() => window.location.reload(), 1500);
        } catch (error) {
            window.toast(error.message || 'Failed to process withdrawal', 'error');
        }
    }

    async function reinvestInvestment(id) {
        if (!confirm('Reinvest your total return into a new investment cycle? The funds stay with us, so no new payment is required.')) return;
        
        try {
            const data = await window.ajax(`{{ route("investor.reinvest", ":id") }}`.replace(':id', id), 'POST');
            window.toast(data.message, 'success');
            setTimeout(() => window.location.reload(), 1500);
        } catch (error) {
            window.toast(error.message || 'Failed to reinvest', 'error');
        }
    }
</script>
@endpush
