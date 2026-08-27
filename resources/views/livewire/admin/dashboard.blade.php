<div class="space-y-8">

    {{-- ========================================================= --}}
    {{-- Dashboard Header --}}
    {{-- ========================================================= --}}

    <div>
        <h1 class="text-3xl font-bold text-slate-900">
            Welcome to GoBattambang Admin
        </h1>

        <p class="mt-2 text-base text-slate-500">
            Manage your tourism content, destinations, bookings, and users.
        </p>
    </div>


    {{-- ========================================================= --}}
    {{-- Statistics --}}
    {{-- ========================================================= --}}

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">

        {{-- Registered Travelers --}}
        <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">

            <div class="flex items-start justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Registered Travelers
                    </p>

                    <p class="mt-4 text-3xl font-bold text-slate-900">
                        {{ $registeredTravelerCount }}
                    </p>

                    <p class="mt-3 text-sm">
                        <span class="font-medium text-emerald-500">
                            ↑ 12.5%
                        </span>
                        <span class="text-slate-400">
                            from last month
                        </span>
                    </p>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50">
                    <svg
                        class="h-6 w-6 text-blue-600"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m4-5a4 4 0 100-8 4 4 0 000 8zm6 1a3 3 0 100-6 3 3 0 000 6z" />
                    </svg>
                </div>

            </div>

        </div>


        {{-- Active Destinations --}}
        <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">

            <div class="flex items-start justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Active Destinations
                    </p>

                    <p class="mt-4 text-3xl font-bold text-slate-900">
                        {{ $destinationCount }}
                    </p>

                    <p class="mt-3 text-sm">
                        <span class="font-medium text-emerald-500">
                            ↑ 4.3%
                        </span>
                        <span class="text-slate-400">
                            from last month
                        </span>
                    </p>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-violet-50">
                    <svg
                        class="h-6 w-6 text-violet-600"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 21s7-6.5 7-12a7 7 0 10-14 0c0 5.5 7 12 7 12z" />

                        <circle
                            cx="12"
                            cy="9"
                            r="2"
                            stroke-width="2" />
                    </svg>
                </div>

            </div>

        </div>


        {{-- Bookings --}}
        <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">

            <div class="flex items-start justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Bookings
                    </p>

                    <p class="mt-4 text-3xl font-bold text-slate-900">
                        {{ $bookingCount }}
                    </p>

                    <p class="mt-3 text-sm">
                        <span class="font-medium text-emerald-500">
                            ↑ 18.6%
                        </span>
                        <span class="text-slate-400">
                            from last month
                        </span>
                    </p>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50">
                    <svg
                        class="h-6 w-6 text-amber-600"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 7h12a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V9a2 2 0 012-2z" />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M8 12h8" />
                    </svg>
                </div>

            </div>

        </div>


        {{-- Total Reviews --}}
        <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">

            <div class="flex items-start justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Total Reviews
                    </p>

                    <p class="mt-4 text-3xl font-bold text-slate-900">
                        {{ $reviewCount }}
                    </p>

                    <p class="mt-3 text-sm">
                        <span class="font-medium text-emerald-500">
                            ↑ 15.2%
                        </span>
                        <span class="text-slate-400">
                            from last month
                        </span>
                    </p>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-rose-50">
                    <svg
                        class="h-6 w-6 text-rose-500"
                        fill="currentColor"
                        viewBox="0 0 24 24">
                        <path d="M12 2.5l2.9 5.88 6.49.94-4.7 4.58 1.11 6.47L12 17.32l-5.8 3.05 1.11-6.47-4.7-4.58 6.49-.94L12 2.5z" />
                    </svg>
                </div>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- Recent Bookings + Recent Reviews --}}
    {{-- ========================================================= --}}

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

        {{-- Recent Bookings --}}
        <div class="overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm">

            <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">

                <div>
                    <h2 class="text-lg font-semibold text-slate-900">
                        Recent Bookings
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Latest booking activity
                    </p>
                </div>

                <a
                    href="#"
                    class="text-sm font-medium text-blue-600 hover:text-blue-700">
                    View All
                </a>

            </div>


            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-slate-100">

                    <thead class="bg-slate-50">

                        <tr>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Destination
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Type
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Guests
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Date
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Status
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100 bg-white">

                        @forelse ($recentBookings as $booking)

                        <tr class="hover:bg-slate-50">

                            <td class="whitespace-nowrap px-5 py-4">

                                <div class="text-sm font-medium text-slate-900">
                                    {{ $booking->destination?->title ?? 'Unknown Destination' }}
                                </div>

                                <div class="text-xs text-slate-400">
                                    Booking #{{ $booking->booking_id }}
                                </div>

                            </td>


                            <td class="whitespace-nowrap px-5 py-4">

                                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium capitalize text-slate-600">
                                    {{ $booking->booking_type }}
                                </span>

                            </td>


                            <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-600">
                                {{ $booking->guest_count }}
                            </td>


                            <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-600">
                                {{ $booking->visit_date }}
                            </td>


                            <td class="whitespace-nowrap px-5 py-4">

                                @if ($booking->status === 'sent')

                                <span class="inline-flex items-center rounded-full bg-emerald-50 px-3 py-1 text-xs font-medium text-emerald-600">
                                    <span class="mr-1.5 h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                    Sent
                                </span>

                                @elseif ($booking->status === 'pending')

                                <span class="inline-flex items-center rounded-full bg-amber-50 px-3 py-1 text-xs font-medium text-amber-600">
                                    <span class="mr-1.5 h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                    Pending
                                </span>

                                @else

                                <span class="inline-flex items-center rounded-full bg-red-50 px-3 py-1 text-xs font-medium text-red-600">
                                    {{ ucfirst($booking->status) }}
                                </span>

                                @endif

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td
                                colspan="5"
                                class="px-6 py-10 text-center text-sm text-slate-400">
                                No recent bookings found.
                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- Recent Reviews --}}
        <div class="overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm">

            {{-- Header --}}
            <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">

                <div>
                    <h2 class="text-lg font-semibold text-slate-900">
                        Recent Reviews
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Latest traveler reviews
                    </p>
                </div>

                <a
                    href="#"
                    class="text-sm font-medium text-blue-600 hover:text-blue-700">
                    View All
                </a>

            </div>


            {{-- Reviews --}}
            <div class="divide-y divide-slate-100">

                @forelse ($recentReviews as $review)

                <div class="px-6 py-4">

                    {{-- Name + Rating --}}
                    <div class="flex items-center justify-between gap-4">

                        <div class="flex min-w-0 items-center gap-3">

                            {{-- Profile Picture --}}
                            @if ($review->user?->profile_picture)

                            <img
                                src="{{ asset('storage/' . $review->user->profile_picture) }}"
                                alt="{{ $review->user->first_name }}"
                                class="h-10 w-10 shrink-0 rounded-full object-cover">

                            @else

                            {{-- Default Avatar --}}
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-slate-100 text-sm font-semibold text-slate-500">
                                {{ strtoupper(substr($review->user?->first_name ?? 'T', 0, 1)) }}
                            </div>

                            @endif


                            <div class="min-w-0">

                                <p class="truncate text-sm font-semibold text-slate-900">
                                    {{ $review->user
                ? $review->user->first_name . ' ' . $review->user->last_name
                : 'Traveler'
            }}
                                </p>

                                <p class="mt-1 truncate text-xs text-slate-400">
                                    {{ $review->destination?->title ?? 'Unknown Destination' }}
                                </p>

                            </div>

                        </div>


                        {{-- Rating --}}
                        <div class="flex shrink-0 items-center gap-0.5 text-amber-400">

                            @for ($i = 1; $i <= 5; $i++)

                                <span class="text-sm leading-none">
                                {{ $i <= $review->rating ? '★' : '☆' }}
                                </span>

                                @endfor

                        </div>

                    </div>


                    {{-- Comment --}}
                    <p class="mt-3 line-clamp-2 text-sm leading-5 text-slate-600">
                        {{ $review->comment }}
                    </p>


                    {{-- Date + Status --}}
                    <div class="mt-3 flex items-center justify-between">

                        <span class="text-xs text-slate-400">
                            {{ $review->created_at?->diffForHumans() }}
                        </span>

                        @if ($review->status === 'visible')

                        <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-600">
                            Visible
                        </span>

                        @else

                        <span class="rounded-full bg-amber-50 px-2.5 py-1 text-xs font-medium text-amber-600">
                            {{ ucfirst($review->status) }}
                        </span>

                        @endif

                    </div>

                </div>

                @empty

                <div class="px-6 py-10 text-center">

                    <p class="text-sm text-slate-400">
                        No reviews found.
                    </p>

                </div>

                @endforelse

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- Content Overview --}}
    {{-- ========================================================= --}}

    <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 overflow-hidden">

        {{-- Section Header --}}
        <div class="border-b border-slate-100 px-6 py-5">
            <div>
                <h2 class="text-lg font-semibold text-slate-900">
                    Content Overview
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Overview of tourism content
                </p>
            </div>
        </div>


        {{-- 2 x 2 Cards --}}
        <div class="grid grid-cols-1 gap-4 p-6 sm:grid-cols-2">

            {{-- ===================================================== --}}
            {{-- Destinations --}}
            {{-- ===================================================== --}}

            <div class="min-w-0 rounded-xl bg-blue-50 p-6">

                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100">
                    <span class="text-xl">📍</span>
                </div>

                <p class="mt-5 text-sm font-medium text-slate-600">
                    Destinations
                </p>

                <p class="mt-2 text-3xl font-bold text-slate-900">
                    {{ $destinationCount }}
                </p>

                <p class="mt-1 text-sm text-slate-500">
                    Tourist destinations
                </p>

                <div class="mt-5">
                    <a
                        href="{{ route('admin.destinations') }}"
                        class="text-sm font-semibold text-blue-600 transition hover:text-blue-700">
                        View →
                    </a>
                </div>

            </div>


            {{-- ===================================================== --}}
            {{-- Categories --}}
            {{-- ===================================================== --}}

            <div class="min-w-0 rounded-xl bg-emerald-50 p-6">

                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-100">
                    <span class="text-xl">🏷️</span>
                </div>

                <p class="mt-5 text-sm font-medium text-slate-600">
                    Categories
                </p>

                <p class="mt-2 text-3xl font-bold text-slate-900">
                    {{ $categoryCount }}
                </p>

                <p class="mt-1 text-sm text-slate-500">
                    Tourism categories
                </p>

                <div class="mt-5">
                    <a
                        href="{{ route('admin.categories') }}"
                        class="text-sm font-semibold text-emerald-600 transition hover:text-emerald-700">
                        View →
                    </a>
                </div>

            </div>


            {{-- ===================================================== --}}
            {{-- Reviews --}}
            {{-- ===================================================== --}}

            <div class="min-w-0 rounded-xl bg-amber-50 p-6">

                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-amber-100">
                    <span class="text-xl">⭐</span>
                </div>

                <p class="mt-5 text-sm font-medium text-slate-600">
                    Reviews
                </p>

                <p class="mt-2 text-3xl font-bold text-slate-900">
                    {{ $reviewCount }}
                </p>

                <p class="mt-1 text-sm text-slate-500">
                    Traveler reviews
                </p>

                <div class="mt-5">
                    <a
                        href="{{ route('admin.reviews') }}"
                        class="text-sm font-semibold text-amber-600 transition hover:text-amber-700">
                        View →
                    </a>
                </div>

            </div>


            {{-- ===================================================== --}}
            {{-- Users --}}
            {{-- ===================================================== --}}

            <div class="min-w-0 rounded-xl bg-violet-50 p-6">

                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-violet-100">
                    <span class="text-xl">👥</span>
                </div>

                <p class="mt-5 text-sm font-medium text-slate-600">
                    Users
                </p>

                <p class="mt-2 text-3xl font-bold text-slate-900">
                    {{ $userCount }}
                </p>

                <p class="mt-1 text-sm text-slate-500">
                    Registered users
                </p>

                <div class="mt-5">
                    <a
                        href="{{ route('admin.users') }}"
                        class="text-sm font-semibold text-violet-600 transition hover:text-violet-700">
                        View →
                    </a>
                </div>

            </div>

        </div>

    </div>



</div>