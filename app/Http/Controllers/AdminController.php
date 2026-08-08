<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Property;
use App\Models\Inspection;
use App\Models\Payment;
use App\Models\Investment;
use App\Models\Setting;
use App\Models\Notification;
use App\Models\Inquiry;
use App\Models\Promotion;
use App\Models\Purchase;
use App\Models\ActivityLog;
use App\Models\Receipt;
use App\Mail\AccountApprovedMail;
use App\Services\ReceiptService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Main Stats
        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'total_agents' => User::agents()->where('status', 'active')->whereNotNull('agent_approved_at')->count(),
            'total_investors' => User::investors()->where('status', 'active')->whereNotNull('investor_approved_at')->count(),
            'total_properties' => Property::count(),
            'approved_properties' => Property::where('approval_status', 'approved')->count(),
            'pending_properties' => Property::where('approval_status', 'pending')->count(),
            'rejected_properties' => Property::where('approval_status', 'rejected')->count(),
            'total_inspections' => Inspection::count(),
            'pending_inspections' => Inspection::where('status', 'pending')->count(),
            'confirmed_inspections' => Inspection::where('status', 'confirmed')->count(),
            'total_payments' => Payment::count(),
            'pending_payments' => Payment::where('status', 'pending')->count(),
            'approved_payments' => Payment::where('status', 'approved')->count(),
            'total_investments' => Investment::count(),
            'active_investments' => Investment::where('status', 'active')->count(),
            'total_revenue' => Payment::where('status', 'approved')->sum('amount'),
            'pending_revenue' => Payment::where('status', 'pending')->sum('amount'),
        ];

        // Analytics - Last 30 days
        $last30Days = now()->subDays(30);
        $analytics = [
            'new_users' => User::where('created_at', '>=', $last30Days)->count(),
            'new_properties' => Property::where('created_at', '>=', $last30Days)->count(),
            'new_inspections' => Inspection::where('created_at', '>=', $last30Days)->count(),
            'new_payments' => Payment::where('created_at', '>=', $last30Days)->count(),
            'new_investments' => Investment::where('created_at', '>=', $last30Days)->count(),
        ];

        // Monthly growth data for charts
        $monthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthlyData[] = [
                'month' => $date->format('M Y'),
                'users' => User::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
                'properties' => Property::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
                'payments' => Payment::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->where('status', 'approved')
                    ->sum('amount'),
            ];
        }

        // Financial overview (all time)
        $totalSales = Payment::where('status', 'approved')
            ->whereIn('type', ['purchase', 'rent'])
            ->sum('amount');
        $totalPurchases = \App\Models\Purchase::sum('amount');
        $totalExpenses = \App\Models\Expense::sum('amount');

        $finance = [
            'total_sales' => $totalSales,
            'total_purchases' => $totalPurchases,
            'total_expenses' => $totalExpenses,
            'net_profit' => $totalSales - $totalPurchases - $totalExpenses,
        ];

        // Last 6 months finance for charts
        $financeMonthly = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthStart = $date->copy()->startOfMonth();
            $monthEnd = $date->copy()->endOfMonth();
            $sales = Payment::where('status', 'approved')
                ->whereIn('type', ['purchase', 'rent'])
                ->whereBetween('sale_date', [$monthStart, $monthEnd])
                ->sum('amount');
            $purchases = \App\Models\Purchase::whereBetween('purchase_date', [$monthStart->toDateString(), $monthEnd->toDateString()])
                ->sum('amount');
            $expenses = \App\Models\Expense::whereBetween('expense_date', [$monthStart->toDateString(), $monthEnd->toDateString()])
                ->sum('amount');
            $financeMonthly[] = [
                'month' => $date->format('M Y'),
                'sales' => (float) $sales,
                'purchases' => (float) $purchases,
                'expenses' => (float) $expenses,
                'profit' => (float) ($sales - $purchases - $expenses),
            ];
        }

        // Expense breakdown (all time, top 6)
        $expenseBreakdown = \App\Models\Expense::selectRaw('category, SUM(amount) as total')
            ->groupBy('category')
            ->orderByDesc('total')
            ->take(6)
            ->get();

        // Pending Approvals
        $pendingApprovals = [
            'properties' => Property::where('approval_status', 'pending')->count(),
            'investor_requests' => User::whereNotNull('investor_requested_at')
                ->whereNull('investor_approved_at')
                ->count(),
            'agent_requests' => User::whereNotNull('agent_requested_at')
                ->whereNull('agent_approved_at')
                ->where('role', 'agent')
                ->count(),
            'payments' => Payment::where('status', 'pending')->count(),
        ];

        // Recent Activity
        $recentProperties = Property::with('agent')->latest()->take(5)->get();
        $recentUsers = User::latest()->take(5)->get();
        $recentPayments = Payment::with(['user', 'property'])->latest()->take(5)->get();

        // Top Agents
        $topAgents = User::agents()
            ->where('status', 'active')
            ->whereNotNull('agent_approved_at')
            ->withCount('properties')
            ->orderBy('properties_count', 'desc')
            ->take(5)
            ->get();

        // Notifications
        $unreadNotifications = auth()->user()->unreadNotifications()->count();
        $recentNotifications = auth()->user()->notifications()->unread()->recent(5)->get();

        return view('admin.dashboard', compact(
            'stats', 
            'analytics', 
            'monthlyData',
            'finance',
            'financeMonthly',
            'expenseBreakdown',
            'pendingApprovals', 
            'recentProperties', 
            'recentUsers',
            'recentPayments',
            'topAgents',
            'unreadNotifications',
            'recentNotifications'
        ));
    }

    // User Management
    public function users(Request $request)
    {
        $query = User::withCount(['properties', 'inspections', 'payments']);

        // Filter by role
        if ($request->filled('role')) {
            if ($request->role === 'agent') {
                $query->where('role', 'agent');
            } elseif ($request->role === 'investor') {
                $query->where('role', 'investor');
            } elseif ($request->role === 'user') {
                $query->where('role', 'user');
            }
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter pending approvals
        if ($request->filled('pending')) {
            if ($request->pending === 'investor') {
                $query->whereNotNull('investor_requested_at')
                    ->whereNull('investor_approved_at');
            } elseif ($request->pending === 'agent') {
                $query->whereNotNull('agent_requested_at')
                    ->whereNull('agent_approved_at')
                    ->where('role', 'agent');
            }
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(20)->withQueryString();

        // Stats for filter tabs
        $userStats = [
            'all' => User::count(),
            'users' => User::where('role', 'user')->count(),
            'agents' => User::where('role', 'agent')->count(),
            'investors' => User::where('role', 'investor')->count(),
            'pending_agents' => User::whereNotNull('agent_requested_at')
                ->whereNull('agent_approved_at')
                ->where('role', 'agent')
                ->count(),
            'pending_investors' => User::whereNotNull('investor_requested_at')
                ->whereNull('investor_approved_at')
                ->count(),
        ];

        return view('admin.users.index', compact('users', 'userStats'));
    }

    public function toggleUserStatus(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $status = $user->status === 'active' ? 'blocked' : 'active';

        return $this->setUserStatus($id, $status);
    }

    public function activateUser(Request $request, $id)
    {
        return $this->setUserStatus($id, 'active');
    }

    public function deactivateUser(Request $request, $id)
    {
        return $this->setUserStatus($id, 'blocked');
    }

    protected function setUserStatus($id, $status)
    {
        try {
            $user = User::findOrFail($id);

            if ($user->isAdmin()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot modify admin account',
                ], 403);
            }

            $user->update(['status' => $status]);

            return response()->json([
                'success' => true,
                'message' => 'User status updated successfully',
                'status' => $status,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update user status',
            ], 500);
        }
    }

    public function deleteUser(Request $request, User $user)
    {
        try {
            if ($user->isAdmin()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete admin account',
                ], 403);
            }

            if ($user->id === auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot delete your own account',
                ], 403);
            }

            $userName = $user->name;
            $userEmail = $user->email;

            ActivityLog::log(
                auth()->id(),
                'user_deleted',
                "Deleted user {$userName} ({$userEmail})",
                null,
                ['user_id' => $user->id]
            );

            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete user: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function impersonateUser(Request $request, User $user)
    {
        try {
            if ($user->isAdmin()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot impersonate an admin account',
                ], 403);
            }

            if ($user->id === auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are already signed in as this user',
                ], 403);
            }

            $impersonator = auth()->user();

            session()->put('impersonator_id', $impersonator->id);
            session()->put('impersonator_name', $impersonator->name);
            session()->put('impersonating', true);

            auth()->login($user);

            $redirect = match ($user->role) {
                'agent' => route('agent.dashboard'),
                'investor' => route('investor.dashboard'),
                default => route('dashboard'),
            };

            return response()->json([
                'success' => true,
                'message' => 'Now impersonating ' . $user->name,
                'redirect' => $redirect,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to impersonate user: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function stopImpersonation(Request $request)
    {
        $impersonatorId = session('impersonator_id');

        session()->forget(['impersonator_id', 'impersonator_name', 'impersonating']);

        if (!$impersonatorId) {
            return redirect()->route('dashboard');
        }

        $impersonator = User::find($impersonatorId);

        if ($impersonator) {
            auth()->login($impersonator);
        }

        return redirect()->route('admin.users')
            ->with('success', 'Impersonation stopped. Welcome back, ' . ($impersonator->name ?? 'Admin') . '.');
    }

    public function approveInvestor(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            if ($user->isAdmin()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot modify admin account',
                ], 403);
            }

            if (!$user->investor_requested_at) {
                return response()->json([
                    'success' => false,
                    'message' => 'No investor request found',
                ], 400);
            }

            $user->update([
                'role' => 'investor',
                'investor_approved_at' => now(),
                'status' => 'active',
            ]);

            // Notify user via in-app notification
            Notification::createNotification(
                $user->id,
                'registration_approved',
                'Investor Account Approved',
                'Congratulations! Your investor account has been approved. You can now invest in properties.',
                $user,
                'bi-check-circle-fill',
                'success'
            );

            // Send approval email
            try {
                Mail::to($user->email)->send(new AccountApprovedMail($user, 'Investor'));
                Log::info('Investor approval email sent', ['email' => $user->email, 'user_id' => $user->id]);
            } catch (\Exception $e) {
                Log::error('Failed to send investor approval email: ' . $e->getMessage(), [
                    'email' => $user->email,
                    'user_id' => $user->id,
                ]);
                // Don't fail the approval if email fails
            }

            return response()->json([
                'success' => true,
                'message' => 'Investor upgrade approved successfully',
            ]);
        } catch (\Exception $e) {
            Log::error('Approve investor error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to approve investor',
            ], 500);
        }
    }

    public function approveAgent(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            if ($user->isAdmin()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot modify admin account',
                ], 403);
            }

            $user->update([
                'role' => 'agent',
                'agent_approved_at' => now(),
                'status' => 'active',
            ]);

            // Notify user via in-app notification
            Notification::createNotification(
                $user->id,
                'registration_approved',
                'Agent Account Approved',
                'Congratulations! Your agent account has been approved. You can now list properties.',
                $user,
                'bi-check-circle-fill',
                'success'
            );

            // Send approval email
            try {
                Mail::to($user->email)->send(new AccountApprovedMail($user, 'Agent'));
                Log::info('Agent approval email sent', ['email' => $user->email, 'user_id' => $user->id]);
            } catch (\Exception $e) {
                Log::error('Failed to send agent approval email: ' . $e->getMessage(), [
                    'email' => $user->email,
                    'user_id' => $user->id,
                ]);
                // Don't fail the approval if email fails
            }

            return response()->json([
                'success' => true,
                'message' => 'Agent approved successfully',
            ]);
        } catch (\Exception $e) {
            Log::error('Approve agent error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to approve agent',
            ], 500);
        }
    }

    // Property Management
    public function properties(Request $request)
    {
        $query = Property::with('agent');

        // Filter by approval status
        if ($request->filled('status')) {
            $query->where('approval_status', $request->status);
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by agent
        if ($request->filled('agent_id')) {
            $query->where('agent_id', $request->agent_id);
        }

        // Filter by featured
        if ($request->filled('featured')) {
            $query->where('is_featured', $request->featured === '1');
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        $properties = $query->latest()->paginate(20)->withQueryString();

        // Stats
        $propertyStats = [
            'all' => Property::count(),
            'approved' => Property::where('approval_status', 'approved')->count(),
            'pending' => Property::where('approval_status', 'pending')->count(),
            'rejected' => Property::where('approval_status', 'rejected')->count(),
            'featured' => Property::where('is_featured', true)->count(),
        ];

        // Get agents for filter
        $agents = User::agents()->where('status', 'active')->whereNotNull('agent_approved_at')->get();

        return view('admin.properties.index', compact('properties', 'propertyStats', 'agents'));
    }

    public function createProperty()
    {
        $agents = User::agents()->where('status', 'active')->whereNotNull('agent_approved_at')->get();
        return view('admin.properties.create', compact('agents'));
    }

    public function storeProperty(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'type' => 'required|in:Rent,Sale,Investment',
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
                'agent_id' => 'nullable|exists:users,id',
                'roi_percentage' => 'nullable|numeric|min:0|max:100',
                'investment_duration' => 'nullable|integer|min:1',
            ]);

            $images = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $images[] = $image->store('properties', 'public');
                }
            }

            $property = Property::create([
                'agent_id' => $validated['agent_id'] ?? auth()->id(),
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
                'approval_status' => 'approved',
                'is_featured' => $request->has('is_featured'),
            ]);

            // If it's an investment property, store ROI and duration
            if ($validated['type'] === 'Investment' && isset($validated['roi_percentage'])) {
                $property->update([
                    'roi_percentage' => $validated['roi_percentage'],
                    'investment_duration' => $validated['investment_duration'] ?? 12,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Property created successfully!',
                'redirect' => route('admin.properties'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create property: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function editProperty($id)
    {
        $property = Property::findOrFail($id);
        $agents = User::agents()->where('status', 'active')->whereNotNull('agent_approved_at')->get();
        return view('admin.properties.edit', compact('property', 'agents'));
    }

    public function updateProperty(Request $request, $id)
    {
        try {
            $property = Property::findOrFail($id);

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'type' => 'required|in:Rent,Sale,Investment',
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
                'agent_id' => 'nullable|exists:users,id',
                'roi_percentage' => 'nullable|numeric|min:0|max:100',
                'investment_duration' => 'nullable|integer|min:1',
            ]);

            $images = $property->images ?? [];
            
            if ($request->has('removed_images')) {
                $removedIndices = $request->removed_images;
                $images = array_filter($images, function($index) use ($removedIndices) {
                    return !in_array($index, $removedIndices);
                }, ARRAY_FILTER_USE_KEY);
                $images = array_values($images);
            }
            
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $images[] = $image->store('properties', 'public');
                }
            }

            $updateData = [
                'agent_id' => $validated['agent_id'] ?? $property->agent_id,
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
                'is_featured' => $request->has('is_featured'),
            ];

            if ($validated['type'] === 'Investment') {
                $updateData['roi_percentage'] = $validated['roi_percentage'] ?? $property->roi_percentage;
                $updateData['investment_duration'] = $validated['investment_duration'] ?? $property->investment_duration ?? 12;
            }

            $property->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'Property updated successfully!',
                'redirect' => route('admin.properties'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update property: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function approveProperty(Request $request, $id)
    {
        try {
            $property = Property::findOrFail($id);
            
            $property->update([
                'approval_status' => 'approved',
                'rejection_reason' => null,
            ]);

            // Notify agent
            Notification::createNotification(
                $property->agent_id,
                'property_approved',
                'Property Approved',
                "Your property '{$property->title}' has been approved and is now live!",
                $property,
                'bi-check-circle-fill',
                'success'
            );

            return response()->json([
                'success' => true,
                'message' => 'Property approved successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to approve property',
            ], 500);
        }
    }

    public function rejectProperty(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'rejection_reason' => 'required|string|max:500',
            ]);

            $property = Property::findOrFail($id);
            
            $property->update([
                'approval_status' => 'rejected',
                'rejection_reason' => $validated['rejection_reason'],
            ]);

            // Notify agent
            Notification::createNotification(
                $property->agent_id,
                'property_rejected',
                'Property Rejected',
                "Your property '{$property->title}' was rejected. Reason: {$validated['rejection_reason']}",
                $property,
                'bi-x-circle-fill',
                'danger'
            );

            return response()->json([
                'success' => true,
                'message' => 'Property rejected successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to reject property',
            ], 500);
        }
    }

    public function toggleFeatured(Request $request, $id)
    {
        try {
            $property = Property::findOrFail($id);
            $property->update(['is_featured' => !$property->is_featured]);

            return response()->json([
                'success' => true,
                'message' => 'Property featured status updated',
                'is_featured' => $property->is_featured,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update featured status',
            ], 500);
        }
    }

    public function updateTags(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'tags' => 'nullable|array',
                'tags.*' => 'string|in:featured,best_collection,new,trending,premium',
            ]);

            $property = Property::findOrFail($id);
            $property->update(['tags' => $validated['tags'] ?? []]);

            return response()->json([
                'success' => true,
                'message' => 'Property tags updated successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update tags',
            ], 500);
        }
    }

    public function deleteProperty($id)
    {
        try {
            $property = Property::findOrFail($id);
            $property->delete();

            return response()->json([
                'success' => true,
                'message' => 'Property deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete property',
            ], 500);
        }
    }

    public function markAsSold(Request $request, Property $property)
    {
        try {
            $validated = $request->validate([
                'sold_info' => 'nullable|string|max:255',
            ]);

            $property->update([
                'status' => 'Sold',
                'sold_info' => $validated['sold_info'] ?? null,
                'sold_at' => now(),
            ]);

            ActivityLog::log(
                auth()->id(),
                'property_marked_sold',
                "Property marked as sold: {$property->title}" . ($property->sold_info ? " ({$property->sold_info})" : ''),
                $property,
                ['sold_info' => $property->sold_info]
            );

            return response()->json([
                'success' => true,
                'message' => 'Property marked as sold successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark property as sold: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function markAsAvailable(Request $request, Property $property)
    {
        try {
            $property->update([
                'status' => 'Available',
                'sold_info' => null,
                'sold_at' => null,
            ]);

            ActivityLog::log(
                auth()->id(),
                'property_marked_available',
                "Property marked as available: {$property->title}",
                $property
            );

            return response()->json([
                'success' => true,
                'message' => 'Property is now available again',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update property status: ' . $e->getMessage(),
            ], 500);
        }
    }

    // Inspection Management
    public function bookings()
    {
        $inspections = Inspection::with(['user', 'property', 'assignedAgent'])
            ->latest()
            ->paginate(20);

        return view('admin.bookings.index', compact('inspections'));
    }

    public function assignInspection(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'assigned_to' => 'required|exists:users,id',
            ]);

            $inspection = Inspection::findOrFail($id);
            $inspection->update([
                'assigned_to' => $validated['assigned_to'],
                'status' => 'confirmed',
                'confirmed_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Inspection assigned successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to assign inspection',
            ], 500);
        }
    }

    public function updateInspectionStatus(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'status' => 'required|in:pending,confirmed,completed,cancelled',
            ]);

            $inspection = Inspection::findOrFail($id);
            $inspection->update([
                'status' => $validated['status'],
                'confirmed_at' => $validated['status'] === 'confirmed' ? now() : $inspection->confirmed_at,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Inspection status updated',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status',
            ], 500);
        }
    }

    // Payment Management
    public function payments()
    {
        $payments = Payment::with(['user', 'property'])
            ->latest()
            ->paginate(20);

        return view('admin.payments.index', compact('payments'));
    }

    public function approvePayment(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'admin_notes' => 'nullable|string|max:500',
            ]);

            $payment = Payment::findOrFail($id);
            $payment->update([
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => auth()->id(),
                'admin_notes' => $validated['admin_notes'] ?? null,
                'sale_date' => $payment->sale_date ?? now(),
            ]);

            // If this is an investment payment, activate the investment
            if ($payment->type === 'investment') {
                $investment = \App\Models\Investment::where('payment_id', $payment->id)->first();
                if ($investment && $investment->status === 'pending') {
                    $investment->update([
                        'status' => 'active',
                        'start_date' => now(),
                        'maturity_date' => now()->addMonths($investment->duration_months ?? 12),
                    ]);

                    Notification::createNotification(
                        $investment->investor_id,
                        'investment_activated',
                        'Investment Activated',
                        "Your investment of ₦" . number_format($investment->amount, 2) . " has been activated! ROI tracking has begun.",
                        $investment,
                        'bi-check-circle-fill',
                        'success'
                    );
                }

                // Generate receipt for the investment payment
                $receiptService = app(ReceiptService::class);
                $receiptService->generate($payment);
            } else {
                // Auto-update property status for purchase/rent
                $status = $payment->type === 'rent' ? 'Rented' : 'Sold';
                $payment->property->update(['status' => $status]);

                // Auto-generate receipt
                $receiptService = app(ReceiptService::class);
                $receiptService->generate($payment);
            }

            // Notify user
            Notification::createNotification(
                $payment->user_id,
                'payment_approved',
                'Payment Approved',
                "Your payment of ₦" . number_format($payment->amount, 2) . " has been approved!",
                $payment,
                'bi-check-circle-fill',
                'success'
            );

            // Log activity
            ActivityLog::log(
                auth()->id(),
                'payment_approved',
                "Payment {$payment->reference} of ₦" . number_format($payment->amount, 2) . " approved for {$payment->user->name}",
                $payment,
                ['amount' => $payment->amount]
            );

            return response()->json([
                'success' => true,
                'message' => 'Payment approved successfully. Receipt has been generated.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to approve payment',
            ], 500);
        }
    }

    public function rejectPayment(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'admin_notes' => 'required|string|max:500',
            ]);

            $payment = Payment::findOrFail($id);
            $payment->update([
                'status' => 'rejected',
                'admin_notes' => $validated['admin_notes'],
            ]);

            // Notify user
            Notification::createNotification(
                $payment->user_id,
                'payment_rejected',
                'Payment Rejected',
                "Your payment of ₦" . number_format($payment->amount, 2) . " was rejected. Reason: {$validated['admin_notes']}",
                $payment,
                'bi-x-circle-fill',
                'danger'
            );

            return response()->json([
                'success' => true,
                'message' => 'Payment rejected',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to reject payment',
            ], 500);
        }
    }

    public function destroyPayment(Payment $payment)
    {
        try {
            $propertyTitle = $payment->property?->title ?? 'Unknown Property';
            $buyerName = $payment->buyer_name;

            // Restore property to Available if it was marked by this payment
            if ($payment->property && in_array($payment->property->status, ['Sold', 'Rented'])) {
                $payment->property->update(['status' => 'Available']);
            }

            // Delete receipt record + PDF file
            if ($payment->receipt) {
                if ($payment->receipt->file_path) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($payment->receipt->file_path);
                }
                $payment->receipt->delete();
            }

            // Delete linked investment (if any) for investment payments
            if ($payment->type === 'investment') {
                \App\Models\Investment::where('payment_id', $payment->id)->get()->each->delete();
            }

            // Remove notifications referencing this payment
            \App\Models\Notification::where('notifiable_type', Payment::class)
                ->where('notifiable_id', $payment->id)
                ->delete();

            // Log activity before deleting
            ActivityLog::log(
                auth()->id(),
                'payment_deleted',
                "Payment {$payment->reference} deleted for {$buyerName} - {$propertyTitle} (₦" . number_format($payment->amount, 2) . ")",
                null,
                ['payment_id' => $payment->id, 'amount' => $payment->amount, 'property_id' => $payment->property_id]
            );

            $payment->delete();

            return response()->json([
                'success' => true,
                'message' => 'Payment deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete payment',
            ], 500);
        }
    }

    // Investment Management
    public function investments(Request $request)
    {
        $query = Investment::with(['investor', 'property']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by investor
        if ($request->filled('investor_id')) {
            $query->where('investor_id', $request->investor_id);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('reference', 'like', "%{$search}%")
                  ->orWhereHas('investor', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  })
                  ->orWhereHas('property', function($q) use ($search) {
                      $q->where('title', 'like', "%{$search}%");
                  });
            });
        }

        $investments = $query->latest()->paginate(20)->withQueryString();

        // Stats
        $investmentStats = [
            'all' => Investment::count(),
            'active' => Investment::where('status', 'active')->count(),
            'completed' => Investment::where('status', 'completed')->count(),
            'withdrawn' => Investment::where('status', 'withdrawn')->count(),
            'total_invested' => Investment::sum('amount'),
            'total_returns' => Investment::sum('total_return'),
        ];

        return view('admin.investments.index', compact('investments', 'investmentStats'));
    }

    public function approveWithdrawal(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'admin_notes' => 'nullable|string|max:500',
            ]);

            $investment = Investment::with('investor')->findOrFail($id);

            if ($investment->withdrawal_status !== 'requested') {
                return response()->json([
                    'success' => false,
                    'message' => 'Investment withdrawal has not been requested',
                ], 400);
            }

            $investment->update([
                'withdrawal_status' => 'approved',
                'admin_notes' => $validated['admin_notes'] ?? null,
            ]);

            // Notify investor
            Notification::createNotification(
                $investment->investor_id,
                'withdrawal_approved',
                'Withdrawal Approved',
                "Your withdrawal request for investment " . $investment->reference . " (₦" . number_format($investment->total_return, 2) . ") has been approved. Payment will be processed shortly.",
                $investment,
                'bi-check-circle-fill',
                'success'
            );

            return response()->json([
                'success' => true,
                'message' => 'Withdrawal approved. Please process payment to investor.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to approve withdrawal',
            ], 500);
        }
    }

    public function markWithdrawalPaid(Request $request, $id)
    {
        try {
            $investment = Investment::with('investor')->findOrFail($id);

            if ($investment->withdrawal_status !== 'approved') {
                return response()->json([
                    'success' => false,
                    'message' => 'Withdrawal must be approved first',
                ], 400);
            }

            $investment->update([
                'status' => 'completed',
                'withdrawal_status' => 'paid',
            ]);

            // Notify investor
            Notification::createNotification(
                $investment->investor_id,
                'withdrawal_paid',
                'Withdrawal Paid',
                "Your withdrawal for investment " . $investment->reference . " (₦" . number_format($investment->total_return, 2) . ") has been paid. Please check your bank account.",
                $investment,
                'bi-check-circle-fill',
                'success'
            );

            return response()->json([
                'success' => true,
                'message' => 'Withdrawal marked as paid successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark withdrawal as paid',
            ], 500);
        }
    }

    public function rejectWithdrawal(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'reason' => 'required|string|max:500',
            ]);

            $investment = Investment::findOrFail($id);

            if ($investment->status !== 'withdrawn') {
                return response()->json([
                    'success' => false,
                    'message' => 'Investment is not in withdrawal status',
                ], 400);
            }

            $investment->update([
                'status' => 'active',
                'withdrawal_status' => null,
                'withdrawal_requested_at' => null,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Withdrawal rejected',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to reject withdrawal',
            ], 500);
        }
    }

    // Impersonation (see impersonateUser / stopImpersonation above)

    // Settings
    public function settings()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('admin.settings.index', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        try {
            $validated = $request->validate([
                'investor_upgrade_amount' => 'nullable|numeric|min:0',
                'company_name' => 'nullable|string|max:255',
                'company_email' => 'nullable|email',
                'company_phone' => 'nullable|string',
                'company_address' => 'nullable|string',
                'bank_name' => 'nullable|string',
                'bank_account_number' => 'nullable|string',
                'bank_account_name' => 'nullable|string',
                'payment_instructions' => 'nullable|string',
            ]);

            foreach ($validated as $key => $value) {
                Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $value]
                );
            }

            return response()->json([
                'success' => true,
                'message' => 'Settings updated successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update settings',
            ], 500);
        }
    }

    public function inquiries(Request $request)
    {
        $query = Inquiry::with('user', 'property');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $inquiries = $query->latest()->paginate(20)->withQueryString();

        // Stats
        $inquiryStats = [
            'all' => Inquiry::count(),
            'new' => Inquiry::where('status', 'new')->count(),
            'in_progress' => Inquiry::where('status', 'in_progress')->count(),
            'resolved' => Inquiry::where('status', 'resolved')->count(),
        ];

        return view('admin.inquiries.index', compact('inquiries', 'inquiryStats'));
    }

    public function showInquiry($id)
    {
        $inquiry = Inquiry::with('user', 'property')->findOrFail($id);
        
        // Mark as read if new
        if ($inquiry->status === 'new') {
            $inquiry->update(['status' => 'in_progress']);
        }

        return view('admin.inquiries.show', compact('inquiry'));
    }

    public function updateInquiryStatus(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'status' => 'required|in:new,in_progress,resolved',
            ]);

            $inquiry = Inquiry::findOrFail($id);
            $inquiry->update(['status' => $validated['status']]);

            return response()->json([
                'success' => true,
                'message' => 'Inquiry status updated successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update inquiry status',
            ], 500);
        }
    }

    public function viewUserProfile($id)
    {
        $user = User::with([
            'properties' => function($query) {
                $query->latest()->limit(10);
            },
            'investments' => function($query) {
                $query->latest()->limit(10);
            },
            'payments' => function($query) {
                $query->latest()->limit(10);
            },
            'inspections' => function($query) {
                $query->latest()->limit(10);
            }
        ])->findOrFail($id);

        // Get stats based on role
        $stats = [];
        if ($user->isAgent()) {
            $stats = [
                'total_properties' => $user->properties()->count(),
                'approved_properties' => $user->properties()->where('approval_status', 'approved')->count(),
                'pending_properties' => $user->properties()->where('approval_status', 'pending')->count(),
                'total_inspections' => Inspection::whereHas('property', function($q) use ($user) {
                    $q->where('agent_id', $user->id);
                })->count(),
            ];
        } elseif ($user->isInvestor()) {
            $stats = [
                'total_investments' => $user->investments()->count(),
                'active_investments' => $user->investments()->where('status', 'active')->count(),
                'total_invested' => $user->investments()->sum('amount'),
                'total_returns' => $user->investments()->sum('total_return'),
            ];
        } else {
            $stats = [
                'total_inspections' => $user->inspections()->count(),
                'total_payments' => $user->payments()->count(),
                'total_investments' => $user->investments()->count(),
            ];
        }

        return view('admin.users.profile', compact('user', 'stats'));
    }

    public function promotions()
    {
        $promotion = Promotion::where('is_active', true)->first();
        return view('admin.promotions.index', compact('promotion'));
    }

    public function storePromotion(Request $request)
    {
        try {
            $validated = $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
                'title' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'link' => 'nullable|url|max:500',
            ]);

            // Delete existing active promotion
            $existingPromotion = Promotion::where('is_active', true)->first();
            if ($existingPromotion) {
                Storage::disk('public')->delete($existingPromotion->image);
                $existingPromotion->delete();
            }

            // Store new image
            $imagePath = $request->file('image')->store('promotions', 'public');

            $promotion = Promotion::create([
                'image' => $imagePath,
                'title' => $validated['title'] ?? null,
                'description' => $validated['description'] ?? null,
                'link' => $validated['link'] ?? null,
                'is_active' => true,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Promotion uploaded successfully!',
                'promotion' => $promotion,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload promotion: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function deletePromotion($id)
    {
        try {
            $promotion = Promotion::findOrFail($id);
            
            // Delete image file
            if ($promotion->image) {
                Storage::disk('public')->delete($promotion->image);
            }
            
            $promotion->delete();

            return response()->json([
                'success' => true,
                'message' => 'Promotion deleted successfully!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete promotion: ' . $e->getMessage(),
            ], 500);
        }
    }

    // Sales Management
    public function sales(Request $request)
    {
        $query = Payment::with(['user', 'property', 'receipt', 'approver'])
            ->where('status', 'approved')
            ->whereIn('type', ['purchase', 'rent']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('reference', 'like', "%{$search}%")
                  ->orWhere('buyer_name', 'like', "%{$search}%")
                  ->orWhere('buyer_email', 'like', "%{$search}%")
                  ->orWhere('amount', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  })
                  ->orWhereHas('property', function($q) use ($search) {
                      $q->where('title', 'like', "%{$search}%")
                        ->orWhere('location', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('date_from')) {
            $query->where('sale_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('sale_date', '<=', $request->date_to . ' 23:59:59');
        }

        $sales = $query->latest('sale_date')->paginate(20)->withQueryString();

        $stats = [
            'total_sales' => Payment::where('status', 'approved')
                ->whereIn('type', ['purchase', 'rent'])->sum('amount'),
            'total_transactions' => Payment::where('status', 'approved')
                ->whereIn('type', ['purchase', 'rent'])->count(),
            'this_month' => Payment::where('status', 'approved')
                ->whereIn('type', ['purchase', 'rent'])
                ->whereMonth('sale_date', now()->month)
                ->whereYear('sale_date', now()->year)
                ->sum('amount'),
        ];

        return view('admin.sales.index', compact('sales', 'stats'));
    }

    public function createSale()
    {
        $users = User::where('status', 'active')
            ->whereIn('role', ['user', 'agent', 'investor'])
            ->orderBy('name')
            ->get(['id', 'name', 'email']);
        $properties = Property::where('status', 'Available')
            ->orderBy('title')
            ->get(['id', 'title', 'location', 'price']);

        return view('admin.sales.create', compact('users', 'properties'));
    }

    public function storeSale(Request $request)
    {
        try {
            $validated = $request->validate([
                'user_id' => 'nullable|exists:users,id',
                'buyer_name' => 'nullable|required_without:user_id|string|max:255',
                'buyer_email' => 'nullable|required_without:user_id|email|max:255',
                'buyer_phone' => 'nullable|required_without:user_id|string|max:255',
                'buyer_address' => 'nullable|string|max:1000',
                'property_id' => 'nullable|exists:properties,id',
                'new_property_title' => 'nullable|required_without:property_id|string|max:255',
                'new_property_location' => 'nullable|required_without:property_id|string|max:255',
                'new_property_address' => 'nullable|string|max:1000',
                'new_property_category' => 'nullable|required_without:property_id|string|max:100',
                'amount' => 'required|numeric|min:0',
                'sale_date' => 'required|date',
                'payment_method' => 'required|string',
                'staff_notes' => 'nullable|string|max:1000',
                'type' => 'nullable|in:purchase,rent',
            ]);

            $paymentType = $validated['type'] ?? 'purchase';
            $propertyStatus = $paymentType === 'rent' ? 'Rented' : 'Sold';

            // Resolve existing property or create a new one on the fly
            if (!empty($validated['property_id'])) {
                $property = Property::findOrFail($validated['property_id']);
            } else {
                $property = Property::create([
                    'agent_id' => auth()->id(),
                    'title' => $validated['new_property_title'],
                    'description' => $validated['new_property_title'] . ' - ' . $validated['new_property_location'],
                    'type' => $paymentType === 'rent' ? 'Rent' : 'Sale',
                    'category' => $validated['new_property_category'],
                    'price' => $validated['amount'],
                    'location' => $validated['new_property_location'],
                    'address' => $validated['new_property_address'] ?: $validated['new_property_location'],
                    'status' => $propertyStatus,
                    'approval_status' => 'approved',
                ]);
            }

            $payment = Payment::create([
                'user_id' => $validated['user_id'] ?? null,
                'buyer_name' => $validated['buyer_name'] ?? null,
                'buyer_email' => $validated['buyer_email'] ?? null,
                'buyer_phone' => $validated['buyer_phone'] ?? null,
                'buyer_address' => $validated['buyer_address'] ?? null,
                'property_id' => $property->id,
                'reference' => Payment::generateReference(),
                'amount' => $validated['amount'],
                'type' => $paymentType,
                'schedule' => 'One-time',
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => auth()->id(),
                'sale_date' => $validated['sale_date'],
                'payment_method' => $validated['payment_method'],
                'staff_notes' => $validated['staff_notes'] ?? null,
            ]);

            // Update property status
            $property->update(['status' => $propertyStatus]);

            // Generate receipt
            app(ReceiptService::class)->generate($payment);

            // Log activity
            ActivityLog::log(
                auth()->id(),
                'sale_recorded',
                "Sale recorded for {$payment->buyer_name} - {$property->title} (₦" . number_format($payment->amount, 2) . ")",
                $payment,
                ['amount' => $payment->amount, 'method' => $validated['payment_method']]
            );

            // Notify buyer (only if linked to a registered user)
            if ($payment->user_id) {
                Notification::createNotification(
                    $payment->user_id,
                    'sale_confirmed',
                    'Sale Confirmed',
                    "Your purchase of {$property->title} has been confirmed. Receipt: {$payment->receipt->receipt_number}",
                    $payment,
                    'bi-check-circle-fill',
                    'success'
                );
            }

            return redirect()->route('admin.sales')
                ->with('success', 'Sale recorded and receipt generated successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to record sale: ' . $e->getMessage());
        }
    }

    public function showSale(Payment $payment)
    {
        if (!in_array($payment->status, ['approved']) || in_array($payment->type, ['investment'])) {
            abort(404);
        }

        $payment->load(['user', 'property', 'receipt.generator', 'approver']);
        return view('admin.sales.show', compact('payment'));
    }

    public function printReceipt(Payment $payment)
    {
        if (!in_array($payment->status, ['approved']) || in_array($payment->type, ['investment'])) {
            abort(404);
        }

        $receipt = $payment->receipt;

        if (!$receipt) {
            $receipt = app(ReceiptService::class)->generate($payment);
        } else {
            if (!$receipt->file_path) {
                $receipt->update(['file_path' => 'receipts/receipt-' . $receipt->receipt_number . '.pdf']);
            }
            app(ReceiptService::class)->regenerateFile($payment, $receipt);
        }

        $path = Storage::disk('public')->path($receipt->file_path);
        abort_if(!is_file($path), 404);

        return response()->file($path, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $receipt->receipt_number . '.pdf"',
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
        ]);
    }

    public function downloadReceipt(Payment $payment)
    {
        if (!in_array($payment->status, ['approved']) || in_array($payment->type, ['investment'])) {
            abort(404);
        }

        $receipt = $payment->receipt;

        if (!$receipt) {
            $receipt = app(ReceiptService::class)->generate($payment);
        } else {
            app(ReceiptService::class)->regenerateFile($payment, $receipt);
        }

        $path = Storage::disk('public')->path($receipt->file_path);
        abort_if(!is_file($path), 404);

        return response()->download($path, $receipt->receipt_number . '.pdf', [
            'Content-Type' => 'application/pdf',
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
        ]);
    }

    public function receiptShareImage(Payment $payment)
    {
        if (!in_array($payment->status, ['approved']) || in_array($payment->type, ['investment'])) {
            abort(404);
        }

        $receipt = $payment->receipt;

        if (!$receipt) {
            $receipt = app(ReceiptService::class)->generate($payment);
        }

        $imagePath = 'receipts/receipt-' . $receipt->receipt_number . '.png';
        if (!Storage::disk('public')->exists($imagePath)) {
            app(ReceiptService::class)->generateImage($payment, $receipt);
        }

        return response()->json([
            'success' => true,
            'url' => asset('storage/' . $imagePath),
        ]);
    }

    public function destroySale(Payment $payment)
    {
        if (!in_array($payment->status, ['approved']) || in_array($payment->type, ['investment'])) {
            abort(404);
        }

        try {
            $propertyTitle = $payment->property?->title ?? 'Unknown Property';
            $buyerName = $payment->buyer_name;

            // Restore property to Available if it was marked by this sale
            if ($payment->property && in_array($payment->property->status, ['Sold', 'Rented'])) {
                $payment->property->update(['status' => 'Available']);
            }

            // Delete receipt record + PDF file
            if ($payment->receipt) {
                if ($payment->receipt->file_path) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($payment->receipt->file_path);
                }
                $payment->receipt->delete();
            }

            // Log activity before deleting
            ActivityLog::log(
                auth()->id(),
                'sale_deleted',
                "Sale deleted for {$buyerName} - {$propertyTitle} (₦" . number_format($payment->amount, 2) . ")",
                null,
                ['payment_id' => $payment->id, 'amount' => $payment->amount, 'property_id' => $payment->property_id]
            );

            $payment->delete();

            return redirect()->route('admin.sales')
                ->with('success', 'Sale deleted and property marked as Available.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete sale: ' . $e->getMessage());
        }
    }

    // Purchase History
    public function purchaseHistory(Request $request)
    {
        $query = Purchase::with('recorder');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('reference', 'like', "%{$search}%")
                  ->orWhere('notes', 'like', "%{$search}%")
                  ->orWhere('amount', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('date_from')) {
            $query->where('purchase_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('purchase_date', '<=', $request->date_to);
        }

        $purchases = $query->latest('purchase_date')->paginate(20)->withQueryString();

        $stats = [
            'total_amount' => Purchase::sum('amount'),
            'total_records' => Purchase::count(),
            'this_month' => Purchase::whereMonth('purchase_date', now()->month)
                ->whereYear('purchase_date', now()->year)->sum('amount'),
        ];

        return view('admin.purchase-history', compact('purchases', 'stats'));
    }

    public function destroyPurchaseHistory(Purchase $purchase)
    {
        try {
            ActivityLog::log(
                auth()->id(),
                'purchase_deleted',
                "Purchase deleted: {$purchase->title} (₦" . number_format($purchase->amount, 2) . ")",
                null,
                ['amount' => $purchase->amount, 'category' => $purchase->category]
            );

            $purchase->delete();

            return redirect()->route('admin.purchase-history')
                ->with('success', 'Purchase record deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete purchase: ' . $e->getMessage());
        }
    }

    // Sale History (property purchases only)
    public function saleHistory(Request $request)
    {
        $query = Payment::with(['user', 'property', 'receipt', 'approver'])
            ->where('status', 'approved')
            ->where('type', 'purchase');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('reference', 'like', "%{$search}%")
                  ->orWhere('buyer_name', 'like', "%{$search}%")
                  ->orWhere('buyer_email', 'like', "%{$search}%")
                  ->orWhere('amount', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  })
                  ->orWhereHas('property', function($q) use ($search) {
                      $q->where('title', 'like', "%{$search}%")
                        ->orWhere('location', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('date_from')) {
            $query->where('sale_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('sale_date', '<=', $request->date_to . ' 23:59:59');
        }

        $sales = $query->latest('sale_date')->paginate(20)->withQueryString();

        $stats = [
            'total_sales' => Payment::where('status', 'approved')
                ->where('type', 'purchase')->sum('amount'),
            'total_transactions' => Payment::where('status', 'approved')
                ->where('type', 'purchase')->count(),
            'this_month' => Payment::where('status', 'approved')
                ->where('type', 'purchase')
                ->whereMonth('sale_date', now()->month)
                ->whereYear('sale_date', now()->year)
                ->sum('amount'),
        ];

        return view('admin.sale-history', compact('sales', 'stats'));
    }

    // Activity Logs
    public function activityLogs(Request $request)
    {
        $query = ActivityLog::with('user');

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->latest()->paginate(30)->withQueryString();

        return view('admin.activity_logs.index', compact('logs'));
    }
}

