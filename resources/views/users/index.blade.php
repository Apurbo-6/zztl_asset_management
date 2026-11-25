@extends('layouts.app')

@section('title', 'Users & Roles')
@section('breadcrumb', 'Administration / Users')

@section('content')

<!-- Page Header -->
<div class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

    <div>

        <div class="mb-2 text-xs font-bold tracking-[0.2em] text-blue-600">
            ADMINISTRATION
        </div>

        <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
            Users & Roles
        </h1>

        <p class="mt-2 text-sm text-slate-500">
            Manage system login accounts and assigned roles.
        </p>

    </div>


    <!-- Create User Button -->
    <a
        href="{{ route('users.create') }}"
        class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700 hover:shadow-xl active:scale-[0.98]">

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
                d="M12 4.5v15m7.5-7.5h-15" />

        </svg>

        Create User

    </a>

</div>


<!-- Users Table -->
<div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

    <div class="border-b border-slate-100 px-6 py-5">

        <h2 class="text-lg font-bold text-slate-900">
            System Users
        </h2>

        <p class="mt-1 text-sm text-slate-500">
            View and manage user accounts and permissions.
        </p>

    </div>


    <div class="overflow-x-auto">

        <table class="min-w-full divide-y divide-slate-200">

            <thead class="bg-slate-50">

                <tr>

                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                        User
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                        Email
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                        Role
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                        Status
                    </th>

                    <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-slate-500">
                        Action
                    </th>

                </tr>

            </thead>


            <tbody class="divide-y divide-slate-100 bg-white">

                @forelse($users as $u)

                <tr class="transition hover:bg-slate-50/80">

                    <!-- User -->
                    <td class="whitespace-nowrap px-6 py-4">

                        <div class="flex items-center gap-3">

                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blue-50 text-sm font-bold text-blue-600">

                                {{ strtoupper(substr($u->name, 0, 1)) }}

                            </div>

                            <div>

                                <div class="font-semibold text-slate-900">
                                    {{ $u->name }}
                                </div>

                                <div class="mt-0.5 text-xs text-slate-400">
                                    System User
                                </div>

                            </div>

                        </div>

                    </td>


                    <!-- Email -->
                    <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">

                        {{ $u->email }}

                    </td>


                    <!-- Role -->
                    <td class="whitespace-nowrap px-6 py-4">

                        @if($u->getRoleNames()->isNotEmpty())

                        <div class="flex flex-wrap gap-2">

                            @foreach($u->getRoleNames() as $role)

                            <span class="inline-flex rounded-full bg-purple-50 px-3 py-1 text-xs font-semibold text-purple-700">
                                {{ $role }}
                            </span>

                            @endforeach

                        </div>

                        @else

                        <span class="text-sm text-slate-400">
                            No role
                        </span>

                        @endif

                    </td>


                    <!-- Status -->
                    <td class="whitespace-nowrap px-6 py-4">

                        @if($u->is_active)

                        <span class="inline-flex items-center gap-2 rounded-full bg-green-50 px-3 py-1.5 text-xs font-semibold text-green-700">

                            <span class="h-2 w-2 rounded-full bg-green-500"></span>

                            Active

                        </span>

                        @else

                        <span class="inline-flex items-center gap-2 rounded-full bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-700">

                            <span class="h-2 w-2 rounded-full bg-red-500"></span>

                            Inactive

                        </span>

                        @endif

                    </td>


                    <!-- Actions -->
                    <td class="whitespace-nowrap px-6 py-4">

                        <div class="flex items-center justify-end gap-2">

                            <!-- Edit -->
                            <a
                                href="{{ route('users.edit', $u) }}"
                                class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-blue-600 transition hover:bg-blue-50"
                                title="Edit User">

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
                                        d="M16.862 4.487a2.1 2.1 0 113 2.97L8.25 19.07l-4.125 1.155 1.155-4.125L16.862 4.487z" />

                                </svg>

                            </a>


                            <!-- Deactivate -->
                            <form
                                method="POST"
                                action="{{ route('users.destroy', $u) }}">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    data-confirm="Deactivate this user?"
                                    class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-red-600 transition hover:bg-red-50"
                                    title="Deactivate User">

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
                                            d="M6 18L18 6M6 6l12 12" />

                                    </svg>

                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

                @empty

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
                                    d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 21a7.5 7.5 0 0115 0" />

                            </svg>

                        </div>

                        <h3 class="mt-4 font-semibold text-slate-800">
                            No users found
                        </h3>

                        <p class="mt-1 text-sm text-slate-500">
                            Create a user account to get started.
                        </p>

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    <!-- Pagination -->
    @if($users->hasPages())

    <div class="border-t border-slate-100 px-5 py-4">

        {{ $users->links() }}

    </div>

    @endif

</div>

@endsection