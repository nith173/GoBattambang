<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="max-w-md mx-auto mt-20 p-6 bg-white rounded shadow">
        <h1 class="text-xl font-bold mb-4">Login</h1>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label class="block mb-1 font-medium">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full border p-2 rounded">
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium">Password</label>
                <div class="relative">
                    <input type="password" name="password" id="password" required
                        class="w-full border p-2 rounded pr-10">
                    <button type="button" onclick="togglePassword('password', this)"
                        class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="eye-open h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 3.5c-4.5 0-8.3 2.9-10 6.5 1.7 3.6 5.5 6.5 10 6.5s8.3-2.9 10-6.5c-1.7-3.6-5.5-6.5-10-6.5zm0 11a4.5 4.5 0 110-9 4.5 4.5 0 010 9z" />
                            <path d="M10 7.5a2.5 2.5 0 100 5 2.5 2.5 0 000-5z" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="eye-closed h-5 w-5 hidden" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3.28 2.22a.75.75 0 00-1.06 1.06l14.5 14.5a.75.75 0 101.06-1.06l-1.97-1.97c1.7-1.19 3.02-2.87 3.79-4.75-1.7-3.6-5.5-6.5-10-6.5-1.36 0-2.66.27-3.85.76L3.28 2.22zM7.53 6.47l1.6 1.6a2.5 2.5 0 013.3 3.3l1.6 1.6a4.5 4.5 0 00-6.5-6.5zM4.02 5.6C2.65 6.72 1.53 8.18.8 9.86l-.8.14.8-.14c1.7 3.6 5.5 6.5 10 6.5.99 0 1.95-.14 2.85-.4l-1.6-1.6c-.4.07-.82.1-1.25.1a4.5 4.5 0 01-4.44-5.24L4.02 5.6z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="mb-4 flex items-center justify-between">
                <label class="flex items-center text-sm">
                    <input type="checkbox" name="remember" class="mr-2">
                    Remember me
                </label>
                <a href="{{ route('password.otp.request') }}" class="text-sm text-blue-600 hover:underline">
                    Forgot your password?
                </a>

            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded w-full">
                Log in
            </button>
            <p class="mt-4 text-sm text-center">
                Don't have an account? <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Register</a>
            </p>
        </form>
    </div>

    <script>
        function togglePassword(fieldId, btn) {
            const input = document.getElementById(fieldId);
            const eyeOpen = btn.querySelector('.eye-open');
            const eyeClosed = btn.querySelector('.eye-closed');
            if (input.type === 'password') {
                input.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                input.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        }
    </script>

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
</body>

</html>