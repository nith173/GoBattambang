<div>

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

            <button
                type="button"
                class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700"
            >
                + Add Category
            </button>

        </div>

    </div>


    {{-- Category Content --}}
    <div class="bg-slate-50 p-6">

        <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">

            {{-- Table Header --}}
            <div class="border-b border-slate-100 px-6 py-5">

                <h2 class="text-lg font-semibold text-slate-900">
                    All Categories
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    {{ $categories->count() }} categories available
                </p>

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

                            <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
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

                                    <button
                                        type="button"
                                        class="mr-3 text-sm font-medium text-blue-600 hover:text-blue-700"
                                    >
                                        Edit
                                    </button>

                                    <button
                                        type="button"
                                        class="text-sm font-medium text-red-500 hover:text-red-600"
                                    >
                                        Delete
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

        </div>

    </div>

</div>