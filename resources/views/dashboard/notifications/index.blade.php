@php
    $layout = 'layouts.dashboard';
    if (auth()->user()->isAdmin()) {
        $layout = 'layouts.admin';
    } elseif (auth()->user()->isAgent()) {
        $layout = 'layouts.agent';
    } elseif (auth()->user()->isInvestor()) {
        $layout = 'layouts.investor';
    }
@endphp
@extends($layout)

@section('title', 'Notifications')

@section('content')
<div class="mb-8">
    <div class="relative bg-gradient-to-br from-blue-900 via-blue-800 to-blue-900 rounded-2xl p-6 md:p-8 shadow-lg overflow-hidden">
        <div class="absolute -top-10 -right-10 w-48 h-48 bg-white/5 rounded-full"></div>
        <div class="absolute -bottom-10 -left-10 w-36 h-36 bg-white/5 rounded-full"></div>
        <div class="absolute top-1/2 right-1/3 w-20 h-20 bg-white/5 rounded-full"></div>

        <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-start gap-4">
                <div class="w-14 h-14 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center shadow-sm flex-shrink-0 border border-white/10">
                    <i class="bi bi-bell text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-bold text-white">Notifications</h1>
                    <p class="text-blue-100/80 text-sm mt-0.5">View all your notifications</p>
                </div>
            </div>
            <button onclick="markAllAsRead()" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white/10 text-white rounded-xl hover:bg-white/20 font-semibold transition-all text-sm backdrop-blur-sm border border-white/10 flex-shrink-0">
                <i class="bi bi-check-all"></i>
                Mark All as Read
            </button>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
    @if($notifications->count() > 0)
        <div class="space-y-4">
            @foreach($notifications as $notification)
            <div class="flex items-start gap-4 p-4 rounded-xl border {{ $notification->is_read ? 'border-gray-100 bg-gray-50/50' : 'border-orange-200 bg-orange-50' }} hover:shadow-sm transition-all cursor-pointer" onclick="markAsRead({{ $notification->id }})">
                <div class="w-12 h-12 rounded-full flex items-center justify-center bg-orange-100 flex-shrink-0">
                    <i class="bi {{ $notification->icon ?? 'bi-info-circle' }} text-orange-600 text-xl"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex-1">
                            <h4 class="font-bold text-gray-900">{{ $notification->title }}</h4>
                            <p class="text-gray-600 text-sm mt-1">{{ $notification->message }}</p>
                            <p class="text-xs text-gray-400 mt-2">
                                <i class="bi bi-clock"></i>
                                {{ $notification->created_at->diffForHumans() }}
                            </p>
                        </div>
                        @if(!$notification->is_read)
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-gradient-to-r from-orange-500 to-yellow-500 text-white">New</span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $notifications->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <i class="bi bi-bell-slash text-6xl text-gray-200 mb-4"></i>
            <h3 class="text-xl font-bold text-gray-900 mb-2">No Notifications</h3>
            <p class="text-gray-500 text-sm">You're all caught up! No new notifications.</p>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    async function markAsRead(notificationId) {
        try {
            const data = await window.ajax(`{{ route("notifications.read", ":id") }}`.replace(':id', notificationId), 'POST');
            if (data.success) {
                window.toast('Notification marked as read', 'success');
                setTimeout(() => window.location.reload(), 1000);
            }
        } catch (error) {
            window.toast('Failed to mark notification as read', 'error');
        }
    }

    async function markAllAsRead() {
        if (!confirm('Mark all notifications as read?')) return;
        
        try {
            const data = await window.ajax('{{ route("notifications.read-all") }}', 'POST');
            if (data.success) {
                window.toast('All notifications marked as read', 'success');
                setTimeout(() => window.location.reload(), 1000);
            }
        } catch (error) {
            window.toast('Failed to mark notifications as read', 'error');
        }
    }
</script>
@endpush
