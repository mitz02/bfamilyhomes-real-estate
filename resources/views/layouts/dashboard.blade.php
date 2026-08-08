<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - B-Family Homes</title>
    
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
        
        /* Ensure toast is above preloader and sidebar */
        #preloader {
            z-index: 99999 !important;
        }
        
        #sidebar {
            z-index: 50 !important;
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
                    <a href="{{ route('dashboard') }}" class="flex items-center justify-center lg:justify-start">
                        <img src="{{ asset('images/logo.png') }}" alt="B-Family Homes" class="h-10 w-auto">
                    </a>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 overflow-y-auto p-4">
                    <div class="space-y-1">
                        <a href="{{ route('dashboard') }}" 
                           class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-orange-500 to-yellow-500 text-white font-semibold shadow-sm' : 'text-gray-600 hover:bg-orange-50 hover:text-orange-600' }}">
                            <i class="bi bi-speedometer2"></i>
                            <span>Dashboard</span>
                        </a>

                        <a href="{{ route('properties.index') }}" 
                           class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm text-gray-600 hover:bg-orange-50 hover:text-orange-600">
                            <i class="bi bi-search"></i>
                            <span>Browse Properties</span>
                        </a>

                        <a href="{{ route('inspections.index') }}" 
                           class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm {{ request()->routeIs('inspections.*') ? 'bg-gradient-to-r from-orange-500 to-yellow-500 text-white font-semibold shadow-sm' : 'text-gray-600 hover:bg-orange-50 hover:text-orange-600' }}">
                            <i class="bi bi-calendar-check"></i>
                            <span>My Inspections</span>
                        </a>

                        <a href="{{ route('payments.index') }}" 
                           class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm {{ request()->routeIs('payments.*') ? 'bg-gradient-to-r from-orange-500 to-yellow-500 text-white font-semibold shadow-sm' : 'text-gray-600 hover:bg-orange-50 hover:text-orange-600' }}">
                            <i class="bi bi-credit-card"></i>
                            <span>Transaction History</span>
                        </a>

                        <a href="{{ route('dashboard.profile') }}" 
                           class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm {{ request()->routeIs('dashboard.profile') ? 'bg-gradient-to-r from-orange-500 to-yellow-500 text-white font-semibold shadow-sm' : 'text-gray-600 hover:bg-orange-50 hover:text-orange-600' }}">
                            <i class="bi bi-person"></i>
                            <span>My Profile</span>
                        </a>

                        <a href="{{ route('notifications.index') }}" 
                           class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm {{ request()->routeIs('notifications.*') ? 'bg-gradient-to-r from-orange-500 to-yellow-500 text-white font-semibold shadow-sm' : 'text-gray-600 hover:bg-orange-50 hover:text-orange-600' }}">
                            <i class="bi bi-bell"></i>
                            <span>Notifications</span>
                            @php
                                $unreadCount = auth()->user()->unreadNotifications()->count();
                            @endphp
                            @if($unreadCount > 0)
                            <span class="ml-auto w-5 h-5 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center">
                                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                            </span>
                            @endif
                        </a>
                    </div>

                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <form id="logoutFormSidebar">
                            @csrf
                            <button type="submit" class="flex items-center gap-3 px-4 py-3 rounded-lg text-red-600 hover:bg-red-50 w-full text-sm">
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
            <!-- Top Bar -->
            <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-40 w-full" style="width: 100% !important; max-width: 100vw !important; overflow-x: hidden !important; overflow-y: visible !important; box-sizing: border-box !important;">
                <div class="flex items-center justify-between px-3 py-3 md:px-4 md:py-4 w-full max-w-full" style="width: 100% !important; max-width: 100% !important; overflow-x: hidden !important; overflow-y: visible !important; padding-left: 0.75rem !important; padding-right: 0.75rem !important; display: flex !important; align-items: center !important; justify-content: space-between !important; box-sizing: border-box !important; position: relative !important;">
                    <!-- Mobile Menu Button -->
                    <button id="sidebarToggle" class="lg:hidden w-10 h-10 flex items-center justify-center text-gray-600 hover:text-orange-600 hover:bg-orange-50 rounded-lg transition-colors flex-shrink-0">
                        <i class="bi bi-list text-xl"></i>
                    </button>

                    <!-- User Menu - Right Aligned -->
                    <div class="flex items-center gap-2 md:gap-4 ml-auto flex-shrink-0" style="margin-left: auto !important; display: flex !important; align-items: center !important; gap: 0.5rem !important; flex-shrink: 0 !important; margin-right: 0 !important; padding-right: 0 !important; overflow: visible !important; max-width: calc(100% - 60px) !important; min-width: 0 !important; box-sizing: border-box !important; position: relative !important;">
                        <!-- Notifications -->
                        @php
                            $unreadCount = auth()->user()->unreadNotifications()->count();
                        @endphp
                        <a href="{{ route('notifications.index') }}" 
                           class="relative flex-shrink-0"
                           style="position: relative !important; width: 36px !important; height: 36px !important; display: flex !important; align-items: center !important; justify-content: center !important; color: #4b5563 !important; border-radius: 0.5rem !important; transition: all 0.3s ease !important; flex-shrink: 0 !important; margin-left: auto !important; margin-right: 0 !important;"
                           onmouseover="this.style.background='#f3f4f6'; this.style.color='#ea580c';"
                           onmouseout="this.style.background='transparent'; this.style.color='#4b5563';">
                            <i class="bi bi-bell" style="font-size: 1.125rem !important;"></i>
                            @if($unreadCount > 0)
                            <span style="position: absolute !important; top: 0 !important; right: 0 !important; width: 16px !important; height: 16px !important; background: #ef4444 !important; color: white !important; font-size: 10px !important; font-weight: bold !important; border-radius: 50% !important; display: flex !important; align-items: center !important; justify-content: center !important;">
                                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                            </span>
                            @endif
                        </a>

                        <!-- Profile Image -->
                        <div class="flex items-center flex-shrink-0" style="display: flex !important; align-items: center !important; flex-shrink: 0 !important; margin-left: 0.5rem !important; margin-right: 0 !important; order: 2 !important; position: relative !important; visibility: visible !important; opacity: 1 !important; overflow: visible !important; max-width: 40px !important; min-width: 40px !important; box-sizing: border-box !important;">
                            @if(auth()->user()->avatar)
                            <img src="{{ asset('storage/' . auth()->user()->avatar) }}" 
                                 alt="{{ auth()->user()->name }}"
                                 style="width: 40px !important; height: 40px !important; min-width: 40px !important; min-height: 40px !important; max-width: 40px !important; max-height: 40px !important; border-radius: 50% !important; object-fit: cover !important; border: 2px solid #fef3e7 !important; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1) !important; display: block !important; flex-shrink: 0 !important; visibility: visible !important; opacity: 1 !important; position: relative !important; box-sizing: border-box !important;">
                            @else
                            <div style="width: 40px !important; height: 40px !important; min-width: 40px !important; min-height: 40px !important; max-width: 40px !important; max-height: 40px !important; background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%) !important; border-radius: 50% !important; display: flex !important; align-items: center !important; justify-content: center !important; color: white !important; font-weight: bold !important; font-size: 1rem !important; flex-shrink: 0 !important; visibility: visible !important; opacity: 1 !important; position: relative !important; box-sizing: border-box !important;">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">
                <!-- Greeting Section -->
                <div class="mb-6">
                    <h2 class="text-xl md:text-2xl font-bold text-gray-900">
                        Hi, {{ auth()->user()->name }}!
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">{{ now()->format('l, F d, Y') }}</p>
                </div>
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Sidebar Overlay for Mobile -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden lg:hidden"></div>

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
