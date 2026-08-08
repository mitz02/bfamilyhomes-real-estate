@extends('layouts.app')

@section('title', 'Properties for Sale & Rent in Anambra | Enugu, Delta, Imo, Ebonyi, Abia, Nigeria | B-Family Homes')
@section('description', 'Browse premium properties for sale, rent, and investment in Anambra, Enugu, Delta, Imo, Ebonyi, Abia, Rivers, and across Nigeria. Find your dream home, land, commercial property, or investment opportunity with B-Family Homes — trusted real estate partner in South East Nigeria.')
@section('og:title', 'Properties for Sale, Rent & Investment in Anambra, Enugu, Delta, Imo, Abia, Nigeria')
@section('og:description', 'Browse verified premium properties across South East Nigeria and beyond. Houses for sale, apartments for rent, land, and investment opportunities in Anambra, Enugu, Delta, Imo, Abia, Ebonyi, Rivers, Lagos, and Abuja.')

@section('content')
<!-- Filters & Results -->
<section class="py-6 md:py-10 bg-gray-50">
    <div class="container mx-auto px-4" style="max-width: 95%;">
        <div class="flex flex-col lg:flex-row gap-6 lg:items-start">
            <!-- Main Content - Left Side -->
            <div class="properties-main lg:w-3/4">
                <!-- Header with Filter, Sort, View Toggle -->
                <div id="propertiesToolbar" class="bg-white rounded-xl shadow-sm p-3 md:p-4 mb-6 flex items-center justify-between gap-2 md:gap-3 border border-gray-100">
                    <!-- Filter + Sort -->
                    <div id="toolbarLeft" class="flex items-center gap-2 md:gap-3 min-w-0">
                        <!-- Filter Button -->
                        <button id="filterBtn" onclick="toggleFilterSidebar()" class="flex items-center gap-1.5 px-3 py-2 rounded-lg border-2 border-gray-200 hover:border-orange-500 transition-colors text-xs md:text-sm font-semibold text-gray-700 hover:text-orange-500 flex-shrink-0">
                            <i class="bi bi-funnel-fill text-orange-500"></i>
                            Filter
                            @if(request()->hasAny(['search', 'categories', 'min_price', 'max_price', 'type', 'posted_by']))
                                <span class="bg-orange-500 text-white text-[10px] px-1.5 py-0.5 rounded-full leading-none">{{ collect(request()->only(['categories', 'type', 'posted_by']))->flatten()->filter()->count() }}</span>
                            @endif
                        </button>

                        <!-- Sort Dropdown -->
                        <form id="sortForm" class="flex items-center gap-1.5 flex-shrink-0">
                            <label class="text-sm text-gray-600 font-medium hidden sm:inline">Sort:</label>
                            <select name="sort" class="border border-gray-300 rounded-lg px-2 py-2 text-xs md:text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none bg-white" onchange="this.form.submit()">
                                <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Latest</option>
                                <option value="price_low" {{ request('sort') === 'price_low' ? 'selected' : '' }}>Low Price</option>
                                <option value="price_high" {{ request('sort') === 'price_high' ? 'selected' : '' }}>High Price</option>
                            </select>
                        </form>
                    </div>

                    <!-- Count + View Toggle -->
                    <div id="toolbarRight" class="flex items-center gap-2 md:gap-3 flex-shrink-0">
                        <!-- Results count -->
                        <p class="text-xs md:text-sm text-gray-500 hidden sm:block">
                            <span class="font-bold text-orange-500">{{ $properties->firstItem() ?? 0 }}</span>-<span class="font-bold text-orange-500">{{ $properties->lastItem() ?? 0 }}</span> of <span class="font-bold text-orange-500">{{ $properties->total() }}</span>
                        </p>

                        <!-- View Toggle -->
                        <div id="viewToggle" class="flex items-center gap-1 bg-gray-100 rounded-lg p-1 flex-shrink-0">
                            <button id="listViewBtn" class="p-1.5 md:p-2 rounded-md hover:bg-white transition-colors" title="List View">
                                <i class="bi bi-list text-gray-600 text-lg"></i>
                            </button>
                            <button id="gridViewBtn" class="p-1.5 md:p-2 rounded-md hover:bg-white transition-colors bg-white shadow-sm" title="Grid View">
                                <i class="bi bi-grid text-orange-500 text-lg"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Properties Grid (Default) -->
                @if($properties->count() > 0)
                    <div id="propertiesGrid" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        @foreach($properties as $property)
                            @include('partials.property-card', ['property' => $property])
                        @endforeach
                    </div>

                    <!-- Properties List (Hidden by default) -->
                    <div id="propertiesList" class="hidden space-y-4">
                        @foreach($properties as $property)
                        <div class="bg-white rounded-xl overflow-hidden border border-gray-200 hover:shadow-lg hover:border-orange-200 transition-all duration-300 group">
                            <div class="flex flex-col md:flex-row">
                                <!-- Image -->
                                <div class="md:w-80 lg:w-96 relative flex-shrink-0 overflow-hidden bg-gray-100">
                                    <a href="{{ route('properties.show', $property->id) }}" class="block h-full min-h-[200px] md:min-h-[240px]">
                                        <img src="{{ $property->first_image ?? 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=800' }}"
                                             alt="{{ $property->title }}"
                                             loading="lazy"
                                             class="w-full h-full absolute inset-0 object-cover group-hover:scale-105 transition-transform duration-700"
                                             onerror="this.src='https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=800'">
                                    </a>
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent pointer-events-none"></div>
                                    <div class="absolute top-3 left-3 z-10">
                                        <span class="bg-gradient-to-r from-orange-500 to-yellow-500 text-white px-3 py-1.5 rounded-lg font-bold text-sm shadow-lg">
                                            {{ $property->formatted_price }}
                                        </span>
                                    </div>
                                    <div class="absolute top-3 right-3 z-10 flex gap-1.5">
                                        <div class="w-8 h-8 bg-black/50 backdrop-blur-sm rounded-lg flex items-center justify-center text-white text-xs gap-1">
                                            <i class="bi bi-camera text-sm"></i>
                                            <span>{{ is_array($property->images) ? count($property->images) : (is_string($property->images) ? count(json_decode($property->images, true) ?: []) : 0) }}</span>
                                        </div>
                                    </div>
                                    <div class="absolute bottom-3 left-3 z-10 flex-wrap gap-1.5 hidden md:flex">
                                        @if($property->type === 'Sale')
                                            <span class="bg-red-500 text-white text-[11px] px-2.5 py-0.5 rounded-md shadow font-semibold">For Sale</span>
                                        @elseif($property->type === 'Rent')
                                            <span class="bg-blue-500 text-white text-[11px] px-2.5 py-0.5 rounded-md shadow font-semibold">For Rent</span>
                                        @else
                                            <span class="bg-amber-400 text-gray-900 text-[11px] px-2.5 py-0.5 rounded-md shadow font-semibold">Investment</span>
                                        @endif
                                        @if($property->isSold())
                                            <span class="bg-red-600 text-white text-[11px] px-2.5 py-0.5 rounded-md shadow font-bold uppercase tracking-wide flex items-center gap-1">
                                                <i class="bi bi-tag-fill text-[9px]"></i>
                                                {{ $property->getSoldBadgeText() }}
                                            </span>
                                        @elseif($property->status === 'Rented')
                                            <span class="bg-red-500 text-white text-[11px] px-2.5 py-0.5 rounded-md shadow font-semibold">Rented</span>
                                        @elseif($property->created_at->diffInDays() < 7)
                                            <span class="bg-green-500 text-white text-[11px] px-2.5 py-0.5 rounded-md shadow font-semibold">New</span>
                                        @elseif($property->is_featured)
                                            <span class="bg-yellow-500 text-white text-[11px] px-2.5 py-0.5 rounded-md shadow font-semibold">Featured</span>
                                        @endif
                                    </div>
                                </div>
                                <!-- Details -->
                                <div class="flex-1 p-5 flex flex-col justify-between min-w-0">
                                    <div>
                                        <div class="flex items-center gap-2 mb-1.5">
                                            <span class="bg-orange-50 text-orange-700 text-[11px] font-semibold px-2 py-0.5 rounded-md">{{ $property->category }}</span>
                                            <span class="text-gray-400 text-[11px]">{{ $property->created_at->diffForHumans() }}</span>
                                            <span class="ml-auto md:hidden">
                                                @if($property->type === 'Sale')
                                                    <span class="bg-red-100 text-red-700 text-[11px] px-2 py-0.5 rounded-md font-semibold">For Sale</span>
                                                @elseif($property->type === 'Rent')
                                                    <span class="bg-blue-100 text-blue-700 text-[11px] px-2 py-0.5 rounded-md font-semibold">For Rent</span>
                                                @else
                                                    <span class="bg-amber-100 text-amber-800 text-[11px] px-2 py-0.5 rounded-md font-semibold">Investment</span>
                                                @endif
                                            </span>
                                        </div>
                                        <h3 class="text-base md:text-lg font-bold text-gray-900 mb-1 line-clamp-1">
                                            <a href="{{ route('properties.show', $property->id) }}" class="hover:text-orange-500 transition-colors">{{ $property->title }}</a>
                                        </h3>
                                        <p class="text-sm text-gray-500 flex items-center gap-1 mb-2">
                                            <i class="bi bi-geo-alt-fill text-orange-400 text-xs"></i>
                                            {{ $property->location }}, Anambra
                                        </p>
                                        @if($property->description)
                                        <p class="text-xs text-gray-400 line-clamp-1 mb-3">{{ strip_tags($property->description) }}</p>
                                        @endif
                                        <div class="flex flex-wrap gap-3">
                                            @if($property->bedrooms)
                                            <div class="flex items-center gap-1.5 px-3 py-1.5 bg-gray-50 rounded-lg">
                                                <i class="bi bi-house-door text-blue-500 text-xs"></i>
                                                <span class="text-xs font-medium text-gray-700">{{ $property->bedrooms }} Beds</span>
                                            </div>
                                            @endif
                                            @if($property->bathrooms)
                                            <div class="flex items-center gap-1.5 px-3 py-1.5 bg-gray-50 rounded-lg">
                                                <i class="bi bi-droplet text-emerald-500 text-xs"></i>
                                                <span class="text-xs font-medium text-gray-700">{{ $property->bathrooms }} Baths</span>
                                            </div>
                                            @endif
                                            @if($property->size)
                                            <div class="flex items-center gap-1.5 px-3 py-1.5 bg-gray-50 rounded-lg">
                                                <i class="bi bi-arrows-angle-expand text-orange-500 text-xs"></i>
                                                <span class="text-xs font-medium text-gray-700">{{ number_format($property->size) }} sqft</span>
                                            </div>
                                            @endif
                                            @if($property->parking)
                                            <div class="flex items-center gap-1.5 px-3 py-1.5 bg-gray-50 rounded-lg">
                                                <i class="bi bi-car-front text-purple-500 text-xs"></i>
                                                <span class="text-xs font-medium text-gray-700">{{ $property->parking }} Park</span>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between pt-3 mt-3 border-t border-gray-100">
                                        <div class="flex items-center gap-2.5">
                                            @if($property->agent->avatar)
                                                <img src="{{ asset('storage/' . $property->agent->avatar) }}" alt="{{ $property->agent->name }}" class="w-8 h-8 rounded-full object-cover border-2 border-orange-200">
                                            @else
                                                <div class="w-8 h-8 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-full flex items-center justify-center text-white text-xs font-bold shadow">{{ substr($property->agent->name, 0, 1) }}</div>
                                            @endif
                                            <div>
                                                <p class="text-xs font-semibold text-gray-900 leading-tight">{{ $property->agent->name }}</p>
                                                <p class="text-[10px] text-gray-400">{{ $property->agent->isAgent() ? 'Verified Agent' : 'Property Owner' }}</p>
                                            </div>
                                        </div>
                                        <a href="{{ route('properties.show', $property->id) }}" class="inline-flex items-center gap-1.5 bg-gradient-to-r from-orange-500 to-yellow-500 hover:from-orange-600 hover:to-yellow-600 text-white text-sm font-semibold px-5 py-2 rounded-lg transition-all shadow-md hover:shadow-lg">
                                            View Details
                                            <i class="bi bi-arrow-right text-xs"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8 flex justify-center">
                        {{ $properties->links() }}
                    </div>
                @else
                    <div class="bg-white rounded-xl p-12 text-center border-2 border-dashed border-gray-200">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-5">
                            <i class="bi bi-search text-3xl text-gray-400"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">No Properties Found</h3>
                        <p class="text-gray-500 mb-6 max-w-md mx-auto text-sm">We couldn't find any properties matching your criteria. Try adjusting your filters or search terms.</p>
                        <a href="{{ route('properties.index') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-orange-500 to-yellow-500 hover:from-orange-600 hover:to-yellow-600 text-white font-semibold px-6 py-2.5 rounded-lg transition-all shadow-md">
                            <i class="bi bi-arrow-counterclockwise"></i>
                            Clear All Filters
                        </a>
                    </div>
                @endif
            </div>

            <!-- Sidebar Filters - Right Side -->
            <div id="filterSidebar" class="lg:w-1/4 fixed lg:fixed inset-0 lg:inset-auto z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
                <div onclick="toggleFilterSidebar()" class="lg:hidden fixed inset-0 bg-black/50 z-40"></div>
                
                <div id="filterSidebarInner" class="relative bg-white rounded-xl p-4 md:p-6 shadow-lg border border-gray-100 z-50 max-h-full overflow-y-auto lg:max-h-none lg:overflow-visible">
                    <div class="lg:hidden flex items-center justify-between mb-6 pb-4 border-b border-gray-200 sticky top-0 bg-white z-10">
                        <h3 class="text-lg font-bold text-gray-900">Filter Properties</h3>
                        <button onclick="toggleFilterSidebar()" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                            <i class="bi bi-x-lg text-gray-600 text-lg"></i>
                        </button>
                    </div>
                    
                    <div class="hidden lg:flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-900">Filter Properties</h3>
                        <i class="bi bi-funnel-fill text-orange-500 text-lg"></i>
                    </div>
                    
                    <form id="filterForm" method="GET" action="{{ route('properties.index') }}" class="space-y-5">
                        <!-- Search -->
                        <div>
                            <label class="text-sm font-semibold text-gray-700 mb-1.5 block">Search</label>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Search properties..." 
                                   class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none">
                        </div>

                        <!-- Categories -->
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 mb-2">Categories</h4>
                            <div class="space-y-1.5 max-h-48 overflow-y-auto">
                                @php
                                    $categories = config('bfamily.property.categories', ['Land', '1 Bedroom', '2 Bedroom', '3 Bedroom', 'Duplex', 'Commercial']);
                                    $categoryCounts = [];
                                    foreach($categories as $cat) {
                                        $categoryCounts[$cat] = \App\Models\Property::approved()->available()->where('category', $cat)->count();
                                    }
                                @endphp
                                @foreach($categories as $category)
                                <label class="flex items-center justify-between cursor-pointer hover:bg-orange-50 p-2 rounded-lg transition-colors">
                                    <div class="flex items-center gap-2">
                                        <input type="checkbox" name="categories[]" value="{{ $category }}" 
                                               {{ in_array($category, (array)request('categories', [])) ? 'checked' : '' }}
                                               class="rounded text-orange-500 focus:ring-orange-500">
                                        <span class="text-sm text-gray-700">{{ $category }}</span>
                                    </div>
                                    <span class="text-xs text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full">{{ $categoryCounts[$category] ?? 0 }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Price Range -->
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 mb-2">Price Range (₦)</h4>
                            <div class="flex items-center gap-2 mb-2">
                                <input type="number" name="min_price" value="{{ request('min_price', 5000) }}" 
                                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none" placeholder="Min">
                                <span class="text-gray-400">-</span>
                                <input type="number" name="max_price" value="{{ request('max_price', 50000000) }}" 
                                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none" placeholder="Max">
                            </div>
                        </div>

                        <!-- Property Type -->
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 mb-2">Property Type</h4>
                            <div class="space-y-1.5">
                                @php
                                    $types = config('bfamily.property.types', ['Rent', 'Sale', 'Investment']);
                                    $typeLabels = ['Rent' => 'For Rent', 'Sale' => 'For Sale', 'Investment' => 'Investment'];
                                    $typeCounts = [];
                                    foreach($types as $type) {
                                        $typeCounts[$type] = \App\Models\Property::approved()->available()->where('type', $type)->count();
                                    }
                                @endphp
                                @foreach($types as $type)
                                <label class="flex items-center justify-between cursor-pointer hover:bg-orange-50 p-2 rounded-lg transition-colors">
                                    <div class="flex items-center gap-2">
                                        <input type="checkbox" name="type[]" value="{{ $type }}" 
                                               {{ in_array($type, (array)request('type', [])) ? 'checked' : '' }}
                                               class="rounded text-orange-500 focus:ring-orange-500">
                                        <span class="text-sm text-gray-700">{{ $typeLabels[$type] ?? $type }}</span>
                                    </div>
                                    <span class="text-xs text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full">{{ $typeCounts[$type] ?? 0 }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-gradient-to-r from-orange-500 to-yellow-500 hover:from-orange-600 hover:to-yellow-600 text-white font-semibold py-2.5 px-4 rounded-lg transition-all shadow-md flex items-center justify-center gap-2 text-sm">
                            <i class="bi bi-funnel"></i>
                            Apply Filters
                        </button>

                        <a href="{{ route('properties.index') }}" class="w-full block text-center border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold py-2.5 px-4 rounded-lg transition-all text-sm">
                            <i class="bi bi-x-circle"></i>
                            Clear Filters
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Mobile Filter Sidebar Toggle
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

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(e) {
        const sidebar = document.getElementById('filterSidebar');
        const toggleBtn = e.target.closest('[onclick="toggleFilterSidebar()"]');
        
        if (window.innerWidth < 1024 && !sidebar.contains(e.target) && !toggleBtn && !sidebar.classList.contains('-translate-x-full')) {
            toggleFilterSidebar();
        }
    });

    // View Toggle
    document.getElementById('listViewBtn')?.addEventListener('click', function() {
        document.getElementById('propertiesGrid').classList.add('hidden');
        document.getElementById('propertiesList').classList.remove('hidden');
        this.classList.add('bg-white', 'shadow-sm');
        this.querySelector('i').classList.add('text-orange-500');
        document.getElementById('gridViewBtn').classList.remove('bg-white', 'shadow-sm');
        document.getElementById('gridViewBtn').querySelector('i').classList.remove('text-orange-500');
        document.getElementById('gridViewBtn').querySelector('i').classList.add('text-gray-600');
    });

    document.getElementById('gridViewBtn')?.addEventListener('click', function() {
        document.getElementById('propertiesList').classList.add('hidden');
        document.getElementById('propertiesGrid').classList.remove('hidden');
        this.classList.add('bg-white', 'shadow-sm');
        this.querySelector('i').classList.add('text-orange-500');
        document.getElementById('listViewBtn').classList.remove('bg-white', 'shadow-sm');
        document.getElementById('listViewBtn').querySelector('i').classList.remove('text-orange-500');
        document.getElementById('listViewBtn').querySelector('i').classList.add('text-gray-600');
    });

    // Close mobile sidebar on form submit
    document.getElementById('filterForm')?.addEventListener('submit', function() {
        if (window.innerWidth < 1024) {
            setTimeout(() => toggleFilterSidebar(), 100);
        }
    });

    // Price Range Sliders
    function updateMinPrice(value) {
        const minInput = document.querySelector('input[name="min_price"]');
        const maxInput = document.querySelector('input[name="max_price"]');
        const maxValue = parseInt(maxInput.value) || 50000000;
        
        if (parseInt(value) > maxValue) {
            value = maxValue;
        }
        
        minInput.value = value;
        document.getElementById('minPriceDisplay').textContent = '₦' + parseInt(value).toLocaleString();
    }

    function updateMaxPrice(value) {
        const minInput = document.querySelector('input[name="min_price"]');
        const maxInput = document.querySelector('input[name="max_price"]');
        const minValue = parseInt(minInput.value) || 5000;
        
        if (parseInt(value) < minValue) {
            value = minValue;
        }
        
        maxInput.value = value;
        document.getElementById('maxPriceDisplay').textContent = '₦' + parseInt(value).toLocaleString();
    }

    // Update sliders when input values change
    document.querySelector('input[name="min_price"]')?.addEventListener('input', function() {
        const value = parseInt(this.value) || 5000;
        const maxValue = parseInt(document.querySelector('input[name="max_price"]').value) || 50000000;
        
        if (value > maxValue) {
            this.value = maxValue;
        }
        
        document.getElementById('minPriceRange').value = this.value;
        document.getElementById('minPriceDisplay').textContent = '₦' + parseInt(this.value).toLocaleString();
    });

    document.querySelector('input[name="max_price"]')?.addEventListener('input', function() {
        const value = parseInt(this.value) || 50000000;
        const minValue = parseInt(document.querySelector('input[name="min_price"]').value) || 5000;
        
        if (value < minValue) {
            this.value = minValue;
        }
        
        document.getElementById('maxPriceRange').value = this.value;
        document.getElementById('maxPriceDisplay').textContent = '₦' + parseInt(this.value).toLocaleString();
    });
</script>
<style>
    /* Force the properties toolbar into a single straight row on ALL screen sizes */
    #propertiesToolbar {
        display: flex !important;
        flex-direction: row !important;
        flex-wrap: nowrap !important;
        align-items: center !important;
        justify-content: space-between !important;
        gap: 8px !important;
        width: 100% !important;
        box-sizing: border-box !important;
    }
    #toolbarLeft,
    #toolbarRight {
        display: flex !important;
        flex-direction: row !important;
        flex-wrap: nowrap !important;
        align-items: center !important;
        gap: 8px !important;
        min-width: 0 !important;
        flex: 0 1 auto !important;
    }
    #toolbarLeft > *,
    #toolbarRight > * {
        flex: 0 0 auto !important;
        white-space: nowrap !important;
    }
    #filterBtn {
        display: inline-flex !important;
        align-items: center !important;
        height: 40px !important;
        box-sizing: border-box !important;
        margin: 0 !important;
    }
    #sortForm {
        display: inline-flex !important;
        align-items: center !important;
        gap: 6px !important;
        margin: 0 !important;
    }
    #sortForm select {
        height: 40px !important;
        width: auto !important;
        min-width: 96px !important;
        max-width: 130px !important;
        flex: 0 0 auto !important;
        padding: 0 6px !important;
        line-height: 40px !important;
        box-sizing: border-box !important;
        appearance: auto !important;
        vertical-align: middle !important;
    }
    #viewToggle {
        display: inline-flex !important;
        flex: 0 0 auto !important;
        height: 40px !important;
        align-items: center !important;
        padding: 4px !important;
        box-sizing: border-box !important;
    }
    #viewToggle button {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        height: 30px !important;
        width: 34px !important;
        flex: 0 0 auto !important;
        padding: 0 !important;
        margin: 0 !important;
        box-sizing: border-box !important;
        line-height: 1 !important;
    }
    @media (min-width: 1024px) {
        #filterSidebar {
            position: sticky !important;
            top: 95px !important;
            transform: none !important;
            align-self: flex-start;
        }
    }
</style>
@endpush
