@extends('layouts.admin')

@section('title', 'Manage Users')

@section('content')
<div class="mb-8">
    <div class="flex items-center gap-2 text-xs md:text-sm text-gray-500 mb-4 px-2 md:px-0">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-orange-600 transition-colors">
            <i class="bi bi-house-door mr-1"></i>B-Family
        </a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-orange-600 font-semibold">Manage Users</span>
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
                    <i class="bi bi-people-fill text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-bold text-white">Manage Users</h1>
                    <p class="text-blue-100/80 text-sm mt-0.5">{{ $greeting }}, {{ auth()->user()->name }}!</p>
                    <p class="text-blue-300/60 text-xs mt-0.5">{{ now()->format('l, F j, Y') }}</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/10 backdrop-blur-sm rounded-lg text-white/80 text-xs border border-white/10">
                    <i class="bi bi-people-fill"></i>
                    {{ $userStats['all'] }} Total
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Filter Tabs -->
<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-3 md:p-4 mb-6 mx-1 md:mx-0">
    <div class="flex flex-wrap items-center gap-2">
        <a href="{{ route('admin.users') }}" 
           class="px-3 md:px-4 py-2 rounded-lg font-semibold transition-all text-center text-sm shadow-sm {{ !request('role') && !request('status') && !request('pending') ? 'bg-gradient-to-r from-orange-500 to-yellow-500 text-white shadow-md' : 'bg-gray-50 text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
            <i class="bi bi-people-fill mr-1"></i>
            All <span class="hidden sm:inline">Users</span> ({{ $userStats['all'] }})
        </a>
        <a href="{{ route('admin.users', ['role' => 'user']) }}" 
           class="px-3 md:px-4 py-2 rounded-lg font-semibold transition-all text-center text-sm shadow-sm {{ request('role') === 'user' ? 'bg-gradient-to-r from-orange-500 to-yellow-500 text-white shadow-md' : 'bg-gray-50 text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
            <i class="bi bi-person-fill mr-1"></i>
            Users ({{ $userStats['users'] }})
        </a>
        <a href="{{ route('admin.users', ['role' => 'agent']) }}" 
           class="px-3 md:px-4 py-2 rounded-lg font-semibold transition-all text-center text-sm shadow-sm {{ request('role') === 'agent' ? 'bg-gradient-to-r from-orange-500 to-yellow-500 text-white shadow-md' : 'bg-gray-50 text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
            <i class="bi bi-person-badge-fill mr-1"></i>
            Agents ({{ $userStats['agents'] }})
        </a>
        <a href="{{ route('admin.users', ['role' => 'investor']) }}" 
           class="px-3 md:px-4 py-2 rounded-lg font-semibold transition-all text-center text-sm shadow-sm {{ request('role') === 'investor' ? 'bg-gradient-to-r from-orange-500 to-yellow-500 text-white shadow-md' : 'bg-gray-50 text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
            <i class="bi bi-graph-up-arrow mr-1"></i>
            Investors ({{ $userStats['investors'] }})
        </a>
        <a href="{{ route('admin.users', ['pending' => 'agent']) }}" 
           class="px-3 md:px-4 py-2 rounded-lg font-semibold transition-all text-center text-sm shadow-sm {{ request('pending') === 'agent' ? 'bg-gradient-to-r from-orange-500 to-yellow-500 text-white shadow-md' : 'bg-gray-50 text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
            <i class="bi bi-clock-history mr-1"></i>
            Pending Agents ({{ $userStats['pending_agents'] }})
        </a>
        <a href="{{ route('admin.users', ['pending' => 'investor']) }}" 
           class="px-3 md:px-4 py-2 rounded-lg font-semibold transition-all text-center text-sm shadow-sm {{ request('pending') === 'investor' ? 'bg-gradient-to-r from-orange-500 to-yellow-500 text-white shadow-md' : 'bg-gray-50 text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
            <i class="bi bi-hourglass-split mr-1"></i>
            Pending Investors ({{ $userStats['pending_investors'] }})
        </a>
    </div>
</div>

<!-- Search and Filters -->
<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 md:p-6 mb-6 mx-1 md:mx-0">
    <div class="flex items-center gap-2 mb-4">
        <div class="w-8 h-8 bg-orange-500/10 rounded-lg flex items-center justify-center">
            <i class="bi bi-funnel-fill text-orange-500 text-sm"></i>
        </div>
        <h3 class="font-bold text-gray-900 text-sm md:text-base">Search & Filter Users</h3>
    </div>
    <form method="GET" action="{{ route('admin.users') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 md:gap-4">
        <div class="relative">
            <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="Search by name, email..." 
                   class="w-full pl-10 pr-3 py-2.5 text-sm border border-gray-200 rounded-lg focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all">
        </div>
        <div class="relative">
            <i class="bi bi-check-circle absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <select name="status" class="w-full pl-10 pr-3 py-2.5 text-sm border border-gray-200 rounded-lg focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all bg-white appearance-none">
                <option value="">All Status</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="blocked" {{ request('status') === 'blocked' ? 'selected' : '' }}>Blocked</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
            </select>
        </div>
        <div class="relative">
            <i class="bi bi-person-circle absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <select name="role" class="w-full pl-10 pr-3 py-2.5 text-sm border border-gray-200 rounded-lg focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all bg-white appearance-none">
                <option value="">All Roles</option>
                <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>User</option>
                <option value="agent" {{ request('role') === 'agent' ? 'selected' : '' }}>Agent</option>
                <option value="investor" {{ request('role') === 'investor' ? 'selected' : '' }}>Investor</option>
            </select>
        </div>
        <button type="submit" class="px-4 py-2.5 bg-gradient-to-r from-orange-500 to-yellow-500 text-white rounded-lg hover:from-orange-600 hover:to-yellow-600 font-semibold transition-all text-sm shadow-sm flex items-center justify-center gap-2">
            <i class="bi bi-funnel"></i>
            Apply Filters
        </button>
    </form>
</div>

<!-- Users Table -->
<div class="bg-white rounded-xl border border-gray-100 shadow-sm mx-1 md:mx-0">
    @if($users->count() > 0)
        <div class="overflow-x-auto p-6" style="-webkit-overflow-scrolling: touch;">
            <table class="w-full" style="min-width: 900px;">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">User</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Role</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Status</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Activity</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Joined</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr class="border-b border-gray-50 last:border-0 hover:bg-gray-50/50 transition-colors">
                        <td class="py-4 px-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" 
                                     alt="{{ $user->name }}"
                                     class="w-10 h-10 rounded-full object-cover ring-2 ring-gray-100">
                                @else
                                <div class="w-10 h-10 bg-blue-900 rounded-full flex items-center justify-center text-white font-bold text-sm ring-2 ring-blue-100">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                @endif
                                <div>
                                    <h4 class="font-semibold text-gray-900 text-sm">{{ $user->name }}</h4>
                                    <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <div class="flex items-center gap-1.5">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold {{ 
                                    $user->role === 'admin' ? 'bg-orange-500/10 text-orange-600' : 
                                    ($user->role === 'agent' ? 'bg-orange-500/10 text-orange-600' : 
                                    ($user->role === 'investor' ? 'bg-orange-500/10 text-orange-600' : 'bg-gray-100 text-gray-700'))
                                }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                                @if(($user->role === 'agent' && !$user->agent_approved_at) || ($user->role === 'investor' && !$user->investor_approved_at))
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-700">Pending</span>
                                @endif
                            </div>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold {{ 
                                $user->status === 'active' ? 'bg-green-100 text-green-700' : 
                                ($user->status === 'blocked' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700')
                            }}">
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>
                        <td class="py-4 px-4 text-sm text-gray-500 whitespace-nowrap">
                            <div class="space-y-0.5">
                                <p><span class="font-semibold text-gray-700">{{ $user->properties_count }}</span> Properties</p>
                                <p><span class="font-semibold text-gray-700">{{ $user->inspections_count }}</span> Inspections</p>
                                <p><span class="font-semibold text-gray-700">{{ $user->payments_count }}</span> Payments</p>
                            </div>
                        </td>
                        <td class="py-4 px-4 text-sm text-gray-500 whitespace-nowrap">
                            {{ $user->created_at->format('M d, Y') }}
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.users.profile', $user->id) }}"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 bg-gray-100 text-gray-700 rounded-lg text-xs font-semibold hover:bg-gray-200 transition-colors">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <div class="relative action-menu">
                                    <button onclick="toggleActionMenu(this)" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 transition-colors">
                                        <i class="bi bi-three-dots-vertical text-gray-400"></i>
                                    </button>
                                <div class="hidden absolute right-0 top-full mt-1 bg-white rounded-xl border border-gray-100 shadow-lg py-1 min-w-[180px] max-w-[calc(100vw-16px)] z-50">
                                    <div class="flex items-center justify-between px-3 py-1.5 border-b border-gray-50">
                                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Actions</span>
                                        <button type="button" onclick="closeAllMenus()" class="w-6 h-6 flex items-center justify-center rounded-md hover:bg-gray-100 text-gray-400 hover:text-gray-700 transition-colors" title="Close">
                                            <i class="bi bi-x-lg text-sm"></i>
                                        </button>
                                    </div>

                                    @if($user->investor_requested_at && !$user->investor_approved_at)
                                    <button onclick="approveInvestor({{ $user->id }})" 
                                            class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-green-700 hover:bg-green-50 transition-colors text-left">
                                        <i class="bi bi-check-circle"></i> Approve Investor
                                    </button>
                                    @endif

                                    @if($user->agent_requested_at && !$user->agent_approved_at)
                                    <button onclick="approveAgent({{ $user->id }})" 
                                            class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-blue-700 hover:bg-blue-50 transition-colors text-left">
                                        <i class="bi bi-check-circle"></i> Approve Agent
                                    </button>
                                    @endif

                                    @if(!$user->isAdmin())
                                    <div class="border-t border-gray-50 my-1"></div>
                                    @if($user->status === 'active')
                                    <button onclick="deactivateUser({{ $user->id }})" 
                                            class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-red-700 hover:bg-red-50 transition-colors text-left">
                                        <i class="bi bi-x-circle"></i> Deactivate
                                    </button>
                                    @else
                                    <button onclick="activateUser({{ $user->id }})" 
                                            class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-green-700 hover:bg-green-50 transition-colors text-left">
                                        <i class="bi bi-check-circle"></i> Activate
                                    </button>
                                    @endif
                                    <button onclick="toggleUserStatus({{ $user->id }}, '{{ $user->status }}')" 
                                            class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors text-left">
                                        <i class="bi bi-{{ $user->status === 'active' ? 'lock' : 'unlock' }} text-gray-400"></i>
                                        {{ $user->status === 'active' ? 'Block User' : 'Unblock User' }}
                                    </button>
                                    <div class="border-t border-gray-50 my-1"></div>
                                    <button onclick="impersonateUser({{ $user->id }})" 
                                            class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors text-left">
                                        <i class="bi bi-incognito text-gray-400"></i> Login as User
                                    </button>
                                    <div class="border-t border-gray-50 my-1"></div>
                                    <button onclick="deleteUser({{ $user->id }})" 
                                            class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-red-700 hover:bg-red-50 transition-colors text-left">
                                        <i class="bi bi-trash"></i> Delete User
                                    </button>
                                    @endif
                                </div>
                            </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="px-6 pb-6">
            {{ $users->links() }}
        </div>
    @else
        <div class="text-center py-16">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="bi bi-people text-3xl text-gray-300"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-1">No Users Found</h3>
            <p class="text-sm text-gray-500">Try adjusting your filters</p>
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
            positionMenu(menu, btn);
        }
    }

    function positionMenu(menu, btn) {
        var rect = btn.getBoundingClientRect();
        var menuWidth = menu.offsetWidth || 200;
        var menuHeight = menu.offsetHeight || 260;
        var top = rect.bottom + 6;
        var left = rect.right - menuWidth;
        left = Math.max(8, Math.min(left, window.innerWidth - menuWidth - 8));
        if (top + menuHeight > window.innerHeight - 8) {
            top = Math.max(8, rect.top - menuHeight - 6);
        }
        menu.style.position = 'fixed';
        menu.style.top = top + 'px';
        menu.style.left = left + 'px';
        menu.style.right = 'auto';
        menu.style.zIndex = '50';
    }

    function closeAllMenus() {
        document.querySelectorAll('.action-menu > div:last-child').forEach(function(m) {
            m.classList.add('hidden');
            m.style.position = '';
            m.style.top = '';
            m.style.left = '';
            m.style.right = '';
            m.style.zIndex = '';
        });
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.action-menu')) {
            closeAllMenus();
        }
    });

    window.addEventListener('resize', closeAllMenus);
    window.addEventListener('scroll', closeAllMenus, true);

    async function toggleUserStatus(userId, currentStatus) {
        if (!confirm(`Are you sure you want to ${currentStatus === 'active' ? 'block' : 'unblock'} this user?`)) return;
        
        try {
            const data = await window.ajax(`{{ url('admin/users') }}/${userId}/toggle-status`, 'POST');
            window.toast(data.message, 'success');
            setTimeout(() => window.location.reload(), 1000);
        } catch (error) {
            window.toast(error.message || 'Failed to update user status', 'error');
        }
    }

    async function activateUser(userId) {
        if (!confirm('Activate this user?')) return;
        
        try {
            const data = await window.ajax(`{{ url('admin/users') }}/${userId}/activate`, 'POST');
            window.toast(data.message, 'success');
            setTimeout(() => window.location.reload(), 1000);
        } catch (error) {
            window.toast(error.message || 'Failed to activate user', 'error');
        }
    }

    async function deactivateUser(userId) {
        if (!confirm('Deactivate this user?')) return;
        
        try {
            const data = await window.ajax(`{{ url('admin/users') }}/${userId}/deactivate`, 'POST');
            window.toast(data.message, 'success');
            setTimeout(() => window.location.reload(), 1000);
        } catch (error) {
            window.toast(error.message || 'Failed to deactivate user', 'error');
        }
    }

    async function deleteUser(userId) {
        if (!confirm('Are you sure you want to delete this user? This cannot be undone.')) return;
        
        try {
            const data = await window.ajax(`{{ url('admin/users') }}/${userId}`, 'DELETE');
            window.toast(data.message, 'success');
            setTimeout(() => window.location.reload(), 1000);
        } catch (error) {
            window.toast(error.message || 'Failed to delete user', 'error');
        }
    }

    async function impersonateUser(userId) {
        if (!confirm('Sign in as this user? You can switch back anytime.')) return;
        
        try {
            const data = await window.ajax(`{{ url('admin/users') }}/${userId}/impersonate`, 'POST');
            window.toast(data.message, 'success');
            setTimeout(() => window.location.href = data.redirect || '{{ route('dashboard') }}', 800);
        } catch (error) {
            window.toast(error.message || 'Failed to impersonate user', 'error');
        }
    }

    async function approveInvestor(userId) {
        if (!confirm('Approve this user as an investor?')) return;
        
        try {
            const data = await window.ajax(`{{ url('admin/users') }}/${userId}/approve-investor`, 'POST');
            window.toast(data.message, 'success');
            setTimeout(() => window.location.reload(), 1000);
        } catch (error) {
            window.toast(error.message || 'Failed to approve investor', 'error');
        }
    }

    async function approveAgent(userId) {
        if (!confirm('Approve this user as an agent?')) return;
        
        try {
            const data = await window.ajax(`{{ url('admin/users') }}/${userId}/approve-agent`, 'POST');
            window.toast(data.message, 'success');
            setTimeout(() => window.location.reload(), 1000);
        } catch (error) {
            window.toast(error.message || 'Failed to approve agent', 'error');
        }
    }
</script>
@endpush
