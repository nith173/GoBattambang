<div class="min-h-[calc(100vh-5rem)] bg-slate-100">

    {{-- ================================================================ --}}
    {{-- SUCCESS / ERROR POPUP --}}
    {{-- ================================================================ --}}

    @if ($showAlertPopup)
    <div
        x-data="{ show: true }"
        x-show="show"
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

                <button
                    type="button"
                    x-on:click="show = false; $wire.closeAlertPopup()"
                    class="mt-6 w-full rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700">
                    OK
                </button>

            </div>
        </div>
    </div>
    @endif


    {{-- ================================================================
        PAGE HEADER
    ================================================================= --}}

    <div class="px-8 pt-8">

        <a
            href="{{ route('admin.dashboard') }}"
            class="inline-flex items-center gap-2 text-sm font-medium text-slate-600 transition hover:text-blue-600">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Dashboard
        </a>

        <div class="mt-4">
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                Change Password
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                Choose a strong, unique password for your account.
            </p>
        </div>

    </div>


    {{-- ================================================================
        FORM
    ================================================================= --}}

    <div class="px-8 pb-8 pt-6">

        <form wire:submit="save" class="max-w-3xl">

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-200 px-6 py-5">
                    <h2 class="text-base font-bold uppercase tracking-wide text-slate-900">
                        Password
                    </h2>
                    <p class="mt-1 text-sm text-slate-500">
                        At least 8 characters, with uppercase, lowercase, a number, and a symbol.
                    </p>
                </div>

                <div class="space-y-6 px-6 py-6">

                    <div>
                        <label for="current_password" class="mb-2 block text-sm font-semibold text-slate-700">
                            Current Password <span class="text-red-500">*</span>
                        </label>
                        <input id="current_password" type="password" wire:model="current_password"
                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 @error('current_password') border-red-300 @enderror">
                        @error('current_password')
                        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="new_password" class="mb-2 block text-sm font-semibold text-slate-700">
                            New Password <span class="text-red-500">*</span>
                        </label>
                        <input id="new_password" type="password" wire:model="new_password"
                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 @error('new_password') border-red-300 @enderror">
                        @error('new_password')
                        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="new_password_confirmation" class="mb-2 block text-sm font-semibold text-slate-700">
                            Confirm New Password <span class="text-red-500">*</span>
                        </label>
                        <input id="new_password_confirmation" type="password" wire:model="new_password_confirmation"
                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                    </div>

                </div>

                <div class="flex flex-col-reverse gap-3 border-t border-slate-200 bg-slate-50 px-6 py-4 sm:flex-row sm:justify-end">

                    <a href="{{ route('admin.dashboard') }}"
                        class="rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-center text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                        Cancel
                    </a>

                    <button type="submit" wire:loading.attr="disabled"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-60">
                        <span wire:loading.remove wire:target="save">Update Password</span>
                        <span wire:loading wire:target="save">Saving...</span>
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>