<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Property;
use App\Models\Setting;

class SitemapController extends Controller
{
    public function index()
    {
        $urls = [];

        $urls[] = ['loc' => url('/'), 'priority' => '1.0', 'changefreq' => 'daily'];
        $urls[] = ['loc' => route('about'), 'priority' => '0.9', 'changefreq' => 'weekly'];
        $urls[] = ['loc' => route('contact'), 'priority' => '0.8', 'changefreq' => 'monthly'];
        $urls[] = ['loc' => route('privacy'), 'priority' => '0.3', 'changefreq' => 'yearly'];
        $urls[] = ['loc' => route('terms'), 'priority' => '0.3', 'changefreq' => 'yearly'];
        $urls[] = ['loc' => route('refund'), 'priority' => '0.3', 'changefreq' => 'yearly'];
        $urls[] = ['loc' => route('properties.index'), 'priority' => '0.9', 'changefreq' => 'daily'];
        $urls[] = ['loc' => route('blogs.index'), 'priority' => '0.8', 'changefreq' => 'weekly'];

        $urls[] = ['loc' => route('properties.index', ['type' => 'Rent']), 'priority' => '0.8', 'changefreq' => 'daily'];
        $urls[] = ['loc' => route('properties.index', ['type' => 'Sale']), 'priority' => '0.8', 'changefreq' => 'daily'];
        $urls[] = ['loc' => route('properties.index', ['type' => 'Investment']), 'priority' => '0.8', 'changefreq' => 'daily'];

        $properties = Property::where('approval_status', 'approved')->get();
        foreach ($properties as $property) {
            $urls[] = ['loc' => route('properties.show', $property->id), 'priority' => '0.9', 'changefreq' => 'weekly'];
        }

        $blogs = Blog::published()->get();
        foreach ($blogs as $blog) {
            $urls[] = ['loc' => route('blogs.show', $blog->slug), 'priority' => '0.7', 'changefreq' => 'monthly'];
        }

        return response()->view('sitemap', ['urls' => $urls])->header('Content-Type', 'application/xml');
    }
}
