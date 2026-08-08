@extends('layouts.app')

@section('title', $blog->title . ' | B-Family Homes Blog')
@section('description', $blog->excerpt ? strip_tags($blog->excerpt) : Str::limit(strip_tags($blog->content), 160))
@section('og:title', $blog->title . ' | B-Family Homes Blog')
@section('og:description', $blog->excerpt ? strip_tags($blog->excerpt) : Str::limit(strip_tags($blog->content), 160))
@section('og:image', $blog->featured_image ? asset('storage/' . $blog->featured_image) : asset('images/logo.png'))
@section('og:type', 'article')
@section('twitter:title', $blog->title . ' | B-Family Homes Blog')
@section('twitter:description', $blog->excerpt ? strip_tags($blog->excerpt) : Str::limit(strip_tags($blog->content), 160))

@push('schemas')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
        {"@type": "ListItem", "position": 1, "name": "Home", "item": "{{ route('home') }}"},
        {"@type": "ListItem", "position": 2, "name": "Blog", "item": "{{ route('blogs.index') }}"},
        {"@type": "ListItem", "position": 3, "name": "{{ $blog->title }}", "item": "{{ url()->current() }}"}
    ]
}
</script>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Article",
    "headline": "{{ $blog->title }}",
    "description": "{{ $blog->excerpt ? strip_tags($blog->excerpt) : Str::limit(strip_tags($blog->content), 160) }}",
    "image": "{{ $blog->featured_image ? asset('storage/' . $blog->featured_image) : asset('images/logo.png') }}",
    "author": {
        "@type": "Person",
        "name": "{{ $blog->author->name }}"
    },
    "publisher": {
        "@type": "Organization",
        "name": "B-Family Homes Limited",
        "logo": {
            "@type": "ImageObject",
            "url": "{{ asset('images/logo.png') }}"
        }
    },
    "datePublished": "{{ $blog->created_at->toIso8601String() }}",
    "dateModified": "{{ $blog->updated_at->toIso8601String() }}",
    "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "{{ url()->current() }}"
    }
}
</script>
@endpush

@section('content')
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4" style="max-width: 900px;">
        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 text-sm text-gray-600 mb-6">
            <a href="{{ route('home') }}" class="hover:text-primary-600">Home</a>
            <i class="bi bi-chevron-right"></i>
            <a href="{{ route('blogs.index') }}" class="hover:text-primary-600">Blog</a>
            <i class="bi bi-chevron-right"></i>
            <span class="text-gray-900">{{ $blog->title }}</span>
        </div>

        <article class="bg-white rounded-xl shadow-md overflow-hidden">
            @if($blog->featured_image)
            <img src="{{ asset('storage/' . $blog->featured_image) }}" 
                 alt="{{ $blog->title }} - B-Family Homes Blog"
                 loading="lazy"
                 class="w-full h-96 object-cover">
            @endif
            
            <div class="p-8 md:p-12">
                <div class="flex items-center gap-4 text-sm text-gray-500 mb-6">
                    <div class="flex items-center gap-2">
                        <div class="w-10 h-10 bg-primary-600 rounded-full flex items-center justify-center text-white font-bold">
                            {{ substr($blog->author->name, 0, 1) }}
                        </div>
                        <span>{{ $blog->author->name }}</span>
                    </div>
                    <span>•</span>
                    <span>{{ $blog->created_at->format('F d, Y') }}</span>
                    <span>•</span>
                    <span><i class="bi bi-eye"></i> {{ number_format($blog->views) }} views</span>
                </div>
                
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">{{ $blog->title }}</h1>
                
                @if($blog->excerpt)
                <p class="text-xl text-gray-600 mb-8 leading-relaxed">{{ $blog->excerpt }}</p>
                @endif
                
                <div class="prose max-w-none text-gray-700 leading-relaxed whitespace-pre-line">
                    {!! nl2br(e($blog->content)) !!}
                </div>
            </div>
        </article>

        <!-- Related Blogs -->
        @if($relatedBlogs->count() > 0)
        <div class="mt-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-8">Related Posts</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($relatedBlogs as $related)
                <article class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-shadow">
                    @if($related->featured_image)
                    <a href="{{ route('blogs.show', $related->slug) }}">
                        <img src="{{ asset('storage/' . $related->featured_image) }}" 
                             alt="{{ $related->title }}"
                             class="w-full h-48 object-cover">
                    </a>
                    @endif
                    
                    <div class="p-4">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">
                            <a href="{{ route('blogs.show', $related->slug) }}" class="hover:text-primary-600 transition-colors">
                                {{ $related->title }}
                            </a>
                        </h3>
                        <p class="text-sm text-gray-500">{{ $related->created_at->format('M d, Y') }}</p>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Back to Blog -->
        <div class="mt-12 text-center">
            <a href="{{ route('blogs.index') }}" class="btn btn-outline">
                <i class="bi bi-arrow-left"></i>
                Back to Blog
            </a>
        </div>
    </div>
</section>
@endsection

