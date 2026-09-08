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
                    <svg class="h-7 w-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86l-7.82 13a2 2 0 001.71 3h15.64a2 2 0 001.71-3l-7.82-13a2 2 0 00-3.42 0z" />
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
                {{ $isEditing ? 'Edit Your Review' : 'Leave a Review' }}
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                Share your experience at {{ $destination->title }}.
            </p>
        </div>

        <form wire:submit.prevent="submit" class="space-y-6">

            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-200 px-6 py-5">
                    <h2 class="text-lg font-semibold text-slate-900">
                        {{ $destination->title }}
                    </h2>
                    <p class="mt-1 text-sm text-slate-500">
                        {{ $destination->address }}
                    </p>
                </div>

                <div class="space-y-5 p-6">

                    {{-- Star Rating --}}
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Rating
                            <span class="text-red-500">*</span>
                        </label>

                        <div class="flex items-center gap-1">
                            @for ($i = 1; $i <= 5; $i++)
                            <button
                                type="button"
                                wire:click="setRating({{ $i }})"
                                class="text-3xl leading-none transition {{ $i <= $rating ? 'text-amber-400' : 'text-slate-300 hover:text-amber-300' }}">
                                ★
                            </button>
                            @endfor

                            @if ($rating > 0)
                            <span class="ml-2 text-sm text-slate-500">
                                {{ $rating }} / 5
                            </span>
                            @endif
                        </div>

                        @error('rating')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Comment --}}
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Comment
                            <span class="text-slate-400">(optional)</span>
                        </label>

                        <textarea
                            wire:model="comment"
                            rows="5"
                            maxlength="1000"
                            placeholder="Tell others about your experience..."
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"></textarea>

                        <p class="mt-1 text-xs text-slate-400">
                            {{ strlen($comment) }} / 1000 characters
                        </p>

                        @error('comment')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="flex items-center justify-end gap-3">
                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    class="rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-60">
                    <span wire:loading.remove wire:target="submit">
                        {{ $isEditing ? 'Update Review' : 'Submit Review' }}
                    </span>
                    <span wire:loading wire:target="submit">
                        Saving...
                    </span>
                </button>
            </div>

        </form>

    </div>

</div>