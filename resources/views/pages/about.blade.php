@extends('layouts.app')

@section('title', 'About B-Family Homes - #1 Real Estate Agency in Anambra, Enugu, Delta, Imo, Abia, Nigeria')
@section('description', 'Learn about B-Family Homes Limited, your trusted real estate partner in Anambra State, South East Nigeria. We specialize in premium properties for sale, rent, and investment across Anambra, Enugu, Delta, Imo, Ebonyi, Abia, Rivers, Lagos, and Abuja. Expert real estate services for local and diaspora clients.')
@section('og:title', 'About B-Family Homes - Leading Real Estate Agency in Anambra & South East Nigeria')
@section('og:description', 'Discover why B-Family Homes is the trusted real estate partner across Anambra, Enugu, Delta, Imo, Ebonyi, Abia, Rivers, and all Nigeria.')

@section('content')
<!-- Hero Section -->
<section class="relative overflow-hidden bg-gradient-to-br from-orange-50 via-white to-yellow-50 py-20">
    <div class="absolute inset-0 z-0 opacity-[0.04]" style="background-image: radial-gradient(#f97316 1px, transparent 1px); background-size: 30px 30px;"></div>
    <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-orange-100/60 blur-3xl"></div>
    <div class="absolute -bottom-32 -left-32 w-[30rem] h-[30rem] rounded-full bg-yellow-100/50 blur-3xl"></div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-orange-100 rounded-full mb-6">
                <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                <span class="text-orange-600 text-sm font-semibold uppercase tracking-wide">About Us</span>
            </div>
            <h1 class="text-5xl md:text-6xl font-bold text-gray-900 mb-6">
                About B-Family Homes
            </h1>
            <p class="text-xl md:text-2xl text-gray-700 mb-4 font-semibold">
                Your Trusted Real Estate Partner in Nigeria
            </p>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Building dreams, one property at a time. We're committed to making property ownership accessible, transparent, and rewarding for everyone.
            </p>
        </div>
    </div>
</section>

<!-- Our Story Section -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <div class="relative">
                        <div class="absolute -top-4 -left-4 w-24 h-24 rounded-full bg-orange-100 -z-10"></div>
                        <div class="absolute -bottom-4 -right-4 w-32 h-32 rounded-full bg-yellow-100 -z-10"></div>
                        <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=800&h=600&fit=crop"
                             alt="B-Family Homes Office - Real Estate Agency in Anambra, Nigeria"
                             loading="lazy"
                             class="rounded-2xl w-full h-96 object-cover shadow-md">
                        <div class="absolute bottom-4 left-4 bg-white/90 backdrop-blur rounded-lg px-4 py-3 shadow-sm border border-gray-100">
                            <p class="text-orange-600 font-bold text-lg">Since 2010</p>
                            <p class="text-gray-600 text-sm">Years of Excellence</p>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-orange-100 rounded-full mb-4">
                        <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                        <span class="text-orange-600 text-sm font-semibold uppercase tracking-wide">Our Story</span>
                    </div>
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                        Building Trust, One Property at a Time
                    </h2>
                    <p class="text-gray-600 leading-relaxed mb-4 text-lg">
                        B-Family Homes Limited is a leading real estate company in Nigeria, dedicated to providing exceptional property services to both local and diaspora clients. With years of experience in the Nigerian property market, we have built a reputation for trust, professionalism, and customer satisfaction.
                    </p>
                    <p class="text-gray-600 leading-relaxed mb-6 text-lg">
                        Our mission is to make property ownership accessible and hassle-free for everyone, offering flexible payment plans, expert guidance, and a wide range of premium properties across Nigeria.
                    </p>
                    <div class="flex flex-wrap gap-6">
                        <div class="flex items-center gap-2">
                            <i class="bi bi-check-circle-fill text-orange-500 text-xl"></i>
                            <span class="font-semibold text-gray-700">Licensed & Certified</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="bi bi-check-circle-fill text-orange-500 text-xl"></i>
                            <span class="font-semibold text-gray-700">Trusted by Thousands</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="bi bi-check-circle-fill text-orange-500 text-xl"></i>
                            <span class="font-semibold text-gray-700">24/7 Support</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="py-20 bg-gradient-to-b from-gray-50 via-orange-50/30 to-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-orange-100 rounded-full mb-4">
                    <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                    <span class="text-orange-600 text-sm font-semibold uppercase tracking-wide">Our Achievements</span>
                </div>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Numbers That Speak</h2>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                    We're proud of the impact we've made in the Nigerian real estate space
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Stat 1: Horizontal with icon left -->
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                    <div class="flex items-start gap-5">
                        <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-sm">
                            <i class="bi bi-house-heart text-white text-2xl"></i>
                        </div>
                        <div>
                            <div class="text-4xl font-bold text-gray-900">1000+</div>
                            <p class="text-gray-500 font-medium mt-1">Properties Listed</p>
                            <p class="text-gray-400 text-sm mt-1">Across prime locations in Anambra State</p>
                        </div>
                    </div>
                </div>

                <!-- Stat 2: With progress bar -->
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                    <div class="flex items-start gap-5 mb-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-full flex items-center justify-center flex-shrink-0 shadow-sm">
                            <i class="bi bi-people-fill text-white text-2xl"></i>
                        </div>
                        <div>
                            <div class="text-4xl font-bold text-gray-900">5000+</div>
                            <p class="text-gray-500 font-medium mt-1">Happy Clients</p>
                        </div>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="bg-gradient-to-r from-orange-500 to-yellow-500 h-2 rounded-full" style="width: 92%"></div>
                    </div>
                    <p class="text-gray-400 text-xs mt-2">Client satisfaction rate</p>
                </div>

                <!-- Stat 3: Centered with dot indicators -->
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 hover:shadow-md hover:-translate-y-1 transition-all duration-300 text-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-xl flex items-center justify-center mx-auto mb-4 shadow-sm">
                        <i class="bi bi-person-badge text-white text-2xl"></i>
                    </div>
                    <div class="text-4xl font-bold text-gray-900 mb-1">50+</div>
                    <p class="text-gray-500 font-medium">Expert Agents</p>
                    <div class="flex justify-center gap-1 mt-3">
                        <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                        <span class="w-2 h-2 rounded-full bg-orange-400"></span>
                        <span class="w-2 h-2 rounded-full bg-orange-400"></span>
                        <span class="w-2 h-2 rounded-full bg-orange-300"></span>
                        <span class="w-2 h-2 rounded-full bg-orange-200"></span>
                    </div>
                </div>

                <!-- Stat 4: Number-focused with top accent bar -->
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 hover:shadow-md hover:-translate-y-1 transition-all duration-300 relative">
                    <div class="absolute top-0 left-8 right-8 h-1 bg-gradient-to-r from-orange-500 to-yellow-500 rounded-full"></div>
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-5xl font-bold text-gray-900">15+</div>
                            <p class="text-gray-500 font-medium mt-1">Years Experience</p>
                            <p class="text-gray-400 text-sm mt-1">Serving with integrity and excellence</p>
                        </div>
                        <div class="w-16 h-16 bg-orange-50 rounded-2xl flex items-center justify-center">
                            <i class="bi bi-trophy-fill text-orange-500 text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mission & Vision Section -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-orange-100 rounded-full mb-4">
                    <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                    <span class="text-orange-600 text-sm font-semibold uppercase tracking-wide">Our Direction</span>
                </div>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Mission & Vision</h2>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                    Guided by purpose, driven by vision
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Mission -->
                <div class="bg-gradient-to-br from-orange-50 to-white rounded-2xl p-10 border border-orange-100 hover:shadow-md transition-all duration-300">
                    <div class="flex items-start gap-5 mb-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-sm">
                            <i class="bi bi-bullseye text-white text-2xl"></i>
                        </div>
                        <div>
                            <span class="text-xs font-semibold text-orange-500 uppercase tracking-wider">Our Purpose</span>
                            <h3 class="text-2xl font-bold text-gray-900 mt-1">Mission</h3>
                        </div>
                    </div>
                    <p class="text-gray-600 leading-relaxed text-lg">
                        To make property ownership accessible, transparent, and rewarding for everyone. We strive to provide exceptional real estate services that empower individuals and families to achieve their property dreams through flexible solutions, expert guidance, and unwavering commitment to excellence.
                    </p>
                </div>

                <!-- Vision -->
                <div class="bg-gradient-to-br from-yellow-50 to-white rounded-2xl p-10 border border-yellow-100 hover:shadow-md transition-all duration-300 relative">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-orange-100 to-yellow-100 rounded-bl-[2rem] rounded-tr-2xl"></div>
                    <div class="relative">
                        <div class="flex items-start gap-5 mb-6">
                            <div class="w-16 h-16 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-sm">
                                <i class="bi bi-eye text-white text-2xl"></i>
                            </div>
                            <div>
                                <span class="text-xs font-semibold text-yellow-600 uppercase tracking-wider">Our Aspiration</span>
                                <h3 class="text-2xl font-bold text-gray-900 mt-1">Vision</h3>
                            </div>
                        </div>
                        <p class="text-gray-600 leading-relaxed text-lg">
                            To become Nigeria's most trusted and innovative real estate platform, recognized for transforming the property market through technology, integrity, and customer-centric solutions. We envision a future where property ownership is seamless, secure, and accessible to all.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Core Values Section -->
<section class="py-20 bg-gradient-to-b from-gray-50 to-white">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-orange-100 rounded-full mb-4">
                    <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                    <span class="text-orange-600 text-sm font-semibold uppercase tracking-wide">What We Stand For</span>
                </div>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Our Core Values</h2>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                    The principles that guide everything we do
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Value 1: Left accent bar -->
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 hover:shadow-md hover:-translate-y-1 transition-all duration-300 relative">
                    <div class="absolute left-0 top-8 bottom-8 w-1 bg-gradient-to-b from-orange-500 to-yellow-500 rounded-full"></div>
                    <div class="pl-5">
                        <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-xl flex items-center justify-center mb-5 shadow-sm">
                            <i class="bi bi-shield-check text-white text-xl"></i>
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 mb-2">Trust & Integrity</h4>
                        <p class="text-gray-500 leading-relaxed text-sm">
                            We build lasting relationships through transparency, honesty, and ethical practices in every transaction.
                        </p>
                    </div>
                </div>

                <!-- Value 2: Centered with rounded icon -->
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 hover:shadow-md hover:-translate-y-1 transition-all duration-300 text-center">
                    <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-full flex items-center justify-center mx-auto mb-5 shadow-sm">
                        <i class="bi bi-heart-fill text-white text-xl"></i>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-2">Customer First</h4>
                    <p class="text-gray-500 leading-relaxed text-sm">
                        Your satisfaction is our priority. We listen, understand, and go above and beyond to exceed expectations.
                    </p>
                </div>

                <!-- Value 3: Icon on right -->
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h4 class="text-xl font-bold text-gray-900">Innovation</h4>
                            <span class="text-xs text-orange-500 font-medium">Forward Thinking</span>
                        </div>
                        <div class="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center flex-shrink-0 ml-4">
                            <i class="bi bi-lightbulb-fill text-orange-500 text-xl"></i>
                        </div>
                    </div>
                    <p class="text-gray-500 leading-relaxed text-sm">
                        We embrace technology and innovative solutions to make property transactions easier and more efficient.
                    </p>
                </div>

                <!-- Value 4: Tinted background, icon bottom-right -->
                <div class="bg-gradient-to-br from-orange-50 to-white rounded-2xl p-8 shadow-sm border border-orange-100 hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                    <div class="mb-4">
                        <h4 class="text-xl font-bold text-gray-900">Excellence</h4>
                        <p class="text-gray-500 leading-relaxed text-sm mt-2">
                            We strive for excellence in every detail, from property selection to customer service delivery.
                        </p>
                    </div>
                    <div class="flex justify-end">
                        <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-lg flex items-center justify-center shadow-sm">
                            <i class="bi bi-award-fill text-white text-base"></i>
                        </div>
                    </div>
                </div>

                <!-- Value 5: Horizontal layout -->
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-xl flex items-center justify-center flex-shrink-0 shadow-sm">
                            <i class="bi bi-people-fill text-white text-xl"></i>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-gray-900 mb-2">Community</h4>
                            <p class="text-gray-500 leading-relaxed text-sm">
                                We're committed to building stronger communities through responsible real estate development.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Value 6: Bottom accent border -->
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 hover:shadow-md hover:-translate-y-1 transition-all duration-300 border-b-4 border-b-orange-500">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-orange-50 rounded-lg flex items-center justify-center">
                            <i class="bi bi-clock-fill text-orange-500 text-lg"></i>
                        </div>
                        <h4 class="text-xl font-bold text-gray-900">Reliability</h4>
                    </div>
                    <p class="text-gray-500 leading-relaxed text-sm">
                        You can count on us to deliver on our promises, with consistent service and dependable support.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="py-20 bg-gradient-to-b from-white via-orange-50/30 to-white">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-orange-100 rounded-full mb-4">
                    <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                    <span class="text-orange-600 text-sm font-semibold uppercase tracking-wide">Why Choose Us</span>
                </div>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-1">Why B-Family Homes?</h2>
                <div class="flex items-center justify-center gap-2 mb-4">
                    <span class="w-20 h-1 bg-gradient-to-r from-primary-500 to-accent rounded-full"></span>
                    <span class="w-2.5 h-2.5 bg-primary-500 rounded-full rotate-45"></span>
                    <span class="w-20 h-1 bg-gradient-to-r from-accent to-primary-500 rounded-full"></span>
                </div>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                    Experience the difference of working with a trusted real estate partner
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="group bg-white rounded-2xl p-8 shadow-sm border border-gray-100 hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                    <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-2xl flex items-center justify-center mb-5 shadow-sm group-hover:rotate-3 transition-transform duration-300">
                        <i class="bi bi-wallet2 text-white text-2xl"></i>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-2">Flexible Payment Plans</h4>
                    <p class="text-gray-500 leading-relaxed text-sm">
                        Choose from various payment schedules that fit your budget and financial goals.
                    </p>
                </div>

                <div class="group bg-white rounded-2xl p-8 shadow-sm border border-gray-100 hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                    <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-xl flex items-center justify-center mb-5 shadow-sm group-hover:scale-110 transition-transform duration-300">
                        <i class="bi bi-shield-check text-white text-2xl"></i>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-2">Verified Properties</h4>
                    <p class="text-gray-500 leading-relaxed text-sm">
                        All properties are thoroughly verified, ensuring authenticity and legal compliance.
                    </p>
                </div>

                <div class="group bg-white rounded-2xl p-8 shadow-sm border border-gray-100 hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                    <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-full flex items-center justify-center mb-5 shadow-sm group-hover:scale-110 transition-transform duration-300">
                        <i class="bi bi-headset text-white text-2xl"></i>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-2">24/7 Support</h4>
                    <p class="text-gray-500 leading-relaxed text-sm">
                        Our dedicated support team is always ready to assist you, anytime, anywhere.
                    </p>
                </div>

                <div class="group bg-white rounded-2xl p-8 shadow-sm border border-gray-100 hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                    <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-2xl flex items-center justify-center mb-5 shadow-sm group-hover:-rotate-3 transition-transform duration-300">
                        <i class="bi bi-graph-up-arrow text-white text-2xl"></i>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-2">Investment Opportunities</h4>
                    <p class="text-gray-500 leading-relaxed text-sm">
                        Explore profitable real estate investment options with attractive returns.
                    </p>
                </div>

                <div class="group bg-white rounded-2xl p-8 shadow-sm border border-gray-100 hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                    <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-xl flex items-center justify-center mb-5 shadow-sm group-hover:scale-110 transition-transform duration-300">
                        <i class="bi bi-person-check text-white text-2xl"></i>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-2">Expert Agents</h4>
                    <p class="text-gray-500 leading-relaxed text-sm">
                        Work with certified and experienced real estate professionals.
                    </p>
                </div>

                <div class="group bg-white rounded-2xl p-8 shadow-sm border border-gray-100 hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                    <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-2xl flex items-center justify-center mb-5 shadow-sm group-hover:rotate-3 transition-transform duration-300">
                        <i class="bi bi-globe text-white text-2xl"></i>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-2">Nationwide Coverage</h4>
                    <p class="text-gray-500 leading-relaxed text-sm">
                        Properties available across major cities in Nigeria with local expertise.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="bg-gradient-to-br from-orange-500 to-yellow-500 rounded-3xl p-12 md:p-16 text-center text-white relative overflow-hidden">
                <div class="absolute -top-20 -right-20 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
                <div class="relative z-10">
                    <h2 class="text-4xl md:text-5xl font-bold mb-6">Ready to Find Your Dream Property?</h2>
                    <p class="text-lg opacity-95 mb-8 max-w-2xl mx-auto">
                        Join thousands of satisfied customers who have found their perfect home or investment opportunity with us.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('properties.index') }}" class="bg-white text-orange-600 hover:bg-gray-100 px-8 py-4 text-lg font-semibold rounded-xl transition-all duration-300 shadow-md hover:shadow-lg inline-flex items-center gap-2">
                            <i class="bi bi-search"></i>
                            Browse Properties
                        </a>
                        <a href="{{ route('contact') }}" class="bg-orange-600 hover:bg-orange-500 text-white border-2 border-white/30 px-8 py-4 text-lg font-semibold rounded-xl transition-all duration-300 shadow-md hover:shadow-lg inline-flex items-center gap-2">
                            <i class="bi bi-envelope"></i>
                            Contact Us
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fade-in 0.8s ease-out;
    }
</style>
@endpush