<div class="bg-slate-50 p-6">
<div class="mx-auto max-w-7xl">

    {{-- Header --}}
    <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

        <div>
            <h1 class="text-2xl font-bold text-slate-900">
                Category Details
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                View category information and related destinations.
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


    {{-- Category Information --}}
    <div class="mb-6 overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">

        <div class="border-b border-slate-100 px-6 py-5">
            <h2 class="text-lg font-semibold text-slate-900">
                {{ $category->name }}
            </h2>
        </div>

        <div class="grid gap-6 p-6 md:grid-cols-2">

            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                    Description
                </p>

                <p class="mt-2 text-sm leading-6 text-slate-700">
                    {{ $category->description ?: 'No description provided.' }}
                </p>
            </div>

            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                    Created
                </p>

                <p class="mt-2 text-sm text-slate-700">
                    {{ $category->created_at ? $category->created_at->format('d M Y') : 'N/A' }}
                </p>
            </div>

            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                    Destinations
                </p>

                <p class="mt-2 text-sm font-semibold text-blue-600">
                    {{ $category->destinations->count() }}
                    {{ $category->destinations->count() === 1 ? 'destination' : 'destinations' }}
                </p>
            </div>

        </div>

    </div>


    {{-- Destination List --}}
    <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">

        <div class="border-b border-slate-100 px-6 py-5">
            <h2 class="text-lg font-semibold text-slate-900">
                Destinations in this Category
            </h2>
        </div>

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-slate-100">

                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Destination
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Address
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Status
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Ticket Price
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 bg-white">

                    @forelse ($category->destinations as $destination)

                        <tr>

                            <td class="px-6 py-4 text-sm font-medium text-slate-900">
                                {{ $destination->title }}
                            </td>

                            <td class="px-6 py-4 text-sm text-slate-600">
                                {{ $destination->address ?: 'N/A' }}
                                </td>

                            <td class="px-6 py-4 text-sm text-slate-600">
                                {{ ucfirst($destination->status ?? 'N/A') }}
                            </td>

                            <td class="px-6 py-4 text-sm text-slate-600">
                                @if (!is_null($destination->ticket_price))
                                    ${{ number_format((float) $destination->ticket_price, 2) }}
                                @else
                                    N/A
                                @endif
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td
                                colspan="4"
                                class="px-6 py-12 text-center"
                            >
                                <p class="text-sm font-medium text-slate-500">
                                    No destinations found for this category.
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