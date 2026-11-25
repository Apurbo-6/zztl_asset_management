@extends('layouts.app')

@section('title', 'Purchases')
@section('breadcrumb', 'Purchases')

@section('content')

    <div class="space-y-6">

        <!-- Page Header -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <div class="text-xs font-bold tracking-widest text-blue-600">
                    PURCHASE MANAGEMENT
                </div>

                <h1 class="mt-1 text-2xl font-bold text-slate-900">
                    Purchases
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Manage invoices and purchased assets.
                </p>
            </div>

            @can('purchases.create')
                <a href="{{ route('purchases.create') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-200 transition hover:bg-blue-700">
                    <span class="text-lg">+</span>
                    Add Purchase
                </a>
            @endcan

        </div>


        <!-- Search -->
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">

            <form method="GET" class="flex flex-col gap-3 sm:flex-row">

                <input type="text" name="q" value="{{ request('q') }}"
                    placeholder="Search invoice number or supplier..."
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

                <button type="submit"
                    class="rounded-xl bg-slate-900 px-6 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                    Search
                </button>

                <a href="{{ route('purchases.index') }}"
                    class="rounded-xl border border-slate-300 px-6 py-3 text-center text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                    Reset
                </a>

            </form>

        </div>


        <!-- Purchase Table -->
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="overflow-x-auto">

                <table class="min-w-full text-left">

                    <thead class="border-b border-slate-200 bg-slate-50">

                        <tr>

                            <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                                Invoice
                            </th>

                            <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                                Supplier
                            </th>

                            <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                                Purchase Date
                            </th>

                            <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                                Assets
                            </th>

                            <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                                Invoice Total
                            </th>

                            <th class="px-5 py-4 text-right text-xs font-bold uppercase tracking-wider text-slate-500">
                                Action
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100">

                        @forelse($purchases as $purchase)
                            <tr class="transition hover:bg-slate-50">

                                <td class="px-5 py-4">

                                    <a href="{{ route('purchases.show', $purchase) }}"
                                        class="font-semibold text-blue-600 hover:text-blue-800">

                                        {{ $purchase->invoice_no ?: 'No Invoice Number' }}

                                    </a>

                                </td>


                                <td class="px-5 py-4 text-sm text-slate-600">

                                    {{ $purchase->supplier?->name ?? 'No Supplier' }}

                                </td>


                                <td class="px-5 py-4 text-sm text-slate-600">

                                    {{ $purchase->purchased_at?->format('d M Y, h:i A') ?? $purchase->purchase_date?->format('d M Y') }}

                                </td>

                                <td class="px-5 py-4">

                                    <span
                                        class="inline-flex rounded-full bg-blue-50 px-3 py-1 text-xs font-bold text-blue-700">

                                        {{ $purchase->assets->count() }} Items

                                    </span>

                                </td>

                                <td class="px-5 py-4 text-sm font-semibold text-slate-700">
                                    ৳{{ number_format($purchase->grand_total, 2) }}
                                </td>


                                <td class="px-5 py-4">

                                    <div class="flex justify-end gap-2">

                                        <a href="{{ route('purchases.show', $purchase) }}"
                                            class="rounded-lg bg-slate-100 px-3 py-2 text-xs font-semibold text-slate-700 transition hover:bg-slate-200">

                                            View

                                        </a>


                                        @can('purchases.update')
                                            <a href="{{ route('purchases.edit', $purchase) }}"
                                                class="rounded-lg bg-blue-50 px-3 py-2 text-xs font-semibold text-blue-700 transition hover:bg-blue-100">

                                                Edit

                                            </a>
                                        @endcan

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6" class="px-6 py-14 text-center text-sm text-slate-400">

                                    No purchase records found.

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        <!-- Pagination -->
        <div>

            {{ $purchases->links() }}

        </div>

    </div>

@endsection
