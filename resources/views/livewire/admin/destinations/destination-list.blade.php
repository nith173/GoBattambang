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
            SCROLL-FREE TOP CONTENT
            Statistics + Search/Filter
        ============================================================= --}}

        <div class="shrink-0 space-y-5 px-6 py-6">


            {{-- ========================================================
                STATISTICS
            ========================================================= --}}

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">


                {{-- TOTAL --}}

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
                                d="M12 21s7-5.2 7-11a7 7 0 10-14 0c0 5.8 7 11 7 11z" />

                            <circle
                                cx="12"
                                cy="10"
                                r="2.5" />

                        </svg>

                    </div>

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


                {{-- ACTIVE --}}

                <div class="flex min-h-[132px] items-center rounded-xl border border-slate-200 bg-white px-6 py-5 shadow-sm">

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


                {{-- INACTIVE --}}

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


                {{-- CATEGORIES --}}

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
                                d="M4.5 6.75A2.25 2.25 0 016.75 4.5h4.5l8.25 8.25a2.25 2.25 0 010 3.18l-3.57 3.57a2.25 2.25 0 01-3.18 0L4.5 11.25v-4.5Z" />

                            <circle
                                cx="8.25"
                                cy="8.25"
                                r="1" />

                        </svg>

                    </div>

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

                </div>

            </div>


            {{-- ========================================================
                SEARCH & FILTERS
            ========================================================= --}}

            <div class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm">

                <div class="flex flex-col gap-3 lg:flex-row lg:items-end">


                    {{-- SEARCH --}}

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


                    {{-- CATEGORY --}}

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


                    {{-- STATUS --}}

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


                    {{-- CLEAR --}}

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
        ================================================================= --}}

        <div class="flex min-h-0 flex-1 flex-col px-6 pb-6">


            {{-- DESTINATION TABLE CARD --}}

            <div class="flex min-h-0 flex-1 flex-col overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">


                {{-- TABLE TITLE / RESULT COUNT --}}

                <div class="shrink-0 border-b border-slate-200 bg-white px-5 py-4">

                    <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">

                        <div>

                            <h2 class="text-base font-bold uppercase tracking-wide text-slate-900">
                                Destinations
                            </h2>

                            <p class="mt-0.5 text-sm text-slate-500">
                                Manage tourist destinations and their information.
                            </p>

                        </div>


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


                {{-- EMPTY STATE --}}

                @if ($destinations->isEmpty())

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

                    </div>


                @else


                    {{-- SCROLLABLE TABLE AREA --}}

                    <div class="min-h-0 flex-1 overflow-auto">

                        <table class="min-w-full">

                            <thead class="sticky top-0 z-30 border-b border-slate-200 bg-slate-50">

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
                                        $primaryImage = $destination->images->firstWhere('is_primary', true) ?? $destination->images->first();
                                        $rowNumber = ($destinations->currentPage() - 1) * $destinations->perPage() + $loop->iteration;
                                    @endphp

                                    <tr wire:key="destination-{{ $destination->destination_id }}" class="transition hover:bg-slate-50">

                                        {{-- NUMBER --}}
                                        <td class="px-4 py-3 text-center text-sm font-medium text-slate-500">
                                            {{ $rowNumber }}
                                        </td>

                                        {{-- PHOTO --}}
                                        <td class="px-3 py-3">
                                            <div class="h-12 w-16 overflow-hidden rounded-md bg-slate-100">
                                                @if ($primaryImage && $primaryImage->image_url)
                                                    @php
                                                        $displayImageUrl = asset(ltrim($primaryImage->image_url, '/'));
                                                    @endphp
                                                    <img src="{{ $displayImageUrl }}" alt="{{ $destination->title }}" class="h-full w-full object-cover" loading="lazy">
                                                @else
                                                    <div class="flex h-full w-full items-center justify-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-slate-400">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.409 2.409M3.75 19.5h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Z" />
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
                                                <p class="max-w-[240px] truncate text-xs text-slate-500">
                                                    {{ $destination->address ?? 'No address set' }}
                                                </p>
                                            </div>
                                        </td>

                                        {{-- CATEGORY --}}
                                        <td class="px-4 py-3 text-sm text-slate-600 whitespace-nowrap">
                                            {{ $destination->category->name ?? 'Uncategorized' }}
                                        </td>

                                        {{-- PRICE --}}
                                        <td class="px-4 py-3 text-sm font-medium text-slate-900 whitespace-nowrap">
                                            {{ $destination->ticket_price ? '$' . number_format($destination->ticket_price, 2) : 'Free' }}
                                        </td>

                                        {{-- STATUS --}}
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            @if ($destination->status === 'active')
                                                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                                    Active
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                                    Inactive
                                                </span>
                                            @endif
                                        </td>

                                        {{-- ACTIONS --}}
                                        <td class="px-4 py-3 text-center whitespace-nowrap">
                                            <div class="flex items-center justify-center gap-2">
                                                <button wire:click="view({{ $destination->destination_id }})" class="rounded p-1 text-slate-400 hover:bg-slate-100 hover:text-blue-600 transition">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </button>
                                                <button wire:click="delete({{ $destination->destination_id }})" wire:confirm="Are you sure you want to delete this destination?" class="rounded p-1 text-slate-400 hover:bg-slate-100 hover:text-red-600 transition">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                        {{-- PAGINATION --}}
                        <div class="border-t border-slate-200 px-5 py-3">
                            {{ $destinations->links() }}
                        </div>

                    </div>

                @endif

            </div>

        </div>

    </div>

</div>
