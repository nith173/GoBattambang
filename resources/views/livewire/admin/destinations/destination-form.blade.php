<div class="min-h-screen bg-slate-100">

    {{-- ================================================================ --}}
    {{-- CONFIRMATION POPUP --}}
    {{-- ================================================================ --}}

    @if ($showConfirmPopup)
    <div
        class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/50 px-4"
        wire:click.self="closeConfirmPopup">

        <div
            class="w-full max-w-md overflow-hidden rounded-2xl bg-white shadow-2xl">

            {{-- Icon --}}
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

            {{-- Content --}}
            <div class="px-6 pb-6 pt-5 text-center">

                <h3 class="text-lg font-bold text-slate-900">
                    {{ $confirmTitle }}
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-500">
                    {{ $confirmMessage }}
                </p>

                {{-- Buttons --}}
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


    {{{-- ================================================================ --}}
    {{-- SUCCESS / ERROR POPUP --}}
    {{-- ================================================================ --}}

    @if ($showAlertPopup)

    <div
        x-data="{
            show: true,
            closePopup() {
                this.show = false;
                $wire.closeAlertPopup();
            }
        }"
        x-show="show"
        x-init="
            @if ($alertType === 'success')
                setTimeout(() => closePopup(), 3000)
            @endif
        "
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="fixed inset-0 z-[10000] flex items-center justify-center bg-black/40 px-4">

        <div
            class="w-full max-w-md overflow-hidden rounded-2xl bg-white shadow-2xl">

            <div class="px-6 pb-6 pt-7 text-center">

                {{-- ==================================================== --}}
                {{-- SUCCESS ICON --}}
                {{-- ==================================================== --}}

                @if ($alertType === 'success')

                <div
                    class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-green-100">
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

                {{-- ================================================= --}}
                {{-- ERROR ICON --}}
                {{-- ================================================= --}}

                <div
                    class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-red-100">
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


                {{-- ==================================================== --}}
                {{-- TITLE --}}
                {{-- ==================================================== --}}

                <h3 class="mt-4 text-lg font-bold text-slate-900">
                    {{ $alertTitle }}
                </h3>


                {{-- ==================================================== --}}
                {{-- MESSAGE --}}
                {{-- ==================================================== --}}

                <p class="mt-2 text-sm leading-6 text-slate-500">
                    {{ $alertMessage }}
                </p>


                {{-- ==================================================== --}}
                {{-- OK BUTTON --}}
                {{-- ==================================================== --}}

                <button
                    type="button"
                    x-on:click="closePopup()"
                    class="mt-6 w-full rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700">
                    OK
                </button>

            </div>

        </div>

    </div>

    @endif


    {{-- ================================================================ --}}
    {{-- SESSION SUCCESS --}}
    {{-- ================================================================ --}}

    @if (session()->has('success'))
    <div
        x-data="{ show: true }"
        x-show="show"
        x-init="setTimeout(() => show = false, 3000)"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-x-4"
        x-transition:enter-end="opacity-100 translate-x-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 translate-x-0"
        x-transition:leave-end="opacity-0 translate-x-4"
        class="fixed right-6 top-6 z-[9999] flex items-center gap-3 rounded-xl bg-emerald-600 px-5 py-4 text-sm font-medium text-white shadow-lg">
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
                d="M9 12.75 11.25 15 15 9.75" />

            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>

        <span>{{ session('success') }}</span>
    </div>
    @endif


    {{-- ================================================================ --}}
    {{-- VALIDATION --}}
    {{-- ================================================================ --}}

    @if ($errors->any())

    <div class="mx-6 mt-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3">

        <p class="mb-2 text-sm font-semibold text-red-700">
            Please correct the following:
        </p>

        <ul class="list-disc space-y-1 pl-5 text-sm text-red-600">

            @foreach ($errors->all() as $error)

            <li>
                {{ $error }}
            </li>

            @endforeach

        </ul>

    </div>

    @endif


    {{-- ================================================================ --}}
    {{-- FORM --}}
    {{-- ================================================================ --}}

    <form
        wire:submit="save"
        class="mx-6 my-6">

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">


            {{-- ======================================================== --}}
            {{-- LEFT SIDE --}}
            {{-- ======================================================== --}}

            <div class="space-y-6 lg:col-span-2">


                {{-- ==================================================== --}}
                {{-- BASIC INFORMATION --}}
                {{-- ==================================================== --}}

                <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

                    <div class="border-b border-slate-200 px-6 py-5">

                        <h2 class="text-lg font-semibold text-slate-900">
                            Basic Information
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            Enter the main information about this destination.
                        </p>

                    </div>


                    <div class="space-y-5 p-6">

                        {{-- Title --}}
                        <div>

                            <label class="mb-2 block text-sm font-medium text-slate-700">
                                Destination Title
                                <span class="text-red-500">*</span>
                            </label>

                            <input
                                type="text"
                                wire:model="title"
                                placeholder="e.g. Phnom Sampov"
                                class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200">

                            @error('title')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                            @enderror

                        </div>


                        {{-- Slug --}}
                        <div>

                            <label class="mb-2 block text-sm font-medium text-slate-700">
                                Slug
                            </label>

                            <input
                                type="text"
                                wire:model="slug"
                                placeholder="Leave empty to generate automatically"
                                class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200">

                            @error('slug')
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
                                class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200">

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
                                class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"></textarea>

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
                                class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"></textarea>

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
                                class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"></textarea>

                        </div>

                    </div>

                </div>


                {{-- ==================================================== --}}
                {{-- LOCATION --}}
                {{-- ==================================================== --}}

                <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

                    <div class="border-b border-slate-200 px-6 py-5">

                        <h2 class="text-lg font-semibold text-slate-900">
                            Location
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            Provide the destination's location information.
                        </p>

                    </div>


                    <div class="space-y-5 p-6">

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
                                class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"></textarea>

                            @error('address')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                            @enderror

                        </div>


                        {{-- Coordinates --}}
                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                            <div>

                                <label class="mb-2 block text-sm font-medium text-slate-700">
                                    Latitude
                                </label>

                                <input
                                    type="text"
                                    wire:model="latitude"
                                    placeholder="e.g. 13.0957"
                                    class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200">

                            </div>


                            <div>

                                <label class="mb-2 block text-sm font-medium text-slate-700">
                                    Longitude
                                </label>

                                <input
                                    type="text"
                                    wire:model="longitude"
                                    placeholder="e.g. 103.2022"
                                    class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200">

                            </div>

                        </div>


                        {{-- Map Link --}}
                        <div>

                            <label class="mb-2 block text-sm font-medium text-slate-700">
                                Google Maps Link
                            </label>

                            <input
                                type="url"
                                wire:model="map_link"
                                placeholder="https://maps.google.com/..."
                                class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200">

                        </div>

                    </div>

                </div>


                {{-- ==================================================== --}}
                {{-- ADDITIONAL INFORMATION --}}
                {{-- ==================================================== --}}

                <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

                    <div class="border-b border-slate-200 px-6 py-5">

                        <h2 class="text-lg font-semibold text-slate-900">
                            Additional Information
                        </h2>

                    </div>


                    <div class="space-y-5 p-6">

                        {{-- Ticket --}}
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
                                        placeholder="Enter ticket price"
                                        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200 disabled:bg-slate-100 disabled:text-slate-400">

                                </div>

                                <span class="text-sm text-slate-500">
                                    USD
                                </span>

                            </div>


                            <label class="mt-3 flex cursor-pointer items-center gap-2">

                                <input
                                    type="checkbox"
                                    wire:model="isFree"
                                    class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">

                                <span class="text-sm text-slate-600">
                                    Free / No ticket required
                                </span>

                            </label>

                            @error('ticket_price')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                            @enderror

                        </div>


                        {{-- Contact --}}
                        <div>

                            <label class="mb-2 block text-sm font-medium text-slate-700">
                                Contact Phone
                            </label>

                            <input
                                type="text"
                                wire:model="contact_phone"
                                placeholder="+855 ..."
                                class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200">

                        </div>


                        {{-- Opening --}}
                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                            <div>

                                <label class="mb-2 block text-sm font-medium text-slate-700">
                                    Opening Time
                                </label>

                                <input
                                    type="time"
                                    wire:model="open_time"
                                    class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200">

                            </div>


                            <div>

                                <label class="mb-2 block text-sm font-medium text-slate-700">
                                    Closing Time
                                </label>

                                <input
                                    type="time"
                                    wire:model="close_time"
                                    class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200">

                            </div>

                        </div>


                        {{-- Status --}}
                        <div>

                            <label class="mb-2 block text-sm font-medium text-slate-700">
                                Status
                                <span class="text-red-500">*</span>
                            </label>

                            <select
                                wire:model="status"
                                class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200">

                                <option value="active">
                                    Active
                                </option>

                                <option value="inactive">
                                    Inactive
                                </option>

                            </select>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ======================================================== --}}
            {{-- RIGHT SIDE --}}
            {{-- ======================================================== --}}

            <div class="space-y-6">


                {{-- ==================================================== --}}
                {{-- PHOTOS --}}
                {{-- ==================================================== --}}

                <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

                    <div class="border-b border-slate-200 px-6 py-5">

                        <h2 class="text-lg font-semibold text-slate-900">
                            Destination Photos
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            Upload up to 10 photos.
                        </p>

                    </div>


                    <div class="p-6">


                        {{-- Existing Photos --}}
                        @if ($isEditing && !empty($existingPhotos))

                        <div class="mb-6">

                            <div class="mb-3 flex items-center justify-between">

                                <h3 class="text-sm font-semibold text-slate-700">
                                    Existing Photos
                                </h3>

                                <span class="text-xs text-slate-500">
                                    {{ count($existingPhotos) }} saved
                                </span>

                            </div>


                            <div class="grid grid-cols-2 gap-3">

                                @foreach ($existingPhotos as $image)

                                <div class="relative overflow-hidden rounded-lg border border-slate-200">

                                    <img
                                        src="{{ $image['image_url'] }}"
                                        alt="Destination photo"
                                        class="h-32 w-full object-cover">


                                    {{-- Primary --}}
                                    @if ($image['is_primary'])

                                    <span class="absolute left-2 top-2 rounded-full bg-blue-600 px-2 py-1 text-xs font-medium text-white">
                                        Primary
                                    </span>

                                    @else

                                    <button
                                        type="button"
                                        wire:click="setPrimaryPhoto({{ $image['image_id'] }})"
                                        class="absolute left-2 top-2 rounded-full bg-white px-2 py-1 text-xs font-medium text-slate-700 shadow hover:bg-blue-50">
                                        Set Primary
                                    </button>

                                    @endif


                                    {{-- Delete --}}
                                    <button
                                        type="button"
                                        wire:click="deleteExistingPhoto({{ $image['image_id'] }})"
                                        class="absolute right-2 top-2 flex h-7 w-7 items-center justify-center rounded-full bg-white text-red-600 shadow hover:bg-red-50">
                                        ×
                                    </button>

                                </div>

                                @endforeach

                            </div>

                        </div>

                        @elseif ($isEditing)

                        <div class="mb-6 rounded-lg bg-slate-50 px-4 py-4 text-center">

                            <p class="text-sm font-medium text-slate-600">
                                No photos uploaded yet.
                            </p>

                        </div>

                        @endif


                        {{-- Upload --}}
                        <label class="flex cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-slate-300 bg-slate-50 px-6 py-8 text-center transition hover:border-blue-400 hover:bg-blue-50">

                            <div class="mb-3 text-3xl">
                                📷
                            </div>

                            <p class="text-sm font-medium text-slate-700">
                                Click to upload photos
                            </p>

                            <p class="mt-1 text-xs text-slate-500">
                                JPG, PNG or WEBP
                            </p>

                            <p class="mt-1 text-xs text-slate-500">
                                Maximum 5MB per image
                            </p>

                            <input
                                type="file"
                                wire:model="photos"
                                multiple
                                accept="image/jpeg,image/png,image/webp"
                                class="hidden">

                        </label>


                        {{-- Uploading --}}
                        <div
                            wire:loading
                            wire:target="photos"
                            class="mt-4 rounded-lg bg-blue-50 px-4 py-3">

                            <p class="text-sm text-blue-700">
                                Uploading images...
                            </p>

                        </div>


                        {{-- Errors --}}
                        @error('photos')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                        @enderror

                        @error('photos.*')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                        @enderror


                        {{-- New Photos --}}
                        @if (!empty($photos))

                        <div class="mt-5">

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

                                <div class="relative overflow-hidden rounded-lg border border-slate-200">

                                    <img
                                        src="{{ $photo->temporaryUrl() }}"
                                        alt="New destination photo"
                                        class="h-32 w-full object-cover">


                                    {{-- New Primary --}}
                                    @if ($newPrimaryPhoto === $index)

                                    <span class="absolute left-2 top-2 rounded-full bg-blue-600 px-2 py-1 text-xs font-medium text-white">
                                        Primary
                                    </span>

                                    @else

                                    <button
                                        type="button"
                                        wire:click="setNewPrimaryPhoto({{ $index }})"
                                        class="absolute left-2 top-2 rounded-full bg-white px-2 py-1 text-xs font-medium text-slate-700 shadow hover:bg-blue-50">
                                        Set Primary
                                    </button>

                                    @endif


                                    {{-- Remove --}}
                                    <button
                                        type="button"
                                        wire:click="removePhoto({{ $index }})"
                                        class="absolute right-2 top-2 flex h-7 w-7 items-center justify-center rounded-full bg-white text-red-600 shadow hover:bg-red-50">
                                        ×
                                    </button>

                                </div>

                                @endforeach

                            </div>

                        </div>

                        @endif

                    </div>

                </div>


                {{-- ==================================================== --}}
                {{-- SAVE CARD --}}
                {{-- ==================================================== --}}

                <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

                    <h2 class="text-lg font-semibold text-slate-900">
                        {{ $isEditing ? 'Update Destination' : 'Save Destination' }}
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Review the information before saving.
                    </p>


                    <button
                        type="submit"
                        wire:loading.attr="disabled"
                        class="mt-5 w-full rounded-lg bg-blue-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-60">

                        <span wire:loading.remove wire:target="save">
                            {{ $isEditing ? 'Update Destination' : 'Save Destination' }}
                        </span>

                        <span wire:loading wire:target="save">
                            Checking...
                        </span>

                    </button>


                    <a
                        href="{{ route('admin.destinations') }}"
                        class="mt-3 block w-full rounded-lg border border-slate-300 px-4 py-3 text-center text-sm font-medium text-slate-700 hover:bg-slate-50">
                        Cancel
                    </a>

                </div>

            </div>

        </div>

    </form>

</div>