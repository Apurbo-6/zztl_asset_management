@extends('layouts.app')

@section('title', 'Add Purchase')
@section('breadcrumb', 'Add Purchase')

@section('content')

    <div class="mx-auto max-w-7xl space-y-6">

        <!-- Header -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <div class="text-xs font-bold tracking-widest text-blue-600">
                    PURCHASE MANAGEMENT
                </div>

                <h1 class="mt-1 text-2xl font-bold text-slate-900">
                    Add Purchase
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Record one invoice with multiple items. Serial numbers are required only for configured categories.
                </p>

            </div>

            <a href="{{ route('purchases.index') }}"
                class="rounded-xl border border-slate-300 px-5 py-3 text-center text-sm font-semibold text-slate-600 transition hover:bg-white">

                ← Back

            </a>

        </div>


        <form method="POST" enctype="multipart/form-data" action="{{ route('purchases.store') }}" id="purchaseForm" class="space-y-6">

            @csrf


            <!-- Purchase Information -->
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <h2 class="text-lg font-bold text-slate-900">
                    Purchase Information
                </h2>

                <div class="mt-6 grid gap-5 md:grid-cols-3">


                    <!-- Supplier -->
                    <div>

                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Supplier
                        </label>

                        <select name="supplier_id"
                            class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

                            <option value="">
                                Select Supplier
                            </option>

                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" @selected(old('supplier_id') == $supplier->id)>

                                    {{ $supplier->name }}

                                </option>
                            @endforeach

                        </select>

                    </div>


                    <!-- Invoice -->
                    <div>

                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Invoice Number
                        </label>

                        <input type="text" name="invoice_no" value="{{ old('invoice_no') }}" placeholder="INV26000839"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

                    </div>


                    <!-- Date -->
                    <div>

                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Purchase Date <span class="text-red-500">*</span>
                        </label>

                        <input type="datetime-local" name="purchase_date"
                            value="{{ old('purchase_date', now()->format('Y-m-d\\TH:i')) }}" required
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

                    </div>

                </div>

                <div class="mt-5 grid gap-5 md:grid-cols-3">
                    <div><label class="mb-2 block text-sm font-semibold text-slate-700">Delivery / Shipping Charge</label><input type="number" name="shipping_charge" min="0" step="0.01" value="{{ old('shipping_charge', 0) }}" class="invoice-charge w-full rounded-xl border border-slate-300 px-4 py-3 text-sm"></div>
                    <div><label class="mb-2 block text-sm font-semibold text-slate-700">Extra Charge</label><input type="number" name="extra_charge" min="0" step="0.01" value="{{ old('extra_charge', 0) }}" class="invoice-charge w-full rounded-xl border border-slate-300 px-4 py-3 text-sm"></div>
                    <div><label class="mb-2 block text-sm font-semibold text-slate-700">Extra Charge Description</label><input type="text" name="extra_charge_description" maxlength="255" value="{{ old('extra_charge_description') }}" placeholder="e.g. Installation" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm"></div>
                </div>

                <div class="mt-5">
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Invoice Scan (PDF or image, up to 10 files)</label>
                    <input type="file" name="invoice_files[]" multiple accept=".pdf,.jpg,.jpeg,.png,.webp" class="block w-full text-sm text-slate-600">
                    <p class="mt-1 text-xs text-slate-500">Images are resized and converted to WebP when supported. PDFs are stored as uploaded.</p>
                </div>


                <!-- Remarks -->
                <div class="mt-5">

                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Purchase Remarks
                    </label>

                    <textarea name="remarks" rows="3" placeholder="Optional remarks about this invoice..."
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100">{{ old('remarks') }}</textarea>

                </div>

            </div>


            <!-- Asset Items -->
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

                <div
                    class="flex flex-col gap-4 border-b border-slate-200 p-6 sm:flex-row sm:items-center sm:justify-between">

                    <div>

                        <h2 class="text-lg font-bold text-slate-900">
                            Asset Items
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            Add each invoice line. For serial tracked categories, add one asset per line and enter its serial number.
                        </p>

                    </div>


                    <button type="button" id="addItem"
                        class="rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-200 transition hover:bg-blue-700">

                        + Add Item

                    </button>

                </div>


                <div id="itemsContainer" class="space-y-5 p-6">


                    <!-- First Item -->
                    <div class="item-row rounded-xl border border-slate-200 bg-slate-50 p-5">

                        <div class="mb-4 flex items-center justify-between">

                            <div class="item-number font-bold text-slate-700">
                                Item #1
                            </div>

                            <button type="button"
                                class="remove-item hidden rounded-lg px-3 py-2 text-sm font-semibold text-red-600 hover:bg-red-50">

                                Remove

                            </button>

                        </div>


                        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">


                            <!-- Category -->
                            <div>

                                <label class="mb-2 block text-xs font-bold text-slate-600">
                                    Category *
                                </label>

                                <select name="items[0][category_id]" required
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-3 text-sm">

                                    <option value="">
                                        Select Category
                                    </option>

                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" data-unit="{{ $category->unit }}" data-serial-required="{{ $category->serial_required ? '1' : '0' }}">
                                            {{ $category->name }} ({{ $category->code }})
                                        </option>
                                    @endforeach

                                </select>

                            </div>


                            <!-- Item -->
                            <div>

                                <label class="mb-2 block text-xs font-bold text-slate-600">
                                    Asset Name *
                                </label>

                                <input type="text" name="items[0][particular_items]" required
                                    placeholder="Laptop / Monitor"
                                    class="w-full rounded-lg border border-slate-300 px-3 py-3 text-sm">

                            </div>


                            <!-- Brand -->
                            <div>

                                <label class="mb-2 block text-xs font-bold text-slate-600">
                                    Brand
                                </label>

                                <input type="text" name="items[0][brand_name]" placeholder="HP / Lenovo"
                                    class="w-full rounded-lg border border-slate-300 px-3 py-3 text-sm">

                            </div>


                            <!-- Serial -->
                            <div class="serial-field">

                                <label class="mb-2 block text-xs font-bold text-slate-600">
                                    Serial Number
                                </label>

                                <input type="text" name="items[0][serial_number]" placeholder="Device serial number"
                                    class="w-full rounded-lg border border-slate-300 px-3 py-3 text-sm">

                            </div>


                            <!-- Qty -->
                            <div>

                                <label class="mb-2 block text-xs font-bold text-slate-600">
                                    Quantity (<span class="quantity-unit">unit</span>) *
                                </label>

                                <input type="number" step="0.01" min="0.01" value="1" name="items[0][qty]" required class="quantity-input w-full rounded-lg border border-slate-300 px-3 py-3 text-sm">

                            </div>


                            <!-- Unit Price -->
                            <div>

                                <label class="mb-2 block text-xs font-bold text-slate-600">
                                    Unit Price *
                                </label>

                                <input type="number" step="0.01" min="0" name="items[0][unit_price]" required
                                    placeholder="0.00" class="unit-price-input w-full rounded-lg border border-slate-300 px-3 py-3 text-sm">
                                <p class="mt-1 text-xs text-slate-500">Line total: <span class="line-total">0.00</span></p>

                            </div>


                            <!-- Warranty -->
                            <div>

                                <label class="mb-2 block text-xs font-bold text-slate-600">
                                    Warranty
                                </label>

                                <input type="text" name="items[0][warranty]" placeholder="2 Years"
                                    class="w-full rounded-lg border border-slate-300 px-3 py-3 text-sm">

                            </div>


                            <!-- Remarks -->
                            <div>

                                <label class="mb-2 block text-xs font-bold text-slate-600">
                                    Item Remarks
                                </label>

                                <input type="text" name="items[0][remarks]" placeholder="Optional remarks"
                                    class="w-full rounded-lg border border-slate-300 px-3 py-3 text-sm">

                            </div>

                        </div>

                    </div>

                </div>


                <div class="border-t border-slate-200 bg-slate-50 p-6 text-right">
                    <span class="text-sm font-semibold text-slate-600">Invoice Total</span>
                    <span id="invoice-total" class="ml-3 text-xl font-bold text-slate-900">0.00</span>
                </div>

                <!-- Footer -->
                <div class="flex flex-col gap-3 border-t border-slate-200 p-6 sm:flex-row sm:justify-end">

                    <a href="{{ route('purchases.index') }}"
                        class="rounded-xl border border-slate-300 px-6 py-3 text-center text-sm font-semibold text-slate-600">

                        Cancel

                    </a>

                    <button type="submit"
                        class="rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-200 transition hover:bg-blue-700">

                        Save Purchase & Assets

                    </button>

                </div>

            </div>

        </form>

    </div>


    <!-- Template -->
    <template id="itemTemplate">

        <div class="item-row rounded-xl border border-slate-200 bg-slate-50 p-5">

            <div class="mb-4 flex items-center justify-between">

                <div class="item-number font-bold text-slate-700">
                    Item
                </div>

                <button type="button"
                    class="remove-item rounded-lg px-3 py-2 text-sm font-semibold text-red-600 hover:bg-red-50">

                    Remove

                </button>

            </div>


            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">

                <div>

                    <label class="mb-2 block text-xs font-bold text-slate-600">
                        Category *
                    </label>

                    <select data-name="category_id" required
                        class="w-full rounded-lg border border-slate-300 bg-white px-3 py-3 text-sm">

                        <option value="">
                            Select Category
                        </option>

                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" data-unit="{{ $category->unit }}" data-serial-required="{{ $category->serial_required ? '1' : '0' }}">
                                {{ $category->name }} ({{ $category->code }})
                            </option>
                        @endforeach

                    </select>

                </div>


                <div>

                    <label class="mb-2 block text-xs font-bold text-slate-600">
                        Asset Name *
                    </label>

                    <input type="text" data-name="particular_items" required
                        class="w-full rounded-lg border border-slate-300 px-3 py-3 text-sm">

                </div>


                <div>

                    <label class="mb-2 block text-xs font-bold text-slate-600">
                        Brand
                    </label>

                    <input type="text" data-name="brand_name"
                        class="w-full rounded-lg border border-slate-300 px-3 py-3 text-sm">

                </div>


                <div class="serial-field">

                    <label class="mb-2 block text-xs font-bold text-slate-600">
                        Serial Number
                    </label>

                    <input type="text" data-name="serial_number"
                        class="w-full rounded-lg border border-slate-300 px-3 py-3 text-sm">

                </div>


                <div>

                    <label class="mb-2 block text-xs font-bold text-slate-600">
                        Quantity (<span class="quantity-unit">unit</span>) *
                    </label>

                    <input type="number" data-name="qty" value="1" min="0.01" step="0.01" required
                        class="quantity-input w-full rounded-lg border border-slate-300 px-3 py-3 text-sm">

                </div>


                <div>

                    <label class="mb-2 block text-xs font-bold text-slate-600">
                        Unit Price *
                    </label>

                    <input type="number" data-name="unit_price" min="0" step="0.01" required
                        class="unit-price-input w-full rounded-lg border border-slate-300 px-3 py-3 text-sm">
                    <p class="mt-1 text-xs text-slate-500">Line total: <span class="line-total">0.00</span></p>

                </div>


                <div>

                    <label class="mb-2 block text-xs font-bold text-slate-600">
                        Warranty
                    </label>

                    <input type="text" data-name="warranty"
                        class="w-full rounded-lg border border-slate-300 px-3 py-3 text-sm">

                </div>


                <div>

                    <label class="mb-2 block text-xs font-bold text-slate-600">
                        Item Remarks
                    </label>

                    <input type="text" data-name="remarks"
                        class="w-full rounded-lg border border-slate-300 px-3 py-3 text-sm">

                </div>

            </div>

        </div>

    </template>


    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const container = document.getElementById('itemsContainer');

            const template = document.getElementById('itemTemplate');

            const addButton = document.getElementById('addItem');

            function refreshTotals() {
                let itemsTotal = 0;
                container.querySelectorAll('.item-row').forEach(row => {
                    const quantity = parseFloat(row.querySelector('.quantity-input')?.value) || 0;
                    const unitPrice = parseFloat(row.querySelector('.unit-price-input')?.value) || 0;
                    const lineTotal = quantity * unitPrice;
                    row.querySelector('.line-total').textContent = lineTotal.toFixed(2);
                    itemsTotal += lineTotal;
                });
                const shipping = parseFloat(document.querySelector('[name="shipping_charge"]').value) || 0;
                const extra = parseFloat(document.querySelector('[name="extra_charge"]').value) || 0;
                document.getElementById('invoice-total').textContent = (itemsTotal + shipping + extra).toFixed(2);
            }

            function updateCategory(row) {
                const select = row.querySelector('select[name$="[category_id]"]');
                const option = select?.selectedOptions[0];
                row.querySelector('.quantity-unit').textContent = option?.dataset.unit || 'unit';
                const serialWrap = row.querySelector('.serial-field');
                const serialInput = serialWrap?.querySelector('input');
                const required = option?.dataset.serialRequired === '1';
                if (serialWrap && serialInput) {
                    serialWrap.classList.toggle('hidden', !required);
                    serialInput.required = required;
                    serialInput.placeholder = required ? 'Required device serial number' : 'Not required';
                    if (!required) serialInput.value = '';
                }
                const quantityInput = row.querySelector('.quantity-input');
                quantityInput.readOnly = required;
                quantityInput.max = required ? '1' : '';
                if (required) quantityInput.value = '1';
                refreshTotals();
            }

            container.addEventListener('input', refreshTotals);
            container.addEventListener('change', event => {
                if (event.target.matches('select[name$="[category_id]"]')) updateCategory(event.target.closest('.item-row'));
                refreshTotals();
            });
            document.querySelectorAll('.invoice-charge').forEach(field => field.addEventListener('input', refreshTotals));
            container.querySelectorAll('.item-row').forEach(updateCategory);
            refreshTotals();


            function updateNumbers() {

                const items = container.querySelectorAll('.item-row');

                items.forEach((item, index) => {

                    item.querySelector('.item-number').textContent =
                        'Item #' + (index + 1);

                    const removeButton =
                        item.querySelector('.remove-item');

                    if (removeButton) {

                        removeButton.classList.toggle(
                            'hidden',
                            items.length === 1
                        );

                    }

                });

            }


            addButton.addEventListener('click', function() {

                const index =
                    container.querySelectorAll('.item-row').length;

                const clone =
                    template.content.cloneNode(true);

                clone.querySelectorAll('[data-name]').forEach(function(field) {

                    const fieldName =
                        field.getAttribute('data-name');

                    field.name =
                        `items[${index}][${fieldName}]`;

                });

                container.appendChild(clone);

                const newRow = container.lastElementChild;
                updateCategory(newRow);

                updateNumbers();

            });


            container.addEventListener('click', function(event) {

                if (
                    event.target.classList.contains('remove-item')
                ) {

                    event.target
                        .closest('.item-row')
                        .remove();

                    /*
                    |--------------------------------------------------------------------------
                    | Re-index input names
                    |--------------------------------------------------------------------------
                    */

                    container
                        .querySelectorAll('.item-row')
                        .forEach(function(item, index) {

                            item
                                .querySelectorAll('input, select, textarea')
                                .forEach(function(field) {

                                    const name =
                                        field.name;

                                    if (name) {

                                        field.name =
                                            name.replace(
                                                /items\[\d+\]/,
                                                `items[${index}]`
                                            );

                                    }

                                });

                        });

                    updateNumbers();

                }

            });

        });
    </script>

@endsection
