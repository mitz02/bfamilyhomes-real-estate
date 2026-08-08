<div class="property-card group bg-white rounded-xl overflow-hidden border border-gray-200 hover:shadow-lg transition-all duration-300">

    <!-- Image Section -->
    <div class="relative overflow-hidden" style="height: 220px;">
        <a href="{{ route('properties.show', $property->id) }}" class="block w-full h-full">
            <img src="{{ $property->first_image }}"
                 alt="{{ $property->title }} - {{ $property->type === 'Sale' ? 'For Sale' : ($property->type === 'Rent' ? 'For Rent' : 'Investment') }} in {{ $property->location }}, Anambra"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                 loading="lazy"
                 onerror="this.src='https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=800'">
        </a>

        <!-- Image Count - Top Left -->
        @php $imgCount = is_array($property->images) ? count($property->images) : 0; @endphp
        <div class="absolute top-3 left-3 bg-black/50 backdrop-blur-sm rounded-full px-2.5 py-1.5 flex items-center gap-1.5 text-white text-xs font-medium z-10">
            <i class="bi bi-camera text-sm"></i>
            <span>{{ $imgCount }}</span>
        </div>

        <!-- Status badge top-right -->
        @if($property->isSold())
            <span class="absolute top-3 right-3 px-3 py-1 bg-red-600 text-white text-xs font-bold rounded-full shadow z-10 uppercase tracking-wide flex items-center gap-1">
                <i class="bi bi-tag-fill text-[10px]"></i>
                {{ $property->getSoldBadgeText() }}
            </span>
        @elseif($property->status === 'Rented')
            <span class="absolute top-3 right-3 px-3 py-1 bg-red-500 text-white text-xs font-bold rounded-full shadow z-10">Rented</span>
        @elseif($property->created_at->diffInDays() < 7)
            <span class="absolute top-3 right-3 px-3 py-1 bg-green-500 text-white text-xs font-bold rounded-full shadow z-10">New</span>
        @endif
    </div>

    <!-- Card Body -->
    <div class="p-4">

        <!-- Top Badge (Verified/Type) -->
        <div class="flex items-center gap-1.5 mb-2">
            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold"
                  style="background-color: #e8f0fe; color: #3b5bdb;">
                <i class="bi bi-patch-check-fill text-xs"></i>
                @if($property->type === 'Sale') For Sale
                @elseif($property->type === 'Rent') For Rent
                @else Investment
                @endif
            </span>
        </div>

        <!-- Title -->
        <h3 class="text-sm font-bold text-gray-900 mb-2 line-clamp-1">
            <a href="{{ route('properties.show', $property->id) }}" class="hover:text-orange-500 transition-colors">
                {{ $property->title }}
            </a>
        </h3>

        <!-- Feature Pills + Rating -->
        @php
            $pills = [];
            if (!$property->isSold() && $property->created_at->diffInDays() < 14) {
                $pills[] = ['kind' => 'plain', 'text' => 'New', 'title' => 'New'];
            }
            if ($property->bedrooms) {
                $pills[] = ['kind' => 'count', 'number' => $property->bedrooms, 'label' => 'Bed' . ($property->bedrooms > 1 ? 's' : ''), 'title' => $property->bedrooms . ' Bedrooms'];
            }
            if ($property->bathrooms) {
                $pills[] = ['kind' => 'count', 'number' => $property->bathrooms, 'label' => 'Bath' . ($property->bathrooms > 1 ? 's' : ''), 'title' => $property->bathrooms . ' Bathrooms'];
            }
            if ($property->size) {
                $pills[] = ['kind' => 'plain', 'text' => number_format($property->size) . ' sqft', 'title' => number_format($property->size) . ' sqft'];
            }
            if ($property->category) {
                $pills[] = ['kind' => 'plain', 'text' => $property->category, 'title' => $property->category];
            }
        @endphp
        <div class="flex items-center gap-1.5 flex-wrap mb-2.5">
            @foreach($pills as $index => $pill)
                @php
                    $pillClass = $pill['kind'] === 'count'
                        ? 'w-10 h-10 sm:w-auto sm:h-auto px-0 sm:px-3 sm:py-1 rounded-full flex flex-col sm:flex-row items-center justify-center gap-0 sm:gap-1 text-white bg-[#1e3a8a] shadow-xs shrink-0 font-semibold text-xs transition-all'
                        : 'h-10 sm:h-auto px-3 py-0 sm:py-1 rounded-full flex items-center justify-center text-white bg-[#1e3a8a] text-xs font-semibold whitespace-nowrap shrink-0 shadow-xs';
                @endphp
                <div class="{{ $pillClass }}{{ $index >= 3 ? ' hidden sm:flex' : '' }}" title="{{ $pill['title'] }}">
                    @if($pill['kind'] === 'count')
                        <span class="text-xs sm:text-xs font-extrabold sm:font-semibold leading-none sm:leading-normal">{{ $pill['number'] }}</span>
                        <span class="text-[9px] sm:text-xs font-semibold opacity-90 sm:opacity-100 leading-tight sm:leading-normal">{{ $pill['label'] }}</span>
                    @else
                        <span>{{ $pill['text'] }}</span>
                    @endif
                </div>
            @endforeach

            @if(count($pills) > 3)
                <div class="h-10 sm:hidden px-3 rounded-full flex items-center justify-center text-white bg-[#1e3a8a]/80 text-xs font-semibold whitespace-nowrap shrink-0 shadow-xs">
                    <span>...</span>
                </div>
            @endif

            <!-- Rating pushed to the right -->
            <div class="ml-auto h-10 sm:h-auto px-2.5 py-0 sm:py-1 rounded-full inline-flex items-center justify-center gap-1 text-xs font-bold bg-gray-100 text-gray-800 shrink-0">
                <i class="bi bi-star-fill text-yellow-400 text-xs"></i>
                <span>4.8</span>
            </div>
        </div>

        <!-- Price Row -->
        <div class="flex items-end justify-between mb-2.5 pb-2.5 border-b border-gray-100">
            <div>
                <p class="text-sm font-black text-gray-900">{{ $property->formatted_price }}</p>
                <p class="text-xs text-gray-500 mt-0.5 flex items-center gap-1">
                    <i class="bi bi-geo-alt text-orange-400"></i>
                    {{ $property->location }}
                </p>
            </div>
            @if($property->type === 'Rent')
            <div class="text-right">
                <p class="text-sm font-bold text-orange-500">{{ $property->formatted_price }}<span class="text-[10px] font-normal text-gray-500">/mo</span></p>
                <p class="text-[11px] text-gray-400 mt-0.5">Per Month</p>
            </div>
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-1.5">
            <a href="{{ route('contact') }}?property={{ $property->id }}"
               class="flex-1 flex items-center justify-center gap-1 py-2.5 text-xs font-bold text-gray-800 bg-white border-2 border-gray-800 rounded-lg hover:bg-gray-800 hover:text-white transition-all duration-200">
                Contact Agent
            </a>

            <a href="{{ route('properties.show', $property->id) }}"
               class="flex-1 flex items-center justify-center gap-1 py-2.5 text-xs font-bold text-white rounded-lg transition-all duration-200"
               style="background: linear-gradient(90deg, #f97316, #eab308);">
                View Property
            </a>
        </div>

    </div>
</div>
