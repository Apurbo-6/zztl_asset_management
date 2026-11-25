@extends('layouts.app')

@section('title', 'Manage Assignment')
@section('breadcrumb', 'Manage Assignment')

@section('content')

    <div class="mb-8 flex items-start justify-between">

        <div>

            <div class="text-xs font-bold tracking-widest text-blue-600">
                ASSET ASSIGNMENT
            </div>

            <h1 class="mt-2 text-2xl font-bold text-slate-900">
                Manage Assignment
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Update assignment information or mark the asset as returned.
            </p>

        </div>


        <a href="{{ route('asset-assignments.index') }}"
            class="rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">

            ← Back

        </a>

    </div>


    <!-- Asset Information -->
    <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

        <div class="text-xs font-bold tracking-widest text-slate-400">
            ASSIGNED ASSET
        </div>

        <div class="mt-3">

            <h2 class="text-lg font-bold text-slate-900">

                {{ $assignment->asset?->particular_items }}

            </h2>

            @if ($assignment->asset?->serial_number)
                <div class="mt-1 font-mono text-sm text-slate-500">

                    Serial: {{ $assignment->asset->serial_number }}

                </div>
            @endif

        </div>

    </div>


    <div class="max-w-4xl rounded-2xl border border-slate-200 bg-white p-6 shadow-sm md:p-8">

        <form method="POST" action="{{ route('asset-assignments.update', $assignment) }}" class="space-y-6">

            @csrf
            @method('PUT')


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
                            <option value="{{ $department->id }}" @selected(old('department_id', $assignment->department_id) == $department->id)>

                                {{ $department->name }}

                            </option>
                        @endforeach

                    </select>

                </div>


                <!-- Assigned Person -->
                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">

                        Assigned To

                    </label>

                    <input type="text" name="assigned_to" value="{{ old('assigned_to', $assignment->assigned_to) }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

                </div>

            </div>


            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                <!-- Assigned Date -->
                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">

                        Assigned Date

                    </label>

                    <input type="date" name="assigned_date"
                        value="{{ old('assigned_date', $assignment->assigned_date?->format('Y-m-d')) }}" required
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

                </div>


                <!-- Status -->
                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">

                        Status

                    </label>

                    <select name="status" id="status"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500">

                        <option value="assigned" @selected(old('status', $assignment->status) === 'assigned')>

                            Assigned

                        </option>

                        <option value="returned" @selected(old('status', $assignment->status) === 'returned')>

                            Returned

                        </option>

                    </select>

                </div>

            </div>


            <!-- Returned Date -->
            <div id="returnedDateWrapper">

                <label class="mb-2 block text-sm font-semibold text-slate-700">

                    Returned Date

                </label>

                <input type="date" name="returned_date"
                    value="{{ old('returned_date', $assignment->returned_date?->format('Y-m-d')) }}"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

            </div>


            <!-- Remarks -->
            <div>

                <label class="mb-2 block text-sm font-semibold text-slate-700">

                    Remarks

                </label>

                <textarea name="remarks" rows="4"
                    class="w-full resize-none rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100">{{ old('remarks', $assignment->remarks) }}</textarea>

            </div>


            <!-- Current Status -->
            <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">

                <div class="text-xs font-semibold uppercase tracking-wide text-slate-400">

                    Current Status

                </div>

                <div class="mt-2">

                    @if ($assignment->status === 'assigned')
                        <span class="rounded-full bg-blue-100 px-3 py-1.5 text-sm font-semibold text-blue-700">
                            Currently Assigned
                        </span>
                    @else
                        <span class="rounded-full bg-slate-200 px-3 py-1.5 text-sm font-semibold text-slate-700">
                            Returned
                        </span>
                    @endif

                </div>

            </div>


            <!-- Buttons -->
            <div class="flex flex-col-reverse gap-3 border-t border-slate-200 pt-6 sm:flex-row sm:justify-end">

                <a href="{{ route('asset-assignments.index') }}"
                    class="rounded-xl border border-slate-300 px-5 py-3 text-center text-sm font-semibold text-slate-700 hover:bg-slate-50">

                    Cancel

                </a>

                <button type="submit"
                    class="rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">

                    Update Assignment

                </button>

            </div>

        </form>

    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const status = document.getElementById('status');
            const returnedDateWrapper = document.getElementById('returnedDateWrapper');

            function toggleReturnedDate() {

                if (status.value === 'returned') {
                    returnedDateWrapper.classList.remove('hidden');
                } else {
                    returnedDateWrapper.classList.add('hidden');
                }

            }

            status.addEventListener('change', toggleReturnedDate);

            toggleReturnedDate();

        });
    </script>

@endsection
