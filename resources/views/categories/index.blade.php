@extends('layouts.app')

@section('title', 'Categories')
@section('breadcrumb', 'Categories')

@section('content')

<div class="space-y-6">

    <!-- Page Header -->
    <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

        <div>

            <div class="mb-2 text-xs font-bold tracking-[0.2em] text-blue-600">
                MASTER DATA
            </div>

            <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                Categories
            </h1>

            <p class="mt-2 text-sm text-slate-500">
                Manage purchase item categories used in the asset management system.
            </p>

        </div>


        <!-- Add Button -->
        <a
            href="{{ route('categories.create') }}"

            class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700 hover:shadow-xl active:scale-[0.98]">

            <!-- Plus Icon -->
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

            Add Category

        </a>

    </div>


    <!-- Statistics -->
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">

        <!-- Total Categories -->
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm font-medium text-slate-500">
                        Total Categories
                    </p>

                    <p class="mt-2 text-3xl font-bold text-slate-900">
                        {{ $categories->total() }}
                    </p>

                </div>


                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M4 6h16M4 10h16M4 14h16M4 18h16" />

                    </svg>

                </div>

            </div>

        </div>


        <!-- Active Categories -->
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm font-medium text-slate-500">
                        Active Categories
                    </p>

                    <p class="mt-2 text-3xl font-bold text-emerald-600">
                        {{ $categories->getCollection()->where('is_active', true)->count() }}
                    </p>

                </div>


                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M5 13l4 4L19 7" />

                    </svg>

                </div>

            </div>

        </div>


        <!-- Current Page -->
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm font-medium text-slate-500">
                        Purchase Categories
                    </p>

                    <p class="mt-2 text-sm font-semibold text-slate-700">
                        Master Data Management
                    </p>

                </div>


                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-violet-50 text-violet-600">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3 7h18M3 12h18M3 17h18" />

                    </svg>

                </div>

            </div>

        </div>

    </div>


    <!-- Categories Table -->
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <!-- Table Header -->
        <div class="flex flex-col gap-3 border-b border-slate-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <h2 class="text-base font-semibold text-slate-900">
                    Category List
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    View and manage all available purchase categories.
                </p>

            </div>

        </div>


        <!-- Responsive Table -->
        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-slate-200">

                <thead class="bg-slate-50">

                    <tr>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                            Category
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider text-slate-500">
                            Purchase Records
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider text-slate-500">
                            Status
                        </th>

                        <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-slate-500">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-100 bg-white">

                    @forelse($categories as $category)

                    <tr class="transition hover:bg-slate-50">

                        <!-- Category -->
                        <td class="whitespace-nowrap px-6 py-4">

                            <div class="flex items-center gap-3">

                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600">

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
                                            d="M4 6h16M4 10h16M4 14h16M4 18h16" />

                                    </svg>

                                </div>


                                <div>

                                    <div class="font-semibold text-slate-800">
                                        {{ $category->name }}
                                    </div>

                                    <div class="text-xs text-slate-400">
                                        Category ID: #{{ $category->id }}
                                    </div>

                                </div>

                            </div>

                        </td>


                        <!-- Purchase Records -->
                        <td class="whitespace-nowrap px-6 py-4 text-center">

                            <span class="inline-flex min-w-[40px] items-center justify-center rounded-lg bg-slate-100 px-3 py-1.5 text-sm font-semibold text-slate-700">

                                {{ $category->assets_count }}

                            </span>

                        </td>


                        <!-- Status -->
                        <td class="whitespace-nowrap px-6 py-4 text-center">

                            @if($category->is_active)

                            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700">

                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>

                                Active

                            </span>

                            @else

                            <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-600">

                                <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>

                                Inactive

                            </span>

                            @endif

                        </td>


                        <!-- Actions -->
                        <td class="whitespace-nowrap px-6 py-4 text-right">

                            <div class="flex items-center justify-end gap-2">


                                <!-- Edit -->
                                <a
                                    href="{{ route('categories.edit', $category) }}"

                                    class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-blue-600 transition hover:bg-blue-50"
                                    title="Edit Category">

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
                                            d="M15.232 5.232l3.536 3.536M9 11l6-6 3 3-6 6-4 1 1-4z" />

                                    </svg>

                                </a>


                                <!-- Delete -->
                                <form
                                    method="POST"
                                    action="{{ route('categories.destroy', $category) }}">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        data-confirm="Delete this category? This action cannot be undone."

                                        class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-red-500 transition hover:bg-red-50"
                                        title="Delete Category">

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
                                                d="M6 7h12M9 7V5h6v2m-7 3v8m4-8v8m4-8v8M5 7l1 14h12l1-14" />

                                        </svg>

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>


                    @empty

                    <tr>

                        <td colspan="4" class="px-6 py-16 text-center">

                            <div class="flex flex-col items-center">

                                <div class="flex h-16 w-16 items-center justify-center rounded-full bg-slate-100 text-slate-400">

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-8 w-8"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="2">

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M4 6h16M4 10h16M4 14h16M4 18h16" />

                                    </svg>

                                </div>

                                <h3 class="mt-4 text-sm font-semibold text-slate-700">
                                    No categories found
                                </h3>

                                <p class="mt-1 text-sm text-slate-500">
                                    Create your first category to get started.
                                </p>

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        <!-- Pagination -->
        @if($categories->hasPages())

        <div class="border-t border-slate-200 px-6 py-4">

            {{ $categories->links() }}

        </div>

        @endif

    </div>

</div>

@endsection