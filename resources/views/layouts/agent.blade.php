<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Agent Dashboard') - B-Family Homes</title>
    
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
                    <a href="{{ route('agent.dashboard') }}" class="flex items-center justify-center lg:justify-start">
                        <img src="{{ asset('images/logo.png') }}" alt="B-Family Homes" class="h-10 w-auto">
                    </a>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 overflow-y-auto p-4">
                    <div class="mb-4">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 mb-2">NAVIGATION</p>
                    </div>
                    <div class="space-y-1">
                        <a href="{{ route('agent.dashboard') }}" 
                           class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('agent.dashboard') ? 'bg-gradient-to-r from-orange-500 to-yellow-500 text-white font-semibold shadow-sm' : 'text-gray-600 hover:bg-orange-50 hover:text-orange-600' }}">
                            <i class="bi bi-speedometer2 text-lg"></i>
                            <span>Dashboard</span>
                        </a>

                        <a href="{{ route('agent.properties.index') }}" 
                           class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('agent.properties.*') ? 'bg-gradient-to-r from-orange-500 to-yellow-500 text-white font-semibold shadow-sm' : 'text-gray-600 hover:bg-orange-50 hover:text-orange-600' }}">
                            <i class="bi bi-house-door text-lg"></i>
                            <span>My Properties</span>
                        </a>

                        <a href="{{ route('agent.properties.create') }}" 
                           class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 text-gray-600 hover:bg-orange-50 hover:text-orange-600">
                            <i class="bi bi-plus-circle text-lg"></i>
                            <span>Add Property</span>
                        </a>

                        <a href="{{ route('agent.inquiries') }}" 
                           class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('agent.inquiries') ? 'bg-gradient-to-r from-orange-500 to-yellow-500 text-white font-semibold shadow-sm' : 'text-gray-600 hover:bg-orange-50 hover:text-orange-600' }}">
                            <i class="bi bi-chat-dots text-lg"></i>
                            <span>Inquiries</span>
                        </a>

                        <a href="{{ route('agent.transactions') }}" 
                           class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('agent.transactions') ? 'bg-gradient-to-r from-orange-500 to-yellow-500 text-white font-semibold shadow-sm' : 'text-gray-600 hover:bg-orange-50 hover:text-orange-600' }}">
                            <i class="bi bi-credit-card text-lg"></i>
                            <span>Transaction History</span>
                        </a>

                        <a href="{{ route('agent.profile') }}" 
                           class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('agent.profile') ? 'bg-gradient-to-r from-orange-500 to-yellow-500 text-white font-semibold shadow-sm' : 'text-gray-600 hover:bg-orange-50 hover:text-orange-600' }}">
                            <i class="bi bi-person text-lg"></i>
                            <span>My Profile</span>
                        </a>

                        <a href="{{ route('notifications.index') }}" 
                           class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('notifications.*') ? 'bg-gradient-to-r from-orange-500 to-yellow-500 text-white font-semibold shadow-sm' : 'text-gray-600 hover:bg-orange-50 hover:text-orange-600' }}">
                            <i class="bi bi-bell text-lg"></i>
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

                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <form id="logoutFormSidebar">
                            @csrf
                            <button type="submit" class="flex items-center gap-3 px-4 py-3 rounded-lg text-red-600 hover:bg-red-50 w-full">
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
                    <button id="sidebarToggle" class="lg:hidden w-10 h-10 flex items-center justify-center text-gray-600 hover:text-primary-600 hover:bg-gray-100 rounded-lg transition-colors flex-shrink-0">
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
                            onmouseover="this.style.background='#fff7ed'; this.style.color='#ea580c';"
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
                                 style="width: 40px !important; height: 40px !important; min-width: 40px !important; min-height: 40px !important; max-width: 40px !important; max-height: 40px !important; border-radius: 50% !important; object-fit: cover !important; border: 2px solid #fed7aa !important; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1) !important; display: block !important; flex-shrink: 0 !important; visibility: visible !important; opacity: 1 !important; position: relative !important; box-sizing: border-box !important;">
                            @else
                            <div style="width: 40px !important; height: 40px !important; min-width: 40px !important; min-height: 40px !important; max-width: 40px !important; max-height: 40px !important; background: linear-gradient(135deg, #f97316 0%, #eab308 100%) !important; border-radius: 50% !important; display: flex !important; align-items: center !important; justify-content: center !important; color: white !important; font-weight: bold !important; font-size: 1rem !important; flex-shrink: 0 !important; visibility: visible !important; opacity: 1 !important; position: relative !important; box-sizing: border-box !important;">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-0 md:p-6">
                <div class="w-full px-0 md:px-6 mx-auto" style="max-width: 100%;">
                    <!-- Greeting Section -->
                    <div class="w-full max-w-[90%] md:max-w-full mx-auto px-2 md:px-0 mb-4 md:mb-6 pt-4 md:pt-0">
                        @php
                            $hour = now()->hour;
                            if ($hour < 12) $greeting = 'Good Morning';
                            elseif ($hour < 17) $greeting = 'Good Afternoon';
                            else $greeting = 'Good Evening';
                        @endphp
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2 md:gap-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-xl flex items-center justify-center shadow-sm flex-shrink-0">
                                    <i class="bi bi-sun-fill text-white text-lg md:text-xl"></i>
                                </div>
                                <div>
                                    <h2 class="text-lg md:text-xl font-bold bg-gradient-to-r from-orange-600 to-yellow-600 bg-clip-text text-transparent">
                                        {{ $greeting }}, {{ explode(' ', auth()->user()->name)[0] }}!
                                    </h2>
                                    <p class="text-xs md:text-sm text-gray-500 mt-0.5">
                                        <i class="bi bi-calendar3 mr-1 text-orange-500"></i>{{ now()->format('l, F d, Y') }}
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

    <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden lg:hidden"></div>

    @stack('scripts')

    <script>
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            sidebarOverlay.classList.toggle('hidden');
        });

        sidebarOverlay.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
        });

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
