@extends('layouts.app')

@section('title', 'Purchase Details')
@section('breadcrumb', 'Purchase Details')

@section('content')

    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

        <div>
            <div class="text-xs font-bold tracking-widest text-blue-600">
                PURCHASE DETAILS
            </div>

            <h1 class="mt-2 text-2xl font-bold text-slate-900">
                {{ $purchase->invoice_no ?: 'Purchase Record' }}
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                View purchase information and individual assets.
            </p>
        </div>

        <div class="flex flex-wrap gap-3">

            <a href="{{ route('purchases.edit', $purchase) }}"
                class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">

                Edit Purchase

            </a>

            <a href="{{ route('purchases.index') }}"
                class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">

                ← Back

            </a>

        </div>

    </div>


    <!-- Purchase Information -->
    <div class="mb-8 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-6 py-5">

            <h2 class="text-lg font-bold text-slate-900">
                Purchase Information
            </h2>

        </div>

        <div class="grid grid-cols-1 gap-6 p-6 md:grid-cols-2 lg:grid-cols-4">

            <div>

                <div class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                    Invoice Number
                </div>

                <div class="mt-2 font-semibold text-slate-900">
                    {{ $purchase->invoice_no ?: '—' }}
                </div>

            </div>


            <div>

                <div class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                    Supplier
                </div>

                <div class="mt-2 font-semibold text-slate-900">
                    {{ $purchase->supplier?->name ?? '—' }}
                </div>

            </div>


            <div>

                <div class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                    Purchase Date
                </div>

                <div class="mt-2 font-semibold text-slate-900">
                    {{ $purchase->purchased_at?->format('d M Y, h:i A') ?? $purchase->purchase_date?->format('d M Y') ?? '—' }}
                </div>

            </div>


            <div>

                <div class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                    Total Items
                </div>

                <div class="mt-2 font-semibold text-slate-900">
                    {{ $purchase->assets->count() }}
                </div>

            </div>

        </div>


        @if ($purchase->remarks)
            <div class="border-t border-slate-200 px-6 py-5">

                <div class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                    Remarks
                </div>

                <div class="mt-2 text-sm text-slate-700">
                    {{ $purchase->remarks }}
                </div>

            </div>
        @endif

        <div class="border-t border-slate-200 px-6 py-5">
            <div class="grid gap-3 text-sm sm:grid-cols-2">
                <div class="text-slate-600">Items subtotal <span class="float-right font-semibold text-slate-900">৳{{ number_format($purchase->items_total, 2) }}</span></div>
                <div class="text-slate-600">Delivery / shipping <span class="float-right font-semibold text-slate-900">৳{{ number_format($purchase->shipping_charge, 2) }}</span></div>
                <div class="text-slate-600">{{ $purchase->extra_charge_description ?: 'Extra charge' }} <span class="float-right font-semibold text-slate-900">৳{{ number_format($purchase->extra_charge, 2) }}</span></div>
                <div class="font-bold text-slate-900">Invoice total <span class="float-right">৳{{ number_format($purchase->grand_total, 2) }}</span></div>
            </div>
        </div>

        @if ($purchase->attachments->isNotEmpty())
            <div class="border-t border-slate-200 px-6 py-5">
                <h3 class="text-sm font-semibold text-slate-700">Invoice scans</h3>
                <div class="mt-3 flex flex-wrap gap-3">
                    @foreach ($purchase->attachments as $attachment)
                        <a href="{{ route('purchase-attachments.show', $attachment) }}" class="rounded-lg bg-blue-50 px-3 py-2 text-sm font-medium text-blue-700 hover:bg-blue-100">{{ $attachment->original_file_name ?: $attachment->stored_file_name }}</a>
                    @endforeach
                </div>
            </div>
        @endif

    </div>


    <!-- Assets -->
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="flex flex-col gap-4 border-b border-slate-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <h2 class="text-lg font-bold text-slate-900">
                    Purchased Assets
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Individual assets under this purchase invoice.
                </p>

            </div>


            <a href="{{ route('assets.create', ['purchase_id' => $purchase->id]) }}"
                class="inline-flex items-center justify-center rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-700">

                + Add Asset

            </a>

        </div>


        <div class="overflow-x-auto">

            <table class="w-full min-w-[900px] text-left text-sm">

                <thead class="bg-slate-50 text-xs font-bold uppercase tracking-wide text-slate-500">

                    <tr>

                        <th class="px-6 py-4">
                            Asset
                        </th>

                        <th class="px-6 py-4">
                            Category
                        </th>

                        <th class="px-6 py-4">
                            Serial Number
                        </th>

                        <th class="px-6 py-4">
                            Brand
                        </th>

                        <th class="px-6 py-4">
                            Price
                        </th>

                        <th class="px-6 py-4">
                            Status
                        </th>

                        <th class="px-6 py-4 text-right">
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-100">

                    @forelse($purchase->assets as $asset)
                        <tr class="transition hover:bg-slate-50">

                            <td class="px-6 py-4">

                                <a href="{{ route('assets.show', $asset) }}"
                                    class="font-semibold text-slate-900 hover:text-blue-600">

                                    {{ $asset->particular_items }}
                                    <span class="mt-1 block font-mono text-xs text-slate-500">{{ $asset->asset_code }}</span>

                                </a>

                            </td>


                            <td class="px-6 py-4 text-slate-600">

                                {{ $asset->category?->name ?? '—' }}

                            </td>


                            <td class="px-6 py-4">

                                <span class="font-mono text-xs text-slate-600">

                                    {{ $asset->serial_number ?: '—' }}

                                </span>

                            </td>


                            <td class="px-6 py-4 text-slate-600">

                                {{ $asset->brand_name ?: '—' }}

                            </td>


                            <td class="px-6 py-4 font-semibold text-slate-800">

                                ৳{{ number_format($asset->total_price, 2) }}

                            </td>


                            <td class="px-6 py-4">

                                @if ($asset->status === 'assigned')
                                    <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                                        Assigned
                                    </span>
                                @else
                                    <span
                                        class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                                        Available
                                    </span>
                                @endif

                            </td>


                            <td class="px-6 py-4 text-right">

                                <a href="{{ route('assets.show', $asset) }}"
                                    class="font-semibold text-blue-600 hover:text-blue-800">

                                    View →

                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7" class="px-6 py-12 text-center text-slate-500">

                                No assets have been added to this purchase yet.

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

@endsection
