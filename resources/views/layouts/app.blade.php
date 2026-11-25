<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Dashboard') · ZZTL Asset Management</title>

    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpg') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-slate-100 font-sans text-slate-800">

    <!-- Mobile Overlay -->
    <div id="sidebarOverlay" class="fixed inset-0 z-40 hidden bg-slate-950/50 backdrop-blur-sm lg:hidden">
    </div>


    <!-- Main Application -->
    <div class="min-h-screen">


        <!-- ================= SIDEBAR ================= -->

        <aside id="sidebar"
            class="fixed inset-y-0 left-0 z-50 flex w-72 -translate-x-full flex-col bg-slate-950 text-slate-300 shadow-2xl transition-transform duration-300 lg:translate-x-0">

            <!-- Logo / Brand -->
            <div class="flex h-20 items-center justify-between border-b border-slate-800 px-5">

                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">

                    <div
                        class="flex h-11 w-11 items-center justify-center overflow-hidden rounded-xl bg-white shadow-lg">

                        <img src="{{ asset('images/logo.jpg') }}" alt="ZZTL Logo" class="h-full w-full object-contain">

                    </div>

                    <div class="min-w-0">

                        <div class="truncate text-sm font-bold tracking-wide text-white">
                            ZARA ZAMAN
                        </div>

                        <div class="text-[10px] font-semibold tracking-[0.15em] text-slate-400">
                            TECHNOLOGY LTD.
                        </div>

                    </div>

                </a>


                <!-- Close Button -->
                <button id="sidebarClose" type="button"
                    class="flex h-9 w-9 items-center justify-center rounded-lg text-slate-400 transition hover:bg-slate-800 hover:text-white lg:hidden"
                    aria-label="Close menu">

                    ✕
                </button>

            </div>


            <!-- Navigation -->
            <div class="sidebar-scroll flex-1 overflow-y-auto px-4 py-5">

                <div class="mb-3 px-3 text-[10px] font-bold tracking-[0.2em] text-slate-500">
                    WORKSPACE
                </div>


                <nav class="space-y-1">


                    <!-- Dashboard -->
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition
                        {{ request()->routeIs('dashboard')
                            ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/30'
                            : 'hover:bg-slate-800 hover:text-white' }}">

                        <span class="text-lg">▦</span>

                        <span>Dashboard</span>

                    </a>


                    <!-- Section -->
                    <div class="mt-7 mb-3 px-3 text-[10px] font-bold tracking-[0.2em] text-slate-500">
                        ASSET MANAGEMENT
                    </div>

                    @can('purchases.view')
                        <a href="{{ route('purchases.index') }}"
                            class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition
                                {{ request()->routeIs('purchases.*')
                                    ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/30'
                                    : 'hover:bg-slate-800 hover:text-white' }}">

                            <!-- Purchase Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">

                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.3 2.3c-.63.63-.18 1.7.7 1.7H17m0 0a2 2 0 100 4 2 2 0 000-4zM9 21a2 2 0 100-4 2 2 0 000 4z" />
                            </svg>

                            <span>Purchases</span>
                        </a>
                    @endcan

                    @can('assets.view')
                        <a href="{{ route('assets.index') }}"
                            class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition
                        {{ request()->routeIs('assets.*')
                            ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/30'
                            : 'hover:bg-slate-800 hover:text-white' }}">

                            <span class="text-lg">▣</span>

                            <span>Assets</span>

                        </a>
                    @endcan


                    @can('categories.view')
                        <a href="{{ route('categories.index') }}"
                            class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition
                        {{ request()->routeIs('categories.*')
                            ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/30'
                            : 'hover:bg-slate-800 hover:text-white' }}">

                            <span class="text-lg">▤</span>

                            <span>Categories</span>

                        </a>
                    @endcan


                    @can('suppliers.view')
                        <a href="{{ route('suppliers.index') }}"
                            class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition
                        {{ request()->routeIs('suppliers.*')
                            ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/30'
                            : 'hover:bg-slate-800 hover:text-white' }}">

                            <span class="text-lg">♧</span>

                            <span>Suppliers</span>

                        </a>
                    @endcan

                    @can('departments.view')
                        <a href="{{ route('departments.index') }}"
                            class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition
                            {{ request()->routeIs('departments.*')
                                ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/30'
                                : 'hover:bg-slate-800 hover:text-white' }}">

                            <!-- Department Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">

                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 21h18M4 21V7l8-4 8 4v14M9 21v-6h6v6" />

                            </svg>

                            <span>Departments</span>

                        </a>
                    @endcan

                    @can('asset_assignments.view')
                        <a href="{{ route('asset-assignments.index') }}"
                            class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition
                            {{ request()->routeIs('asset-assignments.*')
                                ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/30'
                                : 'hover:bg-slate-800 hover:text-white' }}">

                            <!-- Assignment Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">

                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 011 1v13a1 1 0 01-1 1H5a1 1 0 01-1-1V6a1 1 0 011-1zm4 10h6" />

                            </svg>

                            <span>Asset Assignments</span>

                        </a>
                    @endcan


                    <!-- Administration -->
                    <div class="mt-7 mb-3 px-3 text-[10px] font-bold tracking-[0.2em] text-slate-500">
                        ADMINISTRATION
                    </div>


                    @can('users.manage')
                        <a href="{{ route('users.index') }}"
                            class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition
                        {{ request()->routeIs('users.*')
                            ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/30'
                            : 'hover:bg-slate-800 hover:text-white' }}">

                            <span class="text-lg">♙</span>

                            <span>Users</span>

                        </a>
                    @endcan


                    @can('roles.manage')
                        <a href="{{ route('roles.index') }}"
                            class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition
                        {{ request()->routeIs('roles.*')
                            ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/30'
                            : 'hover:bg-slate-800 hover:text-white' }}">

                            <span class="text-lg">⚿</span>

                            <span>Roles & Permissions</span>

                        </a>
                    @endcan


                    @can('activity_logs.view')
                        <a href="{{ route('activity-logs.index') }}"
                            class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition
                        {{ request()->routeIs('activity-logs.*')
                            ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/30'
                            : 'hover:bg-slate-800 hover:text-white' }}">

                            <span class="text-lg">◷</span>

                            <span>Activity Logs</span>

                        </a>
                    @endcan

                </nav>

            </div>


            <!-- Sidebar Footer -->
            <!-- <div class="border-t border-slate-800 px-6 py-5">

                <div class="text-xs text-slate-500">
                    Internal company system
                </div>

                <div class="mt-1 text-xs font-semibold text-slate-400">
                    Version 1.0
                </div>

            </div> -->
            <!-- Sidebar Footer -->
            <!-- Logout -->
            <div class="border-t border-slate-800 p-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit"
                        class="group flex w-full items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold text-red-400 transition hover:bg-red-500/10 hover:text-red-300">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 transition-transform duration-200 group-hover:translate-x-1" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">

                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15" />

                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.75 12H9m0 0l3-3m-3 3l3 3" />

                        </svg>

                        <span>Logout</span>

                    </button>
                </form>
            </div>

        </aside>


        <!-- ================= MAIN AREA ================= -->

        <div class="min-h-screen transition-all duration-300 lg:ml-72">


            <!-- TOPBAR -->
            <header
                class="sticky top-0 z-30 flex h-20 items-center justify-between border-b border-slate-200 bg-white/95 px-4 shadow-sm backdrop-blur md:px-8">


                <!-- Left -->
                <div class="flex items-center gap-4">


                    <!-- Menu Toggle -->
                    <button id="menuToggle" type="button"
                        class="flex h-11 w-11 items-center justify-center rounded-xl border border-slate-200 bg-white text-lg text-slate-700 shadow-sm transition hover:bg-slate-100 lg:hidden"
                        aria-label="Open menu">

                        ☰

                    </button>


                    <div>

                        <div class="text-xs font-medium text-slate-400">
                            ZZTL Asset Management
                        </div>

                        <div class="text-lg font-bold text-slate-900">
                            @yield('breadcrumb', 'Workspace')
                        </div>

                    </div>

                </div>


                <!-- User Area -->
                <div class="flex items-center gap-3">


                    <!-- User Info -->
                    <div class="hidden text-right sm:block">

                        <div class="text-sm font-bold text-slate-800">
                            {{ auth()->user()->name }}
                        </div>

                        <div class="text-xs text-slate-500">

                            {{ auth()->user()->getRoleNames()->first() ?? 'User' }}

                        </div>

                    </div>


                    <!-- Avatar -->
                    <div
                        class="flex h-11 w-11 items-center justify-center rounded-full bg-gradient-to-br from-blue-500 to-blue-700 text-sm font-bold text-white shadow-md">

                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                    </div>
                </div>

            </header>


            <!-- CONTENT -->
            <main class="p-4 md:p-6 lg:p-8">


                <!-- Success Message -->
                @if (session('success'))
                    <div
                        class="mb-6 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-medium text-green-700 shadow-sm">

                        {{ session('success') }}

                    </div>
                @endif


                <!-- Validation Errors -->
                @if ($errors->any())

                    <div
                        class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700 shadow-sm">

                        <div class="mb-2 font-bold">
                            Please check the form:
                        </div>

                        <ul class="list-disc space-y-1 pl-5">

                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach

                        </ul>

                    </div>

                @endif


                <!-- Page Content -->
                @yield('content')

            </main>

        </div>

    </div>


    <!-- Sidebar Script -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');

        const menuToggle = document.getElementById('menuToggle');
        const sidebarClose = document.getElementById('sidebarClose');


        function openSidebar() {

            sidebar.classList.remove('-translate-x-full');

            overlay.classList.remove('hidden');

        }


        function closeSidebar() {

            sidebar.classList.add('-translate-x-full');

            overlay.classList.add('hidden');

        }


        menuToggle?.addEventListener('click', openSidebar);

        sidebarClose?.addEventListener('click', closeSidebar);

        overlay?.addEventListener('click', closeSidebar);


        // Close sidebar after clicking a menu item on mobile
        document.querySelectorAll('#sidebar a').forEach(link => {

            link.addEventListener('click', () => {

                if (window.innerWidth < 1024) {

                    closeSidebar();

                }

            });

        });


        // Confirmation buttons
        document.addEventListener('click', function(e) {

            if (e.target.matches('[data-confirm]')) {

                if (!confirm(e.target.dataset.confirm)) {

                    e.preventDefault();

                }

            }

        });
    </script>

</body>

</html>
