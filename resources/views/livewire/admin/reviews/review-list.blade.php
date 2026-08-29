<div>

    {{-- Page Header --}}
    <div class="border-b border-slate-200 bg-white px-6 py-6">

        <div class="flex items-center justify-between">

            <div>
                <h1 class="text-2xl font-bold text-slate-900">
                    Reviews
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Manage customer reviews and feedback.
                </p>
            </div>

            <div class="rounded-lg bg-slate-100 px-4 py-2.5">
                <span class="text-sm font-semibold text-slate-700">
                    {{ $reviews->total() }} reviews
                </span>
            </div>

        </div>

    </div>


    {{-- Review Content --}}
    <div class="bg-slate-50 p-6">

        {{-- Success / Error Feedback Banner --}}
        @if (session()->has('message'))
            <div class="mb-6 flex items-center justify-between rounded-xl bg-emerald-50 p-4 ring-1 ring-emerald-200">
                <div class="flex items-center gap-3">
                    <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <p class="text-sm font-medium text-emerald-800">
                        {{ session('message') }}
                    </p>
                </div>
            </div>
        @endif


        <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">

            {{-- Controls & Filtering Header --}}
            <div class="border-b border-slate-100 px-6 py-5">

                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">
                            All Reviews
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            View reviewer information, ratings, comments, and status.
                        </p>
                    </div>

                    {{-- Search and Filter Controls --}}
                    <div class="flex flex-wrap items-center gap-3">

                        {{-- Search Input --}}
                        <div class="relative">
                            <input
                                wire:model.live.debounce.300ms="search"
                                type="text"
                                placeholder="Search reviewer, destination..."
                                class="w-64 rounded-xl border border-slate-200 bg-slate-50 py-2 pl-9 pr-4 text-sm text-slate-800 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-blue-500"
                            >
                            <svg class="absolute left-3 top-2.5 h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>

                        {{-- Rating Filter --}}
                        <select
                            wire:model.live="ratingFilter"
                            class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-700 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-blue-500"
                        >
                            <option value="">All Ratings</option>
                            <option value="5">5 Stars</option>
                            <option value="4">4 Stars</option>
                            <option value="3">3 Stars</option>
                            <option value="2">2 Stars</option>
                            <option value="1">1 Star</option>
                        </select>

                        {{-- Status Filter --}}
                        <select
                            wire:model.live="statusFilter"
                            class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-700 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-blue-500"
                        >
                            <option value="">All Statuses</option>
                            <option value="visible">Visible</option>
                            <option value="hidden">Hidden</option>
                        </select>

                    </div>

                </div>

            </div>


            {{-- Table --}}
            <div class="relative overflow-x-auto">

                {{-- Global Loading State Overlay --}}
                <div wire:loading.flex class="absolute inset-0 z-10 items-center justify-center bg-white/60 backdrop-blur-sm">
                    <div class="flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2 text-white shadow-lg">
                        <svg class="h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                        <span class="text-xs font-medium">Updating...</span>
                    </div>
                </div>


                <table class="min-w-full divide-y divide-slate-100">

                    <thead class="bg-slate-50">

                        <tr>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Reviewer
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Destination
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Rating
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Comment
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Status
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Date
                            </th>

                            <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100 bg-white">

                        @forelse ($reviews as $review)

                            <tr class="transition hover:bg-slate-50" wire:key="review-{{ $review->review_id }}">

                                {{-- Reviewer --}}
                                <td class="whitespace-nowrap px-6 py-4">

                                    @if ($review->user)

                                        <div class="flex items-center gap-3">

                                            @if ($review->user->profile_picture)

                                                <img
                                                    src="{{ asset('storage/' . $review->user->profile_picture) }}"
                                                    alt="{{ $review->user->first_name }} {{ $review->user->last_name }}"
                                                    class="h-10 w-10 rounded-full object-cover"
                                                >

                                            @else

                                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-50 text-sm font-bold text-blue-600">
                                                    {{ strtoupper(substr($review->user->first_name ?? 'U', 0, 1)) }}
                                                </div>

                                            @endif

                                            <div>

                                                <p class="font-semibold text-slate-900">
                                                    {{ $review->user->first_name }}
                                                    {{ $review->user->last_name }}
                                                </p>

                                                <p class="mt-0.5 text-xs text-slate-400">
                                                    {{ $review->user->email }}
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

                                    @if ($review->destination)

                                        <p class="max-w-xs truncate text-sm font-medium text-slate-800">
                                            {{ $review->destination->title ?? $review->destination->name }}
                                        </p>

                                    @else

                                        <span class="text-sm text-slate-400">
                                            Destination not found
                                        </span>

                                    @endif

                                </td>


                                {{-- Rating --}}
                                <td class="whitespace-nowrap px-6 py-4">

                                    <div class="flex items-center gap-2">

                                        <div class="flex items-center gap-0.5">

                                            @for ($star = 1; $star <= 5; $star++)

                                                @if ($star <= $review->rating)

                                                    <svg
                                                        class="h-4 w-4 fill-current text-amber-400"
                                                        viewBox="0 0 24 24"
                                                        aria-hidden="true"
                                                    >
                                                        <path d="M12 2.5l2.91 5.9 6.51.95-4.71 4.59 1.11 6.49L12 17.37l-5.82 3.06 1.11-6.49-4.71-4.59 6.51-.95L12 2.5z"/>
                                                    </svg>

                                                @else

                                                    <svg
                                                        class="h-4 w-4 fill-current text-slate-200"
                                                        viewBox="0 0 24 24"
                                                        aria-hidden="true"
                                                    >
                                                        <path d="M12 2.5l2.91 5.9 6.51.95-4.71 4.59 1.11 6.49L12 17.37l-5.82 3.06 1.11-6.49-4.71-4.59 6.51-.95L12 2.5z"/>
                                                    </svg>

                                                @endif

                                            @endfor

                                        </div>

                                        <span class="text-sm font-semibold text-slate-700">
                                            {{ $review->rating }}/5
                                        </span>

                                    </div>

                                </td>


                                {{-- Comment --}}
                                <td class="max-w-sm px-6 py-4">

                                    <p class="line-clamp-2 text-sm text-slate-600">
                                        {{ $review->comment ?: 'No comment' }}
                                    </p>

                                </td>


                                {{-- Status (Clickable Toggle) --}}
                                <td class="whitespace-nowrap px-6 py-4">

                                    <button
                                        type="button"
                                        wire:click="toggleStatus({{ $review->review_id }})"
                                        class="focus:outline-none"
                                    >
                                        @if ($review->status === 'visible')

                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-600 transition hover:bg-emerald-100">
                                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                                Visible
                                            </span>

                                        @else

                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-500 transition hover:bg-slate-200">
                                                <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                                Hidden
                                            </span>

                                        @endif
                                    </button>

                                </td>


                                {{-- Date --}}
                                <td class="whitespace-nowrap px-6 py-4">

                                    <span class="text-sm text-slate-600">
                                        {{ $review->created_at?->format('d M Y') ?? '—' }}
                                    </span>

                                </td>


                                {{-- Actions --}}
                                <td class="whitespace-nowrap px-6 py-4 text-right">

                                    {{-- View Details Button --}}
                                    <button
                                        type="button"
                                        wire:click="viewReview({{ $review->review_id }})"
                                        class="mr-3 text-sm font-medium text-blue-600 hover:text-blue-700"
                                    >
                                        View
                                    </button>

                                    {{-- Delete Button --}}
                                    <button
                                        type="button"
                                        wire:click="confirmDelete({{ $review->review_id }})"
                                        class="text-sm font-medium text-red-500 hover:text-red-600"
                                    >
                                        Delete
                                    </button>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="7"
                                    class="px-6 py-12 text-center"
                                >

                                    <p class="text-sm font-medium text-slate-500">
                                        No reviews found.
                                    </p>

                                    <p class="mt-1 text-xs text-slate-400">
                                        There are currently no customer reviews matching your query.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- Pagination Links --}}
            @if ($reviews->hasPages())
                <div class="border-t border-slate-100 px-6 py-4">
                    {{ $reviews->links() }}
                </div>
            @endif

        </div>

    </div>


    {{-- View Review Details Modal Popup --}}
    @if ($showViewModal && $selectedReview)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 p-4 backdrop-blur-sm">
            <div class="w-full max-w-lg overflow-hidden rounded-2xl bg-white shadow-xl ring-1 ring-slate-200">
                <div class="border-b border-slate-100 px-6 py-4 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-slate-900">Review Details</h3>
                    <button wire:click="closeViewModal" class="text-slate-400 hover:text-slate-600">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="p-6 space-y-4">
                    <div>
                        <span class="text-xs font-semibold uppercase text-slate-400">Reviewer</span>
                        <p class="text-sm font-semibold text-slate-800">
                            {{ $selectedReview->user?->first_name }} {{ $selectedReview->user?->last_name }} ({{ $selectedReview->user?->email }})
                        </p>
                    </div>

                    <div>
                        <span class="text-xs font-semibold uppercase text-slate-400">Destination</span>
                        <p class="text-sm font-medium text-slate-800">
                            {{ $selectedReview->destination?->title ?? $selectedReview->destination?->name }}
                        </p>
                    </div>

                    <div>
                        <span class="text-xs font-semibold uppercase text-slate-400">Rating</span>
                        <div class="flex items-center gap-1 mt-1">
                            @for ($s = 1; $s <= 5; $s++)
                                <svg class="h-4 w-4 {{ $s <= $selectedReview->rating ? 'text-amber-400 fill-current' : 'text-slate-200 fill-current' }}" viewBox="0 0 24 24">
                                    <path d="M12 2.5l2.91 5.9 6.51.95-4.71 4.59 1.11 6.49L12 17.37l-5.82 3.06 1.11-6.49-4.71-4.59 6.51-.95L12 2.5z"/>
                                </svg>
                            @endfor
                            <span class="ml-2 text-xs font-bold text-slate-700">{{ $selectedReview->rating }}/5</span>
                        </div>
                    </div>

                    <div>
                        <span class="text-xs font-semibold uppercase text-slate-400">Comment</span>
                        <div class="mt-1 rounded-xl bg-slate-50 p-3 text-sm text-slate-700 ring-1 ring-slate-100">
                            {{ $selectedReview->comment ?: 'No comment provided.' }}
                        </div>
                    </div>

                    <div>
                        <span class="text-xs font-semibold uppercase text-slate-400">Date</span>
                        <p class="text-sm text-slate-600">{{ $selectedReview->created_at?->format('d M Y, h:i A') ?? '—' }}</p>
                    </div>
                </div>

                <div class="bg-slate-50 px-6 py-3 text-right">
                    <button wire:click="closeViewModal" class="rounded-xl bg-slate-200 px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-300">
                        Close
                    </button>
                </div>
            </div>
        </div>
    @endif


    {{-- Delete Confirmation Modal Popup --}}
    @if ($showDeleteModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 p-4 backdrop-blur-sm">
            <div class="w-full max-w-md overflow-hidden rounded-2xl bg-white shadow-xl ring-1 ring-slate-200">
                <div class="p-6">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-red-100 text-red-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <h3 class="mt-4 text-center text-lg font-bold text-slate-900">Confirm Deletion</h3>
                    <p class="mt-2 text-center text-sm text-slate-500">
                        Are you sure you want to delete this review? This action cannot be undone.
                    </p>
                </div>
                <div class="flex items-center justify-end gap-3 bg-slate-50 px-6 py-4">
                    <button wire:click="$set('showDeleteModal', false)" class="rounded-xl bg-white px-4 py-2 text-xs font-semibold text-slate-700 ring-1 ring-slate-200 hover:bg-slate-100">
                        Cancel
                    </button>
                    <button wire:click="deleteReview" class="rounded-xl bg-red-600 px-4 py-2 text-xs font-semibold text-white hover:bg-red-700">
                        Delete Review
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>
