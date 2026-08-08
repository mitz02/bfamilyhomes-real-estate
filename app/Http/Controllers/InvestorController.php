<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use App\Models\Property;
use App\Models\Payment;
use App\Models\Notification;
use App\Models\Setting;
use App\Support\AdminNotifier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class InvestorController extends Controller
{
    public function dashboard()
    {
        $investor = auth()->user();
        
        // Get all investments for this investor
        $allInvestments = Investment::where('investor_id', $investor->id)->get();
        
        // Calculate comprehensive stats
        $stats = [
            'total_investments' => $allInvestments->count(),
            'pending_investments' => $allInvestments->where('status', 'pending')->count(),
            'active_investments' => $allInvestments->where('status', 'active')->count(),
            'completed_investments' => $allInvestments->where('status', 'completed')->count(),
            'withdrawn_investments' => $allInvestments->where('status', 'withdrawn')->count(),
            'total_invested' => $allInvestments->where('status', '!=', 'pending')->sum('amount'),
            'pending_amount' => $allInvestments->where('status', 'pending')->sum('amount'),
            'total_returns' => $allInvestments->where('status', '!=', 'pending')->sum('total_return'),
            'total_profit' => $allInvestments->where('status', '!=', 'pending')->sum('total_return') - $allInvestments->where('status', '!=', 'pending')->sum('amount'),
            'average_roi' => $allInvestments->where('status', 'active')->count() > 0 ? $allInvestments->where('status', 'active')->avg('roi_percentage') : 0,
            'upcoming_maturities' => $allInvestments->where('status', 'active')
                ->where('maturity_date', '>=', now())
                ->where('maturity_date', '<=', now()->addDays(30))
                ->count(),
        ];

        // Calculate monthly investment data for chart (last 12 months)
        $monthlyData = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthStart = $month->copy()->startOfMonth();
            $monthEnd = $month->copy()->endOfMonth();
            
            $monthInvestments = $allInvestments->filter(function($inv) use ($monthStart, $monthEnd) {
                return $inv->start_date >= $monthStart && $inv->start_date <= $monthEnd;
            });
            
            $monthlyData[] = [
                'month' => $month->format('M Y'),
                'invested' => $monthInvestments->sum('amount'),
                'count' => $monthInvestments->count(),
            ];
        }

        // Investment by status for pie chart
        $statusData = [
            'active' => $stats['active_investments'],
            'completed' => $stats['completed_investments'],
            'withdrawn' => $stats['withdrawn_investments'],
        ];

        // ROI distribution
        $roiRanges = [
            '0-10%' => $allInvestments->where('roi_percentage', '>=', 0)->where('roi_percentage', '<', 10)->count(),
            '10-15%' => $allInvestments->where('roi_percentage', '>=', 10)->where('roi_percentage', '<', 15)->count(),
            '15-20%' => $allInvestments->where('roi_percentage', '>=', 15)->where('roi_percentage', '<', 20)->count(),
            '20%+' => $allInvestments->where('roi_percentage', '>=', 20)->count(),
        ];

        // Upcoming maturities (next 30 days)
        $upcomingMaturities = Investment::where('investor_id', $investor->id)
            ->where('status', 'active')
            ->where('maturity_date', '>=', now())
            ->where('maturity_date', '<=', now()->addDays(30))
            ->with('property')
            ->orderBy('maturity_date', 'asc')
            ->get();

        $recentInvestments = Investment::where('investor_id', $investor->id)
            ->with('property')
            ->latest()
            ->take(5)
            ->get();

        $recentPayments = Payment::where('user_id', $investor->id)
            ->with(['property', 'receipt'])
            ->latest()
            ->take(5)
            ->get();

        // Notifications
        $unreadNotifications = $investor->unreadNotifications()->count();
        $recentNotifications = $investor->notifications()->unread()->recent(5)->get();

        // Investment opportunities (exclude properties already invested in)
        // Only show properties with ROI and duration configured by admin
        $investedPropertyIds = $allInvestments->pluck('property_id')->toArray();
        $investmentProperties = Property::approved()
            ->where('type', 'Investment')
            ->whereNotNull('roi_percentage')
            ->whereNotNull('investment_duration')
            ->where(function($query) {
                $query->where('status', 'Available')
                      ->orWhereNull('status');
            })
            ->whereNotIn('id', $investedPropertyIds)
            ->take(6)
            ->get();

        return view('investor.dashboard', compact(
            'stats', 
            'recentInvestments', 
            'recentPayments',
            'investmentProperties', 
            'unreadNotifications', 
            'recentNotifications',
            'monthlyData',
            'statusData',
            'roiRanges',
            'upcomingMaturities'
        ));
    }

    public function investments(Request $request)
    {
        $query = Investment::where('investor_id', auth()->id())
            ->with('property');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by property category
        if ($request->filled('categories')) {
            $categories = is_array($request->categories) ? $request->categories : [$request->categories];
            $query->whereHas('property', function($q) use ($categories) {
                $q->whereIn('category', $categories);
            });
        }

        // Filter by investment amount range
        if ($request->filled('amount_min')) {
            $query->where('amount', '>=', $request->amount_min);
        }
        if ($request->filled('amount_max')) {
            $query->where('amount', '<=', $request->amount_max);
        }

        // Filter by ROI range
        if ($request->filled('roi_min')) {
            $query->where('roi_percentage', '>=', $request->roi_min);
        }
        if ($request->filled('roi_max')) {
            $query->where('roi_percentage', '<=', $request->roi_max);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->where('start_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('start_date', '<=', $request->date_to);
        }

        $investments = $query->latest()->paginate(10)->withQueryString();

        return view('investor.investments', compact('investments'));
    }

    public function invest(Request $request)
    {
        try {
            $minAmount = (float) (Setting::get('investor_upgrade_amount', config('bfamily.investor.upgrade_amount', 100000)) ?? 100000);
            
            $validated = $request->validate([
                'property_id' => 'required|exists:properties,id',
                'amount' => 'required|numeric|min:' . $minAmount,
            ], [
                'property_id.required' => 'Please select a property to invest in.',
                'property_id.exists' => 'The selected property does not exist.',
                'amount.required' => 'Investment amount is required.',
                'amount.numeric' => 'Investment amount must be a valid number.',
                'amount.min' => 'Investment amount must be at least ₦' . number_format($minAmount, 2) . '.',
            ]);

            $property = Property::findOrFail($validated['property_id']);
            
            // Get ROI and duration from property (set by admin)
            if (!$property->roi_percentage || !$property->investment_duration) {
                return response()->json([
                    'success' => false,
                    'message' => 'This investment property does not have ROI and duration configured. Please contact admin.',
                ], 400);
            }
            
            $roiPercentage = $property->roi_percentage;
            $durationMonths = $property->investment_duration;
            $totalReturn = $validated['amount'] + ($validated['amount'] * ($roiPercentage / 100));
            
            // Ensure property is approved and available for investment
            if ($property->approval_status !== 'approved') {
                return response()->json([
                    'success' => false,
                    'message' => 'This property is not yet approved for investment.',
                ], 400);
            }
            
            if ($property->type !== 'Investment') {
                return response()->json([
                    'success' => false,
                    'message' => 'This property is not available for investment.',
                ], 400);
            }
            
            // Check if investor already has pending investment in this property
            $existingInvestment = Investment::where('investor_id', auth()->id())
                ->where('property_id', $validated['property_id'])
                ->whereIn('status', ['pending', 'active'])
                ->first();
                
            if ($existingInvestment) {
                return response()->json([
                    'success' => false,
                    'message' => 'You already have a pending or active investment in this property.',
                ], 400);
            }
            
            // Create payment reference first
            $payment = Payment::create([
                'user_id' => auth()->id(),
                'property_id' => $validated['property_id'],
                'reference' => Payment::generateReference(),
                'amount' => $validated['amount'],
                'type' => 'investment',
                'schedule' => 'One-time',
                'status' => 'pending',
            ]);
            
            // Create pending investment (will be activated when payment is confirmed)
            $investment = Investment::create([
                'investor_id' => auth()->id(),
                'property_id' => $validated['property_id'],
                'payment_id' => $payment->id,
                'reference' => Investment::generateReference(),
                'amount' => $validated['amount'],
                'roi_percentage' => $roiPercentage, // From property (set by admin)
                'total_return' => $totalReturn,
                'duration_months' => $durationMonths, // From property (set by admin)
                'status' => 'pending', // Will be activated when payment is confirmed
                'start_date' => null, // Will be set when payment is confirmed
                'maturity_date' => null, // Will be calculated when payment is confirmed
            ]);

            // Notify admin
            $admin = \App\Models\User::where('role', 'admin')->first();
            if ($admin) {
                Notification::createNotification(
                    $admin->id,
                    'investment_initiated',
                    'New Investment Initiated',
                    auth()->user()->name . " initiated an investment of ₦" . number_format($validated['amount'], 2) . " (" . $investment->reference . ")",
                    $investment,
                    'bi-cash-coin',
                    'info'
                );
            }

            AdminNotifier::notify(
                'investment_initiated',
                'New Investment Initiated',
                auth()->user()->name . ' initiated an investment of <strong>₦' . number_format($validated['amount'], 2) . '</strong> at <strong>' . $roiPercentage . '% ROI</strong> for ' . $durationMonths . ' months.',
                [
                    'Investor' => auth()->user()->name,
                    'Email' => auth()->user()->email,
                    'Investment Reference' => $investment->reference,
                    'Payment Reference' => $payment->reference,
                    'Amount' => '₦' . number_format($validated['amount'], 2),
                    'Projected Return' => '₦' . number_format($totalReturn, 2),
                    'Property' => $property->title ?? 'N/A',
                    'ROI' => $roiPercentage . '%',
                    'Duration' => $durationMonths . ' months',
                ],
                route('admin.investments'),
                'View Investment'
            );

            return response()->json([
                'success' => true,
                'message' => 'Investment prepared successfully! Please complete payment.',
                'investment' => $investment,
                'payment' => $payment,
                'redirect' => route('investments.instructions', $investment->id),
            ]);
        } catch (ValidationException $e) {
            $errors = $e->errors();
            $firstError = collect($errors)->flatten()->first();
            
            return response()->json([
                'success' => false,
                'message' => $firstError ?: 'Validation failed. Please check your input.',
                'errors' => $errors,
            ], 422);
        } catch (\Exception $e) {
            Log::error('Investment creation error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage() ?: 'Failed to create investment. Please try again.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    public function instructions($id)
    {
        $investment = Investment::where('investor_id', auth()->id())
            ->with(['property', 'payment'])
            ->findOrFail($id);

        $bankDetails = PaymentController::bankDetails();

        return view('investor.investments.instructions', compact('investment', 'bankDetails'));
    }

    public function withdraw(Request $request, $id)
    {
        try {
            $investment = Investment::where('investor_id', auth()->id())
                ->with('property')
                ->findOrFail($id);

            if ($investment->status !== 'active') {
                return response()->json([
                    'success' => false,
                    'message' => 'Only active investments can be withdrawn',
                ], 400);
            }

            if ($investment->maturity_date && $investment->maturity_date > now()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Investment has not reached maturity yet. Maturity date: ' . $investment->maturity_date->format('M d, Y'),
                ], 400);
            }

            $investment->update([
                'status' => 'withdrawn',
                'withdrawal_status' => 'requested',
                'withdrawal_requested_at' => now(),
            ]);

            // Notify admin
            $admin = \App\Models\User::where('role', 'admin')->first();
            if ($admin) {
                Notification::createNotification(
                    $admin->id,
                    'withdrawal_requested',
                    'Withdrawal Request',
                    auth()->user()->name . " requested withdrawal for investment: " . $investment->reference . " (₦" . number_format($investment->total_return, 2) . ")",
                    $investment,
                    'bi-cash-stack',
                    'info'
                );
            }

            AdminNotifier::notify(
                'withdrawal_requested',
                'Withdrawal Request',
                auth()->user()->name . ' requested to withdraw <strong>₦' . number_format($investment->total_return, 2) . '</strong> from investment <strong>' . $investment->reference . '</strong>.',
                [
                    'Investor' => auth()->user()->name,
                    'Email' => auth()->user()->email,
                    'Investment Reference' => $investment->reference,
                    'Principal Invested' => '₦' . number_format($investment->amount, 2),
                    'Total Return (Payout)' => '₦' . number_format($investment->total_return, 2),
                    'Property' => $investment->property->title ?? 'N/A',
                    'Requested At' => now()->format('M d, Y h:i A'),
                ],
                route('admin.investments'),
                'Review Withdrawal'
            );

            return response()->json([
                'success' => true,
                'message' => 'Withdrawal request submitted! Admin will review and process your payment.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to process withdrawal: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function reinvest(Request $request, $id)
    {
        try {
            $originalInvestment = Investment::where('investor_id', auth()->id())
                ->with('property')
                ->findOrFail($id);

            if ($originalInvestment->status !== 'active') {
                return response()->json([
                    'success' => false,
                    'message' => 'Only active investments can be reinvested',
                ], 400);
            }

            if ($originalInvestment->maturity_date && $originalInvestment->maturity_date > now()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Investment has not reached maturity yet. Maturity date: ' . $originalInvestment->maturity_date->format('M d, Y'),
                ], 400);
            }

            // Get ROI and duration from property (set by admin)
            $property = Property::findOrFail($originalInvestment->property_id);
            if (!$property->roi_percentage || !$property->investment_duration) {
                return response()->json([
                    'success' => false,
                    'message' => 'This investment property does not have ROI and duration configured. Please contact admin.',
                ], 400);
            }

            $roiPercentage = $property->roi_percentage;
            $durationMonths = $property->investment_duration;
            $reinvestAmount = $originalInvestment->total_return; // Reinvest the total return
            $totalReturn = $reinvestAmount + ($reinvestAmount * ($roiPercentage / 100));

            // Reinvest directly - the matured funds are already held, so no new payment/transfer is required.
            // The new investment starts immediately as active.
            $newInvestment = Investment::create([
                'investor_id' => auth()->id(),
                'property_id' => $originalInvestment->property_id,
                'payment_id' => $originalInvestment->payment_id,
                'reference' => Investment::generateReference(),
                'amount' => $reinvestAmount,
                'roi_percentage' => $roiPercentage, // From property (set by admin)
                'total_return' => $totalReturn,
                'duration_months' => $durationMonths, // From property (set by admin)
                'status' => 'active',
                'start_date' => now(),
                'maturity_date' => now()->addMonths($durationMonths),
            ]);

            // Mark original investment as completed
            $originalInvestment->update(['status' => 'completed']);

            // Notify investor
            Notification::createNotification(
                auth()->id(),
                'investment_reinvested',
                'Investment Reinvested',
                "Your investment of ₦" . number_format($reinvestAmount, 2) . " has been reinvested at {$roiPercentage}% ROI for {$durationMonths} months. New maturity: " . $newInvestment->maturity_date->format('M d, Y'),
                $newInvestment,
                'bi-arrow-repeat',
                'success'
            );

            return response()->json([
                'success' => true,
                'message' => 'Investment reinvested successfully! Your new investment is now active.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to reinvest: ' . $e->getMessage(),
            ], 500);
        }
    }
}
