<x-layouts.app>
    <div class="max-w-md mx-auto mt-10">
        <h1 class="text-2xl font-bold mb-6">Create an account</h1>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <div>
                <label for="first_name" class="block text-sm font-medium">First name</label>
                <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" required autofocus
                    class="mt-1 block w-full border rounded px-3 py-2">
            </div>

            <div>
                <label for="last_name" class="block text-sm font-medium">Last name</label>
                <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" required
                    class="mt-1 block w-full border rounded px-3 py-2">
            </div>

            <div>
                <label for="email" class="block text-sm font-medium">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                    class="mt-1 block w-full border rounded px-3 py-2">
            </div>

            <div>
                <label for="phone_number" class="block text-sm font-medium">Phone number</label>
                <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number') }}"
                    class="mt-1 block w-full border rounded px-3 py-2">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium">Password</label>
                <div class="relative mt-1">
                    <input type="password" name="password" id="password" required
                        class="block w-full border rounded px-3 py-2 pr-10">
                    <button type="button" onclick="togglePassword('password')"
                        class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium">Confirm password</label>
                <div class="relative mt-1">
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="block w-full border rounded px-3 py-2 pr-10">
                    <button type="button" onclick="togglePassword('password_confirmation')"
                        class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                Register
            </button>
        </form>

        <p class="mt-4 text-sm text-center">
            Already have an account? <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Log in</a>
        </p>
    </div>

    <script>
        function togglePassword(fieldId) {
            const input = document.getElementById(fieldId);
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>
</x-layouts.app>