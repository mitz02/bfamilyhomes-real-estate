@extends('layouts.app')

@section('title', $property->title . ' - ' . $property->location . ', Anambra | B-Family Homes')
@section('description', 'View ' . $property->title . ' in ' . $property->location . ', Anambra State, Nigeria. ' . ($property->type === 'Sale' ? 'For Sale' : ($property->type === 'Rent' ? 'For Rent' : 'Investment Opportunity')) . ' - ' . $property->formatted_price . '. Contact B-Family Homes for more details.')
@section('og:title', $property->title . ' - ' . $property->location . ', Anambra | B-Family Homes')
@section('og:description', ($property->type === 'Sale' ? 'For Sale' : ($property->type === 'Rent' ? 'For Rent' : 'Investment Opportunity')) . ': ' . $property->title . ' in ' . $property->location . ', Anambra. ' . $property->formatted_price . '. Contact B-Family Homes.')

@push('schemas')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
        {"@type": "ListItem", "position": 1, "name": "Home", "item": "{{ route('home') }}"},
        {"@type": "ListItem", "position": 2, "name": "Properties", "item": "{{ route('properties.index') }}"},
        {"@type": "ListItem", "position": 3, "name": "{{ $property->title }}", "item": "{{ url()->current() }}"}
    ]
}
</script>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Product",
    "name": "{{ $property->title }}",
    "description": "{{ strip_tags($property->description) }}",
    "image": "{{ !empty($images) && isset($images[0]) ? (str_starts_with($images[0], 'http') ? $images[0] : asset('storage/' . ltrim($images[0], '/'))) : asset('images/logo.png') }}",
    "url": "{{ url()->current() }}",
    "category": "{{ $property->category }}",
    "offers": {
        "@type": "Offer",
        "price": "{{ $property->price }}",
        "priceCurrency": "NGN",
        "availability": "{{ $property->status === 'Available' ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock' }}",
        "url": "{{ url()->current() }}",
        "seller": {
            "@type": "RealEstateAgent",
            "name": "B-Family Homes Limited",
            "telephone": "+2348164856758"
        }
    },
    @if($property->bedrooms || $property->bathrooms || $property->size)
    "additionalProperty": [
        @if($property->bedrooms){"@type": "PropertyValue", "name": "Bedrooms", "value": "{{ $property->bedrooms }}"},@endif
        @if($property->bathrooms){"@type": "PropertyValue", "name": "Bathrooms", "value": "{{ $property->bathrooms }}"},@endif
        @if($property->size){"@type": "PropertyValue", "name": "Size", "value": "{{ $property->size }} sqft"}@endif
    ],
    @endif
    "areaServed": "{{ $property->location }}, Anambra State, Nigeria",
    "brand": {
        "@type": "Brand",
        "name": "B-Family Homes Limited"
    }
}
</script>
@endpush

@section('content')
<section class="py-4 md:py-8 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4" style="max-width: 1400px;">
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-sm text-gray-400 mb-4">
            <a href="{{ route('home') }}" class="hover:text-primary-600 transition-colors">Home</a>
            <i class="bi bi-chevron-right text-[10px]"></i>
            <a href="{{ route('properties.index') }}" class="hover:text-primary-600 transition-colors">Properties</a>
            <i class="bi bi-chevron-right text-[10px]"></i>
            <span class="text-gray-700 font-medium truncate">{{ $property->title }}</span>
        </nav>

        @if(auth()->check() && auth()->user()->isAdmin() && $property->approval_status !== 'approved')
        <div class="mb-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
            <div class="flex items-start gap-2">
                <i class="bi bi-exclamation-triangle-fill text-yellow-600 text-base mt-0.5"></i>
                <div>
                    <h3 class="font-bold text-yellow-900 text-xs">Property Pending Approval</h3>
                    <p class="text-xs text-yellow-700 mt-0.5">This property is not yet approved. Only admins can view it.</p>
                    @if($property->approval_status === 'rejected' && $property->rejection_reason)
                    <p class="text-xs text-red-600 mt-1"><strong>Rejection Reason:</strong> {{ $property->rejection_reason }}</p>
                    @endif
                </div>
            </div>
        </div>
        @endif

        @php
            $images = is_array($property->images) ? $property->images : (is_string($property->images) ? json_decode($property->images, true) : []);
            if (empty($images) && $property->first_image) {
                $images = [$property->first_image];
            }
            $imageCount = count($images);
        @endphp

        @php $hasDetails = $property->bedrooms || $property->bathrooms || $property->parking || $property->size; @endphp

        <!-- Main Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left -->
            <div class="lg:col-span-2 space-y-4">

                <!-- Card Hero / Slider -->
                <div class="bg-white rounded-xl overflow-hidden border border-gray-200">
                    <!-- Image Section -->
                    <div class="relative overflow-hidden" style="height: 340px;" id="propertyHero">
                        <div class="w-full h-full flex transition-transform duration-500 ease-in-out" id="sliderTrack">
                            @forelse($images as $index => $image)
                            @php
                                if (is_string($image)) {
                                    if (str_starts_with($image, 'http') || str_starts_with($image, '/')) {
                                        $imageUrl = $image;
                                    } else {
                                        $imageUrl = asset('storage/' . ltrim($image, '/'));
                                    }
                                } else {
                                    $imageUrl = asset('storage/' . ltrim($image, '/'));
                                }
                            @endphp
                            <div class="w-full h-full flex-shrink-0 slider-slide">
                                <img src="{{ $imageUrl }}"
                                     alt="{{ $property->title }} - Photo {{ $index + 1 }}"
                                     class="w-full h-full object-cover cursor-pointer slider-img"
                                     {{ $loop->first ? 'fetchpriority=high' : 'loading=lazy' }}
                                     data-full-image="{{ $imageUrl }}"
                                     onclick="openImageModal(this)"
                                     onerror="this.src='https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=1200'">
                            </div>
                            @empty
                            <div class="w-full h-full flex-shrink-0">
                                <img src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=1200"
                                     alt="{{ $property->title }}"
                                     class="w-full h-full object-cover">
                            </div>
                            @endforelse
                        </div>

                        <!-- Gradient overlay at bottom -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent pointer-events-none"></div>

                        <!-- Slider controls -->
                        @if($imageCount > 1)
                        <button onclick="prevSlide()" class="absolute left-3 top-1/2 -translate-y-1/2 w-9 h-9 bg-white/90 hover:bg-white rounded-full flex items-center justify-center shadow transition-all z-10">
                            <i class="bi bi-chevron-left text-gray-800 text-sm"></i>
                        </button>
                        <button onclick="nextSlide()" class="absolute right-3 top-1/2 -translate-y-1/2 w-9 h-9 bg-white/90 hover:bg-white rounded-full flex items-center justify-center shadow transition-all z-10">
                            <i class="bi bi-chevron-right text-gray-800 text-sm"></i>
                        </button>
                        @endif

                        <!-- Image Count Badge -->
                        <div class="absolute top-3 left-3 bg-black/50 backdrop-blur-sm rounded-full px-2.5 py-1.5 flex items-center gap-1.5 text-white text-xs font-medium z-10">
                            <i class="bi bi-camera-fill text-sm"></i>
                            <span id="currentImageIndex">1</span>/<span>{{ $imageCount }}</span>
                        </div>

                        <!-- Status badge -->
                        @if($property->isSold())
                            <span class="absolute top-3 right-3 px-3.5 py-1 bg-red-600 text-white text-xs font-bold rounded-full z-10 shadow uppercase tracking-wide flex items-center gap-1">
                                <i class="bi bi-tag-fill text-[10px]"></i>
                                {{ $property->getSoldBadgeText() }}
                            </span>
                        @elseif($property->status === 'Rented')
                            <span class="absolute top-3 right-3 px-3 py-1 bg-red-500 text-white text-xs font-bold rounded-full z-10">Rented</span>
                        @elseif($property->created_at->diffInDays() < 7)
                            <span class="absolute top-3 right-3 px-3 py-1 bg-green-500 text-white text-xs font-bold rounded-full z-10">New</span>
                        @endif

                        <!-- Price badge -->
                        <div class="absolute bottom-16 left-4">
                            <div class="bg-white/95 backdrop-blur-sm px-3 py-1.5 rounded-lg">
                                <p class="text-primary-600 font-bold text-lg md:text-xl">
                                    {{ $property->formatted_price }}
                                    @if($property->type === 'Rent')
                                        <span class="text-sm font-normal text-gray-400">/month</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <!-- Type badge -->
                        <div class="absolute bottom-16 right-4">
                            @if($property->type === 'Sale')
                            <span class="bg-red-500 text-white px-3 py-1 rounded-lg font-semibold text-xs flex items-center gap-1">
                                <i class="bi bi-tag-fill"></i> For Sale
                            </span>
                            @elseif($property->type === 'Rent')
                            <span class="bg-blue-500 text-white px-3 py-1 rounded-lg font-semibold text-xs flex items-center gap-1">
                                <i class="bi bi-calendar-check"></i> For Rent
                            </span>
                            @else
                            <span class="bg-yellow-500 text-gray-900 px-3 py-1 rounded-lg font-semibold text-xs flex items-center gap-1">
                                <i class="bi bi-graph-up-arrow"></i> Investment
                            </span>
                            @endif
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-4 md:p-5">
                        <!-- Top Badge -->
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

                        <h1 class="text-xl md:text-2xl font-bold text-gray-900 mb-2">{{ $property->title }}</h1>

                        <!-- Feature Pills -->
                        <div class="flex items-center gap-2 flex-wrap mb-3">
                            @if(!$property->isSold() && $property->created_at->diffInDays() < 14)
                                <span class="px-3 py-1 rounded-full text-xs font-semibold text-white" style="background-color: #1e3a8a;">New</span>
                            @endif
                            @if($property->bedrooms)
                                <span class="px-3 py-1 rounded-full text-xs font-semibold text-white" style="background-color: #1e3a8a;">{{ $property->bedrooms }} Bed{{ $property->bedrooms > 1 ? 's' : '' }}</span>
                            @endif
                            @if($property->bathrooms)
                                <span class="px-3 py-1 rounded-full text-xs font-semibold text-white" style="background-color: #1e3a8a;">{{ $property->bathrooms }} Bath{{ $property->bathrooms > 1 ? 's' : '' }}</span>
                            @endif
                            @if($property->size)
                                <span class="px-3 py-1 rounded-full text-xs font-semibold text-white" style="background-color: #1e3a8a;">{{ number_format($property->size) }} sqft</span>
                            @endif
                            @if($property->category)
                                <span class="px-3 py-1 rounded-full text-xs font-semibold text-white" style="background-color: #1e3a8a;">{{ $property->category }}</span>
                            @endif
                            <span class="ml-auto inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-700">
                                <i class="bi bi-star-fill text-yellow-400 text-xs"></i>
                                4.8
                            </span>
                        </div>

                        <!-- Location & Meta Row -->
                        <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-gray-500 pb-3 border-b border-gray-100">
                            <span class="flex items-center gap-1"><i class="bi bi-geo-alt-fill text-orange-400"></i> {{ $property->location }}</span>
                            <span class="flex items-center gap-1"><i class="bi bi-clock-fill"></i> {{ $property->created_at->diffForHumans() }}</span>
                            <span class="flex items-center gap-1"><i class="bi bi-eye-fill"></i> {{ number_format($property->views) }} views</span>
                        </div>
                    </div>
                </div>

                <!-- Image Thumbnails -->
                @if($imageCount > 1)
                <div class="bg-white rounded-lg border border-gray-200 p-3">
                    <div class="flex gap-2 overflow-x-auto pb-1 scrollbar-hide" id="imageGallery">
                        @foreach($images as $index => $image)
                        @php
                            if (is_string($image)) {
                                if (str_starts_with($image, 'http') || str_starts_with($image, '/')) {
                                    $imageUrl = $image;
                                } else {
                                    $imageUrl = asset('storage/' . ltrim($image, '/'));
                                }
                            } else {
                                $imageUrl = asset('storage/' . ltrim($image, '/'));
                            }
                        @endphp
                        <div class="flex-shrink-0 cursor-pointer" onclick="goToSlide({{ $index }})">
                            <img src="{{ $imageUrl }}"
                                 alt="{{ $property->title }} - Photo {{ $index + 1 }}"
                                 class="w-16 h-16 md:w-20 md:h-20 object-cover rounded-lg border-2 border-transparent hover:border-primary-500 transition-all gallery-thumb shadow-sm {{ $index === 0 ? 'active border-primary-500' : '' }}"
                                 loading="lazy"
                                 data-index="{{ $index }}"
                                 onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=200';">
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Description -->
                <div class="bg-white rounded-lg border border-gray-200 p-5">
                    <h2 class="text-lg font-bold text-gray-900 mb-3 flex items-center gap-2">
                        <i class="bi bi-file-earmark-text-fill text-primary-600"></i>
                        About This Property
                    </h2>
                    <p class="text-gray-600 leading-relaxed whitespace-pre-line text-sm md:text-base">{{ $property->description }}</p>
                </div>

                <!-- Details -->
                @if($hasDetails)
                <div class="bg-white rounded-lg border border-gray-200 p-5">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="bi bi-info-circle-fill text-primary-600"></i>
                        Property Details
                    </h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        @if($property->bedrooms)
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100/40 rounded-lg p-3 text-center border border-blue-100">
                            <div class="w-9 h-9 bg-blue-500 rounded-lg flex items-center justify-center mx-auto mb-2">
                                <i class="bi bi-door-open-fill text-white text-sm"></i>
                            </div>
                            <p class="text-gray-500 text-xs mb-0.5 font-medium">Bedrooms</p>
                            <p class="font-bold text-gray-900 text-xl">{{ $property->bedrooms }}</p>
                        </div>
                        @endif
                        @if($property->bathrooms)
                        <div class="bg-gradient-to-br from-emerald-50 to-emerald-100/40 rounded-lg p-3 text-center border border-emerald-100">
                            <div class="w-9 h-9 bg-emerald-500 rounded-lg flex items-center justify-center mx-auto mb-2">
                                <i class="bi bi-droplet-fill text-white text-sm"></i>
                            </div>
                            <p class="text-gray-500 text-xs mb-0.5 font-medium">Bathrooms</p>
                            <p class="font-bold text-gray-900 text-xl">{{ $property->bathrooms }}</p>
                        </div>
                        @endif
                        @if($property->parking)
                        <div class="bg-gradient-to-br from-violet-50 to-violet-100/40 rounded-lg p-3 text-center border border-violet-100">
                            <div class="w-9 h-9 bg-violet-500 rounded-lg flex items-center justify-center mx-auto mb-2">
                                <i class="bi bi-car-front-fill text-white text-sm"></i>
                            </div>
                            <p class="text-gray-500 text-xs mb-0.5 font-medium">Parking</p>
                            <p class="font-bold text-gray-900 text-xl">{{ $property->parking }}</p>
                            <p class="text-[11px] text-gray-400">Spaces</p>
                        </div>
                        @endif
                        @if($property->size)
                        <div class="bg-gradient-to-br from-orange-50 to-orange-100/40 rounded-lg p-3 text-center border border-orange-100">
                            <div class="w-9 h-9 bg-orange-500 rounded-lg flex items-center justify-center mx-auto mb-2">
                                <i class="bi bi-aspect-ratio-fill text-white text-sm"></i>
                            </div>
                            <p class="text-gray-500 text-xs mb-0.5 font-medium">Size</p>
                            <p class="font-bold text-gray-900 text-lg">{{ number_format($property->size) }}</p>
                            <p class="text-[11px] text-gray-400">Sq ft</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Features -->
                @php
                    $features = is_array($property->features) ? $property->features : (is_string($property->features) ? json_decode($property->features, true) : []);
                @endphp
                @if(!empty($features) && count($features) > 0)
                <div class="bg-white rounded-lg border border-gray-200 p-5">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="bi bi-award-fill text-primary-600"></i>
                        Features & Amenities
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                        @foreach($features as $feature)
                        <div class="flex items-center gap-2 p-2.5 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="w-7 h-7 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="bi bi-check-circle-fill text-green-600 text-xs"></i>
                            </div>
                            <span class="text-gray-700 text-sm font-medium">{{ $feature }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Location -->
                <div class="bg-white rounded-lg border border-gray-200 p-5">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="bi bi-geo-alt-fill text-primary-600"></i>
                        Location & Tags
                    </h2>
                    <div class="flex items-start gap-3 mb-4">
                        <div class="w-9 h-9 bg-primary-50 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i class="bi bi-geo-alt text-primary-600 text-base"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900 mb-0.5">Address</p>
                            <p class="text-gray-500 text-sm">{{ $property->address }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-1.5">
                        <span class="bg-primary-100 text-primary-700 px-2.5 py-1 rounded-lg text-xs font-semibold">{{ $property->category }}</span>
                        <span class="bg-blue-100 text-blue-700 px-2.5 py-1 rounded-lg text-xs font-semibold">{{ $property->type }}</span>
                        @if($property->bedrooms)
                        <span class="bg-green-100 text-green-700 px-2.5 py-1 rounded-lg text-xs font-semibold">{{ $property->bedrooms }} Bedroom</span>
                        @endif
                        @if($property->status === 'Available')
                        <span class="bg-emerald-100 text-emerald-700 px-2.5 py-1 rounded-lg text-xs font-semibold flex items-center gap-1">
                            <i class="bi bi-check-circle"></i> Available
                        </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-4">
                <div class="lg:sticky lg:top-4 space-y-4">
                    <!-- Agent -->
                    <div class="bg-white rounded-lg border border-gray-200 p-5">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="relative flex-shrink-0">
                                @if($property->agent->avatar)
                                <img src="{{ asset('storage/' . $property->agent->avatar) }}"
                                     alt="{{ $property->agent->name }}"
                                     class="w-14 h-14 rounded-lg object-cover">
                                @else
                                <div class="w-14 h-14 bg-gradient-to-br from-primary-500 to-primary-600 rounded-lg flex items-center justify-center text-white text-xl font-bold">
                                    {{ substr($property->agent->name, 0, 1) }}
                                </div>
                                @endif
                                <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-white flex items-center justify-center">
                                    <i class="bi bi-check text-white text-[8px]"></i>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-gray-900 text-sm truncate">{{ $property->agent->name }}</h4>
                                <p class="text-xs text-gray-500">Real Estate Agent</p>
                                <p class="text-[10px] text-gray-400 mt-0.5">
                                    <i class="bi bi-calendar3-fill"></i>
                                    Since {{ $property->agent->created_at->format('Y') }}
                                </p>
                            </div>
                        </div>
                        <div class="space-y-1.5">
                            <a href="tel:{{ $property->agent->phone }}"
                               class="flex items-center gap-2.5 p-2.5 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors group">
                                <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center group-hover:scale-105 transition-transform flex-shrink-0">
                                    <i class="bi bi-telephone-fill text-white text-xs"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-[10px] text-gray-400">Call</p>
                                    <p class="font-semibold text-gray-900 text-xs truncate">{{ $property->agent->phone }}</p>
                                </div>
                            </a>
                            <a href="mailto:{{ $property->agent->email }}"
                               class="flex items-center gap-2.5 p-2.5 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors group">
                                <div class="w-8 h-8 bg-gray-500 rounded-lg flex items-center justify-center group-hover:scale-105 transition-transform flex-shrink-0">
                                    <i class="bi bi-envelope-fill text-white text-xs"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-[10px] text-gray-400">Email</p>
                                    <p class="font-semibold text-gray-900 text-xs truncate">{{ $property->agent->email }}</p>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="bg-white rounded-lg border border-gray-200 p-5">
                        <h3 class="text-base font-bold text-gray-900 mb-3 flex items-center gap-2">
                            <i class="bi bi-lightning-fill text-primary-600"></i>
                            Quick Actions
                        </h3>
                        <div class="space-y-2.5">
                            <!-- WhatsApp (always visible, most important) -->
                            <button onclick="window.sendToWhatsApp('{{ $property->agent->phone }}', 'Hi, I am interested in {{ $property->title }}')"
                                    class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-4 rounded-lg flex items-center justify-center gap-2 transition-all text-sm">
                                <i class="bi bi-whatsapp text-lg"></i>
                                <span>Chat on WhatsApp</span>
                            </button>

                            @auth
                                @php $userPayment = $property->getUserPayment(); @endphp
                                @if($userPayment && $userPayment->status === 'pending')
                                <a href="{{ route('payments.instructions', $userPayment->id) }}"
                                   class="w-full bg-yellow-600 hover:bg-yellow-700 text-white font-semibold py-2.5 px-4 rounded-lg flex items-center justify-center gap-2 transition-all text-sm">
                                    <i class="bi bi-clock-history"></i>
                                    View Payment Status
                                </a>
                                @elseif($userPayment && $userPayment->status === 'approved')
                                <button class="w-full bg-green-600 text-white font-semibold py-2.5 px-4 rounded-lg flex items-center justify-center gap-2 opacity-75 cursor-not-allowed text-sm" disabled>
                                    <i class="bi bi-check-circle"></i>
                                    Payment Confirmed
                                </button>
                                @else
                                <button onclick="initiatePayment({{ $property->id }})"
                                        class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2.5 px-4 rounded-lg flex items-center justify-center gap-2 transition-all text-sm">
                                    <i class="bi bi-credit-card-2-front-fill"></i>
                                    Pay Now
                                </button>
                                @endif

                                @if($property->type === 'Sale')
                                <button onclick="window.sendToWhatsApp('{{ config('bfamily.company.whatsapp') }}', 'Hi, I want to BUY {{ $property->title }} at {{ $property->location }}. Price: {{ $property->formatted_price }}')"
                                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-4 rounded-lg flex items-center justify-center gap-2 transition-all text-sm">
                                    <i class="bi bi-bag-check-fill"></i>
                                    Buy Property
                                </button>
                                @elseif($property->type === 'Rent')
                                <button onclick="window.sendToWhatsApp('{{ config('bfamily.company.whatsapp') }}', 'Hi, I want to RENT {{ $property->title }} at {{ $property->location }}. Price: {{ $property->formatted_price }}/month')"
                                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-4 rounded-lg flex items-center justify-center gap-2 transition-all text-sm">
                                    <i class="bi bi-house-check-fill"></i>
                                    Rent Property
                                </button>
                                @endif
                            @else
                            <a href="{{ route('login') }}?redirect={{ urlencode(request()->fullUrl()) }}"
                               class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2.5 px-4 rounded-lg flex items-center justify-center gap-2 transition-all text-sm">
                                <i class="bi bi-box-arrow-in-right"></i>
                                Login to Continue
                            </a>
                            @endauth

                            <!-- Secondary row: Share + Print -->
                            <div class="flex gap-2 pt-1">
                                <button onclick="shareProperty()"
                                        class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-lg flex items-center justify-center gap-2 transition-colors text-xs">
                                    <i class="bi bi-share-fill"></i>
                                    Share
                                </button>
                                <button onclick="window.print()"
                                        class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-lg flex items-center justify-center gap-2 transition-colors text-xs">
                                    <i class="bi bi-printer-fill"></i>
                                    Print
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Book Inspection -->
                    @auth
                        @if($property->approval_status === 'approved')
                        <div class="bg-white rounded-lg border border-gray-200 p-5" id="contactForm">
                            <h3 class="text-base font-bold text-gray-900 mb-1 flex items-center gap-2">
                                <i class="bi bi-calendar-check-fill text-primary-600"></i>
                                Book Inspection
                            </h3>
                            <p class="text-xs text-gray-500 mb-4">Schedule a visit to view this property</p>
                            <form id="inspectionForm" class="space-y-3">
                                @csrf
                                <input type="hidden" name="property_id" value="{{ $property->id }}">
                                <div>
                                    <label class="text-xs font-medium text-gray-700 mb-1 block">Preferred Date</label>
                                    <input type="date" name="preferred_date"
                                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-primary-500 focus:ring-1 focus:ring-primary-500 outline-none transition-colors"
                                           required min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                </div>
                                <div>
                                    <label class="text-xs font-medium text-gray-700 mb-1 block">Preferred Time</label>
                                    <input type="time" name="preferred_time"
                                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-primary-500 focus:ring-1 focus:ring-primary-500 outline-none transition-colors"
                                           required>
                                </div>
                                <div>
                                    <label class="text-xs font-medium text-gray-700 mb-1 block">Message <span class="text-gray-400">(Optional)</span></label>
                                    <textarea name="message" rows="2"
                                              class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-primary-500 focus:ring-1 focus:ring-primary-500 outline-none transition-colors resize-none"
                                              placeholder="Any special requests..."></textarea>
                                </div>
                                <button type="submit"
                                        class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2.5 px-4 rounded-lg flex items-center justify-center gap-2 transition-all text-sm">
                                    <i class="bi bi-calendar-check-fill"></i>
                                    Book Inspection
                                </button>
                            </form>
                            <div class="mt-3 pt-3 border-t border-gray-100">
                                <p class="text-xs text-gray-500 text-center mb-2">Or book via WhatsApp</p>
                                <button onclick="window.sendToWhatsApp('{{ config('bfamily.company.whatsapp') }}', 'Hi, I want to BOOK AN INSPECTION for {{ $property->title }} at {{ $property->location }}. Please suggest available dates and times.')"
                                        class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-lg flex items-center justify-center gap-2 transition-all text-xs">
                                    <i class="bi bi-whatsapp"></i>
                                    Book via WhatsApp
                                </button>
                            </div>
                        </div>
                        @else
                        <div class="bg-white rounded-lg border border-gray-200 p-5 text-center">
                            <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                <i class="bi bi-clock-history text-yellow-600"></i>
                            </div>
                            <h3 class="font-bold text-gray-900 text-sm mb-1">Booking Not Available</h3>
                            <p class="text-xs text-gray-500">This property is pending approval. Bookings will be available once approved.</p>
                        </div>
                        @endif
                    @else
                    <div class="bg-white rounded-lg border border-gray-200 p-5 text-center">
                        <div class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-2">
                            <i class="bi bi-lock text-primary-600"></i>
                        </div>
                        <h3 class="font-bold text-gray-900 text-sm mb-1">Login Required</h3>
                        <p class="text-xs text-gray-500 mb-3">Please login to book an inspection</p>
                        <a href="{{ route('login') }}?redirect={{ urlencode(request()->fullUrl()) }}"
                           class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2 px-4 rounded-lg flex items-center justify-center gap-2 transition-all text-xs">
                            <i class="bi bi-box-arrow-in-right"></i>
                            Login
                        </a>
                    </div>
                    @endauth

                    <!-- Enquire About This Property -->
                    <div class="bg-white rounded-lg border border-gray-200 p-5 mt-5">
                        <h3 class="text-base font-bold text-gray-900 mb-1 flex items-center gap-2">
                            <i class="bi bi-envelope-fill text-primary-600"></i>
                            Enquire About This Property
                        </h3>
                        <p class="text-xs text-gray-500 mb-4">Ask the agent anything about this property</p>
                        <form id="propertyInquiryForm" class="space-y-3">
                            @csrf
                            <input type="hidden" name="property_id" value="{{ $property->id }}">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="text-xs font-medium text-gray-700 mb-1 block">Full Name</label>
                                    <input type="text" name="name" required value="{{ auth()->user()->name ?? '' }}"
                                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-primary-500 focus:ring-1 focus:ring-primary-500 outline-none transition-colors"
                                           placeholder="Your name">
                                </div>
                                <div>
                                    <label class="text-xs font-medium text-gray-700 mb-1 block">Phone</label>
                                    <input type="tel" name="phone" required value="{{ auth()->user()->phone ?? '' }}"
                                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-primary-500 focus:ring-1 focus:ring-primary-500 outline-none transition-colors"
                                           placeholder="Your phone number">
                                </div>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-700 mb-1 block">Email</label>
                                <input type="email" name="email" required value="{{ auth()->user()->email ?? '' }}"
                                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-primary-500 focus:ring-1 focus:ring-primary-500 outline-none transition-colors"
                                       placeholder="Your email address">
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-700 mb-1 block">Message <span class="text-gray-400">(Optional)</span></label>
                                <textarea name="message" rows="3"
                                          class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-primary-500 focus:ring-1 focus:ring-primary-500 outline-none transition-colors resize-none"
                                          placeholder="I'm interested in this property. Please contact me..."></textarea>
                            </div>
                            <button type="submit"
                                    class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2.5 px-4 rounded-lg flex items-center justify-center gap-2 transition-all text-sm">
                                <i class="bi bi-send-fill"></i>
                                Send Enquiry
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Similar Properties -->
        @if(isset($similarProperties) && $similarProperties->count() > 0)
        <div class="mt-8 pt-6 border-t border-gray-200">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="text-xl md:text-2xl font-bold text-gray-900">Similar Properties</h2>
                    <p class="text-gray-500 text-xs mt-0.5">You might also be interested in these</p>
                </div>
                <a href="{{ route('properties.index', ['category' => $property->category]) }}"
                   class="hidden md:flex items-center gap-1.5 text-primary-600 hover:text-primary-700 font-semibold text-xs transition-colors">
                    View All
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($similarProperties as $similar)
                    @include('partials.property-card', ['property' => $similar])
                @endforeach
            </div>

            @if($similarProperties->hasPages())
            <div class="mt-6 flex justify-center">
                {{ $similarProperties->links() }}
            </div>
            @endif
        </div>
        @endif
    </div>
</section>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 z-[9999] bg-black/90 items-center justify-center p-4" style="display: none;" onclick="closeImageModal()">
    <div class="relative max-w-5xl w-full max-h-[90vh] animate-modal-in" onclick="event.stopPropagation()">
        <button onclick="closeImageModal()" class="absolute -top-10 right-0 text-white/80 hover:text-white text-2xl z-10">
            <i class="bi bi-x-lg"></i>
        </button>
        <img id="modalImage" src="" alt="Full size image" class="w-full h-auto max-h-[85vh] object-contain rounded-lg">
        <div class="flex items-center justify-center gap-4 mt-3">
            <button onclick="modalPrev()" class="text-white/80 hover:text-white text-lg bg-white/10 hover:bg-white/20 rounded-full w-8 h-8 flex items-center justify-center transition-all">
                <i class="bi bi-chevron-left"></i>
            </button>
            <span class="text-white/60 text-xs" id="modalCounter"></span>
            <button onclick="modalNext()" class="text-white/80 hover:text-white text-lg bg-white/10 hover:bg-white/20 rounded-full w-8 h-8 flex items-center justify-center transition-all">
                <i class="bi bi-chevron-right"></i>
            </button>
        </div>
    </div>
</div>

@push('styles')
<style>
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .gallery-thumb.active { border-color: #f97316 !important; border-width: 2px; transform: scale(1.05); }
    #imageGallery { display: flex; flex-direction: row; flex-wrap: nowrap; }
    #imageModal.show { display: flex !important; }
    @keyframes modal-in { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
    .animate-modal-in { animation: modal-in 0.2s ease-out; }
</style>
@endpush

@push('scripts')
<script>
    let currentSlideIndex = 0;

    function getImageUrls() {
        return Array.from(document.querySelectorAll('#sliderTrack .slider-img')).map(function(img) {
            return img.getAttribute('data-full-image') || img.src;
        });
    }

    function slideCount() {
        return getImageUrls().length;
    }

    function updateSlider() {
        const track = document.getElementById('sliderTrack');
        if (track) {
            track.style.transform = 'translateX(-' + (currentSlideIndex * 100) + '%)';
        }
        document.getElementById('currentImageIndex').textContent = currentSlideIndex + 1;
        document.querySelectorAll('.gallery-thumb').forEach(function(t) {
            t.classList.remove('active');
            t.classList.remove('border-primary-500');
            if (parseInt(t.getAttribute('data-index')) === currentSlideIndex) {
                t.classList.add('active');
                t.classList.add('border-primary-500');
            }
        });
    }

    function nextSlide() {
        var count = slideCount();
        if (currentSlideIndex < count - 1) {
            currentSlideIndex++;
        } else {
            currentSlideIndex = 0;
        }
        updateSlider();
    }

    function prevSlide() {
        var count = slideCount();
        if (currentSlideIndex > 0) {
            currentSlideIndex--;
        } else {
            currentSlideIndex = count - 1;
        }
        updateSlider();
    }

    function goToSlide(index) {
        currentSlideIndex = index;
        updateSlider();
    }

    function openImageModal(img) {
        var modal = document.getElementById('imageModal');
        var src = img.getAttribute('data-full-image') || img.src;
        var count = slideCount();
        document.getElementById('modalImage').src = src;
        document.getElementById('modalCounter').textContent = (currentSlideIndex + 1) + ' / ' + count;
        modal.style.display = 'flex';
        requestAnimationFrame(function() {
            modal.classList.add('show');
        });
        document.body.style.overflow = 'hidden';
    }

    function closeImageModal() {
        var modal = document.getElementById('imageModal');
        modal.classList.remove('show');
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }

    function modalNext() {
        var urls = getImageUrls();
        var count = urls.length;
        var next = currentSlideIndex < count - 1 ? currentSlideIndex + 1 : 0;
        currentSlideIndex = next;
        document.getElementById('modalImage').src = urls[next];
        document.getElementById('modalCounter').textContent = (next + 1) + ' / ' + count;
    }

    function modalPrev() {
        var urls = getImageUrls();
        var count = urls.length;
        var prev = currentSlideIndex > 0 ? currentSlideIndex - 1 : count - 1;
        currentSlideIndex = prev;
        document.getElementById('modalImage').src = urls[prev];
        document.getElementById('modalCounter').textContent = (prev + 1) + ' / ' + count;
    }

    document.addEventListener('keydown', function(e) {
        const modal = document.getElementById('imageModal');
        if (modal.classList.contains('show')) {
            if (e.key === 'Escape') closeImageModal();
            if (e.key === 'ArrowRight') modalNext();
            if (e.key === 'ArrowLeft') modalPrev();
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        const firstThumb = document.querySelector('.gallery-thumb');
        if (firstThumb) {
            firstThumb.classList.add('active');
            firstThumb.classList.add('border-primary-500');
        }
    });

    function shareProperty() {
        if (navigator.share) {
            navigator.share({
                title: '{{ $property->title }}',
                text: 'Check out this property: {{ $property->title }}',
                url: window.location.href
            }).catch(() => fallbackCopy());
        } else {
            fallbackCopy();
        }
    }

    function fallbackCopy() {
        navigator.clipboard.writeText(window.location.href).then(() => {
            if (window.toast) window.toast('Link copied to clipboard!', 'success');
        });
    }

    async function initiatePayment(propertyId) {
        try {
            const response = await window.ajax('{{ route("payments.store") }}', 'POST', { property_id: propertyId });
            if (response.success && response.redirect) {
                window.location.href = response.redirect;
            } else {
                if (window.toast) window.toast(response.message || 'Payment initiated successfully', 'success');
            }
        } catch (error) {
            if (window.toast) window.toast(error.message || 'Failed to initiate payment', 'error');
        }
    }

    document.getElementById('inspectionForm')?.addEventListener('submit', async function(e) {
        e.preventDefault();
        const form = e.target;
        const submitBtn = form.querySelector('button[type="submit"]');
        const formData = new FormData(form);

        if (!formData.get('preferred_date') || !formData.get('preferred_time')) {
            if (window.toast) { window.toast('Please fill in all required fields', 'error'); } else { alert('Please fill in all required fields'); }
            return;
        }

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Booking...';

        try {
            const response = await fetch('{{ route("inspections.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || formData.get('_token'),
                    'Accept': 'application/json',
                },
                body: formData
            });
            const data = await response.json();
            if (data.success) {
                if (window.toast) window.toast(data.message || 'Inspection booked successfully! We will confirm shortly.', 'success', 5000);
                form.reset();
                setTimeout(() => {
                    if (confirm('Inspection booked! Would you like to send a confirmation via WhatsApp?')) {
                        const date = formData.get('preferred_date');
                        const time = formData.get('preferred_time');
                        if (typeof window.sendToWhatsApp === 'function') {
                            window.sendToWhatsApp(
                                '{{ config('bfamily.company.whatsapp') }}',
                                'Hi, I just booked an inspection for {{ $property->title }} at {{ $property->location }} on ' + date + ' at ' + time + '. Please confirm.'
                            );
                        }
                    }
                }, 2000);
            } else {
                if (window.toast) window.toast(data.message || 'Failed to book inspection. Please try again.', 'error', 5000);
            }
        } catch (error) {
            console.error('Error:', error);
            if (window.toast) window.toast(error.message || 'Failed to book inspection. Please try again.', 'error');
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="bi bi-calendar-check-fill"></i> Book Inspection';
        }
    });

    document.getElementById('propertyInquiryForm')?.addEventListener('submit', async function(e) {
        e.preventDefault();
        const form = e.target;
        const submitBtn = form.querySelector('button[type="submit"]');
        const formData = new FormData(form);

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Sending...';

        try {
            const response = await window.ajax('{{ route("properties.inquiry", $property->id) }}', 'POST', formData);
            if (window.toast) window.toast(response.message || 'Enquiry sent!', 'success', 5000);
            form.reset();
        } catch (error) {
            if (window.toast) window.toast(error.message || 'Failed to send enquiry. Please try again.', 'error', 5000);
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="bi bi-send-fill"></i> Send Enquiry';
        }
    });
</script>
@endpush
@endsection
