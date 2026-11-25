@extends('layouts.app')

@section('title', $user->exists ? 'Edit User' : 'Create User')
@section('breadcrumb', 'Administration / Users')

@section('content')

<!-- Page Header -->
<div class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

    <div>

        <div class="mb-2 text-xs font-bold tracking-[0.2em] text-blue-600">
            ADMINISTRATION
        </div>

        <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">

            {{ $user->exists ? 'Edit User' : 'Create User' }}

        </h1>

        <p class="mt-2 text-sm text-slate-500">

            {{ $user->exists
                    ? 'Update user account information, role and permissions.'
                    : 'Create a new system login account and assign permissions.' }}

        </p>

    </div>


    <a
        href="{{ route('users.index') }}"
        class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">

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
                d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />

        </svg>

        Back to Users

    </a>

</div>


<form
    method="POST"
    action="{{ $user->exists ? route('users.update', $user) : route('users.store') }}">

    @csrf

    @if($user->exists)
    @method('PUT')
    @endif


    <div class="grid gap-6 lg:grid-cols-3">


        <!-- Main Form -->
        <div class="space-y-6 lg:col-span-2">


            <!-- Account Information -->
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-100 px-6 py-5">

                    <h2 class="text-lg font-bold text-slate-900">
                        Account Information
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Basic information for this system user.
                    </p>

                </div>


                <div class="grid gap-5 p-6 sm:grid-cols-2">


                    <!-- Name -->
                    <div>

                        <label class="mb-2 block text-sm font-semibold text-slate-700">

                            Full Name <span class="text-red-500">*</span>

                        </label>

                        <input
                            type="text"
                            name="name"
                            value="{{ old('name', $user->name) }}"
                            required
                            placeholder="Enter full name"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

                    </div>


                    <!-- Email -->
                    <div>

                        <label class="mb-2 block text-sm font-semibold text-slate-700">

                            Email Address <span class="text-red-500">*</span>

                        </label>

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email', $user->email) }}"
                            required
                            placeholder="name@zztl.com"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

                    </div>

                </div>

            </div>


            <!-- Security -->
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-100 px-6 py-5">

                    <h2 class="text-lg font-bold text-slate-900">
                        Security
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">

                        {{ $user->exists
                                ? 'Leave the password fields empty if you do not want to change the current password.'
                                : 'Set a secure password for this user account.' }}

                    </p>

                </div>


                <div class="grid gap-5 p-6 sm:grid-cols-2">


                    <!-- Password -->
                    <div>

                        <label class="mb-2 block text-sm font-semibold text-slate-700">

                            Password

                            @if(!$user->exists)
                            <span class="text-red-500">*</span>
                            @endif

                        </label>


                        <div class="relative">

                            <input
                                id="password"
                                type="password"
                                name="password"
                                {{ $user->exists ? '' : 'required' }}
                                placeholder="Enter password"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 pr-12 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100">


                            <button
                                type="button"
                                onclick="togglePassword('password', 'passwordEye')"
                                class="absolute inset-y-0 right-0 flex w-12 items-center justify-center text-slate-400 transition hover:text-blue-600">

                                <svg
                                    id="passwordEye"
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2">

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12z" />

                                    <circle
                                        cx="12"
                                        cy="12"
                                        r="2.5" />

                                </svg>

                            </button>

                        </div>

                    </div>


                    <!-- Confirm Password -->
                    <div>

                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Confirm Password
                        </label>


                        <div class="relative">

                            <input
                                id="password_confirmation"
                                type="password"
                                name="password_confirmation"
                                placeholder="Confirm password"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 pr-12 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100">


                            <button
                                type="button"
                                onclick="togglePassword('password_confirmation', 'confirmPasswordEye')"
                                class="absolute inset-y-0 right-0 flex w-12 items-center justify-center text-slate-400 transition hover:text-blue-600">

                                <svg
                                    id="confirmPasswordEye"
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2">

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12z" />

                                    <circle
                                        cx="12"
                                        cy="12"
                                        r="2.5" />

                                </svg>

                            </button>

                        </div>

                    </div>

                </div>

            </div>


            <!-- Individual Permissions -->
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-100 px-6 py-5">

                    <h2 class="text-lg font-bold text-slate-900">
                        Additional Individual Permissions
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        These permissions are granted directly to this user in addition to the selected role.
                    </p>

                </div>


                <div class="p-6">

                    <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">

                        @foreach($permissions as $permission)

                        <label
                            class="flex cursor-pointer items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 p-4 transition hover:border-blue-300 hover:bg-blue-50">

                            <input
                                type="checkbox"
                                name="permission_ids[]"
                                value="{{ $permission->id }}"

                                @checked(
                                collect(
                                old( 'permission_ids' ,
                                $user->exists
                            ? $user->getDirectPermissions()->pluck('id')->all()
                            : []
                            )
                            )->contains($permission->id)
                            )

                            class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">


                            <span class="text-sm font-medium text-slate-700">

                                {{ $permission->name }}

                            </span>

                        </label>

                        @endforeach

                    </div>

                </div>

            </div>

        </div>


        <!-- Right Sidebar -->
        <div class="space-y-6">


            <!-- Role -->
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-100 px-6 py-5">

                    <h2 class="text-lg font-bold text-slate-900">
                        User Role
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Select the primary role.
                    </p>

                </div>


                <div class="p-6">

                    <label class="mb-2 block text-sm font-semibold text-slate-700">

                        Role <span class="text-red-500">*</span>

                    </label>


                    <select
                        name="role"
                        required
                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

                        @foreach($roles as $role)

                        <option
                            value="{{ $role->name }}"

                            @selected(
                            old( 'role' ,
                            $user->exists
                            ? $user->getRoleNames()->first()
                            : null
                            ) === $role->name
                            )>

                            {{ $role->name }}

                        </option>

                        @endforeach

                    </select>

                </div>

            </div>


            <!-- Save Panel -->
            <div class="rounded-2xl border border-blue-100 bg-blue-50 p-6">

                <h3 class="font-bold text-slate-900">

                    {{ $user->exists ? 'Save Changes' : 'Create Account' }}

                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">

                    Review the user information, role and permissions before saving.

                </p>


                <button
                    type="submit"
                    class="mt-5 inline-flex w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 font-semibold text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700 active:scale-[0.98]">

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
                            d="M5 13l4 4L19 7" />

                    </svg>

                    {{ $user->exists ? 'Save Changes' : 'Create User' }}

                </button>


                <a
                    href="{{ route('users.index') }}"
                    class="mt-3 inline-flex w-full items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">

                    Cancel

                </a>

            </div>


            <!-- Information -->
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <div class="flex items-start gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-slate-100">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 text-slate-500"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />

                        </svg>

                    </div>


                    <div>

                        <h3 class="font-semibold text-slate-800">
                            Permission Information
                        </h3>

                        <p class="mt-2 text-sm leading-6 text-slate-500">

                            Roles provide the main system permissions. Additional permissions can be assigned individually.

                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</form>


<!-- Password Toggle -->
<script>
    function togglePassword(inputId, iconId) {

        const input = document.getElementById(inputId);

        if (!input) return;

        input.type = input.type === 'password' ?
            'text' :
            'password';

    }
</script>

@endsection