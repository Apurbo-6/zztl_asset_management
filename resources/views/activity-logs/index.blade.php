@extends('layouts.app')

@section('title', 'Activity Logs')
@section('breadcrumb', 'Activity Logs')

@section('content')

<!-- Page Header -->
<div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

    <div>

        <div class="mb-2 text-xs font-bold tracking-[0.2em] text-blue-600">
            SYSTEM AUDIT
        </div>

        <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
            Activity Logs
        </h1>

        <p class="mt-2 text-sm text-slate-500">
            Track who changed what and when.
        </p>

    </div>


    <!-- Record Count -->
    <div class="rounded-xl border border-slate-200 bg-white px-4 py-3 shadow-sm">

        <div class="text-xs font-medium text-slate-500">
            Total Records
        </div>

        <div class="mt-1 text-lg font-bold text-slate-900">
            {{ $logs->total() }}
        </div>

    </div>

</div>


<!-- Main Panel -->
<div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">


    <!-- Filter Header -->
    <div class="border-b border-slate-100 px-5 py-5 sm:px-6">

        <div class="flex flex-col gap-1">

            <h2 class="text-lg font-bold text-slate-900">
                System Activity
            </h2>

            <p class="text-sm text-slate-500">
                Search and filter system activity records.
            </p>

        </div>

    </div>


    <!-- Filters -->
    <div class="border-b border-slate-100 bg-slate-50 px-5 py-5 sm:px-6">

        <form
            method="GET"
            class="grid gap-3 md:grid-cols-2 lg:grid-cols-4">


            <!-- Search -->
            <div class="relative lg:col-span-2">

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="pointer-events-none absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="m21 21-4.35-4.35m1.35-5.15a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z" />

                </svg>

                <input
                    type="text"
                    name="q"
                    placeholder="Search activity..."
                    value="{{ request('q') }}"
                    class="w-full rounded-xl border border-slate-300 bg-white py-3 pl-10 pr-4 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

            </div>


            <!-- Module -->
            <div>

                <input
                    type="text"
                    name="module"
                    placeholder="Module (assets, users...)"
                    value="{{ request('module') }}"
                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

            </div>


            <!-- Buttons -->
            <div class="flex gap-2">

                <button
                    type="submit"
                    class="inline-flex flex-1 items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white shadow-md shadow-blue-600/20 transition hover:bg-blue-700 active:scale-[0.98]">

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
                            d="M21 21l-4.35-4.35M17.5 11.5a6 6 0 11-12 0 6 6 0 0112 0z" />

                    </svg>

                    Search

                </button>


                <a
                    href="{{ route('activity-logs.index') }}"
                    class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-100"
                    title="Reset Filters">

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
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9M4.582 9H9m11 11v-5h-.581m0 0A8.003 8.003 0 014.582 15m15.418 0H15" />

                    </svg>

                </a>

            </div>

        </form>

    </div>


    <!-- Table -->
    <div class="overflow-x-auto">

        <table class="min-w-full divide-y divide-slate-200">

            <thead class="bg-slate-50">

                <tr>

                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                        Activity
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                        Module
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                        User
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                        IP Address
                    </th>

                    <th class="whitespace-nowrap px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                        Date & Time
                    </th>

                </tr>

            </thead>


            <tbody class="divide-y divide-slate-100 bg-white">

                @forelse($logs as $log)

                <tr class="transition hover:bg-slate-50/80">


                    <!-- Activity -->
                    <td class="min-w-[300px] px-6 py-5">

                        <div class="font-semibold text-slate-900">

                            {{ $log->description }}

                        </div>


                        <!-- Changes -->
                        @if($log->old_values || $log->new_values)

                        <details class="mt-3">

                            <summary class="inline-flex cursor-pointer items-center gap-2 text-sm font-medium text-blue-600 transition hover:text-blue-700">

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
                                        d="M12 4.5v15m7.5-7.5h-15" />

                                </svg>

                                View Changes

                            </summary>


                            <div class="mt-3 overflow-hidden rounded-xl border border-slate-200 bg-slate-950">

                                <pre class="max-h-72 overflow-auto p-4 text-xs leading-6 text-slate-200">{{ json_encode([
'old' => $log->old_values,
'new' => $log->new_values
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>

                            </div>

                        </details>

                        @endif

                    </td>


                    <!-- Module / Action -->
                    <td class="whitespace-nowrap px-6 py-5">

                        <div class="inline-flex rounded-lg bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700">

                            {{ ucfirst($log->module) }}

                        </div>


                        <div class="mt-2 text-xs font-medium text-slate-400">

                            {{ ucfirst($log->action) }}

                        </div>

                    </td>


                    <!-- User -->
                    <td class="whitespace-nowrap px-6 py-5">

                        @if($log->user)

                        <div class="flex items-center gap-3">

                            <div class="flex h-9 w-9 items-center justify-center rounded-full bg-slate-100 text-xs font-bold text-slate-600">

                                {{ strtoupper(substr($log->user->name, 0, 1)) }}

                            </div>


                            <span class="text-sm font-medium text-slate-700">

                                {{ $log->user->name }}

                            </span>

                        </div>

                        @else

                        <span class="inline-flex rounded-full bg-slate-100 px-3 py-1.5 text-xs font-medium text-slate-500">

                            System

                        </span>

                        @endif

                    </td>


                    <!-- IP Address -->
                    <td class="whitespace-nowrap px-6 py-5">

                        @if($log->ip_address)

                        <code class="rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-medium text-slate-600">

                            {{ $log->ip_address }}

                        </code>

                        @else

                        <span class="text-slate-400">
                            —
                        </span>

                        @endif

                    </td>


                    <!-- Date -->
                    <td class="whitespace-nowrap px-6 py-5">

                        <div class="text-sm font-semibold text-slate-700">

                            {{ $log->created_at?->format('d M Y') }}

                        </div>

                        <div class="mt-1 text-xs text-slate-400">

                            {{ $log->created_at?->format('h:i A') }}

                        </div>

                    </td>

                </tr>

                @empty

                <!-- Empty State -->
                <tr>

                    <td
                        colspan="5"
                        class="px-6 py-16 text-center">


                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-slate-100">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-7 w-7 text-slate-400"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8">

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-2M9 5a2 2 0 002-2h2a2 2 0 012 2m-6 0h6" />

                            </svg>

                        </div>


                        <h3 class="mt-4 font-semibold text-slate-800">
                            No activity recorded
                        </h3>

                        <p class="mt-1 text-sm text-slate-500">
                            System activity will appear here.
                        </p>

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    <!-- Pagination -->
    @if($logs->hasPages())

    <div class="border-t border-slate-100 px-5 py-4 sm:px-6">

        {{ $logs->links() }}

    </div>

    @endif

</div>

@endsection