@extends('layouts.admin')

@section('title', 'Promotions Management')

@section('content')
<div class="mb-8">
    <div class="flex items-center gap-2 text-xs md:text-sm text-gray-500 mb-4 px-2 md:px-0">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-orange-600 transition-colors">
            <i class="bi bi-house-door mr-1"></i>B-Family
        </a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-orange-600 font-semibold">Promotions</span>
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
                    <i class="bi bi-megaphone-fill text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-bold text-white">Promotions Management</h1>
                    <p class="text-blue-100/80 text-sm mt-0.5">{{ $greeting }}, {{ auth()->user()->name }}!</p>
                    <p class="text-blue-300/60 text-xs mt-0.5">{{ now()->format('l, F j, Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 mx-1 md:mx-0">
    <div class="flex items-center gap-2 mb-6">
        <div class="w-8 h-8 bg-orange-500/10 rounded-lg flex items-center justify-center">
            <i class="bi bi-image text-orange-500 text-sm"></i>
        </div>
        <h2 class="text-lg font-bold text-gray-900">Current Promotion</h2>
    </div>

    @if($promotion)
    <div class="mb-6 p-6 bg-gradient-to-br from-blue-50 to-blue-100/50 rounded-xl border border-blue-100">
        <div class="flex flex-col md:flex-row gap-6">
            <div class="flex-shrink-0">
                <img src="{{ asset('storage/' . $promotion->image) }}" 
                     alt="Promotion"
                     class="w-full md:w-64 h-auto rounded-xl shadow-sm ring-2 ring-gray-100 object-cover">
            </div>
            <div class="flex-1">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        @if($promotion->title)
                        <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $promotion->title }}</h3>
                        @endif
                        @if($promotion->description)
                        <p class="text-gray-600 text-sm mb-3">{{ $promotion->description }}</p>
                        @endif
                        @if($promotion->link)
                        <a href="{{ $promotion->link }}" target="_blank" class="text-orange-600 hover:text-orange-700 font-semibold text-sm inline-flex items-center gap-2">
                            <span>View Link</span>
                            <i class="bi bi-box-arrow-up-right"></i>
                        </a>
                        @endif
                    </div>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-green-100 text-green-700">Active</span>
                </div>
                <div class="flex gap-3">
                    <button onclick="deletePromotion({{ $promotion->id }})" 
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-semibold transition-all text-sm flex items-center gap-2">
                        <i class="bi bi-trash"></i>
                        Delete Promotion
                    </button>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="text-center py-12 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200 mb-6">
        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="bi bi-image text-3xl text-gray-300"></i>
        </div>
        <h3 class="text-lg font-bold text-gray-900 mb-1">No Active Promotion</h3>
        <p class="text-sm text-gray-500 mb-6">Upload a promotional image to display on the home page</p>
    </div>
    @endif

    <div class="mt-8 pt-8 border-t border-gray-100">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Upload New Promotion</h3>
        <form id="promotionForm" enctype="multipart/form-data" class="space-y-6 max-w-2xl">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Promotional Image *</label>
                <input type="file" name="image" id="promotionImage" accept="image/*" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-orange-500/10 file:text-orange-600 hover:file:bg-orange-500/20" required>
                <p class="text-xs text-gray-500 mt-1">Recommended size: 1200x800px. Max size: 5MB</p>
                <div id="imagePreview" class="mt-4 hidden">
                    <img id="previewImg" src="" alt="Preview" class="max-w-md h-auto rounded-xl ring-2 ring-gray-100 shadow-sm">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Title (Optional)</label>
                <input type="text" name="title" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all" placeholder="Enter promotion title">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Description (Optional)</label>
                <textarea name="description" rows="3" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all" placeholder="Enter promotion description"></textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Link (Optional)</label>
                <input type="url" name="link" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all" placeholder="https://example.com">
                <p class="text-xs text-gray-500 mt-1">Users will be redirected to this link when clicking the promotion</p>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="px-4 py-2.5 bg-gradient-to-r from-orange-500 to-yellow-500 text-white rounded-lg hover:from-orange-600 hover:to-yellow-600 font-semibold transition-all text-sm shadow-sm flex items-center gap-2">
                    <i class="bi bi-upload"></i>
                    Upload Promotion
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('promotionImage')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImg').src = e.target.result;
                document.getElementById('imagePreview').classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    });

    document.getElementById('promotionForm')?.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const form = e.target;
        const formData = new FormData(form);
        const submitBtn = form.querySelector('button[type="submit"]');
        
        if (!formData.get('image').size) {
            window.toast('Please select an image', 'error');
            return;
        }
        
        showLoader(submitBtn);
        
        try {
            const response = await fetch('{{ route("admin.promotions.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                },
                body: formData
            });
            
            const data = await response.json();
            
            if (data.success) {
                window.toast(data.message, 'success');
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                window.toast(data.message || 'Failed to upload promotion', 'error');
            }
        } catch (error) {
            window.toast('Failed to upload promotion', 'error');
        } finally {
            hideLoader(submitBtn);
        }
    });

    async function deletePromotion(id) {
        if (!confirm('Are you sure you want to delete this promotion? This action cannot be undone.')) {
            return;
        }
        
        try {
            const response = await fetch(`{{ route("admin.promotions.delete", ":id") }}`.replace(':id', id), {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
                    'Accept': 'application/json'
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                window.toast(data.message, 'success');
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                window.toast(data.message || 'Failed to delete promotion', 'error');
            }
        } catch (error) {
            window.toast('Failed to delete promotion', 'error');
        }
    }
</script>
@endpush
