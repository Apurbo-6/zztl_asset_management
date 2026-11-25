@extends('layouts.app')

@section('title', $role->exists ? 'Edit Role' : 'Create Role')
@section('breadcrumb', 'Administration / Roles')

@section('content')

<div class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

    <div>

        <div class="mb-2 text-xs font-bold tracking-[0.2em] text-blue-600">
            ACCESS CONTROL
        </div>

        <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
            {{ $role->exists ? 'Edit Role' : 'Create Role' }}
        </h1>

        <p class="mt-2 text-sm text-slate-500">
            Select the permissions that members of this role should receive.
        </p>

    </div>


    <a href="{{ route('roles.index') }}"
        class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">

        <svg xmlns="http://www.w3.org/2000/svg"
            class="h-4 w-4"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2">

            <path stroke-linecap="round"
                stroke-linejoin="round"
                d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />

        </svg>

        Back to Roles

    </a>

</div>


<form method="POST"
    action="{{ $role->exists ? route('roles.update', $role) : route('roles.store') }}"
    class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

    @csrf

    @if($role->exists)
    @method('PUT')
    @endif


    <!-- Role Information -->
    <div class="border-b border-slate-200 p-5 sm:p-6">

        <div class="mb-6">

            <h2 class="text-lg font-bold text-slate-900">
                Role Information
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Define the name for this access role.
            </p>

        </div>


        <div class="max-w-xl">

            <label class="mb-2 block text-sm font-semibold text-slate-700">
                Role Name <span class="text-red-500">*</span>
            </label>


            <input type="text"
                name="name"
                value="{{ old('name', $role->name) }}"
                required
                @disabled($role->name === 'Super Admin')
            placeholder="Example: Manager"
            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 disabled:cursor-not-allowed disabled:bg-slate-100">

            @if($role->name === 'Super Admin')

            <p class="mt-2 text-xs font-medium text-amber-600">
                The Super Admin role cannot be renamed.
            </p>

            @endif

        </div>

    </div>


    <!-- Permissions -->
    <div class="p-5 sm:p-6">

        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <h2 class="text-lg font-bold text-slate-900">
                    Permissions
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Select the permissions that members of this role should receive.
                </p>

            </div>

            <div class="self-start rounded-lg bg-blue-50 px-3 py-2 text-xs font-semibold text-blue-700">
                {{ $permissions->count() }} Available Permissions
            </div>

        </div>


        @php
        $selectedPermissions = collect(
        old(
        'permission_ids',
        $role->exists
        ? $role->permissions->pluck('id')->all()
        : []
        )
        );
        @endphp


        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-3">

            @foreach($permissions as $permission)

            <label class="group flex items-center gap-3 rounded-xl border border-slate-200 bg-white p-4 transition
                {{ $role->name === 'Super Admin'
                    ? 'cursor-not-allowed opacity-70'
                    : 'cursor-pointer hover:border-blue-300 hover:bg-blue-50/50' }}">

                <input type="checkbox"
                    name="permission_ids[]"
                    value="{{ $permission->id }}"
                    @checked($selectedPermissions->contains($permission->id))
                @disabled($role->name === 'Super Admin')
                class="h-5 w-5 rounded border-slate-300 text-blue-600 focus:ring-2 focus:ring-blue-500">


                <span class="text-sm font-semibold text-slate-800">
                    {{ $permission->name }}
                </span>

            </label>

            @endforeach

        </div>

    </div>


    <!-- Actions -->
    <div class="flex flex-col-reverse gap-3 border-t border-slate-200 bg-slate-50 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">

        <a href="{{ route('roles.index') }}"
            class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">

            Cancel

        </a>


        @if($role->name !== 'Super Admin')

        <button type="submit"
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700 active:scale-[0.98]">

            <svg xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2">

                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M5 13l4 4L19 7" />

            </svg>

            {{ $role->exists ? 'Update Role' : 'Save Role' }}

        </button>

        @endif

    </div>

</form>

@endsection