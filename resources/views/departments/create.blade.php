@extends('layouts.app')

@section('title', 'Create Department')
@section('breadcrumb', 'Create Department')

@section('content')

    <div class="mb-8 flex items-start justify-between">

        <div>

            <div class="text-xs font-bold tracking-widest text-blue-600">
                ADMINISTRATION
            </div>

            <h1 class="mt-2 text-2xl font-bold text-slate-900">
                Create Department
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Add a new department for asset assignment.
            </p>

        </div>


        <a href="{{ route('departments.index') }}"
            class="rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">

            ← Back

        </a>

    </div>


    <div class="max-w-3xl rounded-2xl border border-slate-200 bg-white p-6 shadow-sm md:p-8">

        <form method="POST" action="{{ route('departments.store') }}" class="space-y-6">

            @csrf


            <!-- Department Name -->
            <div>

                <label class="mb-2 block text-sm font-semibold text-slate-700">

                    Department Name <span class="text-red-500">*</span>

                </label>

                <input type="text" name="name" value="{{ old('name') }}" required
                    placeholder="Example: Software Development"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

            </div>


            <!-- Description -->
            <div>

                <label class="mb-2 block text-sm font-semibold text-slate-700">

                    Description

                </label>

                <textarea name="description" rows="4" placeholder="Department description..."
                    class="w-full resize-none rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100">{{ old('description') }}</textarea>

            </div>


            <!-- Status -->
            <div>

                <label class="flex cursor-pointer items-center gap-3">

                    <input type="checkbox" name="is_active" value="1" checked
                        class="h-5 w-5 rounded border-slate-300 text-blue-600 focus:ring-blue-500">

                    <div>

                        <div class="text-sm font-semibold text-slate-700">
                            Active Department
                        </div>

                        <div class="text-xs text-slate-500">
                            This department can receive asset assignments.
                        </div>

                    </div>

                </label>

            </div>


            <!-- Actions -->
            <div class="flex flex-col-reverse gap-3 border-t border-slate-200 pt-6 sm:flex-row sm:justify-end">

                <a href="{{ route('departments.index') }}"
                    class="rounded-xl border border-slate-300 px-5 py-3 text-center text-sm font-semibold text-slate-700 hover:bg-slate-50">

                    Cancel

                </a>

                <button type="submit"
                    class="rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">

                    Create Department

                </button>

            </div>

        </form>

    </div>

@endsection
