@extends('layouts.app')

@section('title', 'Departments')
@section('breadcrumb', 'Departments')

@section('content')

    <div class="space-y-6">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <div class="text-xs font-bold tracking-widest text-blue-600">
                    ORGANIZATION
                </div>

                <h1 class="mt-1 text-2xl font-bold text-slate-900">
                    Departments
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Manage company departments for asset assignments.
                </p>

            </div>

            @can('departments.create')
                <a href="{{ route('departments.create') }}"
                    class="rounded-xl bg-blue-600 px-5 py-3 text-center text-sm font-semibold text-white shadow-lg shadow-blue-200 transition hover:bg-blue-700">

                    + Add Department

                </a>
            @endcan

        </div>


        <!-- Search -->
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">

            <form method="GET" class="flex flex-col gap-3 sm:flex-row">

                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search department..."
                    class="flex-1 rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

                <button type="submit" class="rounded-xl bg-slate-900 px-6 py-3 text-sm font-semibold text-white">

                    Search

                </button>

                <a href="{{ route('departments.index') }}"
                    class="rounded-xl border border-slate-300 px-6 py-3 text-center text-sm font-semibold text-slate-600">

                    Reset

                </a>

            </form>

        </div>


        <!-- Table -->
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="overflow-x-auto">

                <table class="min-w-full">

                    <thead class="border-b bg-slate-50">

                        <tr>

                            <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                Department
                            </th>

                            <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                Description
                            </th>

                            <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                Status
                            </th>

                            <th class="px-5 py-4 text-right text-xs font-bold uppercase tracking-wider text-slate-500">
                                Action
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100">

                        @forelse($departments as $department)
                            <tr class="hover:bg-slate-50">

                                <td class="px-5 py-4 font-semibold text-slate-800">

                                    {{ $department->name }}

                                </td>


                                <td class="px-5 py-4 text-sm text-slate-500">

                                    {{ $department->description ?: '-' }}

                                </td>


                                <td class="px-5 py-4">

                                    @if ($department->is_active)
                                        <span class="rounded-full bg-green-50 px-3 py-1 text-xs font-bold text-green-700">
                                            Active
                                        </span>
                                    @else
                                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-500">
                                            Inactive
                                        </span>
                                    @endif

                                </td>


                                <td class="px-5 py-4">

                                    <div class="flex justify-end gap-2">

                                        @can('departments.update')
                                            <a href="{{ route('departments.edit', $department) }}"
                                                class="rounded-lg bg-blue-50 px-3 py-2 text-xs font-semibold text-blue-700 hover:bg-blue-100">

                                                Edit

                                            </a>
                                        @endcan


                                        @can('departments.delete')
                                            <form method="POST" action="{{ route('departments.destroy', $department) }}">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" data-confirm="Delete this department?"
                                                    class="rounded-lg bg-red-50 px-3 py-2 text-xs font-semibold text-red-600 hover:bg-red-100">

                                                    Delete

                                                </button>

                                            </form>
                                        @endcan

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="4" class="px-6 py-14 text-center text-sm text-slate-400">

                                    No departments found.

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{ $departments->links() }}

    </div>

@endsection
