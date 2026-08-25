<div>

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
            class="h-5 w-5">
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="m9 12.75 2.25 2.25L15 9.75" />
            <circle
                cx="12"
                cy="12"
                r="9" />
        </svg>

        {{ session('success') }}
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
            class="h-5 w-5">
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M6 18 18 6M6 6l12 12" />
        </svg>

        {{ session('error') }}
    </div>
    @endif


    {{-- ================================================================
        PAGE
        Sidebar + Header remain in layouts.admin
    ================================================================= --}}

    <div class="sticky top-20 z-[100] bg-slate-50">

        {{-- ============================================================
            PAGE HEADER
        ============================================================= --}}

        <div class="border-b border-slate-200 bg-white">

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
                            Destinations
                        </h1>

                        <p class="mt-1 text-sm text-slate-500">
                            Manage tourist destinations and their information.
                        </p>

                    </div>


                    {{-- Add Destination --}}

                    <a
                        href="{{ route('admin.destinations.create') }}"
                        class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                        + Add Destination
                    </a>

                </div>

            </div>

        </div>


        {{-- ============================================================
            CONTENT
        ============================================================= --}}

        <div class="space-y-5 px-6 py-6">


            {{-- ========================================================
    STATISTICS
========================================================= --}}
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

                {{-- Total --}}
                <div class="flex min-h-[132px] items-center rounded-xl border border-slate-200 bg-white px-6 py-5 shadow-sm">

                    {{-- Icon --}}
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
                                d="M12 21s7-5.2 7-11a7 7 0 10-14 0c0 5.8 7 11 7 11z" />
                            <circle
                                cx="12"
                                cy="10"
                                r="2.5" />
                        </svg>
                    </div>

                    {{-- Content --}}
                    <div class="ml-5">
                        <p class="text-sm font-semibold text-slate-700">
                            Total
                        </p>

                        <p class="mt-1 text-2xl font-bold leading-none text-slate-900">
                            {{ $totalDestinations }}
                        </p>

                        <p class="mt-2 text-sm text-slate-400">
                            All destinations
                        </p>
                    </div>

                </div>


                {{-- Active --}}
                <div class="flex min-h-[132px] items-center rounded-xl border border-slate-200 bg-white px-6 py-5 shadow-sm">

                    {{-- Icon --}}
                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-emerald-50">
                        <svg
                            class="h-6 w-6 text-emerald-600"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            stroke-width="2">
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

                    {{-- Content --}}
                    <div class="ml-5">
                        <p class="text-sm font-semibold text-slate-700">
                            Active
                        </p>

                        <p class="mt-1 text-2xl font-bold leading-none text-slate-900">
                            {{ $activeDestinations }}
                        </p>

                        <p class="mt-2 text-sm text-slate-400">
                            Active destinations
                        </p>
                    </div>

                </div>


                {{-- Inactive --}}
                <div class="flex min-h-[132px] items-center rounded-xl border border-slate-200 bg-white px-6 py-5 shadow-sm">

                    {{-- Icon --}}
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

                    {{-- Content --}}
                    <div class="ml-5">
                        <p class="text-sm font-semibold text-slate-700">
                            Inactive
                        </p>

                        <p class="mt-1 text-2xl font-bold leading-none text-slate-900">
                            {{ $inactiveDestinations }}
                        </p>

                        <p class="mt-2 text-sm text-slate-400">
                            Inactive destinations
                        </p>
                    </div>

                </div>


                {{-- Categories --}}
                <div class="flex min-h-[132px] items-center rounded-xl border border-slate-200 bg-white px-6 py-5 shadow-sm">

                    {{-- Icon --}}
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
                                d="M4.5 6.75A2.25 2.25 0 016.75 4.5h4.5l8.25 8.25a2.25 2.25 0 010 3.18l-3.57 3.57a2.25 2.25 0 01-3.18 0L4.5 11.25v-4.5Z" />
                            <circle
                                cx="8.25"
                                cy="8.25"
                                r="1" />
                        </svg>
                    </div>

                    {{-- Content --}}
                    <div class="ml-5">
                        <p class="text-sm font-semibold text-slate-700">
                            Categories
                        </p>

                        <p class="mt-1 text-2xl font-bold leading-none text-slate-900">
                            {{ $categoryCount }}
                        </p>

                        <p class="mt-2 text-sm text-slate-400">
                            All categories
                        </p>
                    </div>

                </div> {{-- End Statistics Grid --}}

            </div> {{-- End Sticky Header + Cards --}}

            {{-- ========================================================
            SEARCH & FILTERS
        ========================================================= --}}
            <div class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm">

                <div class="flex flex-col gap-3 lg:flex-row lg:items-end">

                    {{-- Search --}}

                    <div class="flex-1">

                        <label
                            for="destination-search"
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
                                id="destination-search"
                                type="text"
                                wire:model.live.debounce.300ms="search"
                                placeholder="Search destinations..."
                                class="w-full rounded-lg border border-slate-300 bg-white py-2.5 pl-9 pr-4 text-sm text-slate-900 placeholder-slate-400 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100" />

                        </div>

                    </div>


                    {{-- Category --}}

                    <div class="w-full lg:w-56">

                        <label
                            for="category-filter"
                            class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Category
                        </label>

                        <select
                            id="category-filter"
                            wire:model.live="categoryFilter"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                            <option value="">
                                All Categories
                            </option>

                            @foreach ($categories as $category)

                            <option value="{{ $category->category_id }}">
                                {{ $category->name }}
                            </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Status --}}

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

                            <option value="hidden">
                                Inactive
                            </option>

                        </select>

                    </div>


                    {{-- Clear Filters --}}

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


            {{-- ========================================================
                DESTINATION TABLE
            ========================================================= --}}

            <div class="overflow-visible rounded-lg border border-slate-200 bg-white shadow-sm">


                {{-- ====================================================
                    TABLE HEADER
                ===================================================== --}}

                <div class="border-b border-slate-200 px-5 py-4">

                    <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">

                        <div>

                            <h2 class="text-base font-bold uppercase tracking-wide text-slate-900">
                                Destinations
                            </h2>

                            <p class="mt-0.5 text-sm text-slate-500">
                                Manage tourist destinations and their information.
                            </p>

                        </div>


                        {{-- Top result count --}}

                        @if ($destinations->total() > 0)

                        <p class="text-sm text-slate-500">

                            Showing

                            <span class="font-semibold text-slate-700">
                                {{ $destinations->firstItem() }}
                            </span>

                            -

                            <span class="font-semibold text-slate-700">
                                {{ $destinations->lastItem() }}
                            </span>

                            of

                            <span class="font-semibold text-slate-700">
                                {{ $destinations->total() }}
                            </span>

                        </p>

                        @endif

                    </div>

                </div>


                {{-- ====================================================
                    EMPTY STATE
                ===================================================== --}}

                @if ($destinations->isEmpty())

                <div class="px-6 py-16 text-center">

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
                                d="M20.25 10.5c0 4.97-8.25 10.5-8.25 10.5S3.75 15.47 3.75 10.5a8.25 8.25 0 1 1 16.5 0Z" />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>

                    </div>


                    @if ($hasActiveFilters)

                    <h3 class="mt-4 text-base font-semibold text-slate-900">
                        No destinations found
                    </h3>

                    <p class="mx-auto mt-1 max-w-md text-sm text-slate-500">
                        No destinations match your current search or filters.
                    </p>

                    <button
                        type="button"
                        wire:click="clearFilters"
                        class="mt-5 inline-flex items-center rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">
                        Clear Filters
                    </button>

                    @else

                    <h3 class="mt-4 text-base font-semibold text-slate-900">
                        No destinations yet
                    </h3>

                    <p class="mx-auto mt-1 max-w-md text-sm text-slate-500">
                        Start adding tourist destinations to your GoBattambang website.
                    </p>

                    <a
                        href="{{ route('admin.destinations.create') }}"
                        class="mt-5 inline-flex items-center rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">
                        + Add Destination
                    </a>

                    @endif

                </div>


                @else


                {{-- =================================================
                        TABLE
                    ================================================== --}}

                <div class="overflow-x-auto">

                    <table class="min-w-full">

                        <thead class="border-b border-slate-200 bg-slate-50">

                            <tr>

                                <th class="w-12 px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-slate-500">
                                    #
                                </th>

                                <th class="w-20 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                                    Photo
                                </th>

                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                                    Destination
                                </th>

                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                                    Category
                                </th>

                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                                    Price
                                </th>

                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                                    Status
                                </th>

                                <th class="w-20 px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-slate-500">
                                    Actions
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-slate-100 bg-white">

                            @foreach ($destinations as $destination)

                            @php

                            $primaryImage =
                            $destination->images->firstWhere(
                            'is_primary',
                            true
                            )
                            ?? $destination->images->first();

                            $rowNumber =
                            ($destinations->currentPage() - 1)
                            * $destinations->perPage()
                            + $loop->iteration;

                            @endphp


                            <tr
                                wire:key="destination-{{ $destination->destination_id }}"
                                class="transition hover:bg-slate-50">


                                {{-- NUMBER --}}

                                <td class="px-4 py-3 text-center text-sm font-medium text-slate-500">
                                    {{ $rowNumber }}
                                </td>


                                {{-- PHOTO --}}

                                <td class="px-3 py-3">

                                    <div class="h-12 w-16 overflow-hidden rounded-md bg-slate-100">

                                        @if ($primaryImage && $primaryImage->image_url)

                                        @php
                                        $displayImageUrl = asset(
                                        ltrim($primaryImage->image_url, '/')
                                        );
                                        @endphp

                                        <img
                                            src="{{ $displayImageUrl }}"
                                            alt="{{ $destination->title }}"
                                            class="h-full w-full object-cover"
                                            loading="lazy">

                                        @else

                                        <div class="flex h-full w-full items-center justify-center">

                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.5"
                                                stroke="currentColor"
                                                class="h-5 w-5 text-slate-400">
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.409 2.409M3.75 19.5h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Z" />
                                            </svg>

                                        </div>

                                        @endif

                                    </div>

                                </td>


                                {{-- DESTINATION --}}

                                <td class="px-4 py-3">

                                    <div class="min-w-0">

                                        <p class="max-w-[240px] truncate text-sm font-semibold text-slate-900">
                                            {{ $destination->title }}
                                        </p>

                                        <p class="mt-0.5 max-w-[240px] truncate text-xs text-slate-400">
                                            {{ $destination->slug }}
                                        </p>

                                    </div>

                                </td>


                                {{-- CATEGORY --}}

                                <td class="px-4 py-3">

                                    @if ($destination->category)

                                    <span class="inline-flex items-center rounded-md bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700">
                                        {{ $destination->category->name }}
                                    </span>

                                    @else

                                    <span class="text-sm text-slate-400">
                                        —
                                    </span>

                                    @endif

                                </td>


                                {{-- PRICE --}}

                                <td class="whitespace-nowrap px-4 py-3">

                                    @if (
                                    is_null($destination->ticket_price)
                                    ||
                                    $destination->ticket_price == 0
                                    )

                                    <span class="text-sm font-semibold text-slate-700">
                                        Free
                                    </span>

                                    @else

                                    <span class="text-sm font-semibold text-slate-700">
                                        ${{ number_format((float) $destination->ticket_price, 2) }}
                                    </span>

                                    @endif

                                </td>


                                {{-- STATUS --}}

                                <td class="whitespace-nowrap px-4 py-3">

                                    @if ($destination->status === 'active')

                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">

                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>

                                        Active

                                    </span>

                                    @else

                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">

                                        <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>

                                        Inactive

                                    </span>

                                    @endif

                                </td>


                                {{-- ACTIONS --}}

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
                                            aria-label="Destination actions">

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
                                            class="absolute right-0 z-50 mt-2 w-36 origin-top-right rounded-lg border border-slate-200 bg-white py-1 text-left shadow-lg">

                                            {{-- VIEW --}}

                                            <button
                                                type="button"
                                                wire:click="view({{ $destination->destination_id }})"
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
                                                            'admin.destinations.edit',
                                                            $destination->destination_id
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
                                                wire:click="delete({{ $destination->destination_id }})"
                                                wire:confirm="Are you sure you want to delete '{{ $destination->title }}'? This action cannot be undone."
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

                </div>


                {{-- ================================================================
    TABLE FOOTER
================================================================= --}}
                <div class="flex flex-col gap-4 border-t border-slate-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">

                    {{-- Showing X - Y of Z --}}
                    <div class="text-sm text-slate-500">
                        Showing
                        <span class="font-medium text-slate-900">
                            {{ $destinations->firstItem() ?? 0 }}
                        </span>
                        -
                        <span class="font-medium text-slate-900">
                            {{ $destinations->lastItem() ?? 0 }}
                        </span>
                        of
                        <span class="font-medium text-slate-900">
                            {{ $destinations->total() }}
                        </span>
                    </div>


                    {{-- Pagination --}}
                    <div class="flex items-center gap-2">

                        {{-- Previous Button --}}
                        @if ($destinations->onFirstPage())

                        <button
                            type="button"
                            disabled
                            class="flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-300 cursor-not-allowed"
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
                        @for ($page = 1; $page <= max(1, $destinations->lastPage()); $page++)

                            @if ($page === $destinations->currentPage())

                            {{-- Current Page --}}
                            <button
                                type="button"
                                wire:key="page-{{ $page }}"
                                class="flex h-10 min-w-10 items-center justify-center rounded-lg bg-blue-600 px-3 text-sm font-semibold text-white shadow-sm"
                                aria-current="page">
                                {{ $page }}
                            </button>

                            @else

                            {{-- Other Page --}}
                            <button
                                type="button"
                                wire:key="page-{{ $page }}"
                                wire:click="gotoPage({{ $page }})"
                                class="flex h-10 min-w-10 items-center justify-center rounded-lg border border-slate-200 bg-white px-3 text-sm font-medium text-slate-600 transition hover:bg-slate-50">
                                {{ $page }}
                            </button>

                            @endif

                            @endfor


                            {{-- Next Button --}}
                            @if ($destinations->hasMorePages())

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
                                class="flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-300 cursor-not-allowed"
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

                @endif

            </div>

        </div>

    </div>


    {{-- ================================================================
        VIEW DESTINATION MODAL
    ================================================================= --}}

    @if ($showViewModal)

    <div
        x-data
        x-on:keydown.escape.window="$wire.closeViewModal()"
        class="fixed inset-0 z-[9990] overflow-y-auto">

        {{-- Backdrop --}}

        <div
            class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm"
            wire:click="closeViewModal"></div>


        {{-- Modal --}}

        <div class="relative flex min-h-screen items-center justify-center p-4">

            <div class="relative w-full max-w-4xl overflow-hidden rounded-xl bg-white shadow-2xl">

                {{-- Header --}}

                <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">

                    <div>

                        <h2 class="text-lg font-bold text-slate-900">
                            Destination Details
                        </h2>

                        <p class="mt-0.5 text-sm text-slate-500">
                            View destination information.
                        </p>

                    </div>

                    <button
                        type="button"
                        wire:click="closeViewModal"
                        class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-slate-400 hover:bg-slate-100 hover:text-slate-700">
                        ✕
                    </button>

                </div>


                {{-- Body --}}

                <div class="max-h-[75vh] overflow-y-auto">

                    @if (!empty($selectedDestination))

                    {{-- Main Image --}}

                    <div class="border-b border-slate-200 bg-slate-50 p-5">

                        @if (!empty($selectedDestination['primary_image']))

                        @php

                        $modalImage =
                        $selectedDestination['primary_image'];

                        if (
                        str_starts_with($modalImage, 'http://')
                        ||
                        str_starts_with($modalImage, 'https://')
                        ) {
                        $modalImageUrl = $modalImage;
                        } else {
                        $modalImageUrl = asset(
                        ltrim($modalImage, '/')
                        );
                        }

                        @endphp

                        <div class="flex min-h-[16rem] max-h-[28rem] w-full items-center justify-center overflow-hidden rounded-lg bg-slate-100">
                            <img
                                src="{{ $modalImageUrl }}"
                                alt="{{ $selectedDestination['title'] }}"
                                class="max-h-[28rem] max-w-full w-auto object-contain"
                                loading="eager">
                        </div>

                        @else

                        <div class="flex h-64 items-center justify-center rounded-lg bg-slate-100">

                            <span class="text-sm text-slate-400">
                                No image available
                            </span>

                        </div>

                        @endif

                    </div>


                    {{-- Information --}}

                    <div class="space-y-6 p-6">

                        {{-- Title --}}

                        <div>

                            <div class="flex flex-wrap items-center gap-3">

                                <h3 class="text-xl font-bold text-slate-900">
                                    {{ $selectedDestination['title'] }}
                                </h3>

                                @if ($selectedDestination['status'] === 'active')

                                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">

                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>

                                    Active

                                </span>

                                @else

                                <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">

                                    <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>

                                    Inactive

                                </span>

                                @endif

                            </div>

                            <p class="mt-1 text-sm text-slate-400">
                                {{ $selectedDestination['slug'] }}
                            </p>

                        </div>


                        {{-- Basic Information --}}

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">

                            <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">

                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                    Category
                                </p>

                                <p class="mt-1 text-sm font-semibold text-slate-800">
                                    {{ $selectedDestination['category'] ?? '—' }}
                                </p>

                            </div>


                            <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">

                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                    Ticket Price
                                </p>

                                <p class="mt-1 text-sm font-semibold text-slate-800">

                                    @if (
                                    is_null($selectedDestination['ticket_price'])
                                    ||
                                    $selectedDestination['ticket_price'] == 0
                                    )

                                    Free

                                    @else

                                    ${{ number_format(
                                                    (float) $selectedDestination['ticket_price'],
                                                    2
                                                ) }}

                                    @endif

                                </p>

                            </div>


                            <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">

                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                    Status
                                </p>

                                <p class="mt-1 text-sm font-semibold text-slate-800">
                                    {{ ($selectedDestination['status'] ?? '') === 'hidden' ? 'Inactive' : ucfirst($selectedDestination['status'] ?? '—') }}
                                </p>

                            </div>

                        </div>


                        {{-- Description --}}

                        @if (!empty($selectedDestination['description']))

                        <div>

                            <h4 class="text-sm font-bold text-slate-900">
                                Description
                            </h4>

                            <p class="mt-2 whitespace-pre-line text-sm leading-6 text-slate-600">
                                {{ $selectedDestination['description'] }}
                            </p>

                        </div>

                        @endif


                        {{-- Things To Do --}}

                        @if (!empty($selectedDestination['things_to_do']))

                        <div>

                            <h4 class="text-sm font-bold text-slate-900">
                                Things to Do
                            </h4>

                            <p class="mt-2 whitespace-pre-line text-sm leading-6 text-slate-600">
                                {{ $selectedDestination['things_to_do'] }}
                            </p>

                        </div>

                        @endif


                        {{-- Things To Prepare --}}

                        @if (!empty($selectedDestination['things_to_prepare']))

                        <div>

                            <h4 class="text-sm font-bold text-slate-900">
                                Things to Prepare
                            </h4>

                            <p class="mt-2 whitespace-pre-line text-sm leading-6 text-slate-600">
                                {{ $selectedDestination['things_to_prepare'] }}
                            </p>

                        </div>

                        @endif


                        {{-- Location --}}

                        <div>

                            <h4 class="text-sm font-bold text-slate-900">
                                Location
                            </h4>

                            <div class="mt-2 space-y-2">

                                <p class="text-sm text-slate-600">
                                    {{ $selectedDestination['address'] ?? '—' }}
                                </p>

                                @if (
                                !empty($selectedDestination['latitude'])
                                ||
                                !empty($selectedDestination['longitude'])
                                )

                                <p class="text-xs text-slate-400">

                                    Latitude:
                                    {{ $selectedDestination['latitude'] ?? '—' }}

                                    &nbsp;&nbsp;

                                    Longitude:
                                    {{ $selectedDestination['longitude'] ?? '—' }}

                                </p>

                                @endif


                                @if (!empty($selectedDestination['map_link']))

                                <a
                                    href="{{ $selectedDestination['map_link'] }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex items-center text-sm font-semibold text-blue-600 hover:text-blue-700">
                                    View on Google Maps →
                                </a>

                                @endif

                            </div>

                        </div>


                        {{-- Opening Hours --}}

                        @if (
                        !empty($selectedDestination['open_time'])
                        ||
                        !empty($selectedDestination['close_time'])
                        )

                        <div>

                            <h4 class="text-sm font-bold text-slate-900">
                                Opening Hours
                            </h4>

                            <p class="mt-2 text-sm text-slate-600">

                                {{ $selectedDestination['open_time'] ?? '—' }}

                                -

                                {{ $selectedDestination['close_time'] ?? '—' }}

                            </p>

                        </div>

                        @endif


                        {{-- Photos --}}

                        @if (
                        !empty($selectedDestination['images'])
                        &&
                        count($selectedDestination['images']) > 0
                        )

                        <div>

                            <h4 class="text-sm font-bold text-slate-900">
                                Photos
                            </h4>

                            <div class="mt-3 grid grid-cols-3 gap-3 sm:grid-cols-5">

                                @foreach ($selectedDestination['images'] as $image)

                                @php

                                $galleryImage =
                                $image['image_url'];

                                if (
                                str_starts_with($galleryImage, 'http://')
                                ||
                                str_starts_with($galleryImage, 'https://')
                                ) {
                                $galleryImageUrl = $galleryImage;
                                } else {
                                $galleryImageUrl = asset(
                                ltrim($galleryImage, '/')
                                );
                                }

                                @endphp

                                <div class="relative aspect-square overflow-hidden rounded-lg bg-slate-100">

                                    <img
                                        src="{{ $galleryImageUrl }}"
                                        alt="Destination photo"
                                        class="h-full w-full object-cover">

                                    @if ($image['is_primary'])

                                    <span class="absolute bottom-1 left-1 rounded bg-blue-600 px-1.5 py-0.5 text-[10px] font-semibold text-white">
                                        Primary
                                    </span>

                                    @endif

                                </div>

                                @endforeach

                            </div>

                        </div>

                        @endif

                    </div>

                    @endif

                </div>


                {{-- Footer --}}

                <div class="flex items-center justify-end gap-3 border-t border-slate-200 bg-slate-50 px-6 py-4">

                    @if (!empty($selectedDestination['destination_id']))

                    <a
                        href="{{ route(
                                    'admin.destinations.edit',
                                    $selectedDestination['destination_id']
                                ) }}"
                        class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">
                        Edit Destination
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

    </div>

    @endif


    {{-- ================================================================
        LOADING
    ================================================================= --}}

    <div
        wire:loading.flex
        wire:target="search, categoryFilter, statusFilter, clearFilters, delete, view"
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