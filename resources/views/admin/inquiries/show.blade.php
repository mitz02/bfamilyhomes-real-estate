@extends('layouts.admin')

@section('title', 'View Contact Message')

@section('content')
<div class="mb-8">
    <div class="flex items-center gap-2 text-xs md:text-sm text-gray-500 mb-4 px-2 md:px-0">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-orange-600 transition-colors">
            <i class="bi bi-house-door mr-1"></i>B-Family
        </a>
        <i class="bi bi-chevron-right text-xs"></i>
        <a href="{{ route('admin.inquiries') }}" class="hover:text-orange-600 transition-colors">Contact Messages</a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-orange-600 font-semibold">View Message</span>
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
                    <h1 class="text-xl md:text-2xl font-bold text-white">Contact Message</h1>
                    <p class="text-blue-100/80 text-sm mt-0.5">{{ $greeting }}, {{ auth()->user()->name }}!</p>
                    <p class="text-blue-300/60 text-xs mt-0.5">{{ now()->format('l, F j, Y') }}</p>
                </div>
            </div>
            <a href="{{ route('admin.inquiries') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-white text-blue-900 rounded-lg hover:bg-blue-50 font-semibold transition-all text-sm shadow-sm">
                <i class="bi bi-arrow-left"></i>
                Back to Messages
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mx-1 md:mx-0">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Message Details -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-bold text-gray-900">Message Details</h2>
                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold {{ 
                    $inquiry->status === 'new' ? 'bg-yellow-100 text-yellow-700' : 
                    ($inquiry->status === 'in_progress' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700')
                }}">
                    {{ ucfirst(str_replace('_', ' ', $inquiry->status)) }}
                </span>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Subject</label>
                    <p class="text-gray-900 font-semibold mt-1">{{ $inquiry->subject ?? 'General Inquiry' }}</p>
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Message</label>
                    <div class="mt-2 p-4 bg-gray-50 rounded-xl">
                        <p class="text-gray-900 whitespace-pre-wrap text-sm leading-relaxed">{{ $inquiry->message }}</p>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-100">
                    <p class="text-sm text-gray-500">
                        <i class="bi bi-clock mr-1"></i>
                        Received: {{ $inquiry->created_at->format('F d, Y \a\t h:i A') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Related Property -->
        @if($inquiry->property)
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Related Property</h2>
            <div class="flex items-center gap-4">
                @if($inquiry->property->first_image)
                <img src="{{ $inquiry->property->first_image }}" 
                     alt="{{ $inquiry->property->title }}"
                     class="w-20 h-20 object-cover rounded-xl ring-2 ring-gray-100"
                     onerror="this.src='https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=100';">
                @endif
                <div>
                    <h3 class="font-semibold text-gray-900">{{ $inquiry->property->title }}</h3>
                    <p class="text-sm text-gray-500">{{ $inquiry->property->location }}</p>
                    <a href="{{ route('admin.properties') }}?search={{ $inquiry->property->id }}" 
                       class="text-orange-600 hover:text-orange-700 text-sm font-semibold inline-flex items-center gap-1 mt-1">
                        View Property <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Contact Information -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Contact Information</h2>
            <div class="space-y-4">
                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Name</label>
                    <p class="text-gray-900 mt-1 text-sm">{{ $inquiry->name }}</p>
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Email</label>
                    <p class="text-gray-900 mt-1 text-sm">
                        <a href="mailto:{{ $inquiry->email }}" class="text-orange-600 hover:text-orange-700 font-semibold">
                            {{ $inquiry->email }}
                        </a>
                    </p>
                </div>

                @if($inquiry->phone)
                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Phone</label>
                    <p class="text-gray-900 mt-1 text-sm">
                        <a href="tel:{{ $inquiry->phone }}" class="text-orange-600 hover:text-orange-700 font-semibold">
                            {{ $inquiry->phone }}
                        </a>
                    </p>
                </div>
                @endif

                @if($inquiry->user)
                <div class="pt-4 border-t border-gray-100">
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Registered User</label>
                    <div class="mt-2">
                        <a href="{{ route('admin.users.profile', $inquiry->user->id) }}" 
                           class="inline-flex items-center gap-1.5 text-sm font-semibold text-orange-600 hover:text-orange-700">
                            <i class="bi bi-person"></i>
                            View Profile
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Status Management -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Update Status</h2>
            <form id="statusForm" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Status</label>
                    <select name="status" id="statusSelect" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all bg-white appearance-none" required>
                        <option value="new" {{ $inquiry->status === 'new' ? 'selected' : '' }}>New</option>
                        <option value="in_progress" {{ $inquiry->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="resolved" {{ $inquiry->status === 'resolved' ? 'selected' : '' }}>Resolved</option>
                    </select>
                </div>

                <button type="submit" class="w-full px-4 py-2.5 bg-gradient-to-r from-orange-500 to-yellow-500 text-white rounded-lg hover:from-orange-600 hover:to-yellow-600 font-semibold transition-all text-sm shadow-sm flex items-center justify-center gap-2">
                    <i class="bi bi-check-circle"></i>
                    Update Status
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('statusForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const form = e.target;
        const submitBtn = form.querySelector('button[type="submit"]');
        const status = document.getElementById('statusSelect').value;
        
        showLoader(submitBtn);
        
        try {
            const data = await window.ajax('{{ route("admin.inquiries.status", $inquiry->id) }}', 'POST', {
                status: status,
            });
            
            window.toast(data.message, 'success');
            setTimeout(() => window.location.reload(), 1000);
        } catch (error) {
            hideLoader(submitBtn);
            window.toast(error.message || 'Failed to update status', 'error');
        }
    });
</script>
@endpush
