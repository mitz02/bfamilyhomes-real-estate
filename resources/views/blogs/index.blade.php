@extends('layouts.app')

@section('title', 'Real Estate Blog | Property Tips & Insights in Anambra, Nigeria | B-Family Homes')
@section('description', 'Expert real estate tips, market insights, and property guides for Anambra State, Enugu, Delta, Imo, Ebonyi, Abia, and all Nigeria. Learn about buying, selling, renting, and investing in properties in South East Nigeria.')
@section('og:title', 'Real Estate Blog & Property Insights | B-Family Homes Nigeria')
@section('og:description', 'Stay informed with expert real estate tips, market analysis, and property guides covering Anambra, Enugu, Delta, Imo, Ebonyi, Abia, and all Nigeria.')

@section('content')
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4" style="max-width: 1400px;">
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Our Blog</h1>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Stay updated with the latest news, tips, and insights about real estate
            </p>
        </div>

        @if($blogs->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($blogs as $blog)
            <article class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-shadow">
                @if($blog->featured_image)
                <a href="{{ route('blogs.show', $blog->slug) }}">
                    <img src="{{ asset('storage/' . $blog->featured_image) }}" 
                         alt="{{ $blog->title }} - B-Family Homes Real Estate Blog"
                         loading="lazy"
                         class="w-full h-64 object-cover">
                </a>
                @else
                <div class="w-full h-64 bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center">
                    <i class="bi bi-journal-text text-white text-6xl"></i>
                </div>
                @endif
                
                <div class="p-6">
                    <div class="flex items-center gap-3 text-sm text-gray-500 mb-3">
                        <span>{{ $blog->created_at->format('M d, Y') }}</span>
                        <span>•</span>
                        <span>{{ $blog->author->name }}</span>
                        <span>•</span>
                        <span><i class="bi bi-eye"></i> {{ number_format($blog->views) }}</span>
                    </div>
                    
                    <h2 class="text-2xl font-bold text-gray-900 mb-3">
                        <a href="{{ route('blogs.show', $blog->slug) }}" class="hover:text-primary-600 transition-colors">
                            {{ $blog->title }}
                        </a>
                    </h2>
                    
                    @if($blog->excerpt)
                    <p class="text-gray-600 mb-4 line-clamp-3">{{ $blog->excerpt }}</p>
                    @else
                    <p class="text-gray-600 mb-4 line-clamp-3">{{ Str::limit(strip_tags($blog->content), 150) }}</p>
                    @endif
                    
                    <a href="{{ route('blogs.show', $blog->slug) }}" class="text-primary-600 font-semibold hover:text-primary-700 inline-flex items-center gap-2">
                        Read More
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </article>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            {{ $blogs->links() }}
        </div>
        @else
        <div class="text-center py-12">
            <i class="bi bi-journal-text text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">No blog posts yet</h3>
            <p class="text-gray-600">Check back soon for updates!</p>
        </div>
        @endif
    </div>
</section>
@endsection

