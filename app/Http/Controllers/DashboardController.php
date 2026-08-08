<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Inspection;
use App\Models\Payment;
use App\Models\User;
use App\Models\Notification;
use App\Support\AdminNotifier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Redirect admins to admin dashboard
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        
        // Redirect agents to agent dashboard
        if ($user->isAgent()) {
            return redirect()->route('agent.dashboard');
        }
        
        // Redirect investors to investor dashboard
        if ($user->isInvestor()) {
            return redirect()->route('investor.dashboard');
        }
        
        $stats = [
            'inspections' => Inspection::where('user_id', $user->id)->count(),
            'properties' => Property::approved()->available()->count(),
            'payments' => Payment::where('user_id', $user->id)->count(),
            'pending_payments' => Payment::where('user_id', $user->id)->pending()->count(),
        ];

        $recentInspections = Inspection::where('user_id', $user->id)
            ->with('property')
            ->latest()
            ->take(5)
            ->get();

        $recentPayments = Payment::where('user_id', $user->id)
            ->with(['property', 'receipt'])
            ->latest()
            ->take(5)
            ->get();

        // Notifications
        $unreadNotifications = $user->unreadNotifications()->count();
        $recentNotifications = $user->notifications()->unread()->recent(5)->get();

        return view('dashboard.index', compact('stats', 'recentInspections', 'recentPayments', 'unreadNotifications', 'recentNotifications'));
    }

    public function profile()
    {
        $user = auth()->user();
        
        // Determine which layout to use based on user role and route
        if ($user->isAdmin() && request()->routeIs('admin.profile')) {
            return view('admin.profile');
        } elseif ($user->isAgent() && request()->routeIs('agent.profile')) {
            return view('agent.profile');
        } elseif ($user->isInvestor() && request()->routeIs('investor.profile')) {
            return view('investor.profile');
        }
        
        // Default to regular dashboard profile
        return view('dashboard.profile');
    }

    public function updateProfile(Request $request)
    {
        try {
            $user = auth()->user();
            
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:20|unique:users,phone,' . $user->id,
                'address' => 'nullable|string',
                'avatar' => 'nullable|image|max:2048',
            ]);

            // Allow admin to edit email
            if ($user->isAdmin() && $request->has('email')) {
                $validated['email'] = $request->validate([
                    'email' => 'required|email|unique:users,email,' . $user->id,
                ])['email'];
            }

            if ($request->hasFile('avatar')) {
                // Delete old avatar
                if ($user->avatar) {
                    Storage::disk('public')->delete($user->avatar);
                }
                $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
            }

            $user->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully!',
                'user' => $user->fresh(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update profile: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function changePassword(Request $request)
    {
        try {
            $user = auth()->user();
            
            $validated = $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|string|min:8|confirmed',
            ]);

            if (!Hash::check($validated['current_password'], $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Current password is incorrect',
                ], 422);
            }

            $user->update([
                'password' => Hash::make($validated['new_password']),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Password changed successfully!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to change password',
            ], 500);
        }
    }

    public function requestAgentStatus(Request $request)
    {
        try {
            $user = auth()->user();

            if ($user->isAgent() && $user->agent_approved_at) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are already an approved agent',
                ], 400);
            }

            if ($user->role === 'agent' && $user->status === 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Your agent request is pending approval',
                ], 400);
            }

            // If user registered as agent but not approved yet
            if ($user->role === 'agent' && !$user->agent_approved_at) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your agent request is pending approval',
                ], 400);
            }

            // Record the agent upgrade request. Do NOT change role/status here —
            // the user must be able to log in while their request is pending.
            // Admin approval (approveAgent) sets role=agent, status=active.
            $user->update([
                'agent_requested_at' => now(),
            ]);

            // Notify admin
            $admin = User::where('role', 'admin')->first();
            if ($admin) {
                Notification::createNotification(
                    $admin->id,
                    'upgrade_request',
                    'Agent Upgrade Request',
                    "{$user->name} ({$user->email}) has requested to upgrade to agent status.",
                    $user,
                    'bi-person-badge',
                    'warning'
                );
            }

            AdminNotifier::notify(
                'upgrade_request',
                'Agent Upgrade Request',
                "<strong>{$user->name}</strong> ({$user->email}) has requested to upgrade to agent status and is awaiting your approval.",
                [
                    'Name' => $user->name,
                    'Email' => $user->email,
                    'Phone' => $user->phone,
                    'Requested At' => now()->format('M d, Y h:i A'),
                ],
                route('admin.users'),
                'Review Request'
            );

            return response()->json([
                'success' => true,
                'message' => 'Agent status request submitted! Admin will review shortly.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit request',
            ], 500);
        }
    }

    public function requestInvestorUpgrade(Request $request)
    {
        try {
            $user = auth()->user();

            if ($user->isInvestor()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are already an investor',
                ], 400);
            }

            if ($user->investor_requested_at) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your upgrade request is pending approval',
                ], 400);
            }

            $user->update(['investor_requested_at' => now()]);

            // Notify admin
            $admin = User::where('role', 'admin')->first();
            if ($admin) {
                Notification::createNotification(
                    $admin->id,
                    'upgrade_request',
                    'Investor Upgrade Request',
                    "{$user->name} ({$user->email}) has requested to upgrade to investor status.",
                    $user,
                    'bi-graph-up-arrow',
                    'warning'
                );
            }

            AdminNotifier::notify(
                'upgrade_request',
                'Investor Upgrade Request',
                "<strong>{$user->name}</strong> ({$user->email}) has requested to upgrade to investor status and is awaiting your approval.",
                [
                    'Name' => $user->name,
                    'Email' => $user->email,
                    'Phone' => $user->phone,
                    'Requested At' => now()->format('M d, Y h:i A'),
                ],
                route('admin.users'),
                'Review Request'
            );

            return response()->json([
                'success' => true,
                'message' => 'Investor upgrade request submitted! Admin will review shortly.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit request',
            ], 500);
        }
    }
}
