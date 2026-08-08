@extends('layouts.admin')

@section('title', 'Record Sale')

@section('content')
<div class="mb-8">
    <div class="flex items-center gap-2 text-xs md:text-sm text-gray-500 mb-4 px-2 md:px-0">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-orange-600 transition-colors">
            <i class="bi bi-house-door mr-1"></i>B-Family
        </a>
        <i class="bi bi-chevron-right text-xs"></i>
        <a href="{{ route('admin.sales') }}" class="hover:text-orange-600 transition-colors">Sales</a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-orange-600 font-semibold">Record Sale</span>
    </div>

    <div class="relative bg-gradient-to-br from-blue-900 via-blue-800 to-blue-900 rounded-2xl p-6 md:p-8 shadow-lg overflow-hidden">
        <div class="absolute -top-10 -right-10 w-48 h-48 bg-white/5 rounded-full"></div>
        <div class="absolute -bottom-10 -left-10 w-36 h-36 bg-white/5 rounded-full"></div>

        <div class="relative flex items-start gap-4">
            <div class="w-14 h-14 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center shadow-sm flex-shrink-0 border border-white/10">
                <i class="bi bi-plus-circle text-white text-2xl"></i>
            </div>
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-white">Record New Sale</h1>
                <p class="text-blue-100/80 text-sm mt-0.5">Manually record a property sale transaction</p>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl border border-gray-100 shadow-sm mx-1 md:mx-0">
    <form method="POST" action="{{ route('admin.sales.store') }}" class="p-6 space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Buyer Type</label>
                <div class="inline-flex rounded-lg border border-gray-200 bg-gray-50 p-1 gap-1">
                    <button type="button" id="btnExistingUser" onclick="setBuyerType('existing')"
                            class="px-4 py-2 rounded-lg text-sm font-semibold transition-all bg-white shadow-sm border border-gray-200 text-orange-600">
                        <i class="bi bi-person-check mr-1"></i>Registered User
                    </button>
                    <button type="button" id="btnNewBuyer" onclick="setBuyerType('new')"
                            class="px-4 py-2 rounded-lg text-sm font-semibold transition-all text-gray-500 hover:text-gray-700">
                        <i class="bi bi-person-plus mr-1"></i>New / Walk-in Buyer
                    </button>
                </div>
            </div>

            <div id="existingUserPanel" class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Registered Buyer *</label>
                <select name="user_id" id="userSelect"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all">
                    <option value="">Select Buyer</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div id="newBuyerPanel" class="md:col-span-2 hidden">
                <div class="rounded-xl border border-orange-100 bg-orange-50/40 p-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Buyer Full Name *</label>
                        <input type="text" name="buyer_name" id="buyerName"
                               value="{{ old('buyer_name') }}" placeholder="e.g. John Doe"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Buyer Email *</label>
                        <input type="email" name="buyer_email" id="buyerEmail"
                               value="{{ old('buyer_email') }}" placeholder="e.g. john@example.com"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Buyer Phone *</label>
                        <input type="text" name="buyer_phone" id="buyerPhone"
                               value="{{ old('buyer_phone') }}" placeholder="e.g. 08012345678"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Buyer Address</label>
                        <input type="text" name="buyer_address" id="buyerAddress"
                               value="{{ old('buyer_address') }}" placeholder="e.g. 12 Adeola Street, Lagos"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all">
                    </div>
                </div>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Property Source</label>
                <div class="inline-flex rounded-lg border border-gray-200 bg-gray-50 p-1 gap-1">
                    <button type="button" id="btnExistingProperty" onclick="setPropertyType('existing')"
                            class="px-4 py-2 rounded-lg text-sm font-semibold transition-all bg-white shadow-sm border border-gray-200 text-orange-600">
                        <i class="bi bi-building mr-1"></i>Select Property
                    </button>
                    <button type="button" id="btnNewProperty" onclick="setPropertyType('new')"
                            class="px-4 py-2 rounded-lg text-sm font-semibold transition-all text-gray-500 hover:text-gray-700">
                        <i class="bi bi-building-add mr-1"></i>Add New Property
                    </button>
                </div>
            </div>

            <div id="existingPropertyPanel" class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Property *</label>
                <select name="property_id" id="propertySelect"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all">
                    <option value="">Select Property</option>
                    @foreach($properties as $property)
                        <option value="{{ $property->id }}" data-price="{{ $property->price }}"
                            {{ old('property_id') == $property->id ? 'selected' : '' }}>
                            {{ $property->title }} - {{ $property->location }} ({{ $property->formatted_price }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div id="newPropertyPanel" class="md:col-span-2 hidden">
                <div class="rounded-xl border border-orange-100 bg-orange-50/40 p-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Property Title *</label>
                        <input type="text" name="new_property_title" id="newPropertyTitle"
                               value="{{ old('new_property_title') }}" placeholder="e.g. Luxury 3 Bedroom Duplex"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Location *</label>
                        <input type="text" name="new_property_location" id="newPropertyLocation"
                               value="{{ old('new_property_location') }}" placeholder="e.g. Lekki Phase 1, Lagos"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Address</label>
                        <input type="text" name="new_property_address"
                               value="{{ old('new_property_address') }}" placeholder="e.g. 5 Admiralty Way, Lekki"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Category *</label>
                        <select name="new_property_category" id="newPropertyCategory"
                                class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all">
                            <option value="">Select Category</option>
                            @foreach(['Studio Apartment', '1 Bedroom', '2 Bedroom', '3 Bedroom', '4 Bedroom', '5 Bedroom', 'Duplex', 'Bungalow', 'Commercial', 'Land', 'Shortlet'] as $cat)
                                <option value="{{ $cat }}" {{ old('new_property_category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Amount (₦) *</label>
                <input type="number" name="amount" id="amountInput" step="0.01" min="0"
                       value="{{ old('amount') }}"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all" required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Sale Date & Time *</label>
                <input type="datetime-local" name="sale_date" value="{{ old('sale_date', now()->format('Y-m-d\TH:i')) }}"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all" required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Payment Method *</label>
                <select name="payment_method" required
                        class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all">
                    <option value="">Select Method</option>
                    <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                    <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                    <option value="pos" {{ old('payment_method') == 'pos' ? 'selected' : '' }}>POS / Debit Card</option>
                    <option value="cheque" {{ old('payment_method') == 'cheque' ? 'selected' : '' }}>Cheque</option>
                    <option value="installment" {{ old('payment_method') == 'installment' ? 'selected' : '' }}>Installment</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Sale Type</label>
                <select name="type"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all">
                    <option value="purchase" {{ old('type') == 'purchase' ? 'selected' : '' }}>Purchase</option>
                    <option value="rent" {{ old('type') == 'rent' ? 'selected' : '' }}>Rent</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Staff Notes</label>
            <textarea name="staff_notes" rows="3"
                      class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all">{{ old('staff_notes') }}</textarea>
            <p class="text-xs text-gray-400 mt-1">Optional notes about this transaction</p>
        </div>

        <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
            <button type="submit"
                    class="px-6 py-2.5 bg-gradient-to-r from-orange-500 to-yellow-500 text-white rounded-xl hover:from-orange-600 hover:to-yellow-600 font-semibold transition-all text-sm shadow-sm inline-flex items-center gap-2">
                <i class="bi bi-check-lg"></i>
                Record Sale & Generate Receipt
            </button>
            <a href="{{ route('admin.sales') }}"
               class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 font-semibold transition-all text-sm">
                Cancel
            </a>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function setBuyerType(type) {
        var existingPanel = document.getElementById('existingUserPanel');
        var newPanel = document.getElementById('newBuyerPanel');
        var btnExisting = document.getElementById('btnExistingUser');
        var btnNew = document.getElementById('btnNewBuyer');
        var userSelect = document.getElementById('userSelect');
        var fields = ['buyerName', 'buyerEmail', 'buyerPhone'];

        if (type === 'new') {
            newPanel.classList.remove('hidden');
            existingPanel.classList.add('hidden');
            btnNew.classList.add('bg-white', 'shadow-sm', 'border', 'border-gray-200', 'text-orange-600');
            btnNew.classList.remove('text-gray-500');
            btnExisting.classList.remove('bg-white', 'shadow-sm', 'border', 'border-gray-200', 'text-orange-600');
            btnExisting.classList.add('text-gray-500');
            userSelect.removeAttribute('required');
            userSelect.value = '';
            fields.forEach(function(id) {
                document.getElementById(id).setAttribute('required', 'required');
            });
        } else {
            newPanel.classList.add('hidden');
            existingPanel.classList.remove('hidden');
            btnExisting.classList.add('bg-white', 'shadow-sm', 'border', 'border-gray-200', 'text-orange-600');
            btnExisting.classList.remove('text-gray-500');
            btnNew.classList.remove('bg-white', 'shadow-sm', 'border', 'border-gray-200', 'text-orange-600');
            btnNew.classList.add('text-gray-500');
            userSelect.setAttribute('required', 'required');
            fields.forEach(function(id) {
                document.getElementById(id).removeAttribute('required');
            });
        }
    }

    @if(old('buyer_name') || old('buyer_email') || old('buyer_phone'))
    setBuyerType('new');
    @endif

    function setPropertyType(type) {
        var existingPanel = document.getElementById('existingPropertyPanel');
        var newPanel = document.getElementById('newPropertyPanel');
        var btnExisting = document.getElementById('btnExistingProperty');
        var btnNew = document.getElementById('btnNewProperty');
        var propertySelect = document.getElementById('propertySelect');
        var fields = ['newPropertyTitle', 'newPropertyLocation', 'newPropertyCategory'];

        if (type === 'new') {
            newPanel.classList.remove('hidden');
            existingPanel.classList.add('hidden');
            btnNew.classList.add('bg-white', 'shadow-sm', 'border', 'border-gray-200', 'text-orange-600');
            btnNew.classList.remove('text-gray-500');
            btnExisting.classList.remove('bg-white', 'shadow-sm', 'border', 'border-gray-200', 'text-orange-600');
            btnExisting.classList.add('text-gray-500');
            propertySelect.removeAttribute('required');
            propertySelect.value = '';
            fields.forEach(function(id) {
                document.getElementById(id).setAttribute('required', 'required');
            });
        } else {
            newPanel.classList.add('hidden');
            existingPanel.classList.remove('hidden');
            btnExisting.classList.add('bg-white', 'shadow-sm', 'border', 'border-gray-200', 'text-orange-600');
            btnExisting.classList.remove('text-gray-500');
            btnNew.classList.remove('bg-white', 'shadow-sm', 'border', 'border-gray-200', 'text-orange-600');
            btnNew.classList.add('text-gray-500');
            propertySelect.setAttribute('required', 'required');
            fields.forEach(function(id) {
                document.getElementById(id).removeAttribute('required');
            });
        }
    }

    @if(old('new_property_title') || old('new_property_location') || old('new_property_category'))
    setPropertyType('new');
    @endif

    document.getElementById('propertySelect').addEventListener('change', function() {
        var selected = this.options[this.selectedIndex];
        var price = selected.getAttribute('data-price');
        if (price) {
            document.getElementById('amountInput').value = price;
        }
    });

    @if(old('property_id'))
    document.getElementById('propertySelect').dispatchEvent(new Event('change'));
    @endif
</script>
@endpush
@endsection
