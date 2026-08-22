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
                    {{ $reviews->count() }} reviews
                </span>
            </div>

        </div>

    </div>


    {{-- Review Content --}}
    <div class="bg-slate-50 p-6">

        <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">

            {{-- Table Header --}}
            <div class="border-b border-slate-100 px-6 py-5">

                <h2 class="text-lg font-semibold text-slate-900">
                    All Reviews
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    View reviewer information, ratings, comments, and status.
                </p>

            </div>


            {{-- Table --}}
            <div class="overflow-x-auto">

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

                            <tr class="transition hover:bg-slate-50">

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
                                                    {{ strtoupper(substr($review->user->first_name, 0, 1)) }}
                                                </div>

                                            @endif

                                            <div>

                                                <p class="font-semibold text-slate-900">
                                                    {{ $review->user->first_name }}
                                                    {{ $review->user->last_name }}
                                                </p>

                                                <p class="mt-1 text-xs text-slate-400">
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
                                            {{ $review->destination->title }}
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


                                {{-- Status --}}
                                <td class="whitespace-nowrap px-6 py-4">

                                    @if ($review->status === 'visible')

                                        <span class="inline-flex rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-600">
                                            Visible
                                        </span>

                                    @elseif ($review->status === 'hidden')

                                        <span class="inline-flex rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-500">
                                            Hidden
                                        </span>

                                    @else

                                        <span class="inline-flex rounded-full bg-amber-50 px-2.5 py-1 text-xs font-medium text-amber-600">
                                            {{ ucfirst($review->status ?? 'Unknown') }}
                                        </span>

                                    @endif

                                </td>


                                {{-- Date --}}
                                <td class="whitespace-nowrap px-6 py-4">

                                    <span class="text-sm text-slate-600">
                                        {{ $review->created_at?->format('d M Y') ?? '—' }}
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
                                    colspan="7"
                                    class="px-6 py-12 text-center"
                                >

                                    <p class="text-sm font-medium text-slate-500">
                                        No reviews found.
                                    </p>

                                    <p class="mt-1 text-xs text-slate-400">
                                        There are currently no customer reviews.
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