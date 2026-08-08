@extends('layouts.agent')

@section('title', 'Edit Property')

@section('content')
<div class="mb-8">
    <div class="relative bg-gradient-to-br from-blue-900 via-blue-800 to-blue-900 rounded-2xl p-6 md:p-8 shadow-lg overflow-hidden">
        <div class="absolute -top-10 -right-10 w-48 h-48 bg-white/5 rounded-full"></div>
        <div class="absolute -bottom-10 -left-10 w-36 h-36 bg-white/5 rounded-full"></div>
        <div class="absolute top-1/2 right-1/3 w-20 h-20 bg-white/5 rounded-full"></div>

        <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-start gap-4">
                <div class="w-14 h-14 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center shadow-sm flex-shrink-0 border border-white/10">
                    <i class="bi bi-pencil-square text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-bold text-white">Edit Property</h1>
                    <p class="text-blue-100/80 text-sm mt-0.5">Update property details</p>
                </div>
            </div>
            <a href="{{ route('agent.properties.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white/10 text-white rounded-xl hover:bg-white/20 font-semibold transition-all text-sm backdrop-blur-sm border border-white/10 flex-shrink-0">
                <i class="bi bi-arrow-left"></i>
                Back to Properties
            </a>
        </div>
    </div>
</div>

<form id="propertyForm" enctype="multipart/form-data" class="max-w-4xl">
    @csrf
    @method('PUT')
    
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Basic Information</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Property Title *</label>
                <input type="text" name="title" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500" required 
                       value="{{ $property->title }}"
                       placeholder="e.g., Luxury 3 Bedroom Apartment">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Description *</label>
                <textarea name="description" rows="5" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500" required
                          placeholder="Describe the property in detail...">{{ $property->description }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Property Type *</label>
                <select name="type" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500" required {{ $property->type === 'Investment' ? 'disabled' : '' }}>
                    <option value="">Select Type</option>
                    <option value="Rent" {{ $property->type === 'Rent' ? 'selected' : '' }}>For Rent</option>
                    <option value="Sale" {{ $property->type === 'Sale' ? 'selected' : '' }}>For Sale</option>
                    @if($property->type === 'Investment')
                    <option value="Investment" selected>Investment (Cannot be changed)</option>
                    @endif
                </select>
                @if($property->type === 'Investment')
                <p class="text-xs text-yellow-600 mt-1">
                    <i class="bi bi-exclamation-triangle"></i> Investment properties cannot be edited by agents
                </p>
                @else
                <p class="text-xs text-gray-400 mt-1">
                    <i class="bi bi-info-circle"></i> Investment properties can only be created by administrators
                </p>
                @endif
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Category *</label>
                <select name="category" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500" required>
                    <option value="">Select Category</option>
                    @foreach(config('bfamily.property.categories') as $cat)
                    <option value="{{ $cat }}" {{ $property->category === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Price (₦) *</label>
                <input type="number" name="price" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500" required 
                       value="{{ $property->price }}"
                       min="0" step="0.01" placeholder="0.00">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Location *</label>
                <input type="text" name="location" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500" required 
                       value="{{ $property->location }}"
                       placeholder="e.g., Lagos, Victoria Island">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Full Address *</label>
                <input type="text" name="address" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500" required 
                       value="{{ $property->address }}"
                       placeholder="Street address">
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Property Details</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Bedrooms</label>
                <input type="number" name="bedrooms" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500" 
                       value="{{ $property->bedrooms }}"
                       min="0" placeholder="0">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Bathrooms</label>
                <input type="number" name="bathrooms" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500" 
                       value="{{ $property->bathrooms }}"
                       min="0" placeholder="0">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Parking Spaces</label>
                <input type="number" name="parking" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500" 
                       value="{{ $property->parking }}"
                       min="0" placeholder="0">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Size (sq ft)</label>
                <input type="number" name="size" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500" 
                       value="{{ $property->size }}"
                       min="0" step="0.01" placeholder="0.00">
            </div>
        </div>

        <div class="mt-6">
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Features</label>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mt-2">
                @php
                    $features = ['Air Conditioning', 'Swimming Pool', 'Gym', 'Security', 'Parking', 'Garden', 'Balcony', 'Elevator', 'WiFi', 'Furnished'];
                    $propertyFeatures = $property->features ?? [];
                @endphp
                @foreach($features as $feature)
                <label class="flex items-center">
                    <input type="checkbox" name="features[]" value="{{ $feature }}" 
                           {{ in_array($feature, $propertyFeatures) ? 'checked' : '' }}
                           class="rounded text-orange-600 focus:ring-orange-500">
                    <span class="ml-2 text-sm text-gray-700">{{ $feature }}</span>
                </label>
                @endforeach
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Property Images</h2>
        
        <!-- Existing Images -->
        @if($property->images && count($property->images) > 0)
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-3">Current Images</label>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($property->images as $index => $image)
                @php
                    $imageUrl = is_string($image) && (str_starts_with($image, 'http') || str_starts_with($image, '/')) 
                        ? $image 
                        : asset('storage/' . $image);
                @endphp
                <div class="relative group">
                    <img src="{{ $imageUrl }}" 
                         alt="Property image {{ $index + 1 }}"
                         class="w-full h-32 object-cover rounded-lg border-2 border-gray-200">
                    <button type="button" 
                            onclick="removeExistingImage({{ $index }})"
                            class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <i class="bi bi-x text-xs"></i>
                    </button>
                </div>
                @endforeach
            </div>
        </div>
        @endif
        
        <!-- New Images Upload -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Add More Images *</label>
            <input type="file" name="images[]" id="images" 
                   class="w-full px-4 py-2.5 border border-gray-200 rounded-xl file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-orange-500/10 file:text-orange-600 hover:file:bg-orange-500/20 focus:ring-2 focus:ring-orange-500 focus:border-orange-500" 
                   accept="image/*" multiple>
            <p class="text-xs text-gray-400 mt-1">You can select multiple images. Max 5MB per image.</p>
            
            <div id="imagePreview" class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4"></div>
        </div>
    </div>

    <div class="flex gap-4">
        <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-orange-500 to-yellow-500 text-white rounded-xl hover:from-orange-600 hover:to-yellow-600 font-semibold transition-all duration-200 shadow-sm hover:shadow-md text-sm">
            <i class="bi bi-check-circle"></i>
            Update Property
        </button>
        <a href="{{ route('agent.properties.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 font-semibold transition-all text-sm">
            Cancel
        </a>
    </div>
</form>
@endsection

@push('scripts')
<script>
    const existingImages = @json($property->images ?? []);
    const removedImages = [];

    function removeExistingImage(index) {
        if (confirm('Remove this image?')) {
            removedImages.push(index);
            event.target.closest('.relative').remove();
        }
    }

    // Image Preview
    document.getElementById('images').addEventListener('change', function(e) {
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = '';
        
        Array.from(e.target.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative';
                div.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-32 object-cover rounded-lg border-2 border-gray-200">
                `;
                preview.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    });

    // Form Submission
    document.getElementById('propertyForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const form = e.target;
        const submitBtn = form.querySelector('button[type="submit"]');
        const formData = new FormData(form);
        
        // Add removed image indices
        removedImages.forEach(index => {
            formData.append('removed_images[]', index);
        });
        
        showLoader(submitBtn);
        
        try {
            const data = await window.ajax('{{ route("agent.properties.update", $property->id) }}', 'POST', formData);
            window.toast(data.message, 'success');
            setTimeout(() => {
                window.location.href = data.redirect;
            }, 1500);
        } catch (error) {
            hideLoader(submitBtn);
            window.toast(error.message || 'Failed to update property', 'error');
        }
    });
</script>
@endpush
