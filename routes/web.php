<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Livewire\Admin\ProfileForm;
use App\Livewire\Admin\ChangePasswordForm;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Livewire\Admin\ActivityLog\ActivityLog;
use App\Livewire\Admin\Reviews\ReviewForm;
use App\Livewire\Admin\Bookings\BookingForm;
use App\Livewire\Admin\Users\UserForm;
use App\Livewire\Admin\Destinations\DestinationForm;
use App\Livewire\Admin\Reviews\ReviewList;
use App\Livewire\Admin\Bookings\BookingList;
use App\Livewire\Admin\Users\UserList;
use App\Livewire\Admin\Categories\CategoryForm;
use App\Livewire\Admin\Categories\CategoryList;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Destinations\DestinationList;
use App\Livewire\TestComponent;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Root / Home
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    $user = Auth::user();

    return $user
        ? redirect()->route($user->role === 'admin' ? 'admin.dashboard' : 'home')
        : redirect()->route('login');
});

Route::get('/home', function () {
    return '<h1>Logged in ✅ — user-side coming soon.</h1>';
})->middleware('auth')->name('home');


Route::get('/livewire-test', TestComponent::class);

Route::get('/admin-layout-test', function () {
    return view('admin-layout-test');
});


/*
|--------------------------------------------------------------------------
| Admin Routes (protected — must be logged in AND be an admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', Dashboard::class)
        ->name('dashboard');

    Route::get('/destinations', DestinationList::class)
        ->name('destinations');

    Route::get('/destinations/create', DestinationForm::class)
        ->name('destinations.create');

    Route::get('/destinations/{destinationId}/edit', DestinationForm::class)
        ->name('destinations.edit');

    Route::get('/categories', CategoryList::class)
        ->name('categories');

    Route::get('/categories/create', CategoryForm::class)
        ->name('categories.create');

    Route::get('/categories/{categoryId}/edit', CategoryForm::class)
        ->name('categories.edit');

    Route::get('/users', UserList::class)
        ->name('users');

    Route::get('/users/create', UserForm::class)
        ->name('users.create');

    Route::get('/users/{userId}/edit', UserForm::class)
        ->name('users.edit');

    Route::get('/bookings', BookingList::class)
        ->name('bookings');

    Route::get('/reviews', ReviewList::class)
        ->name('reviews');

    Route::get('/activity-log', ActivityLog::class)
        ->name('activity-log');

    Route::get('/profile', ProfileForm::class)
        ->name('profile');

    Route::get('/password', ChangePasswordForm::class)
        ->name('password');

});


/*
|--------------------------------------------------------------------------
| Auth Routes (guest-only)
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [LoginController::class, 'store'])
    ->middleware('guest');

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::get('/forgot-password', [ForgotPasswordController::class, 'showEmailForm'])
    ->middleware('guest')
    ->name('password.otp.request');

Route::post('/forgot-password', [ForgotPasswordController::class, 'sendOtp'])
    ->middleware('guest')
    ->name('password.otp.send');

Route::get('/forgot-password/verify', [ForgotPasswordController::class, 'showVerifyForm'])
    ->middleware('guest')
    ->name('password.otp.verify.show');

Route::post('/forgot-password/verify', [ForgotPasswordController::class, 'verifyOtp'])
    ->middleware('guest')
    ->name('password.otp.verify');

Route::post('/forgot-password/resend', [ForgotPasswordController::class, 'resend'])
    ->middleware('guest')
    ->name('password.otp.resend');

Route::get('/forgot-password/reset', [ForgotPasswordController::class, 'showResetForm'])
    ->middleware('guest')
    ->name('password.otp.reset.show');

Route::post('/forgot-password/reset', [ForgotPasswordController::class, 'resetPassword'])
    ->middleware('guest')
    ->name('password.otp.reset');


/*
|--------------------------------------------------------------------------
| Public / Customer Routes
|--------------------------------------------------------------------------
*/
Route::get('/destinations/{destinationId}/book', BookingForm::class)
    ->middleware('auth')
    ->name('booking.create');

Route::get('/destinations/{destinationId}/review', ReviewForm::class)
    ->middleware('auth')
    ->name('review.create');


Route::get('/register', [RegisterController::class, 'create'])
    ->middleware('guest')
    ->name('register');

Route::post('/register', [RegisterController::class, 'store'])
    ->middleware('guest');