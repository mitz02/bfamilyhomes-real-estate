@extends('layouts.admin')

@section('title', 'Manage Properties')

@section('content')
<div class="mb-8">
    <div class="flex items-center gap-2 text-xs md:text-sm text-gray-500 mb-4 px-2 md:px-0">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-orange-600 transition-colors">
            <i class="bi bi-house-door mr-1"></i>B-Family
        </a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-orange-600 font-semibold">Manage Properties</span>
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
                    <i class="bi bi-building-check text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-bold text-white">Manage Properties</h1>
                    <p class="text-blue-100/80 text-sm mt-0.5">{{ $greeting }}, {{ auth()->user()->name }}!</p>
                    <p class="text-blue-300/60 text-xs mt-0.5">{{ now()->format('l, F j, Y') }}</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/10 backdrop-blur-sm rounded-lg text-white/80 text-xs border border-white/10">
                    <i class="bi bi-building"></i>
                    {{ $propertyStats['all'] }} Total
                </span>
                <a href="{{ route('admin.properties.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-white text-blue-900 rounded-lg hover:bg-blue-50 font-semibold transition-all text-sm shadow-sm">
                    <i class="bi bi-plus-circle"></i>
                    Create
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Filter Tabs -->
<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-3 md:p-4 mb-6 mx-1 md:mx-0">
    <div class="flex flex-wrap items-center gap-2">
        <a href="{{ route('admin.properties') }}" 
           class="px-4 py-2 rounded-lg font-semibold transition-all text-sm shadow-sm {{ !request('status') ? 'bg-gradient-to-r from-orange-500 to-yellow-500 text-white shadow-md' : 'bg-gray-50 text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
            All ({{ $propertyStats['all'] }})
        </a>
        <a href="{{ route('admin.properties', ['status' => 'approved']) }}" 
           class="px-4 py-2 rounded-lg font-semibold transition-all text-sm shadow-sm {{ request('status') === 'approved' ? 'bg-gradient-to-r from-orange-500 to-yellow-500 text-white shadow-md' : 'bg-gray-50 text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
            Approved ({{ $propertyStats['approved'] }})
        </a>
        <a href="{{ route('admin.properties', ['status' => 'pending']) }}" 
           class="px-4 py-2 rounded-lg font-semibold transition-all text-sm shadow-sm {{ request('status') === 'pending' ? 'bg-gradient-to-r from-orange-500 to-yellow-500 text-white shadow-md' : 'bg-gray-50 text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
            Pending ({{ $propertyStats['pending'] }})
        </a>
        <a href="{{ route('admin.properties', ['status' => 'rejected']) }}" 
           class="px-4 py-2 rounded-lg font-semibold transition-all text-sm shadow-sm {{ request('status') === 'rejected' ? 'bg-gradient-to-r from-orange-500 to-yellow-500 text-white shadow-md' : 'bg-gray-50 text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
            Rejected ({{ $propertyStats['rejected'] }})
        </a>
    </div>
</div>

<!-- Search and Filters -->
<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 md:p-6 mb-6 mx-1 md:mx-0">
    <div class="flex items-center gap-2 mb-4">
        <div class="w-8 h-8 bg-orange-500/10 rounded-lg flex items-center justify-center">
            <i class="bi bi-funnel-fill text-orange-500 text-sm"></i>
        </div>
        <h3 class="font-bold text-gray-900 text-sm md:text-base">Search & Filter Properties</h3>
    </div>
    <form method="GET" action="{{ route('admin.properties') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-3 md:gap-4">
        <div class="relative">
            <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="Search properties..." 
                   class="w-full pl-10 pr-3 py-2.5 text-sm border border-gray-200 rounded-lg focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all">
        </div>
        <div class="relative">
            <i class="bi bi-check-circle absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <select name="status" class="w-full pl-10 pr-3 py-2.5 text-sm border border-gray-200 rounded-lg focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all bg-white appearance-none">
                <option value="">All Status</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </div>
        <div class="relative">
            <i class="bi bi-building absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <select name="type" class="w-full pl-10 pr-3 py-2.5 text-sm border border-gray-200 rounded-lg focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all bg-white appearance-none">
                <option value="">All Types</option>
                <option value="Rent" {{ request('type') === 'Rent' ? 'selected' : '' }}>For Rent</option>
                <option value="Sale" {{ request('type') === 'Sale' ? 'selected' : '' }}>For Sale</option>
                <option value="Investment" {{ request('type') === 'Investment' ? 'selected' : '' }}>Investment</option>
            </select>
        </div>
        <div class="relative">
            <i class="bi bi-person absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <select name="agent_id" class="w-full pl-10 pr-3 py-2.5 text-sm border border-gray-200 rounded-lg focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all bg-white appearance-none">
                <option value="">All Agents</option>
                @if(isset($agents) && $agents->count() > 0)
                @foreach($agents as $agent)
                <option value="{{ $agent->id }}" {{ request('agent_id') == $agent->id ? 'selected' : '' }}>{{ $agent->name }}</option>
                @endforeach
                @endif
            </select>
        </div>
        <button type="submit" class="px-4 py-2.5 bg-gradient-to-r from-orange-500 to-yellow-500 text-white rounded-lg hover:from-orange-600 hover:to-yellow-600 font-semibold transition-all text-sm shadow-sm flex items-center justify-center gap-2">
            <i class="bi bi-funnel"></i>
            Filter
        </button>
    </form>
</div>

<!-- Properties Table -->
<div class="bg-white rounded-xl border border-gray-100 shadow-sm mx-1 md:mx-0">
    @if($properties->count() > 0)
        <div class="overflow-x-auto p-6" style="-webkit-overflow-scrolling: touch;">
            <table class="w-full" style="min-width: 1100px;">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Property</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Agent</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Price</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Status</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Featured</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Tags</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($properties as $property)
                    <tr class="border-b border-gray-50 last:border-0 hover:bg-gray-50/50 transition-colors">
                        <td class="py-4 px-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <img src="{{ $property->first_image }}" 
                                     alt="{{ $property->title }}"
                                     class="w-14 h-14 object-cover rounded-lg ring-2 ring-gray-100"
                                     onerror="this.src='https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=100'">
                                <div>
                                    <h4 class="font-semibold text-gray-900 text-sm">{{ Str::limit($property->title, 35) }}</h4>
                                    <p class="text-xs text-gray-500">{{ $property->location }}</p>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-600 mt-0.5">{{ $property->type }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            @if($property->agent)
                                <div class="flex items-center gap-2.5">
                                    @if($property->agent->avatar)
                                        <img src="{{ asset('storage/' . $property->agent->avatar) }}" 
                                             alt="{{ $property->agent->name }}"
                                             class="w-9 h-9 rounded-full object-cover ring-2 ring-gray-100">
                                    @else
                                        <div class="w-9 h-9 bg-blue-900 rounded-full flex items-center justify-center text-white font-bold text-xs ring-2 ring-blue-100">
                                            {{ substr($property->agent->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-semibold text-gray-900 text-sm">{{ $property->agent->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $property->agent->email }}</p>
                                    </div>
                                </div>
                            @else
                                <p class="text-sm text-gray-400 italic">Agent deleted</p>
                            @endif
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <p class="font-bold text-gray-900">{{ $property->formatted_price }}</p>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <div class="flex flex-col gap-1 items-start">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold {{ 
                                    $property->approval_status === 'approved' ? 'bg-green-100 text-green-700' : 
                                    ($property->approval_status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700')
                                }}">
                                    {{ ucfirst($property->approval_status) }}
                                </span>
                                @if($property->isSold())
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[11px] font-bold bg-red-100 text-red-700 border border-red-200">
                                        <i class="bi bi-tag-fill text-[10px]"></i>
                                        {{ $property->getSoldBadgeText() }}
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <button onclick="toggleFeatured({{ $property->id }}, {{ $property->is_featured ? 'true' : 'false' }})" 
                                    class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold {{ $property->is_featured ? 'bg-orange-500/10 text-orange-600' : 'bg-gray-100 text-gray-600' }}">
                                {{ $property->is_featured ? 'Featured' : 'Not Featured' }}
                            </button>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <button onclick="openTagsModal({{ $property->id }}, {{ json_encode($property->tags ?? []) }})" 
                                    class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold bg-orange-500/10 text-orange-600 hover:bg-orange-500/20 transition-colors">
                                <i class="bi bi-tags"></i>
                                {{ !empty($property->tags) ? count($property->tags) . ' Tags' : 'Add Tags' }}
                            </button>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <div class="relative action-menu">
                                <button onclick="toggleActionMenu(this)" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 transition-colors">
                                    <i class="bi bi-three-dots-vertical text-gray-400"></i>
                                </button>
                                <div class="hidden absolute right-0 top-full mt-1 bg-white rounded-xl border border-gray-100 shadow-lg py-1 min-w-[175px] z-50">
                                    <a href="{{ route('properties.show', $property->id) }}" 
                                       class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                        <i class="bi bi-eye text-gray-400"></i> View Property
                                    </a>

                                    @if($property->approval_status === 'pending')
                                    <div class="border-t border-gray-50 my-1"></div>
                                    <button onclick="approveProperty({{ $property->id }})" 
                                            class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-green-700 hover:bg-green-50 transition-colors text-left">
                                        <i class="bi bi-check-circle"></i> Approve
                                    </button>
                                    <button onclick="rejectProperty({{ $property->id }})" 
                                            class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-red-700 hover:bg-red-50 transition-colors text-left">
                                        <i class="bi bi-x-circle"></i> Reject
                                    </button>
                                    @endif

                                    <div class="border-t border-gray-50 my-1"></div>
                                    @if($property->isSold())
                                    <button onclick="openMarkSoldModal({{ $property->id }}, {{ json_encode($property->title) }}, {{ json_encode($property->sold_info ?? '') }})" 
                                            class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-orange-600 hover:bg-orange-50 transition-colors text-left">
                                        <i class="bi bi-pencil-square text-orange-500"></i> Edit Sold Status
                                    </button>
                                    <button onclick="markAsAvailable({{ $property->id }})" 
                                            class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-green-600 hover:bg-green-50 transition-colors text-left">
                                        <i class="bi bi-arrow-counterclockwise text-green-500"></i> Mark as Available
                                    </button>
                                    @else
                                    <button onclick="openMarkSoldModal({{ $property->id }}, {{ json_encode($property->title) }}, '')" 
                                            class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors text-left">
                                        <i class="bi bi-tag-fill text-red-500"></i> Mark as Sold
                                    </button>
                                    @endif

                                    <div class="border-t border-gray-50 my-1"></div>
                                    <button onclick="toggleFeatured({{ $property->id }}, {{ $property->is_featured ? 'true' : 'false' }})" 
                                            class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors text-left">
                                        <i class="bi bi-star text-gray-400"></i> {{ $property->is_featured ? 'Unfeature' : 'Feature' }}
                                    </button>
                                    <button onclick="openTagsModal({{ $property->id }}, {{ json_encode($property->tags ?? []) }})" 
                                            class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors text-left">
                                        <i class="bi bi-tags text-gray-400"></i> Edit Tags
                                    </button>

                                    <div class="border-t border-gray-50 my-1"></div>
                                    <button onclick="deleteProperty({{ $property->id }})" 
                                            class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-red-700 hover:bg-red-50 transition-colors text-left">
                                        <i class="bi bi-trash"></i> Delete
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
            {{ $properties->links() }}
        </div>
    @else
        <div class="text-center py-16">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="bi bi-building text-3xl text-gray-300"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-1">No Properties</h3>
            <p class="text-sm text-gray-500">No properties have been submitted yet</p>
        </div>
    @endif
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                <i class="bi bi-x-circle text-red-600"></i>
            </div>
            <div>
                <h3 class="font-bold text-gray-900">Reject Property</h3>
                <p class="text-sm text-gray-500">Provide a reason for rejection</p>
            </div>
        </div>
        <form id="rejectForm" class="space-y-4">
            @csrf
            <input type="hidden" id="rejectPropertyId" name="property_id">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Rejection Reason *</label>
                <textarea id="rejectionReason" name="rejection_reason" rows="4" 
                          class="w-full border border-gray-200 rounded-lg p-3 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all" required></textarea>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="flex-1 px-4 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 font-semibold transition-all text-sm">
                    Reject Property
                </button>
                <button type="button" onclick="closeRejectModal()" class="flex-1 px-4 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-semibold transition-all text-sm">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Tags Modal -->
<div id="tagsModal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-orange-500/10 rounded-lg flex items-center justify-center">
                <i class="bi bi-tags text-orange-500"></i>
            </div>
            <div>
                <h3 class="font-bold text-gray-900">Manage Property Tags</h3>
                <p class="text-sm text-gray-500">Select tags for this property</p>
            </div>
        </div>
        <form id="tagsForm">
            <input type="hidden" id="tagsPropertyId" name="property_id">
            <div id="tagsContainer" class="space-y-3 mb-6">
                <!-- Tags will be populated here -->
            </div>
            <div class="flex gap-3">
                <button type="submit" class="flex-1 px-4 py-2.5 bg-gradient-to-r from-orange-500 to-yellow-500 text-white rounded-lg hover:from-orange-600 hover:to-yellow-600 font-semibold transition-all text-sm">
                    <i class="bi bi-check-lg"></i> Save Tags
                </button>
                <button type="button" onclick="closeTagsModal()" class="flex-1 px-4 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-semibold transition-all text-sm">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>
<!-- Mark as Sold Modal -->
<div id="markSoldModal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                <i class="bi bi-tag-fill text-red-600 text-lg"></i>
            </div>
            <div>
                <h3 class="font-bold text-gray-900">Mark Property as Sold</h3>
                <p class="text-xs text-gray-500 truncate max-w-[280px]" id="markSoldPropertyTitle">Property Title</p>
            </div>
        </div>
        
        <form id="markSoldForm" class="space-y-4">
            <input type="hidden" id="markSoldPropertyId" name="property_id">
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Sold Status / Badge Text</label>
                <p class="text-xs text-gray-500 mb-2">This badge text (e.g. "Sold Out" or "500 Plots Sold") will replace the "NEW" tag on property cards across the website.</p>
                <input type="text" id="soldInfoInput" name="sold_info" 
                       placeholder="e.g. 500 Plots Sold, 20 Units Sold, Sold Out" 
                       class="w-full border border-gray-200 rounded-lg p-3 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all">
            </div>

            <!-- Quick Presets -->
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wider">Quick Presets</label>
                <div class="flex flex-wrap gap-1.5">
                    <button type="button" onclick="setSoldPreset('Sold Out')" class="px-2.5 py-1 text-xs rounded-lg bg-gray-100 text-gray-700 hover:bg-red-50 hover:text-red-600 hover:border-red-200 border border-gray-200 transition-colors font-medium">Sold Out</button>
                    <button type="button" onclick="setSoldPreset('500 Plots Sold')" class="px-2.5 py-1 text-xs rounded-lg bg-gray-100 text-gray-700 hover:bg-red-50 hover:text-red-600 hover:border-red-200 border border-gray-200 transition-colors font-medium">500 Plots Sold</button>
                    <button type="button" onclick="setSoldPreset('200 Plots Sold')" class="px-2.5 py-1 text-xs rounded-lg bg-gray-100 text-gray-700 hover:bg-red-50 hover:text-red-600 hover:border-red-200 border border-gray-200 transition-colors font-medium">200 Plots Sold</button>
                    <button type="button" onclick="setSoldPreset('100 Plots Sold')" class="px-2.5 py-1 text-xs rounded-lg bg-gray-100 text-gray-700 hover:bg-red-50 hover:text-red-600 hover:border-red-200 border border-gray-200 transition-colors font-medium">100 Plots Sold</button>
                    <button type="button" onclick="setSoldPreset('50 Plots Sold')" class="px-2.5 py-1 text-xs rounded-lg bg-gray-100 text-gray-700 hover:bg-red-50 hover:text-red-600 hover:border-red-200 border border-gray-200 transition-colors font-medium">50 Plots Sold</button>
                    <button type="button" onclick="setSoldPreset('10 Units Sold')" class="px-2.5 py-1 text-xs rounded-lg bg-gray-100 text-gray-700 hover:bg-red-50 hover:text-red-600 hover:border-red-200 border border-gray-200 transition-colors font-medium">10 Units Sold</button>
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="flex-1 px-4 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 font-semibold transition-all text-sm flex items-center justify-center gap-1.5">
                    <i class="bi bi-check-circle"></i> Save Sold Status
                </button>
                <button type="button" onclick="closeMarkSoldModal()" class="flex-1 px-4 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-semibold transition-all text-sm">
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

    function openMarkSoldModal(id, title, currentSoldInfo) {
        document.getElementById('markSoldPropertyId').value = id;
        document.getElementById('markSoldPropertyTitle').innerText = title;
        document.getElementById('soldInfoInput').value = currentSoldInfo || 'Sold Out';
        document.getElementById('markSoldModal').classList.remove('hidden');
    }

    function closeMarkSoldModal() {
        document.getElementById('markSoldModal').classList.add('hidden');
        document.getElementById('markSoldForm').reset();
    }

    function setSoldPreset(text) {
        document.getElementById('soldInfoInput').value = text;
    }

    document.getElementById('markSoldForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const form = e.target;
        const submitBtn = form.querySelector('button[type="submit"]');
        const propertyId = document.getElementById('markSoldPropertyId').value;
        const soldInfo = document.getElementById('soldInfoInput').value;

        showLoader(submitBtn);

        try {
            const data = await window.ajax(`{{ route("admin.properties.mark-sold", ":id") }}`.replace(':id', propertyId), 'POST', {
                sold_info: soldInfo
            });
            window.toast(data.message, 'success');
            closeMarkSoldModal();
            setTimeout(() => window.location.reload(), 1000);
        } catch (error) {
            hideLoader(submitBtn);
            window.toast(error.message || 'Failed to mark property as sold', 'error');
        }
    });

    async function markAsAvailable(id) {
        if (!confirm('Are you sure you want to mark this property as Available again?')) return;

        try {
            const data = await window.ajax(`{{ route("admin.properties.mark-available", ":id") }}`.replace(':id', id), 'POST');
            window.toast(data.message, 'success');
            setTimeout(() => window.location.reload(), 1000);
        } catch (error) {
            window.toast(error.message || 'Failed to mark property as available', 'error');
        }
    }

    async function approveProperty(id) {
        if (!confirm('Are you sure you want to approve this property?')) return;
        
        try {
            const data = await window.ajax(`{{ route("admin.properties.approve", ":id") }}`.replace(':id', id), 'POST');
            window.toast(data.message, 'success');
            setTimeout(() => window.location.reload(), 1000);
        } catch (error) {
            window.toast(error.message || 'Failed to approve property', 'error');
        }
    }

    function rejectProperty(id) {
        document.getElementById('rejectPropertyId').value = id;
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
            const propertyId = formData.get('property_id');
            const data = await window.ajax(`{{ route("admin.properties.reject", ":id") }}`.replace(':id', propertyId), 'POST', {
                rejection_reason: formData.get('rejection_reason'),
            });
            window.toast(data.message, 'success');
            closeRejectModal();
            setTimeout(() => window.location.reload(), 1000);
        } catch (error) {
            hideLoader(submitBtn);
            window.toast(error.message || 'Failed to reject property', 'error');
        }
    });

    async function toggleFeatured(id, currentStatus) {
        try {
            const data = await window.ajax(`{{ route("admin.properties.toggle-featured", ":id") }}`.replace(':id', id), 'POST');
            window.toast(data.message, 'success');
            setTimeout(() => window.location.reload(), 1000);
        } catch (error) {
            window.toast(error.message || 'Failed to update featured status', 'error');
        }
    }

    async function deleteProperty(id) {
        if (!confirm('Are you sure you want to delete this property? This action cannot be undone.')) return;
        
        try {
            const data = await window.ajax(`{{ route("admin.properties.delete", ":id") }}`.replace(':id', id), 'DELETE');
            window.toast(data.message, 'success');
            setTimeout(() => window.location.reload(), 1000);
        } catch (error) {
            window.toast(error.message || 'Failed to delete property', 'error');
        }
    }

    function openTagsModal(id, currentTags) {
        document.getElementById('tagsPropertyId').value = id;
        const tagsContainer = document.getElementById('tagsContainer');
        tagsContainer.innerHTML = '';
        
        const availableTags = ['featured', 'best_collection', 'new', 'trending', 'premium'];
        
        availableTags.forEach(tag => {
            const isChecked = currentTags && currentTags.includes(tag);
            const tagDiv = document.createElement('div');
            tagDiv.className = 'flex items-center gap-2';
            tagDiv.innerHTML = `
                <input type="checkbox" id="tag_${tag}" name="tags[]" value="${tag}" ${isChecked ? 'checked' : ''} 
                       class="w-4 h-4 rounded border-gray-300 text-orange-500 focus:ring-orange-500">
                <label for="tag_${tag}" class="text-sm text-gray-700 capitalize">${tag.replace('_', ' ')}</label>
            `;
            tagsContainer.appendChild(tagDiv);
        });
        
        document.getElementById('tagsModal').classList.remove('hidden');
    }

    function closeTagsModal() {
        document.getElementById('tagsModal').classList.add('hidden');
        document.getElementById('tagsForm').reset();
    }

    document.getElementById('tagsForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const form = e.target;
        const submitBtn = form.querySelector('button[type="submit"]');
        const formData = new FormData(form);
        
        const tags = [];
        formData.getAll('tags[]').forEach(tag => tags.push(tag));
        
        showLoader(submitBtn);
        
        try {
            const propertyId = formData.get('property_id');
            const data = await window.ajax(`{{ route("admin.properties.update-tags", ":id") }}`.replace(':id', propertyId), 'POST', {
                tags: tags,
            });
            window.toast(data.message, 'success');
            closeTagsModal();
            setTimeout(() => window.location.reload(), 1000);
        } catch (error) {
            hideLoader(submitBtn);
            window.toast(error.message || 'Failed to update tags', 'error');
        }
    });
</script>
@endpush

