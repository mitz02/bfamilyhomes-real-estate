<?php

namespace App\Http\Controllers;

use App\Models\Inspection;
use App\Models\Property;
use App\Models\Notification;
use App\Models\User;
use App\Support\AdminNotifier;
use Illuminate\Http\Request;

class InspectionController extends Controller
{
    public function index()
    {
        $inspections = Inspection::where('user_id', auth()->id())
            ->with('property')
            ->latest()
            ->paginate(10);

        return view('dashboard.inspections.index', compact('inspections'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'property_id' => 'required|exists:properties,id',
                'preferred_date' => 'required|date|after:today',
                'preferred_time' => 'required',
                'message' => 'nullable|string',
            ]);

            $inspection = Inspection::create([
                'user_id' => auth()->id(),
                'property_id' => $validated['property_id'],
                'preferred_date' => $validated['preferred_date'],
                'preferred_time' => $validated['preferred_time'],
                'message' => $validated['message'],
            ]);

            $property = Property::with('agent')->find($validated['property_id']);
            $user = auth()->user();

            // Notify the property agent
            if ($property && $property->agent && $property->agent_id !== $user->id) {
                Notification::createNotification(
                    $property->agent->id,
                    'inspection_booked',
                    'New Inspection Booking',
                    $user->name . " booked an inspection for your property: " . ($property->title ?? 'N/A'),
                    $inspection,
                    'bi-calendar-check',
                    'info'
                );
            }

            // Notify admin
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                Notification::createNotification(
                    $admin->id,
                    'inspection_booked',
                    'New Inspection Booking',
                    $user->name . " booked an inspection for: " . ($property->title ?? 'N/A') . " on " . $validated['preferred_date'] . " at " . $validated['preferred_time'],
                    $inspection,
                    'bi-calendar-check',
                    'info'
                );
            }

            AdminNotifier::notify(
                'inspection_booked',
                'New Inspection Booked',
                '<strong>' . $user->name . '</strong> booked an inspection for <strong>' . ($property->title ?? 'a property') . '</strong>.',
                [
                    'Customer' => $user->name,
                    'Email' => $user->email,
                    'Phone' => $user->phone,
                    'Property' => $property->title ?? 'N/A',
                    'Preferred Date' => \Carbon\Carbon::parse($validated['preferred_date'])->format('D, M d, Y'),
                    'Preferred Time' => $validated['preferred_time'],
                    'Booked At' => now()->format('M d, Y h:i A'),
                ],
                route('admin.bookings'),
                'View Booking'
            );

            return response()->json([
                'success' => true,
                'message' => 'Inspection booked successfully! We will confirm shortly.',
                'inspection' => $inspection,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to book inspection',
            ], 500);
        }
    }

    public function show($id)
    {
        $inspection = Inspection::where('user_id', auth()->id())
            ->with(['property', 'assignedAgent'])
            ->findOrFail($id);

        return view('dashboard.inspections.show', compact('inspection'));
    }
}
