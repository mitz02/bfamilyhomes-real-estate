<!-- Mobile Bottom Navigation (Hidden on desktop) -->
<div class="fixed bottom-0 w-full bg-white border-t border-gray-200 lg:hidden z-50 pb-safe shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)]">
    <div class="flex items-center justify-around h-16">
        <!-- Home -->
        <a href="{{ route('home') }}" class="flex flex-col items-center justify-center w-full h-full space-y-0.5 text-gray-500 hover:text-orange-600 transition-colors {{ request()->routeIs('home') ? 'text-orange-600' : '' }}">
            <i class="bi {{ request()->routeIs('home') ? 'bi-house-fill' : 'bi-house' }} text-xl"></i>
            <span class="text-[11px] font-semibold">Home</span>
        </a>

        <!-- Properties / Search -->
        <a href="{{ route('properties.index') }}" class="flex flex-col items-center justify-center w-full h-full space-y-0.5 text-gray-500 hover:text-orange-600 transition-colors {{ request()->routeIs('properties.*') && !request('type') ? 'text-orange-600' : '' }}">
            <i class="bi {{ request()->routeIs('properties.*') && !request('type') ? 'bi-grid-fill' : 'bi-grid' }} text-xl"></i>
            <span class="text-[11px] font-semibold">Explore</span>
        </a>

        <!-- Invest -->
        <a href="{{ route('properties.index', ['type' => 'Investment']) }}" class="flex flex-col items-center justify-center w-full h-full space-y-0.5 text-gray-500 hover:text-orange-600 transition-colors {{ request('type') == 'Investment' ? 'text-orange-600' : '' }}">
            <i class="bi {{ request('type') == 'Investment' ? 'bi-bar-chart-fill' : 'bi-bar-chart' }} text-xl"></i>
            <span class="text-[11px] font-semibold">Invest</span>
        </a>

        <!-- User / Auth -->
        <button id="bottomNavUserBtn" type="button" class="flex flex-col items-center justify-center w-full h-full space-y-0.5 text-gray-500 hover:text-orange-600 transition-colors">
            <i class="bi bi-person-circle text-xl"></i>
            <span class="text-[11px] font-semibold">Account</span>
        </button>
    </div>
</div>

<!-- Auth Modal -->
<div id="authModal" class="fixed inset-0 z-[9999] hidden">
    <div class="absolute inset-0 bg-black/50" onclick="closeAuthModal()"></div>
    <div class="absolute bottom-0 left-0 right-0 bg-white rounded-t-2xl shadow-2xl p-6 pb-10 animate-slide-up">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-gray-900">Account</h3>
            <button onclick="closeAuthModal()" class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center hover:bg-gray-200 transition-colors">
                <i class="bi bi-x text-gray-600 text-lg"></i>
            </button>
        </div>
        @auth
            <div class="flex items-center gap-3 mb-6 p-4 bg-orange-50 rounded-xl">
                <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-full flex items-center justify-center text-white text-lg font-bold">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-bold text-gray-900 text-sm truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                </div>
            </div>
            <div class="space-y-2">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 p-3.5 bg-gray-50 hover:bg-orange-50 rounded-xl transition-colors group">
                    <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-xl flex items-center justify-center text-white shadow">
                        <i class="bi bi-speedometer2 text-lg"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-gray-900 text-sm group-hover:text-orange-600 transition-colors">Dashboard</p>
                        <p class="text-xs text-gray-500">Manage your account & properties</p>
                    </div>
                    <i class="bi bi-chevron-right text-gray-400 group-hover:text-orange-500 transition-colors"></i>
                </a>
                <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 p-3.5 bg-gray-50 hover:bg-red-50 rounded-xl transition-colors group">
                        <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center text-red-600 shadow">
                            <i class="bi bi-box-arrow-right text-lg"></i>
                        </div>
                        <div class="flex-1 text-left">
                            <p class="font-semibold text-gray-900 text-sm group-hover:text-red-600 transition-colors">Logout</p>
                            <p class="text-xs text-gray-500">Sign out of your account</p>
                        </div>
                        <i class="bi bi-chevron-right text-gray-400 group-hover:text-red-500 transition-colors"></i>
                    </button>
                </form>
            </div>
        @else
            <div class="space-y-3">
                <a href="{{ route('login') }}" class="flex items-center gap-3 p-3.5 bg-gradient-to-r from-orange-500 to-yellow-500 hover:from-orange-600 hover:to-yellow-600 text-white rounded-xl transition-all shadow-md group">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="bi bi-box-arrow-in-right text-lg"></i>
                    </div>
                    <div class="flex-1 text-left">
                        <p class="font-semibold text-sm">Login</p>
                        <p class="text-xs text-white/80">Access your account</p>
                    </div>
                    <i class="bi bi-chevron-right text-white/60 group-hover:translate-x-0.5 transition-transform"></i>
                </a>
                <a href="{{ route('register') }}" class="flex items-center gap-3 p-3.5 bg-gray-50 hover:bg-orange-50 rounded-xl transition-colors group border border-gray-200">
                    <div class="w-10 h-10 bg-white border-2 border-orange-200 rounded-xl flex items-center justify-center text-orange-500 shadow">
                        <i class="bi bi-person-plus text-lg"></i>
                    </div>
                    <div class="flex-1 text-left">
                        <p class="font-semibold text-gray-900 text-sm group-hover:text-orange-600 transition-colors">Create Account</p>
                        <p class="text-xs text-gray-500">Join B-Family Homes today</p>
                    </div>
                    <i class="bi bi-chevron-right text-gray-400 group-hover:text-orange-500 transition-colors"></i>
                </a>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <p class="text-xs text-gray-400 text-center">By continuing, you agree to our <a href="{{ route('terms') }}" class="text-orange-500 underline">Terms</a> & <a href="{{ route('privacy') }}" class="text-orange-500 underline">Privacy Policy</a></p>
            </div>
        @endauth
    </div>
</div>

<style>
    .pb-safe {
        padding-bottom: env(safe-area-inset-bottom);
    }
    @keyframes slide-up {
        from { transform: translateY(100%); }
        to { transform: translateY(0); }
    }
    .animate-slide-up {
        animation: slide-up 0.25s ease-out;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const userBtn = document.getElementById('bottomNavUserBtn');
        const authModal = document.getElementById('authModal');

        if (userBtn && authModal) {
            userBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                authModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            });
        }
    });

    function closeAuthModal() {
        const authModal = document.getElementById('authModal');
        if (authModal) {
            authModal.classList.add('hidden');
            document.body.style.overflow = '';
        }
    }
</script>
