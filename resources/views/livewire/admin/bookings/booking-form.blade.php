<div class="min-h-screen bg-slate-100">

    {{-- ================================================================ --}}
    {{-- CONFIRMATION POPUP --}}
    {{-- ================================================================ --}}

    @if ($showConfirmPopup)
    <div
        class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/50 px-4"
        wire:click.self="closeConfirmPopup">
        <div class="w-full max-w-md overflow-hidden rounded-2xl bg-white shadow-2xl">

            <div class="flex justify-center pt-7">
                <div class="flex h-14 w-14 items-center justify-center rounded-full bg-blue-100">
                    <svg
                        class="h-7 w-7 text-blue-600"
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
                        class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-60">
                        <span wire:loading.remove wire:target="confirmPopupAction">
                            {{ $confirmButtonText }}
                        </span>
                        <span wire:loading wire:target="confirmPopupAction">
                            Processing...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif


    {{-- ================================================================ --}}
    {{-- SUCCESS / ERROR POPUP --}}
    {{-- ================================================================ --}}

    @if ($showAlertPopup)
    <div
        x-data="{
            show: true,
            closePopup() {
                this.show = false;
                $wire.closeAlertPopup();

                @if ($alertType === 'success')
                    window.location.href = '{{ $telegramLink }}';
                @endif
            }
        }"
        x-show="show"
        x-init="
            @if ($alertType === 'success')
                setTimeout(() => closePopup(), 1500)
            @endif
        "
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
                    <svg class="h-7 w-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                @else
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-red-100">
                    <svg class="h-7 w-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
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


    {{-- ================================================================ --}}
    {{-- PAGE --}}
    {{-- ================================================================ --}}

    <div class="mx-auto max-w-2xl px-6 py-10">

        <div class="mb-7">
            <h1 class="text-3xl font-bold tracking-tight text-slate-900">
                Book This Destination
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                Fill in your booking details and we'll send it directly to the vendor on Telegram.
            </p>
        </div>

        {{-- Destination Summary --}}
        <div class="mb-6 flex items-center gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-xl bg-slate-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                </svg>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-slate-900">
                    {{ $destination->title }}
                </h2>
                <p class="text-sm text-slate-500">
                    {{ $destination->address }}
                </p>
            </div>
        </div>

        @if (!$vendorAvailable)
        <div class="mb-6 rounded-2xl border border-amber-200 bg-amber-50 p-5 text-sm text-amber-800">
            This destination hasn't set up Telegram booking yet. Please contact the destination directly using the phone number on its page.
        </div>
        @endif

        <form wire:submit.prevent="submit" class="space-y-6">

            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-200 px-6 py-5">
                    <h2 class="text-lg font-semibold text-slate-900">
                        Booking Details
                    </h2>
                </div>

                <div class="space-y-5 p-6">

                    {{-- Booking Type --}}
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Booking Type
                            <span class="text-red-500">*</span>
                        </label>

                        <select
                            wire:model="booking_type"
                            class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            <option value="ticket">Ticket</option>
                            <option value="accommodation">Accommodation</option>
                        </select>

                        @error('booking_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Guest Count --}}
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Number of Guests
                            <span class="text-red-500">*</span>
                        </label>

                        <input
                            type="number"
                            min="1"
                            wire:model="guest_count"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                        @error('guest_count')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Visit Date --}}
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Visit Date
                            <span class="text-red-500">*</span>
                        </label>

                        <input
                            type="date"
                            wire:model="visit_date"
                            min="{{ now()->format('Y-m-d') }}"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                        @error('visit_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="flex items-center justify-end gap-3">
                <button
                    type="submit"
                    @disabled(!$vendorAvailable)
                    wire:loading.attr="disabled"
                    class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-60">

                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M21.5 2.5L2.5 10.5l6 2.5 2.5 7 3-4.5 5 3.5z" />
                    </svg>

                    <span wire:loading.remove wire:target="submit">
                        Submit Booking
                    </span>
                    <span wire:loading wire:target="submit">
                        Please wait...
                    </span>
                </button>
            </div>

        </form>

    </div>

</div>