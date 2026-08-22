<div class="min-h-screen bg-slate-900 flex items-center justify-center p-8">

    <div class="w-full max-w-lg rounded-2xl bg-white p-6 shadow-xl">

        <h1 class="mb-2 text-2xl font-bold text-slate-900">
            Local Image Test
        </h1>

        <p class="mb-5 text-slate-500">
            Testing the Phnom Sampov local image.
        </p>

        <img
            src="{{ asset('storage/destinations/phnom-sampov.jpg') }}"
            alt="Phnom Sampov"
            class="h-64 w-full rounded-xl object-cover"
        >

        <div class="mt-5 rounded-xl bg-green-50 px-4 py-3 text-center">
            <p class="font-semibold text-green-600">
                ✓ Local image loaded successfully
            </p>
        </div>

    </div>

</div>