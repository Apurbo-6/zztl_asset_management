@extends('layouts.app')

@section('title', 'Assign Asset')
@section('breadcrumb', 'Assign Asset')

@section('content')

    <div class="mb-8 flex items-start justify-between">

        <div>

            <div class="text-xs font-bold tracking-widest text-blue-600">
                ASSET ASSIGNMENT
            </div>

            <h1 class="mt-2 text-2xl font-bold text-slate-900">
                Assign Asset
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Assign an individual asset to a department or person.
            </p>

        </div>


        <a href="{{ route('asset-assignments.index') }}"
            class="rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">

            ← Back

        </a>

    </div>


    <div class="max-w-4xl rounded-2xl border border-slate-200 bg-white p-6 shadow-sm md:p-8">

        <form method="POST" action="{{ route('asset-assignments.store') }}" class="space-y-6">

            @csrf


            <!-- Asset -->
            <div>

                <label class="mb-2 block text-sm font-semibold text-slate-700">

                    Select Asset <span class="text-red-500">*</span>

                </label>

                <select name="asset_id" required
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

                    <option value="">
                        Select an available asset
                    </option>

                    @foreach ($assets as $asset)
                        <option value="{{ $asset->id }}" @selected(old('asset_id') == $asset->id)>

                            {{ $asset->particular_items }}

                            @if ($asset->serial_number)
                                — SN: {{ $asset->serial_number }}
                            @endif

                        </option>
                    @endforeach

                </select>

            </div>


            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                <!-- Department -->
                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">

                        Department

                    </label>

                    <select name="department_id"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

                        <option value="">
                            Select Department
                        </option>

                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}" @selected(old('department_id') == $department->id)>

                                {{ $department->name }}

                            </option>
                        @endforeach

                    </select>

                </div>


                <!-- Assigned To -->
                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">

                        Assigned To

                    </label>

                    <input type="text" name="assigned_to" value="{{ old('assigned_to') }}"
                        placeholder="Employee / Person name"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

                </div>

            </div>


            <!-- Date -->
            <div>

                <label class="mb-2 block text-sm font-semibold text-slate-700">

                    Assigned Date <span class="text-red-500">*</span>

                </label>

                <input type="date" name="assigned_date" value="{{ old('assigned_date', now()->format('Y-m-d')) }}"
                    required
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

            </div>


            <!-- Remarks -->
            <div>

                <label class="mb-2 block text-sm font-semibold text-slate-700">

                    Remarks

                </label>

                <textarea name="remarks" rows="4" placeholder="Assignment notes..."
                    class="w-full resize-none rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100">{{ old('remarks') }}</textarea>

            </div>


            <!-- Actions -->
            <div class="flex flex-col-reverse gap-3 border-t border-slate-200 pt-6 sm:flex-row sm:justify-end">

                <a href="{{ route('asset-assignments.index') }}"
                    class="rounded-xl border border-slate-300 px-5 py-3 text-center text-sm font-semibold text-slate-700 hover:bg-slate-50">

                    Cancel

                </a>

                <button type="submit"
                    class="rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">

                    Assign Asset

                </button>

            </div>

        </form>

    </div>

@endsection
