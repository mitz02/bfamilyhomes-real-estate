@extends('layouts.admin')

@section('title', 'Create Property')

@section('content')
<div class="mb-8">
    <div class="flex items-center gap-2 text-xs md:text-sm text-gray-500 mb-4 px-2 md:px-0">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-orange-600 transition-colors">
            <i class="bi bi-house-door mr-1"></i>B-Family
        </a>
        <i class="bi bi-chevron-right text-xs"></i>
        <a href="{{ route('admin.properties') }}" class="hover:text-orange-600 transition-colors">Manage Properties</a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-orange-600 font-semibold">Create Property</span>
    </div>

    @php
        $hour = now()->hour;
        if ($hour < 12) $greeting = 'Good Morning';
        elseif ($hour < 17) $greeting = 'Good Afternoon';
        else $greeting = 'Good Evening';
    @endphp
    <div class="relative bg-gradient-to-br from-blue-900 via-blue-800 to-blue-900 rounded-2xl p-6 md:p-8 shadow-lg overflow-hidden">
        <div class="absolute -top-10 -right-10 w-48 h-48 bg-white/5 rounded-full"></div>
        <div class="absolute -bottom-10 -left-10 w-36 h-36 bg-white/5 rounded-full"></div>
        <div class="absolute top-1/2 right-1/3 w-20 h-20 bg-white/5 rounded-full"></div>

        <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-start gap-4">
                <div class="w-14 h-14 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center shadow-sm flex-shrink-0 border border-white/10">
                    <i class="bi bi-plus-circle text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-bold text-white">Create New Property</h1>
                    <p class="text-blue-100/80 text-sm mt-0.5">{{ $greeting }}, {{ auth()->user()->name }}!</p>
                    <p class="text-blue-300/60 text-xs mt-0.5">{{ now()->format('l, F j, Y') }}</p>
                </div>
            </div>
            <a href="{{ route('admin.properties') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-white text-blue-900 rounded-lg hover:bg-blue-50 font-semibold transition-all text-sm shadow-sm">
                <i class="bi bi-arrow-left"></i>
                Back to Properties
            </a>
        </div>
    </div>
</div>

<form id="propertyForm" enctype="multipart/form-data" class="max-w-4xl mx-1 md:mx-0">
    @csrf
    
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 mb-6">
        <h2 class="text-lg font-bold text-gray-900 mb-6">Basic Information</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Property Title *</label>
                <input type="text" name="title" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all" required 
                       placeholder="e.g., Luxury 3 Bedroom Apartment">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Description *</label>
                <textarea name="description" rows="5" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all" required
                          placeholder="Describe the property in detail..."></textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Property Type *</label>
                <select name="type" id="propertyType" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all bg-white appearance-none" required>
                    <option value="">Select Type</option>
                    <option value="Rent">For Rent</option>
                    <option value="Sale">For Sale</option>
                    <option value="Investment">Investment</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Category *</label>
                <select name="category" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all bg-white appearance-none" required>
                    <option value="">Select Category</option>
                    @foreach(config('bfamily.property.categories') as $cat)
                    <option value="{{ $cat }}">{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Assign to Agent (Optional)</label>
                <select name="agent_id" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all bg-white appearance-none">
                    <option value="">No Agent (Admin Owned)</option>
                    @foreach($agents as $agent)
                    <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Price (₦) *</label>
                <input type="number" name="price" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all" required min="0" step="0.01"
                       placeholder="5000000">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Location *</label>
                <input type="text" name="location" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all" required
                       placeholder="e.g., Lekki, Lagos">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Full Address *</label>
                <input type="text" name="address" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all" required
                       placeholder="Complete property address">
            </div>

            <div class="md:col-span-2">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_featured" class="w-4 h-4 rounded border-gray-300 text-orange-500 focus:ring-orange-500">
                    <span class="text-sm font-semibold text-gray-700">Feature this property</span>
                </label>
            </div>
        </div>
    </div>

    <!-- Investment Details -->
    <div id="investmentDetails" class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 mb-6 hidden">
        <div class="flex items-center gap-2 mb-6">
            <div class="w-8 h-8 bg-orange-500/10 rounded-lg flex items-center justify-center">
                <i class="bi bi-graph-up-arrow text-orange-500 text-sm"></i>
            </div>
            <h2 class="text-lg font-bold text-gray-900">Investment Details</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">ROI Percentage (%) *</label>
                <input type="number" name="roi_percentage" id="roi_percentage" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all" 
                       min="0" max="100" step="0.01" placeholder="e.g., 15.5">
                <p class="text-xs text-gray-500 mt-1">Expected return on investment percentage</p>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Investment Duration (Months) *</label>
                <input type="number" name="investment_duration" id="investment_duration" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all" 
                       min="1" placeholder="e.g., 12">
                <p class="text-xs text-gray-500 mt-1">Duration in months for the investment</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 mb-6">
        <h2 class="text-lg font-bold text-gray-900 mb-6">Property Details</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Bedrooms</label>
                <input type="number" name="bedrooms" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all" min="0" placeholder="3">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Bathrooms</label>
                <input type="number" name="bathrooms" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all" min="0" placeholder="2">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Parking Spaces</label>
                <input type="number" name="parking" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all" min="0" placeholder="1">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Size (Sqft)</label>
                <input type="number" name="size" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all" min="0" step="0.01" placeholder="1500">
            </div>
        </div>

        <div class="mt-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Features (Check all that apply)</label>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                @foreach(['Swimming Pool', 'Gym', '24/7 Security', 'Electricity', 'Water Supply', 'Internet', 'Generator', 'Garden', 'Balcony'] as $feature)
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="features[]" value="{{ $feature }}" class="w-4 h-4 rounded border-gray-300 text-orange-500 focus:ring-orange-500">
                    <span class="text-sm text-gray-700">{{ $feature }}</span>
                </label>
                @endforeach
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 mb-6">
        <h2 class="text-lg font-bold text-gray-900 mb-6">Property Images *</h2>
        
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Upload Images (Min: 1, Max: 10)</label>
            <input type="file" name="images[]" multiple accept="image/*" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-orange-500/10 file:text-orange-600 hover:file:bg-orange-500/20" required>
            <p class="text-xs text-gray-500 mt-2">Upload high-quality images of the property. Max 5MB per image.</p>
        </div>
    </div>

    <div class="flex gap-4">
        <button type="submit" class="px-4 py-2.5 bg-gradient-to-r from-orange-500 to-yellow-500 text-white rounded-lg hover:from-orange-600 hover:to-yellow-600 font-semibold transition-all text-sm shadow-sm flex items-center gap-2">
            <i class="bi bi-check-circle"></i>
            Create Property
        </button>
        <a href="{{ route('admin.properties') }}" class="px-4 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-semibold transition-all text-sm flex items-center gap-2">
            <i class="bi bi-x-circle"></i>
            Cancel
        </a>
    </div>
</form>
@endsection

@push('scripts')
<script>
    document.getElementById('propertyType').addEventListener('change', function() {
        const investmentDetails = document.getElementById('investmentDetails');
        const roiInput = document.getElementById('roi_percentage');
        const durationInput = document.getElementById('investment_duration');
        
        if (this.value === 'Investment') {
            investmentDetails.classList.remove('hidden');
            roiInput.setAttribute('required', 'required');
            durationInput.setAttribute('required', 'required');
        } else {
            investmentDetails.classList.add('hidden');
            roiInput.removeAttribute('required');
            durationInput.removeAttribute('required');
        }
    });

    document.getElementById('propertyForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const form = e.target;
        const submitBtn = form.querySelector('button[type="submit"]');
        const formData = new FormData(form);
        
        const fileInput = form.querySelector('input[name="images[]"]');
        if (fileInput && fileInput.files.length > 0) {
            let totalSize = 0;
            const maxSize = 5 * 1024 * 1024;
            const maxTotalSize = 50 * 1024 * 1024;
            
            for (let file of fileInput.files) {
                if (file.size > maxSize) {
                    window.toast(`File "${file.name}" is too large. Maximum size is 5MB per file.`, 'error');
                    return;
                }
                totalSize += file.size;
            }
            
            if (totalSize > maxTotalSize) {
                window.toast('Total file size exceeds 50MB. Please reduce the number or size of images.', 'error');
                return;
            }
        }
        
        form.querySelectorAll('.border-red-500').forEach(el => {
            el.classList.remove('border-red-500');
        });
        
        showLoader(submitBtn);
        
        try {
            const data = await window.ajax('{{ route("admin.properties.store") }}', 'POST', formData);
            window.toast(data.message, 'success');
            setTimeout(() => window.location.href = data.redirect, 1500);
        } catch (error) {
            hideLoader(submitBtn);
            
            let errorMessage = error.message || 'Failed to create property';
            
            if (error.message && error.message.includes('timeout')) {
                errorMessage = 'Upload timed out. The files may be too large. Please try with fewer or smaller images.';
            } else if (error.message && error.message.includes('Network error')) {
                errorMessage = 'Network error occurred. Please check your connection and try again.';
            } else if (error.message && error.message.includes('ERR_CONNECTION')) {
                errorMessage = 'Connection was reset. This usually means the files are too large or the server timed out.';
            }
            
            if (error.errors) {
                const errorMessages = Object.values(error.errors).flat();
                errorMessage = errorMessages[0] || errorMessage;
                
                Object.keys(error.errors).forEach(field => {
                    const input = form.querySelector(`[name="${field}"], [name="${field}[]"]`);
                    if (input) {
                        input.classList.add('border-red-500');
                    }
                });
            }
            
            window.toast(errorMessage, 'error');
            console.error('Property creation error:', error);
        }
    });
</script>
@endpush
