@extends('layouts.app')

@section('title', 'Contact B-Family Homes - #1 Real Estate Agency in Anambra, Enugu, Delta, Nigeria')
@section('description', 'Contact B-Family Homes Limited in Awkuzu, Anambra State, Nigeria. Get in touch for property inquiries, sales, rentals, and investment opportunities across Anambra, Enugu, Delta, Imo, Ebonyi, Abia, Rivers, Lagos, and Abuja. Call +234 816 485 6758.')
@section('og:title', 'Contact B-Family Homes - Real Estate in Anambra & South East Nigeria')
@section('og:description', 'Reach out to B-Family Homes for premium real estate services across Anambra, Enugu, Delta, Imo, Abia, Rivers, Lagos, and Abuja. Call +234 816 485 6758.')

@push('schemas')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "ContactPage",
    "name": "Contact B-Family Homes Limited",
    "description": "Contact B-Family Homes for premium real estate services across Nigeria.",
    "url": "{{ url()->current() }}",
    "mainEntity": {
        "@type": "RealEstateAgent",
        "name": "B-Family Homes Limited",
        "telephone": "+2348164856758",
        "email": "admin@bfamilyhomes.com",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "No1, Ananti Jerry Chijioke Street",
            "addressLocality": "Awkuzu",
            "addressRegion": "Anambra State",
            "addressCountry": "NG"
        }
    }
}
</script>
@endpush

@section('content')
<section class="bg-gradient-primary py-16">
    <div class="container mx-auto px-4 text-center text-white">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Contact Us</h1>
        <p class="text-lg opacity-90">Get in touch with our team</p>
    </div>
</section>

<section class="py-16">
    <div class="container mx-auto px-4" style="max-width: 1400px;">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Contact Form -->
                <div class="card p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Send us a Message</h2>
                    
                    <form id="contactForm" class="space-y-4">
                        @csrf
                        <div>
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-input" required>
                        </div>

                        <div>
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-input" required>
                        </div>

                        <div>
                            <label class="form-label">Phone Number</label>
                            <input type="tel" name="phone" class="form-input" required>
                        </div>

                        <div>
                            <label class="form-label">Subject</label>
                            <input type="text" name="subject" class="form-input">
                        </div>

                        <div>
                            <label class="form-label">Message</label>
                            <textarea name="message" rows="5" class="form-input" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-full">
                            <i class="bi bi-send"></i>
                            Send Message
                        </button>
                    </form>
                </div>

                <!-- Contact Info -->
                <div>
                    <div class="card p-8 mb-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Get in Touch</h2>
                        
                        <div class="space-y-4">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="bi bi-geo-alt-fill text-primary-600 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 mb-1">Office Address</h3>
                                    <p class="text-gray-600">{{ config('bfamily.company.address') }}</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="bi bi-telephone-fill text-primary-600 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 mb-1">Phone</h3>
                                    <a href="tel:{{ config('bfamily.company.phone') }}" class="text-gray-600 hover:text-primary-600">
                                        {{ config('bfamily.company.phone') }}
                                    </a>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="bi bi-envelope-fill text-primary-600 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 mb-1">Email</h3>
                                    <a href="mailto:{{ config('bfamily.company.email') }}" class="text-gray-600 hover:text-primary-600">
                                        {{ config('bfamily.company.email') }}
                                    </a>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="bi bi-whatsapp text-primary-600 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 mb-1">WhatsApp</h3>
                                    <a href="https://wa.me/{{ str_replace(['+', ' '], '', config('bfamily.company.whatsapp')) }}" 
                                       class="text-gray-600 hover:text-primary-600">
                                        {{ config('bfamily.company.whatsapp') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card p-8">
    <h3 class="text-xl font-bold text-gray-900 mb-4">Office Hours</h3>
    <div class="space-y-2 text-gray-700">
        <p>
            <span class="font-semibold">Monday – Saturday:</span>
            7:00 AM – 6:30 PM
        </p>
        <p>
            <span class="font-semibold">Sunday:</span>
            Closed
        </p>
    </div>
</div>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.getElementById('contactForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const form = e.target;
        const submitBtn = form.querySelector('button[type="submit"]');
        const formData = new FormData(form);
        
        showLoader(submitBtn);
        
        try {
            const data = await window.ajax('{{ route("contact.submit") }}', 'POST', {
                name: formData.get('name'),
                email: formData.get('email'),
                phone: formData.get('phone'),
                subject: formData.get('subject'),
                message: formData.get('message'),
            });
            
            window.toast(data.message, 'success');
            form.reset();
        } catch (error) {
            window.toast(error.message || 'Failed to send message', 'error');
        } finally {
            hideLoader(submitBtn);
        }
    });
</script>
@endpush
