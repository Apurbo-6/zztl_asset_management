@extends('layouts.app')

@section('title', 'Edit Department')
@section('breadcrumb', 'Edit Department')

@section('content')

    <div class="mb-8 flex items-start justify-between">

        <div>

            <div class="text-xs font-bold tracking-widest text-blue-600">
                ADMINISTRATION
            </div>

            <h1 class="mt-2 text-2xl font-bold text-slate-900">
                Edit Department
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Update department information.
            </p>

        </div>


        <a href="{{ route('departments.index') }}"
            class="rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">

            ← Back

        </a>

    </div>


    <div class="max-w-3xl rounded-2xl border border-slate-200 bg-white p-6 shadow-sm md:p-8">

        <form method="POST" action="{{ route('departments.update', $department) }}" class="space-y-6">

            @csrf
            @method('PUT')


            <div>

                <label class="mb-2 block text-sm font-semibold text-slate-700">

                    Department Name <span class="text-red-500">*</span>

                </label>

                <input type="text" name="name" value="{{ old('name', $department->name) }}" required
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

            </div>


            <div>

                <label class="mb-2 block text-sm font-semibold text-slate-700">

                    Description

                </label>

                <textarea name="description" rows="4"
                    class="w-full resize-none rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100">{{ old('description', $department->description) }}</textarea>

            </div>


            <div>

                <label class="flex cursor-pointer items-center gap-3">

                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $department->is_active))
                        class="h-5 w-5 rounded border-slate-300 text-blue-600">

                    <div>

                        <div class="text-sm font-semibold text-slate-700">
                            Active Department
                        </div>

                        <div class="text-xs text-slate-500">
                            Enable this department for asset assignments.
                        </div>

                    </div>

                </label>

            </div>


            <div class="flex flex-col-reverse gap-3 border-t border-slate-200 pt-6 sm:flex-row sm:justify-end">

                <a href="{{ route('departments.index') }}"
                    class="rounded-xl border border-slate-300 px-5 py-3 text-center text-sm font-semibold text-slate-700 hover:bg-slate-50">

                    Cancel

                </a>

                <button type="submit"
                    class="rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">

                    Update Department

                </button>

            </div>

        </form>

    </div>

@endsection
