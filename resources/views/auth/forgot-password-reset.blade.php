<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="max-w-md mx-auto mt-20 p-6 bg-white rounded shadow">
        <h1 class="text-xl font-bold mb-2">Set a New Password</h1>
        <p class="text-sm text-gray-500 mb-4">
            Your code has been verified. Choose a new password for your account.
        </p>

        <form method="POST" action="{{ route('password.otp.reset') }}">
            @csrf

            <div class="mb-4">
                <label class="block mb-1 font-medium">New Password</label>
                <div class="relative">
                    <input type="password" name="password" id="password" required autofocus
                        class="w-full border p-2 rounded pr-10">
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
                <p class="text-xs text-gray-400 mt-1">
                    At least 8 characters, with uppercase, lowercase, a number, and a symbol.
                </p>
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium">Confirm New Password</label>
                <div class="relative">
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="w-full border p-2 rounded pr-10">
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

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded w-full">
                Reset Password
            </button>
        </form>

        <p class="text-sm text-center mt-4">
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Back to login</a>
        </p>
    </div>

    @if ($errors->any())
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: "{{ $errors->first() }}",
                confirmButtonColor: '#dc2626'
            });
        });
    </script>
    @endif

    <script>
        function togglePassword(fieldId) {
            const input = document.getElementById(fieldId);
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>
</body>

</html>