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
            window.location.href = '{{ route('admin.users') }}';
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

    <div class="mx-auto max-w-5xl px-6 py-10">

        {{-- ============================================================ --}}
        {{-- HEADER --}}
        {{-- ============================================================ --}}

        <div class="mb-7">

            <a
                href="{{ route('admin.users') }}"
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

                Back to Users
            </a>

            <div class="mt-5">
                <h1 class="text-3xl font-bold tracking-tight text-slate-900">
                    {{ $isEditing ? 'Edit User' : 'Add User' }}
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    {{ $isEditing
                        ? 'Update the information for this user account.'
                        : 'Create a new user account.'
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
            {{-- ACCOUNT INFORMATION + PHOTO --}}
            {{-- ======================================================== --}}

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-5">

                {{-- ==================================================== --}}
                {{-- ACCOUNT INFORMATION --}}
                {{-- ==================================================== --}}

                <div class="rounded-2xl border border-slate-200 bg-white shadow-sm lg:col-span-3">

                    <div class="border-b border-slate-200 px-6 py-5">
                        <h2 class="text-lg font-semibold text-slate-900">
                            Account Information
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            Enter the main information about this user.
                        </p>
                    </div>

                    <div class="space-y-5 p-6">

                        {{-- First Name --}}
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">
                                First Name
                                <span class="text-red-500">*</span>
                            </label>

                            <input
                                type="text"
                                wire:model="first_name"
                                placeholder="e.g. Sokha"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                            @error('first_name')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>


                        {{-- Last Name --}}
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">
                                Last Name
                                <span class="text-red-500">*</span>
                            </label>

                            <input
                                type="text"
                                wire:model="last_name"
                                placeholder="e.g. Chan"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                            @error('last_name')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>


                        {{-- Email --}}
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">
                                Email
                                <span class="text-red-500">*</span>
                            </label>

                            <input
                                type="email"
                                wire:model="email"
                                placeholder="e.g. sokha@example.com"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                            @error('email')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>


                        {{-- Phone Number --}}
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">
                                Phone Number
                            </label>

                            <input
                                type="text"
                                wire:model="phone_number"
                                placeholder="e.g. 012 345 678"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                            @error('phone_number')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>


                        {{-- ============================================= --}}
                        {{-- CREDENTIALS (Security) --}}
                        {{-- Creating a user: admin sets an initial        --}}
                        {{-- password directly.                            --}}
                        {{-- Editing a user: no raw password field --     --}}
                        {{-- admin sends a reset link instead.             --}}
                        {{-- ============================================= --}}

                        <div
                            x-data="{
                                showPassword: false,
                                showConfirm: false
                            }">

                            @if ($isEditing)

                            <div class="flex flex-col gap-3 rounded-xl border border-slate-200 bg-slate-50 px-4 py-4 sm:flex-row sm:items-center sm:justify-between">

                                <div class="flex items-start gap-3">

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.7"
                                        stroke="currentColor"
                                        class="mt-0.5 h-5 w-5 shrink-0 text-slate-400">

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />

                                    </svg>

                                    <div>
                                        <p class="text-sm font-medium text-slate-700">
                                            For security, passwords can't be viewed or set directly.
                                        </p>

                                        <p class="mt-1 text-xs text-slate-500">
                                            {{ $lastPasswordResetSentAt
                                                    ?? 'Send a reset link and the user will choose a new password themselves.'
                                                }}
                                        </p>
                                    </div>

                                </div>

                                <button
                                    type="button"
                                    wire:click="sendPasswordResetLink"
                                    wire:confirm="Send a password reset link to this user's email?"
                                    wire:loading.attr="disabled"
                                    wire:target="sendPasswordResetLink"
                                    class="inline-flex shrink-0 items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-60">

                                    <span
                                        wire:loading.remove
                                        wire:target="sendPasswordResetLink">
                                        Send Reset Link
                                    </span>

                                    <span
                                        wire:loading
                                        wire:target="sendPasswordResetLink">
                                        Sending...
                                    </span>

                                </button>

                            </div>

                            @else

                            <div class="space-y-5">

                                {{-- Password --}}
                                <div>
                                    <label class="mb-2 block text-sm font-medium text-slate-700">
                                        Password
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <div class="relative">
                                        <input
                                            :type="showPassword ? 'text' : 'password'"
                                            wire:model="password"
                                            placeholder="Enter a password"
                                            autocomplete="new-password"
                                            class="w-full rounded-xl border border-slate-300 px-4 py-3 pr-11 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                                        <button
                                            type="button"
                                            x-on:click="showPassword = !showPassword"
                                            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">

                                            <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M10 3.5c-4.5 0-8.3 2.9-10 6.5 1.7 3.6 5.5 6.5 10 6.5s8.3-2.9 10-6.5c-1.7-3.6-5.5-6.5-10-6.5zm0 11a4.5 4.5 0 110-9 4.5 4.5 0 010 9z" />
                                                <path d="M10 7.5a2.5 2.5 0 100 5 2.5 2.5 0 000-5z" />
                                            </svg>

                                            <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M3.28 2.22a.75.75 0 00-1.06 1.06l14.5 14.5a.75.75 0 101.06-1.06l-1.97-1.97c1.7-1.19 3.02-2.87 3.79-4.75-1.7-3.6-5.5-6.5-10-6.5-1.36 0-2.66.27-3.85.76L3.28 2.22zM7.53 6.47l1.6 1.6a2.5 2.5 0 013.3 3.3l1.6 1.6a4.5 4.5 0 00-6.5-6.5zM4.02 5.6C2.65 6.72 1.53 8.18.8 9.86l-.8.14.8-.14c1.7 3.6 5.5 6.5 10 6.5.99 0 1.95-.14 2.85-.4l-1.6-1.6c-.4.07-.82.1-1.25.1a4.5 4.5 0 01-4.44-5.24L4.02 5.6z" clip-rule="evenodd" />
                                            </svg>

                                        </button>
                                    </div>
                                </div>


                                {{-- Confirm Password --}}
                                <div>
                                    <label class="mb-2 block text-sm font-medium text-slate-700">
                                        Confirm Password
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <div class="relative">
                                        <input
                                            :type="showConfirm ? 'text' : 'password'"
                                            wire:model="password_confirmation"
                                            placeholder="Re-enter the password"
                                            autocomplete="new-password"
                                            class="w-full rounded-xl border border-slate-300 px-4 py-3 pr-11 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                                        <button
                                            type="button"
                                            x-on:click="showConfirm = !showConfirm"
                                            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">

                                            <svg x-show="!showConfirm" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M10 3.5c-4.5 0-8.3 2.9-10 6.5 1.7 3.6 5.5 6.5 10 6.5s8.3-2.9 10-6.5c-1.7-3.6-5.5-6.5-10-6.5zm0 11a4.5 4.5 0 110-9 4.5 4.5 0 010 9z" />
                                                <path d="M10 7.5a2.5 2.5 0 100 5 2.5 2.5 0 000-5z" />
                                            </svg>

                                            <svg x-show="showConfirm" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M3.28 2.22a.75.75 0 00-1.06 1.06l14.5 14.5a.75.75 0 101.06-1.06l-1.97-1.97c1.7-1.19 3.02-2.87 3.79-4.75-1.7-3.6-5.5-6.5-10-6.5-1.36 0-2.66.27-3.85.76L3.28 2.22zM7.53 6.47l1.6 1.6a2.5 2.5 0 013.3 3.3l1.6 1.6a4.5 4.5 0 00-6.5-6.5zM4.02 5.6C2.65 6.72 1.53 8.18.8 9.86l-.8.14.8-.14c1.7 3.6 5.5 6.5 10 6.5.99 0 1.95-.14 2.85-.4l-1.6-1.6c-.4.07-.82.1-1.25.1a4.5 4.5 0 01-4.44-5.24L4.02 5.6z" clip-rule="evenodd" />
                                            </svg>

                                        </button>
                                    </div>

                                    @error('password_confirmation')
                                    <p class="mt-1 text-sm text-red-600">
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>

                            </div>

                            @endif

                            @error('password')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                    </div>
                </div>


                {{-- ==================================================== --}}
                {{-- PROFILE PHOTO --}}
                {{-- ==================================================== --}}

                <div class="rounded-2xl border border-slate-200 bg-white shadow-sm lg:col-span-2">

                    <div class="border-b border-slate-200 px-6 py-5">

                        <h2 class="text-lg font-semibold text-slate-900">
                            Profile Photo
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            Upload a profile picture (optional).
                        </p>

                    </div>


                    <div class="p-6">

                        {{-- ================================================= --}}
                        {{-- CURRENT / NEW PREVIEW --}}
                        {{-- ================================================= --}}

                        <div class="mb-4 flex justify-center">

                            <div class="relative h-32 w-32 overflow-hidden rounded-full bg-slate-100">

                                @if ($profilePicture)

                                <img
                                    src="{{ $profilePicture->temporaryUrl() }}"
                                    alt="New profile photo"
                                    class="h-full w-full object-cover">

                                @elseif ($existingProfilePicture && !$removeExistingProfilePicture)

                                @php

                                $currentPhoto = $existingProfilePicture;

                                $currentPhotoUrl = str_starts_with($currentPhoto, 'http://')
                                || str_starts_with($currentPhoto, 'https://')
                                ? $currentPhoto
                                : asset(ltrim($currentPhoto, '/'));

                                @endphp

                                <img
                                    src="{{ $currentPhotoUrl }}"
                                    alt="Current profile photo"
                                    class="h-full w-full object-cover">

                                @else

                                <div class="flex h-full w-full items-center justify-center">

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="h-10 w-10 text-slate-400">

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />

                                    </svg>

                                </div>

                                @endif

                            </div>

                        </div>


                        {{-- ================================================= --}}
                        {{-- REMOVE / UNDO --}}
                        {{-- ================================================= --}}

                        @if ($profilePicture)

                        <div class="mb-4 flex justify-center">

                            <button
                                type="button"
                                wire:click="removeNewPhoto"
                                class="text-sm font-medium text-red-600 hover:text-red-700">

                                Remove Selected Photo

                            </button>

                        </div>

                        @elseif ($existingProfilePicture && !$removeExistingProfilePicture)

                        <div class="mb-4 flex justify-center">

                            <button
                                type="button"
                                wire:click="markExistingPhotoForRemoval"
                                class="text-sm font-medium text-red-600 hover:text-red-700">

                                Remove Current Photo

                            </button>

                        </div>

                        @elseif ($removeExistingProfilePicture)

                        <div class="mb-4 flex flex-col items-center gap-1 text-center">

                            <p class="text-sm text-slate-500">
                                Current photo will be removed when saved.
                            </p>

                            <button
                                type="button"
                                wire:click="undoRemoveExistingPhoto"
                                class="text-sm font-medium text-blue-600 hover:text-blue-700">

                                Undo

                            </button>

                        </div>

                        @endif


                        {{-- ================================================= --}}
                        {{-- UPLOAD INPUT --}}
                        {{-- ================================================= --}}

                        <label class="flex cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-slate-300 px-4 py-6 text-center transition hover:border-blue-400 hover:bg-blue-50/40">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="mb-2 h-8 w-8 text-slate-400">

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 16.5V9.75m0 0 3 3m-3-3-3 3M6.75 19.5a4.5 4.5 0 0 1-1.41-8.775 5.25 5.25 0 0 1 10.233-2.33 3 3 0 0 1 3.758 3.848A3.752 3.752 0 0 1 18 19.5H6.75Z" />

                            </svg>

                            <span class="text-sm font-medium text-slate-600">
                                Click to upload a photo
                            </span>

                            <span class="mt-1 text-xs text-slate-400">
                                JPG, JPEG, PNG, or WEBP — up to 5 MB
                            </span>

                            <input
                                type="file"
                                wire:model="profilePicture"
                                accept="image/jpeg,image/png,image/webp"
                                class="hidden">

                        </label>

                        <div wire:loading wire:target="profilePicture" class="mt-3 text-center text-sm text-slate-500">
                            Uploading...
                        </div>

                        @error('profilePicture')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                        @enderror

                    </div>

                </div>

            </div>


            {{-- ======================================================== --}}
            {{-- ROLE & STATUS --}}
            {{-- ======================================================== --}}

            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-200 px-6 py-5">
                    <h2 class="text-lg font-semibold text-slate-900">
                        Role & Status
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Control this user's access level and account status.
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-5 p-6 sm:grid-cols-2">

                    {{-- Role --}}
                    <div>

                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Role
                            <span class="text-red-500">*</span>
                        </label>

                        <select
                            wire:model="role"
                            class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                            <option value="registered">
                                Registered
                            </option>

                            <option value="admin">
                                Admin
                            </option>

                        </select>

                        @error('role')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                        @enderror

                    </div>


                    {{-- Account Status --}}
                    <div>

                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Account Status
                            <span class="text-red-500">*</span>
                        </label>

                        <select
                            wire:model="account_status"
                            class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                            <option value="active">
                                Active
                            </option>

                            <option value="suspended">
                                Suspended
                            </option>

                        </select>

                        @error('account_status')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                        @enderror

                    </div>

                </div>
            </div>


            {{-- ======================================================== --}}
            {{-- AUDIT TRAIL --}}
            {{-- Read-only. Every save on this form should be logged      --}}
            {{-- server-side with admin_id, timestamp, and changed        --}}
            {{-- fields — this panel just surfaces the most recent entry. --}}
            {{-- ======================================================== --}}

            @if ($isEditing && ($lastEditedByName ?? null))

            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

                <div class="flex items-center gap-3 px-6 py-5">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.7"
                        stroke="currentColor"
                        class="h-5 w-5 shrink-0 text-slate-400">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />

                    </svg>

                    <p class="text-sm text-slate-500">
                        Last edited by
                        <span class="font-medium text-slate-700">{{ $lastEditedByName }}</span>
                        on
                        <span class="font-medium text-slate-700">{{ optional($lastEditedAt ?? null)->format('M d, Y g:i A') ?? '—' }}</span>
                    </p>

                </div>
            </div>

            @endif


            {{-- ======================================================== --}}
            {{-- FORM ACTIONS --}}
            {{-- ======================================================== --}}

            <div class="flex items-center justify-end gap-3 border-t border-slate-200 pt-6">

                <a
                    href="{{ route('admin.users') }}"
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
                        {{ $isEditing ? 'Update User' : 'Create User' }}
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