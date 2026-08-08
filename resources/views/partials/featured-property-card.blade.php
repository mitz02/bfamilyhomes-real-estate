<div class="featured-property-card group bg-white rounded-[1.5rem] overflow-hidden border border-gray-100 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 flex-shrink-0 w-full max-w-sm mx-auto">
    <div class="relative aspect-[4/3] overflow-hidden">
        <a href="{{ route('properties.show', $property->id) }}" class="block w-full h-full">
            <img src="{{ $property->first_image }}" 
                 alt="{{ $property->title }}"
                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                 onerror="this.src='https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=800'">
            <!-- Gradient overlay for text readability -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-black/20"></div>
        </a>
        
        <!-- Top Badges -->
        <div class="absolute top-4 left-4 flex flex-col gap-2 z-10">
            @if($property->isSold())
                <span class="px-3 py-1 bg-red-600/95 backdrop-blur-sm text-white text-xs font-bold rounded-full shadow-sm uppercase tracking-wide flex items-center gap-1">
                    <i class="bi bi-tag-fill text-[10px]"></i>
                    {{ $property->getSoldBadgeText() }}
                </span>
            @elseif($property->type === 'Sale')
                <span class="px-3 py-1 bg-green-500/90 backdrop-blur-sm text-white text-xs font-bold rounded-full shadow-sm">For Sale</span>
            @elseif($property->type === 'Rent')
                <span class="px-3 py-1 bg-blue-500/90 backdrop-blur-sm text-white text-xs font-bold rounded-full shadow-sm">For Rent</span>
            @else
                <span class="px-3 py-1 bg-accent/90 backdrop-blur-sm text-gray-900 text-xs font-bold rounded-full shadow-sm">Investment</span>
            @endif
            
            @if($property->is_featured)
                <span class="px-3 py-1 bg-gray-900/90 backdrop-blur-sm text-white text-xs font-bold rounded-full shadow-sm">Featured</span>
            @endif
        </div>

        <!-- Action Icons - Top Right -->
        <div class="absolute top-4 right-4 flex flex-col gap-2 z-10">
            <button onclick="toggleWishlist({{ $property->id }}, this)" 
                    class="wishlist-btn w-9 h-9 bg-white/80 backdrop-blur-md hover:bg-white rounded-full flex items-center justify-center text-gray-700 hover:text-red-500 transition-all shadow-sm"
                    data-property-id="{{ $property->id }}">
                <i class="bi bi-heart wishlist-icon text-base"></i>
            </button>
            <button onclick="sharePropertyCard('{{ route('properties.show', $property->id) }}', '{{ addslashes($property->title) }}')" 
                    class="w-9 h-9 bg-white/80 backdrop-blur-md hover:bg-white rounded-full flex items-center justify-center text-gray-700 hover:text-primary-600 transition-all shadow-sm">
                <i class="bi bi-share text-base"></i>
            </button>
        </div>

        <!-- Price (Bottom of Image) -->
        <div class="absolute bottom-4 left-4 right-4 z-10">
            <h4 class="text-white font-bold text-2xl drop-shadow-md">
                {{ $property->formatted_price }}
                @if($property->type === 'Rent')
                    <span class="text-sm font-normal text-white/90">/mo</span>
                @endif
            </h4>
            <div class="flex items-center gap-1 text-white/90 text-sm mt-1">
                <i class="bi bi-geo-alt-fill text-accent"></i>
                <span class="truncate drop-shadow-sm">{{ $property->location }}</span>
            </div>
        </div>
    </div>

    <div class="p-5">
        <!-- Property Title -->
        <h3 class="text-lg font-bold text-gray-900 mb-4 line-clamp-1 group-hover:text-primary-600 transition-colors">
            <a href="{{ route('properties.show', $property->id) }}">
                {{ $property->title }}
            </a>
        </h3>

        <!-- Property Specifications -->
        @if($property->size || $property->bedrooms || $property->bathrooms || $property->parking)
        <div class="flex items-center gap-4 mb-4 pb-4 border-b border-gray-100 text-gray-600 text-sm font-medium">
            @if($property->bedrooms)
            <div class="flex items-center gap-1.5" title="Bedrooms">
                <i class="bi bi-house-door text-gray-400 text-base"></i>
                <span>{{ $property->bedrooms }}</span>
            </div>
            @endif

            @if($property->bathrooms)
            <div class="flex items-center gap-1.5" title="Bathrooms">
                <i class="bi bi-droplet text-gray-400 text-base"></i>
                <span>{{ $property->bathrooms }}</span>
            </div>
            @endif

            @if($property->parking)
            <div class="flex items-center gap-1.5" title="Parking">
                <i class="bi bi-car-front text-gray-400 text-base"></i>
                <span>{{ $property->parking }}</span>
            </div>
            @endif
        </div>
        @endif

        <!-- Agent Info & Date -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                @if($property->agent && $property->agent->avatar)
                    <img src="{{ asset('storage/' . $property->agent->avatar) }}" 
                         alt="{{ $property->agent->name }}"
                         class="w-8 h-8 rounded-full object-cover border-2 border-white shadow-sm">
                @elseif($property->agent)
                    <div class="w-8 h-8 bg-primary-100 text-primary-700 rounded-full flex items-center justify-center font-bold text-xs border-2 border-white shadow-sm">
                        {{ substr($property->agent->name, 0, 1) }}
                    </div>
                @endif
                <div class="min-w-0">
                    <p class="text-xs font-bold text-gray-900 truncate">{{ $property->agent->name ?? 'Agent' }}</p>
                    <div class="flex items-center gap-1 text-[10px] text-gray-500">
                        <i class="bi bi-calendar3"></i>
                        <span>{{ $property->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>
            <a href="{{ route('properties.show', $property->id) }}" class="w-8 h-8 bg-gray-900 hover:bg-gray-800 text-white rounded-full flex items-center justify-center transition-colors shadow-sm" title="View Details">
                <i class="bi bi-arrow-right text-sm"></i>
            </a>
        </div>
    </div>
</div>

