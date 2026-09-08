<div class="min-h-[calc(100vh-5rem)] bg-slate-100">

    {{-- ================================================================ --}}
    {{-- SUCCESS / ERROR POPUP --}}
    {{-- ================================================================ --}}

    @if ($showAlertPopup)
    <div
        x-data="{ show: true }"
        x-show="show"
        x-init="@if ($alertType === 'success') setTimeout(() => { window.location.href = '{{ route('admin.dashboard') }}' }, 1500) @endif"
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

                @if ($alertType === 'success')
                <p class="mt-4 text-xs text-slate-400">
                    Redirecting you to the dashboard...
                </p>
                @else
                <button
                    type="button"
                    x-on:click="show = false; $wire.closeAlertPopup()"
                    class="mt-6 w-full rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700">
                    OK
                </button>
                @endif

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
                My Profile
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                Update your personal information and photo.
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
                        Profile Information
                    </h2>
                    <p class="mt-1 text-sm text-slate-500">
                        This information is only visible to you.
                    </p>
                </div>

                <div class="space-y-6 px-6 py-6">

                    {{-- Photo --}}
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Profile Photo
                        </label>

                        <div class="flex items-center gap-4">

                            <div class="flex h-16 w-16 shrink-0 items-center justify-center overflow-hidden rounded-full bg-slate-100">
                                @if ($newPhoto)
                                    <img src="{{ $newPhoto->temporaryUrl() }}" class="h-full w-full object-cover">
                                @elseif ($existingPhoto)
                                    <img src="{{ $existingPhoto }}" class="h-full w-full object-cover">
                                @else
                                    <span class="text-lg font-bold text-slate-400">
                                        {{ strtoupper(substr($first_name, 0, 1)) }}
                                    </span>
                                @endif
                            </div>

                            <div class="flex items-center gap-3">
                                <label class="cursor-pointer rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                                    Choose Photo
                                    <input type="file" wire:model="newPhoto" class="hidden" accept="image/*">
                                </label>

                                @if ($existingPhoto || $newPhoto)
                                <button type="button" wire:click="removeExistingPhoto" class="text-sm font-medium text-red-600 hover:underline">
                                    Remove
                                </button>
                                @endif
                            </div>

                        </div>

                        @error('newPhoto')
                        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>


                    {{-- Name --}}
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">

                        <div>
                            <label for="first_name" class="mb-2 block text-sm font-semibold text-slate-700">
                                First Name <span class="text-red-500">*</span>
                            </label>
                            <input id="first_name" type="text" wire:model.blur="first_name"
                                class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 @error('first_name') border-red-300 @enderror">
                            @error('first_name')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="last_name" class="mb-2 block text-sm font-semibold text-slate-700">
                                Last Name <span class="text-red-500">*</span>
                            </label>
                            <input id="last_name" type="text" wire:model.blur="last_name"
                                class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 @error('last_name') border-red-300 @enderror">
                            @error('last_name')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>


                    {{-- Email --}}
                    <div>
                        <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input id="email" type="email" wire:model.blur="email"
                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 @error('email') border-red-300 @enderror">
                        @error('email')
                        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>


                    {{-- Phone --}}
                    <div>
                        <label for="phone_number" class="mb-2 block text-sm font-semibold text-slate-700">
                            Phone Number
                        </label>
                        <input id="phone_number" type="text" wire:model.blur="phone_number"
                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 @error('phone_number') border-red-300 @enderror">
                        @error('phone_number')
                        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <div class="flex flex-col-reverse gap-3 border-t border-slate-200 bg-slate-50 px-6 py-4 sm:flex-row sm:justify-end">

                    <a href="{{ route('admin.dashboard') }}"
                        class="rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-center text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                        Cancel
                    </a>

                    <button type="submit" wire:loading.attr="disabled"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-60">
                        <span wire:loading.remove wire:target="save">Save Changes</span>
                        <span wire:loading wire:target="save">Saving...</span>
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>