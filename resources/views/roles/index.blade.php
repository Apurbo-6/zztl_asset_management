@extends('layouts.app')

@section('title', 'Roles & Permissions')
@section('breadcrumb', 'Administration / Roles')

@section('content')

<div class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

    <div>
        <div class="mb-2 text-xs font-bold tracking-[0.2em] text-blue-600">
            ACCESS CONTROL
        </div>

        <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
            Roles & Permissions
        </h1>

        <p class="mt-2 text-sm text-slate-500">
            Define reusable access profiles for employees and managers.
        </p>
    </div>

    <a href="{{ route('roles.create') }}"
        class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700 active:scale-[0.98]">

        <svg xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2">
            <path stroke-linecap="round"
                stroke-linejoin="round"
                d="M12 4.5v15m7.5-7.5h-15" />
        </svg>

        Create Role
    </a>

</div>


<div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

    <div class="border-b border-slate-200 px-5 py-5 sm:px-6">

        <div class="flex items-center gap-3">

            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 3l7.5 4.5v5.25c0 4.42-3.13 7.91-7.5 9.75-4.37-1.84-7.5-5.33-7.5-9.75V7.5L12 3z" />
                </svg>

            </div>

            <div>
                <h2 class="text-base font-bold text-slate-900">
                    System Roles
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Manage employee roles and access permissions.
                </p>
            </div>

        </div>

    </div>


    <div class="overflow-x-auto">

        <table class="w-full min-w-[700px] text-left">

            <thead class="border-b border-slate-200 bg-slate-50">

                <tr>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                        Role
                    </th>

                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                        Users
                    </th>

                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                        Permissions
                    </th>

                    <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-slate-500">
                        Action
                    </th>
                </tr>

            </thead>


            <tbody class="divide-y divide-slate-100">

                @forelse($roles as $role)

                <tr class="transition hover:bg-slate-50">

                    <td class="px-6 py-5">

                        <div class="flex items-center gap-3">

                            <div class="flex h-10 w-10 items-center justify-center rounded-xl
                                {{ $role->name === 'Super Admin'
                                    ? 'bg-purple-50 text-purple-600'
                                    : 'bg-blue-50 text-blue-600' }}">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2">

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 15.75A3.75 3.75 0 1012 8.25a3.75 3.75 0 000 7.5z" />

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M19.5 12c0 7.5-7.5 9-7.5 9S4.5 19.5 4.5 12 12 3 12 3s7.5 1.5 7.5 9z" />

                                </svg>

                            </div>

                            <div>
                                <div class="font-semibold text-slate-900">
                                    {{ $role->name }}
                                </div>

                                <div class="mt-1 text-xs text-slate-500">
                                    {{ $role->name === 'Super Admin'
                                        ? 'Full system access'
                                        : 'Custom access role' }}
                                </div>
                            </div>

                        </div>

                    </td>


                    <td class="px-6 py-5">

                        <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-sm font-semibold text-slate-700">
                            {{ $role->users_count }}
                            <span class="ml-1 text-xs font-medium text-slate-500">Users</span>
                        </span>

                    </td>


                    <td class="px-6 py-5">

                        <span class="inline-flex items-center rounded-full bg-blue-50 px-3 py-1 text-sm font-semibold text-blue-700">
                            {{ $role->permissions->count() }}
                            <span class="ml-1 text-xs font-medium text-blue-500">Permissions</span>
                        </span>

                    </td>


                    <td class="px-6 py-5 text-right">

                        <a href="{{ route('roles.edit', $role) }}"
                            class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M16.862 4.487l2.651 2.651M4.5 19.5l4.22-1.055L18.46 8.705a1.875 1.875 0 00-2.652-2.652L6.07 15.793 4.5 19.5z" />

                            </svg>

                            Manage

                        </a>

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="4"
                        class="px-6 py-14 text-center text-sm text-slate-500">
                        No roles found.
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    @if($roles->hasPages())

    <div class="border-t border-slate-200 px-5 py-4 sm:px-6">
        {{ $roles->links() }}
    </div>

    @endif

</div>

@endsection