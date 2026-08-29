<?php

use App\Livewire\Admin\Destinations\DestinationForm;
use App\Livewire\Admin\Reviews\ReviewList;
use App\Livewire\Admin\Bookings\BookingList;
use App\Livewire\Admin\Users\UserList;
use App\Livewire\Admin\Categories\CategoryList;
use App\Livewire\Admin\Categories\CategoryForm;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Destinations\DestinationList;
use App\Livewire\TestComponent;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Categories\CategoryView;

Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});


Route::get('/livewire-test', TestComponent::class);

Route::get('/admin-layout-test', function () {
    return view('admin-layout-test');
});



Route::get('/admin/dashboard', function () {
    return view('livewire.admin.dashboard');
})->name('admin.dashboard');

Route::get('/admin/destinations', DestinationList::class)
    ->name('admin.destinations');

Route::get('/admin/destinations/create', DestinationForm::class)
    ->name('admin.destinations.create');

Route::get('/admin/destinations/{destinationId}/edit', DestinationForm::class)
    ->name('admin.destinations.edit');

Route::get('/admin/categories', CategoryList::class)
    ->name('admin.categories');

Route::get('/admin/categories/create', CategoryForm::class)
    ->name('admin.categories.create');

Route::get('/admin/categories/{categoryId}/edit', CategoryForm::class)
    ->name('admin.categories.edit');

Route::get('/admin/categories/{categoryId}', CategoryView::class)
    ->name('admin.categories.view');

Route::get('/admin/users', UserList::class)
    ->name('admin.users');

Route::get('/admin/bookings', BookingList::class)
    ->name('admin.bookings');

Route::get('/admin/reviews', ReviewList::class)
    ->name('admin.reviews');
