@extends('layouts.admin')

@section('title', 'Manage Blog Posts')

@section('content')
<div class="mb-8">
    <div class="flex items-center gap-2 text-xs md:text-sm text-gray-500 mb-4 px-2 md:px-0">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-orange-600 transition-colors">
            <i class="bi bi-house-door mr-1"></i>B-Family
        </a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-orange-600 font-semibold">Manage Blog Posts</span>
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
                    <i class="bi bi-journal-richtext text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-bold text-white">Manage Blog Posts</h1>
                    <p class="text-blue-100/80 text-sm mt-0.5">{{ $greeting }}, {{ auth()->user()->name }}!</p>
                    <p class="text-blue-300/60 text-xs mt-0.5">{{ now()->format('l, F j, Y') }}</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/10 backdrop-blur-sm rounded-lg text-white/80 text-xs border border-white/10">
                    <i class="bi bi-journal-richtext"></i>
                    {{ $blogs->total() }} Total
                </span>
                <a href="{{ route('admin.blogs.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-white text-blue-900 rounded-lg hover:bg-blue-50 font-semibold transition-all text-sm shadow-sm">
                    <i class="bi bi-plus-circle"></i>
                    Create
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Filter Tabs -->
<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-3 md:p-4 mb-6 mx-1 md:mx-0">
    <div class="flex flex-wrap items-center gap-2">
        <a href="{{ route('admin.blogs.index') }}" 
           class="px-4 py-2 rounded-lg font-semibold transition-all text-sm shadow-sm {{ !request('status') ? 'bg-gradient-to-r from-orange-500 to-yellow-500 text-white shadow-md' : 'bg-gray-50 text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
            All ({{ $blogs->total() }})
        </a>
        <a href="{{ route('admin.blogs.index', ['status' => 'published']) }}" 
           class="px-4 py-2 rounded-lg font-semibold transition-all text-sm shadow-sm {{ request('status') === 'published' ? 'bg-gradient-to-r from-orange-500 to-yellow-500 text-white shadow-md' : 'bg-gray-50 text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
            Published ({{ \App\Models\Blog::where('status', 'published')->count() }})
        </a>
        <a href="{{ route('admin.blogs.index', ['status' => 'draft']) }}" 
           class="px-4 py-2 rounded-lg font-semibold transition-all text-sm shadow-sm {{ request('status') === 'draft' ? 'bg-gradient-to-r from-orange-500 to-yellow-500 text-white shadow-md' : 'bg-gray-50 text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
            Draft ({{ \App\Models\Blog::where('status', 'draft')->count() }})
        </a>
    </div>
</div>

<div class="bg-white rounded-xl border border-gray-100 shadow-sm mx-1 md:mx-0">
    @if($blogs->count() > 0)
        <div class="overflow-x-auto p-6" style="-webkit-overflow-scrolling: touch;">
            <table class="w-full" style="min-width: 900px;">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Title</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Author</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Status</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Views</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Created</th>
                        <th class="text-right py-3 px-4 text-gray-500 font-semibold text-sm whitespace-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($blogs as $blog)
                    <tr class="border-b border-gray-50 last:border-0 hover:bg-gray-50/50 transition-colors">
                        <td class="py-4 px-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                @if($blog->featured_image)
                                <img src="{{ asset('storage/' . $blog->featured_image) }}" 
                                     alt="{{ $blog->title }}"
                                     class="w-14 h-14 object-cover rounded-lg ring-2 ring-gray-100">
                                @else
                                <div class="w-14 h-14 bg-gray-100 rounded-lg flex items-center justify-center ring-2 ring-gray-100">
                                    <i class="bi bi-image text-gray-400"></i>
                                </div>
                                @endif
                                <div>
                                    <h3 class="font-semibold text-gray-900 text-sm">{{ $blog->title }}</h3>
                                    <p class="text-xs text-gray-500 line-clamp-1">{{ Str::limit($blog->excerpt ?? strip_tags($blog->content), 60) }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-blue-900 rounded-full flex items-center justify-center text-white text-xs font-bold ring-2 ring-blue-100">
                                    {{ substr($blog->author->name, 0, 1) }}
                                </div>
                                <span class="text-gray-700 text-sm">{{ $blog->author->name }}</span>
                            </div>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            @if($blog->status === 'published')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-green-100 text-green-700">Published</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-yellow-100 text-yellow-700">Draft</span>
                            @endif
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <span class="text-gray-700 text-sm">{{ number_format($blog->views) }}</span>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <span class="text-sm text-gray-500">{{ $blog->created_at->format('M d, Y') }}</span>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">
                            <div class="relative action-menu">
                                <button onclick="toggleActionMenu(this)" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 transition-colors">
                                    <i class="bi bi-three-dots-vertical text-gray-400"></i>
                                </button>
                                <div class="hidden absolute right-0 top-full mt-1 bg-white rounded-xl border border-gray-100 shadow-lg py-1 min-w-[170px] z-50">
                                    <a href="{{ route('blogs.show', $blog->slug) }}" target="_blank"
                                       class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                        <i class="bi bi-eye text-gray-400"></i> View
                                    </a>
                                    <a href="{{ route('admin.blogs.edit', $blog->id) }}" 
                                       class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                        <i class="bi bi-pencil text-gray-400"></i> Edit
                                    </a>
                                    <div class="border-t border-gray-50 my-1"></div>
                                    <button onclick="deleteBlog({{ $blog->id }})" 
                                            class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-red-700 hover:bg-red-50 transition-colors text-left">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="px-6 pb-6">
            {{ $blogs->links() }}
        </div>
    @else
        <div class="text-center py-16">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="bi bi-journal-text text-3xl text-gray-300"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-1">No blog posts found</h3>
            <p class="text-sm text-gray-500 mb-4">Get started by creating your first blog post</p>
            <a href="{{ route('admin.blogs.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-gradient-to-r from-orange-500 to-yellow-500 text-white rounded-lg hover:from-orange-600 hover:to-yellow-600 font-semibold transition-all text-sm shadow-sm">
                <i class="bi bi-plus-circle"></i>
                Create First Post
            </a>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    function toggleActionMenu(btn) {
        var menu = btn.nextElementSibling;
        var isHidden = menu.classList.contains('hidden');
        closeAllMenus();
        if (isHidden) {
            menu.classList.remove('hidden');
        }
    }

    function closeAllMenus() {
        document.querySelectorAll('.action-menu > div:last-child').forEach(function(m) {
            m.classList.add('hidden');
        });
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.action-menu')) {
            closeAllMenus();
        }
    });

    function deleteBlog(id) {
        if (!confirm('Are you sure you want to delete this blog post? This action cannot be undone.')) {
            return;
        }

        window.ajax(`{{ url('admin/blogs') }}/${id}`, 'DELETE')
            .then(data => {
                window.toast(data.message, 'success');
                setTimeout(() => location.reload(), 1000);
            })
            .catch(error => {
                window.toast(error.message || 'Failed to delete blog post', 'error');
            });
    }
</script>
@endpush
