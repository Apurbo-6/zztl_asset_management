@extends('layouts.app')

@section('title', 'Asset Assignments')
@section('breadcrumb', 'Asset Assignments')

@section('content')

    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

        <div>

            <div class="text-xs font-bold tracking-widest text-blue-600">
                ASSET MANAGEMENT
            </div>

            <h1 class="mt-2 text-2xl font-bold text-slate-900">
                Asset Assignments
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Track assets assigned to departments and personnel.
            </p>

        </div>


        @can('asset_assignments.create')
            <a href="{{ route('asset-assignments.create') }}"
                class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">

                + Assign Asset

            </a>
        @endcan

    </div>


    <!-- Filters -->
    <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

        <form method="GET" class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-5">

            <input type="text" name="q" value="{{ request('q') }}" placeholder="Asset, serial, person..."
                class="rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500">


            <select name="department_id"
                class="rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500">

                <option value="">
                    All Departments
                </option>

                @foreach ($departments as $department)
                    <option value="{{ $department->id }}" @selected(request('department_id') == $department->id)>

                        {{ $department->name }}

                    </option>
                @endforeach

            </select>


            <select name="status"
                class="rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500">

                <option value="">
                    All Status
                </option>

                <option value="assigned" @selected(request('status') === 'assigned')>
                    Assigned
                </option>

                <option value="returned" @selected(request('status') === 'returned')>
                    Returned
                </option>

            </select>


            <button type="submit"
                class="rounded-xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white hover:bg-slate-800">

                Search

            </button>


            <a href="{{ route('asset-assignments.index') }}"
                class="rounded-xl border border-slate-300 px-4 py-3 text-center text-sm font-semibold text-slate-700 hover:bg-slate-50">

                Reset

            </a>

        </form>

    </div>


    <!-- Assignment Table -->
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="overflow-x-auto">

            <table class="w-full min-w-[1100px] text-left text-sm">

                <thead class="bg-slate-50 text-xs font-bold uppercase tracking-wide text-slate-500">

                    <tr>

                        <th class="px-6 py-4">Asset</th>
                        <th class="px-6 py-4">Serial Number</th>
                        <th class="px-6 py-4">Department</th>
                        <th class="px-6 py-4">Assigned To</th>
                        <th class="px-6 py-4">Assigned Date</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Action</th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-100">

                    @forelse($assignments as $assignment)
                        <tr class="transition hover:bg-slate-50">

                            <td class="px-6 py-4">

                                <a href="{{ route('assets.show', $assignment->asset) }}"
                                    class="font-semibold text-slate-900 hover:text-blue-600">

                                    {{ $assignment->asset?->particular_items ?? '—' }}

                                </a>

                            </td>


                            <td class="px-6 py-4 font-mono text-xs text-slate-600">

                                {{ $assignment->asset?->serial_number ?: '—' }}

                            </td>


                            <td class="px-6 py-4 text-slate-600">

                                {{ $assignment->department?->name ?? '—' }}

                            </td>


                            <td class="px-6 py-4 font-medium text-slate-700">

                                {{ $assignment->assigned_to ?: '—' }}

                            </td>


                            <td class="px-6 py-4 text-slate-600">

                                {{ $assignment->assigned_date?->format('d M Y') }}

                            </td>


                            <td class="px-6 py-4">

                                @if ($assignment->status === 'assigned')
                                    <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                                        Assigned
                                    </span>
                                @else
                                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                                        Returned
                                    </span>
                                @endif

                            </td>


                            <td class="px-6 py-4 text-right">

                                <a href="{{ route('asset-assignments.edit', $assignment) }}"
                                    class="font-semibold text-blue-600 hover:text-blue-800">

                                    Manage →

                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7" class="px-6 py-12 text-center text-slate-500">

                                No asset assignments found.

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>


        @if (method_exists($assignments, 'links'))
            <div class="border-t border-slate-200 px-6 py-4">

                {{ $assignments->links() }}

            </div>
        @endif

    </div>

@endsection
