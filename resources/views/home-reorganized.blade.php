@extends('layouts.app')

@section('title', 'B-Family Homes - Find Your Dream Property in Nigeria')
@section('description', 'Discover premium real estate in Nigeria. Buy, rent, or invest in properties with B-Family Homes Limited.')

@section('content')
<!-- Hero Section with Background Image -->
<!-- Added background-attachment: fixed and typing effect to header -->
<section class="relative py-24 md:py-32 overflow-hidden min-h-[600px] flex items-center">
    <!-- Background Image with fixed attachment -->
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat opacity-160" style="background-image: url('https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=1920&q=80'); background-attachment: fixed;"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-primary-900/90 via-primary-800/85 to-primary-900/90"></div>
    
    <div class="container mx-auto px-4 relative z-10" style="max-width: 1400px;">
        <div class="max-w-5xl mx-auto text-center text-white animate-fade-in">
            <!-- Typing Effect Header -->
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight animate-slide-up">
                <span id="typingText"></span><span id="cursor" class="inline-block w-1 h-12 bg-white ml-1 animate-blink"></span>
            </h1>
            <p class="text-lg md:text-xl mb-12 opacity-90 animate-slide-up-delay">
                Discover premium real estate properties tailored to your needs. Your dream property is just a search away.
            </p>

            <!-- Enhanced search form with better styling -->
            <div class="bg-white rounded-2xl shadow-2xl p-6 md:p-8 animate-slide-up-delay-2">
                <form id="propertySearchForm" class="space-y-4">
                    <!-- First Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="relative">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Property Name</label>
                            <input 
                                type="text" 
                                id="searchKeyword"
                                name="search" 
                                placeholder="Search properties..."
                                class="w-full px-4 py-3 text-gray-900 bg-gray-50 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-orange-500 focus:bg-white focus:ring-2 focus:ring-orange-100 transition-all duration-200 hover:border-gray-300"
                                autocomplete="off"
                            >
                            <div id="keywordSuggestions" class="hidden absolute top-full left-0 right-0 bg-white border border-gray-200 rounded-lg mt-1 shadow-lg z-50 max-h-60 overflow-y-auto"></div>
                        </div>

                        <div class="relative">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Location</label>
                            <input 
                                type="text" 
                                id="searchLocation"
                                name="location" 
                                placeholder="Enter location..."
                                class="w-full px-4 py-3 text-gray-900 bg-gray-50 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-orange-500 focus:bg-white focus:ring-2 focus:ring-orange-100 transition-all duration-200 hover:border-gray-300"
                                autocomplete="off"
                            >
                            <div id="locationSuggestions" class="hidden absolute top-full left-0 right-0 bg-white border border-gray-200 rounded-lg mt-1 shadow-lg z-50 max-h-60 overflow-y-auto"></div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Property Type</label>
                            <select name="type" class="w-full px-4 py-3 text-gray-900 bg-gray-50 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-orange-500 focus:bg-white focus:ring-2 focus:ring-orange-100 transition-all duration-200 hover:border-gray-300 cursor-pointer">
                                <option value="">All Types</option>
                                <option value="Rent">For Rent</option>
                                <option value="Sale">For Sale</option>
                                <option value="Investment">Investment</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Category</label>
                            <select name="category" class="w-full px-4 py-3 text-gray-900 bg-gray-50 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-orange-500 focus:bg-white focus:ring-2 focus:ring-orange-100 transition-all duration-200 hover:border-gray-300 cursor-pointer">
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
                    </div>

                    <!-- Second Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Bedrooms</label>
                            <select name="bedrooms" class="w-full px-4 py-3 text-gray-900 bg-gray-50 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-orange-500 focus:bg-white focus:ring-2 focus:ring-orange-100 transition-all duration-200 hover:border-gray-300 cursor-pointer">
                                <option value="">Any</option>
                                <option value="1">1 Bedroom</option>
                                <option value="2">2 Bedrooms</option>
                                <option value="3">3 Bedrooms</option>
                                <option value="4">4 Bedrooms</option>
                                <option value="5+">5+ Bedrooms</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Bathrooms</label>
                            <select name="bathrooms" class="w-full px-4 py-3 text-gray-900 bg-gray-50 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-orange-500 focus:bg-white focus:ring-2 focus:ring-orange-100 transition-all duration-200 hover:border-gray-300 cursor-pointer">
                                <option value="">Any</option>
                                <option value="1">1 Bathroom</option>
                                <option value="2">2 Bathrooms</option>
                                <option value="3">3 Bathrooms</option>
                                <option value="4+">4+ Bathrooms</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Min Price</label>
                            <input 
                                type="number" 
                                name="min_price" 
                                placeholder="Min Price (₦)"
                                class="w-full px-4 py-3 text-gray-900 bg-gray-50 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-orange-500 focus:bg-white focus:ring-2 focus:ring-orange-100 transition-all duration-200 hover:border-gray-300"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Max Price</label>
                            <input 
                                type="number" 
                                name="max_price" 
                                placeholder="Max Price (₦)"
                                class="w-full px-4 py-3 text-gray-900 bg-gray-50 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-orange-500 focus:bg-white focus:ring-2 focus:ring-orange-100 transition-all duration-200 hover:border-gray-300"
                            >
                        </div>

                        <div class="flex items-end">
                            <button type="submit" class="w-full h-[52px] bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-semibold rounded-lg shadow-md hover:shadow-xl transition-all duration-300 transform hover:scale-105 flex items-center justify-center gap-2">
                                <i class="bi bi-search"></i>
                                <span>Search</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Category Statistics -->
<!-- Ensured content is properly centralized -->
<section class="py-12 bg-white border-b">
    <div class="container mx-auto px-4" style="max-width: 1400px;">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Commercial Lands -->
            <div class="flex items-center justify-center gap-4 p-4 rounded-lg hover:shadow-md transition-all duration-300 hover:scale-105">
                <div class="w-16 h-16 bg-primary-600 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="bi bi-map text-2xl text-white"></i>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-bold text-gray-900">{{ number_format($categoryStats['commercial_lands']) }}</p>
                    <p class="text-sm text-gray-600">Commercial Lands</p>
                </div>
            </div>

            <!-- Showrooms & Shops -->
            <div class="flex items-center justify-center gap-4 p-4 rounded-lg hover:shadow-md transition-all duration-300 hover:scale-105">
                <div class="w-16 h-16 bg-accent rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="bi bi-shop text-2xl text-white"></i>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-bold text-gray-900">{{ number_format($categoryStats['showrooms_shops']) }}</p>
                    <p class="text-sm text-gray-600">Showrooms & Shops</p>
                </div>
            </div>

            <!-- Office rooms -->
            <div class="flex items-center justify-center gap-4 p-4 rounded-lg hover:shadow-md transition-all duration-300 hover:scale-105">
                <div class="w-16 h-16 bg-primary-500 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="bi bi-building text-2xl text-white"></i>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-bold text-gray-900">{{ number_format($categoryStats['office_rooms']) }}</p>
                    <p class="text-sm text-gray-600">Office rooms</p>
                </div>
            </div>

            <!-- Residential -->
            <div class="flex items-center justify-center gap-4 p-4 rounded-lg hover:shadow-md transition-all duration-300 hover:scale-105">
                <div class="w-16 h-16 bg-accent-dark rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="bi bi-house text-2xl text-white"></i>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-bold text-gray-900">{{ number_format($categoryStats['residential']) }}</p>
                    <p class="text-sm text-gray-600">Residential</p>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Categories Slider -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4" style="max-width: 1400px;">
        <div class="text-center mb-12 animate-fade-in-up">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Categories</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Explore our diverse range of property categories
            </p>
        </div>

        <div class="relative">
            @if(isset($categoriesFromDb) && $categoriesFromDb->count() > 0)
            <div class="categories-slider overflow-hidden">
                <div class="flex gap-6 categories-track" style="transition: transform 0.5s ease;">
                    @foreach($categoriesFromDb as $category)
                    <div class="flex-shrink-0" style="width: 280px;">
                        <a href="{{ route('properties.index', ['category' => $category['name']]) }}" 
                           class="block relative rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-shadow group">
                            <div class="relative h-64">
                                <img src="{{ $category['image'] }}" 
                                     alt="{{ $category['name'] }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                                <h3 class="absolute bottom-16 left-4 right-4 text-white text-xl font-bold">
                                    {{ $category['name'] }}
                                </h3>
                                <div class="absolute bottom-4 left-4">
                                    <span class="text-white px-4 py-1 rounded-full text-sm font-semibold {{ 
                                        $category['color'] === 'accent' ? 'bg-accent' : 
                                        ($category['color'] === 'accent-dark' ? 'bg-accent-dark' : 
                                        ($category['color'] === 'primary-600' ? 'bg-primary-600' : 'bg-primary-500')) 
                                    }}">
                                        {{ $category['count'] }}
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @if($categoriesFromDb->count() > 4)
            <button class="categories-prev absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 bg-white rounded-full p-3 shadow-lg hover:shadow-xl transition-shadow z-10 hidden md:block">
                <i class="bi bi-chevron-left text-2xl text-primary-600"></i>
            </button>
            <button class="categories-next absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 bg-white rounded-full p-3 shadow-lg hover:shadow-xl transition-shadow z-10 hidden md:block">
                <i class="bi bi-chevron-right text-2xl text-primary-600"></i>
            </button>
            @endif
            @else
            <div class="text-center py-12">
                <p class="text-gray-600">No categories available yet</p>
            </div>
            @endif
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<!-- Updated with B-Family Homes content from text file -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4" style="max-width: 1400px;">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Left Side - Text Content -->
            <div class="animate-fade-in-left">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg flex items-center justify-center">
                        <i class="bi bi-arrow-up-right text-white text-lg"></i>
                    </div>
                    <span class="text-gray-600 font-semibold uppercase tracking-wide">Why Choose Us</span>
                </div>
                
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                    Why Choose B-Family Homes Limited
                </h2>
                
                <p class="text-gray-600 text-lg mb-8 leading-relaxed">
                    We specialize in land sales, property development, building construction, property investment, and diaspora real estate services. Our goal is to make property ownership easy, secure, transparent, and profitable for individuals, families, and investors both in Nigeria and in the diaspora.
                </p>

                <!-- Benefits List -->
                <div class="space-y-4 mb-8">
                    <div class="flex items-start gap-4 animate-fade-in-up" style="animation-delay: 0.1s">
                        <div class="w-6 h-6 bg-orange-500 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                            <i class="bi bi-check text-white text-sm"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1">Verified & Secure Properties</h3>
                            <p class="text-gray-600">All our lands and buildings come with proper documentation and legal backing.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 animate-fade-in-up" style="animation-delay: 0.2s">
                        <div class="w-6 h-6 bg-orange-500 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                            <i class="bi bi-check text-white text-sm"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1">Professional Construction</h3>
                            <p class="text-gray-600">Through strategic partnerships with OJB Construction, we deliver solid, well-engineered buildings.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 animate-fade-in-up" style="animation-delay: 0.3s">
                        <div class="w-6 h-6 bg-orange-500 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                            <i class="bi bi-check text-white text-sm"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1">Diaspora-Friendly Services</h3>
                            <p class="text-gray-600">We support clients abroad with real-time updates and transparent investment tracking.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 animate-fade-in-up" style="animation-delay: 0.4s">
                        <div class="w-6 h-6 bg-orange-500 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                            <i class="bi bi-check text-white text-sm"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1">Flexible Payment Plans</h3>
                            <p class="text-gray-600">Our 50/50 Building Plan and installment options make property ownership accessible.</p>
                        </div>
                    </div>
                </div>

                <a href="{{ route('properties.index') }}" class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white px-8 py-3 rounded-lg font-semibold transition-all duration-300 hover:scale-105 shadow-lg hover:shadow-xl">
                    Read More
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            <!-- Right Side - Images -->
            <div class="relative animate-fade-in-right">
                <div class="grid grid-cols-2 gap-4">
                    <!-- First Image -->
                    <div class="relative rounded-xl overflow-hidden shadow-xl group">
                        <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=600&q=80" 
                             alt="Property consultation" 
                             class="w-full h-80 object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                    </div>

                    <!-- Second Image -->
                    <div class="relative rounded-xl overflow-hidden shadow-xl group mt-8">
                        <img src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=600&q=80" 
                             alt="Modern property" 
                             class="w-full h-80 object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                    </div>
                </div>

                <!-- Overlay Box -->
                <div class="absolute bottom-8 right-4 bg-white/95 backdrop-blur-sm rounded-xl p-6 shadow-2xl animate-bounce-slow">
                    <p class="text-xl font-bold text-primary-700 mb-3">10k+ Exclusive Agents</p>
                    <div class="flex items-center gap-2">
                        <div class="flex -space-x-2">
                            @for($i = 0; $i < 5; $i++)
                            <div class="w-10 h-10 rounded-full border-2 border-white overflow-hidden">
                                <img src="https://i.pravatar.cc/150?img={{ $i + 10 }}" alt="Agent" class="w-full h-full object-cover">
                            </div>
                            @endfor
                        </div>
                        <div class="w-10 h-10 rounded-full bg-primary-600 flex items-center justify-center border-2 border-white">
                            <span class="text-white font-bold">+</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- Latest Properties -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4" style="max-width: 1400px;">
        <div class="text-center mb-12 animate-fade-in-up">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Latest Properties</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Discover our newest property listings across Anambra State
            </p>
        </div>

        @if($latestProperties->count() > 0)
        <div class="relative">
            <div class="latest-properties-slider overflow-hidden">
                <div class="flex gap-6 latest-properties-track" style="transition: transform 0.5s ease;">
                    @foreach($latestProperties as $property)
                    <div class="flex-shrink-0 latest-property-item">
                        @include('partials.property-card', ['property' => $property])
                    </div>
                    @endforeach
                </div>
            </div>
            @if($latestProperties->count() > 1)
            <button class="latest-prev absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 bg-white rounded-full p-3 shadow-lg hover:shadow-xl transition-shadow z-10">
                <i class="bi bi-chevron-left text-2xl text-primary-600"></i>
            </button>
            <button class="latest-next absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 bg-white rounded-full p-3 shadow-lg hover:shadow-xl transition-shadow z-10">
                <i class="bi bi-chevron-right text-2xl text-primary-600"></i>
            </button>
            @endif
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('properties.index') }}" class="btn btn-primary">
                View All Properties
                <i class="bi bi-arrow-right"></i>
            </a>
        </div>
        @else
        <div class="text-center py-12">
            <p class="text-gray-600">No properties available yet</p>
        </div>
        @endif
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
                    <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=800&q=80" 
                         alt="Luxury property" 
                         class="w-full h-[500px] object-cover group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                </div>

                <!-- Video Thumbnail Overlay -->
                <div class="absolute -bottom-6 -left-6 bg-white rounded-xl shadow-2xl p-2 group cursor-pointer hover:scale-105 transition-transform duration-300">
                    <div class="relative rounded-lg overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1600047509807-ba8f99d2cdde?w=300&q=80" 
                             alt="Property video" 
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
                
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                    Trusted Real Estate Development and Investment Company
                </h2>
                
                <p class="text-gray-600 text-lg mb-6 leading-relaxed">
                    B-Family Homes Limited is a trusted real estate development and investment company based in Awkuzu, Anambra State, Nigeria. We specialize in land sales, property development, building construction, property investment, and diaspora real estate services.
                </p>

                <p class="text-gray-600 text-lg mb-8 leading-relaxed">
                    We operate with integrity, transparency, and a strong commitment to long-term value creation. Through strategic partnerships with professional construction firms such as OJB Construction, we deliver solid, well-engineered buildings that stand the test of time.
                </p>

                <!-- Features Grid -->
                <div class="grid grid-cols-2 gap-6 mb-8">
                    <div class="flex items-start gap-4 p-4 rounded-lg hover:bg-white hover:shadow-md transition-all duration-300 animate-fade-in-up" style="animation-delay: 0.1s">
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-house-check text-2xl text-orange-600"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1">Land Sales</h3>
                            <p class="text-sm text-gray-600">Verified properties with documentation</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-4 rounded-lg hover:bg-white hover:shadow-md transition-all duration-300 animate-fade-in-up" style="animation-delay: 0.2s">
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-building text-2xl text-orange-600"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1">Construction</h3>
                            <p class="text-sm text-gray-600">Professional building services</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-4 rounded-lg hover:bg-white hover:shadow-md transition-all duration-300 animate-fade-in-up" style="animation-delay: 0.3s">
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-cash-coin text-2xl text-orange-600"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1">Investment</h3>
                            <p class="text-sm text-gray-600">Profitable real estate opportunities</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-4 rounded-lg hover:bg-white hover:shadow-md transition-all duration-300 animate-fade-in-up" style="animation-delay: 0.4s">
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-globe text-2xl text-orange-600"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1">Diaspora Services</h3>
                            <p class="text-sm text-gray-600">Support for clients abroad</p>
                        </div>
                    </div>
                </div>

                <a href="{{ route('about') }}" class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white px-8 py-3 rounded-lg font-semibold transition-all duration-300 hover:scale-105 shadow-lg hover:shadow-xl">
                    Read More
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</section>




<!-- Featured Properties -->
<!-- Updated slider to support infinite loop with duplicated items -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4" style="max-width: 1400px;">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Featured Properties</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Explore our handpicked selection of premium properties
            </p>
        </div>

        @if($featuredProperties->count() > 0)
        <div class="relative px-4 md:px-0">
            <div class="featured-properties-slider overflow-hidden">
                <div class="flex gap-6 featured-properties-track" style="transition: transform 0.5s ease;">
                    @foreach($featuredProperties as $property)
                    <div class="flex-shrink-0 featured-property-item">
                        @include('partials.featured-property-card', ['property' => $property])
                    </div>
                    @endforeach
                </div>
            </div>
            @if($featuredProperties->count() > 1)
            <button class="featured-prev absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 bg-white rounded-full p-3 shadow-lg hover:shadow-xl transition-all z-10 hidden md:flex items-center justify-center">
                <i class="bi bi-chevron-left text-2xl text-primary-600"></i>
            </button>
            <button class="featured-next absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 bg-white rounded-full p-3 shadow-lg hover:shadow-xl transition-all z-10 hidden md:flex items-center justify-center">
                <i class="bi bi-chevron-right text-2xl text-primary-600"></i>
            </button>
            @endif
        </div>
        @else
        <div class="text-center py-12">
            <p class="text-gray-600">No featured properties available yet</p>
        </div>
        @endif
    </div>
</section>


<!-- Statistics Section -->
<!-- Added background-attachment: fixed to statistics background -->
<section class="py-20 relative overflow-hidden bg-gradient-primary">
    <!-- Background Image with Overlay and fixed attachment -->
    <div class="absolute inset-0 opacity-90" style="background-image: url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=1920&q=80'); background-size: cover; background-position: center; background-attachment: fixed;"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-primary-700/90 to-primary-900/90"></div>
    
    <div class="container mx-auto px-4 relative z-10" style="max-width: 1400px;">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Total Agents -->
            <div class="text-center text-white animate-fade-in-up hover:scale-110 transition-transform duration-300" style="animation-delay: 0.1s">
                <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 border-2 border-white/30 hover:bg-white/30 transition-colors">
                    <i class="bi bi-people text-3xl text-white"></i>
                </div>
                <h3 class="text-5xl font-bold mb-2 counter-value" data-target="{{ $stats['total_agents'] }}">0</h3>
                <p class="text-lg opacity-90">Total Agents</p>
            </div>

            <!-- Total Sales -->
            <div class="text-center text-white animate-fade-in-up hover:scale-110 transition-transform duration-300" style="animation-delay: 0.2s">
                <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 border-2 border-white/30 hover:bg-white/30 transition-colors">
                    <i class="bi bi-rocket-takeoff text-3xl text-white"></i>
                </div>
                <h3 class="text-5xl font-bold mb-2 counter-value" data-target="{{ $stats['total_sales'] }}">0</h3>
                <p class="text-lg opacity-90">Total Sales</p>
            </div>

            <!-- Total Projects -->
            <div class="text-center text-white animate-fade-in-up hover:scale-110 transition-transform duration-300" style="animation-delay: 0.3s">
                <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 border-2 border-white/30 hover:bg-white/30 transition-colors">
                    <i class="bi bi-file-earmark-text text-3xl text-white"></i>
                </div>
                <h3 class="text-5xl font-bold mb-2 counter-value" data-target="{{ $stats['total_projects'] }}">0</h3>
                <p class="text-lg opacity-90">Total Projects</p>
            </div>

            <!-- Happy Customers -->
            <div class="text-center text-white animate-fade-in-up hover:scale-110 transition-transform duration-300" style="animation-delay: 0.4s">
                <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 border-2 border-white/30 hover:bg-white/30 transition-colors">
                    <i class="bi bi-emoji-smile text-3xl text-white"></i>
                </div>
                <h3 class="text-5xl font-bold mb-2 counter-value" data-target="{{ $stats['happy_customers'] }}">0</h3>
                <p class="text-lg opacity-90">Happy Customers</p>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4" style="max-width: 1400px;">
        <div class="text-center mb-12 animate-fade-in-up">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                What Makes Us The Preferred Choice?
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Experience excellence in real estate with our comprehensive services and trusted expertise
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="card p-8 text-center hover:scale-105 transition-all duration-300 animate-fade-in-up" style="animation-delay: 0.1s">
                <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-primary-200 transition-colors">
                    <i class="bi bi-shield-check text-3xl text-primary-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Buyers Trust Us</h3>
                <p class="text-gray-600">
                    We provide verified properties with complete documentation, ensuring secure and transparent transactions for all buyers.
                </p>
            </div>

            <div class="card p-8 text-center hover:scale-105 transition-all duration-300 animate-fade-in-up" style="animation-delay: 0.2s">
                <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-primary-200 transition-colors">
                    <i class="bi bi-hand-thumbs-up text-3xl text-primary-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Sellers Prefer Us</h3>
                <p class="text-gray-600">
                    Our platform offers easy property listing, professional marketing, and fast support to help sellers reach the right buyers quickly.
                </p>
            </div>

            <div class="card p-8 text-center hover:scale-105 transition-all duration-300 animate-fade-in-up" style="animation-delay: 0.3s">
                <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-primary-200 transition-colors">
                    <i class="bi bi-list-check text-3xl text-primary-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Maximum Choices</h3>
                <p class="text-gray-600">
                    Browse through hundreds of properties across Anambra State, from residential homes to commercial lands and investment opportunities.
                </p>
            </div>

            <div class="card p-8 text-center hover:scale-105 transition-all duration-300 animate-fade-in-up" style="animation-delay: 0.4s">
                <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-primary-200 transition-colors">
                    <i class="bi bi-people text-3xl text-primary-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Expert Guidance</h3>
                <p class="text-gray-600">
                    Our team of experienced agents and professionals provide expert advice to help you make informed property decisions.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Best Property Collections -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4" style="max-width: 1400px;">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Best Property Collections</h2>
        </div>

        <!-- Filter Buttons -->
        <div class="flex flex-wrap justify-center gap-4 mb-12">
            <button class="collection-filter-btn px-6 py-2 rounded-lg font-semibold transition-all active" data-filter="all" style="background: linear-gradient(135deg, #f97316 0%, #ea580c 100%); color: white;">
                All
            </button>
            <button class="collection-filter-btn px-6 py-2 rounded-lg font-semibold transition-all bg-gray-200 hover:bg-gray-300 text-gray-700" data-filter="2bhk">
                2BHK Homes
            </button>
            <button class="collection-filter-btn px-6 py-2 rounded-lg font-semibold transition-all bg-gray-200 hover:bg-gray-300 text-gray-700" data-filter="villas">
                Villas
            </button>
            <button class="collection-filter-btn px-6 py-2 rounded-lg font-semibold transition-all bg-gray-200 hover:bg-gray-300 text-gray-700" data-filter="apartments">
                Apartments
            </button>
            <button class="collection-filter-btn px-6 py-2 rounded-lg font-semibold transition-all bg-gray-200 hover:bg-gray-300 text-gray-700" data-filter="duplex">
                Deplux Houses
            </button>
        </div>

        <!-- Properties Grid -->
        <div class="collection-grid">
            @foreach(['all', '2bhk', 'villas', 'apartments', 'duplex'] as $filter)
            <div class="collection-filter-content {{ $filter === 'all' ? '' : 'hidden' }}" data-content="{{ $filter }}">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($bestCollections[$filter] as $property)
                    <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-shadow">
                        <div class="relative">
                            @php
                                $propertyId = data_get($property, 'id');
                                $firstImage = data_get($property, 'first_image', 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=800');
                                $propertyTitle = data_get($property, 'title', 'Property');
                            @endphp
                            <a href="{{ route('properties.show', $propertyId) }}">
                                <img src="{{ $firstImage }}" 
                                     alt="{{ $propertyTitle }}"
                                     class="w-full h-64 object-cover"
                                     onerror="this.src='https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=800'">
                            </a>
                            
                            <!-- Category Badge -->
                            <div class="absolute bottom-4 left-4">
                                @if($filter === 'villas')
                                    <span class="bg-primary-500 text-white px-3 py-1 rounded text-sm font-semibold">Villa</span>
                                @elseif($filter === 'apartments')
                                    <span class="bg-primary-600 text-white px-3 py-1 rounded text-sm font-semibold">Apartments</span>
                                @else
                                    <span class="bg-accent text-white px-3 py-1 rounded text-sm font-semibold">Luxury Room</span>
                                @endif
                            </div>

                            <!-- Icon -->
                            <div class="absolute top-4 right-4">
                                <div class="w-10 h-10 bg-primary-600 rounded-lg flex items-center justify-center">
                                    <i class="bi bi-house text-white"></i>
                                </div>
                            </div>
                        </div>

                        <div class="p-6">
                            @php
                                $createdAt = data_get($property, 'created_at');
                                $dateFormatted = $createdAt ? (is_object($createdAt) ? $createdAt->format('d M Y') : date('d M Y', strtotime($createdAt))) : '';
                                $propertyId = data_get($property, 'id');
                            @endphp
                            @php
                                $propertyTitle = data_get($property, 'title', 'Property');
                                $propertyDescription = data_get($property, 'description', '');
                            @endphp
                            <p class="text-sm text-gray-500 mb-2">{{ $dateFormatted }}</p>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">
                                <a href="{{ route('properties.show', $propertyId) }}" class="hover:text-primary-600 transition-colors">
                                    {{ \Illuminate\Support\Str::limit($propertyTitle, 40) }}
                                </a>
                            </h3>
                            <p class="text-gray-600 text-sm line-clamp-2">
                                {{ \Illuminate\Support\Str::limit($propertyDescription, 100) }}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-12">
            <button class="px-8 py-3 border-2 border-primary-600 text-primary-600 rounded-lg font-semibold hover:bg-primary-600 hover:text-white transition-all">
                Show more
            </button>
        </div>
    </div>
</section>

<!-- Testimonials -->
<!-- Modified to show single user image per slider -->
<section class="py-20 relative overflow-hidden bg-gradient-primary">
    <!-- Background Image with Overlay and fixed attachment -->
    <div class="absolute inset-0 opacity-10" style="background-image: url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=1920&q=80'); background-size: cover; background-position: center; background-attachment: fixed;"></div>
    
    <div class="container mx-auto px-4 relative z-10" style="max-width: 1400px;">
        <h2 class="text-4xl md:text-5xl font-bold text-white text-center mb-16">Testimonials</h2>

        @if($testimonials->count() > 0)
        <div class="testimonials-slider relative max-w-4xl mx-auto">
            <!-- Testimonial Content with Single Image -->
            <div class="testimonials-content overflow-hidden">
                <div class="flex transition-transform duration-500 ease-in-out" id="testimonialsContainer" style="transform: translateX(0%);">
                    @foreach($testimonials->take(5) as $index => $testimonial)
                    @php
                        $content = data_get($testimonial, 'content', '');
                        $rating = data_get($testimonial, 'rating', 5);
                        $user = data_get($testimonial, 'user', null);
                        $userName = data_get($user, 'name', 'User');
                        $userAvatar = data_get($user, 'avatar', null);
                    @endphp
                    <div class="testimonial-slide flex-shrink-0 w-full text-center px-4">
                        <!-- Single User Image -->
                        <div class="flex justify-center mb-8">
                            <div class="testimonial-avatar ring-4 ring-white/50 rounded-full overflow-hidden">
                                @if($userAvatar)
                                <img src="{{ $userAvatar }}" 
                                     alt="{{ $userName }}"
                                     class="w-24 h-24 rounded-full object-cover border-4 border-white">
                                @else
                                <div class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center border-4 border-white text-white font-bold text-3xl">
                                    {{ substr($userName, 0, 1) }}
                                </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="text-white mb-8">
                            <span class="text-6xl font-serif leading-none opacity-50">"</span>
                            <p class="text-lg md:text-xl leading-relaxed max-w-3xl mx-auto mt-4">
                                {{ $content }}
                            </p>
                        </div>
                        <h4 class="text-2xl font-bold text-white mb-3">{{ $userName }}</h4>
                        <div class="flex justify-center gap-1 mb-8">
                            @for($i = 0; $i < 5; $i++)
                                <i class="bi bi-star-fill {{ $i < $rating ? 'text-yellow-400' : 'text-white/30' }} text-xl"></i>
                            @endfor
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- View All Button -->
            <div class="text-center mt-8">
                <a href="#" class="inline-block bg-primary-800 hover:bg-primary-900 text-white px-8 py-3 rounded-lg font-semibold transition-colors">
                    View all Testimonials
                </a>
            </div>

            <!-- Navigation Arrows -->
            <button class="testimonial-prev absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 bg-white/20 hover:bg-white/30 rounded-full p-3 border border-white/30 transition-all z-10">
                <i class="bi bi-chevron-left text-2xl text-white"></i>
            </button>
            <button class="testimonial-next absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 bg-white/20 hover:bg-white/30 rounded-full p-3 border border-white/30 transition-all z-10">
                <i class="bi bi-chevron-right text-2xl text-white"></i>
            </button>
        </div>
        @else
        <div class="text-center py-12">
            <i class="bi bi-chat-quote text-6xl text-white/50 mb-4"></i>
            <p class="text-white/80">No testimonials available yet</p>
        </div>
        @endif
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

@endsection

@push('styles')
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
</style>
@endpush

@push('scripts')
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

        function updateSlider() {
            if (!items[0]) return;
            const itemWidth = items[0].offsetWidth || 280;
            const gap = 24;
            const translateX = -(currentIndex * (itemWidth + gap));
            track.style.transform = `translateX(${translateX}px)`;
        }

        function nextSlide() {
            itemsPerView = window.innerWidth >= 1024 ? 4 : window.innerWidth >= 768 ? 3 : 2;
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
                itemsPerView = window.innerWidth >= 1024 ? 4 : window.innerWidth >= 768 ? 3 : 2;
                const maxIndex = Math.max(0, items.length - itemsPerView);
                currentIndex = maxIndex; // Loop to end
            }
            updateSlider();
        }

        // Only show navigation if there are more items than can be displayed
        function checkNavigation() {
            itemsPerView = window.innerWidth >= 1024 ? 4 : window.innerWidth >= 768 ? 3 : 2;
            const shouldShowNav = items.length > itemsPerView;
            
            if (prevBtn) prevBtn.style.display = shouldShowNav ? 'block' : 'none';
            if (nextBtn) nextBtn.style.display = shouldShowNav ? 'block' : 'none';
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
            itemsPerView = window.innerWidth >= 1024 ? 4 : window.innerWidth >= 768 ? 3 : 2;
            if (items.length > itemsPerView) {
                autoSlideInterval = setInterval(nextSlide, 4000); // Auto-slide every 4 seconds
            }
        }

        window.addEventListener('resize', () => {
            itemsPerView = window.innerWidth >= 1024 ? 4 : window.innerWidth >= 768 ? 3 : 2;
            checkNavigation();
            updateSlider();
        });

        // Initialize
        checkNavigation();
        updateSlider();
        startAutoSlide();
    })();

    // Latest Properties Slider with Auto-slide
    (function() {
        const sliderContainer = document.querySelector('.latest-properties-slider');
        const track = document.querySelector('.latest-properties-track');
        const prevBtn = document.querySelector('.latest-prev');
        const nextBtn = document.querySelector('.latest-next');
        if (!track || !sliderContainer) return;
        
        const items = document.querySelectorAll('.latest-properties-slider .flex-shrink-0');
        if (items.length === 0) return;
        
        let currentIndex = 0;
        let itemsPerView = window.innerWidth >= 1024 ? 4 : window.innerWidth >= 768 ? 2 : 1;
        let autoSlideInterval;

        function getItemsPerView() {
            return window.innerWidth >= 1024 ? 4 : window.innerWidth >= 768 ? 2 : 1;
        }

        function updateLatestSlider() {
            if (!items[0] || !sliderContainer) return;
            
            itemsPerView = getItemsPerView();
            
            // If there are not enough items to slide, disable slider
            if (items.length <= itemsPerView) {
                // Reset transform and allow natural flow
                track.style.transform = 'translateX(0px)';
                track.style.transition = 'none';
                
                // Remove fixed widths to allow natural sizing
                items.forEach(item => {
                    item.style.width = '';
                    item.style.minWidth = '';
                    item.style.maxWidth = '';
                });
                
                // Hide navigation buttons
                if (prevBtn) prevBtn.style.display = 'none';
                if (nextBtn) nextBtn.style.display = 'none';
                
                // Stop auto-slide
                clearInterval(autoSlideInterval);
                return;
            }
            
            // Enable slider functionality
            track.style.transition = 'transform 0.5s ease';
            
            // Get the actual container width
            const container = sliderContainer.closest('.container');
            let containerWidth = 1400; // Default max-width
            
            if (container) {
                containerWidth = container.offsetWidth;
            } else {
                // Fallback to viewport width minus padding
                containerWidth = window.innerWidth - 64; // 32px padding on each side
            }
            
            // Account for container padding (32px on each side = 64px total)
            const availableWidth = containerWidth - 64;
            const gap = 24;
            const totalGaps = gap * (itemsPerView - 1);
            const itemWidth = Math.floor((availableWidth - totalGaps) / itemsPerView);
            
            // Update item widths
            items.forEach(item => {
                item.style.width = `${itemWidth}px`;
                item.style.minWidth = `${itemWidth}px`;
                item.style.maxWidth = `${itemWidth}px`;
                item.style.flexShrink = '0';
            });
            
            // Calculate translateX - ensure we don't go beyond the last item
            const maxIndex = Math.max(0, items.length - itemsPerView);
            if (currentIndex > maxIndex) {
                currentIndex = maxIndex;
            }
            
            const translateX = -(currentIndex * (itemWidth + gap));
            track.style.transform = `translateX(${translateX}px)`;
        }

        function nextSlide() {
            itemsPerView = getItemsPerView();
            // Don't slide if not enough items
            if (items.length <= itemsPerView) return;
            
            const maxIndex = items.length - itemsPerView;
            
            if (currentIndex < maxIndex) {
                currentIndex++;
            } else {
                currentIndex = 0; // Loop back to start
            }
            updateLatestSlider();
        }

        function prevSlide() {
            itemsPerView = getItemsPerView();
            // Don't slide if not enough items
            if (items.length <= itemsPerView) return;
            
            if (currentIndex > 0) {
                currentIndex--;
            } else {
                const maxIndex = items.length - itemsPerView;
                currentIndex = maxIndex; // Loop to end
            }
            updateLatestSlider();
        }

        function checkNavigation() {
            itemsPerView = getItemsPerView();
            const shouldShowNav = items.length > itemsPerView;
            
            if (prevBtn) prevBtn.style.display = shouldShowNav ? 'block' : 'none';
            if (nextBtn) nextBtn.style.display = shouldShowNav ? 'block' : 'none';
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
            itemsPerView = window.innerWidth >= 1024 ? 4 : window.innerWidth >= 768 ? 2 : 1;
            if (items.length > itemsPerView) {
                autoSlideInterval = setInterval(nextSlide, 4000); // Auto-slide every 4 seconds
            }
        }

        window.addEventListener('resize', () => {
            itemsPerView = window.innerWidth >= 1024 ? 4 : window.innerWidth >= 768 ? 2 : 1;
            checkNavigation();
            updateLatestSlider();
        });

        // Initialize
        checkNavigation();
        // Set initial widths
        setTimeout(() => {
            updateLatestSlider();
            startAutoSlide();
        }, 100);
    })();

    // Featured Properties Slider with Auto-slide (4 desktop, 1 mobile)
    (function() {
        const sliderContainer = document.querySelector('.featured-properties-slider');
        const track = document.querySelector('.featured-properties-track');
        const prevBtn = document.querySelector('.featured-prev');
        const nextBtn = document.querySelector('.featured-next');
        if (!track || !sliderContainer) return;
        
        const items = document.querySelectorAll('.featured-properties-slider .flex-shrink-0');
        if (items.length === 0) return;
        
        let currentIndex = 0;
        let itemsPerView = window.innerWidth >= 1024 ? 4 : 1;
        let autoSlideInterval;

        function getItemsPerView() {
            return window.innerWidth >= 1024 ? 4 : 1;
        }

        function updateFeaturedSlider() {
            if (!items[0] || !sliderContainer) return;
            
            itemsPerView = getItemsPerView();
            
            // If there are not enough items to slide, disable slider
            if (items.length <= itemsPerView) {
                // Reset transform and allow natural flow
                track.style.transform = 'translateX(0px)';
                track.style.transition = 'none';
                
                // Remove fixed widths to allow natural sizing
                items.forEach(item => {
                    item.style.width = '';
                    item.style.minWidth = '';
                    item.style.maxWidth = '';
                });
                
                // Hide navigation buttons
                if (prevBtn) prevBtn.style.display = 'none';
                if (nextBtn) nextBtn.style.display = 'none';
                
                // Stop auto-slide
                clearInterval(autoSlideInterval);
                return;
            }
            
            // Enable slider functionality
            track.style.transition = 'transform 0.5s ease';
            
            // Get the actual container width
            const container = sliderContainer.closest('.container');
            let containerWidth = 1400; // Default max-width
            
            if (container) {
                containerWidth = container.offsetWidth;
            } else {
                // Fallback to viewport width minus padding
                containerWidth = window.innerWidth - 64; // 32px padding on each side
            }
            
            // Account for container padding (32px on each side = 64px total)
            const availableWidth = containerWidth - 64;
            const gap = 24;
            const totalGaps = gap * (itemsPerView - 1);
            const itemWidth = Math.floor((availableWidth - totalGaps) / itemsPerView);
            
            // Update item widths
            items.forEach(item => {
                item.style.width = `${itemWidth}px`;
                item.style.minWidth = `${itemWidth}px`;
                item.style.maxWidth = `${itemWidth}px`;
                item.style.flexShrink = '0';
            });
            
            // Calculate translateX - ensure we don't go beyond the last item
            const maxIndex = Math.max(0, items.length - itemsPerView);
            if (currentIndex > maxIndex) {
                currentIndex = maxIndex;
            }
            
            const translateX = -(currentIndex * (itemWidth + gap));
            track.style.transform = `translateX(${translateX}px)`;
        }

        function nextSlide() {
            itemsPerView = getItemsPerView();
            // Don't slide if not enough items
            if (items.length <= itemsPerView) return;
            
            const maxIndex = items.length - itemsPerView;
            
            if (currentIndex < maxIndex) {
                currentIndex++;
            } else {
                currentIndex = 0; // Loop back to start
            }
            updateFeaturedSlider();
        }

        function prevSlide() {
            itemsPerView = getItemsPerView();
            // Don't slide if not enough items
            if (items.length <= itemsPerView) return;
            
            if (currentIndex > 0) {
                currentIndex--;
            } else {
                const maxIndex = items.length - itemsPerView;
                currentIndex = maxIndex; // Loop to end
            }
            updateFeaturedSlider();
        }

        function checkNavigation() {
            itemsPerView = getItemsPerView();
            const shouldShowNav = items.length > itemsPerView;
            
            if (prevBtn) {
                if (shouldShowNav) {
                    prevBtn.style.display = 'flex';
                } else {
                    prevBtn.style.display = 'none';
                }
            }
            if (nextBtn) {
                if (shouldShowNav) {
                    nextBtn.style.display = 'flex';
                } else {
                    nextBtn.style.display = 'none';
                }
            }
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
                autoSlideInterval = setInterval(nextSlide, 5000); // Auto-slide every 5 seconds
            }
        }

        window.addEventListener('resize', () => {
            itemsPerView = getItemsPerView();
            currentIndex = 0; // Reset to start on resize
            checkNavigation();
            updateFeaturedSlider();
        });

        // Initialize
        checkNavigation();
        // Set initial widths after a short delay to ensure DOM is ready
        setTimeout(() => {
            updateFeaturedSlider();
            startAutoSlide();
        }, 200);
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
</script>
@endpush
