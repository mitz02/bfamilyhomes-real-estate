<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Investor Dashboard') - B-Family Homes</title>
    
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
                <div class="p-6 border-b border-gray-200">
                    <a href="{{ route('investor.dashboard') }}" class="flex items-center justify-center lg:justify-start">
                        <img src="{{ asset('images/logo.png') }}" alt="B-Family Homes" class="h-10 w-auto">
                    </a>
                </div>

                <nav class="flex-1 overflow-y-auto p-4">
                    <div class="space-y-1">
                        <a href="{{ route('investor.dashboard') }}" 
                           class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('investor.dashboard') ? 'bg-gradient-to-r from-orange-500 to-yellow-500 text-white font-semibold shadow-sm' : 'text-gray-600 hover:bg-orange-50 hover:text-orange-600' }}">
                            <i class="bi bi-speedometer2 text-lg"></i>
                            <span>Dashboard</span>
                        </a>

                        <a href="{{ route('investor.investments') }}" 
                           class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('investor.investments') ? 'bg-gradient-to-r from-orange-500 to-yellow-500 text-white font-semibold shadow-sm' : 'text-gray-600 hover:bg-orange-50 hover:text-orange-600' }}">
                            <i class="bi bi-graph-up text-lg"></i>
                            <span>My Investments</span>
                        </a>

                        <a href="{{ route('payments.index') }}" 
                           class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('payments.*') ? 'bg-gradient-to-r from-orange-500 to-yellow-500 text-white font-semibold shadow-sm' : 'text-gray-600 hover:bg-orange-50 hover:text-orange-600' }}">
                            <i class="bi bi-credit-card"></i>
                            <span>Transaction History</span>
                        </a>

                        <a href="{{ route('properties.index', ['type' => 'Investment']) }}" 
                           class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 text-gray-600 hover:bg-orange-50 hover:text-orange-600">
                            <i class="bi bi-search text-lg"></i>
                            <span>Browse Opportunities</span>
                        </a>

                        <a href="{{ route('investor.profile') }}" 
                           class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('investor.profile') ? 'bg-gradient-to-r from-orange-500 to-yellow-500 text-white font-semibold shadow-sm' : 'text-gray-600 hover:bg-orange-50 hover:text-orange-600' }}">
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
            <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-40 w-full">
                <div class="flex items-center justify-between px-3 py-3 md:px-4 md:py-4 w-full max-w-full">
                    <button id="sidebarToggle" class="lg:hidden w-10 h-10 flex items-center justify-center text-gray-600 hover:text-blue-900 hover:bg-gray-100 rounded-lg transition-colors flex-shrink-0">
                        <i class="bi bi-list text-xl"></i>
                    </button>

                    <div class="flex items-center gap-2 md:gap-4 ml-auto flex-shrink-0">
                        @php
                            $unreadCount = auth()->user()->unreadNotifications()->count();
                        @endphp
                        <a href="{{ route('notifications.index') }}" 
                           class="relative w-9 h-9 flex items-center justify-center text-gray-500 hover:text-orange-600 hover:bg-orange-50 rounded-lg transition-colors flex-shrink-0">
                            <i class="bi bi-bell text-lg"></i>
                            @if($unreadCount > 0)
                            <span class="absolute top-0 right-0 w-4 h-4 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center">
                                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                            </span>
                            @endif
                        </a>

                        <div class="flex items-center flex-shrink-0">
                            @if(auth()->user()->avatar)
                            <img src="{{ asset('storage/' . auth()->user()->avatar) }}" 
                                 alt="{{ auth()->user()->name }}"
                                 class="w-10 h-10 rounded-full object-cover ring-2 ring-orange-100 shadow-sm">
                            @else
                            <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-full flex items-center justify-center text-white font-bold text-sm ring-2 ring-orange-100 shadow-sm">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-4 md:p-6">
                @yield('content')
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
