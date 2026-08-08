<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - B-Family Homes</title>
    
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon/favicon-16x16.png') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon/favicon.ico') }}">
    <link rel="manifest" href="{{ asset('images/favicon/site.webmanifest') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    @stack('styles')
    <style>
        /* ADMIN DASHBOARD HEADER - ULTRA STRONG OVERRIDES */
        /* Using very specific selectors to override everything including universal selector */
        
        /* Override the universal selector max-width rule */
        @media (max-width: 768px) {
            body header.bg-white.shadow-sm.border-b.border-gray-200,
            body header.bg-white.shadow-sm.border-b.border-gray-200 *,
            body header.bg-white.shadow-sm.border-b.border-gray-200 > div,
            body header.bg-white.shadow-sm.border-b.border-gray-200 > div *,
            body header.bg-white.shadow-sm.border-b.border-gray-200 button,
            body header.bg-white.shadow-sm.border-b.border-gray-200 a,
            body header.bg-white.shadow-sm.border-b.border-gray-200 img,
            body header.bg-white.shadow-sm.border-b.border-gray-200 div {
                max-width: none !important;
            }
        }
        
        body header.bg-white.shadow-sm.border-b.border-gray-200 {
            width: 100% !important;
            max-width: 100vw !important;
            overflow: visible !important;
            position: sticky !important;
            height: auto !important;
            min-height: 0 !important;
        }
        
        body header.bg-white.shadow-sm.border-b.border-gray-200 > div {
            width: 100% !important;
            max-width: 100% !important;
            overflow: visible !important;
            height: auto !important;
        }
        
        /* Force header flex container to ALWAYS stay in row layout */
        body header.bg-white.shadow-sm.border-b.border-gray-200 > div > div.flex {
            display: flex !important;
            flex-direction: row !important;
            flex-wrap: nowrap !important;
            align-items: center !important;
            justify-content: space-between !important;
            width: 100% !important;
            max-width: 100% !important;
            box-sizing: border-box !important;
        }
        
        /* Ensure flex items don't get constrained by max-width */
        body header.bg-white.shadow-sm.border-b.border-gray-200 > div > div.flex > * {
            flex-shrink: 0 !important;
            max-width: none !important;
        }
        
        /* Left section - Toggler + Logo - ALWAYS stay left */
        body header.bg-white.shadow-sm.border-b.border-gray-200 > div > div.flex > div:first-child {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            flex-shrink: 0 !important;
            flex-grow: 0 !important;
            flex-basis: auto !important;
            margin-right: 0 !important;
            margin-left: 0 !important;
            order: 1 !important;
            position: relative !important;
            left: 0 !important;
            max-width: none !important;
            width: auto !important;
        }
        
        /* Left section children - no max-width */
        body header.bg-white.shadow-sm.border-b.border-gray-200 > div > div.flex > div:first-child > * {
            flex-shrink: 0 !important;
            max-width: none !important;
        }
        
        /* Sidebar toggle button - Force visible on mobile */
        body header.bg-white.shadow-sm.border-b.border-gray-200 #sidebarToggle {
            display: flex !important;
            visibility: visible !important;
            opacity: 1 !important;
            flex-shrink: 0 !important;
            position: relative !important;
            z-index: 1 !important;
            max-width: none !important;
            width: auto !important;
        }
        
        /* Logo on mobile - Force visible */
        body header.bg-white.shadow-sm.border-b.border-gray-200 > div > div.flex > div:first-child > a.lg\\:hidden {
            display: flex !important;
            visibility: visible !important;
            opacity: 1 !important;
            flex-shrink: 0 !important;
            max-width: none !important;
            width: auto !important;
        }
        
        /* Logo image - no constraints */
        body header.bg-white.shadow-sm.border-b.border-gray-200 > div > div.flex > div:first-child > a.lg\\:hidden img {
            max-width: none !important;
            width: auto !important;
        }
        
        /* Right section - Notifications + Profile - ALWAYS stay right */
        body header.bg-white.shadow-sm.border-b.border-gray-200 > div > div.flex > div:last-child {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            flex-shrink: 0 !important;
            flex-grow: 0 !important;
            flex-basis: auto !important;
            margin-left: auto !important;
            margin-right: 0 !important;
            order: 2 !important;
            position: relative !important;
            right: 0 !important;
            max-width: none !important;
            width: auto !important;
        }
        
        /* Right section children - no max-width */
        body header.bg-white.shadow-sm.border-b.border-gray-200 > div > div.flex > div:last-child > * {
            flex-shrink: 0 !important;
            max-width: none !important;
        }
        
        /* Notification icon - Force visible and positioned right */
        body header.bg-white.shadow-sm.border-b.border-gray-200 > div > div.flex > div:last-child > a[href*="notifications"] {
            display: flex !important;
            visibility: visible !important;
            opacity: 1 !important;
            flex-shrink: 0 !important;
            position: relative !important;
            z-index: 1 !important;
            max-width: none !important;
            width: auto !important;
        }
        
        /* Profile section - Force visible and positioned right */
        body header.bg-white.shadow-sm.border-b.border-gray-200 > div > div.flex > div:last-child > div {
            display: flex !important;
            visibility: visible !important;
            opacity: 1 !important;
            flex-shrink: 0 !important;
            position: relative !important;
            max-width: none !important;
            width: auto !important;
        }
        
        /* Profile image/avatar - Force visible */
        body header.bg-white.shadow-sm.border-b.border-gray-200 > div > div.flex > div:last-child > div img,
        body header.bg-white.shadow-sm.border-b.border-gray-200 > div > div.flex > div:last-child > div > div {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
            flex-shrink: 0 !important;
            max-width: none !important;
            width: auto !important;
        }
        
        /* Prevent ANY element from wrapping, growing, shrinking or being constrained */
        body header.bg-white.shadow-sm.border-b.border-gray-200 button,
        body header.bg-white.shadow-sm.border-b.border-gray-200 a,
        body header.bg-white.shadow-sm.border-b.border-gray-200 img,
        body header.bg-white.shadow-sm.border-b.border-gray-200 div.flex {
            flex-shrink: 0 !important;
            flex-grow: 0 !important;
            max-width: none !important;
        }
        
        /* Mobile specific - Extra enforcement */
        @media (max-width: 1023px) {
            body header.bg-white.shadow-sm.border-b.border-gray-200 > div > div.flex {
                padding-left: 0.75rem !important;
                padding-right: 0.75rem !important;
                gap: 0.5rem !important;
                width: 100% !important;
                box-sizing: border-box !important;
            }
            
            /* Force left section to stay left */
            body header.bg-white.shadow-sm.border-b.border-gray-200 > div > div.flex > div:first-child {
                margin-left: 0 !important;
                padding-left: 0 !important;
                justify-content: flex-start !important;
            }
            
            /* Force right section to stay right */
            body header.bg-white.shadow-sm.border-b.border-gray-200 > div > div.flex > div:last-child {
                margin-right: 0 !important;
                padding-right: 0 !important;
                justify-content: flex-end !important;
            }
            
            /* Absolutely ensure toggler is visible */
            body header.bg-white.shadow-sm.border-b.border-gray-200 #sidebarToggle.lg\\:hidden {
                display: flex !important;
                visibility: visible !important;
                opacity: 1 !important;
                width: 36px !important;
                height: 36px !important;
                min-width: 36px !important;
                min-height: 36px !important;
            }
            
            /* Absolutely ensure logo is visible on mobile */
            body header.bg-white.shadow-sm.border-b.border-gray-200 a.lg\\:hidden img {
                display: block !important;
                visibility: visible !important;
                opacity: 1 !important;
            }
        }
        
        /* Tablet adjustments */
        @media (min-width: 768px) and (max-width: 1023px) {
            body header.bg-white.shadow-sm.border-b.border-gray-200 > div > div.flex {
                padding-left: 1.5rem !important;
                padding-right: 1.5rem !important;
                gap: 0.75rem !important;
            }
        }
        
        /* Override any conflicting app.css rules */
        body header.bg-white * {
            box-sizing: border-box !important;
        }
        
        /* TOAST NOTIFICATIONS - Ensure they're ALWAYS on top in dashboard */
        #toast-container,
        .toast-container {
            position: fixed !important;
            top: 1rem !important;
            right: 1rem !important;
            z-index: 999999 !important;
            pointer-events: none !important;
        }
        
        .toast {
            pointer-events: auto !important;
            z-index: 1 !important;
        }
        
        /* Ensure toast is above preloader */
        #preloader {
            z-index: 99999 !important; /* Lower than toast */
        }
        
        /* Desktop - Hide mobile elements (lg:hidden should be hidden on desktop) */
        @media (min-width: 1024px) {
            body header.bg-white.shadow-sm.border-b.border-gray-200 .lg\\:hidden {
                display: none !important;
                visibility: hidden !important;
                opacity: 0 !important;
            }
        }
        
        /* Mobile/Tablet - Show ONLY the toggle button, HIDE the logo and profile text */
        @media (max-width: 1023px) {
            /* Show toggle button */
            body header.bg-white.shadow-sm.border-b.border-gray-200 button.lg\\:hidden {
                display: flex !important;
                visibility: visible !important;
                opacity: 1 !important;
            }
            
            /* HIDE logo on mobile */
            body header.bg-white.shadow-sm.border-b.border-gray-200 a.lg\\:hidden {
                display: none !important;
                visibility: hidden !important;
                opacity: 0 !important;
                width: 0 !important;
                height: 0 !important;
                overflow: hidden !important;
                position: absolute !important;
                left: -9999px !important;
            }
            
            /* HIDE profile name and role on mobile/tablet */
            body header.bg-white.shadow-sm.border-b.border-gray-200 .hidden.lg\\:block {
                display: none !important;
                visibility: hidden !important;
                opacity: 0 !important;
                width: 0 !important;
                overflow: hidden !important;
            }
        }
        
        /* Desktop - Show profile name and role */
        @media (min-width: 1024px) {
            body header.bg-white.shadow-sm.border-b.border-gray-200 .hidden.lg\\:block {
                display: block !important;
                visibility: visible !important;
                opacity: 1 !important;
                width: auto !important;
            }
        }
        
        /* Force correct order: Notification before Profile */
        body header.bg-white.shadow-sm.border-b.border-gray-200 > div > div.flex > div:last-child {
            display: flex !important;
            flex-direction: row !important;
            gap: 0.5rem !important;
        }
        
        body header.bg-white.shadow-sm.border-b.border-gray-200 a[href*="notifications"] {
            order: 1 !important;
        }
        
        body header.bg-white.shadow-sm.border-b.border-gray-200 > div > div.flex > div:last-child > div:last-child {
            order: 2 !important;
        }
        
        /* Ensure profile image is perfectly rounded on all screens */
        body header.bg-white.shadow-sm.border-b.border-gray-200 img[alt*="name"],
        body header.bg-white.shadow-sm.border-b.border-gray-200 .rounded-full {
            border-radius: 50% !important;
        }
        
        /* Content area responsive fixes */
        @media (max-width: 768px) {
            /* Prevent horizontal overflow */
            main.flex-1 {
                overflow-x: hidden !important;
            }
            
            /* Responsive typography */
            main.flex-1 h1 {
                font-size: clamp(1.25rem, 5vw, 1.875rem) !important;
                line-height: 1.3 !important;
                word-break: break-word !important;
            }
            
            main.flex-1 h2 {
                font-size: clamp(1.125rem, 4vw, 1.5rem) !important;
                line-height: 1.4 !important;
            }
            
            main.flex-1 h3 {
                font-size: clamp(1rem, 3.5vw, 1.25rem) !important;
                line-height: 1.4 !important;
            }
            
            /* Ensure buttons and cards are responsive */
            main.flex-1 .btn {
                font-size: 0.875rem !important;
                padding: 0.5rem 0.75rem !important;
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('partials.impersonation-banner')
    <!-- Preloader -->
    <div id="preloader" class="fixed inset-0 bg-white z-[9999] flex items-center justify-center transition-opacity duration-500">
        <div class="text-center preloader-content">
            <img src="{{ asset('images/preloader/preloader2.jpg') }}" alt="Loading..." class="preloader-image">
        </div>
    </div>
    
    <div id="toast-container"></div>

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside id="sidebar" class="w-64 bg-white shadow-lg fixed inset-y-0 left-0 z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300">
            <div class="h-full flex flex-col">
                <!-- Logo -->
                <div class="p-6 border-b border-gray-200">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center justify-center lg:justify-start">
                        <img src="{{ asset('images/logo.png') }}" alt="B-Family Homes" class="h-10 w-auto">
                    </a>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 overflow-y-auto p-4">
                    <div class="mb-4">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 mb-2">NAVIGATION</p>
                    </div>
                    <div class="space-y-1">
                        <!-- Dashboard -->
                        <a href="{{ route('admin.dashboard') }}"
                           class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-orange-500 to-yellow-500 text-white font-semibold shadow-sm' : 'text-gray-600 hover:bg-orange-50 hover:text-orange-600' }}">
                            <i class="bi bi-speedometer2 text-lg"></i>
                            <span>Dashboard</span>
                        </a>

                        <!-- Users Management -->
                        <div>
                            <a href="{{ route('admin.users') }}"
                               class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.users*') ? 'bg-orange-50 text-orange-700 font-semibold' : 'text-gray-600 hover:bg-orange-50 hover:text-orange-600' }}">
                                <i class="bi bi-people-fill text-lg"></i>
                                <span>Users</span>
                                <i class="bi bi-chevron-right ml-auto text-xs"></i>
                            </a>
                            @if(request()->routeIs('admin.users*'))
                            <div class="ml-4 mt-1 space-y-1 border-l-2 border-orange-200 pl-3">
                                <a href="{{ route('admin.users') }}"
                                   class="flex items-center gap-3 px-4 py-2 rounded-lg transition-all duration-200 {{ !request('role') && !request('pending') ? 'bg-orange-50 text-orange-700 font-medium' : 'text-gray-500 hover:bg-orange-50 hover:text-orange-600' }}">
                                    <i class="bi bi-grid-fill text-sm"></i>
                                    <span class="text-sm">All Users</span>
                                </a>
                                <a href="{{ route('admin.users', ['role' => 'user']) }}"
                                   class="flex items-center gap-3 px-4 py-2 rounded-lg transition-all duration-200 {{ request('role') === 'user' ? 'bg-orange-50 text-orange-700 font-medium' : 'text-gray-500 hover:bg-orange-50 hover:text-orange-600' }}">
                                    <i class="bi bi-person-fill text-sm"></i>
                                    <span class="text-sm">Regular Users</span>
                                </a>
                                <a href="{{ route('admin.users', ['role' => 'agent']) }}"
                                   class="flex items-center gap-3 px-4 py-2 rounded-lg transition-all duration-200 {{ request('role') === 'agent' ? 'bg-orange-50 text-orange-700 font-medium' : 'text-gray-500 hover:bg-orange-50 hover:text-orange-600' }}">
                                    <i class="bi bi-person-badge-fill text-sm"></i>
                                    <span class="text-sm">Agents</span>
                                </a>
                                <a href="{{ route('admin.users', ['role' => 'investor']) }}"
                                   class="flex items-center gap-3 px-4 py-2 rounded-lg transition-all duration-200 {{ request('role') === 'investor' ? 'bg-orange-50 text-orange-700 font-medium' : 'text-gray-500 hover:bg-orange-50 hover:text-orange-600' }}">
                                    <i class="bi bi-graph-up-arrow text-sm"></i>
                                    <span class="text-sm">Investors</span>
                                </a>
                            </div>
                            @endif
                        </div>

                        <!-- Properties -->
                        <div>
                            <a href="{{ route('admin.properties') }}"
                               class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.properties*') ? 'bg-orange-50 text-orange-700 font-semibold' : 'text-gray-600 hover:bg-orange-50 hover:text-orange-600' }}">
                                <i class="bi bi-building-check text-lg"></i>
                                <span>Properties</span>
                                <i class="bi bi-chevron-right ml-auto text-xs"></i>
                            </a>
                            @if(request()->routeIs('admin.properties*'))
                            <div class="ml-4 mt-1 space-y-1 border-l-2 border-orange-200 pl-3">
                                <a href="{{ route('admin.properties') }}"
                                   class="flex items-center gap-3 px-4 py-2 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.properties') && !request()->routeIs('admin.properties.create') && !request()->routeIs('admin.properties.edit') ? 'bg-orange-50 text-orange-700 font-medium' : 'text-gray-500 hover:bg-orange-50 hover:text-orange-600' }}">
                                    <i class="bi bi-list-ul text-sm"></i>
                                    <span class="text-sm">All Properties</span>
                                </a>
                                <a href="{{ route('admin.properties.create') }}"
                                   class="flex items-center gap-3 px-4 py-2 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.properties.create') ? 'bg-orange-50 text-orange-700 font-medium' : 'text-gray-500 hover:bg-orange-50 hover:text-orange-600' }}">
                                    <i class="bi bi-plus-circle-fill text-sm"></i>
                                    <span class="text-sm">Create Property</span>
                                </a>
                            </div>
                            @endif
                        </div>

                        <!-- Inspections -->
                        <a href="{{ route('admin.bookings') }}"
                           class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.bookings*') ? 'bg-orange-50 text-orange-700 font-semibold' : 'text-gray-600 hover:bg-orange-50 hover:text-orange-600' }}">
                            <i class="bi bi-calendar-check-fill text-lg"></i>
                            <span>All Inspections</span>
                        </a>

                        <!-- Sales -->
                        <div>
                            <a href="{{ route('admin.sales') }}"
                               class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.sales*') ? 'bg-orange-50 text-orange-700 font-semibold' : 'text-gray-600 hover:bg-orange-50 hover:text-orange-600' }}">
                                <i class="bi bi-receipt text-lg"></i>
                                <span>Sales</span>
                                <i class="bi bi-chevron-right ml-auto text-xs"></i>
                            </a>
                            @if(request()->routeIs('admin.sales*'))
                            <div class="ml-4 mt-1 space-y-1 border-l-2 border-orange-200 pl-3">
                                <a href="{{ route('admin.sales') }}"
                                   class="flex items-center gap-3 px-4 py-2 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.sales') && !request()->routeIs('admin.sales.create') && !request()->routeIs('admin.sales.show') ? 'bg-orange-50 text-orange-700 font-medium' : 'text-gray-500 hover:bg-orange-50 hover:text-orange-600' }}">
                                    <i class="bi bi-list-ul text-sm"></i>
                                    <span class="text-sm">All Sales</span>
                                </a>
                                <a href="{{ route('admin.sales.create') }}"
                                   class="flex items-center gap-3 px-4 py-2 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.sales.create') ? 'bg-orange-50 text-orange-700 font-medium' : 'text-gray-500 hover:bg-orange-50 hover:text-orange-600' }}">
                                    <i class="bi bi-plus-circle-fill text-sm"></i>
                                    <span class="text-sm">Record Sale</span>
                                </a>
                            </div>
                            @endif
                        </div>

                        <!-- Finance & Reports -->
                        <div>
                            <a href="{{ route('admin.finance') }}"
                               class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.finance*') ? 'bg-orange-50 text-orange-700 font-semibold' : 'text-gray-600 hover:bg-orange-50 hover:text-orange-600' }}">
                                <i class="bi bi-cash-stack text-lg"></i>
                                <span>Finance & Reports</span>
                                <i class="bi bi-chevron-right ml-auto text-xs"></i>
                            </a>
                            @if(request()->routeIs('admin.finance*'))
                            <div class="ml-4 mt-1 space-y-1 border-l-2 border-orange-200 pl-3">
                                <a href="{{ route('admin.finance') }}"
                                   class="flex items-center gap-3 px-4 py-2 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.finance') ? 'bg-orange-50 text-orange-700 font-medium' : 'text-gray-500 hover:bg-orange-50 hover:text-orange-600' }}">
                                    <i class="bi bi-speedometer2 text-sm"></i>
                                    <span class="text-sm">Overview</span>
                                </a>
                                <a href="{{ route('admin.finance.expenses.create') }}"
                                   class="flex items-center gap-3 px-4 py-2 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.finance.expenses.*') ? 'bg-orange-50 text-orange-700 font-medium' : 'text-gray-500 hover:bg-orange-50 hover:text-orange-600' }}">
                                    <i class="bi bi-plus-circle-fill text-sm"></i>
                                    <span class="text-sm">Record Expense</span>
                                </a>
                                <a href="{{ route('admin.finance.purchases.create') }}"
                                   class="flex items-center gap-3 px-4 py-2 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.finance.purchases.*') ? 'bg-orange-50 text-orange-700 font-medium' : 'text-gray-500 hover:bg-orange-50 hover:text-orange-600' }}">
                                    <i class="bi bi-plus-circle-fill text-sm"></i>
                                    <span class="text-sm">Record Purchase</span>
                                </a>
                            </div>
                            @endif
                        </div>

                        <!-- Payments / Transaction History -->
                        <a href="{{ route('admin.payments') }}"
                           class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.payments*') ? 'bg-orange-50 text-orange-700 font-semibold' : 'text-gray-600 hover:bg-orange-50 hover:text-orange-600' }}">
                            <i class="bi bi-credit-card-2-front-fill text-lg"></i>
                            <span>Transaction History</span>
                        </a>

                        <!-- Purchase History -->
                        <a href="{{ route('admin.purchase-history') }}"
                           class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.purchase-history*') ? 'bg-orange-50 text-orange-700 font-semibold' : 'text-gray-600 hover:bg-orange-50 hover:text-orange-600' }}">
                            <i class="bi bi-cart-check text-lg"></i>
                            <span>Purchase History</span>
                        </a>

                        <!-- Sale History -->
                        <a href="{{ route('admin.sale-history') }}"
                           class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.sale-history*') ? 'bg-orange-50 text-orange-700 font-semibold' : 'text-gray-600 hover:bg-orange-50 hover:text-orange-600' }}">
                            <i class="bi bi-receipt text-lg"></i>
                            <span>Sale History</span>
                        </a>

                        <!-- Investments -->
                        <a href="{{ route('admin.investments') }}"
                           class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.investments*') ? 'bg-orange-50 text-orange-700 font-semibold' : 'text-gray-600 hover:bg-orange-50 hover:text-orange-600' }}">
                            <i class="bi bi-graph-up-arrow text-lg"></i>
                            <span>Investments</span>
                        </a>

                        <!-- Contact Messages -->
                        <a href="{{ route('admin.inquiries') }}"
                           class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.inquiries*') ? 'bg-orange-50 text-orange-700 font-semibold' : 'text-gray-600 hover:bg-orange-50 hover:text-orange-600' }}">
                            <i class="bi bi-envelope-open-fill text-lg"></i>
                            <span>Contact Messages</span>
                            @php
                                $newInquiries = \App\Models\Inquiry::where('status', 'new')->count();
                            @endphp
                            @if($newInquiries > 0)
                            <span class="ml-auto w-5 h-5 bg-orange-500 text-white text-xs font-bold rounded-full flex items-center justify-center shadow-sm">
                                {{ $newInquiries > 9 ? '9+' : $newInquiries }}
                            </span>
                            @endif
                        </a>

                        <!-- Blog Posts -->
                        <a href="{{ route('admin.blogs.index') }}"
                           class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.blogs*') ? 'bg-orange-50 text-orange-700 font-semibold' : 'text-gray-600 hover:bg-orange-50 hover:text-orange-600' }}">
                            <i class="bi bi-pencil-square text-lg"></i>
                            <span>Blog Posts</span>
                        </a>

                        <!-- Promotions -->
                        <a href="{{ route('admin.promotions') }}"
                           class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.promotions*') ? 'bg-orange-50 text-orange-700 font-semibold' : 'text-gray-600 hover:bg-orange-50 hover:text-orange-600' }}">
                            <i class="bi bi-megaphone-fill text-lg"></i>
                            <span>Promotions</span>
                        </a>

                        <!-- Activity Logs -->
                        <a href="{{ route('admin.activity-logs') }}"
                           class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.activity-logs') ? 'bg-orange-50 text-orange-700 font-semibold' : 'text-gray-600 hover:bg-orange-50 hover:text-orange-600' }}">
                            <i class="bi bi-clock-history text-lg"></i>
                            <span>Activity Logs</span>
                        </a>

                        <!-- Settings -->
                        <a href="{{ route('admin.settings') }}"
                           class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.settings*') ? 'bg-orange-50 text-orange-700 font-semibold' : 'text-gray-600 hover:bg-orange-50 hover:text-orange-600' }}">
                            <i class="bi bi-gear-wide-connected text-lg"></i>
                            <span>Settings</span>
                        </a>

                        <!-- Profile -->
                        <a href="{{ route('admin.profile') }}"
                           class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.profile') ? 'bg-orange-50 text-orange-700 font-semibold' : 'text-gray-600 hover:bg-orange-50 hover:text-orange-600' }}">
                            <i class="bi bi-person-circle text-lg"></i>
                            <span>My Profile</span>
                        </a>

                        <!-- Notifications -->
                        <a href="{{ route('notifications.index') }}"
                           class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('notifications.*') ? 'bg-orange-50 text-orange-700 font-semibold' : 'text-gray-600 hover:bg-orange-50 hover:text-orange-600' }}">
                            <i class="bi bi-bell-fill text-lg"></i>
                            <span>Notifications</span>
                            @php
                                $unreadCount = auth()->user()->unreadNotifications()->count();
                            @endphp
                            @if($unreadCount > 0)
                            <span class="ml-auto w-5 h-5 bg-orange-500 text-white text-xs font-bold rounded-full flex items-center justify-center shadow-sm">
                                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                            </span>
                            @endif
                        </a>
                    </div>

                    <!-- Logout -->
                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <form id="logoutFormSidebar">
                            @csrf
                            <button type="submit" class="flex items-center gap-3 px-4 py-3 rounded-lg text-red-600 hover:bg-red-50 w-full transition-colors">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col lg:ml-64">
            <!-- Top Bar - Fully Responsive -->
            <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-40 w-full" style="width: 100%; max-width: 100vw; overflow: visible;">
                <div class="w-full max-w-full" style="width: 100%; max-width: 100%; overflow: visible;">
                    <div class="flex items-center justify-between w-full px-3 py-3 md:px-6 md:py-4 gap-2" style="display: flex !important; flex-direction: row !important; flex-wrap: nowrap !important; align-items: center !important; justify-content: space-between !important; width: 100% !important;">
                        <!-- Left Section: Menu Button + Logo (Mobile) -->
                        <div class="flex items-center gap-2 md:gap-3 flex-shrink-0 min-w-0" style="display: flex !important; flex-direction: row !important; align-items: center !important; flex-shrink: 0 !important; flex-grow: 0 !important; order: 1 !important; margin-left: 0 !important;">
                            <!-- Mobile Menu Button -->
                            <button id="sidebarToggle" class="lg:hidden w-9 h-9 md:w-10 md:h-10 flex items-center justify-center text-gray-600 hover:text-primary-600 hover:bg-gray-100 rounded-lg transition-colors flex-shrink-0" style="display: flex !important; visibility: visible !important; opacity: 1 !important; flex-shrink: 0 !important;">
                                <i class="bi bi-list text-xl"></i>
                            </button>
                            
                            <!-- Logo/Brand (Hidden on mobile - only in sidebar) -->
                            <a href="{{ route('admin.dashboard') }}" class="lg:hidden flex items-center flex-shrink-0" style="display: none !important; visibility: hidden !important; opacity: 0 !important;">
                                <img src="{{ asset('images/logo.png') }}" alt="B-Family Homes" class="h-7 md:h-9 w-auto">
                            </a>
                        </div>

                        <!-- Right Section: Actions -->
                        <div class="flex items-center gap-2 md:gap-3 flex-shrink-0 ml-auto" style="display: flex !important; flex-direction: row !important; align-items: center !important; flex-shrink: 0 !important; flex-grow: 0 !important; margin-left: auto !important; margin-right: 0 !important; order: 2 !important;">
                            <!-- Search Bar (Desktop Only) -->
                            <div class="hidden md:flex items-center bg-gray-100 rounded-lg px-3 py-2 w-48 lg:w-64" style="display: none !important;">
                                <i class="bi bi-search text-gray-400 text-sm mr-2"></i>
                                <input type="text" placeholder="Search..." class="bg-transparent border-0 outline-none text-sm flex-1 w-0 min-w-0">
                            </div>

                            <!-- View Website (Desktop Only) -->
                            <a href="{{ route('home') }}" class="hidden lg:flex items-center gap-2 px-3 py-2 text-gray-600 hover:text-primary-600 hover:bg-gray-100 rounded-lg transition-colors text-sm whitespace-nowrap" style="display: none !important;">
                                <i class="bi bi-house-door"></i>
                                <span>Website</span>
                            </a>

                            <!-- Notifications (Always appears BEFORE profile) -->
                            @php
                                $unreadCount = auth()->user()->unreadNotifications()->count();
                            @endphp
                            <a href="{{ route('notifications.index') }}" class="relative w-10 h-10 flex items-center justify-center text-gray-600 hover:text-primary-600 hover:bg-gray-100 rounded-lg transition-colors flex-shrink-0" style="display: flex !important; visibility: visible !important; opacity: 1 !important; flex-shrink: 0 !important; min-width: 40px !important; order: 1 !important; position: relative !important;">
                                <i class="bi bi-bell text-lg md:text-xl"></i>
                                @if($unreadCount > 0)
                                <span class="absolute top-0.5 right-0.5 w-4 h-4 md:w-5 md:h-5 bg-red-500 text-white text-[10px] md:text-xs font-bold rounded-full flex items-center justify-center shadow-sm">
                                    {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                                </span>
                                @endif
                            </a>

                            <!-- User Profile (Always appears AFTER notifications) -->
                            <div class="flex items-center gap-2 md:gap-3 md:pl-3 md:border-l md:border-gray-200 flex-shrink-0" style="display: flex !important; visibility: visible !important; opacity: 1 !important; flex-shrink: 0 !important; min-width: 40px !important; order: 2 !important; position: relative !important;">
                                @if(auth()->user()->avatar)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" 
                                     alt="{{ auth()->user()->name }}"
                                     class="w-10 h-10 rounded-full object-cover border-2 border-primary-200 shadow-md flex-shrink-0"
                                     style="display: block !important; visibility: visible !important; opacity: 1 !important; flex-shrink: 0 !important; width: 40px !important; height: 40px !important; min-width: 40px !important; min-height: 40px !important; border-radius: 50% !important;">
                                @else
                                <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-full flex items-center justify-center text-white font-bold shadow-sm flex-shrink-0 text-base" style="display: flex !important; visibility: visible !important; opacity: 1 !important; flex-shrink: 0 !important; width: 40px !important; height: 40px !important; min-width: 40px !important; min-height: 40px !important; border-radius: 50% !important;">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                @endif
                                <!-- User Info (Shows on Desktop, Hidden on Mobile/Tablet) -->
                                <div class="hidden lg:block min-w-0 max-w-[150px]">
                                    <p class="text-sm font-semibold text-gray-900 truncate">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ ucfirst(auth()->user()->role) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto overflow-x-hidden p-0 md:p-6" style="max-width: 100vw; width: 100%;">
                <div class="w-full px-0 md:px-6 mx-auto" style="max-width: 100%; overflow-x: hidden;">
                    <!-- Greeting Section -->
                    <div class="w-full max-w-[90%] md:max-w-full mx-auto px-2 md:px-0 mb-4 md:mb-6 pt-4 md:pt-0">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2 md:gap-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-xl flex items-center justify-center shadow-sm flex-shrink-0">
                                    <i class="bi bi-sun-fill text-white text-lg md:text-xl"></i>
                                </div>
                                <div>
                                    <h2 class="text-lg md:text-xl font-bold bg-gradient-to-r from-orange-600 to-yellow-600 bg-clip-text text-transparent">
                                        Good {{ now()->format('H') < 12 ? 'Morning' : (now()->format('H') < 18 ? 'Afternoon' : 'Evening') }}, {{ explode(' ', auth()->user()->name)[0] }}!
                                    </h2>
                                    <p class="text-xs md:text-sm text-gray-500 mt-0.5">
                                        <i class="bi bi-calendar3 mr-1 text-primary-500"></i>{{ now()->format('l, F d, Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full max-w-[90%] md:max-w-full mx-auto">
                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Sidebar Overlay for Mobile -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden lg:hidden"></div>

    @if(session('success'))
    <script>
        window.addEventListener('DOMContentLoaded', function() {
            window.toast(@json(session('success')), 'success', 4000);
        });
    </script>
    @endif
    @if(session('error'))
    <script>
        window.addEventListener('DOMContentLoaded', function() {
            window.toast(@json(session('error')), 'error', 6000);
        });
    </script>
    @endif

    @stack('scripts')

    <script>
        // Mobile Sidebar Toggle
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        sidebarToggle?.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            sidebarOverlay.classList.toggle('hidden');
        });

        sidebarOverlay?.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
        });

        // Logout
        document.getElementById('logoutFormSidebar')?.addEventListener('submit', async function(e) {
            e.preventDefault();
            try {
                const data = await window.ajax('{{ route("logout") }}', 'POST');
                window.toast(data.message, 'success');
                setTimeout(() => window.location.href = data.redirect, 1000);
            } catch (error) {
                window.toast('Logout failed', 'error');
            }
        });

        // Mark notification as read (global function)
        window.markAsRead = async function(notificationId) {
            try {
                const data = await window.ajax(`{{ route("notifications.read", ":id") }}`.replace(':id', notificationId), 'POST');
                if (data.success) {
                    // Reload page to update notification count
                    setTimeout(() => window.location.reload(), 500);
                }
            } catch (error) {
                console.error('Failed to mark notification as read', error);
            }
        };

        // Hide preloader when page is loaded
        window.addEventListener('load', function() {
            const preloader = document.getElementById('preloader');
            if (preloader) {
                preloader.style.opacity = '0';
                setTimeout(function() {
                    preloader.style.display = 'none';
                }, 500);
            }
        });
    </script>
</body>
</html>
