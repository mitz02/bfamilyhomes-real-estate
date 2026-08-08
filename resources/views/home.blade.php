@extends('layouts.app')

@section('title', 'B-Family Homes - #1 Real Estate in Anambra | Enugu, Delta, Imo, Ebonyi, Abia, Rivers, Nigeria | Properties for Sale, Rent & Investment')
@section('description', 'B-Family Homes Limited - Your trusted real estate partner in Anambra State, South East Nigeria. Find premium properties for sale, rent, and investment across Anambra, Enugu, Delta, Imo, Ebonyi, Abia, Rivers, Lagos, and Abuja. Expert real estate services for local and diaspora clients.')
@section('og:title', 'B-Family Homes - #1 Real Estate in Anambra, Enugu, Delta, Imo, Abia, Nigeria')
@section('og:description', 'Your trusted real estate partner across Nigeria. Find premium properties for sale, rent, and investment in Anambra State, Enugu, Delta, Imo, Ebonyi, Abia, Rivers, Lagos, and Abuja.')
@section('twitter:title', 'B-Family Homes - #1 Real Estate in Anambra, Nigeria')
@section('twitter:description', 'Your trusted real estate partner across Nigeria. Find premium properties for sale, rent, and investment in Anambra, Enugu, Delta, Imo, and all Nigeria.')

@section('content')
<!-- Promotion Overlay -->
@if(isset($promotion) && $promotion)
<div id="promotionOverlay" class="fixed inset-0 bg-black/80 z-[10000] flex items-center justify-center p-4 hidden">
    <div class="relative max-w-4xl w-full bg-white rounded-2xl shadow-2xl overflow-hidden">
        <!-- Close Button -->
        <button onclick="closePromotion()" class="absolute top-4 right-4 z-10 w-10 h-10 bg-white/90 hover:bg-white rounded-full flex items-center justify-center shadow-lg transition-all hover:scale-110">
            <i class="bi bi-x-lg text-gray-900 text-xl"></i>
        </button>
        
        <!-- Promotion Image - Load only when overlay is shown (prevents blocking preloader) -->
        <a href="{{ $promotion->link ?: '#' }}" {{ $promotion->link ? 'target="_blank"' : '' }} onclick="closePromotion()">
            <img id="promotionImage" 
                 data-src="{{ asset('storage/' . $promotion->image) }}" 
                 alt="{{ $promotion->title ?: 'Promotion' }}"
                 class="w-full h-auto max-h-[90vh] object-contain"
                 style="display: none;">
            <div id="promotionPlaceholder" class="w-full h-64 flex items-center justify-center bg-gray-100">
                <i class="bi bi-image text-4xl text-gray-400"></i>
            </div>
        </a>
        
        <!-- Promotion Info (if title or description exists) -->
        @if($promotion->title || $promotion->description)
        <div class="p-6 bg-white">
            @if($promotion->title)
            <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $promotion->title }}</h3>
            @endif
            @if($promotion->description)
            <p class="text-gray-600">{{ $promotion->description }}</p>
            @endif
        </div>
        @endif
    </div>
</div>
@endif
<!-- Hero Section -->
<section class="relative flex items-center bg-gradient-to-br from-orange-50 via-white to-yellow-50">

    <!-- Subtle pattern overlay -->
    <div class="absolute inset-0 z-0 opacity-[0.03]" style="background-image: radial-gradient(#f97316 1px, transparent 1px); background-size: 30px 30px;"></div>

    <!-- Decorative shapes -->
    <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-orange-100/60 blur-3xl"></div>
    <div class="absolute -bottom-32 -left-32 w-[30rem] h-[30rem] rounded-full bg-yellow-100/50 blur-3xl"></div>

    <!-- Left side background designs -->
    <div class="absolute -left-20 top-0 w-[28rem] h-[28rem] rounded-full bg-gradient-to-br from-orange-200/40 via-secondary-100/40 to-orange-100/40 blur-3xl"></div>
    <div class="absolute left-16 top-1/4 w-48 h-48 rounded-full bg-secondary-200/30 blur-2xl border border-secondary-300/20"></div>
    <div class="absolute left-8 bottom-1/4 w-40 h-40 rounded-full bg-orange-300/25 blur-2xl border border-orange-400/20"></div>
    <div class="absolute left-32 top-1/3 w-1 h-56 bg-gradient-to-b from-orange-400/50 via-secondary-400/30 to-transparent rounded-full"></div>
    <div class="absolute left-52 top-1/2 w-0.5 h-40 bg-gradient-to-b from-secondary-400/40 to-transparent rounded-full"></div>
    <div class="absolute left-64 bottom-20 w-20 h-20 rounded-full border-2 border-orange-300/20 bg-orange-200/10"></div>
    <div class="absolute left-12 top-1/2 w-3 h-3 rounded-full bg-orange-400/30"></div>

    <!-- Additional left side accents -->
    <div class="absolute left-36 top-16 w-16 h-16 rounded-full border border-secondary-300/15 bg-secondary-200/10"></div>
    <div class="absolute left-72 top-1/3 w-6 h-6 rounded-full bg-orange-400/20 border border-orange-300/20"></div>
    <div class="absolute left-48 bottom-40 w-2 h-2 rounded-full bg-secondary-500/20"></div>
    <div class="absolute left-16 top-[60%] w-12 h-12 rounded-full border-2 border-secondary-300/15"></div>
    <div class="absolute left-80 top-1/4 w-1 h-24 bg-gradient-to-b from-secondary-400/30 to-transparent rounded-full"></div>
    <div class="absolute left-28 top-[15%] w-0.5 h-16 bg-gradient-to-b from-orange-400/30 to-transparent rounded-full"></div>
    <div class="absolute left-60 bottom-32 w-8 h-8 rounded-full border border-orange-400/20 transform rotate-45"></div>
    <div class="absolute left-44 top-[70%] w-4 h-4 rounded-full bg-secondary-400/15"></div>
    <div class="absolute left-72 top-[60%] w-3 h-3 rounded-full bg-orange-400/20"></div>
    <div class="absolute left-24 top-[85%] w-5 h-5 rounded-full border-2 border-secondary-300/10"></div>
    <div class="absolute left-56 top-[18%] w-2 h-2 rounded-full bg-orange-500/25"></div>
    <div class="absolute left-36 bottom-12 w-10 h-10 rounded-full bg-gradient-to-br from-secondary-200/20 to-orange-200/20 border border-secondary-300/10"></div>

    <div class="container mx-auto px-6 relative z-10 py-14 md:py-20" style="max-width: 1400px;">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-12 items-center">

            <!-- Left: Text Content -->
            <div class="animate-fade-in-left">

                <!-- Pill Badge -->
                <div class="inline-flex items-center gap-2 mb-4 border border-secondary-200 bg-secondary-100 px-3 py-1.5 rounded-full">
                    <span class="w-2 h-2 rounded-full bg-secondary-500"></span>
                    <span class="text-secondary-600 text-xs font-semibold uppercase tracking-[0.15em]">Nigeria's Trusted Real Estate</span>
                </div>

                <!-- Headline -->
                <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-black text-gray-900 leading-[1.08] tracking-tight mb-4">
                    Find The<br>
                    <span style="background: linear-gradient(90deg, #f97316, #eab308); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">Perfect</span><br>
                    Property
                </h1>

                <!-- Mobile Search Bar (matches header desktop style, visible only on tablet/mobile) -->
                <form action="{{ route('properties.index') }}" method="GET" class="mb-4 w-full lg:hidden animate-fade-in-up relative" style="animation-delay: 0.2s">
                    <div class="flex items-center bg-gray-100 rounded-full border border-gray-200 focus-within:border-primary-400 focus-within:bg-white focus-within:ring-2 focus-within:ring-primary-100 transition-all h-14 shadow-sm">
                        <select name="type" class="bg-transparent border-none h-full pl-4 pr-1 text-sm font-medium text-gray-700 outline-none cursor-pointer border-r border-gray-300 focus:ring-0">
                            <option value="">All</option>
                            <option value="Rent">Rent</option>
                            <option value="Sale">Buy</option>
                            <option value="Investment">Invest</option>
                        </select>
                        <input type="text" name="search" placeholder="Search locations, properties..." class="w-full bg-transparent border-none py-3 px-3 text-sm focus:ring-0 outline-none text-gray-800 placeholder-gray-500 cursor-pointer" readonly onclick="openMobileFilterModal()">
                        <button type="button" onclick="openMobileFilterModal()" class="text-gray-500 hover:text-orange-600 px-3 h-full flex items-center justify-center transition-colors border-l border-gray-300 flex-shrink-0" title="Open Filter Card">
                            <i class="bi bi-sliders text-lg text-orange-500 font-bold"></i>
                        </button>
                        <button type="submit" class="bg-gradient-to-r from-orange-500 to-yellow-500 hover:from-orange-600 hover:to-yellow-600 text-white w-10 h-10 rounded-full flex items-center justify-center mr-1.5 flex-shrink-0 transition-all shadow-md active:scale-95">
                            <i class="bi bi-search text-sm text-white font-bold"></i>
                        </button>
                    </div>
                </form>

                <!-- Mobile Filter Modal (Slides down smoothly from top) -->
                <div id="mobileFilterModal" class="fixed inset-0 z-[99999] hidden">
                    <!-- Dark Backdrop -->
                    <div id="mobileFilterBackdrop" onclick="closeMobileFilterModal()" class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity duration-300"></div>

                    <!-- Filter Card Box (Slides down from top) -->
                    <div id="mobileFilterCard" class="relative w-full bg-white rounded-b-3xl shadow-2xl z-10 max-h-[90vh] overflow-y-auto transform transition-all duration-300 -translate-y-full">
                        <!-- Sticky Header -->
                        <div class="sticky top-0 bg-white/95 backdrop-blur-md px-5 py-4 border-b border-gray-100 flex items-center justify-between z-20">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-orange-100 flex items-center justify-center text-orange-600 font-bold">
                                    <i class="bi bi-sliders text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-base font-extrabold text-gray-900">Property Filter</h3>
                                    <p class="text-xs text-gray-500">Filter properties across Anambra & Nigeria</p>
                                </div>
                            </div>
                            <button type="button" onclick="closeMobileFilterModal()" class="w-9 h-9 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-600 flex items-center justify-center transition-colors">
                                <i class="bi bi-x-lg text-sm font-bold"></i>
                            </button>
                        </div>

                        <!-- Filter Form Body -->
                        <form action="{{ route('properties.index') }}" method="GET" class="p-5 space-y-4">
                            <!-- Type & Quick Search -->
                            <div class="grid grid-cols-3 gap-2">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1">Type</label>
                                    <select name="type" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3 py-2.5 text-xs font-medium text-gray-800 outline-none focus:bg-white focus:ring-2 focus:ring-orange-200 focus:border-orange-500">
                                        <option value="">All</option>
                                        <option value="Rent">Rent</option>
                                        <option value="Sale">Buy</option>
                                        <option value="Investment">Invest</option>
                                    </select>
                                </div>
                                <div class="col-span-2">
                                    <label class="block text-xs font-semibold text-gray-700 mb-1">Keyword</label>
                                    <input type="text" name="search" placeholder="Search title or location..." class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3 py-2.5 text-xs text-gray-800 outline-none focus:bg-white focus:ring-2 focus:ring-orange-200 focus:border-orange-500">
                                </div>
                            </div>

                            <!-- Property Name -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Property Name / Title</label>
                                <input type="text" name="title" placeholder="e.g. Luxury Villa, Royal Palms" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs text-gray-800 outline-none focus:bg-white focus:ring-2 focus:ring-orange-200 focus:border-orange-500">
                            </div>

                            <!-- Location -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Location</label>
                                <input type="text" name="location" placeholder="e.g. Awkuzu, Onitsha, Nnewi, Enugu" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs text-gray-800 outline-none focus:bg-white focus:ring-2 focus:ring-orange-200 focus:border-orange-500">
                            </div>

                            <!-- Category -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Category</label>
                                <select name="category" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs text-gray-800 outline-none focus:bg-white focus:ring-2 focus:ring-orange-200 focus:border-orange-500">
                                    <option value="">All Categories</option>
                                    <option value="Apartment">Apartment</option>
                                    <option value="House">House</option>
                                    <option value="Villa">Villa</option>
                                    <option value="Duplex">Duplex</option>
                                    <option value="Commercial">Commercial</option>
                                    <option value="Office">Office</option>
                                    <option value="Land">Land</option>
                                </select>
                            </div>

                            <!-- Bedrooms & Bathrooms -->
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1">Bedrooms</label>
                                    <select name="bedrooms" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs text-gray-800 outline-none focus:bg-white focus:ring-2 focus:ring-orange-200 focus:border-orange-500">
                                        <option value="">Any</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4+">4+</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1">Bathrooms</label>
                                    <select name="bathrooms" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs text-gray-800 outline-none focus:bg-white focus:ring-2 focus:ring-orange-200 focus:border-orange-500">
                                        <option value="">Any</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4+">4+</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Min Price & Max Price -->
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1">Min Price (₦)</label>
                                    <input type="number" name="min_price" placeholder="Min Price" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs text-gray-800 outline-none focus:bg-white focus:ring-2 focus:ring-orange-200 focus:border-orange-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1">Max Price (₦)</label>
                                    <input type="number" name="max_price" placeholder="Max Price" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs text-gray-800 outline-none focus:bg-white focus:border-orange-500">
                                </div>
                            </div>

                            <!-- Actions Footer -->
                            <div class="pt-3 pb-3 flex items-center gap-3">
                                <button type="reset" class="px-4 py-3.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl text-xs transition-colors">
                                    Reset
                                </button>
                                <button type="submit" class="flex-1 bg-gradient-to-r from-orange-500 to-yellow-500 hover:from-orange-600 hover:to-yellow-600 text-white font-bold py-3.5 rounded-xl shadow-lg transition-all flex items-center justify-center gap-2 text-sm active:scale-98">
                                    <i class="bi bi-search"></i> Search Properties
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <script>
                    function openMobileFilterModal() {
                        var modal = document.getElementById('mobileFilterModal');
                        var card = document.getElementById('mobileFilterCard');
                        if (!modal || !card) return;
                        modal.classList.remove('hidden');
                        document.body.style.overflow = 'hidden';
                        requestAnimationFrame(function() {
                            card.classList.remove('-translate-y-full');
                            card.classList.add('translate-y-0');
                        });
                    }

                    function closeMobileFilterModal() {
                        var modal = document.getElementById('mobileFilterModal');
                        var card = document.getElementById('mobileFilterCard');
                        if (!modal || !card) return;
                        card.classList.remove('translate-y-0');
                        card.classList.add('-translate-y-full');
                        setTimeout(function() {
                            modal.classList.add('hidden');
                            document.body.style.overflow = '';
                        }, 300);
                    }

                    document.addEventListener('keydown', function(e) {
                        if (e.key === 'Escape') {
                            closeMobileFilterModal();
                        }
                    });
                </script>
            </div>

            <!-- Right: Images -->
            <div class="hidden lg:block animate-fade-in-right">
                <div class="grid grid-cols-2 gap-4">
                    <div class="row-span-2 rounded-2xl overflow-hidden shadow-xl" style="height: 420px;">
                        <img src="images/bfamily-3.jpeg" alt="Premium real estate property in Anambra, Nigeria - B-Family Homes" fetchpriority="high" class="w-full h-full object-cover hover:scale-105 transition-transform duration-700">
                    </div>
                    <!-- Short Image Top -->
                    <div class="rounded-2xl overflow-hidden shadow-md" style="height: 200px;">
                        <img src="images/bfamily-2.jpeg" alt="Modern property listing in Anambra State - B-Family Homes" loading="lazy" class="w-full h-full object-cover hover:scale-105 transition-transform duration-700">
                    </div>
                    <!-- Short Image Bottom with Floating Card -->
                    <div class="relative rounded-2xl overflow-hidden shadow-md" style="height: 200px;">
                        <img src="images/bfamily-4.jpeg" alt="Luxury home for sale in South East Nigeria - B-Family Homes" loading="lazy" class="w-full h-full object-cover hover:scale-105 transition-transform duration-700">
                        <!-- Floating stat card -->
                        <div class="absolute bottom-2 left-2 right-2 bg-white/90 backdrop-blur-md rounded-lg p-2 border border-gray-100">
                            <p class="text-gray-500 text-[10px] font-medium">Monthly Transactions</p>
                            <p class="text-gray-900 text-base font-black">₦50B+</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Latest Properties -->
<section class="py-16" style="background-color: #f3f3f3;">
    <div class="container mx-auto px-4" style="max-width: 1400px;">
        <div class="text-center mb-12 animate-fade-in-up">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-1">Latest Properties</h2>
            <div class="flex items-center justify-center gap-2 mb-4">
                <span class="w-16 h-1 bg-gradient-to-r from-primary-500 to-accent rounded-full"></span>
                <span class="w-2 h-2 bg-primary-500 rounded-full rotate-45"></span>
                <span class="w-16 h-1 bg-gradient-to-r from-accent to-primary-500 rounded-full"></span>
            </div>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Discover our newest property listings across Anambra State
            </p>
        </div>

        @if($latestProperties->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($latestProperties->take(6) as $property)
                @include('partials.property-card', ['property' => $property])
            @endforeach
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('properties.index') }}" class="group inline-flex items-center gap-3 bg-gradient-to-r from-orange-500 to-yellow-500 hover:from-orange-600 hover:to-yellow-600 text-white font-bold px-8 py-4 rounded-full shadow-lg shadow-orange-200 hover:shadow-orange-300 transition-all duration-300 transform hover:-translate-y-1">
                <span>View All Properties</span>
                <i class="bi bi-arrow-right text-xl group-hover:translate-x-2 transition-transform duration-300"></i>
            </a>
        </div>
        @else
        <div class="text-center py-12">
            <p class="text-gray-600">No properties available yet</p>
        </div>
        @endif
    </div>
</section>

<!-- Categories Section -->
<section class="py-16 bg-gradient-to-b from-white via-gray-50 to-white">
    <div class="container mx-auto px-4" style="max-width: 1400px;">
        <div class="text-center mb-12 animate-fade-in-up">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-1">Categories</h2>
            <div class="flex items-center justify-center gap-2 mb-4">
                <span class="w-16 h-1 bg-gradient-to-r from-primary-500 to-accent rounded-full"></span>
                <span class="w-2 h-2 bg-primary-500 rounded-full rotate-45"></span>
                <span class="w-16 h-1 bg-gradient-to-r from-accent to-primary-500 rounded-full"></span>
            </div>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Explore our diverse range of property categories
            </p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
            @if(isset($categoriesFromDb) && $categoriesFromDb->count() > 0)
                @php
                    $categoryImages = [
                        'Apartment' => 'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=600&h=400&fit=crop',
                        'House' => 'https://images.unsplash.com/photo-1568605114967-8130f3a36994?w=600&h=400&fit=crop',
                        'Villa' => 'https://images.unsplash.com/photo-1613490493576-7fde63acd811?w=600&h=400&fit=crop',
                        'Duplex' => 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=600&h=400&fit=crop',
                        'Commercial' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=600&h=400&fit=crop',
                        'Office' => 'https://images.unsplash.com/photo-1497366754035-f200968a6e72?w=600&h=400&fit=crop',
                        'Land' => 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=600&h=400&fit=crop',
                        'Commercial Lands' => 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=600&h=400&fit=crop',
                        'Showrooms & Shops' => 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=600&h=400&fit=crop',
                        'Office rooms' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=600&h=400&fit=crop',
                        'Residential' => 'https://images.unsplash.com/photo-1568605114967-8130f3a36994?w=600&h=400&fit=crop',
                    ];
                @endphp
                @foreach($categoriesFromDb as $category)
                <a href="{{ route('properties.index', ['category' => $category['name']]) }}" 
                   class="group relative rounded-xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-gray-200">
                    <!-- Category Image -->
                    <div class="relative h-48 md:h-56 overflow-hidden">
                        <img src="{{ $categoryImages[$category['name']] ?? 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=600&h=400&fit=crop' }}" 
                             alt="{{ $category['name'] }} properties for sale and rent in Anambra, Nigeria - B-Family Homes"
                             loading="lazy"
                             class="w-full h-full object-cover object-center group-hover:scale-110 transition-transform duration-500"
                             onerror="this.src='https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=600&h=400&fit=crop'">
                        
                        <!-- Overlay Gradient -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                        
                        <!-- Count Badge -->
                        <div class="absolute top-3 right-3">
                            <span class="px-3 py-1.5 bg-secondary-500 text-white rounded-full text-sm font-bold shadow-lg">
                                {{ $category['count'] }}
                            </span>
                        </div>
                        
                        <!-- Category Name -->
                        <div class="absolute bottom-0 left-0 right-0 p-4">
                            <h3 class="text-lg md:text-xl font-bold text-white mb-1 group-hover:text-secondary-300 transition-colors">
                                {{ $category['name'] }}
                            </h3>
                            <p class="text-xs text-white/90 flex items-center gap-1">
                                <span>Properties</span>
                                <i class="bi bi-arrow-right text-xs opacity-0 group-hover:opacity-100 group-hover:translate-x-1 transition-all"></i>
                            </p>
                        </div>
                    </div>
                </a>
                @endforeach
            @else
            <div class="col-span-full text-center py-12">
                <p class="text-gray-600">No categories available yet</p>
            </div>
            @endif
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="py-20 bg-gradient-to-b from-white via-orange-50/30 to-white">
    <div class="container mx-auto px-4" style="max-width: 1400px;">
        <div class="text-center mb-14">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-orange-100 rounded-full mb-4">
                <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                <span class="text-orange-600 text-sm font-semibold uppercase tracking-wide">Why Choose Us</span>
            </div>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-1">
                Why B-Family Homes?
            </h2>
            <div class="flex items-center justify-center gap-2 mb-4">
                <span class="w-20 h-1 bg-gradient-to-r from-primary-500 to-accent rounded-full"></span>
                <span class="w-2.5 h-2.5 bg-primary-500 rounded-full rotate-45"></span>
                <span class="w-20 h-1 bg-gradient-to-r from-accent to-primary-500 rounded-full"></span>
            </div>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                We make property ownership easy, secure, and profitable for everyone — locally and abroad.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="group relative bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-secondary-500 to-secondary-600"></div>
                <div class="p-8 pt-12 text-center">
                    <i class="bi bi-shield-check text-4xl text-primary-500 mb-5 inline-block group-hover:scale-110 group-hover:text-primary-600 transition-all duration-500"></i>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Verified & Secure</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">All properties come with proper documentation and full legal backing for peace of mind.</p>
                </div>
            </div>

            <div class="group relative bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-secondary-500 to-secondary-600"></div>
                <div class="p-8 pt-12 text-center">
                    <i class="bi bi-building text-4xl text-accent mb-5 inline-block group-hover:scale-110 group-hover:text-accent-dark transition-all duration-500"></i>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Professional Construction</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Through strategic partnerships, we deliver solid and well-engineered buildings that last.</p>
                </div>
            </div>

            <div class="group relative bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-secondary-500 to-secondary-600"></div>
                <div class="p-8 pt-12 text-center">
                    <i class="bi bi-globe2 text-4xl text-primary-500 mb-5 inline-block group-hover:scale-110 group-hover:text-primary-600 transition-all duration-500"></i>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Diaspora-Friendly</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Real-time updates, transparent tracking, and support for clients investing from abroad.</p>
                </div>
            </div>

            <div class="group relative bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-secondary-500 to-secondary-600"></div>
                <div class="p-8 pt-12 text-center">
                    <i class="bi bi-credit-card text-4xl text-accent mb-5 inline-block group-hover:scale-110 group-hover:text-accent-dark transition-all duration-500"></i>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Flexible Payment Plans</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">50/50 Building Plan and installment options that make property ownership accessible to all.</p>
                </div>
            </div>
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('properties.index') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-orange-500 to-yellow-500 hover:from-orange-600 hover:to-yellow-600 text-white font-bold px-8 py-3.5 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-0.5">
                Explore Properties <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
</section>



<!-- About Us Section -->
<!-- Updated with B-Family Homes detailed information -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4" style="max-width: 1400px;">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Left Side - Images -->
            <div class="relative animate-fade-in-left">
                <!-- Main Image -->
                <div class="relative rounded-xl overflow-hidden shadow-2xl group">
                    <img src="images/bfamily-3.jpeg" 
                         alt="Premium luxury property for sale in Anambra, Nigeria - B-Family Homes"
                         loading="lazy"
                         class="w-full h-[500px] object-cover group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                </div>

                <!-- Video Thumbnail Overlay -->
                <div class="absolute -bottom-6 -left-6 bg-white rounded-xl shadow-2xl p-2 group cursor-pointer hover:scale-105 transition-transform duration-300">
                    <div class="relative rounded-lg overflow-hidden">
                        <img src="images/bfamily-property.jpeg" 
                             alt="Property video tour - B-Family Homes real estate in Anambra"
                             loading="lazy"
                             class="w-48 h-32 object-cover">
                        <div class="absolute inset-0 bg-black/30 flex items-center justify-center">
                            <div class="w-16 h-16 bg-orange-500 rounded-full flex items-center justify-center shadow-lg">
                                <i class="bi bi-play-fill text-white text-2xl ml-1"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Decorative Dots -->
                <div class="absolute -top-8 -left-8 w-32 h-32 opacity-20">
                    <div class="grid grid-cols-4 gap-2">
                        @for($i = 0; $i < 16; $i++)
                        <div class="w-2 h-2 bg-orange-500 rounded-full"></div>
                        @endfor
                    </div>
                </div>
            </div>

            <!-- Right Side - Text Content -->
            <div class="animate-fade-in-right">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg flex items-center justify-center">
                        <i class="bi bi-arrow-up-right text-white text-lg"></i>
                    </div>
                    <span class="text-gray-600 font-semibold uppercase tracking-wide">About B-Family Homes</span>
                </div>
                
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-6 leading-tight text-center md:text-left">
                    Trusted Real Estate Development and Investment Company
                </h2>
                
                <p class="text-gray-600 text-lg mb-6 leading-relaxed">
                    B-Family Homes Limited is a trusted real estate development and investment company based in Awkuzu, Anambra State, Nigeria. We specialize in land sales, property development, building construction, property investment, and diaspora real estate services.
                </p>

                <p class="text-gray-600 text-lg mb-8 leading-relaxed">
                    We operate with integrity, transparency, and a strong commitment to long-term value creation. Through strategic partnerships with professional construction firms such as OJB Construction, we deliver solid, well-engineered buildings that stand the test of time.
                </p>

                <a href="{{ route('about') }}" class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white px-8 py-3 rounded-lg font-semibold transition-all duration-300 hover:scale-105 shadow-lg hover:shadow-xl">
                    Read More
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</section>





<!-- Latest Blog Posts -->
@if(isset($latestBlogs) && $latestBlogs->count() > 0)
<section class="py-16 bg-white">
    <div class="container mx-auto px-4" style="max-width: 1400px;">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Latest Blog Posts</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Stay informed with our latest real estate insights and tips
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($latestBlogs as $blog)
            <article class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-shadow border border-gray-100">
                @if($blog->featured_image)
                <a href="{{ route('blogs.show', $blog->slug) }}">
                    <img src="{{ asset('storage/' . $blog->featured_image) }}" 
                         alt="{{ $blog->title }} - B-Family Homes Real Estate Blog"
                         loading="lazy"
                         class="w-full h-64 object-cover">
                </a>
                @else
                <div class="w-full h-64 bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center">
                    <i class="bi bi-journal-text text-white text-6xl"></i>
                </div>
                @endif
                
                <div class="p-6">
                    <div class="flex items-center gap-3 text-sm text-gray-500 mb-3">
                        <span>{{ $blog->created_at->format('M d, Y') }}</span>
                        <span>•</span>
                        <span>{{ $blog->author->name }}</span>
                    </div>
                    
                    <h3 class="text-xl font-bold text-gray-900 mb-3">
                        <a href="{{ route('blogs.show', $blog->slug) }}" class="hover:text-primary-600 transition-colors">
                            {{ $blog->title }}
                        </a>
                    </h3>
                    
                    @if($blog->excerpt)
                    <p class="text-gray-600 mb-4 line-clamp-2">{{ $blog->excerpt }}</p>
                    @else
                    <p class="text-gray-600 mb-4 line-clamp-2">{{ Str::limit(strip_tags($blog->content), 120) }}</p>
                    @endif
                    
                    <a href="{{ route('blogs.show', $blog->slug) }}" class="text-primary-600 font-semibold hover:text-primary-700 inline-flex items-center gap-2">
                        Read More
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </article>
            @endforeach
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('blogs.index') }}" class="btn btn-primary">
                View All Blog Posts
                <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
</section>
@endif

<!-- WhatsApp Inspection Booking -->
<section class="py-20 bg-white relative overflow-hidden">
    <div class="absolute top-0 right-0 w-1/3 h-full bg-gradient-to-l from-orange-50/50 to-transparent"></div>
    <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-orange-100/40 rounded-full blur-3xl"></div>

    <div class="container mx-auto px-4 relative z-10" style="max-width: 1400px;">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Left: Info -->
            <div>
                <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-orange-100 rounded-full mb-4">
                    <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                    <span class="text-orange-600 text-sm font-semibold uppercase tracking-wide">Book an Inspection</span>
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4 leading-tight">
                    Schedule a Property<br>Inspection via WhatsApp
                </h2>
                <p class="text-gray-600 text-lg mb-8">
                    Fill out the form and we'll send your request directly to our team on WhatsApp for a fast response.
                </p>

                <div class="space-y-4 mb-8">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-lightning-charge text-orange-500 text-xl"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">Quick Response</p>
                            <p class="text-sm text-gray-600">Get a reply within minutes on WhatsApp</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-calendar-check text-orange-500 text-xl"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">Pick Your Date & Time</p>
                            <p class="text-sm text-gray-600">Choose what works best for your schedule</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-chat-dots text-orange-500 text-xl"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">Talk Directly</p>
                            <p class="text-sm text-gray-600">Chat with our agents in real-time</p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3 p-4 bg-orange-50 rounded-xl border border-orange-100">
                    <i class="bi bi-shield-check text-orange-500 text-xl"></i>
                    <p class="text-sm text-gray-700">Your information is kept private and will only be used for this inspection request.</p>
                </div>
            </div>

            <!-- Right: Form -->
            <div>
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
                    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                        <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-xl flex items-center justify-center shadow-md">
                            <i class="bi bi-whatsapp text-2xl text-white"></i>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900">Send Inspection Request</p>
                            <p class="text-sm text-gray-500">We'll get back to you shortly</p>
                        </div>
                    </div>

                    <form id="whatsappInspectionForm" class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Your Name *</label>
                                <input type="text" name="name" required placeholder="John Doe" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-orange-200 focus:border-orange-400 focus:bg-white transition-all outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Phone Number *</label>
                                <input type="tel" name="phone" required placeholder="+234 801 234 5678" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-orange-200 focus:border-orange-400 focus:bg-white transition-all outline-none">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Property Interest</label>
                            <input type="text" name="property_interest" placeholder="e.g., 3 Bedroom Apartment in Awka" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-orange-200 focus:border-orange-400 focus:bg-white transition-all outline-none">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Preferred Date</label>
                                <input type="date" name="preferred_date" min="{{ date('Y-m-d', strtotime('+1 day')) }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-orange-200 focus:border-orange-400 focus:bg-white transition-all outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Preferred Time</label>
                                <input type="time" name="preferred_time" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-orange-200 focus:border-orange-400 focus:bg-white transition-all outline-none">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Message <span class="text-gray-400 font-normal">(Optional)</span></label>
                            <textarea name="message" rows="3" placeholder="Any specific requirements or questions..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-orange-200 focus:border-orange-400 focus:bg-white transition-all outline-none resize-none"></textarea>
                        </div>

                        <button type="submit" class="w-full bg-gradient-to-r from-orange-500 to-yellow-500 hover:from-orange-600 hover:to-yellow-600 text-white font-bold py-3.5 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 flex items-center justify-center gap-2 text-base">
                            <i class="bi bi-whatsapp text-xl"></i>
                            Send via WhatsApp
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<!-- Added background-attachment: fixed to statistics background -->
<section class="py-12 md:py-20 relative overflow-hidden bg-gradient-to-br from-secondary-700 via-secondary-800 to-secondary-900">
    <div class="absolute inset-0 opacity-5" style="background-image: url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=1920&q=80'); background-size: cover; background-position: center; background-attachment: fixed;"></div>
    <div class="absolute top-10 left-10 w-72 h-72 bg-accent/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-10 right-10 w-72 h-72 bg-primary-500/10 rounded-full blur-3xl"></div>
    
    <div class="container mx-auto px-4 relative z-10" style="max-width: 1400px;">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-8">
            <!-- Total Agents -->
            <div class="text-center text-white animate-fade-in-up hover:scale-110 transition-transform duration-300 min-w-0" style="animation-delay: 0.1s">
                <div class="w-12 h-12 md:w-20 md:h-20 bg-gradient-to-br from-primary-500 to-primary-600 rounded-full flex items-center justify-center mx-auto mb-2 md:mb-4 shadow-lg">
                    <i class="bi bi-people text-xl md:text-3xl text-white"></i>
                </div>
                <h3 class="text-2xl md:text-5xl font-bold mb-1 md:mb-2 counter-value text-primary-300" data-target="{{ $stats['total_agents'] }}">0</h3>
                <p class="text-xs md:text-lg text-primary-200 font-medium">Total Agents</p>
            </div>

            <!-- Total Sales -->
            <div class="text-center text-white animate-fade-in-up hover:scale-110 transition-transform duration-300 min-w-0" style="animation-delay: 0.2s">
                <div class="w-12 h-12 md:w-20 md:h-20 bg-gradient-to-br from-accent to-accent-dark rounded-full flex items-center justify-center mx-auto mb-2 md:mb-4 shadow-lg">
                    <i class="bi bi-rocket-takeoff text-xl md:text-3xl text-white"></i>
                </div>
                <h3 class="text-2xl md:text-5xl font-bold mb-1 md:mb-2 counter-value text-yellow-300" data-target="{{ $stats['total_sales'] }}">0</h3>
                <p class="text-xs md:text-lg text-yellow-200 font-medium">Total Sales</p>
            </div>

            <!-- Total Projects -->
            <div class="text-center text-white animate-fade-in-up hover:scale-110 transition-transform duration-300 min-w-0" style="animation-delay: 0.3s">
                <div class="w-12 h-12 md:w-20 md:h-20 bg-gradient-to-br from-primary-600 to-primary-700 rounded-full flex items-center justify-center mx-auto mb-2 md:mb-4 shadow-lg">
                    <i class="bi bi-file-earmark-text text-xl md:text-3xl text-white"></i>
                </div>
                <h3 class="text-2xl md:text-5xl font-bold mb-1 md:mb-2 counter-value text-primary-300" data-target="{{ $stats['total_projects'] }}">0</h3>
                <p class="text-xs md:text-lg text-primary-200 font-medium">Total Projects</p>
            </div>

            <!-- Happy Customers -->
            <div class="text-center text-white animate-fade-in-up hover:scale-110 transition-transform duration-300 min-w-0" style="animation-delay: 0.4s">
                <div class="w-12 h-12 md:w-20 md:h-20 bg-gradient-to-br from-accent-dark to-primary-600 rounded-full flex items-center justify-center mx-auto mb-2 md:mb-4 shadow-lg">
                    <i class="bi bi-emoji-smile text-xl md:text-3xl text-white"></i>
                </div>
                <h3 class="text-2xl md:text-5xl font-bold mb-1 md:mb-2 counter-value text-yellow-300" data-target="{{ $stats['happy_customers'] }}">0</h3>
                <p class="text-xs md:text-lg text-yellow-200 font-medium">Happy Customers</p>
            </div>
        </div>
    </div>
</section>

<!-- Features / Preferred Choice Section -->
<section class="py-16 md:py-20 bg-gradient-to-br from-secondary-50 via-white to-orange-50 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-96 h-96 bg-secondary-100 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 animate-bounce-slow" style="animation-delay: 0.5s"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-orange-100 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2 animate-bounce-slow" style="animation-delay: 1s"></div>

    <div class="container mx-auto px-4 relative z-10" style="max-width: 1400px;">
        <div class="text-center mb-14 animate-fade-in-up">
            <span class="inline-block px-4 py-1.5 bg-orange-100 text-orange-600 text-sm font-semibold rounded-full mb-4">Why Choose Us</span>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                What Makes Us The Preferred Choice?
            </h2>
            <p class="text-gray-500 max-w-xl mx-auto text-base">
                Experience excellence in real estate with our comprehensive services and trusted expertise
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8 max-w-5xl mx-auto">
            <!-- Card 1 -->
            <div class="group relative flex gap-5 p-6 bg-white rounded-xl shadow-md hover:shadow-xl border border-gray-100 hover:border-orange-200 transition-all duration-500 animate-fade-in-up" style="animation-delay: 0.1s">
                <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-xl flex items-center justify-center flex-shrink-0 mt-1 shadow-md group-hover:scale-110 group-hover:rotate-3 transition-all duration-500">
                    <i class="bi bi-shield-check text-lg text-white"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="text-lg font-bold text-gray-900 mb-1.5 group-hover:text-orange-600 transition-colors">Buyers Trust Us</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">We provide verified properties with complete documentation, ensuring secure and transparent transactions for all buyers.</p>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="group relative flex gap-5 p-6 bg-white rounded-xl shadow-md hover:shadow-xl border border-gray-100 hover:border-orange-200 transition-all duration-500 animate-fade-in-up" style="animation-delay: 0.2s">
                <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-xl flex items-center justify-center flex-shrink-0 mt-1 shadow-md group-hover:scale-110 group-hover:-rotate-3 transition-all duration-500">
                    <i class="bi bi-hand-thumbs-up text-lg text-white"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="text-lg font-bold text-gray-900 mb-1.5 group-hover:text-orange-600 transition-colors">Sellers Prefer Us</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Our platform offers easy property listing, professional marketing, and fast support to help sellers reach the right buyers quickly.</p>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="group relative flex gap-5 p-6 bg-white rounded-xl shadow-md hover:shadow-xl border border-gray-100 hover:border-orange-200 transition-all duration-500 animate-fade-in-up" style="animation-delay: 0.3s">
                <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-xl flex items-center justify-center flex-shrink-0 mt-1 shadow-md group-hover:scale-110 group-hover:rotate-3 transition-all duration-500">
                    <i class="bi bi-list-check text-lg text-white"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="text-lg font-bold text-gray-900 mb-1.5 group-hover:text-orange-600 transition-colors">Maximum Choices</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Browse through hundreds of properties across Anambra State, from residential homes to commercial lands and investment opportunities.</p>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="group relative flex gap-5 p-6 bg-white rounded-xl shadow-md hover:shadow-xl border border-gray-100 hover:border-orange-200 transition-all duration-500 animate-fade-in-up" style="animation-delay: 0.4s">
                <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-xl flex items-center justify-center flex-shrink-0 mt-1 shadow-md group-hover:scale-110 group-hover:-rotate-3 transition-all duration-500">
                    <i class="bi bi-people text-lg text-white"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="text-lg font-bold text-gray-900 mb-1.5 group-hover:text-orange-600 transition-colors">Expert Guidance</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Our team of experienced agents and professionals provide expert advice to help you make informed property decisions.</p>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="py-20 relative overflow-hidden bg-gradient-to-br from-primary-600 via-primary-500 to-accent">
    <div class="absolute inset-0 opacity-[0.05]"
         style="background-image: url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=1920&q=80');
                background-size: cover;
                background-position: center;
                background-attachment: fixed;">
    </div>
    <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-primary-800/20 rounded-full blur-3xl"></div>

    <div class="container mx-auto px-4 relative z-10" style="max-width: 1400px;">
        <h2 class="text-4xl md:text-5xl font-bold text-white text-center mb-1">
            What Our Clients Say
        </h2>
        <div class="flex items-center justify-center gap-2 mb-14">
            <span class="w-20 h-1 bg-white/60 rounded-full"></span>
            <span class="w-2.5 h-2.5 bg-white rotate-45"></span>
            <span class="w-20 h-1 bg-white/60 rounded-full"></span>
        </div>

        @php
            $testimonials = [
                [
                    'name' => 'Mr. Chinedu O. — Onitsha',
                    'content' => 'B-Family Homes helped me buy my first land with confidence. The process was transparent and stress-free.',
                    'image' => asset('images/image1.jpg'),
                ],
                [
                    'name' => 'Mrs. Ifunanya A. — UK',
                    'content' => 'I invested from abroad, and every update was given to me as the project progressed. I truly felt safe.',
                    'image' => asset('images/image7.jpg'),
                ],
                [
                    'name' => 'Engr. Nnamdi E. — Canada',
                    'content' => 'Their 50/50 building plan is the best thing for people in the diaspora. I paid half, and my house started immediately.',
                    'image' => asset('images/image3.jpg'),
                ],
                [
                    'name' => 'Miss Blessing I. — Awka',
                    'content' => 'From inspection to allocation, everything was exactly as promised. No hidden issues.',
                    'image' => asset('images/image5.jpg'),
                ],
                [
                    'name' => 'Mr. Samuel K. — Abuja',
                    'content' => 'The professionalism and honesty of B-Family Homes stood out. My land documents were delivered without delay.',
                    'image' => asset('images/image5.jpg'),
                ],
                [
                    'name' => 'Mrs. Adaeze M. — Lagos',
                    'content' => 'I recommend them to anyone looking for genuine real estate investment. Their communication is top-notch.',
                    'image' => asset('images/image6.jpg'),
                ],
            ];
        @endphp

        <div class="testimonials-slider relative max-w-4xl mx-auto">
            <div class="testimonials-content overflow-hidden">
                <div class="flex transition-transform duration-500 ease-in-out"
                     id="testimonialsContainer"
                     style="transform: translateX(0%);">

                    @foreach($testimonials as $testimonial)
                        <div class="testimonial-slide flex-shrink-0 w-full text-center px-4">
                            <!-- Avatar -->
                            <div class="flex justify-center mb-8">
                                <div class="testimonial-avatar ring-4 ring-white/50 rounded-full overflow-hidden">
                                    <img src="{{ $testimonial['image'] }}"
                                         alt="{{ $testimonial['name'] }} - B-Family Homes client testimonial"
                                         loading="lazy"
                                         class="w-24 h-24 rounded-full object-cover border-4 border-white">
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="text-white mb-8">
                                <span class="text-6xl font-serif leading-none opacity-50">"</span>
                                <p class="text-lg md:text-xl leading-relaxed max-w-3xl mx-auto mt-4">
                                    {{ $testimonial['content'] }}
                                </p>
                            </div>

                            <!-- Name -->
                            <h4 class="text-2xl font-bold text-white mb-3">
                                {{ $testimonial['name'] }}
                            </h4>

                            <!-- Stars -->
                            <div class="flex justify-center gap-1 mb-8">
                                @for($i = 0; $i < 5; $i++)
                                    <i class="bi bi-star-fill text-yellow-400 text-xl"></i>
                                @endfor
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Navigation -->
            <button class="testimonial-prev absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4
                           bg-white/20 hover:bg-white/30 rounded-full p-3 border border-white/30 transition-all z-10 hidden md:flex">
                <i class="bi bi-chevron-left text-2xl text-white"></i>
            </button>

            <button class="testimonial-next absolute right-0 top-1/2 -translate-y-1/2 translate-x-4
                           bg-white/20 hover:bg-white/30 rounded-full p-3 border border-white/30 transition-all z-10 hidden md:flex">
                <i class="bi bi-chevron-right text-2xl text-white"></i>
            </button>
        </div>
    </div>
</section>


<!-- How to Buy & Invest in Real Estate in Anambra, Nigeria -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4" style="max-width: 1100px;">
        <div class="text-center mb-12">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-orange-100 rounded-full mb-4">
                <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                <span class="text-orange-600 text-sm font-semibold uppercase tracking-wide">Step by Step Guide</span>
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">How to Buy, Rent & Invest in Real Estate in Anambra, Nigeria</h2>
            <p class="text-gray-600 max-w-3xl mx-auto text-lg">
                Your complete guide to property investment in Anambra State, Enugu, Delta, Imo, Ebonyi, Abia, Rivers, and all South East Nigeria
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Step 1 -->
            <div class="bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition-shadow border border-gray-100">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-orange-500 rounded-xl flex items-center justify-center flex-shrink-0 text-white text-xl font-bold shadow-lg">1</div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Browse Properties</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">Explore our extensive portfolio of verified properties for sale, rent, and investment across Anambra State (Awkuzu, Onitsha, Awka, Nnewi), Enugu, Delta, Imo, Ebonyi, Abia, Rivers, Lagos, and Abuja. Use our smart filters to find exactly what you need.</p>
                    </div>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition-shadow border border-gray-100">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-orange-500 rounded-xl flex items-center justify-center flex-shrink-0 text-white text-xl font-bold shadow-lg">2</div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Contact & Inquire</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">Reach out to our team via phone (+234 816 485 6758), email, or WhatsApp. Ask questions about the property, schedule a viewing, or request a virtual tour. Our agents are ready to assist local and diaspora clients.</p>
                    </div>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition-shadow border border-gray-100">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-orange-500 rounded-xl flex items-center justify-center flex-shrink-0 text-white text-xl font-bold shadow-lg">3</div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Inspect or Take a Virtual Tour</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">Book a physical inspection or request a virtual tour of the property. For diaspora investors, we offer comprehensive virtual viewings, detailed photos, video calls, and neighborhood insights to help you make informed decisions remotely.</p>
                    </div>
                </div>
            </div>

            <!-- Step 4 -->
            <div class="bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition-shadow border border-gray-100">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-orange-500 rounded-xl flex items-center justify-center flex-shrink-0 text-white text-xl font-bold shadow-lg">4</div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Secure Payment & Documentation</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">Make payment via bank transfer to our secure First Bank account. We offer flexible payment plans including one-time, monthly, quarterly, and annual schedules with up to 36 installments. Our team handles all legal documentation, title verification, and transfer processes.</p>
                    </div>
                </div>
            </div>

            <!-- Step 5 -->
            <div class="bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition-shadow border border-gray-100">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-orange-500 rounded-xl flex items-center justify-center flex-shrink-0 text-white text-xl font-bold shadow-lg">5</div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Move In or Start Earning Returns</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">Once payment is confirmed, take possession of your property or start earning returns on your investment. For rental properties, move in on your scheduled date. For investment properties, begin receiving ROI payments according to your agreed schedule.</p>
                    </div>
                </div>
            </div>

            <!-- CTA Box -->
            <div class="bg-gradient-to-br from-orange-500 to-yellow-500 rounded-xl p-6 shadow-md flex flex-col items-center justify-center text-center">
                <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center mb-3">
                    <i class="bi bi-headset text-white text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-white mb-2">Need Help?</h3>
                <p class="text-white/90 text-sm mb-4">Our team is ready to guide you through every step</p>
                <a href="tel:+2348164856758" class="inline-flex items-center gap-2 bg-white text-orange-600 px-6 py-2.5 rounded-lg font-semibold hover:bg-orange-50 transition-colors shadow-lg">
                    <i class="bi bi-telephone-fill"></i>
                    Call +234 816 485 6758
                </a>
            </div>
        </div>

        <!-- GEO Content: Service Areas -->
        <div class="mt-12 bg-white rounded-xl p-8 shadow-md border border-gray-100">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Real Estate Services Across Nigeria</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                <div class="flex items-center gap-2 p-2 bg-orange-50 rounded-lg">
                    <i class="bi bi-check-circle-fill text-orange-500 text-sm"></i>
                    <span class="text-sm text-gray-700 font-medium">Anambra State</span>
                </div>
                <div class="flex items-center gap-2 p-2 bg-orange-50 rounded-lg">
                    <i class="bi bi-check-circle-fill text-orange-500 text-sm"></i>
                    <span class="text-sm text-gray-700 font-medium">Enugu State</span>
                </div>
                <div class="flex items-center gap-2 p-2 bg-orange-50 rounded-lg">
                    <i class="bi bi-check-circle-fill text-orange-500 text-sm"></i>
                    <span class="text-sm text-gray-700 font-medium">Delta State</span>
                </div>
                <div class="flex items-center gap-2 p-2 bg-orange-50 rounded-lg">
                    <i class="bi bi-check-circle-fill text-orange-500 text-sm"></i>
                    <span class="text-sm text-gray-700 font-medium">Imo State</span>
                </div>
                <div class="flex items-center gap-2 p-2 bg-orange-50 rounded-lg">
                    <i class="bi bi-check-circle-fill text-orange-500 text-sm"></i>
                    <span class="text-sm text-gray-700 font-medium">Ebonyi State</span>
                </div>
                <div class="flex items-center gap-2 p-2 bg-orange-50 rounded-lg">
                    <i class="bi bi-check-circle-fill text-orange-500 text-sm"></i>
                    <span class="text-sm text-gray-700 font-medium">Abia State</span>
                </div>
                <div class="flex items-center gap-2 p-2 bg-orange-50 rounded-lg">
                    <i class="bi bi-check-circle-fill text-orange-500 text-sm"></i>
                    <span class="text-sm text-gray-700 font-medium">Rivers State</span>
                </div>
                <div class="flex items-center gap-2 p-2 bg-orange-50 rounded-lg">
                    <i class="bi bi-check-circle-fill text-orange-500 text-sm"></i>
                    <span class="text-sm text-gray-700 font-medium">Lagos State</span>
                </div>
                <div class="flex items-center gap-2 p-2 bg-orange-50 rounded-lg">
                    <i class="bi bi-check-circle-fill text-orange-500 text-sm"></i>
                    <span class="text-sm text-gray-700 font-medium">Abuja (FCT)</span>
                </div>
                <div class="flex items-center gap-2 p-2 bg-orange-50 rounded-lg">
                    <i class="bi bi-check-circle-fill text-orange-500 text-sm"></i>
                    <span class="text-sm text-gray-700 font-medium">All South East Nigeria</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Added new Frequently Asked Questions section -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4" style="max-width: 1000px;">
        <div class="text-center mb-12">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Frequently Asked Questions</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Everything you need to know about B-Family Homes Limited
            </p>
        </div>

        <div class="space-y-4">
            <!-- FAQ 1 -->
            <div class="faq-item bg-gray-50 rounded-lg overflow-hidden">
                <button class="faq-question w-full text-left px-6 py-5 flex items-center justify-between hover:bg-gray-100 transition-colors">
                    <span class="font-semibold text-gray-900 pr-8">What does B-Family Homes Limited do?</span>
                    <i class="bi bi-chevron-down text-xl text-orange-500 flex-shrink-0 transition-transform"></i>
                </button>
                <div class="faq-answer hidden px-6 pb-5">
                    <p class="text-gray-600 leading-relaxed">
                        We are a trusted real estate and construction company specializing in: Land sales, Property development, House construction, Rental properties, and Real estate investment solutions.
                    </p>
                </div>
            </div>

            <!-- FAQ 2 -->
            <div class="faq-item bg-gray-50 rounded-lg overflow-hidden">
                <button class="faq-question w-full text-left px-6 py-5 flex items-center justify-between hover:bg-gray-100 transition-colors">
                    <span class="font-semibold text-gray-900 pr-8">Where are your properties located?</span>
                    <i class="bi bi-chevron-down text-xl text-orange-500 flex-shrink-0 transition-transform"></i>
                </button>
                <div class="faq-answer hidden px-6 pb-5">
                    <p class="text-gray-600 leading-relaxed">
                        Our properties are currently located in: Awkuzu, Ebenebe, Umuobi, and other fast-growing areas across Anambra State.
                    </p>
                </div>
            </div>

            <!-- FAQ 3 -->
            <div class="faq-item bg-gray-50 rounded-lg overflow-hidden">
                <button class="faq-question w-full text-left px-6 py-5 flex items-center justify-between hover:bg-gray-100 transition-colors">
                    <span class="font-semibold text-gray-900 pr-8">Are your lands genuine and documented?</span>
                    <i class="bi bi-chevron-down text-xl text-orange-500 flex-shrink-0 transition-transform"></i>
                </button>
                <div class="faq-answer hidden px-6 pb-5">
                    <p class="text-gray-600 leading-relaxed">
                        Yes. All our lands come with: Survey Plan, Deed of Assignment, and other relevant legal documents. We also guide clients through proper verification and documentation.
                    </p>
                </div>
            </div>

            <!-- FAQ 4 -->
            <div class="faq-item bg-gray-50 rounded-lg overflow-hidden">
                <button class="faq-question w-full text-left px-6 py-5 flex items-center justify-between hover:bg-gray-100 transition-colors">
                    <span class="font-semibold text-gray-900 pr-8">I live abroad. Can I still invest with you?</span>
                    <i class="bi bi-chevron-down text-xl text-orange-500 flex-shrink-0 transition-transform"></i>
                </button>
                <div class="faq-answer hidden px-6 pb-5">
                    <p class="text-gray-600 leading-relaxed">
                        We work with clients in the diaspora. We send real-time construction updates, allow site inspections anytime, and secure all investments legally and transparently.
                    </p>
                </div>
            </div>

            <!-- FAQ 5 -->
            <div class="faq-item bg-gray-50 rounded-lg overflow-hidden">
                <button class="faq-question w-full text-left px-6 py-5 flex items-center justify-between hover:bg-gray-100 transition-colors">
                    <span class="font-semibold text-gray-900 pr-8">What is your 50/50 Building Plan?</span>
                    <i class="bi bi-chevron-down text-xl text-orange-500 flex-shrink-0 transition-transform"></i>
                </button>
                <div class="faq-answer hidden px-6 pb-5">
                    <p class="text-gray-600 leading-relaxed">
                        Our 50/50 Building Plan allows clients to: Pay 50% of the project cost upfront, We begin construction immediately, You spread the remaining balance over time, and You only move in when full payment is completed.
                    </p>
                </div>
            </div>

            <!-- FAQ 6 -->
            <div class="faq-item bg-gray-50 rounded-lg overflow-hidden">
                <button class="faq-question w-full text-left px-6 py-5 flex items-center justify-between hover:bg-gray-100 transition-colors">
                    <span class="font-semibold text-gray-900 pr-8">Do you offer payment plans for land?</span>
                    <i class="bi bi-chevron-down text-xl text-orange-500 flex-shrink-0 transition-transform"></i>
                </button>
                <div class="faq-answer hidden px-6 pb-5">
                    <p class="text-gray-600 leading-relaxed">
                        Yes. We offer: Outright payment and Flexible installment plans (depending on the location and project).
                    </p>
                </div>
            </div>

            <!-- FAQ 7 -->
            <div class="faq-item bg-gray-50 rounded-lg overflow-hidden">
                <button class="faq-question w-full text-left px-6 py-5 flex items-center justify-between hover:bg-gray-100 transition-colors">
                    <span class="font-semibold text-gray-900 pr-8">Do you work with professional engineers and builders?</span>
                    <i class="bi bi-chevron-down text-xl text-orange-500 flex-shrink-0 transition-transform"></i>
                </button>
                <div class="faq-answer hidden px-6 pb-5">
                    <p class="text-gray-600 leading-relaxed">
                        Yes. We proudly partner with OJB Construction, supported by: Certified engineers, Skilled builders, and Qualified site supervisors.
                    </p>
                </div>
            </div>

            <!-- FAQ 8 - Refund Policy -->
            <div class="faq-item bg-gray-50 rounded-lg overflow-hidden">
                <button class="faq-question w-full text-left px-6 py-5 flex items-center justify-between hover:bg-gray-100 transition-colors">
                    <span class="font-semibold text-gray-900 pr-8">What is your refund policy?</span>
                    <i class="bi bi-chevron-down text-xl text-orange-500 flex-shrink-0 transition-transform"></i>
                </button>
                <div class="faq-answer hidden px-6 pb-5">
                    <div class="text-gray-600 leading-relaxed space-y-3">
                        <p>Our refund policy is designed to be fair and transparent:</p>
                        <ul class="list-disc list-inside space-y-2 ml-4">
                            <li>A client who requests a refund within 7 days of payment is eligible for a 100% refund if no documentation has been processed.</li>
                            <li>Refunds requested after documentation has begun may attract administrative charges.</li>
                            <li>If the allocation given is unavailable due to company error, the client will receive either: A full refund with no deductions OR A new allocation of equal or higher value.</li>
                            <li>Refunds are processed within 14–21 working days after request submission.</li>
                            <li>All refund requests must be submitted with proof of payment and a valid ID.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- FAQ 9 -->
            <div class="faq-item bg-gray-50 rounded-lg overflow-hidden">
                <button class="faq-question w-full text-left px-6 py-5 flex items-center justify-between hover:bg-gray-100 transition-colors">
                    <span class="font-semibold text-gray-900 pr-8">How can I contact B-Family Homes Limited?</span>
                    <i class="bi bi-chevron-down text-xl text-orange-500 flex-shrink-0 transition-transform"></i>
                </button>
                <div class="faq-answer hidden px-6 pb-5">
                    <div class="text-gray-600 leading-relaxed space-y-2">
                        <p><strong>Phone:</strong> <a href="tel:+2348164856758" class="text-orange-500 hover:text-orange-600">+234 816 485 6758</a></p>
                        <p><strong>Email:</strong> <a href="mailto:admin@bfamilyhomes.com" class="text-orange-500 hover:text-orange-600">admin@bfamilyhomes.com</a></p>
                        <p><strong>Location:</strong> Awkuzu, Anambra State</p>
                        <div class="flex gap-3 mt-3">
                            <a href="https://www.facebook.com/share/1DDk8U2Yhd/" target="_blank" class="text-orange-500 hover:text-orange-600">
                                <i class="bi bi-facebook text-2xl"></i>
                            </a>
                            <a href="https://www.instagram.com/b_familyhomes" target="_blank" class="text-orange-500 hover:text-orange-600">
                                <i class="bi bi-instagram text-2xl"></i>
                            </a>
                            <a href="https://www.tiktok.com/@b_family.homes" target="_blank" class="text-orange-500 hover:text-orange-600">
                                <i class="bi bi-tiktok text-2xl"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-12">
            <p class="text-gray-600 mb-4">Still have questions?</p>
            <a href="tel:+2348164856758" class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white px-8 py-3 rounded-lg font-semibold transition-all duration-300 hover:scale-105 shadow-lg hover:shadow-xl">
                <i class="bi bi-telephone"></i>
                Contact Us
            </a>
        </div>
    </div>
</section>

@push('schemas')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "FAQPage",
    "mainEntity": [
        {
            "@type": "Question",
            "name": "What types of properties does B-Family Homes offer?",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "B-Family Homes offers properties for sale, rent, and investment across Anambra State, Enugu, Delta, Imo, Ebonyi, Abia, Rivers, Lagos, Abuja, and all Nigeria. Our portfolio includes land, apartments (1-3 bedroom), duplexes, and commercial properties."
            }
        },
        {
            "@type": "Question",
            "name": "Where is B-Family Homes located?",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "B-Family Homes Limited is located at No1, Ananti Jerry Chijioke Street, Awkuzu, Anambra State, Nigeria. We serve clients across Anambra, Enugu, Delta, Imo, Ebonyi, Abia, Rivers, Lagos, Abuja, and all Nigeria."
            }
        },
        {
            "@type": "Question",
            "name": "Can diaspora Nigerians invest in properties with B-Family Homes?",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "Yes, B-Family Homes welcomes diaspora Nigerians looking to invest in real estate back home. We provide full support for remote property investment, including virtual tours, digital documentation, and secure payment processing. Whether you are in the US, UK, Canada, or anywhere in the world, you can buy, rent, or invest in Nigerian properties."
            }
        },
        {
            "@type": "Question",
            "name": "How do I book a property inspection?",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "You can book a property inspection by logging into your B-Family Homes dashboard, navigating to any property page, and using the 'Book Inspection' form. You can also book via WhatsApp at +234 816 485 6758 for a faster response."
            }
        },
        {
            "@type": "Question",
            "name": "What areas in South East Nigeria do you serve?",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "B-Family Homes serves all South East Nigeria, including Anambra State (Awkuzu, Onitsha, Awka, Nnewi, Ekwulobia, Oba), Enugu State (Enugu city, Nsukka), Imo State (Owerri, Orlu), Abia State (Umuahia, Aba), Ebonyi State (Abakaliki), and Delta State (Asaba, Warri). We also have properties in Rivers State, Lagos, and Abuja."
            }
        },
        {
            "@type": "Question",
            "name": "What is the minimum investment amount for real estate investment with B-Family Homes?",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "The minimum investment amount with B-Family Homes is ₦100,000. We offer flexible investment plans with attractive returns. Contact us for current ROI percentages and available investment properties."
            }
        },
        {
            "@type": "Question",
            "name": "How can I pay for a property?",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "We accept payments via bank transfer to our First Bank account (Account Name: B-Family Homes Limited, Account Number: 2046980791). We also offer flexible payment plans, including one-time, monthly, quarterly, and annual schedules with up to 36 installments."
            }
        },
        {
            "@type": "Question",
            "name": "Are properties listed by B-Family Homes verified?",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "Yes, all properties listed by B-Family Homes are verified. We ensure proper documentation, clear titles, and accurate property information before listing. Our team conducts thorough due diligence on every property to protect our clients' investments."
            }
        },
        {
            "@type": "Question",
            "name": "How do I start the process of buying a home in Anambra State?",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "To buy a home in Anambra State with B-Family Homes: 1) Browse our properties online, 2) Contact us or book an inspection, 3) Visit the property or take a virtual tour, 4) Make an offer and complete payment, 5) We handle documentation and legal transfer. Our team guides you through every step."
            }
        }
    ]
}
</script>
@endpush

@endsection

@push('styles')
<!-- Swiper.js CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<style>
    /* Animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-50px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(50px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes bounceSlow {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
    }

    /* Added blinking cursor animation for typing effect */
    @keyframes blink {
        0%, 49% {
            opacity: 1;
        }
        50%, 100% {
            opacity: 0;
        }
    }

    .animate-blink {
        animation: blink 1s infinite;
    }

    .animate-fade-in {
        animation: fadeIn 1s ease-out;
    }

    .animate-slide-up {
        animation: slideUp 0.8s ease-out;
    }

    .animate-slide-up-delay {
        animation: slideUp 0.8s ease-out 0.2s both;
    }

    .animate-slide-up-delay-2 {
        animation: slideUp 0.8s ease-out 0.4s both;
    }

    .animate-fade-in-left {
        animation: slideInLeft 1s ease-out;
    }

    .animate-fade-in-right {
        animation: slideInRight 1s ease-out;
    }

    .animate-fade-in-up {
        animation: slideUp 0.6s ease-out both;
    }

    .animate-bounce-slow {
        animation: bounceSlow 3s ease-in-out infinite;
    }

    /* Icon Animations */
    @keyframes float {
        0%, 100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-10px);
        }
    }

    @keyframes floatDelay {
        0%, 100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-12px);
        }
    }

    @keyframes pulseSlow {
        0%, 100% {
            opacity: 1;
            transform: scale(1);
        }
        50% {
            opacity: 0.8;
            transform: scale(1.05);
        }
    }

    .animate-float {
        animation: float 3s ease-in-out infinite;
    }

    .animate-float-delay {
        animation: floatDelay 3s ease-in-out infinite;
        animation-delay: 0.5s;
    }

    .animate-float-delay-2 {
        animation: floatDelay 3s ease-in-out infinite;
        animation-delay: 1s;
    }

    .animate-float-delay-3 {
        animation: floatDelay 3s ease-in-out infinite;
        animation-delay: 1.5s;
    }

    .animate-pulse-slow {
        animation: pulseSlow 2s ease-in-out infinite;
    }

    .feature-card {
        position: relative;
    }

    .feature-card:hover .icon-container {
        transform: scale(1.1) rotate(5deg);
    }

    .icon-container {
        transition: all 0.3s ease;
    }

    /* Intersection Observer for scroll animations */
    .fade-in-on-scroll {
        opacity: 0;
        transform: translateY(30px);
        transition: opacity 0.6s ease-out, transform 0.6s ease-out;
    }

    .fade-in-on-scroll.visible {
        opacity: 1;
        transform: translateY(0);
    }

    /* Responsive slider items - will be set by JavaScript */
    .latest-property-item,
    .featured-property-item {
        flex-shrink: 0;
    }
    
    /* Featured Properties Swiper Customization */
    .featured-properties-swiper {
        padding: 0 0 40px 0;
    }
    
    .featured-properties-swiper .swiper-slide {
        height: auto;
    }
    
    .featured-swiper-prev,
    .featured-swiper-next {
        background: white;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        transition: all 0.3s;
    }
    
    .featured-swiper-prev:hover,
    .featured-swiper-next:hover {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        transform: scale(1.05);
    }
    
    .featured-swiper-prev::after,
    .featured-swiper-next::after {
        font-size: 20px;
        font-weight: bold;
        color: #ea580c;
    }
    
    .featured-swiper-prev {
        left: -16px;
    }
    
    .featured-swiper-next {
        right: -16px;
    }
    
    @media (max-width: 1023px) {
        .featured-swiper-prev,
        .featured-swiper-next {
            display: none !important;
        }
    }
</style>
@endpush

@push('scripts')
<!-- Swiper.js JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    (function() {
        const texts = [
            "Find Your Best Property",
            "Discover Your Dream Home",
            "Invest in Real Estate",
            "Premium Properties Await"
        ];
        const typingElement = document.getElementById('typingText');
        const cursorElement = document.getElementById('cursor');
        
        if (!typingElement) return;
        
        let textIndex = 0;
        let charIndex = 0;
        let isDeleting = false;
        
        function typeText() {
            const currentText = texts[textIndex];
            
            if (isDeleting) {
                // Delete characters
                typingElement.textContent = currentText.substring(0, charIndex - 1);
                charIndex--;
                
                if (charIndex === 0) {
                    isDeleting = false;
                    textIndex = (textIndex + 1) % texts.length;
                    setTimeout(typeText, 500); // Pause before typing next text
                    return;
                }
                
                setTimeout(typeText, 50); // Faster deletion
            } else {
                // Type characters
                typingElement.textContent = currentText.substring(0, charIndex + 1);
                charIndex++;
                
                if (charIndex === currentText.length) {
                    // Finished typing, wait then start deleting
                    setTimeout(() => {
                        isDeleting = true;
                        typeText();
                    }, 2000); // Wait 2 seconds before deleting
                    return;
                }
                
                setTimeout(typeText, 100); // Typing speed
            }
        }
        
        // Start typing after a brief delay
        setTimeout(typeText, 500);
    })();

    // Initialize autocomplete for location
    if (window.initAutocomplete) {
        window.initAutocomplete('searchLocation', 'locationSuggestions', '{{ route("properties.autocomplete") }}?type=location');
        
        // Initialize autocomplete for keyword search
        const keywordInput = document.getElementById('searchKeyword');
        const keywordSuggestions = document.getElementById('keywordSuggestions');
        
        if (keywordInput && keywordSuggestions) {
            let keywordTimeout;
            
            keywordInput.addEventListener('input', function() {
                clearTimeout(keywordTimeout);
                const query = this.value.trim();
                
                if (query.length < 2) {
                    keywordSuggestions.innerHTML = '';
                    keywordSuggestions.classList.add('hidden');
                    return;
                }
                
                keywordTimeout = setTimeout(async () => {
                    try {
                        const data = await window.ajax(`{{ route("properties.autocomplete") }}?q=${encodeURIComponent(query)}&type=keyword`);
                        displayKeywordSuggestions(data.suggestions || []);
                    } catch (error) {
                        console.error('Autocomplete error:', error);
                    }
                }, 300);
            });
            
            function displayKeywordSuggestions(items) {
                if (items.length === 0) {
                    keywordSuggestions.innerHTML = '';
                    keywordSuggestions.classList.add('hidden');
                    return;
                }
                
                keywordSuggestions.innerHTML = items
                    .map(item => `
                        <div class="p-3 hover:bg-gray-100 cursor-pointer border-b border-gray-100 last:border-0" data-value="${item.value}">
                            <div class="font-semibold text-gray-900">${item.label}</div>
                            ${item.type === 'property' ? '<div class="text-xs text-gray-500 mt-1">Property</div>' : ''}
                        </div>
                    `)
                    .join('');
                
                keywordSuggestions.classList.remove('hidden');
                
                keywordSuggestions.querySelectorAll('div').forEach(div => {
                    div.addEventListener('click', function() {
                        keywordInput.value = this.dataset.value;
                        keywordSuggestions.innerHTML = '';
                        keywordSuggestions.classList.add('hidden');
                    });
                });
            }
            
            document.addEventListener('click', (e) => {
                if (!keywordInput.contains(e.target) && !keywordSuggestions.contains(e.target)) {
                    keywordSuggestions.innerHTML = '';
                    keywordSuggestions.classList.add('hidden');
                }
            });
        }
    }

    // Handle search form
    document.getElementById('propertySearchForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(e.target);
        const params = new URLSearchParams(formData);
        window.location.href = '{{ route("properties.index") }}?' + params.toString();
    });

    // Scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, observerOptions);

    document.querySelectorAll('.fade-in-on-scroll').forEach(el => {
        observer.observe(el);
    });

    // Categories Slider with Auto-slide
    (function() {
        const track = document.querySelector('.categories-track');
        const prevBtn = document.querySelector('.categories-prev');
        const nextBtn = document.querySelector('.categories-next');
        if (!track) return;
        
        const items = document.querySelectorAll('.categories-slider .flex-shrink-0');
        if (items.length === 0) return;
        
        let currentIndex = 0;
        let itemsPerView = window.innerWidth >= 1024 ? 4 : window.innerWidth >= 768 ? 3 : 2;
        let autoSlideInterval;

        function getItemsPerView() {
            if (window.innerWidth >= 1024) return 4;
            if (window.innerWidth >= 768) return 3;
            if (window.innerWidth >= 640) return 2;
            return 1;
        }

        function updateSlider() {
            if (!items[0]) return;
            const itemWidth = items[0].offsetWidth || 280;
            const gap = window.innerWidth >= 768 ? 24 : 16;
            const translateX = -(currentIndex * (itemWidth + gap));
            track.style.transform = `translateX(${translateX}px)`;
        }

        function nextSlide() {
            itemsPerView = getItemsPerView();
            const maxIndex = Math.max(0, items.length - itemsPerView);
            if (currentIndex < maxIndex) {
                currentIndex++;
            } else {
                currentIndex = 0; // Loop back to start
            }
            updateSlider();
        }

        function prevSlide() {
            if (currentIndex > 0) {
                currentIndex--;
            } else {
                itemsPerView = getItemsPerView();
                const maxIndex = Math.max(0, items.length - itemsPerView);
                currentIndex = maxIndex; // Loop to end
            }
            updateSlider();
        }

        // Only show navigation if there are more items than can be displayed
        function checkNavigation() {
            itemsPerView = getItemsPerView();
            const shouldShowNav = items.length > itemsPerView;
            
            if (prevBtn) prevBtn.style.display = shouldShowNav ? 'flex' : 'none';
            if (nextBtn) nextBtn.style.display = shouldShowNav ? 'flex' : 'none';
        }

        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                clearInterval(autoSlideInterval);
                prevSlide();
                startAutoSlide();
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                clearInterval(autoSlideInterval);
                nextSlide();
                startAutoSlide();
            });
        }

        function startAutoSlide() {
            clearInterval(autoSlideInterval);
            itemsPerView = getItemsPerView();
            if (items.length > itemsPerView) {
                autoSlideInterval = setInterval(nextSlide, 4000); // Auto-slide every 4 seconds
            }
        }

        window.addEventListener('resize', () => {
            itemsPerView = getItemsPerView();
            checkNavigation();
            updateSlider();
        });

        // Initialize
        checkNavigation();
        updateSlider();
        startAutoSlide();
    })();


    // Featured Properties Slider using Swiper.js
    // Desktop: No slider if <= 4 items, special behavior for 5 items
    // Mobile: Slider if > 1 item
    (function() {
        // Wait for DOM and Swiper to be ready
        function initFeaturedSwiper() {
            if (typeof Swiper === 'undefined') {
                setTimeout(initFeaturedSwiper, 100);
                return;
            }
            
            const swiperEl = document.querySelector('.featured-properties-swiper');
            if (!swiperEl) return;
            
            const totalItems = swiperEl.querySelectorAll('.swiper-slide').length;
            const isDesktop = window.innerWidth >= 1024;
            
            // Desktop: If items <= 4, don't initialize slider
            if (isDesktop && totalItems <= 4) {
                return;
            }
            
            // Mobile: If items <= 1, don't initialize slider
            if (!isDesktop && totalItems <= 1) {
                return;
            }
            
            // Determine slides per view
            let slidesPerView = isDesktop ? 4 : 1;
            let spaceBetween = 24;
            
            // Special handling for 5 items on desktop
            let hasSlidOnce = false;
            
            // Initialize Swiper
            const swiper = new Swiper('.featured-properties-swiper', {
            slidesPerView: slidesPerView,
            spaceBetween: spaceBetween,
            navigation: {
                nextEl: '.featured-swiper-next',
                prevEl: '.featured-swiper-prev',
            },
            breakpoints: {
                320: {
                    slidesPerView: 1,
                    spaceBetween: 16,
                },
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 24,
                }
            },
            // Prevent sliding beyond what should be visible
            watchOverflow: true,
            // For 5 items on desktop, limit sliding
            on: {
                slideChange: function() {
                    const isDesktopNow = window.innerWidth >= 1024;
                    
                    // Special handling for exactly 5 items on desktop
                    if (isDesktopNow && totalItems === 5) {
                        // If we're at slide 1 (showing items 2-5), mark as slid once
                        if (this.activeIndex === 1) {
                            hasSlidOnce = true;
                        } else if (this.activeIndex === 0) {
                            hasSlidOnce = false;
                        }
                        
                        // Prevent going beyond slide 1
                        if (this.activeIndex > 1) {
                            this.slideTo(1);
                        }
                    }
                },
                reachEnd: function() {
                    // For 5 items on desktop, if we reach end, go back to start
                    const isDesktopNow = window.innerWidth >= 1024;
                    if (isDesktopNow && totalItems === 5 && hasSlidOnce) {
                        setTimeout(() => {
                            this.slideTo(0);
                            hasSlidOnce = false;
                        }, 500);
                    }
                }
            }
        });
        
        // Auto-slide functionality
        let autoSlideInterval;
        
        function startAutoSlide() {
            clearInterval(autoSlideInterval);
            const isDesktopNow = window.innerWidth >= 1024;
            
            let shouldAutoSlide = false;
            if (isDesktopNow) {
                shouldAutoSlide = totalItems > 4;
            } else {
                shouldAutoSlide = totalItems > 1;
            }
            
            if (shouldAutoSlide) {
                autoSlideInterval = setInterval(() => {
                    const isDesktopNow = window.innerWidth >= 1024;
                    
                    // Special handling for 5 items on desktop
                    if (isDesktopNow && totalItems === 5) {
                        if (!hasSlidOnce) {
                            swiper.slideNext();
                            hasSlidOnce = true;
                        } else {
                            swiper.slideTo(0);
                            hasSlidOnce = false;
                        }
                    } else {
                        if (swiper.isEnd) {
                            swiper.slideTo(0);
                        } else {
                            swiper.slideNext();
                        }
                    }
                }, 5000);
            }
        }
        
        // Handle resize
        let resizeTimeout;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                const isDesktopNow = window.innerWidth >= 1024;
                
                if (wasDesktop !== isDesktopNow) {
                    hasSlidOnce = false;
                    swiper.slideTo(0);
                }
                
                // Update navigation visibility
                const shouldShowNav = isDesktopNow ? totalItems > 4 : totalItems > 1;
                const prevBtn = document.querySelector('.featured-swiper-prev');
                const nextBtn = document.querySelector('.featured-swiper-next');
                
                if (prevBtn) prevBtn.style.display = shouldShowNav ? 'flex' : 'none';
                if (nextBtn) nextBtn.style.display = shouldShowNav ? 'flex' : 'none';
                
                startAutoSlide();
            }, 150);
        });
        
        // Initial navigation visibility
        const shouldShowNav = isDesktop ? totalItems > 4 : totalItems > 1;
        const prevBtn = document.querySelector('.featured-swiper-prev');
        const nextBtn = document.querySelector('.featured-swiper-next');
        
        if (prevBtn) prevBtn.style.display = shouldShowNav ? 'flex' : 'none';
        if (nextBtn) nextBtn.style.display = shouldShowNav ? 'flex' : 'none';
        
        // Start auto-slide
        startAutoSlide();
        }
        
        // Initialize when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initFeaturedSwiper);
        } else {
            initFeaturedSwiper();
        }
    })();

    // Counter Animation for Statistics
    (function() {
        const counters = document.querySelectorAll('.counter-value');
        if (counters.length === 0) return;

        const animateCounter = (counter) => {
            const target = parseInt(counter.getAttribute('data-target'));
            const duration = 2000; // 2 seconds
            const increment = target / (duration / 16); // 60fps
            let current = 0;

            const updateCounter = () => {
                current += increment;
                if (current < target) {
                    counter.textContent = Math.floor(current).toLocaleString();
                    requestAnimationFrame(updateCounter);
                } else {
                    counter.textContent = target.toLocaleString();
                }
            };

            updateCounter();
        };

        const observerOptions = {
            threshold: 0.5,
            rootMargin: '0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !entry.target.classList.contains('counted')) {
                    entry.target.classList.add('counted');
                    animateCounter(entry.target);
                }
            });
        }, observerOptions);

        counters.forEach(counter => {
            observer.observe(counter);
        });
    })();

    // Testimonials Slider - Updated for single image display
    (function() {
        const container = document.getElementById('testimonialsContainer');
        const slides = document.querySelectorAll('.testimonial-slide');
        const prevBtn = document.querySelector('.testimonial-prev');
        const nextBtn = document.querySelector('.testimonial-next');
        if (!container || !slides.length) return;
        
        let currentIndex = 0;

        function updateTestimonials() {
            container.style.transform = `translateX(-${currentIndex * 100}%)`;
        }

        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                if (currentIndex > 0) {
                    currentIndex--;
                } else {
                    currentIndex = slides.length - 1;
                }
                updateTestimonials();
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                if (currentIndex < slides.length - 1) {
                    currentIndex++;
                } else {
                    currentIndex = 0;
                }
                updateTestimonials();
            });
        }

        // Auto-play testimonials
        if (slides.length > 1) {
            setInterval(() => {
                if (currentIndex < slides.length - 1) {
                    currentIndex++;
                } else {
                    currentIndex = 0;
                }
                updateTestimonials();
            }, 5000);
        }

        // Initialize
        updateTestimonials();
    })();

    (function() {
        const faqItems = document.querySelectorAll('.faq-item');
        
        faqItems.forEach(item => {
            const question = item.querySelector('.faq-question');
            const answer = item.querySelector('.faq-answer');
            const icon = question.querySelector('i');
            
            question.addEventListener('click', () => {
                const isOpen = !answer.classList.contains('hidden');
                
                // Close all other items
                faqItems.forEach(otherItem => {
                    const otherAnswer = otherItem.querySelector('.faq-answer');
                    const otherIcon = otherItem.querySelector('.faq-question i');
                    otherAnswer.classList.add('hidden');
                    otherIcon.style.transform = 'rotate(0deg)';
                });
                
                // Toggle current item
                if (!isOpen) {
                    answer.classList.remove('hidden');
                    icon.style.transform = 'rotate(180deg)';
                } else {
                    answer.classList.add('hidden');
                    icon.style.transform = 'rotate(0deg)';
                }
            });
        });
    })();

    // Best Property Collections Filter
    (function() {
        const filterButtons = document.querySelectorAll('.collection-filter-btn');
        const filterContents = document.querySelectorAll('.collection-filter-content');
        if (!filterButtons.length) return;

        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                const filter = button.getAttribute('data-filter');

                // Update button styles
                filterButtons.forEach(btn => {
                    btn.classList.remove('active');
                    btn.style.background = '';
                    btn.style.color = '';
                    btn.className = 'collection-filter-btn px-6 py-2 rounded-lg font-semibold transition-all bg-gray-200 hover:bg-gray-300 text-gray-700';
                });
                
                button.classList.add('active');
                button.style.background = 'linear-gradient(135deg, #f97316 0%, #ea580c 100%)';
                button.style.color = 'white';

                // Show/hide content
                filterContents.forEach(content => {
                    if (content.getAttribute('data-content') === filter) {
                        content.classList.remove('hidden');
                    } else {
                        content.classList.add('hidden');
                    }
                });
            });
        });
    })();

    // WhatsApp Inspection Booking Form
    document.getElementById('whatsappInspectionForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const form = e.target;
        const formData = new FormData(form);
        
        const name = formData.get('name');
        const phone = formData.get('phone');
        const propertyInterest = formData.get('property_interest') || 'General Property Inquiry';
        const preferredDate = formData.get('preferred_date') || 'Not specified';
        const preferredTime = formData.get('preferred_time') || 'Not specified';
        const message = formData.get('message') || '';
        
        // Build WhatsApp message
        let whatsappMessage = `Hello! I would like to book a property inspection.\n\n`;
        whatsappMessage += `*Name:* ${name}\n`;
        whatsappMessage += `*Phone:* ${phone}\n`;
        whatsappMessage += `*Property Interest:* ${propertyInterest}\n`;
        whatsappMessage += `*Preferred Date:* ${preferredDate}\n`;
        whatsappMessage += `*Preferred Time:* ${preferredTime}\n`;
        if (message) {
            whatsappMessage += `*Message:* ${message}\n`;
        }
        whatsappMessage += `\nPlease confirm availability and provide further details. Thank you!`;
        
        // Get WhatsApp number from config
        const whatsappNumber = '{{ config("bfamily.company.whatsapp") }}';
        
        // Send to WhatsApp
        if (window.sendToWhatsApp) {
            window.sendToWhatsApp(whatsappNumber, whatsappMessage);
            if (window.toast) {
                window.toast('Opening WhatsApp...', 'success');
            }
            // Reset form after a delay
            setTimeout(() => {
                form.reset();
            }, 1000);
        } else {
            // Fallback: direct WhatsApp link
            const url = `https://wa.me/${whatsappNumber.replace(/[^0-9]/g, '')}?text=${encodeURIComponent(whatsappMessage)}`;
            window.open(url, '_blank');
        }
    });
</script>

<!-- Promotion Overlay Script -->
@if(isset($promotion) && $promotion)
<script>
    // Check if promotion was already closed in this session
    const promotionClosed = sessionStorage.getItem('promotion_closed_{{ $promotion->id }}');
    
    if (!promotionClosed) {
        // Load promotion image only after preloader is gone
        // This ensures preloader doesn't wait for promotion image
        (function() {
            function loadAndShowPromotion() {
                const overlay = document.getElementById('promotionOverlay');
                const img = document.getElementById('promotionImage');
                
                if (!overlay || !img) return;
                
                // Load the image only when we're about to show the overlay
                const imgSrc = img.getAttribute('data-src');
                const placeholder = document.getElementById('promotionPlaceholder');
                
                if (imgSrc) {
                    img.onload = function() {
                        // Hide placeholder, show image
                        if (placeholder) placeholder.style.display = 'none';
                        img.style.display = 'block';
                    };
                    img.onerror = function() {
                        // If image fails to load, keep placeholder
                        console.error('Failed to load promotion image');
                        if (placeholder) placeholder.style.display = 'flex';
                    };
                    img.src = imgSrc;
                }
                
                // Show overlay after a delay (after preloader is gone)
                setTimeout(() => {
                    overlay.classList.remove('hidden');
                    overlay.style.opacity = '0';
                    setTimeout(() => {
                        overlay.style.transition = 'opacity 0.3s ease';
                        overlay.style.opacity = '1';
                    }, 10);
                }, 2000); // Show after 2 seconds (ensuring preloader is gone)
            }
            
            // Use DOMContentLoaded - don't wait for images
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', loadAndShowPromotion);
            } else {
                // DOM already loaded
                loadAndShowPromotion();
            }
        })();
    }

    function closePromotion() {
        const overlay = document.getElementById('promotionOverlay');
        if (overlay) {
            overlay.style.opacity = '0';
            setTimeout(() => {
                overlay.classList.add('hidden');
                // Remember that promotion was closed
                sessionStorage.setItem('promotion_closed_{{ $promotion->id }}', 'true');
            }, 300);
        }
    }

    // Close on outside click
    document.getElementById('promotionOverlay')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closePromotion();
        }
    });

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closePromotion();
        }
    });
</script>
@endif
@endpush

