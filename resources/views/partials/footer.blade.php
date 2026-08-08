<footer class="bg-gray-900 text-gray-300 pt-16 pb-8">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
            <!-- About -->
            <div>
                <h3 class="text-white text-lg font-bold mb-4">About B-Family Homes</h3>
                <p class="text-sm leading-relaxed mb-4">
                    Your trusted real estate partner in Nigeria, serving local and diaspora clients with premium properties for rent, sale, and investment.
                </p>
                <div class="flex gap-3">
                    <a href="https://www.facebook.com/share/1DDk8U2Yhd/" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-primary-500 hover:bg-primary-600 rounded-full flex items-center justify-center transition-colors">
                        <i class="bi bi-facebook text-white"></i>
                    </a>
                    <a href="https://www.instagram.com/b_familyhomes?igsh=MXcxcTFveXJyMWp0bw==" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-primary-500 hover:bg-primary-600 rounded-full flex items-center justify-center transition-colors">
                        <i class="bi bi-instagram text-white"></i>
                    </a>
                    <a href="https://www.tiktok.com/@b_family.homes" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-primary-500 hover:bg-primary-600 rounded-full flex items-center justify-center transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" class="text-white">
                            <path d="M9 0h1.98c.144.715.54 1.617 1.235 2.512C12.895 3.389 13.797 4 15 4v2c-1.753 0-3.07-.814-4-1.829V11a5 5 0 1 1-5-5v2a3 3 0 1 0 3 3V0Z"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-white text-lg font-bold mb-4">Quick Links</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" class="hover:text-primary-500 transition-colors">Home</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-primary-500 transition-colors">About Us</a></li>
                    <li><a href="{{ route('properties.index') }}" class="hover:text-primary-500 transition-colors">Properties</a></li>
                    <li><a href="{{ route('properties.index', ['type' => 'Investment']) }}" class="hover:text-primary-500 transition-colors">Invest</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-primary-500 transition-colors">Contact Us</a></li>
                </ul>
            </div>

            <!-- Legal -->
            <div>
                <h3 class="text-white text-lg font-bold mb-4">Legal</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="hover:text-primary-500 transition-colors">Privacy Policy</a></li>
                    <li><a href="/terms-conditions" class="hover:text-primary-500 transition-colors">Terms & Conditions</a></li>
                    <li><a href="/refund-policy" class="hover:text-primary-500 transition-colors">Refund Policy</a></li>
                    <li><a href="#" class="hover:text-primary-500 transition-colors">Cookie Policy</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h3 class="text-white text-lg font-bold mb-4">Contact Info</h3>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-start gap-2">
                        <i class="bi bi-geo-alt-fill text-primary-500 mt-1"></i>
                        <span>{{ config('bfamily.company.address') }}</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="bi bi-telephone-fill text-primary-500"></i>
                        <a href="tel:{{ config('bfamily.company.phone') }}" class="hover:text-primary-500">
                            {{ config('bfamily.company.phone') }}
                        </a>
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="bi bi-envelope-fill text-primary-500"></i>
                        <a href="mailto:{{ config('bfamily.company.email') }}" class="hover:text-primary-500">
                            {{ config('bfamily.company.email') }}
                        </a>
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="bi bi-whatsapp text-primary-500"></i>
                        <a href="https://wa.me/{{ str_replace(['+', ' '], '', config('bfamily.company.whatsapp')) }}" 
                           class="hover:text-primary-500">
                            {{ config('bfamily.company.whatsapp') }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Copyright -->
        <div class="border-t border-gray-800 pt-8 text-center text-sm">
            <p>
                Copyright &copy; {{ date('Y') }} 
                <a href="{{ route('home') }}" class="text-primary-500 hover:text-primary-400">B-Family Homes Limited</a>.
                Designed with <i class="bi bi-heart-fill text-red-500"></i> by 
                <a href="#" class="text-primary-500 hover:text-primary-400">Destiny Technology Hub</a>
            </p>
            <p class="mt-2 text-gray-500">All rights reserved.</p>
        </div>
    </div>
</footer>
