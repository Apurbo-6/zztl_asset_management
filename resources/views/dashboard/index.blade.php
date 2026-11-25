@extends('layouts.app')

@section('title', 'Dashboard')
@section('breadcrumb', 'Overview')

@section('content')

<!-- Page Header -->
<div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

    <div>
        <div class="mb-2 text-xs font-bold tracking-[0.2em] text-blue-600">
            OVERVIEW
        </div>

        <h1 class="text-3xl font-bold tracking-tight text-slate-900">
            Dashboard
        </h1>

        <p class="mt-2 text-sm text-slate-500">
            Company purchase register overview.
        </p>
    </div>

    <div class="inline-flex w-fit items-center rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-600 shadow-sm">
        <svg xmlns="http://www.w3.org/2000/svg"
            class="mr-2 h-5 w-5 text-blue-600"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M8 7V3m8 4V3M3 11h18M5 5h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z" />
        </svg>

        {{ now()->format('l, d M Y') }}
    </div>

</div>


<!-- Main Statistics -->
<div class="mb-8 grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">

    <!-- Purchase Records -->
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">

        <div class="mb-5 flex items-center justify-between">

            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a3 3 0 006 0M9 5a3 3 0 016 0" />

                </svg>

            </div>

            <span class="text-xs font-semibold text-slate-400">
                RECORDS
            </span>

        </div>

        <div class="text-sm font-medium text-slate-500">
            Purchase Records
        </div>

        <div class="mt-2 text-3xl font-bold text-slate-900">
            {{ number_format($assetCount) }}
        </div>

        <div class="mt-2 text-sm text-slate-400">
            All recorded purchase lines
        </div>

    </div>


    <!-- Total Purchase Value -->
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">

        <div class="mb-5 flex items-center justify-between">

            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">

                <span class="text-xl font-bold">৳</span>

            </div>

            <span class="text-xs font-semibold text-slate-400">
                VALUE
            </span>

        </div>

        <div class="text-sm font-medium text-slate-500">
            Total Purchase Value
        </div>

        <div class="mt-2 text-2xl font-bold text-slate-900">
            ৳{{ number_format($purchaseTotal, 2) }}
        </div>

        <div class="mt-2 text-sm text-slate-400">
            Sum of all purchase totals
        </div>

    </div>


    <!-- Total Quantity -->
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">

        <div class="mb-5 flex items-center justify-between">

            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-violet-50 text-violet-600">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M20 7l-8 5-8-5m16 0l-8-5-8 5m16 0v10l-8 5-8-5V7" />

                </svg>

            </div>

            <span class="text-xs font-semibold text-slate-400">
                QUANTITY
            </span>

        </div>

        <div class="text-sm font-medium text-slate-500">
            Total Quantity
        </div>

        <div class="mt-2 text-3xl font-bold text-slate-900">
            {{ number_format($quantityTotal, 2) }}
        </div>

        <div class="mt-2 text-sm text-slate-400">
            Across all purchase records
        </div>

    </div>


    <!-- This Month -->
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">

        <div class="mb-5 flex items-center justify-between">

            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-orange-50 text-orange-600">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 8c-2.2 0-4 1.2-4 3s1.8 3 4 3 4 1.2 4 3-1.8 3-4 3m0-12V4m0 16v-2" />

                </svg>

            </div>

            <span class="text-xs font-semibold text-slate-400">
                THIS MONTH
            </span>

        </div>

        <div class="text-sm font-medium text-slate-500">
            This Month
        </div>

        <div class="mt-2 text-2xl font-bold text-slate-900">
            ৳{{ number_format($thisMonth, 2) }}
        </div>

        <div class="mt-2 text-sm text-slate-400">
            Purchase value this month
        </div>

    </div>

</div>


<!-- Secondary Statistics -->
<div class="mb-8 grid grid-cols-1 gap-5 sm:grid-cols-2">

    <!-- Categories -->
    <div class="flex items-center justify-between rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

        <div>

            <div class="text-sm font-medium text-slate-500">
                Total Categories
            </div>

            <div class="mt-2 text-3xl font-bold text-slate-900">
                {{ number_format($categoryCount) }}
            </div>

        </div>

        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-blue-600">

            <svg xmlns="http://www.w3.org/2000/svg"
                class="h-7 w-7"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor">

                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16" />

            </svg>

        </div>

    </div>


    <!-- Suppliers -->
    <div class="flex items-center justify-between rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

        <div>

            <div class="text-sm font-medium text-slate-500">
                Total Suppliers
            </div>

            <div class="mt-2 text-3xl font-bold text-slate-900">
                {{ number_format($supplierCount) }}
            </div>

        </div>

        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600">

            <svg xmlns="http://www.w3.org/2000/svg"
                class="h-7 w-7"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor">

                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M17 20h5v-2a4 4 0 00-5-3.87M9 20H2v-2a4 4 0 017-3.87M16 3.13a4 4 0 010 7.75M12 3a4 4 0 110 8 4 4 0 010-8z" />

            </svg>

        </div>

    </div>

</div>


<!-- Recent Purchases -->
<div class="mb-8 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

    <div class="flex flex-col gap-4 border-b border-slate-200 p-6 sm:flex-row sm:items-center sm:justify-between">

        <div>

            <h2 class="text-lg font-bold text-slate-900">
                Recent Purchases
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Latest entries in the purchase register
            </p>

        </div>

        <a href="{{ route('assets.index') }}"
            class="inline-flex items-center text-sm font-semibold text-blue-600 transition hover:text-blue-800">

            View register

            <span class="ml-1">→</span>

        </a>

    </div>


    <div class="overflow-x-auto">

        <table class="min-w-full divide-y divide-slate-200">

            <thead class="bg-slate-50">

                <tr>

                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                        Item
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                        Category
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                        Purchase Date
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                        Qty
                    </th>

                    <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-slate-500">
                        Total Price
                    </th>

                </tr>

            </thead>


            <tbody class="divide-y divide-slate-100 bg-white">

                @forelse($recentAssets as $a)

                <tr class="transition hover:bg-slate-50">

                    <td class="px-6 py-4">

                        <a href="{{ route('assets.show', $a) }}"
                            class="font-semibold text-slate-800 hover:text-blue-600">

                            {{ $a->particular_items }}

                        </a>

                    </td>


                    <td class="px-6 py-4 text-sm text-slate-600">

                        {{ $a->category?->name ?? '-' }}

                    </td>


                    <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">

                        {{ $a->purchase_date?->format('d M Y') ?? '-' }}

                    </td>


                    <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-slate-700">

                        {{ $a->qty }}

                    </td>


                    <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-bold text-slate-900">

                        ৳{{ number_format($a->total_price, 2) }}

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="5"
                        class="px-6 py-12 text-center text-sm text-slate-400">

                        No purchase records yet.

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>


<!-- Recent Activities -->
<div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

    <div class="flex flex-col gap-4 border-b border-slate-200 p-6 sm:flex-row sm:items-center sm:justify-between">

        <div>

            <h2 class="text-lg font-bold text-slate-900">
                Recent Activities
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Latest system changes
            </p>

        </div>

        <a href="{{ route('activity-logs.index') }}"
            class="inline-flex items-center text-sm font-semibold text-blue-600 transition hover:text-blue-800">

            View all

            <span class="ml-1">→</span>

        </a>

    </div>


    <div class="overflow-x-auto">

        <table class="min-w-full divide-y divide-slate-200">

            <thead class="bg-slate-50">

                <tr>

                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                        Activity
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                        Module
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                        Performed By
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                        Date
                    </th>

                </tr>

            </thead>


            <tbody class="divide-y divide-slate-100 bg-white">

                @forelse($recentLogs as $log)

                <tr class="transition hover:bg-slate-50">

                    <td class="px-6 py-4 text-sm text-slate-700">

                        {{ $log->description }}

                    </td>


                    <td class="px-6 py-4">

                        <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">

                            {{ $log->module }}

                        </span>

                    </td>


                    <td class="px-6 py-4 text-sm text-slate-600">

                        {{ $log->user?->name ?? 'System' }}

                    </td>


                    <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-500">

                        {{ $log->created_at?->format('d M Y, h:i A') }}

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="4"
                        class="px-6 py-12 text-center text-sm text-slate-400">

                        No activity recorded.

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection