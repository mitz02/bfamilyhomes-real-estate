<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Inquiry;
use App\Models\Notification;
use App\Support\AdminNotifier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $query = Property::approved()->available()->with('agent');

        // Filter by type (can be array from checkboxes)
        if ($request->filled('type')) {
            $types = is_array($request->type) ? $request->type : [$request->type];
            $query->whereIn('type', $types);
        }

        // Filter by category (can be array from checkboxes)
        if ($request->filled('categories')) {
            $categories = is_array($request->categories) ? $request->categories : [$request->categories];
            $query->whereIn('category', $categories);
        } elseif ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by location
        if ($request->filled('location')) {
            $query->where('location', 'like', "%{$request->location}%");
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Filter by bedrooms
        if ($request->filled('bedrooms')) {
            $bedrooms = $request->bedrooms;
            if (str_contains($bedrooms, '+')) {
                $bedrooms = (int) str_replace('+', '', $bedrooms);
                $query->where('bedrooms', '>=', $bedrooms);
            } else {
                $query->where('bedrooms', $bedrooms);
            }
        }

        // Filter by posted_by (agent/owner/builder)
        if ($request->filled('posted_by')) {
            $postedBy = is_array($request->posted_by) ? $request->posted_by : [$request->posted_by];
            if (in_array('agent', $postedBy)) {
                $query->whereHas('agent', function($q) {
                    $q->where('role', 'agent');
                });
            }
            // Note: Owner and Builder filtering would need additional logic
        }

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Sort
        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'latest':
            default:
                $query->orderBy('created_at', 'desc')->orderBy('id', 'desc');
                break;
        }

        $properties = $query->paginate(12);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'properties' => $properties,
            ]);
        }

        return view('properties.index', compact('properties'));
    }

    public function show($id)
    {
        // Admin can view all properties (approved or not)
        // Non-admin users can only view approved properties
        $query = Property::with(['agent', 'inspections']);
        
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            // Non-admin users can only see approved properties
            $query->approved();
        }
        
        $property = $query->findOrFail($id);
        
        // Check if non-admin is trying to access unapproved property
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            if ($property->approval_status !== 'approved') {
                abort(404, 'Property not found');
            }
        }

        // Only increment views for approved properties (unless admin)
        if ($property->approval_status === 'approved' || (auth()->check() && auth()->user()->isAdmin())) {
            $property->incrementViews();
        }

        // Similar properties - only show approved ones to non-admins
        $similarQuery = Property::approved()
            ->available()
            ->where('id', '!=', $id)
            ->where(function ($query) use ($property) {
                $query->where('category', $property->category)
                      ->orWhere('location', $property->location);
            });
        
        $similarProperties = $similarQuery->paginate(4);

        return view('properties.show', compact('property', 'similarProperties'));
    }

    public function storeInquiry(Request $request, $id)
    {
        try {
            $property = Property::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20',
                'message' => 'nullable|string',
            ]);

            $inquiry = Inquiry::create([
                'user_id' => auth()->id(),
                'property_id' => $property->id,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'subject' => 'Property Enquiry: ' . $property->title,
                'message' => $validated['message'] ?? '',
                'status' => 'new',
            ]);

            if ($property->agent) {
                Notification::createNotification(
                    $property->agent->id,
                    'new_inquiry',
                    'New Property Inquiry',
                    "{$validated['name']} enquired about your property: " . Str::limit($property->title, 40),
                    $inquiry,
                    'bi-chat-dots',
                    'info'
                );
            }

            $admins = \App\Models\User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                Notification::createNotification(
                    $admin->id,
                    'new_inquiry',
                    'New Property Inquiry',
                    "{$validated['name']} enquired about: " . Str::limit($property->title, 40),
                    $inquiry,
                    'bi-chat-dots',
                    'info'
                );
            }

            AdminNotifier::notify(
                'new_inquiry',
                'New Property Inquiry',
                '<strong>' . $validated['name'] . '</strong> sent an inquiry about <strong>' . ($property->title ?? 'a property') . '</strong>.',
                [
                    'Name' => $validated['name'],
                    'Email' => $validated['email'],
                    'Phone' => $validated['phone'],
                    'Property' => $property->title ?? 'N/A',
                    'Message' => Str::limit($validated['message'] ?: 'No message provided.', 200),
                    'Sent At' => now()->format('M d, Y h:i A'),
                ],
                route('admin.inquiries'),
                'View Inquiry'
            );

            return response()->json([
                'success' => true,
                'message' => 'Enquiry sent! The agent will contact you shortly.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send enquiry. Please try again.',
            ], 500);
        }
    }

    public function autocomplete(Request $request)
    {
        $query = $request->get('q', '');
        $type = $request->get('type', 'all'); // 'location', 'keyword', or 'all'

        if (strlen($query) < 2) {
            return response()->json(['suggestions' => []]);
        }

        $suggestions = collect();

        // Location autocomplete
        if ($type === 'all' || $type === 'location') {
            $locations = Property::approved()
                ->where('location', 'like', "%{$query}%")
                ->distinct()
                ->pluck('location')
                ->take(5)
                ->map(fn($location) => [
                    'label' => $location,
                    'value' => $location,
                    'type' => 'location',
                ]);
            $suggestions = $suggestions->merge($locations);
        }

        // Keyword/Property title autocomplete
        if ($type === 'all' || $type === 'keyword') {
            $properties = Property::approved()
                ->where(function($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                      ->orWhere('description', 'like', "%{$query}%");
                })
                ->take(5)
                ->get()
                ->map(fn($property) => [
                    'label' => $property->title . ' - ' . $property->location,
                    'value' => $property->title,
                    'type' => 'property',
                ]);
            $suggestions = $suggestions->merge($properties);
        }

        return response()->json(['suggestions' => $suggestions->take(10)]);
    }
}
