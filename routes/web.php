<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Categories\CategoryList;
use App\Livewire\Admin\Categories\CategoryForm;
use App\Livewire\Admin\Categories\CategoryView;
use App\Livewire\Admin\Destinations\DestinationList;
use App\Livewire\Admin\Destinations\DestinationForm;
use App\Livewire\Admin\Reviews\ReviewList;

Route::get('/', function () {
    return redirect()->route('admin.categories');
});

// Category routes
Route::get('/admin/categories', CategoryList::class)->name('admin.categories');
Route::get('/admin/categories/create', CategoryForm::class)->name('admin.categories.create');
Route::get('/admin/categories/{categoryId}/edit', CategoryForm::class)->name('admin.categories.edit');
Route::get('/admin/categories/{categoryId}', CategoryView::class)->name('admin.categories.view');

// Destination routes
Route::get('/admin/destinations', DestinationList::class)->name('admin.destinations');
Route::get('/admin/destinations/create', DestinationForm::class)->name('admin.destinations.create');
Route::get('/admin/destinations/{destinationId}/edit', DestinationForm::class)->name('admin.destinations.edit');

// Review routes
Route::get('/admin/reviews', ReviewList::class)->name('admin.reviews');

// Fallback routes for components that exist on other branches
Route::get('/admin/dashboard', function () { return view('admin-layout-test'); })->name('admin.dashboard');
Route::get('/admin/users', function () { return ''; })->name('admin.users');
Route::get('/admin/bookings', function () { return ''; })->name('admin.bookings');
