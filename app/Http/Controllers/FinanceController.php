<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Expense;
use App\Models\Payment;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class FinanceController extends Controller
{
    public const EXPENSE_CATEGORIES = [
        'Marketing', 'Salaries & Wages', 'Utilities', 'Transport & Fuel', 'Maintenance',
        'Office & Admin', 'Legal & Professional', 'Taxes', 'Software & Tools', 'Other',
    ];

    public const PURCHASE_CATEGORIES = [
        'Land', 'Building Materials', 'Equipment', 'Property', 'Construction', 'Other',
    ];

    public function index(Request $request)
    {
        [$period, $start, $end] = $this->resolvePeriod($request);

        $salesQuery = fn() => Payment::where('status', 'approved')
            ->whereIn('type', ['purchase', 'rent'])
            ->whereBetween('sale_date', [$start, $end]);

        $totalSales = $salesQuery()->sum('amount');
        $totalPurchases = Purchase::whereBetween('purchase_date', [$start->toDateString(), $end->toDateString()])->sum('amount');
        $totalExpenses = Expense::whereBetween('expense_date', [$start->toDateString(), $end->toDateString()])->sum('amount');
        $netProfit = $totalSales - $totalPurchases - $totalExpenses;

        $sales = $salesQuery()
            ->with(['user', 'property', 'receipt'])
            ->orderByDesc('sale_date')
            ->get();

        $purchases = Purchase::with('recorder')
            ->whereBetween('purchase_date', [$start->toDateString(), $end->toDateString()])
            ->orderByDesc('purchase_date')
            ->get();

        $expenses = Expense::with('recorder')
            ->whereBetween('expense_date', [$start->toDateString(), $end->toDateString()])
            ->orderByDesc('expense_date')
            ->get();

        $chartData = $this->chartData($start, $end);

        $expenseBreakdown = Expense::whereBetween('expense_date', [$start->toDateString(), $end->toDateString()])
            ->selectRaw('category, SUM(amount) as total')
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();

        $purchaseBreakdown = Purchase::whereBetween('purchase_date', [$start->toDateString(), $end->toDateString()])
            ->selectRaw('category, SUM(amount) as total')
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();

        return view('admin.finance', compact(
            'period', 'start', 'end',
            'totalSales', 'totalPurchases', 'totalExpenses', 'netProfit',
            'sales', 'purchases', 'expenses',
            'chartData', 'expenseBreakdown', 'purchaseBreakdown'
        ))->with([
            'expenseCategories' => self::EXPENSE_CATEGORIES,
            'purchaseCategories' => self::PURCHASE_CATEGORIES,
        ]);
    }

    // ------------------------------------------------------------------
    // Expense pages
    // ------------------------------------------------------------------

    public function createExpense()
    {
        return view('admin.finance.expenses.form', [
            'expense' => null,
            'categories' => self::EXPENSE_CATEGORIES,
        ]);
    }

    public function editExpense(Expense $expense)
    {
        return view('admin.finance.expenses.form', [
            'expense' => $expense,
            'categories' => self::EXPENSE_CATEGORIES,
        ]);
    }

    // ------------------------------------------------------------------
    // Purchase pages
    // ------------------------------------------------------------------

    public function createPurchase()
    {
        return view('admin.finance.purchases.form', [
            'purchase' => null,
            'categories' => self::PURCHASE_CATEGORIES,
        ]);
    }

    public function editPurchase(Purchase $purchase)
    {
        return view('admin.finance.purchases.form', [
            'purchase' => $purchase,
            'categories' => self::PURCHASE_CATEGORIES,
        ]);
    }

    // ------------------------------------------------------------------
    // Expense CRUD
    // ------------------------------------------------------------------

    public function storeExpense(Request $request)
    {
        $validated = $this->validateEntry($request, 'expense_date');

        $expense = Expense::create($validated + ['recorded_by' => auth()->id()]);

        ActivityLog::log(
            auth()->id(),
            'expense_recorded',
            "Expense recorded: {$expense->title} ({$expense->formatted_amount})",
            $expense,
            ['amount' => $expense->amount, 'category' => $expense->category]
        );

        return $this->entryResponse($request, 'Expense recorded successfully.', [
            'expense' => $expense,
        ]);
    }

    public function updateExpense(Request $request, Expense $expense)
    {
        $validated = $this->validateEntry($request, 'expense_date');

        $expense->update($validated);

        ActivityLog::log(
            auth()->id(),
            'expense_updated',
            "Expense updated: {$expense->title} ({$expense->formatted_amount})",
            $expense,
            ['amount' => $expense->amount, 'category' => $expense->category]
        );

        return $this->entryResponse($request, 'Expense updated successfully.', [
            'expense' => $expense->fresh(),
        ]);
    }

    public function destroyExpense(Expense $expense)
    {
        $expense->delete();

        ActivityLog::log(
            auth()->id(),
            'expense_deleted',
            "Expense deleted: {$expense->title} (₦" . number_format($expense->amount, 2) . ")",
            null,
            ['amount' => $expense->amount, 'category' => $expense->category]
        );

        return response()->json([
            'success' => true,
            'message' => 'Expense deleted successfully.',
        ]);
    }

    // ------------------------------------------------------------------
    // Purchase CRUD
    // ------------------------------------------------------------------

    public function storePurchase(Request $request)
    {
        $validated = $this->validateEntry($request, 'purchase_date');

        $purchase = Purchase::create($validated + ['recorded_by' => auth()->id()]);

        ActivityLog::log(
            auth()->id(),
            'purchase_recorded',
            "Purchase recorded: {$purchase->title} ({$purchase->formatted_amount})",
            $purchase,
            ['amount' => $purchase->amount, 'category' => $purchase->category]
        );

        return $this->entryResponse($request, 'Purchase recorded successfully.', [
            'purchase' => $purchase,
        ]);
    }

    public function updatePurchase(Request $request, Purchase $purchase)
    {
        $validated = $this->validateEntry($request, 'purchase_date');

        $purchase->update($validated);

        ActivityLog::log(
            auth()->id(),
            'purchase_updated',
            "Purchase updated: {$purchase->title} ({$purchase->formatted_amount})",
            $purchase,
            ['amount' => $purchase->amount, 'category' => $purchase->category]
        );

        return $this->entryResponse($request, 'Purchase updated successfully.', [
            'purchase' => $purchase->fresh(),
        ]);
    }

    public function destroyPurchase(Purchase $purchase)
    {
        $purchase->delete();

        ActivityLog::log(
            auth()->id(),
            'purchase_deleted',
            "Purchase deleted: {$purchase->title} (₦" . number_format($purchase->amount, 2) . ")",
            null,
            ['amount' => $purchase->amount, 'category' => $purchase->category]
        );

        return response()->json([
            'success' => true,
            'message' => 'Purchase deleted successfully.',
        ]);
    }

    // ------------------------------------------------------------------
    // Helpers
    // ------------------------------------------------------------------

    private function validateEntry(Request $request, string $dateField): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0',
            $dateField => 'required|date',
            'payment_method' => 'nullable|string|max:100',
            'reference' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:2000',
        ]);
    }

    private function entryResponse(Request $request, string $message, array $payload)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
            ] + $payload);
        }

        return redirect()->route('admin.finance')->with('success', $message);
    }

    private function resolvePeriod(Request $request): array
    {
        $period = $request->get('period', 'month');

        if ($period === 'custom' && $request->filled(['date_from', 'date_to'])) {
            $start = Carbon::parse($request->date_from)->startOfDay();
            $end = Carbon::parse($request->date_to)->endOfDay();
            return ['custom', $start, $end];
        }

        $now = now();
        switch ($period) {
            case 'today':
                $start = $now->copy()->startOfDay();
                $end = $now->copy()->endOfDay();
                break;
            case 'week':
                $start = $now->copy()->startOfWeek();
                $end = $now->copy()->endOfWeek();
                break;
            case 'quarter':
                $start = $now->copy()->startOfQuarter();
                $end = $now->copy()->endOfQuarter();
                break;
            case 'year':
                $start = $now->copy()->startOfYear();
                $end = $now->copy()->endOfYear();
                break;
            default:
                $period = 'month';
                $start = $now->copy()->startOfMonth();
                $end = $now->copy()->endOfMonth();
        }

        return [$period, $start->startOfDay(), $end->endOfDay()];
    }

    private function chartData(Carbon $start, Carbon $end): array
    {
        $salesByDay = Payment::where('status', 'approved')
            ->whereIn('type', ['purchase', 'rent'])
            ->whereBetween('sale_date', [$start, $end])
            ->selectRaw('DATE(sale_date) as d, SUM(amount) as total')
            ->groupBy('d')
            ->pluck('total', 'd')
            ->map(fn($v) => (float) $v);

        $purchasesByDay = Purchase::whereBetween('purchase_date', [$start->toDateString(), $end->toDateString()])
            ->selectRaw('purchase_date as d, SUM(amount) as total')
            ->groupBy('d')
            ->pluck('total', 'd')
            ->map(fn($v) => (float) $v);

        $expensesByDay = Expense::whereBetween('expense_date', [$start->toDateString(), $end->toDateString()])
            ->selectRaw('expense_date as d, SUM(amount) as total')
            ->groupBy('d')
            ->pluck('total', 'd')
            ->map(fn($v) => (float) $v);

        $buckets = $this->buckets($start, $end);

        $rows = [];
        $cumulativeSales = 0;

        foreach ($buckets as $bucket) {
            $sales = $this->sumBetween($salesByDay, $bucket['start'], $bucket['end']);
            $purchases = $this->sumBetween($purchasesByDay, $bucket['start'], $bucket['end']);
            $expenses = $this->sumBetween($expensesByDay, $bucket['start'], $bucket['end']);
            $cumulativeSales += $sales;

            $rows[] = [
                'label' => $bucket['label'],
                'sales' => round($sales, 2),
                'purchases' => round($purchases, 2),
                'expenses' => round($expenses, 2),
                'profit' => round($sales - $purchases - $expenses, 2),
                'cumulative_sales' => round($cumulativeSales, 2),
            ];
        }

        return $rows;
    }

    private function buckets(Carbon $start, Carbon $end): Collection
    {
        $days = $start->copy()->startOfDay()->diffInDays($end->copy()->startOfDay()) + 1;
        $buckets = collect();

        if ($days <= 31) {
            $cursor = $start->copy()->startOfDay();
            while ($cursor <= $end) {
                $buckets->push([
                    'label' => $cursor->format('M j'),
                    'start' => $cursor->copy(),
                    'end' => $cursor->copy(),
                ]);
                $cursor->addDay();
            }
        } elseif ($days <= 180) {
            $cursor = $start->copy()->startOfWeek();
            while ($cursor <= $end) {
                $bucketEnd = $cursor->copy()->endOfWeek();
                if ($bucketEnd > $end) {
                    $bucketEnd = $end->copy();
                }
                $buckets->push([
                    'label' => 'Wk ' . $cursor->format('d M'),
                    'start' => $cursor->copy(),
                    'end' => $bucketEnd,
                ]);
                $cursor->addWeek();
            }
        } else {
            $cursor = $start->copy()->startOfMonth();
            while ($cursor <= $end) {
                $bucketEnd = $cursor->copy()->endOfMonth();
                if ($bucketEnd > $end) {
                    $bucketEnd = $end->copy();
                }
                $buckets->push([
                    'label' => $cursor->format('M Y'),
                    'start' => $cursor->copy(),
                    'end' => $bucketEnd,
                ]);
                $cursor->addMonth();
            }
        }

        return $buckets;
    }

    private function sumBetween(Collection $byDay, Carbon $from, Carbon $to): float
    {
        $total = 0.0;
        $cursor = $from->copy();
        while ($cursor <= $to) {
            $total += (float) ($byDay[$cursor->toDateString()] ?? 0);
            $cursor->addDay();
        }
        return $total;
    }
}
