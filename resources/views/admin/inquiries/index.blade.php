@extends('layouts.admin')

@section('title', 'Contact Messages')

@section('content')
<div class="mb-8">
    <div class="flex items-center gap-2 text-xs md:text-sm text-gray-500 mb-4 px-2 md:px-0">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-orange-600 transition-colors">
            <i class="bi bi-house-door mr-1"></i>B-Family
        </a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-orange-600 font-semibold">Contact Messages</span>
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
                    <i class="bi bi-envelope-open-text text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-bold text-white">Contact Messages</h1>
                    <p class="text-blue-100/80 text-sm mt-0.5">{{ $greeting }}, {{ auth()->user()->name }}!</p>
                    <p class="text-blue-300/60 text-xs mt-0.5">{{ now()->format('l, F j, Y') }}</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/10 backdrop-blur-sm rounded-lg text-white/80 text-xs border border-white/10">
                    <i class="bi bi-envelope"></i>
                    {{ $inquiryStats['all'] }} Total
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 mb-6 mx-1 md:mx-0">
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-orange-500/10 rounded-lg flex items-center justify-center">
                <i class="bi bi-envelope text-orange-500"></i>
            </div>
        </div>
        <p class="text-gray-500 text-xs font-semibold uppercase tracking-wide">Total Messages</p>
        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $inquiryStats['all'] }}</p>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-orange-500/10 rounded-lg flex items-center justify-center">
                <i class="bi bi-clock-history text-orange-500"></i>
            </div>
        </div>
        <p class="text-gray-500 text-xs font-semibold uppercase tracking-wide">New Messages</p>
        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $inquiryStats['new'] }}</p>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-orange-500/10 rounded-lg flex items-center justify-center">
                <i class="bi bi-hourglass-split text-orange-500"></i>
            </div>
        </div>
        <p class="text-gray-500 text-xs font-semibold uppercase tracking-wide">In Progress</p>
        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $inquiryStats['in_progress'] }}</p>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-orange-500/10 rounded-lg flex items-center justify-center">
                <i class="bi bi-check-circle text-orange-500"></i>
            </div>
        </div>
        <p class="text-gray-500 text-xs font-semibold uppercase tracking-wide">Resolved</p>
        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $inquiryStats['resolved'] }}</p>
    </div>
</div>

<!-- Filters -->
<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 md:p-6 mb-6 mx-1 md:mx-0">
    <div class="flex items-center gap-2 mb-4">
        <div class="w-8 h-8 bg-orange-500/10 rounded-lg flex items-center justify-center">
            <i class="bi bi-funnel-fill text-orange-500 text-sm"></i>
        </div>
        <h3 class="font-bold text-gray-900 text-sm md:text-base">Search & Filter Messages</h3>
    </div>
    <form method="GET" action="{{ route('admin.inquiries') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 md:gap-4">
        <div class="relative">
            <i class="bi bi-check-circle absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <select name="status" class="w-full pl-10 pr-3 py-2.5 text-sm border border-gray-200 rounded-lg focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all bg-white appearance-none">
                <option value="">All Statuses</option>
                <option value="new" {{ request('status') === 'new' ? 'selected' : '' }}>New</option>
                <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="resolved" {{ request('status') === 'resolved' ? 'selected' : '' }}>Resolved</option>
            </select>
        </div>

        <div class="relative">
            <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="Search by name, email, phone, or message" 
                   class="w-full pl-10 pr-3 py-2.5 text-sm border border-gray-200 rounded-lg focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all">
        </div>

        <button type="submit" class="px-4 py-2.5 bg-gradient-to-r from-orange-500 to-yellow-500 text-white rounded-lg hover:from-orange-600 hover:to-yellow-600 font-semibold transition-all text-sm shadow-sm flex items-center justify-center gap-2">
            <i class="bi bi-funnel"></i>
            Apply Filters
        </button>
    </form>
</div>

<!-- Inquiries Table -->
<div class="bg-white rounded-xl border border-gray-100 shadow-sm mx-1 md:mx-0">
    @if($inquiries->count() > 0)
        <div class="overflow-x-auto p-6" style="-webkit-overflow-scrolling: touch;">
            <table class="w-full" style="min-width: 1000px;">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">From</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Subject</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Message</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Status</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Date</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inquiries as $inquiry)
                    <tr class="border-b border-gray-50 last:border-0 hover:bg-gray-50/50 transition-colors">
                        <td class="py-4 px-4 whitespace-nowrap">
                            <div>
                                <p class="font-semibold text-gray-900 text-sm">{{ $inquiry->name }}</p>
                                <p class="text-xs text-gray-500">{{ $inquiry->email }}</p>
                                @if($inquiry->phone)
                                <p class="text-xs text-gray-400">{{ $inquiry->phone }}</p>
                                @endif
                                @if($inquiry->user)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-orange-500/10 text-orange-600 mt-0.5">Registered User</span>
                                @endif
                            </div>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <p class="font-semibold text-gray-900 text-sm">{{ $inquiry->subject ?? 'General Inquiry' }}</p>
                        </td>
                        <td class="py-4 px-4 max-w-xs">
                            <p class="text-sm text-gray-700 truncate">{{ Str::limit($inquiry->message, 100) }}</p>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold {{ 
                                $inquiry->status === 'new' ? 'bg-yellow-100 text-yellow-700' : 
                                ($inquiry->status === 'in_progress' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700')
                            }}">
                                {{ ucfirst(str_replace('_', ' ', $inquiry->status)) }}
                            </span>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <p class="text-sm text-gray-500">{{ $inquiry->created_at->format('M d, Y') }}</p>
                            <p class="text-xs text-gray-400">{{ $inquiry->created_at->format('h:i A') }}</p>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <div class="relative action-menu">
                                <button onclick="toggleActionMenu(this)" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 transition-colors">
                                    <i class="bi bi-three-dots-vertical text-gray-400"></i>
                                </button>
                                <div class="hidden absolute right-0 top-full mt-1 bg-white rounded-xl border border-gray-100 shadow-lg py-1 min-w-[170px] z-50">
                                    <a href="{{ route('admin.inquiries.show', $inquiry->id) }}" 
                                       class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                        <i class="bi bi-eye text-gray-400"></i> View Details
                                    </a>
                                    <a href="mailto:{{ $inquiry->email }}" 
                                       class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                        <i class="bi bi-reply text-gray-400"></i> Reply via Email
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="px-6 pb-6">
            {{ $inquiries->links() }}
        </div>
    @else
        <div class="text-center py-16">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="bi bi-inbox text-3xl text-gray-300"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-1">No Contact Messages</h3>
            <p class="text-sm text-gray-500">No contact messages found matching your filters</p>
        </div>
    @endif
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
</script>
@endpush
