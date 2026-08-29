<div>

    <div>

        {{-- ================================================================ --}}
        {{-- Automatic Flash Alert --}}
        {{-- ================================================================ --}}

        <div>

            {{-- ================================================================ --}}
            {{-- AUTOMATIC SUCCESS ALERT --}}
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
            {{-- AUTOMATIC ERROR ALERT --}}
            {{-- ================================================================ --}}

            @if (session()->has('error'))
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
                class="fixed right-6 top-6 z-[9999] flex items-center gap-3 rounded-xl bg-red-600 px-5 py-4 text-sm font-medium text-white shadow-lg">
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


            {{-- ================================================================ --}}
            {{-- PAGE HEADER --}}
            {{-- ================================================================ --}}

            <div class="border-b border-slate-200 bg-white px-6 py-6">

                <div class="flex items-center justify-between gap-4">

                    <div>
                        <h1 class="text-2xl font-bold text-slate-900">
                            Destinations
                        </h1>

                        <p class="mt-1 text-sm text-slate-500">
                            Manage tourist destinations and their content.
                        </p>
                    </div>

                    <a
                        href="{{ route('admin.destinations.create') }}"
                        class="inline-flex items-center rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                        + Add Destination
                    </a>

                </div>

            </div>


            {{-- ================================================================ --}}
            {{-- KEEP YOUR EXISTING DESTINATION TABLE / CONTENT BELOW --}}
            {{-- ================================================================ --}}

            {{-- Your existing destination table code stays here --}}

        </div>


        {{-- ================================================================ --}}
        {{-- Page Header --}}
        {{-- ================================================================ --}}

        <div class="border-b border-slate-200 bg-white px-6 py-6">
            <div class="flex items-center justify-between gap-4">

                <div>
                    <h1 class="text-2xl font-bold text-slate-900">
                        Destinations
                    </h1>

                    <p class="mt-1 text-sm text-slate-500">
                        Manage tourist destinations and their content.
                    </p>
                </div>

                <a
                    href="{{ route('admin.destinations.create') }}"
                    class="inline-flex items-center rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                    + Add Destination
                </a>

            </div>
        </div>



        @if (session()->has('error'))
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
            class="fixed right-6 top-6 z-[9999] flex items-center gap-3 rounded-xl bg-red-600 px-5 py-4 text-sm font-medium text-white shadow-lg">
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

            <span>
                {{ session('error') }}
            </span>
        </div>
        @endif


        {{-- ================================================================ --}}
        {{-- Page Header --}}
        {{-- ================================================================ --}}

        <div class="border-b border-slate-200 bg-white px-6 py-6">

            <div class="flex items-center justify-between gap-4">

                <div>
                    <h1 class="text-2xl font-bold text-slate-900">
                        Destinations
                    </h1>

                    <p class="mt-1 text-sm text-slate-500">
                        Manage tourist destinations and their content.
                    </p>
                </div>

                <a
                    href="{{ route('admin.destinations.create') }}"
                    class="inline-flex items-center rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                    + Add Destination
                </a>

            </div>

        </div>
