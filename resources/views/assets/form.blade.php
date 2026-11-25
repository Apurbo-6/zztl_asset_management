@extends('layouts.app')

@section('title', $asset->exists ? 'Edit Purchase' : 'Add Purchase')
@section('breadcrumb', 'Purchase Register')

@section('content')

<div class="mx-auto max-w-7xl">

    <!-- Page Header -->
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

        <div>
            <div class="mb-2 text-xs font-bold tracking-[0.2em] text-blue-600">
                PURCHASE REGISTER
            </div>

            <h1 class="text-2xl font-bold text-slate-900 sm:text-3xl">
                {{ $asset->exists ? 'Edit Purchase' : 'Add Purchase' }}
            </h1>

            <p class="mt-2 text-sm text-slate-500">
                Enter the purchase details exactly as shown on the invoice/register.
            </p>
        </div>

        <a
            href="{{ $asset->exists ? route('assets.show', $asset) : route('assets.index') }}"
            class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">

            ← Back
        </a>

    </div>


    <!-- Form -->
    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

        <form
            method="POST"
            enctype="multipart/form-data"
            action="{{ $asset->exists ? route('assets.update', $asset) : route('assets.store') }}">

            @csrf

            @if($asset->exists)
            @method('PUT')
            @endif


            <div class="border-b border-slate-200 px-6 py-5 sm:px-8">

                <h2 class="text-lg font-bold text-slate-900">
                    Purchase Information
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Fields marked with * are required.
                </p>

            </div>


            <div class="space-y-8 px-6 py-6 sm:px-8">

                <!-- Basic Information -->
                <div>

                    <h3 class="mb-5 text-sm font-bold uppercase tracking-wider text-slate-700">
                        Basic Information
                    </h3>

                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-3">

                        <!-- Particular Items -->
                        <div class="lg:col-span-2">

                            <label class="mb-2 block text-sm font-semibold text-slate-700">
                                Particular Items <span class="text-red-500">*</span>
                            </label>

                            <input
                                type="text"
                                name="particular_items"
                                required
                                maxlength="255"
                                value="{{ old('particular_items', $asset->particular_items) }}"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

                        </div>


                        <!-- Category -->
                        <div>

                            <label class="mb-2 block text-sm font-semibold text-slate-700">
                                Category <span class="text-red-500">*</span>
                            </label>

                            <select
                                name="category_id"
                                id="category_id"
                                required
                                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

                                <option value="">Select category</option>

                                @foreach($categories as $c)

                                <option
                                    value="{{ $c->id }}"
                                    data-unit="{{ $c->unit }}"
                                    data-serial-required="{{ $c->serial_required ? '1' : '0' }}"
                                    @selected(old('category_id', $asset->category_id) == $c->id)>

                                    {{ $c->name }} ({{ $c->code }})

                                </option>

                                @endforeach

                            </select>

                        </div>


                        <!-- Supplier -->
                        <div>

                            <label class="mb-2 block text-sm font-semibold text-slate-700">
                                Purchased From
                            </label>

                            <select
                                name="supplier_id"
                                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

                                <option value="">Select supplier</option>

                                @foreach($suppliers as $s)

                                <option
                                    value="{{ $s->id }}"
                                    @selected(old('supplier_id', $asset->supplier_id) == $s->id)>

                                    {{ $s->name }}

                                </option>

                                @endforeach

                            </select>

                        </div>


                        <!-- Purchase Date -->
                        <div>

                            <label class="mb-2 block text-sm font-semibold text-slate-700">
                                Purchase Date <span class="text-red-500">*</span>
                            </label>

                            <input
                                type="date"
                                name="purchase_date"
                                required
                                value="{{ old('purchase_date', $asset->purchase_date?->format('Y-m-d')) }}"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

                        </div>


                        <!-- Invoice -->
                        <div>

                            <label class="mb-2 block text-sm font-semibold text-slate-700">
                                Invoice No
                            </label>

                            <input
                                type="text"
                                name="invoice_no"
                                value="{{ old('invoice_no', $asset->invoice_no) }}"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

                        </div>

                    </div>

                </div>


                <!-- Item Details -->
                <div class="border-t border-slate-200 pt-8">

                    <h3 class="mb-5 text-sm font-bold uppercase tracking-wider text-slate-700">
                        Item Details
                    </h3>

                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-3">

                        <div class="serial-field">

                            <label class="mb-2 block text-sm font-semibold text-slate-700">
                                Serial Number
                            </label>

                            <input
                                name="serial_number"
                                id="serial_number"
                                value="{{ old('serial_number', $asset->serial_number) }}"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

                        </div>


                        <div>

                            <label class="mb-2 block text-sm font-semibold text-slate-700">
                                Brand Name
                            </label>

                            <input
                                name="brand_name"
                                value="{{ old('brand_name', $asset->brand_name) }}"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

                        </div>


                        <div>

                            <label class="mb-2 block text-sm font-semibold text-slate-700">
                                Warranty
                            </label>

                            <input
                                name="warranty"
                                placeholder="e.g. 1 Year, 6 Months"
                                value="{{ old('warranty', $asset->warranty) }}"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

                        </div>

                    </div>

                </div>


                <!-- Price Information -->
                <div class="border-t border-slate-200 pt-8">

                    <h3 class="mb-5 text-sm font-bold uppercase tracking-wider text-slate-700">
                        Quantity & Price
                    </h3>

                    <div class="grid grid-cols-1 gap-5 md:grid-cols-3">

                        <div>

                            <label for="qty" class="mb-2 block text-sm font-semibold text-slate-700">
                                Qty (<span id="quantity-unit">{{ $categories->firstWhere('id', old('category_id', $asset->category_id))?->unit ?? 'unit' }}</span>) <span class="text-red-500">*</span>
                            </label>

                            <input
                                type="number"
                                id="qty"
                                step="0.01"
                                min="0.01"
                                name="qty"
                                required
                                value="{{ old('qty', $asset->qty ?? 1) }}"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

                        </div>


                        <div>

                            <label class="mb-2 block text-sm font-semibold text-slate-700">
                                Unit Price <span class="text-red-500">*</span>
                            </label>

                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                name="unit_price"
                                id="unit_price"
                                required
                                value="{{ old('unit_price', $asset->unit_price ?? 0) }}"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

                        </div>


                        <div>

                            <label class="mb-2 block text-sm font-semibold text-slate-700">
                                Total Price <span class="text-red-500">*</span>
                            </label>

                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                name="total_price"
                                id="total_price"
                                readonly
                                required
                                value="{{ old('total_price', $asset->total_price ?? 0) }}"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm font-semibold outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

                            <p class="mt-2 text-xs text-slate-500">
                                Calculated automatically from quantity and unit price.
                            </p>

                        </div>

                    </div>

                </div>


                <!-- Other Information -->
                <div class="border-t border-slate-200 pt-8">

                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                        <div>

                            <label class="mb-2 block text-sm font-semibold text-slate-700">
                                Received By
                            </label>

                            <input
                                name="received_by"
                                value="{{ old('received_by', $asset->received_by) }}"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

                        </div>


                        <div>

                            <label class="mb-2 block text-sm font-semibold text-slate-700">
                                Remarks
                            </label>

                            <textarea
                                name="remarks"
                                rows="4"
                                class="w-full resize-none rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">{{ old('remarks', $asset->remarks) }}</textarea>

                        </div>

                    </div>

                </div>


                <!-- Attachments -->
                <div class="border-t border-slate-200 pt-8">

                    <h3 class="mb-5 text-sm font-bold uppercase tracking-wider text-slate-700">
                        Attachments
                    </h3>

                    <div class="grid grid-cols-1 gap-5">

                        <div class="rounded-xl border border-dashed border-slate-300 p-5">

                            <label class="mb-2 block text-sm font-semibold text-slate-700">
                                Invoice Attachments
                            </label>

                            <input
                                type="file"
                                name="invoice_files[]"
                                multiple
                                accept=".pdf,.jpg,.jpeg,.png,.webp"
                                class="block w-full text-sm text-slate-500">

                            <p class="mt-2 text-xs text-slate-500">
                                PDF or Image · Maximum 5 MB each · Up to 5 files
                            </p>

                        </div>
                    </div>


                    @if($asset->exists && $asset->attachments->count())

                    <div class="mt-6 rounded-xl bg-slate-50 p-5">

                        <h4 class="mb-3 text-sm font-bold text-slate-800">
                            Existing Attachments
                        </h4>

                        <div class="space-y-2">

                            @foreach($asset->attachments as $file)

                            <a
                                href="{{ route('attachments.show', $file) }}"
                                class="flex items-center justify-between rounded-lg bg-white p-3 text-sm text-blue-600 transition hover:bg-blue-50">

                                <span class="truncate">
                                    {{ $file->original_file_name }}
                                </span>

                                <span class="ml-3 text-xs text-slate-400">
                                    {{ $file->attachment_type }}
                                </span>

                            </a>

                            @endforeach

                        </div>

                    </div>

                    @endif

                </div>

            </div>


            <!-- Actions -->
            <div class="flex flex-col-reverse gap-3 border-t border-slate-200 bg-slate-50 px-6 py-5 sm:flex-row sm:justify-end sm:px-8">

                <a
                    href="{{ $asset->exists ? route('assets.show', $asset) : route('assets.index') }}"
                    class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">

                    Cancel

                </a>

                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700">

                    {{ $asset->exists ? 'Update Purchase' : 'Save Purchase' }}

                </button>

            </div>

        </form>

    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const category = document.getElementById('category_id');
        const unitLabel = document.getElementById('quantity-unit');
        const serial = document.getElementById('serial_number');
        const quantity = document.getElementById('qty');
        const unitPrice = document.getElementById('unit_price');
        const totalPrice = document.getElementById('total_price');

        const updateFields = () => {
            const selected = category.options[category.selectedIndex];
            unitLabel.textContent = selected?.dataset.unit || 'unit';
            const serialRequired = selected?.dataset.serialRequired === '1';
            serial.closest('.serial-field').classList.toggle('hidden', !serialRequired);
            serial.required = serialRequired;
            serial.placeholder = serialRequired ? 'Required for this category' : 'Not required for this category';
            quantity.readOnly = serialRequired;
            quantity.max = serialRequired ? '1' : '';
            if (serialRequired) quantity.value = '1';
            totalPrice.value = ((parseFloat(quantity.value) || 0) * (parseFloat(unitPrice.value) || 0)).toFixed(2);
        };

        category.addEventListener('change', updateFields);
        quantity.addEventListener('input', updateFields);
        unitPrice.addEventListener('input', updateFields);
        updateFields();
    });
</script>

@endsection
