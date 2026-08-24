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
                        class="rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-red-700 disabled:cursor-not-allowed disabled:opacity-60"
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

        <div class="flex items-center justify-between">

            <div>
                <h1 class="text-2xl font-bold text-slate-900">
                    Categories
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Manage tourism categories and their destinations.
                </p>
            </div>



            <a 
                href="{{ route('admin.categories.create') }}" 
                wire:navigate 
                class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700"
            >
                + Add Category
            </a>


        </div>

    </div>


    {{-- Category Content --}}
    <div class="bg-slate-50 p-6">

        <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">

            {{-- Table Header --}}
            <div class="border-b border-slate-100 px-6 py-5">

{{-- Summary Cards --}}
<div class="mb-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
{{-- Total Categories --}}
<div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
    <div class="flex items-start justify-between">

        <div>
            <p class="text-sm font-medium text-slate-500">
                Total Categories
            </p>

            <p class="mt-4 text-3xl font-bold text-slate-900">
                {{ $totalCategories }}
            </p>

            <p class="mt-3 text-sm text-slate-400">
                All categories
            </p>
        </div>

        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50">
            <svg class="h-6 w-6 text-blue-600"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16"
                />
            </svg>
        </div>

    </div>
</div>


{{-- Total Destinations --}}
<div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
    <div class="flex items-start justify-between">

        <div>
            <p class="text-sm font-medium text-slate-500">
                Total Destinations
            </p>

            <p class="mt-4 text-3xl font-bold text-slate-900">
                {{ $totalDestinations }}
            </p>

            <p class="mt-3 text-sm text-slate-400">
                Across all categories
            </p>
        </div>

        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-violet-50">
            <svg class="h-6 w-6 text-violet-600"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 21s6-5.2 6-11a6 6 0 10-12 0c0 5.8 6 11 6 11z"
                />
                <circle cx="12" cy="10" r="2" />
            </svg>
        </div>

    </div>
</div>


{{-- Categories With Destinations --}}
<div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
    <div class="flex items-start justify-between">

        <div>
            <p class="text-sm font-medium text-slate-500">
                Categories With Destinations
            </p>

            <p class="mt-4 text-3xl font-bold text-slate-900">
                {{ $categoriesWithDestinations }}
            </p>

            <p class="mt-3 text-sm text-slate-400">
                Currently in use
            </p>
        </div>

        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50">
            <svg class="h-6 w-6 text-emerald-600"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M5 13l4 4L19 7"
                />
            </svg>
        </div>

    </div>
</div>
</div>



                <div class="flex-col gap-4 md:flex-row md:items-center md:justify-between">

                    <div>    
                        <h2 class="text-lg font-semibold text-slate-900">
                            All Categories
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                             {{ $categories->total() }} categories available
                        </p>
                    </div>

                    

<div class="flex w-full flex-col gap-3 md:w-auto md:flex-row">
<div class="w-full md:w-80">
    <input
        type="search"
        wire:model.live.debounce.300ms="search"
        placeholder="Search categories..."
        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
    >
</div>

<div class="w-full md:w-52">
    <select
        wire:model.live="sort"
        class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
    >
        <option value="newest">Newest</option>
        <option value="oldest">Oldest</option>
        <option value="name_asc">Name A-Z</option>
        <option value="name_desc">Name Z-A</option>
        <option value="most_destinations">Most Destinations</option>
    </select>
</div>

</div>





            </div>


            {{-- Table --}}
            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-slate-100">

                    <thead class="bg-slate-50">

                        <tr>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Category
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Description
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Destinations
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Created
                            </th>

                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100 bg-white">

                        @forelse ($categories as $category)

                            <tr class="transition hover:bg-slate-50">

                                {{-- Category --}}
                                <td class="whitespace-nowrap px-6 py-4">

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-50 text-sm font-bold text-blue-600">
                                            {{ strtoupper(substr($category->name, 0, 1)) }}
                                        </div>

                                        <div>

                                            <p class="font-semibold text-slate-900">
                                                {{ $category->name }}
                                            </p>

                                            <p class="mt-1 text-xs text-slate-400">
                                                ID #{{ $category->category_id }}
                                            </p>

                                        </div>

                                    </div>

                                </td>


                                {{-- Description --}}
                                <td class="max-w-md px-6 py-4">

                                    <p class="truncate text-sm text-slate-600">
                                        {{ $category->description ?: 'No description' }}
                                    </p>

                                </td>


                                {{-- Destinations --}}
                                <td class="whitespace-nowrap px-6 py-4">

                                    <span class="inline-flex rounded-full bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-600">
                                        {{ $category->destinations_count }}
                                        {{ $category->destinations_count === 1 ? 'destination' : 'destinations' }}
                                    </span>

                                </td>


                                {{-- Created --}}
                                <td class="whitespace-nowrap px-6 py-4">

                                    <span class="text-sm text-slate-600">
                                        {{ $category->created_at?->format('d M Y') ?? '—' }}
                                    </span>

                                </td>


                                {{-- Actions --}}
                                <td class="whitespace-nowrap px-6 py-4 text-right">

                                    <a href="{{ route('admin.categories.view', $category->category_id) }}" 
                                    wire:navigate 
                                    class="mr-3 text-sm font-medium text-slate-600 hover:text-slate-800"
                                >
                                    View
                                </a>

                                    <a
                                        href="{{ route('admin.categories.edit', $category->category_id) }}"
                                        wire:navigate
                                        class="mr-3 text-sm font-medium text-blue-600 hover:text-blue-700"
                                    >
                                        Edit
                                    </a>

                                    <button
                                        type="button"
                                        wire:click="confirmDelete({{ $category->category_id }})"
                                        wire:loading.attr="disabled"
                                        wire:target="confirmDelete({{ $category->category_id }})"
                                        class="text-sm font-medium text-red-500 hover:text-red-600 disabled:cursor-not-allowed disabled:opacity-60"
                                    >
                                        <span wire:loading.remove wire:target="confirmDelete({{ $category->category_id }})">
                                            Delete
                                        </span>

                                        <span wire:loading wire:target="confirmDelete({{ $category->category_id }})">
                                            Checking...
                                        </span>
                                    </button>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="5"
                                    class="px-6 py-12 text-center"
                                >

                                    <p class="text-sm font-medium text-slate-500">
                                        No categories found.
                                    </p>

                                    <p class="mt-1 text-xs text-slate-400">
                                        Add a category to get started.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>
                @if ($categories->hasPages())
    <div class="border-t border-slate-100 px-6 py-4">
        {{ $categories->links() }}
    </div>
@endif
        </div>

    </div>

</div>