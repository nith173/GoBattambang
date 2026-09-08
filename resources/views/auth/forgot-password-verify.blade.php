<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Verify Code</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="max-w-md mx-auto mt-20 p-6 bg-white rounded shadow">
        <h1 class="text-xl font-bold mb-2">Enter Verification Code</h1>
        <p class="text-sm text-gray-500 mb-4">
            We sent a {{ $expiryMinutes }}-minute code to {{ $maskedEmail }}.
        </p>

        <form method="POST" action="{{ route('password.otp.verify') }}">
            @csrf

            <div class="mb-4">
                <label class="block mb-1 font-medium">Verification Code</label>
                <input type="text" name="code" inputmode="numeric" pattern="[0-9]*" maxlength="6" required
                    autofocus autocomplete="one-time-code"
                    class="w-full border p-2 rounded text-center tracking-widest text-lg">
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded w-full mb-3">
                Verify
            </button>
        </form>

        <form method="POST" action="{{ route('password.otp.resend') }}">
            @csrf
            <button type="submit" id="resend-btn"
                class="text-sm text-blue-600 hover:underline w-full text-center">
                Resend code
            </button>
        </form>

        <p class="text-sm text-center mt-4">
            <a href="{{ route('password.otp.request') }}" class="text-gray-500 hover:underline">Use a different email</a>
        </p>
    </div>

    <script>
        // Simple 60s cooldown on the resend button after a click.
        // The disable is deferred with setTimeout(..., 0) so the form's
        // own submission (triggered by this same click) isn't cancelled
        // by the button becoming disabled before the browser can submit it.
        // Disabling a type="submit" button synchronously inside its own
        // click handler blocks that click's default action (the submit).
        document.querySelector('#resend-btn').addEventListener('click', function (e) {
            const btn = e.target;
            const original = btn.textContent;

            setTimeout(() => {
                let seconds = 60;
                btn.disabled = true;
                const timer = setInterval(() => {
                    btn.textContent = `Resend code (${seconds}s)`;
                    seconds--;
                    if (seconds < 0) {
                        clearInterval(timer);
                        btn.disabled = false;
                        btn.textContent = original;
                    }
                }, 1000);
            }, 0);
        });
    </script>

    @if (session('status'))
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            Swal.fire({
                icon: 'success',
                title: 'Sent',
                text: "{{ session('status') }}",
                confirmButtonColor: '#2563eb'
            });
        });
    </script>
    @endif

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