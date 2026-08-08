<header id="main-header" class="bg-white shadow-sm transition-all duration-300">
    <div class="container mx-auto px-4" style="max-width: 95%;">
<nav class="flex items-center justify-between py-4">
            <!-- Left Side: Logo & Left Nav Links -->
            <div class="flex items-center flex-1 justify-start gap-12">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2 flex-shrink-0">
                    <img src="{{ asset('images/logo.png') }}" alt="B-Family Homes" class="h-8 md:h-10 w-auto">
                </a>

                <!-- Left Nav Links -->
                <div class="hidden xl:flex items-center gap-8">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-orange-500 font-medium transition-colors">
                        Home
                    </a>
                    <a href="{{ route('properties.index') }}" class="text-gray-700 hover:text-orange-500 font-medium transition-colors">
                        Properties
                    </a>
                    <a href="{{ route('properties.index', ['type' => 'Investment']) }}" class="text-gray-700 hover:text-orange-500 font-medium transition-colors">
                        Invest
                    </a>
                </div>
            </div>

            <!-- Header Search (Desktop) -->
            <!-- Centered Search -->
            <div class="hidden md:flex items-center justify-center w-full max-w-sm lg:max-w-lg px-4 flex-shrink-0 z-50">
                <div class="w-full relative group">
                    <form action="{{ route('properties.index') }}" method="GET" class="w-full">
                        <div class="flex items-center bg-gray-100 rounded-full border border-gray-200 focus-within:border-primary-400 focus-within:bg-white focus-within:ring-2 focus-within:ring-primary-100 transition-all h-11 relative z-20 shadow-sm">
                            <select name="type" class="bg-transparent border-none h-full pl-4 pr-1 text-sm font-medium text-gray-700 outline-none cursor-pointer hidden lg:block border-r border-gray-300 focus:ring-0">
                                <option value="">All</option>
                                <option value="Rent">Rent</option>
                                <option value="Sale">Buy</option>
                                <option value="Investment">Invest</option>
                            </select>
                            <input type="text" name="search" placeholder="Search locations, properties..." class="w-full bg-transparent border-none py-2 px-4 text-sm focus:ring-0 outline-none text-gray-800 placeholder-gray-500">
                            
                            <!-- Toggle Advanced Filters -->
                            <button type="button" id="advancedFilterToggleBtn" class="text-gray-500 hover:text-primary-600 px-2 h-full flex items-center justify-center transition-colors border-l border-gray-300">
                                <i class="bi bi-sliders text-lg"></i>
                            </button>
                            
                            <!-- Submit Button -->
                            <button type="submit" class="bg-gradient-to-r from-orange-500 to-yellow-500 hover:from-orange-600 hover:to-yellow-600 text-white w-9 h-9 rounded-full flex items-center justify-center mr-1 ml-1 flex-shrink-0 transition-colors shadow-sm">
                                <i class="bi bi-search text-sm text-white font-bold"></i>
                            </button>
                        </div>

                        <!-- Advanced Filters Dropdown Panel -->
                        <div id="advancedFilterPanel" 
                             class="absolute top-[120%] left-1/2 -translate-x-1/2 w-[600px] bg-white rounded-2xl shadow-2xl border border-gray-100 p-6 z-10 transition-all duration-300 opacity-0 invisible translate-y-2 pointer-events-none">
                            
                            <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">Advanced Filter</h3>
                            
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Property Name</label>
                                    <input type="text" name="title" placeholder="e.g. Luxury Villa" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-primary-200 focus:border-primary-400">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Location</label>
                                    <input type="text" name="location" placeholder="e.g. Awkuzu" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-primary-200 focus:border-primary-400">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Category</label>
                                    <select name="category" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-primary-200 focus:border-primary-400">
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
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">Bedrooms</label>
                                        <select name="bedrooms" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-primary-200 focus:border-primary-400">
                                            <option value="">Any</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4+">4+</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">Bathrooms</label>
                                        <select name="bathrooms" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-primary-200 focus:border-primary-400">
                                            <option value="">Any</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4+">4+</option>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Min Price (₦)</label>
                                    <input type="number" name="min_price" placeholder="Min Price" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-primary-200 focus:border-primary-400">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Max Price (₦)</label>
                                    <input type="number" name="max_price" placeholder="Max Price" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-primary-200 focus:border-primary-400">
                                </div>
                            </div>
                            
                            <button type="submit" class="w-full bg-gradient-to-r from-orange-500 to-yellow-500 hover:from-orange-600 hover:to-yellow-600 text-white font-bold py-3 rounded-lg shadow-md transition-all duration-300 flex items-center justify-center gap-2 hover:shadow-lg">
                                <i class="bi bi-search"></i> Search Properties
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const toggleBtn = document.getElementById('advancedFilterToggleBtn');
                    const panel = document.getElementById('advancedFilterPanel');

                    if(toggleBtn && panel) {
                        toggleBtn.addEventListener('click', function(e) {
                            e.stopPropagation();
                            panel.classList.toggle('opacity-0');
                            panel.classList.toggle('invisible');
                            panel.classList.toggle('translate-y-2');
                            panel.classList.toggle('pointer-events-none');
                        });

                        document.addEventListener('click', function(e) {
                            if (!panel.contains(e.target) && !toggleBtn.contains(e.target)) {
                                panel.classList.add('opacity-0', 'invisible', 'translate-y-2', 'pointer-events-none');
                            }
                        });
                        
                        panel.addEventListener('click', function(e) {
                            e.stopPropagation();
                        });
                    }
                });
            </script>

            <!-- Right Side: Nav Links & User Profile -->
            <div class="flex items-center flex-1 justify-end gap-12">
                <!-- Right Nav Links -->
                <div class="hidden xl:flex items-center gap-8">
                    <a href="{{ route('about') }}" class="text-gray-700 hover:text-orange-500 font-medium transition-colors">
                        About Us
                    </a>
                    <a href="{{ route('blogs.index') }}" class="text-gray-700 hover:text-orange-500 font-medium transition-colors">
                        Blog
                    </a>
                    <a href="{{ route('contact') }}" class="text-gray-700 hover:text-orange-500 font-medium transition-colors">
                        Contact
                    </a>
                </div>

                <!-- User Dropdown (Hover) -->
                <div class="hidden lg:block relative group flex-shrink-0 z-50">
                    <a href="#" class="flex items-center justify-center w-10 h-10 rounded-full bg-gray-50 hover:bg-gray-100 border border-gray-200 transition-colors shadow-sm">
                        <i class="bi bi-person text-gray-700 text-lg"></i>
                    </a>

                    <!-- Dropdown Menu -->
                    <div class="absolute right-0 top-full mt-2 w-56 bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden opacity-0 invisible translate-y-2 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 transition-all duration-300">
                        @auth
                            <div class="px-4 py-3 border-b border-gray-100 bg-gray-50">
                                <p class="text-sm font-semibold text-gray-900 truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                            </div>
                            <a href="{{ 
                                auth()->user()->isAdmin() ? route('admin.dashboard') :
                                (auth()->user()->isAgent() ? route('agent.dashboard') :
                                (auth()->user()->isInvestor() ? route('investor.dashboard') : route('dashboard')))
                            }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-colors">
                                <i class="bi bi-speedometer2 mr-2"></i> Dashboard
                            </a>
                            <form id="logoutForm" class="block w-full border-t border-gray-100">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                    <i class="bi bi-box-arrow-right mr-2"></i> Logout
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-colors border-b border-gray-50">
                                <i class="bi bi-box-arrow-in-right mr-2"></i> Login
                            </a>
                            <a href="{{ route('register') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-colors">
                                <i class="bi bi-person-plus mr-2"></i> Register
                            </a>
                        @endauth
                    </div>
                </div>
            </div>

            <!-- Mobile Menu Toggle Button - Right Side -->
            <button id="mobileMenuBtn" class="mobile-menu-toggle lg:hidden">
                <i class="bi bi-list"></i>
            </button>
        </nav>
    </div>
</header>

<!-- Mobile Sidebar Overlay (Outside header to prevent layout issues) -->
<div id="mobileMenuOverlay" class="mobile-sidebar-overlay"></div>

<!-- Mobile Sidebar Menu (Outside header to prevent layout issues) -->
<div id="mobileMenu" class="mobile-sidebar">
        <!-- Sidebar Header -->
        <div class="mobile-sidebar-header">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <img src="{{ asset('images/logo.png') }}" alt="B-Family Homes" class="h-10 w-auto">
            </a>
            <button id="mobileMenuClose" class="mobile-menu-close">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <!-- Sidebar Navigation -->
        <nav class="mobile-sidebar-nav">
            <a href="{{ route('home') }}" class="mobile-sidebar-link">
                <i class="bi bi-house-door"></i>
                <span>Home</span>
            </a>
            <a href="{{ route('about') }}" class="mobile-sidebar-link">
                <i class="bi bi-info-circle"></i>
                <span>About Us</span>
            </a>
            <a href="{{ route('properties.index') }}" class="mobile-sidebar-link">
                <i class="bi bi-house"></i>
                <span>Properties</span>
            </a>
            <a href="{{ route('properties.index', ['type' => 'Investment']) }}" class="mobile-sidebar-link">
                <i class="bi bi-graph-up-arrow"></i>
                <span>Invest</span>
            </a>
            <a href="{{ route('blogs.index') }}" class="mobile-sidebar-link">
                <i class="bi bi-journal-text"></i>
                <span>Blog</span>
            </a>
            <a href="{{ route('contact') }}" class="mobile-sidebar-link">
                <i class="bi bi-envelope"></i>
                <span>Contact</span>
            </a>
            
            <div class="mobile-sidebar-divider"></div>
            
            @auth
                <a href="{{ 
                    auth()->user()->isAdmin() ? route('admin.dashboard') :
                    (auth()->user()->isAgent() ? route('agent.dashboard') :
                    (auth()->user()->isInvestor() ? route('investor.dashboard') : route('dashboard')))
                }}" class="mobile-sidebar-link">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
                <button id="mobileLogoutBtn" class="mobile-sidebar-link mobile-sidebar-logout">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </button>
            @else
                <a href="{{ route('login') }}" class="mobile-sidebar-link">
                    <i class="bi bi-box-arrow-in-right"></i>
                    <span>Login</span>
                </a>
                <a href="{{ route('register') }}" class="mobile-sidebar-button">
                    Get Started
                </a>
            @endauth
        </nav>
</div>

@auth
<script>
    // Desktop Logout
    document.getElementById('logoutForm')?.addEventListener('submit', async function(e) {
        e.preventDefault();
        try {
            const data = await window.ajax('{{ route("logout") }}', 'POST');
            window.toast(data.message, 'success');
            setTimeout(() => window.location.href = data.redirect, 1000);
        } catch (error) {
            window.toast('Logout failed', 'error');
        }
    });

    // Mobile Logout
    document.getElementById('mobileLogoutBtn')?.addEventListener('click', async function() {
        try {
            const data = await window.ajax('{{ route("logout") }}', 'POST');
            window.toast(data.message, 'success');
            setTimeout(() => window.location.href = data.redirect, 1000);
        } catch (error) {
            window.toast('Logout failed', 'error');
        }
    });
</script>
@endauth

<style>
/* Mobile Sidebar Styles */
.mobile-menu-toggle {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: transparent;
    border: none;
    color: #374151;
    font-size: 1.5rem;
    cursor: pointer;
    margin-left: auto !important;
    margin-right: 0 !important;
    position: relative !important;
    float: right !important;
    transition: all 0.3s ease;
}

/* Force toggle button to right - hard enforce */
#main-header nav {
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    width: 100% !important;
}

#main-header nav > a:first-child {
    flex-shrink: 0 !important;
}

/* Only hide hidden divs on mobile, not desktop */
@media (max-width: 1023px) {
    #main-header nav > div.hidden {
        display: none !important;
    }
}

/* Ensure desktop navigation shows on desktop */
@media (min-width: 1024px) {
    #main-header nav > div.hidden.lg\\:flex,
    #main-header nav > div[class*="hidden"][class*="lg:flex"] {
        display: flex !important;
        visibility: visible !important;
    }
}

#main-header nav .mobile-menu-toggle {
    order: 999 !important;
    margin-left: auto !important;
    margin-right: 0 !important;
    position: relative !important;
    right: 0 !important;
    float: right !important;
}

@media (max-width: 1023px) {
    #main-header nav .mobile-menu-toggle {
        order: 999 !important;
        margin-left: auto !important;
        margin-right: 0 !important;
        position: relative !important;
        right: 0 !important;
        float: right !important;
        display: flex !important;
    }
}

.mobile-menu-toggle:hover {
    color: #ea580c;
    background: #f3f4f6;
    border-radius: 0.5rem;
}

.mobile-sidebar-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    height: 100dvh;
    background: rgba(0, 0, 0, 0.5);
    z-index: 9998;
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    transition: opacity 0.3s ease, visibility 0.3s ease;
}

.mobile-sidebar-overlay.active {
    opacity: 1;
    visibility: visible;
    pointer-events: auto;
}

.mobile-sidebar {
    position: fixed !important;
    top: 0;
    left: 0;
    width: 320px;
    max-width: 85vw;
    height: 100vh;
    height: 100dvh;
    background: white;
    box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
    z-index: 9999;
    transform: translateX(-100%);
    transition: transform 0.3s ease;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    pointer-events: none;
    visibility: hidden;
}

.mobile-sidebar.active {
    transform: translateX(0);
    pointer-events: auto;
    visibility: visible;
}

.mobile-sidebar-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.5rem;
    border-bottom: 1px solid #e5e7eb;
}

.mobile-menu-close {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: transparent;
    border: none;
    color: #374151;
    font-size: 1.5rem;
    cursor: pointer;
    border-radius: 0.5rem;
    transition: all 0.3s ease;
}

.mobile-menu-close:hover {
    color: #ea580c;
    background: #f3f4f6;
}

.mobile-sidebar-nav {
    padding: 1rem;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    flex: 1;
}

.mobile-sidebar-link {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1rem;
    color: #374151;
    text-decoration: none;
    border-radius: 0.5rem;
    transition: all 0.3s ease;
    font-weight: 500;
    border: none;
    background: transparent;
    width: 100%;
    text-align: left;
    cursor: pointer;
}

.mobile-sidebar-link:hover {
    background: #fef3e7;
    color: #ea580c;
}

.mobile-sidebar-link i {
    font-size: 1.25rem;
    width: 24px;
    text-align: center;
}

.mobile-sidebar-logout {
    color: #dc2626;
}

.mobile-sidebar-logout:hover {
    background: #fee2e2;
    color: #dc2626;
}

.mobile-sidebar-divider {
    height: 1px;
    background: #e5e7eb;
    margin: 1rem 0;
}

.mobile-sidebar-button {
    display: block;
    width: 100%;
    padding: 0.75rem 1rem;
    background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%);
    color: white;
    text-align: center;
    border-radius: 0.5rem;
    font-weight: 600;
    text-decoration: none;
    margin-top: 0.5rem;
    transition: all 0.3s ease;
}

.mobile-sidebar-button:hover {
    background: linear-gradient(135deg, #c2410c 0%, #9a3412 100%);
    transform: translateY(-1px);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

/* Hide on desktop */
@media (min-width: 1024px) {
    .mobile-menu-toggle,
    .mobile-sidebar-overlay,
    .mobile-sidebar {
        display: none !important;
    }
}

/* Mobile specific fixes - Ensure sidebar doesn't affect layout */
@media (max-width: 1023px) {
    /* Ensure header has fixed height and doesn't expand */
    #main-header {
        position: relative;
        height: auto !important;
        min-height: 0 !important;
        overflow: visible;
    }
    
    #main-header .container,
    #main-header nav {
        height: auto !important;
        min-height: 0 !important;
    }
    
    /* Ensure sidebar and overlay are completely out of document flow */
    .mobile-sidebar,
    .mobile-sidebar-overlay {
        position: fixed !important;
        margin: 0 !important;
        padding: 0 !important;
        float: none !important;
    }
    
    /* Ensure inactive sidebar doesn't take space */
    .mobile-sidebar:not(.active) {
        transform: translateX(-100%) !important;
        pointer-events: none !important;
        visibility: hidden !important;
    }
    
    .mobile-sidebar-overlay:not(.active) {
        opacity: 0 !important;
        pointer-events: none !important;
        visibility: hidden !important;
    }
}
</style>

<script>
    // Mobile Sidebar Toggle
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');
        const mobileMenuClose = document.getElementById('mobileMenuClose');
        
        function openSidebar() {
            if (mobileMenu && mobileMenuOverlay) {
                mobileMenu.classList.add('active');
                mobileMenuOverlay.classList.add('active');
                // Prevent scroll without affecting layout
                document.body.style.overflowY = 'hidden';
                document.body.style.position = 'fixed';
                document.body.style.width = '100%';
                document.body.style.top = `-${window.scrollY}px`;
            }
        }
        
        function closeSidebar() {
            if (mobileMenu && mobileMenuOverlay) {
                mobileMenu.classList.remove('active');
                mobileMenuOverlay.classList.remove('active');
                // Restore scroll position
                const scrollY = document.body.style.top;
                document.body.style.overflowY = '';
                document.body.style.position = '';
                document.body.style.width = '';
                document.body.style.top = '';
                if (scrollY) {
                    window.scrollTo(0, parseInt(scrollY || '0') * -1);
                }
            }
        }
        
        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                openSidebar();
            });
        }
        
        if (mobileMenuClose) {
            mobileMenuClose.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                closeSidebar();
            });
        }
        
        if (mobileMenuOverlay) {
            mobileMenuOverlay.addEventListener('click', function() {
                closeSidebar();
            });
        }
        
        if (mobileMenu) {
            const menuLinks = mobileMenu.querySelectorAll('a');
            menuLinks.forEach(link => {
                link.addEventListener('click', function() {
                    closeSidebar();
                });
            });
        }
        
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && mobileMenu && mobileMenu.classList.contains('active')) {
                closeSidebar();
            }
        });
    });
</script>
