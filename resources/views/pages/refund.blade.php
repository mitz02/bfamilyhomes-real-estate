@extends('layouts.app')

@section('title', 'Refund Policy - B-Family Homes')

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
                Refund Policy
            </h1>
            <p class="text-xl md:text-2xl opacity-95 mb-8 leading-relaxed">
                Fair and Transparent Refund Process
            </p>
            <p class="text-lg opacity-90 max-w-2xl mx-auto">
                We are committed to providing fair and transparent refund policies to ensure your satisfaction and peace of mind.
            </p>
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-16 md:h-24">
            <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="rgb(249, 250, 251)"/>
        </svg>
    </div>
</section>

<!-- Refund Policy Content -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12">
                <div class="mb-8">
                    <p class="text-gray-600 mb-4">
                        <strong>Last Updated:</strong> {{ date('F d, Y') }}
                    </p>
                    <p class="text-gray-700 leading-relaxed">
                        At B-Family Homes Limited, we understand that circumstances may change, and we are committed to providing a fair and transparent refund policy. This policy outlines the terms and conditions under which refunds may be processed.
                    </p>
                </div>

                <!-- General Refund Policy -->
                <div class="mb-10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-currency-exchange text-green-600 text-2xl"></i>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900">1. General Refund Policy</h2>
                    </div>
                    
                    <div class="space-y-4 text-gray-700">
                        <p class="leading-relaxed">
                            Our refund policy is designed to be fair and transparent. Refunds are processed based on the following conditions:
                        </p>
                        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg">
                            <p class="font-semibold text-green-900 mb-2">Key Principles:</p>
                            <ul class="list-disc list-inside space-y-1 text-green-800">
                                <li>Refunds are processed within 14–21 working days after approval</li>
                                <li>All refund requests must be submitted with proof of payment and valid ID</li>
                                <li>Refund eligibility depends on the timing and circumstances of the request</li>
                                <li>Administrative charges may apply in certain situations</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- 7-Day Full Refund -->
                <div class="mb-10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-check-circle-fill text-green-600 text-2xl"></i>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900">2. 7-Day Full Refund</h2>
                    </div>
                    
                    <div class="space-y-4 text-gray-700">
                        <div class="bg-green-50 rounded-xl p-6 border-2 border-green-200">
                            <p class="leading-relaxed font-semibold text-green-900 mb-3">
                                A client who requests a refund within 7 days of payment is eligible for a 100% refund if no documentation has been processed.
                            </p>
                            <div class="space-y-2 text-green-800">
                                <p><strong>Conditions:</strong></p>
                                <ul class="list-disc list-inside ml-4 space-y-1">
                                    <li>Refund request must be made within 7 calendar days of payment</li>
                                    <li>No documentation processing must have commenced</li>
                                    <li>Full refund will be processed without deductions</li>
                                    <li>Original payment method will be used for refund</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Refunds After Documentation -->
                <div class="mb-10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-file-earmark-text text-yellow-600 text-2xl"></i>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900">3. Refunds After Documentation Has Begun</h2>
                    </div>
                    
                    <div class="space-y-4 text-gray-700">
                        <div class="bg-yellow-50 rounded-xl p-6 border-2 border-yellow-200">
                            <p class="leading-relaxed font-semibold text-yellow-900 mb-3">
                                Refunds requested after documentation has begun may attract administrative charges.
                            </p>
                            <div class="space-y-2 text-yellow-800">
                                <p><strong>Administrative Charges May Include:</strong></p>
                                <ul class="list-disc list-inside ml-4 space-y-1">
                                    <li>Document processing fees</li>
                                    <li>Legal documentation costs already incurred</li>
                                    <li>Administrative processing fees</li>
                                    <li>Bank transaction charges</li>
                                </ul>
                                <p class="mt-3">
                                    The exact amount of administrative charges will be communicated to you before processing the refund. You will receive the remaining balance after deducting applicable charges.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Company Error Refunds -->
                <div class="mb-10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-shield-check text-blue-600 text-2xl"></i>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900">4. Refunds Due to Company Error</h2>
                    </div>
                    
                    <div class="space-y-4 text-gray-700">
                        <div class="bg-blue-50 rounded-xl p-6 border-2 border-blue-200">
                            <p class="leading-relaxed font-semibold text-blue-900 mb-3">
                                If the allocation given is unavailable due to company error, the client will receive either:
                            </p>
                            <div class="space-y-3 text-blue-800">
                                <div class="flex items-start gap-3">
                                    <i class="bi bi-check-circle-fill text-blue-600 mt-1"></i>
                                    <div>
                                        <p class="font-semibold">Option 1: Full Refund</p>
                                        <p>A full refund with no deductions</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <i class="bi bi-check-circle-fill text-blue-600 mt-1"></i>
                                    <div>
                                        <p class="font-semibold">Option 2: New Allocation</p>
                                        <p>A new allocation of equal or higher value at no additional cost</p>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-4 text-blue-800">
                                The client will be consulted to choose their preferred option. We are committed to resolving any errors on our part promptly and fairly.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Refund Processing Time -->
                <div class="mb-10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-clock-history text-purple-600 text-2xl"></i>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900">5. Refund Processing Time</h2>
                    </div>
                    
                    <div class="space-y-4 text-gray-700">
                        <p class="leading-relaxed">
                            Refunds are processed within <strong>14–21 working days</strong> after request submission and approval. Processing time may vary based on:
                        </p>
                        <ul class="list-disc list-inside ml-4 space-y-2">
                            <li>Payment method used (bank transfer, card, etc.)</li>
                            <li>Bank processing times</li>
                            <li>Completeness of refund request documentation</li>
                            <li>Verification requirements</li>
                        </ul>
                        <p class="leading-relaxed mt-4">
                            You will receive email notifications at each stage of the refund process. If you do not receive your refund within the stated timeframe, please contact our support team.
                        </p>
                    </div>
                </div>

                <!-- Required Documentation -->
                <div class="mb-10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-file-earmark-check text-red-600 text-2xl"></i>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900">6. Required Documentation</h2>
                    </div>
                    
                    <div class="space-y-4 text-gray-700">
                        <p class="leading-relaxed">
                            All refund requests must be submitted with the following documentation:
                        </p>
                        <div class="bg-gray-50 rounded-xl p-6 border-2 border-gray-200">
                            <ul class="list-disc list-inside space-y-2">
                                <li><strong>Proof of Payment:</strong> Bank transfer receipt, payment confirmation, or transaction statement</li>
                                <li><strong>Valid ID:</strong> Government-issued identification (National ID, Driver's License, or International Passport)</li>
                                <li><strong>Refund Request Form:</strong> Completed refund request form (available from our office or website)</li>
                                <li><strong>Account Details:</strong> Bank account information for refund processing (if different from original payment method)</li>
                                <li><strong>Reason for Refund:</strong> Clear explanation of the reason for the refund request</li>
                            </ul>
                        </div>
                        <p class="leading-relaxed mt-4">
                            Incomplete documentation may delay the refund process. Please ensure all documents are clear and legible.
                        </p>
                    </div>
                </div>

                <!-- How to Request a Refund -->
                <div class="mb-10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-envelope-paper text-indigo-600 text-2xl"></i>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900">7. How to Request a Refund</h2>
                    </div>
                    
                    <div class="space-y-4 text-gray-700">
                        <p class="leading-relaxed">
                            To request a refund, please follow these steps:
                        </p>
                        <div class="space-y-4">
                            <div class="flex items-start gap-4 p-4 bg-indigo-50 rounded-lg border-l-4 border-indigo-500">
                                <div class="w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">1</div>
                                <div>
                                    <p class="font-semibold text-gray-900">Contact Our Support Team</p>
                                    <p class="text-gray-700">Reach out via phone, email, or visit our office to initiate the refund process.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4 p-4 bg-indigo-50 rounded-lg border-l-4 border-indigo-500">
                                <div class="w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">2</div>
                                <div>
                                    <p class="font-semibold text-gray-900">Submit Required Documents</p>
                                    <p class="text-gray-700">Provide all necessary documentation as outlined in Section 6.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4 p-4 bg-indigo-50 rounded-lg border-l-4 border-indigo-500">
                                <div class="w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">3</div>
                                <div>
                                    <p class="font-semibold text-gray-900">Review and Approval</p>
                                    <p class="text-gray-700">Our team will review your request and notify you of the approval status.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4 p-4 bg-indigo-50 rounded-lg border-l-4 border-indigo-500">
                                <div class="w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">4</div>
                                <div>
                                    <p class="font-semibold text-gray-900">Refund Processing</p>
                                    <p class="text-gray-700">Once approved, your refund will be processed within 14-21 working days.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Non-Refundable Items -->
                <div class="mb-10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-x-circle text-orange-600 text-2xl"></i>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900">8. Non-Refundable Items</h2>
                    </div>
                    
                    <div class="space-y-4 text-gray-700">
                        <p class="leading-relaxed">
                            The following items or services are generally non-refundable:
                        </p>
                        <ul class="list-disc list-inside ml-4 space-y-2">
                            <li>Completed property transactions where legal documentation has been finalized</li>
                            <li>Services already rendered (property inspections, consultations, etc.)</li>
                            <li>Third-party fees (bank charges, legal fees paid to external parties)</li>
                            <li>Properties where construction has commenced based on client's request</li>
                            <li>Customized services or products specifically created for the client</li>
                        </ul>
                        <p class="leading-relaxed mt-4">
                            Exceptions may be made in cases of company error or as otherwise specified in this policy.
                        </p>
                    </div>
                </div>

                <!-- Dispute Resolution -->
                <div class="mb-10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-teal-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-chat-dots text-teal-600 text-2xl"></i>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900">9. Dispute Resolution</h2>
                    </div>
                    
                    <div class="space-y-4 text-gray-700">
                        <p class="leading-relaxed">
                            If you are not satisfied with a refund decision, you may:
                        </p>
                        <ul class="list-disc list-inside ml-4 space-y-2">
                            <li>Request a review by our management team</li>
                            <li>Provide additional documentation or information</li>
                            <li>Seek mediation through a mutually agreed third party</li>
                            <li>Pursue legal remedies in accordance with Nigerian law</li>
                        </ul>
                        <p class="leading-relaxed mt-4">
                            We are committed to resolving disputes fairly and amicably. We encourage open communication to address any concerns.
                        </p>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="mb-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-envelope text-primary-600 text-2xl"></i>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900">10. Contact Us for Refund Requests</h2>
                    </div>
                    
                    <div class="bg-gradient-to-br from-primary-50 to-primary-100 rounded-xl p-6 border-2 border-primary-200 space-y-4">
                        <p class="text-gray-700 leading-relaxed">
                            For refund requests or questions about this policy, please contact us:
                        </p>
                        <div class="space-y-3">
                            <div class="flex items-center gap-3">
                                <i class="bi bi-building text-primary-600 text-xl"></i>
                                <div>
                                    <p class="font-semibold text-gray-900">B-Family Homes Limited</p>
                                    <p class="text-gray-700">Awkuzu, Anambra State, Nigeria</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <i class="bi bi-telephone-fill text-primary-600 text-xl"></i>
                                <div>
                                    <p class="text-gray-700">
                                        <a href="tel:+2348164856758" class="text-primary-600 hover:underline font-semibold">+234 816 485 6758</a>
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <i class="bi bi-envelope-fill text-primary-600 text-xl"></i>
                                <div>
                                    <p class="text-gray-700">
                                        <a href="mailto:admin@bfamilyhomes.com" class="text-primary-600 hover:underline font-semibold">admin@bfamilyhomes.com</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-primary-200">
                            <p class="text-sm text-gray-600">
                                <strong>Office Hours:</strong> Monday - Friday: 9:00 AM - 5:00 PM | Saturday: 10:00 AM - 2:00 PM
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Policy Updates -->
                <div class="mb-6">
                    <div class="bg-gray-50 rounded-xl p-6 border-2 border-gray-200">
                        <p class="text-gray-600 text-sm leading-relaxed">
                            <strong>Note:</strong> This refund policy may be updated from time to time. We will notify clients of significant changes. The version of the policy that applies to your refund request is the one in effect at the time of your payment.
                        </p>
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

