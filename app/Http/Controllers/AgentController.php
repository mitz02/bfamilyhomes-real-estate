<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Inquiry;
use App\Models\Inspection;
use App\Models\Payment;
use App\Models\Notification;
use App\Models\User;
use App\Support\AdminNotifier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AgentController extends Controller
{
    public function dashboard()
    {
        $agent = auth()->user();
        
        $stats = [
            'total_properties' => Property::where('agent_id', $agent->id)->count(),
            'approved_properties' => Property::where('agent_id', $agent->id)->approved()->count(),
            'pending_properties' => Property::where('agent_id', $agent->id)->where('approval_status', 'pending')->count(),
            'total_inspections' => Inspection::whereHas('property', function($q) use ($agent) {
                $q->where('agent_id', $agent->id);
            })->count(),
        ];

        $recentProperties = Property::where('agent_id', $agent->id)
            ->latest()
            ->take(5)
            ->get();

        // Notifications
        $unreadNotifications = $agent->unreadNotifications()->count();
        $recentNotifications = $agent->notifications()->unread()->recent(5)->get();

        $recentInspections = Inspection::whereHas('property', function($q) use ($agent) {
            $q->where('agent_id', $agent->id);
        })->with(['user', 'property'])->latest()->take(5)->get();

        $recentPayments = Payment::whereHas('property', function($q) use ($agent) {
            $q->where('agent_id', $agent->id);
        })->with(['property', 'receipt'])->latest()->take(5)->get();

        return view('agent.dashboard', compact('stats', 'recentProperties', 'recentInspections', 'recentPayments', 'unreadNotifications', 'recentNotifications'));
    }

    public function index()
    {
        $properties = Property::where('agent_id', auth()->id())
            ->latest()
            ->paginate(12);

        return view('agent.properties.index', compact('properties'));
    }

    public function create()
    {
        return view('agent.properties.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'type' => 'required|in:Rent,Sale',
                'category' => 'required|string',
                'price' => 'required|numeric|min:0',
                'location' => 'required|string',
                'address' => 'required|string',
                'bedrooms' => 'nullable|integer|min:0',
                'bathrooms' => 'nullable|integer|min:0',
                'parking' => 'nullable|integer|min:0',
                'size' => 'nullable|numeric|min:0',
                'features' => 'nullable|array',
                'images' => 'required|array|min:1',
                'images.*' => 'image|max:5120',
            ]);

            // Prevent agents from creating investment properties
            if ($validated['type'] === 'Investment') {
                return response()->json([
                    'success' => false,
                    'message' => 'Agents cannot create investment properties. Only administrators can create investment properties.',
                ], 403);
            }

            $images = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $images[] = $image->store('properties', 'public');
                }
            }

            $property = Property::create([
                'agent_id' => auth()->id(),
                'title' => $validated['title'],
                'description' => $validated['description'],
                'type' => $validated['type'],
                'category' => $validated['category'],
                'price' => $validated['price'],
                'location' => $validated['location'],
                'address' => $validated['address'],
                'bedrooms' => $validated['bedrooms'] ?? null,
                'bathrooms' => $validated['bathrooms'] ?? null,
                'parking' => $validated['parking'] ?? null,
                'size' => $validated['size'] ?? null,
                'features' => $validated['features'] ?? [],
                'images' => $images,
                'approval_status' => 'pending',
            ]);

            // Notify admin of new property submission
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                Notification::createNotification(
                    $admin->id,
                    'property_submitted',
                    'New Property Submitted',
                    auth()->user()->name . " submitted a new property for approval: " . $validated['title'],
                    $property,
                    'bi-house-add',
                    'warning'
                );
            }

            AdminNotifier::notify(
                'property_submitted',
                'New Property Submitted for Approval',
                '<strong>' . auth()->user()->name . '</strong> submitted a new <strong>' . $validated['type'] . '</strong> property: <strong>' . $validated['title'] . '</strong>. It is awaiting your approval.',
                [
                    'Agent' => auth()->user()->name,
                    'Email' => auth()->user()->email,
                    'Property' => $validated['title'],
                    'Type' => $validated['type'],
                    'Category' => $validated['category'],
                    'Price' => '₦' . number_format($validated['price'], 2),
                    'Location' => $validated['location'],
                ],
                route('admin.properties'),
                'Review Property'
            );

            return response()->json([
                'success' => true,
                'message' => 'Property submitted successfully! Awaiting admin approval.',
                'redirect' => route('agent.properties.index'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create property',
            ], 500);
        }
    }

    public function edit($id)
    {
        $property = Property::where('agent_id', auth()->id())->findOrFail($id);
        return view('agent.properties.edit', compact('property'));
    }

    public function update(Request $request, $id)
    {
        try {
            $property = Property::where('agent_id', auth()->id())->findOrFail($id);

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'type' => 'required|in:Rent,Sale',
                'category' => 'required|string',
                'price' => 'required|numeric|min:0',
                'location' => 'required|string',
                'address' => 'required|string',
                'bedrooms' => 'nullable|integer|min:0',
                'bathrooms' => 'nullable|integer|min:0',
                'parking' => 'nullable|integer|min:0',
                'size' => 'nullable|numeric|min:0',
                'features' => 'nullable|array',
                'images' => 'nullable|array',
                'images.*' => 'image|max:5120',
            ]);

            // Prevent agents from creating investment properties
            if ($validated['type'] === 'Investment') {
                return response()->json([
                    'success' => false,
                    'message' => 'Agents cannot create investment properties. Only administrators can create investment properties.',
                ], 403);
            }

            $images = $property->images ?? [];
            
            // Remove deleted images
            if ($request->has('removed_images')) {
                $removedIndices = $request->removed_images;
                $images = array_filter($images, function($index) use ($removedIndices) {
                    return !in_array($index, $removedIndices);
                }, ARRAY_FILTER_USE_KEY);
                $images = array_values($images); // Re-index array
            }
            
            // Add new images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $images[] = $image->store('properties', 'public');
                }
            }

            $property->update([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'type' => $validated['type'],
                'category' => $validated['category'],
                'price' => $validated['price'],
                'location' => $validated['location'],
                'address' => $validated['address'],
                'bedrooms' => $validated['bedrooms'] ?? null,
                'bathrooms' => $validated['bathrooms'] ?? null,
                'parking' => $validated['parking'] ?? null,
                'size' => $validated['size'] ?? null,
                'features' => $validated['features'] ?? [],
                'images' => $images,
                'approval_status' => 'pending',
            ]);

            // Notify admin that the property needs re-approval
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                Notification::createNotification(
                    $admin->id,
                    'property_submitted',
                    'Property Resubmitted',
                    auth()->user()->name . " updated a property. It now requires re-approval: " . $property->title,
                    $property,
                    'bi-house-check',
                    'warning'
                );
            }

            AdminNotifier::notify(
                'property_submitted',
                'Property Updated - Re-approval Needed',
                '<strong>' . auth()->user()->name . '</strong> updated property <strong>' . $property->title . '</strong>. It has been reset to pending and now requires re-approval.',
                [
                    'Agent' => auth()->user()->name,
                    'Property' => $property->title,
                    'Type' => $property->type,
                    'Price' => $property->formatted_price,
                    'Location' => $property->location,
                ],
                route('admin.properties'),
                'Review Property'
            );

            return response()->json([
                'success' => true,
                'message' => 'Property updated successfully!',
                'redirect' => route('agent.properties.index'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update property',
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $property = Property::where('agent_id', auth()->id())->findOrFail($id);
            $property->delete();

            return response()->json([
                'success' => true,
                'message' => 'Property deleted successfully!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete property',
            ], 500);
        }
    }

    public function bookings()
    {
        $inspections = Inspection::whereHas('property', function($q) {
            $q->where('agent_id', auth()->id());
        })->with(['user', 'property'])->latest()->paginate(15);

        return view('agent.bookings', compact('inspections'));
    }

    public function inquiries()
    {
        $inquiries = Inquiry::whereHas('property', function($q) {
            $q->where('agent_id', auth()->id());
        })->with('property')->latest()->paginate(15);

        return view('agent.inquiries', compact('inquiries'));
    }

    public function transactions()
    {
        $payments = Payment::whereHas('property', function($q) {
            $q->where('agent_id', auth()->id());
        })->with(['user', 'property', 'receipt'])->latest()->paginate(20);

        return view('agent.transactions.index', compact('payments'));
    }
}
