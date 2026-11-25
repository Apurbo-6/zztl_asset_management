@extends('layouts.app')

@section('title', 'Suppliers')
@section('breadcrumb', 'Suppliers')

@section('content')

<!-- Page Header -->
<div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

    <div>

        <div class="mb-2 text-xs font-bold tracking-[0.2em] text-blue-600">
            MASTER DATA
        </div>

        <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
            Suppliers
        </h1>

        <p class="mt-2 text-sm text-slate-500">
            Manage suppliers and vendors used for company purchases.
        </p>

    </div>


    <a
        href="{{ route('suppliers.create') }}"
        class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-200 transition hover:bg-blue-700 hover:shadow-xl active:scale-[0.98]">

        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2">

            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M12 4v16m8-8H4" />

        </svg>

        Add Supplier

    </a>

</div>


<!-- Supplier Statistics -->
<div class="mb-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">

    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

        <div class="flex items-center justify-between">

            <div>

                <div class="text-sm font-medium text-slate-500">
                    Total Suppliers
                </div>

                <div class="mt-2 text-2xl font-bold text-slate-900">
                    {{ $suppliers->total() }}
                </div>

            </div>

            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-xl text-blue-600">
                🏢
            </div>

        </div>

    </div>


    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

        <div class="flex items-center justify-between">

            <div>

                <div class="text-sm font-medium text-slate-500">
                    Active Suppliers
                </div>

                <div class="mt-2 text-2xl font-bold text-emerald-600">
                    {{ $suppliers->where('is_active', true)->count() }}
                </div>

            </div>

            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-xl">
                ✓
            </div>

        </div>

    </div>


    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:col-span-2 lg:col-span-1">

        <div class="flex items-center justify-between">

            <div>

                <div class="text-sm font-medium text-slate-500">
                    Current Page
                </div>

                <div class="mt-2 text-2xl font-bold text-slate-900">
                    {{ $suppliers->currentPage() }}
                    <span class="text-sm font-medium text-slate-400">
                        / {{ $suppliers->lastPage() }}
                    </span>
                </div>

            </div>

            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-violet-50 text-xl">
                📋
            </div>

        </div>

    </div>

</div>


<!-- Suppliers Table -->
<div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

    <!-- Table Header -->
    <div class="flex flex-col gap-3 border-b border-slate-200 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">

        <div>

            <h2 class="text-base font-bold text-slate-900">
                Supplier Directory
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                All registered suppliers in the asset management system.
            </p>

        </div>

        <div class="text-sm text-slate-500">
            Showing
            <span class="font-semibold text-slate-700">
                {{ $suppliers->firstItem() ?? 0 }}–{{ $suppliers->lastItem() ?? 0 }}
            </span>
            of
            <span class="font-semibold text-slate-700">
                {{ $suppliers->total() }}
            </span>
        </div>

    </div>


    <!-- Responsive Table -->
    <div class="overflow-x-auto">

        <table class="w-full min-w-[850px] text-left text-sm">

            <thead class="border-b border-slate-200 bg-slate-50">

                <tr>

                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                        Supplier
                    </th>

                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                        Contact Person
                    </th>

                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                        Phone
                    </th>

                    <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider text-slate-500">
                        Records
                    </th>

                    <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider text-slate-500">
                        Status
                    </th>

                    <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-slate-500">
                        Actions
                    </th>

                </tr>

            </thead>


            <tbody class="divide-y divide-slate-100">

                @forelse($suppliers as $s)

                <tr class="transition hover:bg-slate-50">

                    <!-- Supplier -->
                    <td class="px-6 py-4">

                        <div class="flex items-center gap-3">

                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 font-bold text-blue-600">

                                {{ strtoupper(substr($s->name, 0, 1)) }}

                            </div>

                            <div>

                                <div class="font-semibold text-slate-800">
                                    {{ $s->name }}
                                </div>

                                @if($s->email)
                                <div class="mt-1 text-xs text-slate-400">
                                    {{ $s->email }}
                                </div>
                                @else
                                <div class="mt-1 text-xs text-slate-400">
                                    No email provided
                                </div>
                                @endif

                            </div>

                        </div>

                    </td>


                    <!-- Contact -->
                    <td class="px-6 py-4 text-slate-600">

                        {{ $s->contact_person ?: '—' }}

                    </td>


                    <!-- Phone -->
                    <td class="px-6 py-4 text-slate-600">

                        {{ $s->phone ?: '—' }}

                    </td>


                    <!-- Records -->
                    <td class="px-6 py-4 text-center">

                        <span class="inline-flex min-w-8 items-center justify-center rounded-lg bg-slate-100 px-2.5 py-1 text-xs font-bold text-slate-700">

                            {{ number_format($s->assets_count) }}

                        </span>

                    </td>


                    <!-- Status -->
                    <td class="px-6 py-4 text-center">

                        @if($s->is_active)

                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">

                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>

                            Active

                        </span>

                        @else

                        <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-600">

                            <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>

                            Inactive

                        </span>

                        @endif

                    </td>


                    <!-- Actions -->
                    <td class="px-6 py-4">

                        <div class="flex items-center justify-end gap-2">

                            <!-- Edit -->
                            <a
                                href="{{ route('suppliers.edit', $s) }}"
                                class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-blue-600 transition hover:bg-blue-50"
                                title="Edit Supplier">

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2">

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M16.862 4.487l1.651-1.651a2.25 2.25 0 113.182 3.182L10.5 17.213l-4.5 1.5 1.5-4.5L16.862 4.487z" />

                                </svg>

                            </a>


                            <!-- Deactivate -->
                            <form
                                method="POST"
                                action="{{ route('suppliers.destroy', $s) }}"
                                onsubmit="return confirm('Are you sure you want to deactivate this supplier?')">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-red-500 transition hover:bg-red-50"
                                    title="Deactivate Supplier">

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-4 w-4"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="2">

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M6 18L18 6M6 6l12 12" />

                                    </svg>

                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

                @empty

                <tr>

                    <td
                        colspan="6"
                        class="px-6 py-16 text-center">

                        <div class="mx-auto flex max-w-sm flex-col items-center">

                            <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-2xl">
                                🏢
                            </div>

                            <h3 class="text-base font-bold text-slate-800">
                                No suppliers found
                            </h3>

                            <p class="mt-2 text-sm text-slate-500">
                                Add your first supplier to start managing purchase records.
                            </p>

                            <a
                                href="{{ route('suppliers.create') }}"
                                class="mt-5 inline-flex items-center rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700">

                                + Add Supplier

                            </a>

                        </div>

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    <!-- Pagination -->
    @if($suppliers->hasPages())

    <div class="border-t border-slate-200 px-5 py-4 sm:px-6">

        {{ $suppliers->links() }}

    </div>

    @endif

</div>

@endsection