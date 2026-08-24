<div>

    {{-- Confirm Popup --}}
    @if ($showConfirmPopup)
        <div class="fixed inset-0 z-[10000] flex items-center justify-center bg-black/40 px-4">
            <div class="w-full max-w-md overflow-hidden rounded-2xl bg-white shadow-2xl">

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
                            class="rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                        >
                            Cancel
                        </button>

                        <button
                            type="button"
                            wire:click="confirmPopupAction"
                            wire:loading.attr="disabled"
                            class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-60"
                        >
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


    {{-- Success / Error Popup --}}
    @if ($showAlertPopup)
        <div class="fixed inset-0 z-[10000] flex items-center justify-center bg-black/40 px-4">
            <div class="w-full max-w-md overflow-hidden rounded-2xl bg-white shadow-2xl">

                <div class="px-6 pb-6 pt-7 text-center">

                    @if ($alertType === 'success')
                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-green-100">
                            <svg
                                class="h-7 w-7 text-green-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5 13l4 4L19 7"
                                />
                            </svg>
                        </div>
                    @else
                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-red-100">
                            <svg
                                class="h-7 w-7 text-red-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </div>
                    @endif

                    <h3 class="mt-4 text-lg font-bold text-slate-900">
                        {{ $alertTitle }}
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-slate-500">
                        {{ $alertMessage }}</p>

                    <button
                        type="button"
                        wire:click="closeAlertPopup"
                        class="mt-6 w-full rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700"
                    >
                        OK
                    </button>

                </div>

            </div>
        </div>
    @endif


    {{-- Page Header --}}
    <div class="border-b border-slate-200 bg-white px-6 py-6">
    <div class="mx-auto flex max-w-7xl flex-col gap-4 md:flex-row md:items-center md:justify-between">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">
            {{ $categoryId ? 'Edit Category' : 'Add Category' }}
        </h1>

        <p class="mt-1 text-sm text-slate-500">
            {{ $categoryId
                ? 'Update the category information below.'
                : 'Add a new tourism category.'
            }}
        </p>
    </div>

    <a
        href="{{ route('admin.categories') }}"
        wire:navigate
        class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
    >
        Back to Categories
    </a>

</div>
</div>


    {{-- Form Content --}}
    <div class="bg-slate-50 p-6">

        <div class="mx-auto max-w-3xl">

            <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">

                <form wire:submit="save" class="space-y-6">

                    {{-- Category Name --}}
                    <div>
                        <label
                            for="name"
                            class="block text-sm font-semibold text-slate-700"
                        >
                            Category Name
                            <span class="text-red-500">*</span>
                        </label>

                        <input
                            id="name"
                            type="text"
                            wire:model.blur="name"
                            placeholder="Enter category name"
                            class="mt-2 w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                        >

                        @error('name')
                            <p class="mt-1.5 text-sm text-red-500">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>


                    {{-- Description --}}
                    <div>
                        <label
                            for="description"
                            class="block text-sm font-semibold text-slate-700"
                        >
                            Description
                        </label>

                        <textarea
                            id="description"
                            rows="5"
                            wire:model.blur="description"
                            placeholder="Enter category description"
                            class="mt-2 w-full resize-none rounded-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                        ></textarea>

                        @error('description')
                            <p class="mt-1.5 text-sm text-red-500">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>


                    {{-- Buttons --}}
                    <div class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-6 sm:flex-row sm:justify-end">

                        <a
                            href="{{ route('admin.categories') }}"
                            wire:navigate
                            class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                        >
                            Cancel
                        </a>

                        <button
                            type="submit"
                            wire:loading.attr="disabled"
                            wire:target="save"
                            class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-60"
                        >
                            <span wire:loading.remove wire:target="save">
                                {{ $categoryId ? 'Update Category' : 'Create Category' }}
                            </span>

                            <span wire:loading wire:target="save">
                                Processing...
                            </span>
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>