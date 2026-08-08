<?php

namespace App\Http\Controllers;

use App\Models\Inspection;
use App\Models\Property;
use Illuminate\Http\Request;

class BookingController extends Controller
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
}

