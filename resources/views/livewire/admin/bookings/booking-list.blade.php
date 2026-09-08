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
        SUCCESS / ERROR POPUP (component-driven)
    ================================================================= --}}

    @if ($showAlertPopup)
        <div
            x-data="{ show: true, closePopup() { this.show = false; $wire.closeAlertPopup(); } }"
            x-show="show"
            x-init="@if ($alertType === 'success') setTimeout(() => closePopup(), 1500) @endif"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="fixed inset-0 z-[10000] flex items-center justify-center bg-black/40 px-4">

            <div class="w-full max-w-md overflow-hidden rounded-2xl bg-white shadow-2xl">

                <div class="px-6 pb-6 pt-7 text-center">

                    @if ($alertType === 'success')
                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-green-100">
                            <svg
                                class="h-7 w-7 text-green-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    @else
                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-red-100">
                            <svg
                                class="h-7 w-7 text-red-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                    @endif

                    <h3 class="mt-4 text-lg font-bold text-slate-900">
                        {{ $alertTitle }}
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-slate-500">
                        {{ $alertMessage }}
                    </p>

                    @if ($alertType !== 'success')
                        <button
                            type="button"
                            x-on:click="closePopup()"
                            class="mt-6 w-full rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700">
                            OK
                        </button>
                    @endif

                </div>
            </div>
        </div>
    @endif


    {{-- ================================================================
        CANCEL CONFIRMATION POPUP
    ================================================================= --}}

    @if ($showConfirmPopup)
        <div
            class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/50 px-4"
            wire:click.self="closeConfirmPopup">

            <div class="w-full max-w-md overflow-hidden rounded-2xl bg-white shadow-2xl">

                <div class="flex justify-center pt-7">
                    <div class="flex h-14 w-14 items-center justify-center rounded-full bg-red-100">
                        <svg
                            class="h-7 w-7 text-red-600"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 9v2m0 4h.01M10.29 3.86l-7.82 13a2 2 0 001.71 3h15.64a2 2 0 001.71-3l-7.82-13a2 2 0 00-3.42 0z" />
                        </svg>
                    </div>
                </div>

                <div class="px-6 pb-6 pt-5 text-center">
                    <h3 class="text-lg font-bold text-slate-900">
                        {{ $confirmTitle }}
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-slate-500">
                        {{ $confirmMessage }}
                    </p>

                    <div class="mt-6 grid grid-cols-2 gap-3">
                        <button
                            type="button"
                            wire:click="closeConfirmPopup"
                            class="rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                            Cancel
                        </button>

                        <button
                            type="button"
                            wire:click="confirmPopupAction"
                            wire:loading.attr="disabled"
                            class="rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-red-700 disabled:cursor-not-allowed disabled:opacity-60">
                            <span
                                wire:loading.remove
                                wire:target="confirmPopupAction">
                                {{ $confirmButtonText }}
                            </span>
                            <span
                                wire:loading
                                wire:target="confirmPopupAction">
                                Processing...
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif


    {{-- ================================================================
        BOOKING DETAILS POPUP
    ================================================================= --}}

    @if ($showDetailsPopup && $detailsBooking)
        <div
            class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/50 px-4"
            wire:click.self="closeDetailsPopup">

            <div class="w-full max-w-lg overflow-hidden rounded-2xl bg-white shadow-2xl">

                <div class="flex items-center justify-between border-b border-slate-200 px-6 py-5">
                    <h3 class="text-lg font-bold text-slate-900">
                        Booking {{ $detailsBooking->booking_id }}
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
                            <p class="text-xs font-medium uppercase tracking-wide text-slate-400">User</p>
                            <p class="mt-1 text-sm font-medium text-slate-900">
                                {{ $detailsBooking->user->full_name ?? '—' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs font-medium uppercase tracking-wide text-slate-400">Destination</p>
                            <p class="mt-1 text-sm font-medium text-slate-900">
                                {{ $detailsBooking->destination->title ?? '—' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs font-medium uppercase tracking-wide text-slate-400">Booking Type</p>
                            <p class="mt-1 text-sm font-medium capitalize text-slate-900">
                                {{ $detailsBooking->booking_type ?? '—' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs font-medium uppercase tracking-wide text-slate-400">Guests</p>
                            <p class="mt-1 text-sm font-medium text-slate-900">
                                {{ $detailsBooking->guest_count ?? '—' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs font-medium uppercase tracking-wide text-slate-400">Visit Date</p>
                            <p class="mt-1 text-sm font-medium text-slate-900">
                                {{ optional($detailsBooking->visit_date)->format('M d, Y') ?? '—' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs font-medium uppercase tracking-wide text-slate-400">Status</p>
                            <p class="mt-1">
                                <span @class([
                                    'inline-flex rounded-full px-2.5 py-1 text-xs font-semibold capitalize',
                                    'bg-amber-50 text-amber-700' => $detailsBooking->status === 'pending',
                                    'bg-emerald-50 text-emerald-700' => $detailsBooking->status === 'confirmed',
                                    'bg-blue-50 text-blue-700' => $detailsBooking->status === 'completed',
                                    'bg-slate-100 text-slate-600' => $detailsBooking->status === 'cancelled',
                                ])>
                                    {{ $detailsBooking->status }}
                                </span>
                            </p>
                        </div>

                        <div class="col-span-2">
                            <p class="text-xs font-medium uppercase tracking-wide text-slate-400">Created At</p>
                            <p class="mt-1 text-sm font-medium text-slate-900">
                                {{ optional($detailsBooking->created_at)->format('M d, Y g:i A') ?? '—' }}
                            </p>
                        </div>
                    </div>

                    @if ($detailsBooking->telegram_message)
                        <div>
                            <p class="mb-2 text-xs font-medium uppercase tracking-wide text-slate-400">
                                Telegram Message
                            </p>
                            <div class="whitespace-pre-line rounded-xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-700">
                                {{ $detailsBooking->telegram_message }}
                            </div>
                        </div>
                    @endif

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
                            Bookings
                        </h1>

                        <p class="mt-1 text-sm text-slate-500">
                            Manage and review destination bookings made by users.
                        </p>

                    </div>

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
                                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                        </svg>
                    </div>

                    <div class="ml-5">
                        <p class="text-sm font-semibold text-slate-700">Total</p>
                        <p class="mt-1 text-2xl font-bold leading-none text-slate-900">{{ $totalBookings }}</p>
                        <p class="mt-2 text-sm text-slate-400">All bookings</p>
                    </div>

                </div>

                {{-- PENDING --}}
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
                                d="M12 7.5V12l3 2" />
                        </svg>
                    </div>

                    <div class="ml-5">
                        <p class="text-sm font-semibold text-slate-700">Pending</p>
                        <p class="mt-1 text-2xl font-bold leading-none text-slate-900">{{ $pendingBookings }}</p>
                        <p class="mt-2 text-sm text-slate-400">Awaiting confirmation</p>
                    </div>

                </div>

                {{-- CONFIRMED --}}
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
                        <p class="text-sm font-semibold text-slate-700">Confirmed</p>
                        <p class="mt-1 text-2xl font-bold leading-none text-slate-900">{{ $confirmedBookings }}</p>
                        <p class="mt-2 text-sm text-slate-400">Ready to go</p>
                    </div>

                </div>

                {{-- CANCELLED --}}
                <div class="flex min-h-[132px] items-center rounded-xl border border-slate-200 bg-white px-6 py-5 shadow-sm">

                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-slate-100">
                        <svg
                            class="h-6 w-6 text-slate-500"
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
                        <p class="text-sm font-semibold text-slate-700">Cancelled</p>
                        <p class="mt-1 text-2xl font-bold leading-none text-slate-900">{{ $cancelledBookings }}</p>
                        <p class="mt-2 text-sm text-slate-400">No longer active</p>
                    </div>

                </div>

            </div>


            {{-- ========================================================
                SEARCH & FILTERS
            ========================================================= --}}

            <div class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm">

                <div class="flex flex-col gap-3 lg:flex-row lg:flex-wrap lg:items-end">

                    {{-- SEARCH --}}
                    <div class="flex-1 lg:min-w-[220px]">
                        <label
                            for="booking-search"
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
                                id="booking-search"
                                type="text"
                                wire:model.live.debounce.300ms="search"
                                placeholder="Search by user or destination..."
                                class="w-full rounded-lg border border-slate-300 bg-white py-2.5 pl-9 pr-4 text-sm text-slate-900 placeholder-slate-400 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100" />
                        </div>
                    </div>

                    {{-- STATUS --}}
                    <div class="w-full lg:w-44">
                        <label
                            for="status-filter"
                            class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Status
                        </label>

                        <select
                            id="status-filter"
                            wire:model.live="statusFilter"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            <option value="all">All Status</option>
                            <option value="pending">Pending</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>

                    {{-- TYPE --}}
                    <div class="w-full lg:w-44">
                        <label
                            for="type-filter"
                            class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Type
                        </label>

                        <select
                            id="type-filter"
                            wire:model.live="typeFilter"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            <option value="all">All Types</option>
                            <option value="individual">Individual</option>
                            <option value="group">Group</option>
                        </select>
                    </div>

                    {{-- DATE FROM --}}
                    <div class="w-full lg:w-44">
                        <label
                            for="date-from"
                            class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Visit From
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
                            Visit To
                        </label>

                        <input
                            id="date-to"
                            type="date"
                            wire:model.live="dateTo"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100" />
                    </div>

                    {{-- CLEAR --}}
                    @if ($this->hasActiveFilters)
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
                                Bookings
                            </h2>

                            <p class="mt-0.5 text-sm text-slate-500">
                                All booking requests submitted through the site.
                            </p>
                        </div>

                        @if ($bookings->total() > 0)
                            <p class="text-sm text-slate-500">
                                Showing
                                <span class="font-semibold text-slate-700">{{ $bookings->firstItem() }}</span>
                                -
                                <span class="font-semibold text-slate-700">{{ $bookings->lastItem() }}</span>
                                of
                                <span class="font-semibold text-slate-700">{{ $bookings->total() }}</span>
                            </p>
                        @endif

                    </div>

                </div>


                {{-- EMPTY STATE --}}
                @if ($bookings->isEmpty())

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
                                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                </svg>
                            </div>

                            @if ($this->hasActiveFilters)
                                <h3 class="mt-4 text-base font-semibold text-slate-900">
                                    No bookings found
                                </h3>

                                <p class="mx-auto mt-1 max-w-md text-sm text-slate-500">
                                    No bookings match your current search or filters.
                                </p>

                                <button
                                    type="button"
                                    wire:click="clearFilters"
                                    class="mt-5 inline-flex items-center rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">
                                    Clear Filters
                                </button>
                            @else
                                <h3 class="mt-4 text-base font-semibold text-slate-900">
                                    No bookings yet
                                </h3>

                                <p class="mx-auto mt-1 max-w-md text-sm text-slate-500">
                                    Bookings made by users will show up here.
                                </p>
                            @endif

                        </div>

                    </div>

                @else

                    <div class="min-h-0 flex-1 overflow-auto">

                        <table class="min-w-full">

                            <thead class="sticky top-0 z-30 border-b border-slate-200 bg-slate-50">
                                <tr>
                                    <th class="w-12 px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-slate-500">#</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">User</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Destination</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Type</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Guests</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Visit Date</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Status</th>
                                    <th class="w-20 px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-slate-500">Actions</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100 bg-white">

                                @foreach ($bookings as $booking)

                                    @php
                                        $rowNumber = ($bookings->currentPage() - 1) * $bookings->perPage() + $loop->iteration;
                                    @endphp

                                    <tr
                                        wire:key="booking-{{ $booking->booking_id }}"
                                        class="transition hover:bg-slate-50">

                                        <td class="px-4 py-3 text-center text-sm font-medium text-slate-500">
                                            {{ $rowNumber }}
                                        </td>

                                        <td class="px-4 py-3">
                                            <p class="max-w-[200px] truncate text-sm font-semibold text-slate-900">
                                                {{ $booking->user->full_name ?? '—' }}
                                            </p>
                                        </td>

                                        <td class="px-4 py-3">
                                            <p class="max-w-[200px] truncate text-sm text-slate-700">
                                                {{ $booking->destination->title ?? '—' }}
                                            </p>
                                        </td>

                                        <td class="px-4 py-3">
                                            <span class="inline-flex items-center rounded-md bg-blue-50 px-2.5 py-1 text-xs font-medium capitalize text-blue-700">
                                                {{ $booking->booking_type ?? '—' }}
                                            </span>
                                        </td>

                                        <td class="whitespace-nowrap px-4 py-3 text-sm text-slate-700">
                                            {{ $booking->guest_count ?? '—' }}
                                        </td>

                                        <td class="whitespace-nowrap px-4 py-3 text-sm text-slate-700">
                                            {{ optional($booking->visit_date)->format('M d, Y') ?? '—' }}
                                        </td>

                                        <td class="whitespace-nowrap px-4 py-3">
                                            @if ($booking->status === 'pending')
                                                <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                                    Pending
                                                </span>
                                            @elseif ($booking->status === 'confirmed')
                                                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                                    Confirmed
                                                </span>
                                            @elseif ($booking->status === 'completed')
                                                <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-700">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span>
                                                    Completed
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                                    Cancelled
                                                </span>
                                            @endif
                                        </td>

                                        <td class="px-4 py-3 text-center">

                                            <div
                                                x-data="{ open: false }"
                                                class="relative inline-block text-left">

                                                <button
                                                    type="button"
                                                    @click="open = !open"
                                                    @keydown.escape.window="open = false"
                                                    class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-slate-500 transition hover:bg-slate-100 hover:text-slate-800"
                                                    aria-label="Booking actions">

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

                                                <div
                                                    x-show="open"
                                                    x-cloak
                                                    @click.outside="open = false"
                                                    x-transition
                                                    class="absolute right-0 z-[100] mt-2 w-40 origin-top-right rounded-lg border border-slate-200 bg-white py-1 text-left shadow-lg">

                                                    <button
                                                        type="button"
                                                        wire:click="viewDetails({{ $booking->booking_id }})"
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
                                                                d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                        </svg>

                                                        View Details
                                                    </button>

                                                    @if ($booking->status !== 'cancelled')
                                                        <button
                                                            type="button"
                                                            wire:click="cancelBooking({{ $booking->booking_id }})"
                                                            @click="open = false"
                                                            class="flex w-full items-center gap-2 px-3 py-2 text-sm text-red-600 hover:bg-red-50">

                                                            <svg
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                fill="none"
                                                                viewBox="0 0 24 24"
                                                                stroke-width="1.7"
                                                                stroke="currentColor"
                                                                class="h-4 w-4 text-red-500">
                                                                <path
                                                                    stroke-linecap="round"
                                                                    stroke-linejoin="round"
                                                                    d="M6 18L18 6M6 6l12 12" />
                                                            </svg>

                                                            Cancel Booking
                                                        </button>
                                                    @endif

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
                                    {{ $bookings->firstItem() ?? 0 }}
                                </span>

                                -

                                <span class="font-medium text-slate-900">
                                    {{ $bookings->lastItem() ?? 0 }}
                                </span>

                                of

                                <span class="font-medium text-slate-900">
                                    {{ $bookings->total() }}
                                </span>

                            </div>


                            {{-- ====================================================
                                PAGINATION
                            ===================================================== --}}

                            <div class="flex items-center gap-2">


                                {{-- Previous --}}

                                @if ($bookings->onFirstPage())

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

                                @for ($page = 1; $page <= max(1, $bookings->lastPage()); $page++)

                                    @if ($page === $bookings->currentPage())

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

                                @if ($bookings->hasMorePages())

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
        wire:target="search, statusFilter, typeFilter, dateFrom, dateTo, clearFilters, viewDetails, cancelBooking, confirmPopupAction"
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