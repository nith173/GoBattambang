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
            <div class="flex h-20 items-center px-6">
                <div class="flex items-center gap-3">
                    <img
                        src="{{ asset('storage/images/logo.jpg') }}"
                        alt="GoBattambang Logo"
                        class="h-10 w-10 shrink-0 rounded-lg object-cover">

                    <div>
                        <span class="text-lg font-bold text-white">
                            GoBattambang
                        </span>

                        <p class="mt-1 text-xs text-slate-400">
                            ADMIN DASHBOARD
                        </p>
                    </div>
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


                <a
                    href="{{ route('admin.activity-log') }}"
                    class="mb-2 flex items-center rounded-xl px-4 py-3 text-sm font-medium
        {{ request()->routeIs('admin.activity-log')
            ? 'bg-blue-600 text-white'
            : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    Activity Log
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
                        x-data="{ open: false }"
                        x-on:click.outside="open = false"
                        class="relative">

                        <button
                            type="button"
                            x-on:click="open = !open"
                            class="flex items-center gap-3 rounded-xl border border-slate-200 px-3 py-2 transition hover:bg-slate-50">

                            @if (auth()->user()->profile_picture)

                                <img
                                    src="{{ auth()->user()->profile_picture }}"
                                    alt="{{ auth()->user()->full_name }}"
                                    class="h-9 w-9 shrink-0 rounded-full object-cover">

                            @else

                                <div
                                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-blue-600 text-sm font-bold text-white">
                                    {{ strtoupper(substr(auth()->user()->first_name, 0, 1)) }}
                                </div>

                            @endif

                            <div class="text-left">
                                <p class="text-sm font-semibold text-slate-800">
                                    {{ auth()->user()->full_name }}
                                </p>

                                <p class="text-xs text-slate-500">
                                    {{ auth()->user()->role === 'admin' ? 'Administrator' : ucfirst(auth()->user()->role) }}
                                </p>
                            </div>

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="2"
                                stroke="currentColor"
                                class="h-4 w-4 shrink-0 text-slate-400 transition"
                                x-bind:class="open ? 'rotate-180' : ''">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>

                        </button>


                        {{-- Dropdown Menu --}}
                        <div
                            x-show="open"
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 -translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 -translate-y-1"
                            x-cloak
                            class="absolute right-0 top-full z-50 mt-2 w-56 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-lg">

                            <a
                                href="{{ route('admin.profile') }}"
                                class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50">

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.8"
                                    stroke="currentColor"
                                    class="h-4 w-4 text-slate-400">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>

                                View Profile
                            </a>

                            <a
                                href="{{ route('admin.password') }}"
                                class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50">

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.8"
                                    stroke="currentColor"
                                    class="h-4 w-4 text-slate-400">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                                </svg>

                                Change Password
                            </a>

                            <div class="border-t border-slate-200"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <button
                                    type="submit"
                                    class="flex w-full items-center gap-3 px-4 py-3 text-sm font-medium text-red-600 transition hover:bg-red-50">

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.8"
                                        stroke="currentColor"
                                        class="h-4 w-4">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 -3H9m0 0 3-3m-3 3 3 3" />
                                    </svg>

                                    Log Out
                                </button>
                            </form>

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