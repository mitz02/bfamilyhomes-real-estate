@extends('layouts.admin')

@section('title', 'Finance & Reports')

@push('styles')
<style>
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-6px); }
    }
    @keyframes pulse-soft {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.08); }
    }
    .animate-float { animation: float 3s ease-in-out infinite; }
    .animate-pulse-soft { animation: pulse-soft 2s ease-in-out infinite; }
</style>
@endpush

@section('content')
@php
    $hour = now()->hour;
    if ($hour < 12) $greeting = 'Good Morning';
    elseif ($hour < 17) $greeting = 'Good Afternoon';
    else $greeting = 'Good Evening';

    $periods = ['today' => 'Today', 'week' => 'This Week', 'month' => 'This Month', 'quarter' => 'This Quarter', 'year' => 'This Year'];
@endphp

<div class="mb-8">
    <div class="flex items-center gap-2 text-xs md:text-sm text-gray-500 mb-4 px-2 md:px-0">
        <a href="{{ route('home') }}" class="hover:text-orange-600 transition-colors">
            <i class="bi bi-house-door mr-1"></i>B-Family
        </a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-orange-600 font-semibold">Finance & Reports</span>
    </div>

    <div class="relative bg-gradient-to-br from-blue-900 via-blue-800 to-blue-900 rounded-2xl p-6 md:p-8 shadow-lg overflow-hidden">
        <div class="absolute -top-10 -right-10 w-48 h-48 bg-white/5 rounded-full"></div>
        <div class="absolute -bottom-10 -left-10 w-36 h-36 bg-white/5 rounded-full"></div>

        <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-start gap-4">
                <div class="w-14 h-14 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center shadow-sm flex-shrink-0 border border-white/10">
                    <i class="bi bi-cash-stack text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-bold text-white">Finance & Reports</h1>
                    <p class="text-blue-100/80 text-sm mt-0.5">{{ $greeting }}, {{ auth()->user()->name }}!</p>
                    <p class="text-blue-300/60 text-xs mt-0.5">{{ $start->format('l, M j, Y') }} — {{ $end->format('l, M j, Y') }}</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.finance.expenses.create') }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 bg-white text-blue-900 rounded-lg hover:bg-blue-50 font-semibold transition-all text-sm shadow-sm">
                    <i class="bi bi-plus-lg"></i> Record Expense
                </a>
                <a href="{{ route('admin.finance.purchases.create') }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 bg-gradient-to-r from-orange-500 to-yellow-500 text-white rounded-lg hover:from-orange-600 hover:to-yellow-600 font-semibold transition-all text-sm shadow-sm">
                    <i class="bi bi-plus-lg"></i> Record Purchase
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Period Filter -->
<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 mb-6 mx-1 md:mx-0">
    <div class="flex flex-wrap items-center gap-2">
        <span class="text-sm font-semibold text-gray-700 mr-1"><i class="bi bi-funnel mr-1 text-gray-400"></i>Period:</span>
        @foreach($periods as $key => $label)
        <a href="{{ route('admin.finance', array_merge(['period' => $key], request()->only(['date_from', 'date_to']))) }}"
           class="px-4 py-1.5 rounded-lg text-sm font-medium transition-all {{ $period === $key ? 'bg-blue-900 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-orange-50 hover:text-orange-600' }}">
            {{ $label }}
        </a>
        @endforeach
        <a href="{{ route('admin.finance', array_merge(['period' => 'custom'], request()->only(['date_from', 'date_to']))) }}"
           class="px-4 py-1.5 rounded-lg text-sm font-medium transition-all {{ $period === 'custom' ? 'bg-blue-900 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-orange-50 hover:text-orange-600' }}">
            Custom
        </a>
        <form method="GET" action="{{ route('admin.finance') }}" class="flex items-center gap-2 ml-auto">
            <input type="hidden" name="period" value="custom">
            <input type="date" name="date_from" value="{{ request('date_from') }}" class="border border-gray-200 rounded-lg px-2.5 py-1.5 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none">
            <span class="text-gray-400 text-xs">to</span>
            <input type="date" name="date_to" value="{{ request('date_to') }}" class="border border-gray-200 rounded-lg px-2.5 py-1.5 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none">
            <button type="submit" class="px-3 py-1.5 bg-blue-900 text-white rounded-lg hover:bg-blue-800 text-sm font-medium transition-colors">Go</button>
        </form>
    </div>
</div>

<!-- Profit Stat Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6 px-1 md:px-0">
    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-24 h-24 bg-green-100/60 rounded-full -mr-12 -mt-12"></div>
        <div class="relative">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                    <i class="bi bi-graph-up-arrow text-green-600"></i>
                </div>
                <span class="text-xs text-green-600 font-medium bg-green-50 px-2 py-0.5 rounded-full">Income</span>
            </div>
            <h3 class="text-gray-500 text-xs font-medium mb-1">Total Sales</h3>
            <p class="text-xl md:text-2xl font-bold text-gray-900">₦{{ number_format($totalSales, 2) }}</p>
            <p class="text-xs text-gray-400 mt-1">{{ $sales->count() }} approved sale{{ $sales->count() !== 1 ? 's' : '' }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-24 h-24 bg-blue-100/60 rounded-full -mr-12 -mt-12"></div>
        <div class="relative">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="bi bi-cart-check text-blue-600"></i>
                </div>
                <span class="text-xs text-blue-600 font-medium bg-blue-50 px-2 py-0.5 rounded-full">Cost</span>
            </div>
            <h3 class="text-gray-500 text-xs font-medium mb-1">Total Purchases</h3>
            <p class="text-xl md:text-2xl font-bold text-gray-900">₦{{ number_format($totalPurchases, 2) }}</p>
            <p class="text-xs text-gray-400 mt-1">{{ $purchases->count() }} recorded purchase{{ $purchases->count() !== 1 ? 's' : '' }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-24 h-24 bg-rose-100/60 rounded-full -mr-12 -mt-12"></div>
        <div class="relative">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-rose-100 rounded-xl flex items-center justify-center">
                    <i class="bi bi-receipt-cutoff text-rose-600"></i>
                </div>
                <span class="text-xs text-rose-600 font-medium bg-rose-50 px-2 py-0.5 rounded-full">Cost</span>
            </div>
            <h3 class="text-gray-500 text-xs font-medium mb-1">Total Expenses</h3>
            <p class="text-xl md:text-2xl font-bold text-gray-900">₦{{ number_format($totalExpenses, 2) }}</p>
            <p class="text-xs text-gray-400 mt-1">{{ $expenses->count() }} recorded expense{{ $expenses->count() !== 1 ? 's' : '' }}</p>
        </div>
    </div>

    <div class="rounded-xl p-5 shadow-sm border relative overflow-hidden {{ $netProfit >= 0 ? 'bg-gradient-to-br from-blue-900 to-blue-800 border-blue-900' : 'bg-gradient-to-br from-rose-600 to-rose-700 border-rose-600' }}">
        <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -mr-12 -mt-12"></div>
        <div class="relative">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-white/15 rounded-xl flex items-center justify-center">
                    <i class="bi bi-piggy-bank text-white"></i>
                </div>
                <span class="text-xs bg-white/15 text-white font-medium px-2 py-0.5 rounded-full">Profit = Sales − Purchases − Expenses</span>
            </div>
            <h3 class="text-blue-100/70 text-xs font-medium mb-1">Net Profit</h3>
            <p class="text-xl md:text-2xl font-bold text-white">₦{{ number_format($netProfit, 2) }}</p>
            <p class="text-xs mt-1 {{ $netProfit >= 0 ? 'text-blue-100/70' : 'text-rose-100/80' }}">{{ $netProfit >= 0 ? 'Profitable period' : 'Period running at a loss' }}</p>
        </div>
    </div>
</div>

<!-- Charts Row 1 -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6 mx-1 md:mx-0">
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-lg font-bold text-gray-900">Sales vs Purchases vs Expenses</h2>
                <p class="text-xs text-gray-400 mt-0.5">Money in vs money out for the selected period</p>
            </div>
            <i class="bi bi-bar-chart-fill text-orange-500"></i>
        </div>
        <div class="h-72">
            <canvas id="comparisonChart"></canvas>
        </div>
    </div>

    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-lg font-bold text-gray-900">Net Profit Trend</h2>
                <p class="text-xs text-gray-400 mt-0.5">Profit per {{ $period === 'today' ? 'day' : ($period === 'week' ? 'day' : ($period === 'year' ? 'month' : ($period === 'quarter' ? 'week' : 'bucket'))) }}</p>
            </div>
            <i class="bi bi-graph-up text-orange-500"></i>
        </div>
        <div class="h-72">
            <canvas id="profitChart"></canvas>
        </div>
    </div>
</div>

<!-- Charts Row 2 -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6 mx-1 md:mx-0">
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-lg font-bold text-gray-900">Revenue Growth</h2>
                <p class="text-xs text-gray-400 mt-0.5">Cumulative sales across the period</p>
            </div>
            <i class="bi bi-activity text-orange-500"></i>
        </div>
        <div class="h-72">
            <canvas id="growthChart"></canvas>
        </div>
    </div>

    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-lg font-bold text-gray-900">Expense Breakdown</h2>
                <p class="text-xs text-gray-400 mt-0.5">Expenses by category</p>
            </div>
            <i class="bi bi-pie-chart-fill text-orange-500"></i>
        </div>
        <div class="h-72 flex items-center justify-center">
            <canvas id="expenseChart" style="max-width: 300px; max-height: 300px;"></canvas>
        </div>
    </div>
</div>

<!-- Recent Sales -->
<div class="bg-white rounded-xl border border-gray-100 shadow-sm mb-6 mx-1 md:mx-0">
    <div class="flex items-center justify-between p-6 pb-4">
        <h2 class="text-lg font-bold text-gray-900"><i class="bi bi-receipt mr-2 text-orange-500"></i>Sales In Period</h2>
        <a href="{{ route('admin.sales') }}" class="text-orange-600 hover:text-orange-700 text-sm font-semibold flex items-center gap-1">
            View All Sales <i class="bi bi-arrow-right"></i>
        </a>
    </div>
    <div class="px-6 pb-6">
        @if($sales->count() > 0)
        <div class="space-y-3 max-h-96 overflow-y-auto pr-1">
            @foreach($sales as $sale)
            <div class="flex items-center gap-4 p-3 rounded-xl border border-gray-100 hover:bg-orange-50/40 transition-colors">
                <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center flex-shrink-0">
                    <i class="bi bi-check-circle text-green-600"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between gap-2">
                        <h4 class="font-semibold text-gray-900 text-sm truncate">{{ $sale->property->title ?? 'Property' }}</h4>
                        <span class="font-bold text-green-600 text-sm flex-shrink-0">₦{{ number_format($sale->amount, 2) }}</span>
                    </div>
                    <div class="flex items-center justify-between gap-2 mt-0.5">
                        <p class="text-xs text-gray-500 truncate">
                            {{ $sale->buyer_name }} · {{ $sale->receipt?->receipt_number ?? 'N/A' }} · {{ \Illuminate\Support\Str::ucfirst($sale->type) }}
                        </p>
                        <span class="text-xs text-gray-400 flex-shrink-0">{{ $sale->sale_date?->format('M j, Y') }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-gray-500 text-center py-8"><i class="bi bi-inbox mr-1"></i>No approved sales in this period.</p>
        @endif
    </div>
</div>

<!-- Purchases -->
<div class="bg-white rounded-xl border border-gray-100 shadow-sm mb-6 mx-1 md:mx-0">
    <div class="flex items-center justify-between p-6 pb-4">
        <div>
            <h2 class="text-lg font-bold text-gray-900"><i class="bi bi-cart-check mr-2 text-blue-500"></i>Purchases</h2>
            <p class="text-xs text-gray-400 mt-0.5">Land, building materials, equipment and other costs of acquisition</p>
        </div>
        <a href="{{ route('admin.finance.purchases.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-900 text-white rounded-lg hover:bg-blue-800 font-semibold transition-all text-sm shadow-sm">
            <i class="bi bi-plus-lg"></i> Record Purchase
        </a>
    </div>
    <div class="px-6 pb-6 overflow-x-auto" style="-webkit-overflow-scrolling: touch;">
        @if($purchases->count() > 0)
        <table class="w-full" style="min-width: 760px;">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="text-left py-3 pr-4 text-gray-500 font-semibold text-sm">Title</th>
                    <th class="text-left py-3 pr-4 text-gray-500 font-semibold text-sm">Category</th>
                    <th class="text-left py-3 pr-4 text-gray-500 font-semibold text-sm">Date</th>
                    <th class="text-left py-3 pr-4 text-gray-500 font-semibold text-sm">Method</th>
                    <th class="text-left py-3 pr-4 text-gray-500 font-semibold text-sm">Amount</th>
                    <th class="text-right py-3 text-gray-500 font-semibold text-sm">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($purchases as $purchase)
                <tr class="border-b border-gray-50 last:border-0 hover:bg-gray-50/50 transition-colors">
                    <td class="py-3.5 pr-4">
                        <p class="font-semibold text-gray-900 text-sm">{{ $purchase->title }}</p>
                        @if($purchase->reference)
                        <p class="text-xs text-gray-400 font-mono">{{ $purchase->reference }}</p>
                        @endif
                    </td>
                    <td class="py-3.5 pr-4"><span class="text-xs bg-blue-50 text-blue-700 px-2.5 py-1 rounded-full font-medium">{{ $purchase->category }}</span></td>
                    <td class="py-3.5 pr-4 text-sm text-gray-600 whitespace-nowrap">{{ $purchase->purchase_date->format('M j, Y') }}</td>
                    <td class="py-3.5 pr-4 text-sm text-gray-600">{{ $purchase->payment_method ?? '—' }}</td>
                    <td class="py-3.5 pr-4 text-sm font-bold text-gray-900 whitespace-nowrap">{{ $purchase->formatted_amount }}</td>
                    <td class="py-3.5 text-right whitespace-nowrap">
                        <a href="{{ route('admin.finance.purchases.edit', $purchase) }}" title="Edit" class="inline-flex w-8 h-8 rounded-lg bg-gray-100 hover:bg-orange-50 text-gray-600 hover:text-orange-600 transition-colors items-center justify-center mr-1"><i class="bi bi-pencil"></i></a>
                        <button onclick="deletePurchase({{ $purchase->id }}, '{{ addslashes($purchase->title) }}')" title="Delete" class="inline-flex w-8 h-8 rounded-lg bg-gray-100 hover:bg-red-50 text-gray-600 hover:text-red-600 transition-colors items-center justify-center"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p class="text-gray-500 text-center py-8"><i class="bi bi-inbox mr-1"></i>No purchases recorded in this period.</p>
        @endif
    </div>
</div>

<!-- Expenses -->
<div class="bg-white rounded-xl border border-gray-100 shadow-sm mb-6 mx-1 md:mx-0">
    <div class="flex items-center justify-between p-6 pb-4">
        <div>
            <h2 class="text-lg font-bold text-gray-900"><i class="bi bi-receipt-cutoff mr-2 text-rose-500"></i>Expenses</h2>
            <p class="text-xs text-gray-400 mt-0.5">Running costs, marketing, salaries and other overheads</p>
        </div>
        <a href="{{ route('admin.finance.expenses.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-rose-600 text-white rounded-lg hover:bg-rose-700 font-semibold transition-all text-sm shadow-sm">
            <i class="bi bi-plus-lg"></i> Record Expense
        </a>
    </div>
    <div class="px-6 pb-6 overflow-x-auto" style="-webkit-overflow-scrolling: touch;">
        @if($expenses->count() > 0)
        <table class="w-full" style="min-width: 760px;">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="text-left py-3 pr-4 text-gray-500 font-semibold text-sm">Title</th>
                    <th class="text-left py-3 pr-4 text-gray-500 font-semibold text-sm">Category</th>
                    <th class="text-left py-3 pr-4 text-gray-500 font-semibold text-sm">Date</th>
                    <th class="text-left py-3 pr-4 text-gray-500 font-semibold text-sm">Method</th>
                    <th class="text-left py-3 pr-4 text-gray-500 font-semibold text-sm">Amount</th>
                    <th class="text-right py-3 text-gray-500 font-semibold text-sm">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($expenses as $expense)
                <tr class="border-b border-gray-50 last:border-0 hover:bg-gray-50/50 transition-colors">
                    <td class="py-3.5 pr-4">
                        <p class="font-semibold text-gray-900 text-sm">{{ $expense->title }}</p>
                        @if($expense->reference)
                        <p class="text-xs text-gray-400 font-mono">{{ $expense->reference }}</p>
                        @endif
                    </td>
                    <td class="py-3.5 pr-4"><span class="text-xs bg-rose-50 text-rose-700 px-2.5 py-1 rounded-full font-medium">{{ $expense->category }}</span></td>
                    <td class="py-3.5 pr-4 text-sm text-gray-600 whitespace-nowrap">{{ $expense->expense_date->format('M j, Y') }}</td>
                    <td class="py-3.5 pr-4 text-sm text-gray-600">{{ $expense->payment_method ?? '—' }}</td>
                    <td class="py-3.5 pr-4 text-sm font-bold text-gray-900 whitespace-nowrap">{{ $expense->formatted_amount }}</td>
                    <td class="py-3.5 text-right whitespace-nowrap">
                        <a href="{{ route('admin.finance.expenses.edit', $expense) }}" title="Edit" class="inline-flex w-8 h-8 rounded-lg bg-gray-100 hover:bg-orange-50 text-gray-600 hover:text-orange-600 transition-colors items-center justify-center mr-1"><i class="bi bi-pencil"></i></a>
                        <button onclick="deleteExpense({{ $expense->id }}, '{{ addslashes($expense->title) }}')" title="Delete" class="inline-flex w-8 h-8 rounded-lg bg-gray-100 hover:bg-red-50 text-gray-600 hover:text-red-600 transition-colors items-center justify-center"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p class="text-gray-500 text-center py-8"><i class="bi bi-inbox mr-1"></i>No expenses recorded in this period.</p>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // ---------- Chart rendering ----------
    const chartLabels = @json(array_column($chartData, 'label'));
    const salesData = @json(array_column($chartData, 'sales'));
    const purchasesChartData = @json(array_column($chartData, 'purchases'));
    const expensesChartData = @json(array_column($chartData, 'expenses'));
    const profitData = @json(array_column($chartData, 'profit'));
    const cumulativeData = @json(array_column($chartData, 'cumulative_sales'));

    const comparisonCtx = document.getElementById('comparisonChart');
    if (comparisonCtx) {
        new Chart(comparisonCtx, {
            type: 'bar',
            data: {
                labels: chartLabels,
                datasets: [
                    {
                        label: 'Sales',
                        data: salesData,
                        backgroundColor: 'rgba(16, 185, 129, 0.8)',
                        borderRadius: 6,
                        barPercentage: 0.85,
                    },
                    {
                        label: 'Purchases',
                        data: purchasesChartData,
                        backgroundColor: 'rgba(37, 99, 235, 0.8)',
                        borderRadius: 6,
                        barPercentage: 0.85,
                    },
                    {
                        label: 'Expenses',
                        data: expensesChartData,
                        backgroundColor: 'rgba(225, 29, 72, 0.8)',
                        borderRadius: 6,
                        barPercentage: 0.85,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { padding: 15, usePointStyle: true } },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.85)',
                        padding: 12,
                        callbacks: {
                            label: function(ctx) { return ' ' + ctx.dataset.label + ': ₦' + Number(ctx.parsed.y).toLocaleString(undefined, { minimumFractionDigits: 2 }); }
                        }
                    }
                },
                scales: {
                    y: { beginAtZero: true, grid: { color: 'rgba(0, 0, 0, 0.05)' }, ticks: { callback: function(v) { return '₦' + (v >= 1000 ? (v / 1000) + 'k' : v); } } },
                    x: { grid: { display: false } }
                }
            }
        });
    }

    const profitCtx = document.getElementById('profitChart');
    if (profitCtx) {
        new Chart(profitCtx, {
            type: 'line',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Net Profit',
                    data: profitData,
                    borderColor: '#1e3a8a',
                    backgroundColor: 'rgba(30, 58, 138, 0.12)',
                    tension: 0.4,
                    fill: true,
                    pointRadius: 3,
                    pointHoverRadius: 6,
                    pointBackgroundColor: '#f97316',
                    pointBorderColor: '#fff',
                    borderWidth: 2.5,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.85)',
                        padding: 12,
                        callbacks: {
                            label: function(ctx) { return ' ₦' + Number(ctx.parsed.y).toLocaleString(undefined, { minimumFractionDigits: 2 }); }
                        }
                    }
                },
                scales: {
                    y: { beginAtZero: true, grid: { color: 'rgba(0, 0, 0, 0.05)' }, ticks: { callback: function(v) { return '₦' + (v >= 1000 ? (v / 1000) + 'k' : v); } } },
                    x: { grid: { display: false } }
                }
            }
        });
    }

    const growthCtx = document.getElementById('growthChart');
    if (growthCtx) {
        new Chart(growthCtx, {
            type: 'line',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Cumulative Sales',
                    data: cumulativeData,
                    borderColor: '#f97316',
                    backgroundColor: 'rgba(249, 115, 22, 0.15)',
                    tension: 0.4,
                    fill: true,
                    pointRadius: 0,
                    pointHoverRadius: 6,
                    borderWidth: 2.5,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.85)',
                        padding: 12,
                        callbacks: {
                            label: function(ctx) { return ' ₦' + Number(ctx.parsed.y).toLocaleString(undefined, { minimumFractionDigits: 2 }); }
                        }
                    }
                },
                scales: {
                    y: { beginAtZero: true, grid: { color: 'rgba(0, 0, 0, 0.05)' }, ticks: { callback: function(v) { return '₦' + (v >= 1000 ? (v / 1000) + 'k' : v); } } },
                    x: { grid: { display: false } }
                }
            }
        });
    }

    const expenseCtx = document.getElementById('expenseChart');
    if (expenseCtx) {
        const breakdown = @json($expenseBreakdown);
        const hasData = breakdown.length > 0 && breakdown.some(b => Number(b.total) > 0);
        new Chart(expenseCtx, {
            type: 'doughnut',
            data: {
                labels: hasData ? breakdown.map(b => b.category) : ['No expenses'],
                datasets: [{
                    data: hasData ? breakdown.map(b => Number(b.total)) : [1],
                    backgroundColor: hasData
                        ? ['#f97316', '#eab308', '#1e3a8a', '#10b981', '#e11d48', '#3b82f6', '#8b5cf6', '#64748b', '#ef4444', '#14b8a6'].slice(0, breakdown.length)
                        : ['#e5e7eb'],
                    borderWidth: 2,
                    borderColor: '#fff',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                cutout: '62%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { padding: 12, usePointStyle: true, font: { size: 12 } }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.85)',
                        padding: 12,
                        callbacks: {
                            label: function(ctx) { return ' ' + ctx.label + ': ₦' + Number(ctx.parsed).toLocaleString(undefined, { minimumFractionDigits: 2 }); }
                        }
                    }
                }
            }
        });
    }

    // ---------- Delete actions ----------
    async function deleteExpense(id, title) {
        if (!confirm(`Delete expense "${title}"? This cannot be undone.`)) return;
        try {
            const data = await window.ajax(`{{ route("admin.finance.expenses.destroy", ":id") }}`.replace(':id', id), 'DELETE');
            window.toast(data.message, 'success');
            setTimeout(() => window.location.reload(), 900);
        } catch (error) {
            window.toast(error.message || 'Failed to delete expense', 'error');
        }
    }

    async function deletePurchase(id, title) {
        if (!confirm(`Delete purchase "${title}"? This cannot be undone.`)) return;
        try {
            const data = await window.ajax(`{{ route("admin.finance.purchases.destroy", ":id") }}`.replace(':id', id), 'DELETE');
            window.toast(data.message, 'success');
            setTimeout(() => window.location.reload(), 900);
        } catch (error) {
            window.toast(error.message || 'Failed to delete purchase', 'error');
        }
    }
</script>
@endpush
