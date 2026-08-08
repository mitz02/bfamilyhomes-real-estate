@extends('layouts.admin')

@section('title', $expense ? 'Edit Expense' : 'Record Expense')

@section('content')
@php $isEdit = (bool) $expense; @endphp

<div class="mb-8">
    <div class="flex items-center gap-2 text-xs md:text-sm text-gray-500 mb-4 px-2 md:px-0">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-orange-600 transition-colors">
            <i class="bi bi-house-door mr-1"></i>B-Family
        </a>
        <i class="bi bi-chevron-right text-xs"></i>
        <a href="{{ route('admin.finance') }}" class="hover:text-orange-600 transition-colors">Finance & Reports</a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-orange-600 font-semibold">{{ $isEdit ? 'Edit Expense' : 'Record Expense' }}</span>
    </div>

    <div class="relative bg-gradient-to-br from-rose-700 via-rose-600 to-rose-700 rounded-2xl p-6 md:p-8 shadow-lg overflow-hidden">
        <div class="absolute -top-10 -right-10 w-48 h-48 bg-white/5 rounded-full"></div>
        <div class="absolute -bottom-10 -left-10 w-36 h-36 bg-white/5 rounded-full"></div>

        <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-start gap-4">
                <div class="w-14 h-14 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center shadow-sm flex-shrink-0 border border-white/10">
                    <i class="bi bi-receipt-cutoff text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-bold text-white">{{ $isEdit ? 'Edit Expense' : 'Record New Expense' }}</h1>
                    <p class="text-rose-100/80 text-sm mt-0.5">{{ $isEdit ? 'Update this operating cost entry' : 'Add an operating cost — running costs, marketing, salaries and other overheads' }}</p>
                </div>
            </div>
            <a href="{{ route('admin.finance') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-white/10 border border-white/20 text-white rounded-lg hover:bg-white/20 font-semibold transition-all text-sm flex-shrink-0">
                <i class="bi bi-arrow-left"></i> Back to Reports
            </a>
        </div>
    </div>
</div>

@if($errors->any())
<div class="bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 mb-6 mx-1 md:mx-0 text-sm">
    <p class="font-semibold mb-1"><i class="bi bi-exclamation-triangle mr-1"></i>Please fix the following errors:</p>
    <ul class="list-disc list-inside space-y-0.5">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="bg-white rounded-xl border border-gray-100 shadow-sm mx-1 md:mx-0">
    <div class="p-6 border-b border-gray-100 flex items-center gap-3">
        <div class="w-9 h-9 bg-rose-100 rounded-lg flex items-center justify-center">
            <i class="bi bi-pencil-square text-rose-600"></i>
        </div>
        <div>
            <h2 class="font-bold text-gray-900">{{ $isEdit ? 'Expense Details' : 'Expense Information' }}</h2>
            <p class="text-xs text-gray-400">This amount counts against Total Expenses in your profit reports</p>
        </div>
    </div>

    <form method="POST" action="{{ $isEdit ? route('admin.finance.expenses.update', $expense) : route('admin.finance.expenses.store') }}" class="p-6 space-y-6">
        @csrf
        @if($isEdit)
        @method('PUT')
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Title *</label>
                <input type="text" name="title" value="{{ old('title', $expense?->title) }}"
                       placeholder="e.g. Facebook Ads, Generator fuel, Staff salaries"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-rose-500 focus:ring-1 focus:ring-rose-500 outline-none transition-all" required>
                @error('title')
                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Category *</label>
                <select name="category"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-rose-500 focus:ring-1 focus:ring-rose-500 outline-none transition-all" required>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ old('category', $expense?->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
                @error('category')
                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Amount (₦) *</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">₦</span>
                    <input type="number" name="amount" step="0.01" min="0" value="{{ old('amount', $expense?->amount) }}"
                           placeholder="0.00"
                           class="w-full border border-gray-200 rounded-lg pl-8 pr-3 py-2.5 text-sm focus:border-rose-500 focus:ring-1 focus:ring-rose-500 outline-none transition-all" required>
                </div>
                @error('amount')
                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Expense Date *</label>
                <input type="date" name="expense_date" value="{{ old('expense_date', $expense?->expense_date?->format('Y-m-d') ?? now()->toDateString()) }}"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-rose-500 focus:ring-1 focus:ring-rose-500 outline-none transition-all" required>
                @error('expense_date')
                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Payment Method</label>
                <input type="text" name="payment_method" value="{{ old('payment_method', $expense?->payment_method) }}"
                       list="paymentMethods" placeholder="e.g. Bank transfer"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-rose-500 focus:ring-1 focus:ring-rose-500 outline-none transition-all">
                <datalist id="paymentMethods">
                    <option value="Bank transfer"></option>
                    <option value="Cash"></option>
                    <option value="POS / Debit Card"></option>
                    <option value="Cheque"></option>
                </datalist>
                @error('payment_method')
                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Reference (optional)</label>
                <input type="text" name="reference" value="{{ old('reference', $expense?->reference) }}"
                       placeholder="e.g. INV-00123, RCP-0042"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-rose-500 focus:ring-1 focus:ring-rose-500 outline-none transition-all">
                @error('reference')
                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Notes</label>
                <textarea name="notes" rows="3"
                          class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-rose-500 focus:ring-1 focus:ring-rose-500 outline-none transition-all">{{ old('notes', $expense?->notes) }}</textarea>
                <p class="text-xs text-gray-400 mt-1">Optional notes about this expense</p>
                @error('notes')
                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
            <button type="submit"
                    class="px-6 py-2.5 bg-gradient-to-r from-rose-600 to-rose-500 text-white rounded-xl hover:from-rose-700 hover:to-rose-600 font-semibold transition-all text-sm shadow-sm inline-flex items-center gap-2">
                <i class="bi bi-check-lg"></i>
                {{ $isEdit ? 'Update Expense' : 'Record Expense' }}
            </button>
            <a href="{{ route('admin.finance') }}"
               class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 font-semibold transition-all text-sm">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
