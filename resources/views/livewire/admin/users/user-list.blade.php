<div class="h-[calc(100vh-5rem)] overflow-hidden">

    {{-- ================================================================
        SUCCESS ALERT
    ================================================================= --}}

    @if (session()->has('success'))
        <div
            x-data="{ show: true }"
            x-show="show"
            x-init="setTimeout(() => show = false, 3000)"
            x-transition
            class="fixed right-6 top-6 z-[9999] flex items-center gap-3 rounded-lg bg-emerald-600 px-5 py-3.5 text-sm font-medium text-white shadow-lg">

            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="2"
                stroke="currentColor"
                class="h-5 w-5 shrink-0">

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="m9 12.75 2.25 2.25L15 9.75" />

                <circle
                    cx="12"
                    cy="12"
                    r="9" />

            </svg>

            <span>{{ session('success') }}</span>

        </div>
    @endif


    {{-- ================================================================
        ERROR ALERT
    ================================================================= --}}

    @if (session()->has('error'))
        <div
            x-data="{ show: true }"
            x-show="show"
            x-init="setTimeout(() => show = false, 3000)"
            x-transition
            class="fixed right-6 top-6 z-[9999] flex items-center gap-3 rounded-lg bg-red-600 px-5 py-3.5 text-sm font-medium text-white shadow-lg">

            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="2"
                stroke="currentColor"
                class="h-5 w-5 shrink-0">

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M6 18 18 6M6 6l12 12" />

            </svg>

            <span>{{ session('error') }}</span>

        </div>
    @endif


    {{-- ================================================================
        FIXED PAGE CONTENT
        Header + Cards + Search/Filter + Table
    ================================================================= --}}

    <div class="flex h-full min-h-0 flex-col bg-slate-50">


        {{-- ============================================================
            PAGE HEADER
        ============================================================= --}}

        <div class="shrink-0 border-b border-slate-200 bg-white">

            <div class="px-6 py-5">

                <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

                    <div>

                        <a
                            href="{{ route('admin.dashboard') }}"
                            class="mb-3 inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-blue-600">

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
                                    d="m15 18-6-6 6-6" />

                            </svg>

                            Dashboard

                        </a>

                        <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                            Users
                        </h1>

                        <p class="mt-1 text-sm text-slate-500">
                            Manage registered users and administrator accounts.
                        </p>

                    </div>


                    {{-- Add User --}}

                    <a
                        href="{{ route('admin.users.create') }}"
                        class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">

                        + Add User

                    </a>

                </div>

            </div>

        </div>


        {{-- ============================================================
            SCROLL-FREE TOP CONTENT
            Statistics + Search/Filter
        ============================================================= --}}

        <div class="shrink-0 space-y-5 px-6 py-6">


            {{-- ========================================================
                STATISTICS
            ========================================================= --}}

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">


                {{-- ====================================================
                    TOTAL
                ===================================================== --}}

                <div class="flex min-h-[132px] items-center rounded-xl border border-slate-200 bg-white px-6 py-5 shadow-sm">

                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-blue-50">

                        <svg
                            class="h-6 w-6 text-blue-600"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            stroke-width="1.8">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />

                        </svg>

                    </div>

                    <div class="ml-5">

                        <p class="text-sm font-semibold text-slate-700">
                            Total
                        </p>

                        <p class="mt-1 text-2xl font-bold leading-none text-slate-900">
                            {{ $totalUsers }}
                        </p>

                        <p class="mt-2 text-sm text-slate-400">
                            All users
                        </p>

                    </div>

                </div>


                {{-- ====================================================
                    ACTIVE
                ===================================================== --}}

                <div class="flex min-h-[132px] items-center rounded-xl border border-slate-200 bg-white px-6 py-5 shadow-sm">

                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-emerald-50">

                        <svg
                            class="h-6 w-6 text-emerald-600"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            stroke-width="1.8">

                            <circle
                                cx="12"
                                cy="12"
                                r="8.5" />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m8 12 2.5 2.5L16 9" />

                        </svg>

                    </div>

                    <div class="ml-5">

                        <p class="text-sm font-semibold text-slate-700">
                            Active
                        </p>

                        <p class="mt-1 text-2xl font-bold leading-none text-slate-900">
                            {{ $activeUsers }}
                        </p>

                        <p class="mt-2 text-sm text-slate-400">
                            Active accounts
                        </p>

                    </div>

                </div>


                {{-- ====================================================
                    SUSPENDED
                ===================================================== --}}

                <div class="flex min-h-[132px] items-center rounded-xl border border-slate-200 bg-white px-6 py-5 shadow-sm">

                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-amber-50">

                        <svg
                            class="h-6 w-6 text-amber-500"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            stroke-width="1.8">

                            <circle
                                cx="12"
                                cy="12"
                                r="8.5" />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M9 9l6 6M15 9l-6 6" />

                        </svg>

                    </div>

                    <div class="ml-5">

                        <p class="text-sm font-semibold text-slate-700">
                            Suspended
                        </p>

                        <p class="mt-1 text-2xl font-bold leading-none text-slate-900">
                            {{ $suspendedUsers }}
                        </p>

                        <p class="mt-2 text-sm text-slate-400">
                            Suspended accounts
                        </p>

                    </div>

                </div>


                {{-- ====================================================
                    ADMINS
                ===================================================== --}}

                <div class="flex min-h-[132px] items-center rounded-xl border border-slate-200 bg-white px-6 py-5 shadow-sm">

                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-purple-50">

                        <svg
                            class="h-6 w-6 text-purple-600"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            stroke-width="1.8">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />

                        </svg>

                    </div>

                    <div class="ml-5">

                        <p class="text-sm font-semibold text-slate-700">
                            Admins
                        </p>

                        <p class="mt-1 text-2xl font-bold leading-none text-slate-900">
                            {{ $adminCount }}
                        </p>

                        <p class="mt-2 text-sm text-slate-400">
                            Administrator accounts
                        </p>

                    </div>

                </div>

            </div>


            {{-- ========================================================
                SEARCH & FILTERS
            ========================================================= --}}

            <div class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm">

                <div class="flex flex-col gap-3 lg:flex-row lg:items-end">


                    {{-- ====================================================
                        SEARCH
                    ===================================================== --}}

                    <div class="flex-1">

                        <label
                            for="user-search"
                            class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-500">

                            Search

                        </label>

                        <div class="relative">

                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">

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
                                        d="m21 21-4.35-4.35m1.35-5.4a6.75 6.75 0 1 1-13.5 0 6.75 6.75 0 0 1 13.5 0Z" />

                                </svg>

                            </div>

                            <input
                                id="user-search"
                                type="text"
                                wire:model.live.debounce.300ms="search"
                                placeholder="Search name, email, or phone..."
                                class="w-full rounded-lg border border-slate-300 bg-white py-2.5 pl-9 pr-4 text-sm text-slate-900 placeholder-slate-400 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100" />

                        </div>

                    </div>


                    {{-- ====================================================
                        ROLE
                    ===================================================== --}}

                    <div class="w-full lg:w-56">

                        <label
                            for="role-filter"
                            class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-500">

                            Role

                        </label>

                        <select
                            id="role-filter"
                            wire:model.live="roleFilter"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                            <option value="">
                                All Roles
                            </option>

                            <option value="registered">
                                Registered
                            </option>

                            <option value="admin">
                                Admin
                            </option>

                        </select>

                    </div>


                    {{-- ====================================================
                        STATUS
                    ===================================================== --}}

                    <div class="w-full lg:w-48">

                        <label
                            for="status-filter"
                            class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-500">

                            Status

                        </label>

                        <select
                            id="status-filter"
                            wire:model.live="statusFilter"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                            <option value="">
                                All Status
                            </option>

                            <option value="active">
                                Active
                            </option>

                            <option value="suspended">
                                Suspended
                            </option>

                        </select>

                    </div>


                    {{-- ====================================================
                        CLEAR
                    ===================================================== --}}

                    @if ($hasActiveFilters)

                        <button
                            type="button"
                            wire:click="clearFilters"
                            class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50">

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
                                    d="M6 18 18 6M6 6l12 12" />

                            </svg>

                            Clear

                        </button>

                    @endif

                </div>

            </div>

        </div>


        {{-- ================================================================
            TABLE AREA
            This takes the remaining available height.
        ================================================================= --}}

        <div class="flex min-h-0 flex-1 flex-col px-6 pb-6">


            {{-- ============================================================
                USER TABLE CARD
            ============================================================= --}}

            <div class="flex min-h-0 flex-1 flex-col overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">


                {{-- ========================================================
                    TABLE TITLE / RESULT COUNT
                    FIXED
                ========================================================= --}}

                <div class="shrink-0 border-b border-slate-200 bg-white px-5 py-4">

                    <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">

                        <div>

                            <h2 class="text-base font-bold uppercase tracking-wide text-slate-900">
                                Users
                            </h2>

                            <p class="mt-0.5 text-sm text-slate-500">
                                Manage registered users and administrator accounts.
                            </p>

                        </div>


                        @if ($users->total() > 0)

                            <p class="text-sm text-slate-500">

                                Showing

                                <span class="font-semibold text-slate-700">
                                    {{ $users->firstItem() }}
                                </span>

                                -

                                <span class="font-semibold text-slate-700">
                                    {{ $users->lastItem() }}
                                </span>

                                of

                                <span class="font-semibold text-slate-700">
                                    {{ $users->total() }}
                                </span>

                            </p>

                        @endif

                    </div>

                </div>


                {{-- ========================================================
                    EMPTY STATE
                ========================================================= --}}

                @if ($users->isEmpty())

                    <div class="flex flex-1 items-center justify-center px-6 py-16 text-center">

                        <div>

                            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-slate-100">

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.6"
                                    stroke="currentColor"
                                    class="h-7 w-7 text-slate-400">

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />

                                </svg>

                            </div>


                            @if ($hasActiveFilters)

                                <h3 class="mt-4 text-base font-semibold text-slate-900">
                                    No users found
                                </h3>

                                <p class="mx-auto mt-1 max-w-md text-sm text-slate-500">
                                    No users match your current search or filters.
                                </p>

                                <button
                                    type="button"
                                    wire:click="clearFilters"
                                    class="mt-5 inline-flex items-center rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">

                                    Clear Filters

                                </button>

                            @else

                                <h3 class="mt-4 text-base font-semibold text-slate-900">
                                    No users yet
                                </h3>

                                <p class="mx-auto mt-1 max-w-md text-sm text-slate-500">
                                    Start adding user accounts to your GoBattambang website.
                                </p>

                                <a
                                    href="{{ route('admin.users.create') }}"
                                    class="mt-5 inline-flex items-center rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">

                                    + Add User

                                </a>

                            @endif

                        </div>

                    </div>


                @else


                    {{-- ====================================================
                        SCROLLABLE TABLE + PAGINATION AREA

                        IMPORTANT:
                        The pagination is INSIDE this overflow container.
                        Therefore pagination will NOT stay fixed.
                        It will scroll together with the table.
                    ===================================================== --}}

                    <div class="min-h-0 flex-1 overflow-auto">


                        {{-- ==================================================
                            TABLE
                        =================================================== --}}

                        <table class="min-w-full">


                            {{-- =================================================
                                TABLE HEADER
                                STAYS FIXED WHILE TABLE SCROLLS
                            ================================================== --}}

                            <thead class="sticky top-0 z-30 border-b border-slate-200 bg-slate-50">

                                <tr>

                                    <th class="w-12 px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-slate-500">
                                        #
                                    </th>

                                    <th class="w-20 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                                        Photo
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                                        User
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                                        Phone
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                                        Role
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                                        Status
                                    </th>

                                    <th class="w-20 px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-slate-500">
                                        Actions
                                    </th>

                                </tr>

                            </thead>


                            {{-- =================================================
                                TABLE DATA
                                ONLY THIS PART SCROLLS
                            ================================================== --}}

                            <tbody class="divide-y divide-slate-100 bg-white">

                                @foreach ($users as $user)

                                    @php

                                        $rowNumber =
                                            ($users->currentPage() - 1)
                                            * $users->perPage()
                                            + $loop->iteration;

                                    @endphp


                                    <tr
                                        wire:key="user-{{ $user->user_id }}"
                                        class="transition hover:bg-slate-50">


                                        {{-- ====================================================
                                            NUMBER
                                        ===================================================== --}}

                                        <td class="px-4 py-3 text-center text-sm font-medium text-slate-500">
                                            {{ $rowNumber }}
                                        </td>


                                        {{-- ====================================================
                                            PHOTO
                                        ===================================================== --}}

                                        <td class="px-3 py-3">

                                            <div class="h-12 w-12 overflow-hidden rounded-full bg-slate-100">

                                                @if ($user->profile_picture)

                                                    @php

                                                        $displayImageUrl = asset(
                                                            ltrim($user->profile_picture, '/')
                                                        );

                                                    @endphp

                                                    <img
                                                        src="{{ $displayImageUrl }}"
                                                        alt="{{ $user->first_name }} {{ $user->last_name }}"
                                                        class="h-full w-full object-cover"
                                                        loading="lazy">

                                                @else

                                                    <div class="flex h-full w-full items-center justify-center bg-blue-50 text-sm font-semibold text-blue-600">

                                                        {{ strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1)) }}

                                                    </div>

                                                @endif

                                            </div>

                                        </td>


                                        {{-- ====================================================
                                            USER
                                        ===================================================== --}}

                                        <td class="px-4 py-3">

                                            <div class="min-w-0">

                                                <p class="max-w-[240px] truncate text-sm font-semibold text-slate-900">
                                                    {{ $user->first_name }} {{ $user->last_name }}
                                                </p>

                                                <p class="mt-0.5 max-w-[240px] truncate text-xs text-slate-400">
                                                    {{ $user->email }}
                                                </p>

                                            </div>

                                        </td>


                                        {{-- ====================================================
                                            PHONE
                                        ===================================================== --}}

                                        <td class="whitespace-nowrap px-4 py-3">

                                            <span class="text-sm text-slate-600">
                                                {{ $user->phone_number ?? '—' }}
                                            </span>

                                        </td>


                                        {{-- ====================================================
                                            ROLE
                                        ===================================================== --}}

                                        <td class="px-4 py-3">

                                            @if ($user->role === 'admin')

                                                <span class="inline-flex items-center rounded-md bg-purple-50 px-2.5 py-1 text-xs font-medium text-purple-700">
                                                    Admin
                                                </span>

                                            @elseif ($user->role === 'manager')

                                                <span class="inline-flex items-center rounded-md bg-amber-50 px-2.5 py-1 text-xs font-medium text-amber-700">
                                                    Manager
                                                </span>

                                            @else

                                                <span class="inline-flex items-center rounded-md bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700">
                                                    Registered
                                                </span>

                                            @endif

                                        </td>


                                        {{-- ====================================================
                                            STATUS
                                        ===================================================== --}}

                                        <td class="whitespace-nowrap px-4 py-3">

                                            @if ($user->account_status === 'active')

                                                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">

                                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>

                                                    Active

                                                </span>

                                            @elseif ($user->account_status === 'banned')

                                                <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-2.5 py-1 text-xs font-semibold text-red-700">

                                                    <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>

                                                    Banned

                                                </span>

                                            @else

                                                <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">

                                                    <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>

                                                    Suspended

                                                </span>

                                            @endif

                                        </td>


                                        {{-- ====================================================
                                            ACTIONS
                                        ===================================================== --}}

                                        <td class="px-4 py-3 text-center">

                                            <div
                                                x-data="{ open: false }"
                                                class="relative inline-block text-left">


                                                {{-- THREE DOT BUTTON --}}

                                                <button
                                                    type="button"
                                                    @click="open = !open"
                                                    @keydown.escape.window="open = false"
                                                    class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-slate-500 transition hover:bg-slate-100 hover:text-slate-800"
                                                    aria-label="User actions">

                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        fill="currentColor"
                                                        viewBox="0 0 24 24"
                                                        class="h-5 w-5">

                                                        <circle
                                                            cx="12"
                                                            cy="5"
                                                            r="1.7" />

                                                        <circle
                                                            cx="12"
                                                            cy="12"
                                                            r="1.7" />

                                                        <circle
                                                            cx="12"
                                                            cy="19"
                                                            r="1.7" />

                                                    </svg>

                                                </button>


                                                {{-- ACTION DROPDOWN --}}

                                                <div
                                                    x-show="open"
                                                    x-cloak
                                                    @click.outside="open = false"
                                                    x-transition
                                                    class="absolute right-0 z-[100] mt-2 w-36 origin-top-right rounded-lg border border-slate-200 bg-white py-1 text-left shadow-lg">


                                                    {{-- VIEW --}}

                                                    <button
                                                        type="button"
                                                        wire:click="view({{ $user->user_id }})"
                                                        @click="open = false"
                                                        class="flex w-full items-center gap-2 px-3 py-2 text-sm text-slate-700 hover:bg-slate-50">

                                                        <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            fill="none"
                                                            viewBox="0 0 24 24"
                                                            stroke-width="1.7"
                                                            stroke="currentColor"
                                                            class="h-4 w-4 text-slate-500">

                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                d="M2.25 12s3.5-6.75 9.75-6.75S21.75 12 21.75 12 18.25 18.75 12 18.75 2.25 12 2.25 12Z" />

                                                            <circle
                                                                cx="12"
                                                                cy="12"
                                                                r="2.75" />

                                                        </svg>

                                                        View

                                                    </button>


                                                    {{-- EDIT --}}

                                                    <a
                                                        href="{{ route(
                                                            'admin.users.edit',
                                                            $user->user_id
                                                        ) }}"
                                                        @click="open = false"
                                                        class="flex items-center gap-2 px-3 py-2 text-sm text-slate-700 hover:bg-slate-50">

                                                        <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            fill="none"
                                                            viewBox="0 0 24 24"
                                                            stroke-width="1.7"
                                                            stroke="currentColor"
                                                            class="h-4 w-4 text-blue-600">

                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z" />

                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                d="M19.5 7.125 16.875 4.5" />

                                                        </svg>

                                                        Edit

                                                    </a>


                                                    {{-- DELETE --}}

                                                    <button
                                                        type="button"
                                                        wire:click="delete({{ $user->user_id }})"
                                                        wire:confirm="Are you sure you want to delete '{{ $user->first_name }} {{ $user->last_name }}'? This action cannot be undone."
                                                        wire:loading.attr="disabled"
                                                        @click="open = false"
                                                        class="flex w-full items-center gap-2 px-3 py-2 text-sm text-red-600 hover:bg-red-50">

                                                        <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            fill="none"
                                                            viewBox="0 0 24 24"
                                                            stroke-width="1.7"
                                                            stroke="currentColor"
                                                            class="h-4 w-4">

                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673A2.25 2.25 0 0 1 15.916 21.75H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79" />

                                                        </svg>

                                                        Delete

                                                    </button>

                                                </div>

                                            </div>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>


                        {{-- ====================================================
                            TABLE FOOTER / PAGINATION

                            IMPORTANT:
                            This is INSIDE overflow-auto.

                            Therefore:
                            - It does NOT stay fixed.
                            - It does NOT stay sticky.
                            - It scrolls with the table content.
                        ===================================================== --}}

                        <div class="flex flex-col gap-4 border-t border-slate-200 bg-white px-5 py-4 sm:flex-row sm:items-center sm:justify-between">


                            {{-- Showing X - Y of Z --}}

                            <div class="text-sm text-slate-500">

                                Showing

                                <span class="font-medium text-slate-900">
                                    {{ $users->firstItem() ?? 0 }}
                                </span>

                                -

                                <span class="font-medium text-slate-900">
                                    {{ $users->lastItem() ?? 0 }}
                                </span>

                                of

                                <span class="font-medium text-slate-900">
                                    {{ $users->total() }}
                                </span>

                            </div>


                            {{-- ====================================================
                                PAGINATION
                            ===================================================== --}}

                            <div class="flex items-center gap-2">


                                {{-- Previous --}}

                                @if ($users->onFirstPage())

                                    <button
                                        type="button"
                                        disabled
                                        class="flex h-10 w-10 cursor-not-allowed items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-300"
                                        aria-label="Previous page">

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
                                                d="M15 19l-7-7 7-7" />

                                        </svg>

                                    </button>

                                @else

                                    <button
                                        type="button"
                                        wire:click="previousPage"
                                        wire:loading.attr="disabled"
                                        class="flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-600 transition hover:bg-slate-50"
                                        aria-label="Previous page">

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
                                                d="M15 19l-7-7 7-7" />

                                        </svg>

                                    </button>

                                @endif


                                {{-- Page Numbers --}}

                                @for ($page = 1; $page <= max(1, $users->lastPage()); $page++)

                                    @if ($page === $users->currentPage())

                                        <button
                                            type="button"
                                            disabled
                                            class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-600 text-sm font-semibold text-white">

                                            {{ $page }}

                                        </button>

                                    @else

                                        <button
                                            type="button"
                                            wire:click="gotoPage({{ $page }})"
                                            wire:loading.attr="disabled"
                                            class="flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 bg-white text-sm font-medium text-slate-600 transition hover:bg-slate-50">

                                            {{ $page }}

                                        </button>

                                    @endif

                                @endfor


                                {{-- Next --}}

                                @if ($users->hasMorePages())

                                    <button
                                        type="button"
                                        wire:click="nextPage"
                                        wire:loading.attr="disabled"
                                        class="flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-600 transition hover:bg-slate-50"
                                        aria-label="Next page">

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
                                                d="M9 5l7 7-7 7" />

                                        </svg>

                                    </button>

                                @else

                                    <button
                                        type="button"
                                        disabled
                                        class="flex h-10 w-10 cursor-not-allowed items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-300"
                                        aria-label="Next page">

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
                                                d="M9 5l7 7-7 7" />

                                        </svg>

                                    </button>

                                @endif

                            </div>

                        </div>

                    </div>

                @endif

            </div>

        </div>

    </div>


    {{-- ================================================================
        VIEW MODAL
    ================================================================= --}}

    @if ($showViewModal)

        <div
            class="fixed inset-0 z-[9999] flex items-center justify-center bg-slate-900/50 px-4"
            wire:click.self="closeViewModal">

            <div class="flex max-h-[90vh] w-full max-w-2xl flex-col overflow-hidden rounded-2xl bg-white shadow-2xl">


                {{-- ====================================================
                    MODAL HEADER
                ===================================================== --}}

                <div class="flex shrink-0 items-center justify-between border-b border-slate-200 px-6 py-4">

                    <h3 class="text-lg font-bold text-slate-900">
                        User Details
                    </h3>

                    <button
                        type="button"
                        wire:click="closeViewModal"
                        class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 transition hover:bg-slate-100 hover:text-slate-600">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="2"
                            stroke="currentColor"
                            class="h-5 w-5">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6 18 18 6M6 6l12 12" />

                        </svg>

                    </button>

                </div>


                {{-- ====================================================
                    MODAL BODY
                ===================================================== --}}

                <div class="min-h-0 flex-1 overflow-y-auto px-6 py-5">

                    @if (!empty($selectedUser))

                        <div class="space-y-6">


                            {{-- Avatar + Name --}}

                            <div class="flex items-center gap-4">

                                <div class="h-16 w-16 shrink-0 overflow-hidden rounded-full bg-slate-100">

                                    @php

                                        $viewImage = $selectedUser['profile_picture'] ?? null;

                                        if ($viewImage) {
                                            $viewImageUrl = str_starts_with($viewImage, 'http://')
                                                || str_starts_with($viewImage, 'https://')
                                                ? $viewImage
                                                : asset(ltrim($viewImage, '/'));
                                        } else {
                                            $viewImageUrl = null;
                                        }

                                    @endphp

                                    @if ($viewImageUrl)

                                        <img
                                            src="{{ $viewImageUrl }}"
                                            alt="{{ $selectedUser['first_name'] }}"
                                            class="h-full w-full object-cover">

                                    @else

                                        <div class="flex h-full w-full items-center justify-center bg-blue-50 text-lg font-semibold text-blue-600">

                                            {{ strtoupper(substr($selectedUser['first_name'] ?? '', 0, 1) . substr($selectedUser['last_name'] ?? '', 0, 1)) }}

                                        </div>

                                    @endif

                                </div>

                                <div>

                                    <h4 class="text-base font-bold text-slate-900">
                                        {{ $selectedUser['first_name'] }} {{ $selectedUser['last_name'] }}
                                    </h4>

                                    <p class="text-sm text-slate-500">
                                        {{ $selectedUser['email'] }}
                                    </p>

                                </div>

                            </div>


                            {{-- Details Grid --}}

                            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                                <div>

                                    <h4 class="text-sm font-bold text-slate-900">
                                        Phone Number
                                    </h4>

                                    <p class="mt-2 text-sm text-slate-600">
                                        {{ $selectedUser['phone_number'] ?? '—' }}
                                    </p>

                                </div>

                                <div>

                                    <h4 class="text-sm font-bold text-slate-900">
                                        Role
                                    </h4>

                                    <p class="mt-2">

                                        @if ($selectedUser['role'] === 'admin')

                                            <span class="inline-flex items-center rounded-md bg-purple-50 px-2.5 py-1 text-xs font-medium text-purple-700">
                                                Admin
                                            </span>

                                        @elseif ($selectedUser['role'] === 'manager')

                                            <span class="inline-flex items-center rounded-md bg-amber-50 px-2.5 py-1 text-xs font-medium text-amber-700">
                                                Manager
                                            </span>

                                        @else

                                            <span class="inline-flex items-center rounded-md bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700">
                                                Registered
                                            </span>

                                        @endif

                                    </p>

                                </div>

                                <div>

                                    <h4 class="text-sm font-bold text-slate-900">
                                        Account Status
                                    </h4>

                                    <p class="mt-2">

                                        @if ($selectedUser['account_status'] === 'active')

                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">

                                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>

                                                Active

                                            </span>

                                        @elseif ($selectedUser['account_status'] === 'banned')

                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-2.5 py-1 text-xs font-semibold text-red-700">

                                                <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>

                                                Banned

                                            </span>

                                        @else

                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">

                                                <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>

                                                Suspended

                                            </span>

                                        @endif

                                    </p>

                                </div>

                                <div>

                                    <h4 class="text-sm font-bold text-slate-900">
                                        Joined
                                    </h4>

                                    <p class="mt-2 text-sm text-slate-600">
                                        {{ optional($selectedUser['created_at'])->format('M d, Y') ?? '—' }}
                                    </p>

                                </div>

                                @if (!empty($selectedUser['last_edited_by_name']))

                                <div>

                                    <h4 class="text-sm font-bold text-slate-900">
                                        Last Edited
                                    </h4>

                                    <p class="mt-2 text-sm text-slate-600">
                                        {{ $selectedUser['last_edited_by_name'] }}
                                        @if (!empty($selectedUser['last_edited_at']))
                                            — {{ optional($selectedUser['last_edited_at'])->format('M d, Y g:i A') }}
                                        @endif
                                    </p>

                                </div>

                                @endif

                            </div>

                        </div>

                    @endif

                </div>


                {{-- ====================================================
                    MODAL FOOTER
                ===================================================== --}}

                <div class="flex items-center justify-end gap-3 border-t border-slate-200 bg-slate-50 px-6 py-4">

                    @if (!empty($selectedUser['user_id']))

                        <a
                            href="{{ route(
                                'admin.users.edit',
                                $selectedUser['user_id']
                            ) }}"
                            class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">

                            Edit User

                        </a>

                    @endif

                    <button
                        type="button"
                        wire:click="closeViewModal"
                        class="inline-flex items-center rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">

                        Close

                    </button>

                </div>

            </div>

        </div>

    @endif


    {{-- ================================================================
        LOADING
    ================================================================= --}}

    <div
        wire:loading.flex
        wire:target="search, roleFilter, statusFilter, clearFilters, delete, view"
        class="fixed inset-0 z-[9998] hidden items-center justify-center bg-slate-900/10 backdrop-blur-[1px]">

        <div class="flex items-center gap-3 rounded-lg bg-white px-5 py-4 text-sm font-medium text-slate-700 shadow-xl">

            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                class="h-5 w-5 animate-spin">

                <circle
                    cx="12"
                    cy="12"
                    r="9"
                    stroke="currentColor"
                    stroke-width="3"
                    class="opacity-25" />

                <path
                    fill="currentColor"
                    d="M4 12a8 8 0 0 1 8-8v3a5 5 0 0 0-5 5H4Z"
                    class="opacity-75" />

            </svg>

            Loading...

        </div>

    </div>

</div>