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
        DETAILS POPUP
    ================================================================= --}}

    @if ($showDetailsPopup && $detailsLog)
        <div
            class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/50 px-4"
            wire:click.self="closeDetailsPopup">

            <div class="w-full max-w-lg overflow-hidden rounded-2xl bg-white shadow-2xl">

                <div class="flex items-center justify-between border-b border-slate-200 px-6 py-5">
                    <h3 class="text-lg font-bold text-slate-900">
                        Log {{ $detailsLog->log_id }}
                    </h3>

                    <button
                        type="button"
                        wire:click="closeDetailsPopup"
                        class="text-slate-400 hover:text-slate-600">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="2"
                            stroke="currentColor">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="max-h-[70vh] space-y-5 overflow-y-auto px-6 py-6">

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs font-medium uppercase tracking-wide text-slate-400">Admin</p>
                            <p class="mt-1 text-sm font-medium text-slate-900">
                                {{ $detailsLog->user->full_name ?? 'System' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs font-medium uppercase tracking-wide text-slate-400">Action</p>
                            <p class="mt-1">
                                <span @class([
                                    'inline-flex rounded-full px-2.5 py-1 text-xs font-semibold capitalize',
                                    'bg-green-100 text-green-700' => $detailsLog->action === 'created',
                                    'bg-blue-100 text-blue-700' => $detailsLog->action === 'updated',
                                    'bg-red-100 text-red-700' => $detailsLog->action === 'deleted',
                                ])>
                                    {{ $detailsLog->action }}
                                </span>
                            </p>
                        </div>

                        <div>
                            <p class="text-xs font-medium uppercase tracking-wide text-slate-400">Model</p>
                            <p class="mt-1 text-sm font-medium text-slate-900">
                                {{ $detailsLog->model_type }} {{ $detailsLog->model_id }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs font-medium uppercase tracking-wide text-slate-400">Date</p>
                            <p class="mt-1 text-sm font-medium text-slate-900">
                                {{ optional($detailsLog->created_at)->format('M d, Y g:i A') ?? '—' }}
                            </p>
                        </div>
                    </div>

                    <div>
                        <p class="mb-2 text-xs font-medium uppercase tracking-wide text-slate-400">
                            Changes
                        </p>

                        @if ($detailsLog->action === 'deleted' || empty($detailsLog->changes))

                            <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-500">
                                @if ($detailsLog->action === 'deleted')
                                    This record was permanently deleted. No field details available.
                                @else
                                    No changes recorded.
                                @endif
                            </div>

                        @else

                            <div class="space-y-3">
                                @foreach ($detailsLog->changes as $field => $value)
                                    <div class="rounded-xl border border-slate-200 p-3">
                                        <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-500">
                                            {{ str_replace('_', ' ', $field) }}
                                        </p>

                                        @if ($detailsLog->action === 'created')
                                            <p class="break-words text-sm text-slate-700">
                                                {{ is_array($value) ? json_encode($value) : $value }}
                                            </p>
                                        @else
                                            <div class="grid grid-cols-2 gap-3 text-sm">
                                                <div>
                                                    <p class="text-xs text-slate-400">Before</p>
                                                    <p class="break-words text-red-600">
                                                        {{ $value['old'] ?? '—' }}
                                                    </p>
                                                </div>
                                                <div>
                                                    <p class="text-xs text-slate-400">After</p>
                                                    <p class="break-words text-green-600">
                                                        {{ $value['new'] ?? '—' }}
                                                    </p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                        @endif
                    </div>

                </div>

                <div class="border-t border-slate-200 px-6 py-4">
                    <button
                        type="button"
                        wire:click="closeDetailsPopup"
                        class="w-full rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700">
                        Close
                    </button>
                </div>

            </div>
        </div>
    @endif


    {{-- ================================================================
        FIXED PAGE CONTENT
        Header + Search/Filter + Table
    ================================================================= --}}

    <div class="flex h-full min-h-0 flex-col bg-slate-50">


        {{-- ============================================================
            PAGE HEADER
        ============================================================= --}}

        <div class="shrink-0 border-b border-slate-200 bg-white">

            <div class="px-6 py-5">

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
                    Activity Log
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Track every create, update, and delete made across the system.
                </p>

            </div>

        </div>


        {{-- ============================================================
            SCROLL-FREE TOP CONTENT
            Search/Filter
        ============================================================= --}}

        <div class="shrink-0 space-y-5 px-6 py-6">

            <div class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm">

                <div class="flex flex-col gap-3 lg:flex-row lg:flex-wrap lg:items-end">

                    {{-- MODEL --}}
                    <div class="w-full lg:w-48">
                        <label
                            for="model-filter"
                            class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Model
                        </label>

                        <select
                            id="model-filter"
                            wire:model.live="modelFilter"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            <option value="all">All</option>
                            @foreach ($modelTypes as $type)
                                <option value="{{ $type }}">{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- ACTION --}}
                    <div class="w-full lg:w-44">
                        <label
                            for="action-filter"
                            class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Action
                        </label>

                        <select
                            id="action-filter"
                            wire:model.live="actionFilter"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            <option value="all">All</option>
                            <option value="created">Created</option>
                            <option value="updated">Updated</option>
                            <option value="deleted">Deleted</option>
                        </select>
                    </div>

                    {{-- DATE FROM --}}
                    <div class="w-full lg:w-44">
                        <label
                            for="date-from"
                            class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-500">
                            From
                        </label>

                        <input
                            id="date-from"
                            type="date"
                            wire:model.live="dateFrom"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100" />
                    </div>

                    {{-- DATE TO --}}
                    <div class="w-full lg:w-44">
                        <label
                            for="date-to"
                            class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-500">
                            To
                        </label>

                        <input
                            id="date-to"
                            type="date"
                            wire:model.live="dateTo"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100" />
                    </div>

                    {{-- CLEAR --}}
                    @if ($modelFilter !== 'all' || $actionFilter !== 'all' || $dateFrom !== '' || $dateTo !== '')
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

            <div class="flex min-h-0 flex-1 flex-col overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">

                {{-- TABLE TITLE / RESULT COUNT --}}
                <div class="shrink-0 border-b border-slate-200 bg-white px-5 py-4">

                    <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">

                        <div>
                            <h2 class="text-base font-bold uppercase tracking-wide text-slate-900">
                                Activity Log
                            </h2>

                            <p class="mt-0.5 text-sm text-slate-500">
                                Every create, update, and delete made across the system.
                            </p>
                        </div>

                        @if ($logs->total() > 0)
                            <p class="text-sm text-slate-500">
                                Showing
                                <span class="font-semibold text-slate-700">{{ $logs->firstItem() }}</span>
                                -
                                <span class="font-semibold text-slate-700">{{ $logs->lastItem() }}</span>
                                of
                                <span class="font-semibold text-slate-700">{{ $logs->total() }}</span>
                            </p>
                        @endif

                    </div>

                </div>


                {{-- EMPTY STATE --}}
                @if ($logs->isEmpty())

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
                                        d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </div>

                            @if ($modelFilter !== 'all' || $actionFilter !== 'all' || $dateFrom !== '' || $dateTo !== '')
                                <h3 class="mt-4 text-base font-semibold text-slate-900">
                                    No activity found
                                </h3>

                                <p class="mx-auto mt-1 max-w-md text-sm text-slate-500">
                                    No activity matches your current filters.
                                </p>

                                <button
                                    type="button"
                                    wire:click="clearFilters"
                                    class="mt-5 inline-flex items-center rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">
                                    Clear Filters
                                </button>
                            @else
                                <h3 class="mt-4 text-base font-semibold text-slate-900">
                                    No activity yet
                                </h3>

                                <p class="mx-auto mt-1 max-w-md text-sm text-slate-500">
                                    Actions taken across the system will show up here.
                                </p>
                            @endif

                        </div>

                    </div>

                @else

                    <div class="min-h-0 flex-1 overflow-auto">

                        <table class="min-w-full">

                            <thead class="sticky top-0 z-30 border-b border-slate-200 bg-slate-50">
                                <tr>
                                    <th class="w-20 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">ID</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Admin</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Action</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Model</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Date</th>
                                    <th class="w-16 px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-slate-500">Actions</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100 bg-white">

                                @foreach ($logs as $log)

                                    <tr
                                        wire:key="log-{{ $log->log_id }}"
                                        class="transition hover:bg-slate-50">

                                        <td class="whitespace-nowrap px-4 py-3 text-sm font-medium text-slate-500">
                                            {{ $log->log_id }}
                                        </td>

                                        <td class="px-4 py-3">
                                            <p class="max-w-[180px] truncate text-sm font-semibold text-slate-900">
                                                {{ $log->user->full_name ?? 'System' }}
                                            </p>
                                        </td>

                                        <td class="whitespace-nowrap px-4 py-3">
                                            <span @class([
                                                'inline-flex rounded-full px-2.5 py-1 text-xs font-semibold capitalize',
                                                'bg-green-100 text-green-700' => $log->action === 'created',
                                                'bg-blue-100 text-blue-700' => $log->action === 'updated',
                                                'bg-red-100 text-red-700' => $log->action === 'deleted',
                                            ])>
                                                {{ $log->action }}
                                            </span>
                                        </td>

                                        <td class="px-4 py-3">
                                            <p class="max-w-[200px] truncate text-sm text-slate-700">
                                                {{ $log->model_type }} {{ $log->model_id }}
                                            </p>
                                        </td>

                                        <td class="whitespace-nowrap px-4 py-3 text-sm text-slate-500">
                                            {{ optional($log->created_at)->format('M d, Y g:i A') ?? '—' }}
                                        </td>

                                        <td class="px-4 py-3 text-center">

                                            <button
                                                type="button"
                                                wire:click="viewDetails({{ $log->log_id }})"
                                                class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-slate-500 transition hover:bg-slate-100 hover:text-slate-800"
                                                aria-label="View log details">

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
                                                        d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                </svg>

                                            </button>

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
                                    {{ $logs->firstItem() ?? 0 }}
                                </span>

                                -

                                <span class="font-medium text-slate-900">
                                    {{ $logs->lastItem() ?? 0 }}
                                </span>

                                of

                                <span class="font-medium text-slate-900">
                                    {{ $logs->total() }}
                                </span>

                            </div>


                            {{-- ====================================================
                                PAGINATION
                            ===================================================== --}}

                            <div class="flex items-center gap-2">


                                {{-- Previous --}}

                                @if ($logs->onFirstPage())

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

                                @for ($page = 1; $page <= max(1, $logs->lastPage()); $page++)

                                    @if ($page === $logs->currentPage())

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

                                @if ($logs->hasMorePages())

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
        LOADING
    ================================================================= --}}

    <div
        wire:loading.flex
        wire:target="modelFilter, actionFilter, dateFrom, dateTo, clearFilters, viewDetails"
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