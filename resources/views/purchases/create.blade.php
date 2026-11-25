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
                    Create one purchase invoice and add individual assets with serial numbers.
                </p>

            </div>

            <a href="{{ route('purchases.index') }}"
                class="rounded-xl border border-slate-300 px-5 py-3 text-center text-sm font-semibold text-slate-600 transition hover:bg-white">

                ← Back

            </a>

        </div>


        <form method="POST" action="{{ route('purchases.store') }}" id="purchaseForm" class="space-y-6">

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

                        <input type="date" name="purchase_date"
                            value="{{ old('purchase_date', now()->format('Y-m-d')) }}" required
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

                    </div>

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
                            Add each individual asset. Each asset can have its own serial number.
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
                                        <option value="{{ $category->id }}">
                                            {{ $category->name }}
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
                            <div>

                                <label class="mb-2 block text-xs font-bold text-slate-600">
                                    Serial Number
                                </label>

                                <input type="text" name="items[0][serial_number]" placeholder="Device serial number"
                                    class="w-full rounded-lg border border-slate-300 px-3 py-3 text-sm">

                            </div>


                            <!-- Qty -->
                            <div>

                                <label class="mb-2 block text-xs font-bold text-slate-600">
                                    Quantity *
                                </label>

                                <input type="number" step="1" min="1" value="1" name="items[0][qty]"
                                    readonly required
                                    class="w-full rounded-lg border border-slate-300 px-3 py-3 text-sm cursor-not-allowed">

                            </div>


                            <!-- Unit Price -->
                            <div>

                                <label class="mb-2 block text-xs font-bold text-slate-600">
                                    Unit Price *
                                </label>

                                <input type="number" step="0.01" min="0" name="items[0][unit_price]" required
                                    placeholder="0.00" class="w-full rounded-lg border border-slate-300 px-3 py-3 text-sm">

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
                            <option value="{{ $category->id }}">
                                {{ $category->name }}
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


                <div>

                    <label class="mb-2 block text-xs font-bold text-slate-600">
                        Serial Number
                    </label>

                    <input type="text" data-name="serial_number"
                        class="w-full rounded-lg border border-slate-300 px-3 py-3 text-sm">

                </div>


                <div>

                    <label class="mb-2 block text-xs font-bold text-slate-600">
                        Quantity *
                    </label>

                    <input type="number" data-name="qty" value="1" min="1" required
                        class="w-full rounded-lg border border-slate-300 px-3 py-3 text-sm">

                </div>


                <div>

                    <label class="mb-2 block text-xs font-bold text-slate-600">
                        Unit Price *
                    </label>

                    <input type="number" data-name="unit_price" min="0" step="0.01" required
                        class="w-full rounded-lg border border-slate-300 px-3 py-3 text-sm">

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
