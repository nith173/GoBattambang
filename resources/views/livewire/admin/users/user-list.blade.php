<div>

    {{-- Page Header --}}
    <div class="border-b border-slate-200 bg-white px-6 py-6">

        <div class="flex items-center justify-between">

            <div>
                <h1 class="text-2xl font-bold text-slate-900">
                    Users
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Manage registered users and administrator accounts.
                </p>
            </div>

            <div class="rounded-lg bg-slate-100 px-4 py-2.5">
                <span class="text-sm font-semibold text-slate-700">
                    {{ $users->count() }} users
                </span>
            </div>

        </div>

    </div>


    {{-- User Content --}}
    <div class="bg-slate-50 p-6">

        <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">

            {{-- Table Header --}}
            <div class="border-b border-slate-100 px-6 py-5">

                <h2 class="text-lg font-semibold text-slate-900">
                    All Users
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    View account information and account status.
                </p>

            </div>


            {{-- Table --}}
            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-slate-100">

                    <thead class="bg-slate-50">

                        <tr>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                User
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Contact
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Role
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Status
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Joined
                            </th>

                            <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100 bg-white">

                        @forelse ($users as $user)

                            <tr class="transition hover:bg-slate-50">

                                {{-- User --}}
                                <td class="whitespace-nowrap px-6 py-4">

                                    <div class="flex items-center gap-3">

                                        @if ($user->profile_picture)

                                            <img
                                                src="{{ asset('storage/' . $user->profile_picture) }}"
                                                alt="{{ $user->first_name }} {{ $user->last_name }}"
                                                class="h-10 w-10 rounded-full object-cover"
                                            >

                                        @else

                                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-50 text-sm font-bold text-blue-600">
                                                {{ strtoupper(substr($user->first_name, 0, 1)) }}
                                            </div>

                                        @endif


                                        <div>

                                            <p class="font-semibold text-slate-900">
                                                {{ $user->first_name }} {{ $user->last_name }}
                                            </p>

                                            <p class="mt-1 text-xs text-slate-400">
                                                ID #{{ $user->user_id }}
                                            </p>

                                        </div>

                                    </div>

                                </td>


                                {{-- Contact --}}
                                <td class="px-6 py-4">

                                    <p class="text-sm text-slate-700">
                                        {{ $user->email }}
                                    </p>

                                    <p class="mt-1 text-xs text-slate-400">
                                        {{ $user->phone_number ?: 'No phone number' }}
                                    </p>

                                </td>


                                {{-- Role --}}
                                <td class="whitespace-nowrap px-6 py-4">

                                    @if ($user->role === 'admin')

                                        <span class="inline-flex rounded-full bg-purple-50 px-2.5 py-1 text-xs font-medium text-purple-600">
                                            Administrator
                                        </span>

                                    @else

                                        <span class="inline-flex rounded-full bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-600">
                                            Registered User
                                        </span>

                                    @endif

                                </td>


                                {{-- Status --}}
                                <td class="whitespace-nowrap px-6 py-4">

                                    @if ($user->account_status === 'active')

                                        <span class="inline-flex rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-600">
                                            Active
                                        </span>

                                    @elseif ($user->account_status === 'suspended')

                                        <span class="inline-flex rounded-full bg-red-50 px-2.5 py-1 text-xs font-medium text-red-600">
                                            Suspended
                                        </span>

                                    @else

                                        <span class="inline-flex rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-500">
                                            {{ ucfirst($user->account_status ?? 'Unknown') }}
                                        </span>

                                    @endif

                                </td>


                                {{-- Joined --}}
                                <td class="whitespace-nowrap px-6 py-4">

                                    <span class="text-sm text-slate-600">
                                        {{ $user->created_at?->format('d M Y') ?? '—' }}
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
                                    colspan="6"
                                    class="px-6 py-12 text-center"
                                >

                                    <p class="text-sm font-medium text-slate-500">
                                        No users found.
                                    </p>

                                    <p class="mt-1 text-xs text-slate-400">
                                        There are currently no user accounts.
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