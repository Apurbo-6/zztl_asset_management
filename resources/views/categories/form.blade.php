@extends('layouts.app')

@section('title', $category->exists ? 'Edit Category' : 'Add Category')
@section('breadcrumb', 'Categories')

@section('content')

<div class="mx-auto max-w-3xl">

    <!-- Page Header -->
    <div class="mb-8">

        <div class="mb-2 text-xs font-bold tracking-[0.2em] text-blue-600">
            MASTER DATA
        </div>

        <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
            {{ $category->exists ? 'Edit Category' : 'Add Category' }}
        </h1>

        <p class="mt-2 text-sm text-slate-500">
            {{ $category->exists
                ? 'Update the category information below.'
                : 'Create a new purchase item category for the asset management system.' }}
        </p>

    </div>


    <!-- Form Card -->
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <!-- Card Header -->
        <div class="border-b border-slate-200 px-6 py-5">

            <h2 class="text-base font-semibold text-slate-900">
                Category Information
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Fields marked with * are required.
            </p>

        </div>


        <form
            method="POST"
            action="{{ $category->exists
                ? route('categories.update', $category)
                : route('categories.store') }}"
            class="p-6">

            @csrf

            @if($category->exists)
            @method('PUT')
            @endif


            <!-- Category Name -->
            <div>

                <label
                    for="name"
                    class="mb-2 block text-sm font-semibold text-slate-700">

                    Category Name
                    <span class="text-red-500">*</span>

                </label>


                <input
                    id="name"
                    type="text"
                    name="name"
                    required
                    maxlength="150"
                    value="{{ old('name', $category->name) }}"
                    placeholder="Enter category name"

                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 @error('name') border-red-500 focus:border-red-500 focus:ring-red-100 @enderror">


                @error('name')

                <p class="mt-2 text-sm font-medium text-red-600">
                    {{ $message }}
                </p>

                @enderror

            </div>


            <!-- Active Status -->
            @if($category->exists)

            <div class="mt-6">

                <label class="flex cursor-pointer items-center gap-3">

                    <input
                        type="checkbox"
                        name="is_active"
                        value="1"

                        @checked(old('is_active', $category->is_active))

                    class="h-5 w-5 rounded border-slate-300 text-blue-600 focus:ring-blue-500">


                    <div>

                        <div class="text-sm font-semibold text-slate-700">
                            Active Category
                        </div>

                        <div class="mt-0.5 text-xs text-slate-500">
                            Enable this category for future purchase records.
                        </div>

                    </div>

                </label>

            </div>

            @endif


            <!-- Actions -->
            <div class="mt-8 flex flex-col-reverse gap-3 border-t border-slate-200 pt-6 sm:flex-row sm:items-center sm:justify-end">

                <a
                    href="{{ route('categories.index') }}"

                    class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 hover:text-slate-900">

                    Cancel

                </a>


                <button
                    type="submit"

                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700 hover:shadow-xl active:scale-[0.98]">

                    <!-- Save Icon -->
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
                            d="M5 13l4 4L19 7" />

                    </svg>

                    {{ $category->exists ? 'Update Category' : 'Save Category' }}

                </button>

            </div>

        </form>

    </div>

</div>

@endsection