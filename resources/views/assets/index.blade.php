@extends('layouts.app')

@section('title', 'Purchase Register')
@section('breadcrumb', 'Purchase Register')

@section('content')

<div class="mx-auto max-w-[1600px]">

    <!-- Header -->
    <div class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

        <div>

            <div class="mb-2 text-xs font-bold tracking-[0.2em] text-blue-600">
                PURCHASE RECORDS
            </div>

            <h1 class="text-2xl font-bold text-slate-900 sm:text-3xl">
                Purchase Register
            </h1>

            <p class="mt-2 text-sm text-slate-500">
                All company purchases in one searchable register.
            </p>

        </div>

        <a
            href="{{ route('assets.create') }}"
            class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700">

            <span class="mr-2 text-lg">+</span>
            Add Purchase

        </a>

    </div>


    <!-- Summary -->
    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-3">

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Records</p>
            <p class="mt-2 text-2xl font-bold text-slate-900">
                {{ number_format($summary['records']) }}
            </p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Total Quantity</p>
            <p class="mt-2 text-2xl font-bold text-slate-900">
                {{ number_format($summary['quantity'], 2) }}
            </p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Total Purchase Amount</p>
            <p class="mt-2 text-2xl font-bold text-slate-900">
                ৳{{ number_format($summary['amount'], 2) }}
            </p>
        </div>

    </div>


    <!-- Filters -->
    <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

        <form method="GET" class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">

            <input
                name="q"
                placeholder="Search item, invoice, serial, brand..."
                value="{{ request('q') }}"
                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">


            <select
                name="category_id"
                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

                <option value="">All categories</option>

                @foreach($categories as $c)
                <option
                    value="{{ $c->id }}"
                    @selected(request('category_id')==$c->id)>

                    {{ $c->name }}

                </option>
                @endforeach

            </select>


            <select
                name="supplier_id"
                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

                <option value="">All suppliers</option>

                @foreach($suppliers as $s)
                <option
                    value="{{ $s->id }}"
                    @selected(request('supplier_id')==$s->id)>

                    {{ $s->name }}

                </option>
                @endforeach

            </select>


            <select
                name="year"
                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

                <option value="">All years</option>

                @foreach($years as $y)
                <option
                    value="{{ $y }}"
                    @selected(request('year')==$y)>

                    {{ $y }}

                </option>
                @endforeach

            </select>


            <input
                type="date"
                name="start_date"
                value="{{ request('start_date') }}"
                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100">


            <input
                type="date"
                name="end_date"
                value="{{ request('end_date') }}"
                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100">


            <button
                type="submit"
                class="rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">

                Filter

            </button>


            <a
                href="{{ route('assets.index') }}"
                class="flex items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">

                Reset

            </a>

        </form>

    </div>


    <!-- Table -->
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="overflow-x-auto">

            <table class="w-full min-w-[1500px] text-left text-sm">

                <thead class="border-b border-slate-200 bg-slate-50 text-xs uppercase tracking-wider text-slate-500">

                    <tr>
                        <th class="whitespace-nowrap px-4 py-4">SL</th>
                        <th class="whitespace-nowrap px-4 py-4">Particular Items</th>
                        <th class="whitespace-nowrap px-4 py-4">Category</th>
                        <th class="whitespace-nowrap px-4 py-4">Purchased From</th>
                        <th class="whitespace-nowrap px-4 py-4">Purchase Date</th>
                        <th class="whitespace-nowrap px-4 py-4">Invoice No</th>
                        <th class="whitespace-nowrap px-4 py-4">Serial Number</th>
                        <th class="whitespace-nowrap px-4 py-4">Brand</th>
                        <th class="whitespace-nowrap px-4 py-4">Qty</th>
                        <th class="whitespace-nowrap px-4 py-4">Unit Price</th>
                        <th class="whitespace-nowrap px-4 py-4">Total Price</th>
                        <th class="whitespace-nowrap px-4 py-4">Warranty</th>
                        <th class="whitespace-nowrap px-4 py-4">Received By</th>
                        <th class="whitespace-nowrap px-4 py-4">Action</th>
                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-100">

                    @forelse($assets as $a)

                    <tr class="transition hover:bg-slate-50">

                        <td class="px-4 py-4 text-slate-500">
                            {{ $assets->firstItem() + $loop->index }}
                        </td>

                        <td class="max-w-xs px-4 py-4 font-semibold text-slate-900">
                            {{ $a->particular_items }}
                            <span class="mt-1 block font-mono text-xs font-normal text-slate-500">{{ $a->asset_code }}</span>
                        </td>

                        <td class="px-4 py-4">
                            {{ $a->category->name }}
                        </td>

                        <td class="px-4 py-4">
                            {{ $a->supplier?->name ?? '—' }}
                        </td>

                        <td class="whitespace-nowrap px-4 py-4">
                            {{ $a->purchase_date->format('d M Y') }}
                        </td>

                        <td class="px-4 py-4">
                            {{ $a->invoice_no ?? '—' }}
                        </td>

                        <td class="px-4 py-4">
                            {{ $a->serial_number ?? '—' }}
                        </td>

                        <td class="px-4 py-4">
                            {{ $a->brand_name ?? '—' }}
                        </td>

                        <td class="px-4 py-4">
                            {{ $a->qty }} {{ $a->category?->unit }}
                        </td>

                        <td class="whitespace-nowrap px-4 py-4">
                            ৳{{ number_format($a->unit_price, 2) }}
                        </td>

                        <td class="whitespace-nowrap px-4 py-4 font-bold text-slate-900">
                            ৳{{ number_format($a->total_price, 2) }}
                        </td>

                        <td class="px-4 py-4">
                            {{ $a->warranty ?? '—' }}
                        </td>

                        <td class="px-4 py-4">
                            {{ $a->received_by ?? '—' }}
                        </td>

                        <td class="whitespace-nowrap px-4 py-4">

                            <div class="flex items-center gap-2">

                                <a
                                    href="{{ route('assets.show', $a) }}"
                                    class="rounded-lg bg-blue-50 px-3 py-2 text-xs font-semibold text-blue-700 transition hover:bg-blue-100">

                                    View

                                </a>

                                <a
                                    href="{{ route('assets.edit', $a) }}"
                                    class="rounded-lg bg-amber-50 px-3 py-2 text-xs font-semibold text-amber-700 transition hover:bg-amber-100">

                                    Edit

                                </a>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td
                            colspan="14"
                            class="px-6 py-12 text-center text-slate-500">

                            No purchase records found.

                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        <div class="border-t border-slate-200 px-5 py-4">
            {{ $assets->links() }}
        </div>

    </div>

</div>

@endsection
