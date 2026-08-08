@extends('layouts.app')

@section('title', 'Terms & Conditions - B-Family Homes')

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
                Terms & Conditions
            </h1>
            <p class="text-xl md:text-2xl opacity-95 mb-8 leading-relaxed">
                Please Read These Terms Carefully
            </p>
            <p class="text-lg opacity-90 max-w-2xl mx-auto">
                By using our services, you agree to be bound by these terms and conditions. We recommend reading them thoroughly.
            </p>
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-16 md:h-24">
            <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="rgb(249, 250, 251)"/>
        </svg>
    </div>
</section>

<!-- Terms & Conditions Content -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12">
                <div class="mb-8">
                    <p class="text-gray-600 mb-4">
                        <strong>Last Updated:</strong> {{ date('F d, Y') }}
                    </p>
                    <p class="text-gray-700 leading-relaxed">
                        These Terms and Conditions ("Terms") govern your access to and use of the B-Family Homes Limited website and services. By accessing or using our services, you agree to be bound by these Terms. If you do not agree to these Terms, please do not use our services.
                    </p>
                </div>

                <!-- Acceptance of Terms -->
                <div class="mb-10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-check-circle text-primary-600 text-2xl"></i>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900">1. Acceptance of Terms</h2>
                    </div>
                    
                    <div class="space-y-4 text-gray-700">
                        <p class="leading-relaxed">
                            By accessing or using the B-Family Homes website, mobile application, or any of our services, you acknowledge that you have read, understood, and agree to be bound by these Terms and our Privacy Policy. If you do not agree with any part of these Terms, you must not use our services.
                        </p>
                    </div>
                </div>

                <!-- Services Description -->
                <div class="mb-10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-house text-primary-600 text-2xl"></i>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900">2. Services Description</h2>
                    </div>
                    
                    <div class="space-y-4 text-gray-700">
                        <p class="leading-relaxed">
                            B-Family Homes Limited provides the following services:
                        </p>
                        <ul class="list-disc list-inside ml-4 space-y-2">
                            <li>Property listings for sale, rent, and investment</li>
                            <li>Land sales with proper documentation</li>
                            <li>Property development and construction services</li>
                            <li>Real estate investment opportunities</li>
                            <li>Property inspection and booking services</li>
                            <li>Payment processing and transaction management</li>
                            <li>Diaspora real estate services</li>
                        </ul>
                        <p class="leading-relaxed mt-4">
                            We reserve the right to modify, suspend, or discontinue any part of our services at any time without prior notice.
                        </p>
                    </div>
                </div>

                <!-- User Accounts -->
                <div class="mb-10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-person-badge text-primary-600 text-2xl"></i>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900">3. User Accounts and Registration</h2>
                    </div>
                    
                    <div class="space-y-4 text-gray-700">
                        <p class="leading-relaxed">
                            To access certain features of our services, you may be required to create an account. When creating an account, you agree to:
                        </p>
                        <ul class="list-disc list-inside ml-4 space-y-2">
                            <li>Provide accurate, current, and complete information</li>
                            <li>Maintain and update your information to keep it accurate</li>
                            <li>Maintain the security of your account credentials</li>
                            <li>Accept responsibility for all activities under your account</li>
                            <li>Notify us immediately of any unauthorized access</li>
                        </ul>
                        <p class="leading-relaxed mt-4">
                            We reserve the right to suspend or terminate accounts that violate these Terms or engage in fraudulent activities.
                        </p>
                    </div>
                </div>

                <!-- Property Listings -->
                <div class="mb-10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-list-ul text-primary-600 text-2xl"></i>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900">4. Property Listings and Information</h2>
                    </div>
                    
                    <div class="space-y-4 text-gray-700">
                        <p class="leading-relaxed">
                            Property listings on our platform are provided for informational purposes. While we strive for accuracy, we do not guarantee:
                        </p>
                        <ul class="list-disc list-inside ml-4 space-y-2">
                            <li>The accuracy, completeness, or timeliness of property information</li>
                            <li>The availability of listed properties</li>
                            <li>The condition, quality, or legal status of properties</li>
                            <li>The accuracy of property descriptions, images, or pricing</li>
                        </ul>
                        <p class="leading-relaxed mt-4">
                            We recommend conducting your own due diligence, including property inspections, legal verification, and professional consultations before making any purchase decisions.
                        </p>
                    </div>
                </div>

                <!-- Payments and Transactions -->
                <div class="mb-10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-credit-card text-primary-600 text-2xl"></i>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900">5. Payments and Transactions</h2>
                    </div>
                    
                    <div class="space-y-4 text-gray-700">
                        <p class="leading-relaxed">
                            All payments for properties and services must be made through our approved payment methods. By making a payment, you agree to:
                        </p>
                        <ul class="list-disc list-inside ml-4 space-y-2">
                            <li>Provide accurate payment information</li>
                            <li>Authorize us to charge your payment method for agreed amounts</li>
                            <li>Comply with our refund policy (see Refund Policy page)</li>
                            <li>Pay all applicable fees, taxes, and charges</li>
                        </ul>
                        <p class="leading-relaxed mt-4">
                            All prices are subject to change without notice. Final prices will be confirmed at the time of transaction. We use secure third-party payment processors to handle transactions.
                        </p>
                    </div>
                </div>

                <!-- User Conduct -->
                <div class="mb-10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-shield-exclamation text-primary-600 text-2xl"></i>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900">6. User Conduct and Prohibited Activities</h2>
                    </div>
                    
                    <div class="space-y-4 text-gray-700">
                        <p class="leading-relaxed">
                            You agree not to engage in any of the following prohibited activities:
                        </p>
                        <ul class="list-disc list-inside ml-4 space-y-2">
                            <li>Violate any applicable laws or regulations</li>
                            <li>Infringe upon intellectual property rights</li>
                            <li>Transmit viruses, malware, or harmful code</li>
                            <li>Attempt to gain unauthorized access to our systems</li>
                            <li>Interfere with or disrupt our services</li>
                            <li>Use automated systems to scrape or collect data</li>
                            <li>Impersonate others or provide false information</li>
                            <li>Engage in fraudulent or deceptive practices</li>
                            <li>Harass, abuse, or harm other users</li>
                        </ul>
                        <p class="leading-relaxed mt-4">
                            Violation of these terms may result in immediate termination of your account and legal action.
                        </p>
                    </div>
                </div>

                <!-- Intellectual Property -->
                <div class="mb-10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-copyright text-primary-600 text-2xl"></i>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900">7. Intellectual Property Rights</h2>
                    </div>
                    
                    <div class="space-y-4 text-gray-700">
                        <p class="leading-relaxed">
                            All content on our website, including text, graphics, logos, images, and software, is the property of B-Family Homes Limited or its licensors and is protected by copyright, trademark, and other intellectual property laws.
                        </p>
                        <p class="leading-relaxed">
                            You may not reproduce, distribute, modify, or create derivative works from our content without our express written permission. Property images and descriptions are provided for viewing purposes only and may not be used for commercial purposes without authorization.
                        </p>
                    </div>
                </div>

                <!-- Limitation of Liability -->
                <div class="mb-10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-exclamation-triangle text-primary-600 text-2xl"></i>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900">8. Limitation of Liability</h2>
                    </div>
                    
                    <div class="space-y-4 text-gray-700">
                        <p class="leading-relaxed">
                            To the maximum extent permitted by law, B-Family Homes Limited shall not be liable for:
                        </p>
                        <ul class="list-disc list-inside ml-4 space-y-2">
                            <li>Any indirect, incidental, special, or consequential damages</li>
                            <li>Loss of profits, revenue, data, or business opportunities</li>
                            <li>Property defects, disputes, or legal issues</li>
                            <li>Errors or omissions in property listings</li>
                            <li>Service interruptions or technical failures</li>
                            <li>Third-party actions or content</li>
                        </ul>
                        <p class="leading-relaxed mt-4">
                            Our total liability shall not exceed the amount you paid to us in the 12 months preceding the claim.
                        </p>
                    </div>
                </div>

                <!-- Indemnification -->
                <div class="mb-10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-shield-check text-primary-600 text-2xl"></i>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900">9. Indemnification</h2>
                    </div>
                    
                    <div class="space-y-4 text-gray-700">
                        <p class="leading-relaxed">
                            You agree to indemnify, defend, and hold harmless B-Family Homes Limited, its officers, directors, employees, and agents from any claims, damages, losses, liabilities, and expenses (including legal fees) arising from:
                        </p>
                        <ul class="list-disc list-inside ml-4 space-y-2">
                            <li>Your use of our services</li>
                            <li>Your violation of these Terms</li>
                            <li>Your violation of any rights of another party</li>
                            <li>Any content you submit or transmit through our platform</li>
                        </ul>
                    </div>
                </div>

                <!-- Termination -->
                <div class="mb-10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-x-circle text-primary-600 text-2xl"></i>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900">10. Termination</h2>
                    </div>
                    
                    <div class="space-y-4 text-gray-700">
                        <p class="leading-relaxed">
                            We reserve the right to suspend or terminate your account and access to our services at any time, with or without cause or notice, for any reason including:
                        </p>
                        <ul class="list-disc list-inside ml-4 space-y-2">
                            <li>Violation of these Terms</li>
                            <li>Fraudulent or illegal activity</li>
                            <li>Non-payment of fees</li>
                            <li>Extended periods of inactivity</li>
                        </ul>
                        <p class="leading-relaxed mt-4">
                            You may terminate your account at any time by contacting us. Upon termination, your right to use our services will immediately cease.
                        </p>
                    </div>
                </div>

                <!-- Governing Law -->
                <div class="mb-10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-gavel text-primary-600 text-2xl"></i>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900">11. Governing Law and Dispute Resolution</h2>
                    </div>
                    
                    <div class="space-y-4 text-gray-700">
                        <p class="leading-relaxed">
                            These Terms shall be governed by and construed in accordance with the laws of the Federal Republic of Nigeria. Any disputes arising from these Terms or our services shall be subject to the exclusive jurisdiction of the courts of Anambra State, Nigeria.
                        </p>
                        <p class="leading-relaxed">
                            We encourage resolving disputes through good faith negotiation. If a dispute cannot be resolved amicably, it shall be submitted to binding arbitration in accordance with Nigerian arbitration laws.
                        </p>
                    </div>
                </div>

                <!-- Changes to Terms -->
                <div class="mb-10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-arrow-repeat text-primary-600 text-2xl"></i>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900">12. Changes to Terms</h2>
                    </div>
                    
                    <div class="space-y-4 text-gray-700">
                        <p class="leading-relaxed">
                            We reserve the right to modify these Terms at any time. We will notify users of significant changes by posting the updated Terms on our website and updating the "Last Updated" date. Your continued use of our services after changes become effective constitutes acceptance of the modified Terms.
                        </p>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="mb-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-envelope text-primary-600 text-2xl"></i>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900">13. Contact Information</h2>
                    </div>
                    
                    <div class="bg-primary-50 rounded-xl p-6 space-y-3 text-gray-700">
                        <p class="leading-relaxed">
                            If you have any questions about these Terms & Conditions, please contact us:
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

