<div>

    {{-- Page Header --}}
    <div class="border-b border-slate-200 bg-white px-6 py-6">

        <div class="flex items-center justify-between">

            <div>
                <h1 class="text-2xl font-bold text-slate-900">
                    Bookings
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Manage and monitor customer booking requests.
                </p>
            </div>

            <div class="rounded-lg bg-slate-100 px-4 py-2.5">
                <span class="text-sm font-semibold text-slate-700">
                    {{ $bookings->count() }} bookings
                </span>
            </div>

        </div>

    </div>


    {{-- Booking Content --}}
    <div class="bg-slate-50 p-6">

        <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">

            {{-- Table Header --}}
            <div class="border-b border-slate-100 px-6 py-5">

                <h2 class="text-lg font-semibold text-slate-900">
                    All Bookings
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    View booking details, customer information, and request status.
                </p>

            </div>


            {{-- Table --}}
            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-slate-100">

                    <thead class="bg-slate-50">

                        <tr>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Booking
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Customer
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Destination
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Type
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Guests
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Visit Date
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Status
                            </th>

                            <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100 bg-white">

                        @forelse ($bookings as $booking)

                            <tr class="transition hover:bg-slate-50">

                                {{-- Booking --}}
                                <td class="whitespace-nowrap px-6 py-4">

                                    <div>
                                        <p class="font-semibold text-slate-900">
                                            #{{ $booking->booking_id }}
                                        </p>

                                        <p class="mt-1 text-xs text-slate-400">
                                            {{ $booking->created_at
                                                ? \Carbon\Carbon::parse($booking->created_at)->format('d M Y, H:i')
                                                : '—'
                                            }}
                                        </p>
                                    </div>

                                </td>


                                {{-- Customer --}}
                                <td class="whitespace-nowrap px-6 py-4">

                                    @if ($booking->user)

                                        <div class="flex items-center gap-3">

                                            @if ($booking->user->profile_picture)

                                                <img
                                                    src="{{ asset('storage/' . $booking->user->profile_picture) }}"
                                                    alt="{{ $booking->user->first_name }} {{ $booking->user->last_name }}"
                                                    class="h-9 w-9 rounded-full object-cover"
                                                >

                                            @else

                                                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-blue-50 text-xs font-bold text-blue-600">
                                                    {{ strtoupper(substr($booking->user->first_name, 0, 1)) }}
                                                </div>

                                            @endif

                                            <div>

                                                <p class="font-medium text-slate-900">
                                                    {{ $booking->user->first_name }}
                                                    {{ $booking->user->last_name }}
                                                </p>

                                                <p class="mt-1 text-xs text-slate-400">
                                                    {{ $booking->user->email }}
                                                </p>

                                            </div>

                                        </div>

                                    @else

                                        <span class="text-sm text-slate-400">
                                            User not found
                                        </span>

                                    @endif

                                </td>


                                {{-- Destination --}}
                                <td class="px-6 py-4">

                                    @if ($booking->destination)

                                        <p class="max-w-xs truncate text-sm font-medium text-slate-800">
                                            {{ $booking->destination->title }}
                                        </p>

                                    @else

                                        <span class="text-sm text-slate-400">
                                            Destination not found
                                        </span>

                                    @endif

                                </td>


                                {{-- Booking Type --}}
                                <td class="whitespace-nowrap px-6 py-4">

                                    <span class="inline-flex rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium capitalize text-slate-600">
                                        {{ str_replace('_', ' ', $booking->booking_type) }}
                                    </span>

                                </td>


                                {{-- Guests --}}
                                <td class="whitespace-nowrap px-6 py-4">

                                    <span class="text-sm text-slate-700">
                                        {{ $booking->guest_count }}
                                        {{ $booking->guest_count == 1 ? 'guest' : 'guests' }}
                                    </span>

                                </td>


                                {{-- Visit Date --}}
                                <td class="whitespace-nowrap px-6 py-4">

                                    <span class="text-sm text-slate-600">
                                        {{ $booking->visit_date
                                            ? \Carbon\Carbon::parse($booking->visit_date)->format('d M Y')
                                            : '—'
                                        }}
                                    </span>

                                </td>


                                {{-- Status --}}
                                <td class="whitespace-nowrap px-6 py-4">

                                    @if ($booking->status === 'sent')

                                        <span class="inline-flex rounded-full bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-600">
                                            Sent
                                        </span>

                                    @elseif ($booking->status === 'pending')

                                        <span class="inline-flex rounded-full bg-amber-50 px-2.5 py-1 text-xs font-medium text-amber-600">
                                            Pending
                                        </span>

                                    @elseif ($booking->status === 'confirmed')

                                        <span class="inline-flex rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-600">
                                            Confirmed
                                        </span>

                                    @elseif ($booking->status === 'cancelled')

                                        <span class="inline-flex rounded-full bg-red-50 px-2.5 py-1 text-xs font-medium text-red-600">
                                            Cancelled
                                        </span>

                                    @else

                                        <span class="inline-flex rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-500">
                                            {{ ucfirst($booking->status ?? 'Unknown') }}
                                        </span>

                                    @endif

                                </td>


                                {{-- Actions --}}
                                <td class="whitespace-nowrap px-6 py-4 text-right">

                                    <button
                                        type="button"
                                        class="mr-3 text-sm font-medium text-blue-600 hover:text-blue-700"
                                    >
                                        View
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
                                    colspan="8"
                                    class="px-6 py-12 text-center"
                                >

                                    <p class="text-sm font-medium text-slate-500">
                                        No bookings found.
                                    </p>

                                    <p class="mt-1 text-xs text-slate-400">
                                        There are currently no booking requests.
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