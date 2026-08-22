@extends('layouts.admin')

@section('title', 'Admin Layout Test')

@section('content')

    <div>
        <h1 class="text-3xl font-bold text-slate-900">
            Admin Layout Test
        </h1>

        <p class="mt-2 text-slate-500">
            If you can see the sidebar, header, date, and user profile,
            the admin layout is working correctly.
        </p>

        <div class="mt-8 rounded-2xl bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-800">
                Layout Test
            </h2>

            <p class="mt-2 text-sm text-slate-500">
                GoBattambang admin panel layout is connected successfully.
            </p>
        </div>
    </div>

@endsection