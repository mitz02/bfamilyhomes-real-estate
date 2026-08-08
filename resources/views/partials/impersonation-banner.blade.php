@if(session('impersonating'))
<div class="relative z-[100] bg-gradient-to-r from-amber-500 to-orange-500 text-white text-xs md:text-sm shadow-md">
    <div class="container mx-auto px-4 py-2 flex items-center justify-between gap-3">
        <p class="flex items-center gap-2 font-medium min-w-0 truncate">
            <i class="bi bi-incognito text-base flex-shrink-0"></i>
            <span class="truncate">Signed in as <strong>{{ auth()->user()->name }}</strong> (impersonated by {{ session('impersonator_name') ?? 'Admin' }})</span>
        </p>
        <form method="POST" action="{{ route('admin.stop-impersonation') }}" class="flex-shrink-0">
            @csrf
            <button type="submit" class="inline-flex items-center gap-1 bg-white text-orange-600 font-semibold px-3 py-1.5 rounded-lg hover:bg-orange-50 transition-colors">
                <i class="bi bi-x-circle"></i> Stop
            </button>
        </form>
    </div>
</div>
@endif
