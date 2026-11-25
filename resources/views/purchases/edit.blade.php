@extends('layouts.app')

@section('title', 'Edit Purchase')
@section('breadcrumb', 'Edit Purchase')

@section('content')

    <div class="mb-8 flex items-start justify-between">

        <div>

            <div class="text-xs font-bold tracking-widest text-blue-600">
                PURCHASE MANAGEMENT
            </div>

            <h1 class="mt-2 text-2xl font-bold text-slate-900">
                Edit Purchase
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Update the purchase invoice information.
            </p>

        </div>

        <a href="{{ route('purchases.show', $purchase) }}"
            class="rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">

            ← Back

        </a>

    </div>


    <div class="max-w-4xl rounded-2xl border border-slate-200 bg-white p-6 shadow-sm md:p-8">

        <form method="POST" action="{{ route('purchases.update', $purchase) }}" class="space-y-6">

            @csrf
            @method('PUT')


            <!-- Supplier -->
            <div>

                <label class="mb-2 block text-sm font-semibold text-slate-700">

                    Supplier

                </label>

                <select name="supplier_id"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

                    <option value="">
                        Select Supplier
                    </option>

                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" @selected(old('supplier_id', $purchase->supplier_id) == $supplier->id)>

                            {{ $supplier->name }}

                        </option>
                    @endforeach

                </select>

            </div>


            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                <!-- Invoice -->
                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">

                        Invoice Number

                    </label>

                    <input type="text" name="invoice_no" value="{{ old('invoice_no', $purchase->invoice_no) }}"
                        placeholder="Enter invoice number"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

                </div>


                <!-- Date -->
                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">

                        Purchase Date <span class="text-red-500">*</span>

                    </label>

                    <input type="date" name="purchase_date"
                        value="{{ old('purchase_date', optional($purchase->purchase_date)->format('Y-m-d')) }}" required
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

                </div>

            </div>


            <!-- Remarks -->
            <div>

                <label class="mb-2 block text-sm font-semibold text-slate-700">

                    Remarks

                </label>

                <textarea name="remarks" rows="4" placeholder="Additional purchase information..."
                    class="w-full resize-none rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100">{{ old('remarks', $purchase->remarks) }}</textarea>

            </div>


            <div class="flex flex-col-reverse gap-3 border-t border-slate-200 pt-6 sm:flex-row sm:justify-end">

                <a href="{{ route('purchases.show', $purchase) }}"
                    class="rounded-xl border border-slate-300 px-5 py-3 text-center text-sm font-semibold text-slate-700 hover:bg-slate-50">

                    Cancel

                </a>

                <button type="submit"
                    class="rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">

                    Update Purchase

                </button>

            </div>

        </form>

    </div>

@endsection
