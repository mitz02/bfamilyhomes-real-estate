@extends('layouts.app')

@section('title', 'Privacy Policy - B-Family Homes')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-primary-600 via-primary-500 to-primary-700 py-20 overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-white rounded-full blur-3xl"></div>
    </div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto text-center text-white">
            <h1 class="text-5xl md:text-6xl font-bold mb-6 animate-fade-in">
                Privacy Policy
            </h1>
            <p class="text-xl md:text-2xl opacity-95 mb-8 leading-relaxed">
                Your Privacy Matters to Us
            </p>
            <p class="text-lg opacity-90 max-w-2xl mx-auto">
                We are committed to protecting your personal information and ensuring transparency in how we collect, use, and safeguard your data.
            </p>
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-16 md:h-24">
            <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="rgb(249, 250, 251)"/>
        </svg>
    </div>
</section>

<!-- Privacy Policy Content -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12">
                <div class="mb-8">
                    <p class="text-gray-600 mb-4">
                        <strong>Last Updated:</strong> {{ date('F d, Y') }}
                    </p>
                    <p class="text-gray-700 leading-relaxed">
                        B-Family Homes Limited ("we," "our," or "us") is committed to protecting your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website and use our services.
                    </p>
                </div>

                <!-- Information We Collect -->
                <div class="mb-10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-info-circle text-primary-600 text-2xl"></i>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900">1. Information We Collect</h2>
                    </div>
                    
                    <div class="space-y-4 text-gray-700">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Personal Information</h3>
                            <p class="leading-relaxed">
                                We may collect personal information that you provide directly to us, including:
                            </p>
                            <ul class="list-disc list-inside ml-4 mt-2 space-y-2">
                                <li>Name, email address, phone number, and postal address</li>
                                <li>Government-issued identification documents for property transactions</li>
                                <li>Payment information (processed securely through third-party payment processors)</li>
                                <li>Property preferences and search history</li>
                                <li>Communication preferences and feedback</li>
                            </ul>
                        </div>

                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Automatically Collected Information</h3>
                            <p class="leading-relaxed">
                                When you visit our website, we automatically collect certain information, including:
                            </p>
                            <ul class="list-disc list-inside ml-4 mt-2 space-y-2">
                                <li>IP address and browser type</li>
                                <li>Device information and operating system</li>
                                <li>Pages visited and time spent on our website</li>
                                <li>Referring website addresses</li>
                                <li>Cookies and similar tracking technologies</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- How We Use Your Information -->
                <div class="mb-10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-gear text-primary-600 text-2xl"></i>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900">2. How We Use Your Information</h2>
                    </div>
                    
                    <div class="space-y-4 text-gray-700">
                        <p class="leading-relaxed">
                            We use the information we collect for various purposes, including:
                        </p>
                        <ul class="list-disc list-inside ml-4 space-y-2">
                            <li>To provide, maintain, and improve our services</li>
                            <li>To process property transactions and manage bookings</li>
                            <li>To communicate with you about properties, services, and updates</li>
                            <li>To personalize your experience and show relevant property listings</li>
                            <li>To send you marketing communications (with your consent)</li>
                            <li>To detect, prevent, and address technical issues and fraud</li>
                            <li>To comply with legal obligations and enforce our terms</li>
                        </ul>
                    </div>
                </div>

                <!-- Information Sharing -->
                <div class="mb-10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-share text-primary-600 text-2xl"></i>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900">3. Information Sharing and Disclosure</h2>
                    </div>
                    
                    <div class="space-y-4 text-gray-700">
                        <p class="leading-relaxed">
                            We do not sell your personal information. We may share your information in the following circumstances:
                        </p>
                        <ul class="list-disc list-inside ml-4 space-y-2">
                            <li><strong>Service Providers:</strong> With trusted third-party service providers who assist us in operating our website and conducting business</li>
                            <li><strong>Property Agents:</strong> With registered agents to facilitate property viewings and transactions</li>
                            <li><strong>Legal Requirements:</strong> When required by law or to protect our rights and safety</li>
                            <li><strong>Business Transfers:</strong> In connection with any merger, sale, or acquisition of our business</li>
                            <li><strong>With Your Consent:</strong> When you explicitly authorize us to share your information</li>
                        </ul>
                    </div>
                </div>

                <!-- Data Security -->
                <div class="mb-10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-shield-lock text-primary-600 text-2xl"></i>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900">4. Data Security</h2>
                    </div>
                    
                    <div class="space-y-4 text-gray-700">
                        <p class="leading-relaxed">
                            We implement appropriate technical and organizational security measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction. However, no method of transmission over the internet or electronic storage is 100% secure.
                        </p>
                        <p class="leading-relaxed">
                            We use industry-standard encryption technologies and secure servers to protect sensitive information, including payment details and personal documents.
                        </p>
                    </div>
                </div>

                <!-- Your Rights -->
                <div class="mb-10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-person-check text-primary-600 text-2xl"></i>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900">5. Your Rights and Choices</h2>
                    </div>
                    
                    <div class="space-y-4 text-gray-700">
                        <p class="leading-relaxed">
                            You have the following rights regarding your personal information:
                        </p>
                        <ul class="list-disc list-inside ml-4 space-y-2">
                            <li><strong>Access:</strong> Request access to your personal information</li>
                            <li><strong>Correction:</strong> Request correction of inaccurate or incomplete information</li>
                            <li><strong>Deletion:</strong> Request deletion of your personal information (subject to legal requirements)</li>
                            <li><strong>Objection:</strong> Object to processing of your personal information</li>
                            <li><strong>Data Portability:</strong> Request transfer of your data to another service</li>
                            <li><strong>Opt-Out:</strong> Unsubscribe from marketing communications at any time</li>
                        </ul>
                        <p class="leading-relaxed mt-4">
                            To exercise these rights, please contact us using the information provided in the "Contact Us" section below.
                        </p>
                    </div>
                </div>

                <!-- Cookies -->
                <div class="mb-10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-cookie text-primary-600 text-2xl"></i>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900">6. Cookies and Tracking Technologies</h2>
                    </div>
                    
                    <div class="space-y-4 text-gray-700">
                        <p class="leading-relaxed">
                            We use cookies and similar tracking technologies to enhance your browsing experience, analyze website traffic, and personalize content. You can control cookie preferences through your browser settings.
                        </p>
                        <p class="leading-relaxed">
                            Types of cookies we use:
                        </p>
                        <ul class="list-disc list-inside ml-4 space-y-2">
                            <li><strong>Essential Cookies:</strong> Required for the website to function properly</li>
                            <li><strong>Analytics Cookies:</strong> Help us understand how visitors interact with our website</li>
                            <li><strong>Functional Cookies:</strong> Remember your preferences and settings</li>
                            <li><strong>Marketing Cookies:</strong> Used to deliver relevant advertisements</li>
                        </ul>
                    </div>
                </div>

                <!-- Third-Party Links -->
                <div class="mb-10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-link-45deg text-primary-600 text-2xl"></i>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900">7. Third-Party Links</h2>
                    </div>
                    
                    <div class="space-y-4 text-gray-700">
                        <p class="leading-relaxed">
                            Our website may contain links to third-party websites or services. We are not responsible for the privacy practices of these external sites. We encourage you to review the privacy policies of any third-party sites you visit.
                        </p>
                    </div>
                </div>

                <!-- Children's Privacy -->
                <div class="mb-10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-people text-primary-600 text-2xl"></i>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900">8. Children's Privacy</h2>
                    </div>
                    
                    <div class="space-y-4 text-gray-700">
                        <p class="leading-relaxed">
                            Our services are not intended for individuals under the age of 18. We do not knowingly collect personal information from children. If you believe we have collected information from a child, please contact us immediately.
                        </p>
                    </div>
                </div>

                <!-- Changes to Privacy Policy -->
                <div class="mb-10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-arrow-repeat text-primary-600 text-2xl"></i>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900">9. Changes to This Privacy Policy</h2>
                    </div>
                    
                    <div class="space-y-4 text-gray-700">
                        <p class="leading-relaxed">
                            We may update this Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page and updating the "Last Updated" date. You are advised to review this Privacy Policy periodically for any changes.
                        </p>
                    </div>
                </div>

                <!-- Contact Us -->
                <div class="mb-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-envelope text-primary-600 text-2xl"></i>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900">10. Contact Us</h2>
                    </div>
                    
                    <div class="bg-primary-50 rounded-xl p-6 space-y-3 text-gray-700">
                        <p class="leading-relaxed">
                            If you have any questions or concerns about this Privacy Policy or our data practices, please contact us:
                        </p>
                        <div class="space-y-2">
                            <p><strong>B-Family Homes Limited</strong></p>
                            <p><i class="bi bi-geo-alt-fill text-primary-600"></i> Awkuzu, Anambra State, Nigeria</p>
                            <p><i class="bi bi-telephone-fill text-primary-600"></i> <a href="tel:+2348164856758" class="text-primary-600 hover:underline">+234 816 485 6758</a></p>
                            <p><i class="bi bi-envelope-fill text-primary-600"></i> <a href="mailto:admin@bfamilyhomes.com" class="text-primary-600 hover:underline">admin@bfamilyhomes.com</a></p>
                        </div>
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

