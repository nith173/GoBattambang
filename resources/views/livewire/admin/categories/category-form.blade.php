<div class="min-h-[calc(100vh-5rem)] bg-slate-100">

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
            window.location.href = '{{ route('admin.categories') }}';
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

                {{-- Success Icon --}}
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
                {{-- Error Icon --}}
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
        PAGE HEADER
    ================================================================= --}}

    <div class="px-8 pt-8">

        <a
            href="{{ route('admin.categories') }}"
            class="inline-flex items-center gap-2 text-sm font-medium text-slate-600 transition hover:text-blue-600">
            <svg
                class="h-4 w-4"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                stroke-width="1.8">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M15 19l-7-7 7-7" />
            </svg>

            Back to Categories
        </a>

        <div class="mt-4">

            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                {{ $isEditMode ? 'Edit Category' : 'Add Category' }}
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                {{ $isEditMode
                    ? 'Update category information.'
                    : 'Create a new destination category.'
                }}
            </p>

        </div>

    </div>


    {{-- ================================================================
        VALIDATION ERROR SUMMARY
    ================================================================= --}}

    @if ($errors->any())

    <div class="px-8 pt-6">

        <div class="max-w-3xl rounded-xl border border-red-200 bg-red-50 px-5 py-4">
            <div class="flex items-start gap-3">

                <svg
                    class="mt-0.5 h-5 w-5 shrink-0 text-red-600"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 9v4m0 4h.01M10.29 3.86l-7.82 13a2 2 0 001.71 3h15.64a2 2 0 001.71-3l-7.82-13a2 2 0 00-3.42 0z" />
                </svg>

                <div>
                    <p class="text-sm font-semibold text-red-700">
                        Please correct the following:
                    </p>

                    <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                        <li>
                            {{ $error }}
                        </li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </div>

    </div>

    @endif


    {{-- ================================================================
        FORM
    ================================================================= --}}

    <div class="px-8 pb-8 pt-6">

        <form
            wire:submit="save"
            class="max-w-3xl">

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                {{-- ====================================================
                    FORM HEADER
                ===================================================== --}}

                <div class="border-b border-slate-200 px-6 py-5">

                    <h2 class="text-base font-bold uppercase tracking-wide text-slate-900">
                        Category Information
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Enter the category details below.
                    </p>

                </div>


                {{-- ====================================================
                    FORM BODY
                ===================================================== --}}

                <div class="space-y-6 px-6 py-6">

                    {{-- Category Name --}}

                    <div>

                        <label
                            for="name"
                            class="mb-2 block text-sm font-semibold text-slate-700">
                            Category Name
                            <span class="text-red-500">*</span>
                        </label>

                        <input
                            id="name"
                            type="text"
                            wire:model.blur="name"
                            placeholder="e.g. Tourist Place"
                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 @error('name') border-red-300 @enderror">

                        @error('name')

                        <p class="mt-1.5 text-sm text-red-600">
                            {{ $message }}
                        </p>

                        @enderror

                    </div>


                    {{-- Description --}}

                    <div>

                        <label
                            for="description"
                            class="mb-2 block text-sm font-semibold text-slate-700">
                            Description
                        </label>

                        <textarea
                            id="description"
                            rows="5"
                            wire:model.blur="description"
                            placeholder="Describe this category..."
                            class="w-full resize-none rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm leading-6 text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 @error('description') border-red-300 @enderror"></textarea>

                        @error('description')

                        <p class="mt-1.5 text-sm text-red-600">
                            {{ $message }}
                        </p>

                        @enderror

                    </div>

                </div>


                {{-- ====================================================
                    FORM FOOTER
                ===================================================== --}}

                <div class="flex flex-col-reverse gap-3 border-t border-slate-200 bg-slate-50 px-6 py-4 sm:flex-row sm:justify-end">

                    <a
                        href="{{ route('admin.categories') }}"
                        class="rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-center text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                        Cancel
                    </a>

                    <button
                        type="submit"
                        wire:loading.attr="disabled"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-60">

                        <svg
                            wire:loading
                            wire:target="save"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.8"
                            stroke="currentColor"
                            class="h-4 w-4 animate-spin">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 3v3m0 12v3m9-9h-3M6 12H3m15.364-6.364-2.121 2.121M7.757 16.243l-2.121 2.121m12.728 0-2.121-2.121M7.757 7.757 5.636 5.636" />
                        </svg>

                        <span wire:loading.remove wire:target="save">
                            {{ $isEditMode ? 'Update Category' : 'Create Category' }}
                        </span>

                        <span wire:loading wire:target="save">
                            Saving...
                        </span>

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>