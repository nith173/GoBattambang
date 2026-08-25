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
            window.location.href = '{{ route('admin.destinations') }}';
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


    {{-- ================================================================ --}}
    {{-- PAGE --}}
    {{-- ================================================================ --}}

    <div class="mx-auto max-w-7xl px-6 py-10">

        {{-- ============================================================ --}}
        {{-- HEADER --}}
        {{-- ============================================================ --}}

        <div class="mb-7">

            <a
                href="{{ route('admin.destinations') }}"
                class="inline-flex items-center gap-2 text-sm font-medium text-slate-600 transition hover:text-blue-600">
                <svg
                    class="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M15 19l-7-7 7-7" />
                </svg>

                Back to Destinations
            </a>

            <div class="mt-5">
                <h1 class="text-3xl font-bold tracking-tight text-slate-900">
                    {{ $isEditing ? 'Edit Destination' : 'Add Destination' }}
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    {{ $isEditing
                        ? 'Update the information for this tourist destination.'
                        : 'Create a new tourist destination.'
                    }}
                </p>
            </div>

        </div>


        {{-- ============================================================ --}}
        {{-- VALIDATION ERROR --}}
        {{-- ============================================================ --}}

        @if ($errors->any())
        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4">
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
        @endif


        {{-- ============================================================ --}}
        {{-- FORM --}}
        {{-- ============================================================ --}}

        <form
            wire:submit="save"
            class="space-y-6">

            {{-- ======================================================== --}}
            {{-- DESTINATION INFORMATION + PHOTOS --}}
            {{-- ======================================================== --}}

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-5">

                {{-- ==================================================== --}}
                {{-- DESTINATION INFORMATION --}}
                {{-- ==================================================== --}}

                <div class="rounded-2xl border border-slate-200 bg-white shadow-sm lg:col-span-3">

                    <div class="border-b border-slate-200 px-6 py-5">
                        <h2 class="text-lg font-semibold text-slate-900">
                            Destination Information
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            Enter the main information about this destination.
                        </p>
                    </div>

                    <div class="space-y-5 p-6">

                        {{-- Title --}}
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">
                                Title
                                <span class="text-red-500">*</span>
                            </label>

                            <input
                                type="text"
                                wire:model="title"
                                placeholder="e.g. Phnom Sampov"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                            @error('title')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>


                        {{-- Category --}}
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">
                                Category
                                <span class="text-red-500">*</span>
                            </label>

                            <select
                                wire:model="category_id"
                                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                <option value="">
                                    Select a category
                                </option>

                                @foreach ($categories as $category)
                                <option value="{{ $category->category_id }}">
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>

                            @error('category_id')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>


                        {{-- Description --}}
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">
                                Description
                                <span class="text-red-500">*</span>
                            </label>

                            <textarea
                                wire:model="description"
                                rows="5"
                                placeholder="Describe this destination..."
                                class="w-full resize-none rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"></textarea>

                            @error('description')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>


                        {{-- Things To Do --}}
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">
                                Things to Do
                            </label>

                            <textarea
                                wire:model="things_to_do"
                                rows="4"
                                placeholder="Activities visitors can enjoy..."
                                class="w-full resize-none rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"></textarea>

                            @error('things_to_do')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>


                        {{-- Things To Prepare --}}
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">
                                Things to Prepare
                            </label>

                            <textarea
                                wire:model="things_to_prepare"
                                rows="4"
                                placeholder="What should visitors prepare?"
                                class="w-full resize-none rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"></textarea>

                            @error('things_to_prepare')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                    </div>
                </div>


                {{-- ==================================================== --}}
                {{-- DESTINATION PHOTOS --}}
                {{-- ==================================================== --}}

                <div class="rounded-2xl border border-slate-200 bg-white shadow-sm lg:col-span-2">

                    <div class="border-b border-slate-200 px-6 py-5">

                        <div class="flex items-center justify-between gap-3">

                            <div>
                                <h2 class="text-lg font-semibold text-slate-900">
                                    Destination Photos
                                </h2>

                                <p class="mt-1 text-sm text-slate-500">
                                    Upload up to 10 photos.
                                </p>
                            </div>

                            <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                                {{ count($existingPhotos) + count($photos) }}/10
                            </span>

                        </div>
                    </div>


                    <div class="p-6">

                        {{-- ================================================= --}}
                        {{-- EXISTING PHOTOS --}}
                        {{-- ================================================= --}}

                        @if ($isEditing && !empty($existingPhotos))

                        <div class="mb-6">

                            <div class="mb-3 flex items-center justify-between">

                                <h3 class="text-sm font-semibold text-slate-700">
                                    Uploaded Photos
                                </h3>

                                <span class="text-xs text-slate-500">
                                    {{ count($existingPhotos) }} saved
                                </span>

                            </div>


                            <div class="grid grid-cols-2 gap-3">

                                @foreach ($existingPhotos as $image)

                                <div
                                    wire:key="existing-photo-{{ $image['image_id'] }}"
                                    class="group relative overflow-hidden rounded-xl border border-slate-200 bg-slate-50">

                                    <img
                                        src="{{ $image['image_url'] }}"
                                        alt="Destination photo"
                                        class="h-32 w-full object-cover">


                                    {{-- Primary --}}
                                    @if ($image['is_primary'])

                                    <span class="absolute left-2 top-2 rounded-full bg-blue-600 px-2.5 py-1 text-[11px] font-semibold text-white shadow-sm">
                                        Primary
                                    </span>

                                    @else

                                    <button
                                        type="button"
                                        wire:click="setPrimaryPhoto({{ $image['image_id'] }})"
                                        class="absolute left-2 top-2 rounded-full bg-white px-2.5 py-1 text-[11px] font-semibold text-slate-700 shadow-sm transition hover:bg-blue-50 hover:text-blue-700">
                                        Set Primary
                                    </button>

                                    @endif


                                    {{-- Delete --}}
                                    <button
                                        type="button"
                                        wire:click="deleteExistingPhoto({{ $image['image_id'] }})"
                                        class="absolute right-2 top-2 flex h-7 w-7 items-center justify-center rounded-full bg-white text-lg leading-none text-red-600 shadow-sm transition hover:bg-red-50"
                                        title="Delete photo">
                                        ×
                                    </button>

                                </div>

                                @endforeach

                            </div>
                        </div>

                        @elseif ($isEditing)

                        <div class="mb-6 rounded-xl bg-slate-50 px-4 py-5 text-center">

                            <svg
                                class="mx-auto h-8 w-8 text-slate-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.7"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 16M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>

                            <p class="mt-2 text-sm font-medium text-slate-600">
                                No photos uploaded yet.
                            </p>

                        </div>

                        @endif


                        {{-- ================================================= --}}
                        {{-- UPLOAD AREA --}}
                        {{-- ================================================= --}}

                        <div
                            x-data="{
                                uploading: false,
                                progress: 0
                            }"
                            x-on:livewire-upload-start="uploading = true; progress = 0"
                            x-on:livewire-upload-finish="uploading = false; progress = 100"
                            x-on:livewire-upload-cancel="uploading = false"
                            x-on:livewire-upload-error="uploading = false; $wire.showUploadError()"
                            x-on:livewire-upload-progress="progress = $event.detail.progress">

                            <label
                                class="flex cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-blue-300 bg-blue-50/40 px-6 py-8 text-center transition hover:border-blue-500 hover:bg-blue-50">

                                <div class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-blue-100">

                                    <svg
                                        class="h-6 w-6 text-blue-600"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 16V4m0 0l-4 4m4-4l4 4M5 16v2a2 2 0 002 2h10a2 2 0 002-2v-2" />
                                    </svg>

                                </div>

                                <p class="text-sm font-semibold text-slate-700">
                                    Click to upload photos
                                </p>

                                <p class="mt-1 text-xs text-slate-500">
                                    JPG, PNG or WEBP
                                </p>

                                <p class="mt-1 text-xs text-slate-500">
                                    Maximum 5MB per image · Up to 10 photos
                                </p>

                                <input
                                    type="file"
                                    wire:model="photos"
                                    multiple
                                    accept=".jpg,.jpeg,.png,.webp"
                                    class="hidden">
                            </label>


                            {{-- Upload Progress --}}
                            <div
                                x-show="uploading"
                                x-cloak
                                class="mt-4">

                                <div class="mb-1 flex items-center justify-between">

                                    <span class="text-xs font-medium text-blue-700">
                                        Uploading...
                                    </span>

                                    <span
                                        class="text-xs font-medium text-blue-700"
                                        x-text="progress + '%'"></span>

                                </div>

                                <div class="h-2 overflow-hidden rounded-full bg-blue-100">

                                    <div
                                        class="h-full rounded-full bg-blue-600 transition-all duration-150"
                                        x-bind:style="'width: ' + progress + '%'"></div>

                                </div>

                            </div>

                        </div>


                        {{-- Upload Validation Errors --}}
                        @error('photos')
                        <p class="mt-2 text-sm font-medium text-red-600">
                            {{ $message }}
                        </p>
                        @enderror

                        @error('photos.*')
                        <p class="mt-2 text-sm font-medium text-red-600">
                            {{ $message }}
                        </p>
                        @enderror


                        {{-- ================================================= --}}
                        {{-- NEW PHOTOS --}}
                        {{-- ================================================= --}}

                        @if (!empty($photos))

                        <div class="mt-6">

                            <div class="mb-3 flex items-center justify-between">

                                <h3 class="text-sm font-semibold text-slate-700">
                                    New Photos
                                </h3>

                                <span class="text-xs text-slate-500">
                                    {{ count($photos) }} selected
                                </span>

                            </div>


                            <div class="grid grid-cols-2 gap-3">

                                @foreach ($photos as $index => $photo)

                                <div
                                    wire:key="new-photo-{{ $index }}"
                                    class="relative overflow-hidden rounded-xl border border-slate-200 bg-slate-50">

                                    <img
                                        src="{{ $photo->temporaryUrl() }}"
                                        alt="New destination photo"
                                        class="h-32 w-full object-cover">


                                    {{-- Primary --}}
                                    @if ($newPrimaryPhoto === $index)

                                    <span class="absolute left-2 top-2 rounded-full bg-blue-600 px-2.5 py-1 text-[11px] font-semibold text-white shadow-sm">
                                        Primary
                                    </span>

                                    @else

                                    <button
                                        type="button"
                                        wire:click="setNewPrimaryPhoto({{ $index }})"
                                        class="absolute left-2 top-2 rounded-full bg-white px-2.5 py-1 text-[11px] font-semibold text-slate-700 shadow-sm transition hover:bg-blue-50 hover:text-blue-700">
                                        Set Primary
                                    </button>

                                    @endif


                                    {{-- Remove --}}
                                    <button
                                        type="button"
                                        wire:click="removePhoto({{ $index }})"
                                        class="absolute right-2 top-2 flex h-7 w-7 items-center justify-center rounded-full bg-white text-lg leading-none text-red-600 shadow-sm transition hover:bg-red-50"
                                        title="Remove photo">
                                        ×
                                    </button>

                                </div>

                                @endforeach

                            </div>

                        </div>

                        @endif

                    </div>
                </div>

            </div>


            {{-- ======================================================== --}}
            {{-- LOCATION & CONTACT --}}
            {{-- ======================================================== --}}

            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-200 px-6 py-5">

                    <h2 class="text-lg font-semibold text-slate-900">
                        Location & Contact
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Provide the destination location and contact information.
                    </p>

                </div>


                <div class="grid grid-cols-1 gap-5 p-6 md:grid-cols-3">

                    {{-- Address --}}
                    <div>

                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Address
                            <span class="text-red-500">*</span>
                        </label>

                        <textarea
                            wire:model="address"
                            rows="3"
                            placeholder="Destination address"
                            class="w-full resize-none rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"></textarea>

                        @error('address')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                        @enderror

                    </div>


                    {{-- Latitude --}}
                    <div>

                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Latitude
                        </label>

                        <input
                            type="text"
                            wire:model="latitude"
                            placeholder="e.g. 13.0957"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                        @error('latitude')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                        @enderror

                    </div>


                    {{-- Longitude --}}
                    <div>

                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Longitude
                        </label>

                        <input
                            type="text"
                            wire:model="longitude"
                            placeholder="e.g. 103.2022"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                        @error('longitude')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                        @enderror

                    </div>


                    {{-- Map Link --}}
                    <div class="md:col-span-2">

                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Google Maps Link
                        </label>

                        <input
                            type="url"
                            wire:model="map_link"
                            placeholder="https://maps.google.com/..."
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                        @error('map_link')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                        @enderror

                    </div>


                    {{-- Contact Phone --}}
                    <div>

                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Contact Phone
                        </label>

                        <input
                            type="text"
                            wire:model="contact_phone"
                            placeholder="+855 12 345 678"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                        @error('contact_phone')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                        @enderror

                    </div>

                </div>
            </div>


            {{-- ======================================================== --}}
            {{-- PRICING & OPENING HOURS --}}
            {{-- ======================================================== --}}

            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-200 px-6 py-5">

                    <h2 class="text-lg font-semibold text-slate-900">
                        Pricing & Opening Hours
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Set ticket pricing, opening hours, and destination status.
                    </p>

                </div>


                <div class="grid grid-cols-1 gap-5 p-6 md:grid-cols-3">

                    {{-- Ticket Price --}}
                    <div>

                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Ticket Price
                        </label>

                        <div class="flex items-center gap-3">

                            <div class="flex-1">

                                <input
                                    type="number"
                                    step="0.01"
                                    min="0"
                                    wire:model="ticket_price"
                                    @disabled($isFree)
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 disabled:bg-slate-100 disabled:text-slate-400">

                            </div>

                            <span class="text-sm font-medium text-slate-500">
                                USD
                            </span>

                        </div>


                        <label class="mt-3 flex cursor-pointer items-center gap-2">

                            <input
                                type="checkbox"
                                wire:model.live="isFree"
                                class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">

                            <span class="text-sm text-slate-600">
                                Free
                            </span>

                        </label>


                        @error('ticket_price')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                        @enderror

                    </div>


                    {{-- Open Time --}}
                    <div>

                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Open Time
                        </label>

                        <input
                            type="time"
                            wire:model="open_time"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                        @error('open_time')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                        @enderror

                    </div>


                    {{-- Close Time --}}
                    <div>

                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Close Time
                        </label>

                        <input
                            type="time"
                            wire:model="close_time"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                        @error('close_time')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                        @enderror

                    </div>


                    {{-- Status --}}
                    <div>

                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Status
                            <span class="text-red-500">*</span>
                        </label>

                        <select
                            wire:model="status"
                            class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                            <option value="active">
                                Active
                            </option>

                            <option value="hidden">
                                Inactive
                            </option>

                        </select>

                        @error('status')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                        @enderror

                    </div>

                </div>
            </div>


            {{-- ======================================================== --}}
            {{-- FORM ACTIONS --}}
            {{-- ======================================================== --}}

            <div class="flex items-center justify-end gap-3 border-t border-slate-200 pt-6">

                <a
                    href="{{ route('admin.destinations') }}"
                    class="rounded-xl border border-slate-300 bg-white px-6 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                    Cancel
                </a>

                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    class="rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-60">

                    <span
                        wire:loading.remove
                        wire:target="save">
                        {{ $isEditing ? 'Update Destination' : 'Create Destination' }}
                    </span>

                    <span
                        wire:loading
                        wire:target="save">
                        Saving...
                    </span>

                </button>

            </div>

        </form>

    </div>

</div>