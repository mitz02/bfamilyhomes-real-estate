@extends('layouts.agent')

@section('title', 'Add New Property')

@section('content')
<div class="mb-8">
    <div class="relative bg-gradient-to-br from-blue-900 via-blue-800 to-blue-900 rounded-2xl p-6 md:p-8 shadow-lg overflow-hidden">
        <div class="absolute -top-10 -right-10 w-48 h-48 bg-white/5 rounded-full"></div>
        <div class="absolute -bottom-10 -left-10 w-36 h-36 bg-white/5 rounded-full"></div>
        <div class="absolute top-1/2 right-1/3 w-20 h-20 bg-white/5 rounded-full"></div>

        <div class="relative flex flex-col md:flex-row md:items-center gap-4">
            <div class="w-14 h-14 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center shadow-sm flex-shrink-0 border border-white/10">
                <i class="bi bi-plus-circle text-white text-2xl"></i>
            </div>
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-white">Add New Property</h1>
                <p class="text-blue-100/80 text-sm mt-0.5">Fill in the details to list a new property</p>
            </div>
        </div>
    </div>
</div>

<form id="propertyForm" enctype="multipart/form-data" class="max-w-4xl">
    @csrf
    
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Basic Information</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Property Title *</label>
                <input type="text" name="title" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500" required 
                       placeholder="e.g., Luxury 3 Bedroom Apartment">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Description *</label>
                <textarea name="description" rows="5" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500" required
                          placeholder="Describe the property in detail..."></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Property Type *</label>
                <select name="type" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500" required>
                    <option value="">Select Type</option>
                    <option value="Rent">For Rent</option>
                    <option value="Sale">For Sale</option>
                </select>
                <p class="text-xs text-gray-400 mt-1">
                    <i class="bi bi-info-circle"></i> Investment properties can only be created by administrators
                </p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Category *</label>
                <select name="category" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500" required>
                    <option value="">Select Category</option>
                    @foreach(config('bfamily.property.categories') as $cat)
                    <option value="{{ $cat }}">{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Price (₦) *</label>
                <input type="number" name="price" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500" required min="0" step="0.01"
                       placeholder="5000000">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Location *</label>
                <input type="text" name="location" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500" required
                       placeholder="e.g., Lekki, Lagos">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Full Address *</label>
                <input type="text" name="address" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500" required
                       placeholder="Complete property address">
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Property Details</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Bedrooms</label>
                <input type="number" name="bedrooms" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500" min="0" placeholder="3">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Bathrooms</label>
                <input type="number" name="bathrooms" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500" min="0" placeholder="2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Parking Spaces</label>
                <input type="number" name="parking" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500" min="0" placeholder="1">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Size (Sqft)</label>
                <input type="number" name="size" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500" min="0" step="0.01" placeholder="1500">
            </div>
        </div>

        <div class="mt-6">
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Features (Check all that apply)</label>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                @foreach(['Swimming Pool', 'Gym', '24/7 Security', 'Electricity', 'Water Supply', 'Internet', 'Generator', 'Garden', 'Balcony'] as $feature)
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="features[]" value="{{ $feature }}" class="rounded text-orange-600 focus:ring-orange-500">
                    <span class="text-gray-700 text-sm">{{ $feature }}</span>
                </label>
                @endforeach
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Property Images *</h2>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Upload Images (Min: 1, Max: 10)</label>
            <input type="file" name="images[]" multiple accept="image/*" 
                   class="w-full px-4 py-2.5 border border-gray-200 rounded-xl file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-orange-500/10 file:text-orange-600 hover:file:bg-orange-500/20 focus:ring-2 focus:ring-orange-500 focus:border-orange-500" required>
            <p class="text-sm text-gray-500 mt-2">Upload high-quality images of the property. Max 5MB per image.</p>
        </div>
    </div>

    <div class="flex gap-4">
        <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-orange-500 to-yellow-500 text-white rounded-xl hover:from-orange-600 hover:to-yellow-600 font-semibold transition-all duration-200 shadow-sm hover:shadow-md text-sm">
            <i class="bi bi-check-circle"></i>
            Submit Property
        </button>
        <a href="{{ route('agent.properties.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 font-semibold transition-all text-sm">
            <i class="bi bi-x-circle"></i>
            Cancel
        </a>
    </div>
</form>
@endsection

@push('scripts')
<script>
    document.getElementById('propertyForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const form = e.target;
        const submitBtn = form.querySelector('button[type="submit"]');
        const formData = new FormData(form);
        
        showLoader(submitBtn);
        
        try {
            const data = await window.ajax('{{ route("agent.properties.store") }}', 'POST', formData);
            window.toast(data.message, 'success');
            setTimeout(() => window.location.href = data.redirect, 1500);
        } catch (error) {
            hideLoader(submitBtn);
            window.toast(error.message || 'Failed to create property', 'error');
        }
    });
</script>
@endpush
