<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign in · ZZTL Asset Management</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpg') }}">

    <!-- Vite CSS/JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js (Required for the Show/Password Toggle Button) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-blue-950 font-sans text-slate-100 flex items-center justify-center px-4 py-12">

    <!-- Decorative background ambient glow -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-blue-600/20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-indigo-600/20 rounded-full blur-3xl"></div>
    </div>

    <div class="relative w-full max-w-md z-10">

        <!-- Company Brand Header -->
        <div class="mb-8 text-center flex flex-col items-center">
            <div class="relative mb-3 group">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-2xl blur opacity-30 group-hover:opacity-60 transition duration-300"></div>
                <img
                    src="{{ asset('images/logo.jpg') }}"
                    alt="ZZTL Logo"
                    class="relative h-20 w-20 rounded-2xl object-cover shadow-2xl border border-slate-700 bg-slate-900">
            </div>

            <h2 class="text-xl font-extrabold tracking-wider text-white">
                ZARA ZAMAN TECHNOLOGY LTD.
            </h2>
            <span class="inline-block mt-1 px-3 py-0.5 rounded-full bg-blue-500/10 border border-blue-500/20 text-[11px] font-bold tracking-widest text-blue-400">
                ASSET MANAGEMENT SYSTEM
            </span>
        </div>

        <!-- Login Glass Card -->
        <div class="rounded-3xl bg-white/95 backdrop-blur-xl p-8 shadow-2xl shadow-black/40 text-slate-800 border border-white/20">

            <div class="mb-6">
                <div class="text-xs font-extrabold tracking-widest text-blue-600 uppercase mb-1">
                    Welcome Back
                </div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                    Sign in to your account
                </h1>
                <p class="text-sm text-slate-500 mt-1">
                    Enter your company credentials to access the portal.
                </p>
            </div>

            <!-- Error Banner -->
            @if($errors->any())
            <div class="mb-5 flex items-center gap-3 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
                <span>{{ $errors->first() }}</span>
            </div>
            @endif

            <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
                @csrf

                <!-- Email Field -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">
                        Email Address
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                        </span>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            placeholder="name@zztl.com"
                            class="w-full rounded-xl border border-slate-300 bg-slate-50/50 pl-10 pr-4 py-3 text-sm font-medium text-slate-800 placeholder-slate-400 outline-none transition-all duration-200 focus:border-blue-600 focus:bg-white focus:ring-4 focus:ring-blue-600/10">
                    </div>
                </div>

                <!-- Password Field with Show/Hide Toggle -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">
                        Password
                    </label>
                    <div class="relative" x-data="{ showPassword: false }">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </span>

                        <!-- Input type dynamically toggles between password and text -->
                        <input
                            :type="showPassword ? 'text' : 'password'"
                            name="password"
                            required
                            placeholder="Enter your password"
                            class="w-full rounded-xl border border-slate-300 bg-slate-50/50 pl-10 pr-12 py-3 text-sm font-medium text-slate-800 placeholder-slate-400 outline-none transition-all duration-200 focus:border-blue-600 focus:bg-white focus:ring-4 focus:ring-blue-600/10">

                        <!-- Toggle Button Icon -->
                        <button
                            type="button"
                            @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-600 transition focus:outline-none"
                            :title="showPassword ? 'Hide password' : 'Show password'">

                            <!-- Eye Open Icon (Visible when password is shown) -->
                            <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>

                            <!-- Eye Closed Icon (Visible when password is hidden) -->
                            <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Remember Me Checkbox -->
                <div class="flex items-center justify-between text-sm">
                    <label class="flex cursor-pointer items-center gap-2.5 text-slate-600 select-none">
                        <input
                            type="checkbox"
                            name="remember"
                            class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500 transition cursor-pointer">
                        <span class="font-medium">Remember me</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="w-full rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 px-4 py-3.5 text-sm font-bold text-white shadow-lg shadow-blue-600/30 transition-all duration-200 hover:from-blue-700 hover:to-indigo-700 hover:shadow-blue-600/50 active:scale-[0.98]">
                    Sign in to Portal
                </button>
            </form>

            <!-- Card Footer -->
            <div class="mt-8 border-t border-slate-100 pt-5 text-center text-xs font-medium text-slate-400">
                Authorized personnel only &middot; &copy; {{ date('Y') }} ZZTL
            </div>

        </div>

    </div>

</body>

</html>