<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Categories\CategoryList;
use App\Livewire\Admin\Categories\CategoryForm;
use App\Livewire\Admin\Categories\CategoryView;

Route::get('/', function () {
    return redirect()->route('admin.categories');
});

// Category routes (available on this branch)
Route::get('/admin/categories', CategoryList::class)->name('admin.categories');
Route::get('/admin/categories/create', CategoryForm::class)->name('admin.categories.create');
Route::get('/admin/categories/{categoryId}/edit', CategoryForm::class)->name('admin.categories.edit');
Route::get('/admin/categories/{categoryId}', CategoryView::class)->name('admin.categories.view');

// Temporary placeholders for other routes missing classes on this branch
Route::get('/admin/dashboard', function () { return view('admin-layout-test'); })->name('admin.dashboard');
Route::get('/admin/destinations', function () { return ''; })->name('admin.destinations');
Route::get('/admin/destinations/create', function () { return ''; })->name('admin.destinations.create');
Route::get('/admin/destinations/{destinationId}/edit', function () { return ''; })->name('admin.destinations.edit');
Route::get('/admin/users', function () { return ''; })->name('admin.users');
Route::get('/admin/bookings', function () { return ''; })->name('admin.bookings');
Route::get('/admin/reviews', function () { return ''; })->name('admin.reviews');
