<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'B-Family Homes - Premium Real Estate in Anambra, Nigeria | Properties for Sale, Rent & Investment')</title>
    <meta name="description" content="@yield('description', 'B-Family Homes Limited - Your trusted real estate partner in Anambra State, South East Nigeria. Find premium properties for sale, rent, and investment in Awkuzu, Anambra. Expert real estate services for local and diaspora clients.')">
    
    <!-- SEO Meta Tags -->
    <meta name="author" content="B-Family Homes Limited">
    <meta name="robots" content="index, follow">
    <meta name="language" content="English">
    <meta name="geo.region" content="NG-AN">
    <meta name="geo.placename" content="Anambra State, Enugu, Delta, Imo, Ebonyi, Abia, Rivers, Lagos, Abuja, Nigeria">
    <meta name="geo.position" content="6.2109;6.9367">
    <meta name="ICBM" content="6.2109, 6.9367">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('og:title', 'B-Family Homes - Premium Real Estate in Anambra, Nigeria')">
    <meta property="og:description" content="@yield('og:description', 'Your trusted real estate partner in Anambra State, South East Nigeria. Find premium properties for sale, rent, and investment.')">
    <meta property="og:image" content="@yield('og:image', asset('images/logo.png'))">
    <meta property="og:locale" content="en_NG">
    <meta property="og:site_name" content="B-Family Homes Limited">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="@yield('twitter:title', 'B-Family Homes - Premium Real Estate in Anambra, Nigeria')">
    <meta name="twitter:description" content="@yield('twitter:description', 'Your trusted real estate partner in Anambra State, South East Nigeria.')">
    <meta name="twitter:image" content="@yield('twitter:image', asset('images/logo.png'))">
    
    <!-- Additional SEO -->
    <meta name="theme-color" content="#1e40af">
    <link rel="canonical" href="{{ url()->current() }}">
    
    <!-- Structured Data (JSON-LD) -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "name": "B-Family Homes Limited",
        "url": "{{ url('/') }}",
        "potentialAction": {
            "@type": "SearchAction",
            "target": {
                "@type": "EntryPoint",
                "urlTemplate": "{{ route('properties.index') }}?search={search_term_string}"
            },
            "query-input": "required name=search_term_string"
        }
    }
    </script>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "RealEstateAgent",
        "name": "B-Family Homes Limited",
        "description": "Premium real estate services across Anambra State, Enugu, Delta, Imo, Ebonyi, Abia, Rivers, Lagos, and all Nigeria. Properties for sale, rent, and investment.",
        "url": "{{ url('/') }}",
        "logo": "{{ asset('images/logo.png') }}",
        "image": "{{ asset('images/logo.png') }}",
        "telephone": "+2348164856758",
        "email": "admin@bfamilyhomes.com",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "No1, Ananti Jerry Chijioke Street",
            "addressLocality": "Awkuzu",
            "addressRegion": "Anambra State",
            "addressCountry": "NG"
        },
        "areaServed": [
            {"@type": "State", "name": "Anambra State"},
            {"@type": "State", "name": "Enugu State"},
            {"@type": "State", "name": "Delta State"},
            {"@type": "State", "name": "Imo State"},
            {"@type": "State", "name": "Ebonyi State"},
            {"@type": "State", "name": "Abia State"},
            {"@type": "State", "name": "Rivers State"},
            {"@type": "State", "name": "Lagos State"},
            {"@type": "AdministrativeArea", "name": "Nigeria"}
        ],
        "geo": {
            "@type": "GeoCoordinates",
            "latitude": "6.2109",
            "longitude": "6.9367"
        },
        "sameAs": [
            "https://www.facebook.com/share/1DDk8U2Yhd/",
            "https://www.instagram.com/b_familyhomes",
            "https://www.tiktok.com/@b_family.homes"
        ]
    }
    </script>
    @stack('schemas')
    
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon/favicon-16x16.png') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon/favicon.ico') }}">
    <link rel="manifest" href="{{ asset('images/favicon/site.webmanifest') }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Preload preloader image for faster display -->
    <link rel="preload" as="image" href="{{ asset('images/preloader/preloader2.jpg') }}" fetchpriority="high">
    @stack('styles')
    <style>
        /* TOAST NOTIFICATIONS - Ensure they're ALWAYS on top */
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
            z-index: 99999 !important;
        }
    </style>
</head>
<body class="bg-gray-50 pb-16 lg:pb-0">
    @include('partials.impersonation-banner')
    <!-- Preloader -->
    <div id="preloader" class="fixed inset-0 bg-white z-[9999] flex items-center justify-center transition-opacity duration-300">
        <div class="text-center preloader-content">
            <img src="{{ asset('images/preloader/preloader2.jpg') }}" alt="Loading..." class="preloader-image" loading="eager" fetchpriority="high">
        </div>
    </div>
    
    <div id="toast-container"></div>

    <!-- Header -->
    @include('partials.header')

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('partials.footer')

    <!-- WhatsApp Float Button -->
    <a href="https://wa.me/{{ str_replace(['+', ' ', ''], '', config('bfamily.company.whatsapp')) }}" 
       target="_blank"
       class="fixed bottom-24 right-4 lg:bottom-6 lg:right-6 bg-green-500 hover:bg-green-600 text-white w-12 h-12 lg:w-14 lg:h-14 rounded-full flex items-center justify-center shadow-2xl hover:scale-110 transition-transform z-[60]">
        <i class="bi bi-whatsapp text-xl lg:text-2xl"></i>
    </a>

    <!-- Jivo Live Chat (deferred) -->
    @if(config('bfamily.company.jivo_widget_id'))
    <script defer>
        (function(){ var widget_id = '{{ config("bfamily.company.jivo_widget_id") }}';
        var s=document.createElement('script');s.type='text/javascript';s.async=true;s.src='//code.jivosite.com/script/widget/'+widget_id;var ss=document.getElementsByTagName('script')[0];ss.parentNode.insertBefore(s,ss);})();
    </script>
    @endif

    @stack('scripts')
    
    <script>
        // Optimized preloader - works correctly and doesn't wait for promotion images
        (function() {
            const preloader = document.getElementById('preloader');
            if (!preloader) {
                console.warn('Preloader element not found');
                return;
            }
            
            let isHidden = false;
            
            function hidePreloader() {
                if (isHidden) return;
                isHidden = true;
                preloader.style.opacity = '0';
                setTimeout(function() {
                    preloader.style.display = 'none';
                }, 300);
            }
            
            // Primary: Hide when DOM is ready (much faster than waiting for all resources)
            // This ensures we don't wait for images, especially promotion images
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', function() {
                    hidePreloader();
                });
            } else {
                // DOM already loaded
                hidePreloader();
            }
            
            // Maximum timeout: hide after 1.5 seconds regardless
            setTimeout(hidePreloader, 1500);
            
            // Fallback: hide when page fully loads (but this should rarely be needed)
            // The promotion image uses data-src and loads after preloader, so it won't block this
            window.addEventListener('load', function() {
                // Only use this as a last resort fallback
                if (!isHidden) {
                    hidePreloader();
                }
            });
        })();

        // Initialize wishlist icons on page load
        document.addEventListener('DOMContentLoaded', function() {
            const wishlistButtons = document.querySelectorAll('.wishlist-btn');
            wishlistButtons.forEach(btn => {
                const propertyId = btn.getAttribute('data-property-id');
                const wishlist = getWishlist();
                const icon = btn.querySelector('.wishlist-icon');
                if (wishlist.includes(propertyId)) {
                    icon.classList.remove('bi-heart');
                    icon.classList.add('bi-heart-fill', 'text-red-500');
                    btn.classList.add('bg-red-50');
                }
            });
        });

        // Wishlist functionality using localStorage
        function getWishlist() {
            const wishlist = localStorage.getItem('property_wishlist');
            return wishlist ? JSON.parse(wishlist) : [];
        }

        function saveWishlist(wishlist) {
            localStorage.setItem('property_wishlist', JSON.stringify(wishlist));
        }

        function toggleWishlist(propertyId, button) {
            const wishlist = getWishlist();
            const icon = button.querySelector('.wishlist-icon');
            const index = wishlist.indexOf(propertyId.toString());
            
            if (index > -1) {
                // Remove from wishlist
                wishlist.splice(index, 1);
                icon.classList.remove('bi-heart-fill', 'text-red-500');
                icon.classList.add('bi-heart');
                button.classList.remove('bg-red-50');
                if (window.toast) {
                    window.toast('Removed from wishlist', 'info');
                }
            } else {
                // Add to wishlist
                wishlist.push(propertyId.toString());
                icon.classList.remove('bi-heart');
                icon.classList.add('bi-heart-fill', 'text-red-500');
                button.classList.add('bg-red-50');
                if (window.toast) {
                    window.toast('Added to wishlist', 'success');
                }
            }
            
            saveWishlist(wishlist);
        }

        // Share property functionality
        function sharePropertyCard(url, title) {
            const shareData = {
                title: title,
                text: `Check out this property: ${title}`,
                url: url
            };

            if (navigator.share) {
                navigator.share(shareData)
                    .then(() => {
                        if (window.toast) {
                            window.toast('Property shared successfully!', 'success');
                        }
                    })
                    .catch((error) => {
                        console.log('Error sharing', error);
                        fallbackShare(url, title);
                    });
            } else {
                fallbackShare(url, title);
            }
        }

        function fallbackShare(url, title) {
            // Fallback: Copy to clipboard
            if (navigator.clipboard) {
                navigator.clipboard.writeText(url).then(() => {
                    if (window.toast) {
                        window.toast('Link copied to clipboard!', 'success');
                    }
                }).catch(() => {
                    // Show URL in prompt if clipboard fails
                    prompt('Copy this link:', url);
                });
            } else {
                // Show URL in prompt
                prompt('Copy this link:', url);
            }
        }

        // Global payment initiation function
        async function initiatePayment(propertyId) {
            if (!window.ajax) {
                console.error('AJAX helper not available');
                return;
            }

            try {
                const response = await window.ajax('{{ route("payments.store") }}', 'POST', {
                    property_id: propertyId
                });
                
                if (response.success && response.redirect) {
                    window.location.href = response.redirect;
                } else {
                    if (window.toast) {
                        window.toast(response.message || 'Payment initiated successfully', 'success');
                    }
                }
            } catch (error) {
                if (window.toast) {
                    window.toast(error.message || 'Failed to initiate payment', 'error');
                }
            }
        }
    </script>
    
    <!-- Toast Container -->
    <div id="toast-container" class="toast-container"></div>

    <!-- Mobile Bottom Navigation -->
    @include('partials.bottom-nav')
</body>
</html>
