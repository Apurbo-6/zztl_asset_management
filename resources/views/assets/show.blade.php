@extends('layouts.app')

@section('title', 'Purchase Details')
@section('breadcrumb', 'Purchase Register')

@section('content')

<div class="mx-auto max-w-7xl">

    <!-- Header -->
    <div class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-start sm:justify-between">

        <div>

            <div class="mb-2 text-xs font-bold tracking-[0.2em] text-blue-600">
                PURCHASE RECORD #{{ $asset->id }}
            </div>

            <h1 class="text-2xl font-bold text-slate-900 sm:text-3xl">
                {{ $asset->particular_items }}
            </h1>

            <p class="mt-2 text-sm text-slate-500">
                {{ $asset->category->name }}
                <span class="mx-2">·</span>
                {{ $asset->purchase_date->format('d M Y') }}
            </p>

        </div>


        <div class="flex flex-wrap gap-3">

            <a
                href="{{ route('assets.index') }}"
                class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">

                ← Back

            </a>

            <a
                href="{{ route('assets.edit', $asset) }}"
                class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700">

                Edit Purchase

            </a>

        </div>

    </div>


    <!-- Purchase Details -->
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-6 py-5">

            <h2 class="text-lg font-bold text-slate-900">
                Purchase Information
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Complete details for this purchase record.
            </p>

        </div>


        <div class="grid grid-cols-1 divide-y divide-slate-200 sm:grid-cols-2 sm:divide-x sm:divide-y-0 lg:grid-cols-3">

            @foreach([
            'Purchased From' => $asset->supplier?->name ?? '—',
            'Invoice No' => $asset->invoice_no,
            'Serial Number' => $asset->serial_number,
            'Brand Name' => $asset->brand_name,
            'Quantity' => $asset->qty,
            'Unit Price' => '৳'.number_format($asset->unit_price, 2),
            'Total Price' => '৳'.number_format($asset->total_price, 2),
            'Warranty' => $asset->warranty,
            'Received By' => $asset->received_by
            ] as $label => $value)

            <div class="p-6">

                <div class="mb-2 text-xs font-bold uppercase tracking-wider text-slate-400">
                    {{ $label }}
                </div>

                <div class="break-words text-sm font-semibold text-slate-800">
                    {{ $value ?: '—' }}
                </div>

            </div>

            @endforeach

        </div>


        @if($asset->remarks)

        <div class="border-t border-slate-200 px-6 py-6">

            <div class="mb-2 text-xs font-bold uppercase tracking-wider text-slate-400">
                Remarks
            </div>

            <p class="whitespace-pre-line text-sm leading-6 text-slate-700">
                {{ $asset->remarks }}
            </p>

        </div>

        @endif

    </div>


    <!-- Attachments -->
    <div class="mt-6 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-6 py-5">

            <h2 class="text-lg font-bold text-slate-900">
                Attachments
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Invoice documents and item images.
            </p>

        </div>


        <div class="divide-y divide-slate-100">

            @forelse($asset->attachments as $file)

            <div class="flex flex-col gap-4 p-5 sm:flex-row sm:items-center sm:justify-between">

                <div class="min-w-0">

                    <a
                        href="{{ route('attachments.show', $file) }}"
                        class="block truncate text-sm font-semibold text-blue-600 transition hover:text-blue-800 hover:underline">

                        {{ $file->original_file_name }}

                    </a>

                    <div class="mt-1 text-xs text-slate-500">

                        {{ $file->attachment_type }}
                        <span class="mx-1">·</span>
                        {{ number_format(($file->compressed_size ?? 0) / 1024, 1) }} KB

                    </div>

                </div>


                <a
                    href="{{ route('attachments.show', $file) }}"
                    class="inline-flex shrink-0 items-center justify-center rounded-lg bg-slate-100 px-4 py-2 text-xs font-semibold text-slate-700 transition hover:bg-slate-200">

                    View / Download

                </a>

            </div>

            @empty

            <div class="px-6 py-10 text-center text-sm text-slate-500">
                No attachments available for this purchase.
            </div>

            @endforelse

        </div>

    </div>

</div>

@endsection