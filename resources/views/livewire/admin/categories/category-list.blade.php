<div
    class="h-[calc(100vh-5rem)] overflow-hidden bg-slate-50"
    x-data
>

    {{-- ============================================================
        SUCCESS / ERROR ALERTS
    ============================================================= --}}

    @if (session()->has('success'))
        <div
            x-data="{ show: true }"
            x-show="show"
            x-init="setTimeout(() => show = false, 3000)"
            x-transition
            class="fixed right-6 top-6 z-[100] flex items-center gap-3 rounded-xl border border-green-200 bg-white px-5 py-4 text-sm font-medium text-green-700 shadow-lg"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.8"
                stroke="currentColor"
                class="h-5 w-5 text-green-500"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M9 12.75 11.25 15 15 9.75"
                />
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                />
            </svg>

            {{ session('success') }}
        </div>
    @endif


    @if (session()->has('error'))
        <div
            x-data="{ show: true }"
            x-show="show"
            x-init="setTimeout(() => show = false, 4000)"
            x-transition
            class="fixed right-6 top-6 z-[100] flex items-center gap-3 rounded-xl border border-red-200 bg-white px-5 py-4 text-sm font-medium text-red-700 shadow-lg"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.8"
                stroke="currentColor"
                class="h-5 w-5 text-red-500"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 9v3.75m0 3.75h.008v.008H12V16.5Z"
                />
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                />
            </svg>

            {{ session('error') }}
        </div>
    @endif


    {{-- ============================================================
        MAIN CONTENT
        Header stays fixed; only the table section below scrolls.
    ============================================================= --}}

    <div class="flex h-full min-h-0 flex-col bg-slate-50">


        {{-- ============================================================
            PAGE HEADER
        ============================================================= --}}

        <div class="shrink-0 border-b border-slate-200 bg-white">

            <div class="px-6 py-5">

                <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

                    <div>

                        {{-- Back --}}
                        <a
                            href="{{ route('admin.dashboard') }}"
                            class="mb-3 inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-blue-600"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.8"
                                stroke="currentColor"
                                class="h-4 w-4"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m15 18-6-6 6-6"
                                />
                            </svg>

                            Dashboard
                        </a>


                        <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                            Categories
                        </h1>

                        <p class="mt-1 text-sm text-slate-500">
                            Manage destination categories and their information.
                        </p>

                    </div>


                    {{-- Add Category --}}
                    <a
                        href="{{ route('admin.categories.create') }}"
                        class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700"
                    >
                        + Add Category
                    </a>

                </div>

            </div>

        </div>


        {{-- ====================================================
            SCROLL-FREE TOP CONTENT
            Statistics + Search
        ===================================================== --}}

        <div class="shrink-0 space-y-5 px-6 py-6">


            {{-- ====================================================
                STATISTICS
            ===================================================== --}}

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">


                {{-- Total Categories --}}
                <div class="flex min-h-[132px] items-center rounded-xl border border-slate-200 bg-white px-6 py-5 shadow-sm">

                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-purple-50">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.7"
                            stroke="currentColor"
                            class="h-6 w-6 text-purple-600"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M9.75 3.75h4.5m-7.5 3h10.5m-12 3h13.5v7.5a3 3 0 0 1-3 3h-7.5a3 3 0 0 1-3-3v-7.5Z"
                            />
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M9 13.5h6m-6 3h3"
                            />
                        </svg>

                    </div>

                    <div class="ml-5">

                        <p class="text-sm font-semibold text-slate-700">
                            Total
                        </p>

                        <p class="mt-1 text-2xl font-bold leading-none text-slate-900">
                            {{ $totalCategories }}
                        </p>

                        <p class="mt-2 text-sm text-slate-400">
                            All categories
                        </p>

                    </div>

                </div>


                {{-- With Destinations --}}
                <div class="flex min-h-[132px] items-center rounded-xl border border-slate-200 bg-white px-6 py-5 shadow-sm">

                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-blue-50">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.7"
                            stroke="currentColor"
                            class="h-6 w-6 text-blue-600"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 21s8.25-5.25 8.25-11.25a8.25 8.25 0 1 0-16.5 0C3.75 15.75 12 21 12 21Z"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 12.75a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"
                            />
                        </svg>

                    </div>

                    <div class="ml-5">

                        <p class="text-sm font-semibold text-slate-700">
                            Used
                        </p>

                        <p class="mt-1 text-2xl font-bold leading-none text-slate-900">
                            {{ $categories->where('destinations_count', '>', 0)->count() }}
                        </p>

                        <p class="mt-2 text-sm text-slate-400">
                            Categories with destinations
                        </p>

                    </div>

                </div>


                {{-- Empty Categories --}}
                <div class="flex min-h-[132px] items-center rounded-xl border border-slate-200 bg-white px-6 py-5 shadow-sm">

                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-amber-50">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.7"
                            stroke="currentColor"
                            class="h-6 w-6 text-amber-500"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3.75 6.75h16.5M6.75 3.75h10.5l3 3v13.5H3.75V6.75l3-3Z"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M9 12h6m-6 3h4.5"
                            />
                        </svg>

                    </div>

                    <div class="ml-5">

                        <p class="text-sm font-semibold text-slate-700">
                            Empty
                        </p>

                        <p class="mt-1 text-2xl font-bold leading-none text-slate-900">
                            {{ $categories->where('destinations_count', 0)->count() }}
                        </p>

                        <p class="mt-2 text-sm text-slate-400">
                            No destinations assigned
                        </p>

                    </div>

                </div>

            </div>


            {{-- ====================================================
                SEARCH
            ===================================================== --}}

            <div class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm">

                <div class="flex flex-col gap-3 lg:flex-row lg:items-end">

                    <div class="flex-1">

                        <label
                            for="category-search"
                            class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-500"
                        >
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
                                    class="h-4 w-4 text-slate-400"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="m21 21-4.35-4.35m1.35-5.4a6.75 6.75 0 1 1-13.5 0 6.75 6.75 0 0 1 13.5 0Z"
                                    />
                                </svg>

                            </div>

                            <input
                                id="category-search"
                                type="text"
                                wire:model.live.debounce.300ms="search"
                                placeholder="Search categories..."
                                class="w-full rounded-lg border border-slate-300 bg-white py-2.5 pl-9 pr-4 text-sm text-slate-900 placeholder-slate-400 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                            />

                        </div>

                    </div>


                    {{-- Clear Search --}}
                    @if (trim($search) !== '')
                        <button
                            type="button"
                            wire:click="clearFilters"
                            class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.8"
                                stroke="currentColor"
                                class="h-4 w-4"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6 18 18 6M6 6l12 12"
                                />
                            </svg>

                            Clear
                        </button>
                    @endif

                </div>

            </div>

        </div>


        {{-- ====================================================
            TABLE AREA
            This takes the remaining available height.
        ===================================================== --}}

        <div class="flex min-h-0 flex-1 flex-col px-6 pb-6">

            <div class="flex min-h-0 flex-1 flex-col overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">


                    {{-- Table Header --}}
                    <div class="shrink-0 border-b border-slate-200 px-5 py-4">

                        <div class="flex items-center justify-between">

                            <div>

                                <h2 class="text-base font-bold uppercase tracking-wide text-slate-900">
                                    Categories
                                </h2>

                                <p class="mt-1 text-sm text-slate-500">
                                    Manage destination categories and their information.
                                </p>

                            </div>


                            <div class="text-sm text-slate-500">

                                Showing
                                <span class="font-semibold text-slate-700">
                                    {{ $categories->firstItem() ?? 0 }}
                                </span>

                                -

                                <span class="font-semibold text-slate-700">
                                    {{ $categories->lastItem() ?? 0 }}
                                </span>

                                of

                                <span class="font-semibold text-slate-700">
                                    {{ $categories->total() }}
                                </span>

                            </div>

                        </div>

                    </div>


                    {{-- ====================================================
                        SCROLLABLE TABLE AREA
                    ===================================================== --}}

                    <div class="min-h-0 flex-1 overflow-y-auto">

                        <table class="min-w-full table-fixed">

                            <thead class="sticky top-0 z-20 bg-slate-50">

                                <tr class="border-b border-slate-200">

                                    <th
                                        class="w-16 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500"
                                    >
                                        #
                                    </th>

                                    <th
                                        class="w-[28%] px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500"
                                    >
                                        Category
                                    </th>

                                    <th
                                        class="w-[38%] px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500"
                                    >
                                        Description
                                    </th>

                                    <th
                                        class="w-40 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500"
                                    >
                                        Destinations
                                    </th>

                                    <th
                                        class="w-36 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500"
                                    >
                                        Created
                                    </th>

                                    <th
                                        class="w-24 px-5 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500"
                                    >
                                        Actions
                                    </th>

                                </tr>

                            </thead>


                            <tbody class="divide-y divide-slate-100">

                                @forelse ($categories as $index => $category)

                                    <tr class="transition hover:bg-slate-50">


                                        {{-- Number --}}
                                        <td class="px-5 py-4 text-sm text-slate-500">

                                            {{ $categories->firstItem() + $index }}

                                        </td>


                                        {{-- Category --}}
                                        <td class="px-5 py-4">

                                            <div class="min-w-0">

                                                <p class="truncate text-sm font-semibold text-slate-800">
                                                    {{ $category->name }}
                                                </p>

                                                <p class="mt-1 text-xs text-slate-400">
                                                    Category #{{ $category->category_id }}
                                                </p>

                                            </div>

                                        </td>


                                        {{-- Description --}}
                                        <td class="px-5 py-4">

                                            @if ($category->description)

                                                <p class="line-clamp-2 text-sm text-slate-500">
                                                    {{ $category->description }}
                                                </p>

                                            @else

                                                <span class="text-sm text-slate-400">
                                                    No description
                                                </span>

                                            @endif

                                        </td>


                                        {{-- Destinations --}}
                                        <td class="px-5 py-4">

                                            <span class="inline-flex items-center rounded-lg bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-600">

                                                {{ $category->destinations_count }}

                                            </span>

                                        </td>


                                        {{-- Created --}}
                                        <td class="px-5 py-4 text-sm text-slate-500">

                                            {{ $category->created_at
                                                ? \Illuminate\Support\Carbon::parse($category->created_at)->format('d M Y')
                                                : '—'
                                            }}

                                        </td>


                                        {{-- Actions --}}
                                        <td class="px-5 py-4 text-right">

                                            <div
                                                x-data="{ open: false }"
                                                class="relative inline-block text-left"
                                            >

                                                <button
                                                    type="button"
                                                    @click="open = !open"
                                                    @click.outside="open = false"
                                                    class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-slate-400 transition hover:bg-slate-100 hover:text-slate-700"
                                                >

                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke-width="2"
                                                        stroke="currentColor"
                                                        class="h-5 w-5"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M12 6.75h.008v.008H12V6.75Zm0 5.25h.008v.008H12V12Zm0 5.25h.008v.008H12V17.25Z"
                                                        />
                                                    </svg>

                                                </button>


                                                {{-- Dropdown --}}
                                                <div
                                                    x-show="open"
                                                    x-transition
                                                    x-cloak
                                                    class="absolute right-0 top-full z-50 mt-1 w-40 overflow-hidden rounded-lg border border-slate-200 bg-white py-1 text-left shadow-lg"
                                                >

                                                    {{-- VIEW --}}
                                                    <button
                                                        type="button"
                                                        wire:click="viewCategory({{ $category->category_id }})"
                                                        @click="open = false"
                                                        class="flex w-full items-center gap-3 px-4 py-2.5 text-sm text-slate-600 transition hover:bg-slate-50"
                                                    >

                                                        <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            fill="none"
                                                            viewBox="0 0 24 24"
                                                            stroke-width="1.7"
                                                            stroke="currentColor"
                                                            class="h-4 w-4 text-slate-500"
                                                        >
                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12Z"
                                                            />

                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                d="M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z"
                                                            />
                                                        </svg>

                                                        View

                                                    </button>


                                                    {{-- EDIT --}}
                                                    <a
                                                        href="{{ route('admin.categories.edit', $category->category_id) }}"
                                                        class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-600 transition hover:bg-slate-50"
                                                    >

                                                        <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            fill="none"
                                                            viewBox="0 0 24 24"
                                                            stroke-width="1.7"
                                                            stroke="currentColor"
                                                            class="h-4 w-4 text-blue-600"
                                                        >
                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652l-9.193 9.193a4.5 4.5 0 0 1-1.897 1.13l-3.347.995.995-3.347a1.875 1.875 0 0 1 .47-.79l7.973-7.973Z"
                                                            />

                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                d="M19.5 7.125 16.875 4.5"
                                                            />
                                                        </svg>

                                                        Edit

                                                    </a>


                                                    {{-- DELETE --}}
                                                    <button
                                                        type="button"
                                                        wire:click="deleteCategory({{ $category->category_id }})"
                                                        wire:confirm="Are you sure you want to delete this category?"
                                                        class="flex w-full items-center gap-3 px-4 py-2.5 text-sm text-red-600 transition hover:bg-red-50"
                                                    >

                                                        <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            fill="none"
                                                            viewBox="0 0 24 24"
                                                            stroke-width="1.7"
                                                            stroke="currentColor"
                                                            class="h-4 w-4"
                                                        >
                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                d="m9.75 9.75.5 6m4-6 .5 6M5.25 6.75h13.5m-9-3h4.5l1.5 3h-7.5l1.5-3ZM7.5 6.75l.75 13.5h7.5l.75-13.5"
                                                            />
                                                        </svg>

                                                        Delete

                                                    </button>

                                                </div>

                                            </div>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td
                                            colspan="6"
                                            class="px-6 py-16 text-center"
                                        >

                                            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-slate-100">

                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke-width="1.6"
                                                    stroke="currentColor"
                                                    class="h-7 w-7 text-slate-400"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5"
                                                    />
                                                </svg>

                                            </div>


                                            <h3 class="mt-4 text-base font-semibold text-slate-900">
                                                No categories found
                                            </h3>


                                            <p class="mx-auto mt-1 max-w-md text-sm text-slate-500">
                                                @if (trim($search) !== '')
                                                    Try changing your search.
                                                @else
                                                    There are currently no categories.
                                                @endif
                                            </p>

                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>


                    {{-- ====================================================
                        PAGINATION

                        IMPORTANT:
                        This is INSIDE the scrollable container (overflow-y-auto
                        above), same as the Destinations and Users pages.

                        Therefore:
                        - It does NOT stay fixed.
                        - It does NOT stay sticky.
                        - It scrolls with the table content.
                    ===================================================== --}}

                    <div class="flex flex-col gap-4 border-t border-slate-200 bg-white px-5 py-4 sm:flex-row sm:items-center sm:justify-between">

                        <div class="text-sm text-slate-500">

                            Showing

                            <span class="font-medium text-slate-900">
                                {{ $categories->firstItem() ?? 0 }}
                            </span>

                            -

                            <span class="font-medium text-slate-900">
                                {{ $categories->lastItem() ?? 0 }}
                            </span>

                            of

                            <span class="font-medium text-slate-900">
                                {{ $categories->total() }}
                            </span>

                        </div>


                        <div class="flex items-center gap-2">


                            {{-- Previous --}}

                            @if ($categories->onFirstPage())

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

                            @for ($page = 1; $page <= max(1, $categories->lastPage()); $page++)

                                @if ($page === $categories->currentPage())

                                    <button
                                        type="button"
                                        wire:key="page-{{ $page }}"
                                        class="flex h-10 min-w-10 items-center justify-center rounded-lg bg-blue-600 px-3 text-sm font-semibold text-white shadow-sm"
                                        aria-current="page">

                                        {{ $page }}

                                    </button>

                                @else

                                    <button
                                        type="button"
                                        wire:key="page-{{ $page }}"
                                        wire:click="gotoPage({{ $page }})"
                                        class="flex h-10 min-w-10 items-center justify-center rounded-lg border border-slate-200 bg-white px-3 text-sm font-medium text-slate-600 transition hover:bg-slate-50">

                                        {{ $page }}

                                    </button>

                                @endif

                            @endfor


                            {{-- Next --}}

                            @if ($categories->hasMorePages())

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

                </div>

            </div>

        </div>


    {{-- ============================================================
        CATEGORY VIEW MODAL
        NO SEPARATE CATEGORY VIEW FILE
    ============================================================= --}}

    @if ($viewingCategoryData)

        <div
            x-data="{ show: true }"
            x-show="show"
            x-cloak
            class="fixed inset-0 z-[200] flex items-center justify-center bg-slate-900/50 px-4 py-6 backdrop-blur-sm"
        >

            {{-- Modal --}}
            <div
                @click.outside="$wire.closeCategoryView()"
                class="flex max-h-[90vh] w-full max-w-2xl flex-col overflow-hidden rounded-2xl bg-white shadow-2xl"
            >


                {{-- ====================================================
                    MODAL HEADER
                ===================================================== --}}

                <div class="shrink-0 border-b border-slate-200 px-6 py-5">

                    <div class="flex items-start justify-between">

                        <div>

                            <h2 class="text-xl font-bold tracking-tight text-slate-900">
                                Category Details
                            </h2>

                            <p class="mt-1 text-sm text-slate-500">
                                View category information.
                            </p>

                        </div>


                        <button
                            type="button"
                            wire:click="closeCategoryView"
                            class="flex h-9 w-9 items-center justify-center rounded-lg text-slate-400 transition hover:bg-slate-100 hover:text-slate-700"
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.8"
                                stroke="currentColor"
                                class="h-5 w-5"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m6 6 12 12M6 18 18 6"
                                />
                            </svg>

                        </button>

                    </div>

                </div>


                {{-- ====================================================
                    MODAL CONTENT
                ===================================================== --}}

                <div class="min-h-0 flex-1 overflow-y-auto px-6 py-6">

                    <div class="space-y-6">


                        {{-- Category title --}}
                        <div>

                            <h3 class="text-2xl font-bold text-slate-900">
                                {{ $viewingCategoryData->name }}
                            </h3>

                            <p class="mt-1 text-sm text-slate-400">
                                Category #{{ $viewingCategoryData->category_id }}
                            </p>

                        </div>


                        {{-- Information cards --}}
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">


                            {{-- Name --}}
                            <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">

                                <p class="text-xs font-medium uppercase tracking-wide text-slate-500">
                                    Category Name
                                </p>

                                <p class="mt-2 text-sm font-semibold text-slate-900">
                                    {{ $viewingCategoryData->name }}
                                </p>

                            </div>


                            {{-- Destinations --}}
                            <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">

                                <p class="text-xs font-medium uppercase tracking-wide text-slate-500">
                                    Destinations
                                </p>

                                <p class="mt-2 text-2xl font-bold text-blue-600">
                                    {{ $viewingCategoryData->destinations->count() }}
                                </p>

                            </div>

                        </div>


                        {{-- Description --}}
                        <div>

                            <h3 class="text-sm font-bold text-slate-900">
                                Description
                            </h3>

                            @if ($viewingCategoryData->description)

                                <p class="mt-3 whitespace-pre-line text-sm leading-6 text-slate-600">
                                    {{ $viewingCategoryData->description }}
                                </p>

                            @else

                                <p class="mt-3 text-sm text-slate-400">
                                    No description provided.
                                </p>

                            @endif

                        </div>


                        {{-- Created --}}
                        <div>

                            <h3 class="text-sm font-bold text-slate-900">
                                Created
                            </h3>

                            <p class="mt-2 text-sm text-slate-600">

                                {{ $viewingCategoryData->created_at
                                    ? \Illuminate\Support\Carbon::parse($viewingCategoryData->created_at)->format('d M Y')
                                    : '—'
                                }}

                            </p>

                        </div>


                        {{-- Destinations --}}
                        <div>

                            <div class="flex items-center justify-between">

                                <div>

                                    <h3 class="text-sm font-bold text-slate-900">
                                        Destinations
                                    </h3>

                                    <p class="mt-1 text-sm text-slate-500">
                                        Destinations assigned to this category.
                                    </p>

                                </div>


                                <span class="rounded-lg bg-blue-50 px-3 py-1.5 text-sm font-semibold text-blue-600">
                                    {{ $viewingCategoryData->destinations->count() }}
                                </span>

                            </div>


                            @if ($viewingCategoryData->destinations->isEmpty())

                                <div class="mt-4 rounded-xl border border-dashed border-slate-300 px-5 py-8 text-center">

                                    <p class="text-sm text-slate-500">
                                        No destinations assigned to this category.
                                    </p>

                                </div>

                            @else

                                <div class="mt-4 divide-y divide-slate-100 overflow-hidden rounded-xl border border-slate-200">

                                    @foreach ($viewingCategoryData->destinations as $destination)

                                        <div class="flex items-center justify-between px-4 py-4">

                                            <div class="min-w-0">

                                                <p class="truncate text-sm font-semibold text-slate-800">
                                                    {{ $destination->title }}
                                                </p>

                                                @if ($destination->address)

                                                    <p class="mt-1 truncate text-xs text-slate-400">
                                                        {{ $destination->address }}
                                                    </p>

                                                @endif

                                            </div>


                                            @if ($destination->status)

                                                <span
                                                    class="ml-4 inline-flex shrink-0 items-center rounded-full bg-green-50 px-2.5 py-1 text-xs font-semibold text-green-600"
                                                >

                                                    <span class="mr-1.5 h-1.5 w-1.5 rounded-full bg-current"></span>

                                                    {{ ucfirst($destination->status) }}

                                                </span>

                                            @endif

                                        </div>

                                    @endforeach

                                </div>

                            @endif

                        </div>

                    </div>

                </div>


                {{-- ====================================================
                    MODAL FOOTER
                ===================================================== --}}

                <div class="flex shrink-0 items-center justify-end gap-3 border-t border-slate-200 bg-slate-50 px-6 py-4">

                    <a
                        href="{{ route('admin.categories.edit', $viewingCategoryData->category_id) }}"
                        class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700"
                    >

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.7"
                            stroke="currentColor"
                            class="h-4 w-4"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652l-9.193 9.193a4.5 4.5 0 0 1-1.897 1.13l-3.347.995.995-3.347a1.875 1.875 0 0 1 .47-.79l7.973-7.973Z"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M19.5 7.125 16.875 4.5"
                            />
                        </svg>

                        Edit Category

                    </a>


                    <button
                        type="button"
                        wire:click="closeCategoryView"
                        class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-50 hover:text-slate-800"
                    >
                        Close
                    </button>

                </div>

            </div>

        </div>

    @endif

</div>