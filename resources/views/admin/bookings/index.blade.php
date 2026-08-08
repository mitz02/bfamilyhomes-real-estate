@extends('layouts.admin')

@section('title', 'Manage Inspections')

@section('content')
<div class="mb-8">
    <div class="flex items-center gap-2 text-xs md:text-sm text-gray-500 mb-4 px-2 md:px-0">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-orange-600 transition-colors">
            <i class="bi bi-house-door mr-1"></i>B-Family
        </a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-orange-600 font-semibold">Inspections</span>
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
                    <i class="bi bi-calendar-check-fill text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-bold text-white">Manage Inspections</h1>
                    <p class="text-blue-100/80 text-sm mt-0.5">{{ $greeting }}, {{ auth()->user()->name }}!</p>
                    <p class="text-blue-300/60 text-xs mt-0.5">{{ now()->format('l, F j, Y') }}</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/10 backdrop-blur-sm rounded-lg text-white/80 text-xs border border-white/10">
                    <i class="bi bi-calendar-check"></i>
                    {{ $inspections->total() }} Total
                </span>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl border border-gray-100 shadow-sm mx-1 md:mx-0">
    @if($inspections->count() > 0)
        <div class="overflow-x-auto p-6" style="-webkit-overflow-scrolling: touch;">
            <table class="w-full" style="min-width: 1000px;">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Property</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Buyer Details</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Date & Time</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Assigned To</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Status</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inspections as $inspection)
                    <tr class="border-b border-gray-50 last:border-0 hover:bg-gray-50/50 transition-colors">
                        <td class="py-4 px-4 whitespace-nowrap">
                            <div class="flex items-start gap-3">
                                @if($inspection->property->first_image)
                                    <img src="{{ $inspection->property->first_image }}"
                                         alt="{{ $inspection->property->title }}"
                                         class="w-14 h-14 object-cover rounded-lg ring-2 ring-gray-100 flex-shrink-0">
                                @endif
                                <div>
                                    <h4 class="font-semibold text-gray-900 text-sm">{{ Str::limit($inspection->property->title, 35) }}</h4>
                                    <p class="text-xs text-gray-500">{{ $inspection->property->location }}</p>
                                    <p class="text-xs text-orange-600 font-semibold mt-0.5">{{ $inspection->property->formatted_price }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <div class="flex items-center gap-2.5 mb-2">
                                @if($inspection->user->avatar)
                                    <img src="{{ asset('storage/' . $inspection->user->avatar) }}"
                                         alt="{{ $inspection->user->name }}"
                                         class="w-9 h-9 rounded-full object-cover ring-2 ring-gray-100">
                                @else
                                    <div class="w-9 h-9 bg-blue-900 rounded-full flex items-center justify-center text-white font-bold text-xs ring-2 ring-blue-100">
                                        {{ substr($inspection->user->name, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <p class="font-semibold text-gray-900 text-sm">{{ $inspection->user->name }}</p>
                                    <p class="text-xs text-gray-500">Buyer/Client</p>
                                </div>
                            </div>
                            <div class="space-y-0.5">
                                <p class="text-xs text-gray-600 flex items-center gap-1.5">
                                    <i class="bi bi-telephone text-gray-400"></i>
                                    <a href="tel:{{ $inspection->user->phone }}" class="hover:text-orange-600">{{ $inspection->user->phone ?? 'N/A' }}</a>
                                </p>
                                @if($inspection->user->email)
                                <p class="text-xs text-gray-600 flex items-center gap-1.5">
                                    <i class="bi bi-envelope text-gray-400"></i>
                                    <a href="mailto:{{ $inspection->user->email }}" class="hover:text-orange-600 truncate max-w-[150px]">{{ $inspection->user->email }}</a>
                                </p>
                                @endif
                            </div>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <p class="font-semibold text-gray-900 text-sm">{{ $inspection->preferred_date->format('M d, Y') }}</p>
                            <p class="text-xs text-gray-500">{{ $inspection->preferred_time }}</p>
                            @if($inspection->message)
                            <p class="text-xs text-gray-400 mt-1.5 italic flex items-center gap-1">
                                <i class="bi bi-chat-left-text"></i>
                                {{ Str::limit($inspection->message, 40) }}
                            </p>
                            @endif
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            @if($inspection->assignedAgent)
                                <p class="font-semibold text-gray-900 text-sm">{{ $inspection->assignedAgent->name }}</p>
                            @else
                                <span class="text-xs text-gray-400">Not assigned</span>
                            @endif
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <select onchange="updateStatus({{ $inspection->id }}, this.value)" 
                                    class="w-full px-2.5 py-1.5 text-xs border border-gray-200 rounded-lg focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none bg-white text-gray-900 cursor-pointer transition-all">
                                <option value="pending" {{ $inspection->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ $inspection->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="completed" {{ $inspection->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $inspection->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <div class="relative action-menu">
                                <button onclick="toggleActionMenu(this)" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 transition-colors">
                                    <i class="bi bi-three-dots-vertical text-gray-400"></i>
                                </button>
                                <div class="hidden absolute right-0 top-full mt-1 bg-white rounded-xl border border-gray-100 shadow-lg py-1 min-w-[170px] z-50">
                                    <button onclick="viewInspectionDetails({{ $inspection->id }})" 
                                            class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors text-left">
                                        <i class="bi bi-eye text-gray-400"></i> View Details
                                    </button>
                                    <button onclick="assignInspection({{ $inspection->id }})" 
                                            class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors text-left">
                                        <i class="bi bi-person-plus text-gray-400"></i> Assign
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="px-6 pb-6">
            {{ $inspections->links() }}
        </div>
    @else
        <div class="text-center py-16">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="bi bi-calendar-x text-3xl text-gray-300"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-1">No Inspections</h3>
            <p class="text-sm text-gray-500">No inspections have been booked yet</p>
        </div>
    @endif
</div>

<!-- Inspection Details Modal -->
<div id="detailsModal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl max-w-2xl w-full p-6 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-orange-500/10 rounded-lg flex items-center justify-center">
                    <i class="bi bi-calendar-check text-orange-500"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900">Inspection Details</h3>
                    <p class="text-sm text-gray-500">Full inspection information</p>
                </div>
            </div>
            <button onclick="closeDetailsModal()" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 transition-colors">
                <i class="bi bi-x-lg text-gray-400"></i>
            </button>
        </div>
        <div id="inspectionDetailsContent">
            <!-- Content will be loaded here -->
        </div>
    </div>
</div>

<!-- Assign Modal -->
<div id="assignModal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-orange-500/10 rounded-lg flex items-center justify-center">
                <i class="bi bi-person-plus text-orange-500"></i>
            </div>
            <div>
                <h3 class="font-bold text-gray-900">Assign Inspection</h3>
                <p class="text-sm text-gray-500">Select an agent to assign</p>
            </div>
        </div>
        <form id="assignForm" class="space-y-4">
            @csrf
            <input type="hidden" id="assignInspectionId" name="inspection_id">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Assign To Agent *</label>
                <select id="assignedTo" name="assigned_to" 
                        class="w-full border border-gray-200 rounded-lg p-2.5 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all bg-white" required>
                    <option value="">Select Agent</option>
                    @php
                        $agents = \App\Models\User::where('role', 'agent')->where('status', 'active')->get();
                    @endphp
                    @foreach($agents as $agent)
                    <option value="{{ $agent->id }}">{{ $agent->name }} ({{ $agent->email }})</option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="flex-1 px-4 py-2.5 bg-gradient-to-r from-orange-500 to-yellow-500 text-white rounded-lg hover:from-orange-600 hover:to-yellow-600 font-semibold transition-all text-sm">Assign</button>
                <button type="button" onclick="closeAssignModal()" class="flex-1 px-4 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-semibold transition-all text-sm">Cancel</button>
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

    async function viewInspectionDetails(id) {
        const modal = document.getElementById('detailsModal');
        const content = document.getElementById('inspectionDetailsContent');
        
        content.innerHTML = '<div class="text-center py-12"><div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4"><i class="bi bi-hourglass-split text-xl text-gray-400"></i></div><p class="text-sm text-gray-500">Loading inspection details...</p></div>';
        modal.classList.remove('hidden');
        
        try {
            @php
                $inspectionsData = $inspections->map(function($inspection) {
                    return [
                        'id' => $inspection->id,
                        'property' => [
                            'title' => $inspection->property->title ?? 'N/A',
                            'location' => $inspection->property->location ?? 'N/A',
                            'formatted_price' => $inspection->property->formatted_price ?? 'N/A',
                            'type' => $inspection->property->type ?? 'N/A',
                            'first_image' => $inspection->property->first_image ?? null,
                        ],
                        'user' => [
                            'name' => $inspection->user->name ?? 'N/A',
                            'phone' => $inspection->user->phone ?? null,
                            'email' => $inspection->user->email ?? null,
                            'address' => $inspection->user->address ?? null,
                            'avatar' => $inspection->user->avatar ? asset('storage/' . $inspection->user->avatar) : null,
                        ],
                        'preferred_date' => $inspection->preferred_date ? $inspection->preferred_date->format('Y-m-d') : null,
                        'preferred_time' => $inspection->preferred_time ?? 'N/A',
                        'status' => $inspection->status ?? 'pending',
                        'message' => $inspection->message ?? null,
                        'admin_notes' => $inspection->admin_notes ?? null,
                        'assigned_agent' => $inspection->assignedAgent ? [
                            'name' => $inspection->assignedAgent->name,
                            'email' => $inspection->assignedAgent->email ?? null,
                        ] : null,
                        'created_at' => $inspection->created_at ? $inspection->created_at->format('M d, Y h:i A') : null,
                    ];
                })->toJson();
            @endphp
            
            const inspections = @json($inspectionsData);
            let inspectionData = inspections.find(i => i.id === id);
            
            if (!inspectionData) {
                try {
                    const response = await fetch(`{{ route('admin.bookings') }}?inspection_id=${id}`);
                    if (response.ok) {
                        throw new Error('Inspection not found on current page');
                    }
                } catch (fetchError) {
                    content.innerHTML = `
                        <div class="text-center py-12">
                            <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="bi bi-exclamation-triangle text-2xl text-yellow-600"></i>
                            </div>
                            <p class="font-semibold text-gray-900 mb-1">Inspection details not found</p>
                            <p class="text-sm text-gray-500">The inspection may not be on the current page. Please refresh and try again.</p>
                        </div>
                    `;
                    return;
                }
            }
            
            function escapeHtml(text) {
                if (!text) return '';
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }
            
            let formattedDate = 'N/A';
            if (inspectionData.preferred_date) {
                const date = new Date(inspectionData.preferred_date + 'T00:00:00');
                formattedDate = date.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
            }
            
            const statusClasses = {
                'confirmed': 'bg-green-100 text-green-700',
                'completed': 'bg-blue-100 text-blue-700',
                'cancelled': 'bg-red-100 text-red-700',
                'pending': 'bg-yellow-100 text-yellow-700'
            };
            const statusClass = statusClasses[inspectionData.status] || 'bg-gray-100 text-gray-700';
            const statusText = inspectionData.status ? inspectionData.status.charAt(0).toUpperCase() + inspectionData.status.slice(1) : 'Pending';
            
            content.innerHTML = `
                <div class="space-y-6">
                    <div class="border-b border-gray-100 pb-4">
                        <h4 class="font-semibold text-gray-900 mb-3 flex items-center gap-2 text-sm">
                            <i class="bi bi-house-door text-orange-500"></i>
                            Property Information
                        </h4>
                        ${inspectionData.property.first_image ? `
                        <div class="mb-3">
                            <img src="${escapeHtml(inspectionData.property.first_image)}" 
                                 alt="${escapeHtml(inspectionData.property.title)}"
                                 class="w-full h-48 object-cover rounded-xl">
                        </div>
                        ` : ''}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-gray-500 mb-0.5">Property Title</p>
                                <p class="font-semibold text-gray-900 text-sm">${escapeHtml(inspectionData.property.title)}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-0.5">Location</p>
                                <p class="font-semibold text-gray-900 text-sm">${escapeHtml(inspectionData.property.location)}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-0.5">Price</p>
                                <p class="font-semibold text-orange-600 text-sm">${escapeHtml(inspectionData.property.formatted_price)}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-0.5">Type</p>
                                <p class="font-semibold text-gray-900 text-sm">${escapeHtml(inspectionData.property.type)}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="border-b border-gray-100 pb-4">
                        <h4 class="font-semibold text-gray-900 mb-3 flex items-center gap-2 text-sm">
                            <i class="bi bi-person text-orange-500"></i>
                            Buyer/Client Details
                        </h4>
                        <div class="flex items-center gap-3 mb-4">
                            ${inspectionData.user.avatar ? `
                            <img src="${escapeHtml(inspectionData.user.avatar)}" 
                                 alt="${escapeHtml(inspectionData.user.name)}"
                                 class="w-12 h-12 rounded-full object-cover ring-2 ring-gray-100">
                            ` : `
                            <div class="w-12 h-12 bg-blue-900 rounded-full flex items-center justify-center text-white font-bold ring-2 ring-blue-100">
                                ${escapeHtml(inspectionData.user.name.charAt(0).toUpperCase())}
                            </div>
                            `}
                            <div>
                                <p class="font-semibold text-gray-900 text-sm">${escapeHtml(inspectionData.user.name)}</p>
                                <p class="text-xs text-gray-500">Client</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            ${inspectionData.user.phone ? `
                            <div>
                                <p class="text-xs text-gray-500 mb-0.5">Phone Number</p>
                                <p class="font-semibold text-gray-900 text-sm">
                                    <a href="tel:${escapeHtml(inspectionData.user.phone)}" class="text-orange-600 hover:text-orange-700 flex items-center gap-2">
                                        <i class="bi bi-telephone text-gray-400"></i>
                                        ${escapeHtml(inspectionData.user.phone)}
                                    </a>
                                </p>
                            </div>
                            ` : ''}
                            ${inspectionData.user.email ? `
                            <div>
                                <p class="text-xs text-gray-500 mb-0.5">Email Address</p>
                                <p class="font-semibold text-gray-900 text-sm">
                                    <a href="mailto:${escapeHtml(inspectionData.user.email)}" class="text-orange-600 hover:text-orange-700 flex items-center gap-2">
                                        <i class="bi bi-envelope text-gray-400"></i>
                                        ${escapeHtml(inspectionData.user.email)}
                                    </a>
                                </p>
                            </div>
                            ` : ''}
                            ${inspectionData.user.address ? `
                            <div class="md:col-span-2">
                                <p class="text-xs text-gray-500 mb-0.5">Address</p>
                                <p class="font-semibold text-gray-900 text-sm flex items-start gap-2">
                                    <i class="bi bi-geo-alt text-gray-400 mt-0.5"></i>
                                    <span>${escapeHtml(inspectionData.user.address)}</span>
                                </p>
                            </div>
                            ` : ''}
                        </div>
                    </div>
                    
                    <div class="border-b border-gray-100 pb-4">
                        <h4 class="font-semibold text-gray-900 mb-3 flex items-center gap-2 text-sm">
                            <i class="bi bi-calendar-check text-orange-500"></i>
                            Inspection Details
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-gray-500 mb-0.5">Preferred Date</p>
                                <p class="font-semibold text-gray-900 text-sm flex items-center gap-2">
                                    <i class="bi bi-calendar text-gray-400"></i>
                                    ${formattedDate}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-0.5">Preferred Time</p>
                                <p class="font-semibold text-gray-900 text-sm flex items-center gap-2">
                                    <i class="bi bi-clock text-gray-400"></i>
                                    ${escapeHtml(inspectionData.preferred_time)}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-0.5">Status</p>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold ${statusClass}">
                                    ${statusText}
                                </span>
                            </div>
                            ${inspectionData.assigned_agent ? `
                            <div>
                                <p class="text-xs text-gray-500 mb-0.5">Assigned To</p>
                                <p class="font-semibold text-gray-900 text-sm flex items-center gap-2">
                                    <i class="bi bi-person-check text-gray-400"></i>
                                    ${escapeHtml(inspectionData.assigned_agent.name)}
                                </p>
                                ${inspectionData.assigned_agent.email ? `
                                <p class="text-xs text-gray-500 mt-1">
                                    <a href="mailto:${escapeHtml(inspectionData.assigned_agent.email)}" class="text-orange-600 hover:text-orange-700">
                                        ${escapeHtml(inspectionData.assigned_agent.email)}
                                    </a>
                                </p>
                                ` : ''}
                            </div>
                            ` : `
                            <div>
                                <p class="text-xs text-gray-500 mb-0.5">Assigned To</p>
                                <p class="text-sm text-gray-400 italic">Not assigned</p>
                            </div>
                            `}
                            ${inspectionData.created_at ? `
                            <div class="md:col-span-2">
                                <p class="text-xs text-gray-500 mb-0.5">Requested On</p>
                                <p class="text-sm text-gray-600">${escapeHtml(inspectionData.created_at)}</p>
                            </div>
                            ` : ''}
                        </div>
                    </div>
                    
                    ${inspectionData.message ? `
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-3 flex items-center gap-2 text-sm">
                            <i class="bi bi-chat-left-text text-orange-500"></i>
                            Message from Client
                        </h4>
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                            <p class="text-gray-700 text-sm whitespace-pre-wrap">${escapeHtml(inspectionData.message)}</p>
                        </div>
                    </div>
                    ` : ''}
                    
                    ${inspectionData.admin_notes ? `
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-3 flex items-center gap-2 text-sm">
                            <i class="bi bi-sticky text-orange-500"></i>
                            Admin Notes
                        </h4>
                        <div class="bg-yellow-50 p-4 rounded-xl border border-yellow-100">
                            <p class="text-gray-700 text-sm whitespace-pre-wrap">${escapeHtml(inspectionData.admin_notes)}</p>
                        </div>
                    </div>
                    ` : ''}
                </div>
            `;
        } catch (error) {
            console.error('Error loading inspection details:', error);
            content.innerHTML = `
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="bi bi-exclamation-triangle text-2xl text-red-600"></i>
                    </div>
                    <p class="font-semibold text-gray-900 mb-1">Error loading inspection details</p>
                    <p class="text-sm text-gray-500">${escapeHtml(error.message || 'An unexpected error occurred')}</p>
                </div>
            `;
        }
    }

    function closeDetailsModal() {
        document.getElementById('detailsModal').classList.add('hidden');
        document.getElementById('inspectionDetailsContent').innerHTML = '';
    }
    
    document.getElementById('detailsModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeDetailsModal();
        }
    });
    
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('detailsModal');
            if (modal && !modal.classList.contains('hidden')) {
                closeDetailsModal();
            }
        }
    });

    function assignInspection(id) {
        document.getElementById('assignInspectionId').value = id;
        document.getElementById('assignModal').classList.remove('hidden');
    }

    function closeAssignModal() {
        document.getElementById('assignModal').classList.add('hidden');
        document.getElementById('assignForm').reset();
    }

    document.getElementById('assignForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const form = e.target;
        const submitBtn = form.querySelector('button[type="submit"]');
        const formData = new FormData(form);
        
        showLoader(submitBtn);
        
        try {
            const inspectionId = formData.get('inspection_id');
            const data = await window.ajax(`{{ route("admin.bookings.assign", ":id") }}`.replace(':id', inspectionId), 'POST', {
                assigned_to: formData.get('assigned_to'),
            });
            window.toast(data.message, 'success');
            closeAssignModal();
            setTimeout(() => window.location.reload(), 1000);
        } catch (error) {
            hideLoader(submitBtn);
            window.toast(error.message || 'Failed to assign inspection', 'error');
        }
    });

    async function updateStatus(id, status) {
        try {
            const data = await window.ajax(`{{ route("admin.bookings.status", ":id") }}`.replace(':id', id), 'POST', {
                status: status,
            });
            window.toast(data.message, 'success');
        } catch (error) {
            window.toast(error.message || 'Failed to update status', 'error');
            window.location.reload();
        }
    }
</script>
@endpush

