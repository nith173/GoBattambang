<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'GoBattambang Admin')
    </title>

    @vite([
    'resources/css/app.css',
    'resources/js/app.js'
    ])

    @livewireStyles
</head>

<body class="min-h-screen bg-slate-100">

    <div class="flex min-h-screen">

        {{-- =========================
             SIDEBAR
        ========================== --}}
        <aside class="fixed left-0 top-0 z-50 h-screen w-64 shrink-0 overflow-y-auto bg-[#0B0F19] text-white">

            {{-- Logo / Brand --}}
            <div class="flex items-center space-x-3 px-6 py-4">
                <img src="{{ asset('storage/images/logo.jpg') }}" alt="GoBattambang Logo" class="h-10 w-10 object-cover rounded-md">
                <div>
                    <h1 class="text-sm font-bold tracking-wide text-white">GOBATTAMBANG</h1>
                    <p class="text-xs text-slate-400">ADMIN DASHBOARD</p>
                </div>
            </div>


            {{-- Navigation --}}
            <nav class="px-4 py-6">

                {{-- Dashboard --}}
                <a
                    href="{{ route('admin.dashboard') }}"
                    class="mb-2 flex items-center rounded-xl px-4 py-3 text-sm font-medium
                        {{ request()->routeIs('admin.dashboard')
                            ? 'bg-blue-600 text-white'
                            : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    Dashboard
                </a>


                {{-- Destinations --}}
                <a
                    href="{{ route('admin.destinations') }}"
                    class="mb-2 flex items-center rounded-xl px-4 py-3 text-sm font-medium
                        {{ request()->routeIs('admin.destinations*')
                            ? 'bg-blue-600 text-white'
                            : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    Destinations
                </a>


                <a
                    href="{{ route('admin.categories') }}"
                    class="mb-2 flex items-center rounded-xl px-4 py-3 text-sm font-medium
        {{ request()->routeIs('admin.categories')
            ? 'bg-blue-600 text-white'
            : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    Categories
                </a>


                <a
                    href="{{ route('admin.users') }}"
                    class="mb-2 flex items-center rounded-xl px-4 py-3 text-sm font-medium
        {{ request()->routeIs('admin.users')
            ? 'bg-blue-600 text-white'
            : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    Users
                </a>


                <a
                    href="{{ route('admin.bookings') }}"
                    class="mb-2 flex items-center rounded-xl px-4 py-3 text-sm font-medium
        {{ request()->routeIs('admin.bookings')
            ? 'bg-blue-600 text-white'
            : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    Bookings
                </a>


                <a
                    href="{{ route('admin.reviews') }}"
                    class="mb-2 flex items-center rounded-xl px-4 py-3 text-sm font-medium
        {{ request()->routeIs('admin.reviews')
            ? 'bg-blue-600 text-white'
            : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    Reviews
                </a>

            </nav>

        </aside>


        {{-- =========================
             MAIN AREA
        ========================== --}}
        <div class="ml-64 flex min-w-0 flex-1 flex-col">


            {{-- =========================
                 TOP HEADER
            ========================== --}}
            <header
                class="sticky top-0 z-40 flex h-20 items-center justify-end border-b border-slate-200 bg-white px-8">

                <div class="flex items-center gap-4">

                    {{-- Date --}}
                    <div class="rounded-xl bg-slate-100 px-4 py-2">
                        <p class="text-sm font-medium text-slate-700">
                            {{ now()->format('l, d F Y') }}
                        </p>
                    </div>


                    {{-- Admin User --}}
                    <div
                        class="flex items-center gap-3 rounded-xl border border-slate-200 px-3 py-2">

                        <div
                            class="flex h-9 w-9 items-center justify-center rounded-full bg-blue-600 text-sm font-bold text-white">
                            A
                        </div>

                        <div>
                            <p class="text-sm font-semibold text-slate-800">
                                Admin User
                            </p>

                            <p class="text-xs text-slate-500">
                                Administrator
                            </p>
                        </div>

                    </div>

                </div>

            </header>


            {{-- =========================
                 PAGE CONTENT
            ========================== --}}
            <main class="min-w-0 flex-1 p-8">

                {{-- Blade layout content --}}
                @yield('content')

                {{-- Livewire component content --}}
                {{ $slot ?? '' }}

            </main>

        </div>

    </div>


    @livewireScripts

</body>

</html>