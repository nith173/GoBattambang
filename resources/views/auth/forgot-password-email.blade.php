<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="max-w-md mx-auto mt-20 p-6 bg-white rounded shadow">
        <h1 class="text-xl font-bold mb-2">Forgot Password</h1>
        <p class="text-sm text-gray-500 mb-4">
            Enter your account email. We'll send a verification code to it.
        </p>

        <form method="POST" action="{{ route('password.otp.send') }}">
            @csrf

            <div class="mb-4">
                <label class="block mb-1 font-medium">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full border p-2 rounded">
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded w-full">
                Send Code
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
</body>

</html>