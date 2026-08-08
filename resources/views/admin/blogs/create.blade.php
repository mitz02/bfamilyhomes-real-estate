@extends('layouts.admin')

@section('title', 'Create Blog Post')

@section('content')
<div class="mb-8">
    <div class="flex items-center gap-2 text-xs md:text-sm text-gray-500 mb-4 px-2 md:px-0">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-orange-600 transition-colors">
            <i class="bi bi-house-door mr-1"></i>B-Family
        </a>
        <i class="bi bi-chevron-right text-xs"></i>
        <a href="{{ route('admin.blogs.index') }}" class="hover:text-orange-600 transition-colors">Blog Posts</a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-orange-600 font-semibold">Create Post</span>
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
                    <h1 class="text-xl md:text-2xl font-bold text-white">Create Blog Post</h1>
                    <p class="text-blue-100/80 text-sm mt-0.5">{{ $greeting }}, {{ auth()->user()->name }}!</p>
                    <p class="text-blue-300/60 text-xs mt-0.5">{{ now()->format('l, F j, Y') }}</p>
                </div>
            </div>
            <a href="{{ route('admin.blogs.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-white text-blue-900 rounded-lg hover:bg-blue-50 font-semibold transition-all text-sm shadow-sm">
                <i class="bi bi-arrow-left"></i>
                Back to Posts
            </a>
        </div>
    </div>
</div>

<form id="blogForm" enctype="multipart/form-data" class="max-w-4xl mx-1 md:mx-0">
    @csrf
    
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 mb-6">
        <h2 class="text-lg font-bold text-gray-900 mb-6">Blog Information</h2>
        
        <div class="space-y-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Title *</label>
                <input type="text" name="title" id="title" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all" required 
                       placeholder="Enter blog post title">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Excerpt (Short Description)</label>
                <textarea name="excerpt" rows="3" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all" 
                          placeholder="Brief summary of the blog post (optional)"></textarea>
                <p class="text-xs text-gray-500 mt-1">This will be shown in blog listings</p>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Content *</label>
                <textarea name="content" id="content" rows="15" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all" required
                          placeholder="Write your blog post content here..."></textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Featured Image</label>
                <input type="file" name="featured_image" id="featured_image" accept="image/*" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-orange-500/10 file:text-orange-600 hover:file:bg-orange-500/20">
                <p class="text-xs text-gray-500 mt-1">Recommended size: 1200x630px</p>
                <div id="imagePreview" class="mt-4 hidden">
                    <img id="previewImg" src="" alt="Preview" class="w-full max-w-md rounded-xl ring-2 ring-gray-100">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Status *</label>
                <select name="status" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all bg-white appearance-none" required>
                    <option value="draft">Draft</option>
                    <option value="published">Published</option>
                </select>
            </div>
        </div>
    </div>

    <div class="flex items-center justify-end gap-4">
        <a href="{{ route('admin.blogs.index') }}" class="px-4 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-semibold transition-all text-sm">Cancel</a>
        <button type="submit" class="px-4 py-2.5 bg-gradient-to-r from-orange-500 to-yellow-500 text-white rounded-lg hover:from-orange-600 hover:to-yellow-600 font-semibold transition-all text-sm shadow-sm flex items-center gap-2">
            <i class="bi bi-check-circle"></i>
            Create Post
        </button>
    </div>
</form>
@endsection

@push('scripts')
<script>
    document.getElementById('blogForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const form = e.target;
        const formData = new FormData(form);
        const submitBtn = form.querySelector('button[type="submit"]');
        
        showLoader(submitBtn);
        
        try {
            const data = await window.ajax('{{ route("admin.blogs.store") }}', 'POST', formData, true);
            window.toast(data.message, 'success');
            setTimeout(() => {
                window.location.href = data.redirect;
            }, 1000);
        } catch (error) {
            window.toast(error.message || 'Failed to create blog post', 'error');
        } finally {
            hideLoader(submitBtn);
        }
    });

    document.getElementById('featured_image').addEventListener('change', function(e) {
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
</script>
@endpush
