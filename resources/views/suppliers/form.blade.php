@extends('layouts.app')

@section('title', $supplier->exists ? 'Edit Supplier' : 'Add Supplier')
@section('breadcrumb', 'Suppliers')

@section('content')

<div class="mx-auto max-w-4xl">

    <!-- Page Heading -->
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <div class="mb-2 text-xs font-bold tracking-[0.2em] text-blue-600">
                MASTER DATA
            </div>

            <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                {{ $supplier->exists ? 'Edit Supplier' : 'Add Supplier' }}
            </h1>

            <p class="mt-2 text-sm text-slate-500">
                {{ $supplier->exists
                    ? 'Update supplier information and contact details.'
                    : 'Add a new supplier to the purchase management system.' }}
            </p>
        </div>

        <a
            href="{{ route('suppliers.index') }}"
            class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">

            ← Back to Suppliers

        </a>

    </div>


    <!-- Form Card -->
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <!-- Card Header -->
        <div class="border-b border-slate-200 bg-slate-50 px-6 py-5">

            <h2 class="text-base font-bold text-slate-900">
                Supplier Information
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Enter the supplier's business and contact information.
            </p>

        </div>


        <form
            method="POST"
            action="{{ $supplier->exists
                ? route('suppliers.update', $supplier)
                : route('suppliers.store') }}"
            class="p-6 sm:p-8">

            @csrf

            @if($supplier->exists)
            @method('PUT')
            @endif


            <div class="space-y-6">

                <!-- Supplier Name -->
                <div>

                    <label
                        for="name"
                        class="mb-2 block text-sm font-semibold text-slate-700">

                        Supplier Name
                        <span class="text-red-500">*</span>

                    </label>

                    <input
                        id="name"
                        name="name"
                        type="text"
                        required
                        value="{{ old('name', $supplier->name) }}"
                        placeholder="Enter supplier name"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 @error('name') border-red-500 focus:border-red-500 focus:ring-red-100 @enderror">

                    @error('name')
                    <p class="mt-2 text-xs font-medium text-red-600">
                        {{ $message }}
                    </p>
                    @enderror

                </div>


                <!-- Contact Person -->
                <div>

                    <label
                        for="contact_person"
                        class="mb-2 block text-sm font-semibold text-slate-700">

                        Contact Person

                    </label>

                    <input
                        id="contact_person"
                        name="contact_person"
                        type="text"
                        value="{{ old('contact_person', $supplier->contact_person) }}"
                        placeholder="Enter contact person name"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 @error('contact_person') border-red-500 @enderror">

                    @error('contact_person')
                    <p class="mt-2 text-xs font-medium text-red-600">
                        {{ $message }}
                    </p>
                    @enderror

                </div>


                <!-- Phone + Email -->
                <div class="grid gap-6 md:grid-cols-2">

                    <!-- Phone -->
                    <div>

                        <label
                            for="phone"
                            class="mb-2 block text-sm font-semibold text-slate-700">

                            Phone Number

                        </label>

                        <input
                            id="phone"
                            name="phone"
                            type="text"
                            value="{{ old('phone', $supplier->phone) }}"
                            placeholder="e.g. 01XXXXXXXXX"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 @error('phone') border-red-500 @enderror">

                        @error('phone')
                        <p class="mt-2 text-xs font-medium text-red-600">
                            {{ $message }}
                        </p>
                        @enderror

                    </div>


                    <!-- Email -->
                    <div>

                        <label
                            for="email"
                            class="mb-2 block text-sm font-semibold text-slate-700">

                            Email Address

                        </label>

                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email', $supplier->email) }}"
                            placeholder="supplier@example.com"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 @error('email') border-red-500 @enderror">

                        @error('email')
                        <p class="mt-2 text-xs font-medium text-red-600">
                            {{ $message }}
                        </p>
                        @enderror

                    </div>

                </div>


                <!-- Address -->
                <div>

                    <label
                        for="address"
                        class="mb-2 block text-sm font-semibold text-slate-700">

                        Address

                    </label>

                    <textarea
                        id="address"
                        name="address"
                        rows="4"
                        placeholder="Enter supplier address"
                        class="w-full resize-none rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 @error('address') border-red-500 @enderror">{{ old('address', $supplier->address) }}</textarea>

                    @error('address')
                    <p class="mt-2 text-xs font-medium text-red-600">
                        {{ $message }}
                    </p>
                    @enderror

                </div>


                <!-- Active Status -->
                @if($supplier->exists)

                <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">

                    <label class="flex cursor-pointer items-center gap-3">

                        <input
                            type="checkbox"
                            name="is_active"
                            value="1"
                            @checked(old('is_active', $supplier->is_active))
                        class="h-5 w-5 rounded border-slate-300 text-blue-600 focus:ring-blue-500">

                        <div>

                            <div class="text-sm font-semibold text-slate-800">
                                Active Supplier
                            </div>

                            <div class="text-xs text-slate-500">
                                This supplier will be available for future purchase entries.
                            </div>

                        </div>

                    </label>

                </div>

                @endif


                <!-- Actions -->
                <div class="flex flex-col-reverse gap-3 border-t border-slate-200 pt-6 sm:flex-row sm:items-center sm:justify-end">

                    <a
                        href="{{ route('suppliers.index') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">

                        Cancel

                    </a>


                    <button
                        type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-200 transition hover:bg-blue-700 hover:shadow-xl active:scale-[0.98]">

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

                        {{ $supplier->exists ? 'Update Supplier' : 'Save Supplier' }}

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection