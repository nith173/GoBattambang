<?php

namespace App\Livewire\Admin;

use App\Models\DestinationImage;
use App\Models\Review;
use App\Models\User;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Destination;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class Dashboard extends Component
{
    public function render()
{
    return view('livewire.admin.dashboard', [
        'destinationCount' => Destination::count(),
        'categoryCount' => Category::count(),
        'bookingCount' => Booking::count(),

        'registeredTravelerCount' => User::where('role', 'registered')->count(),
        'userCount' => User::where('role', 'registered')->count(),

        'reviewCount' => Review::count(),
        'destinationImageCount' => DestinationImage::count(),

        'recentBookings' => Booking::with('destination', 'user')
            ->latest('created_at')
            ->take(5)
            ->get(),

        'recentReviews' => Review::with('user', 'destination')
            ->where('status', 'visible')
            ->latest('created_at')
            ->take(5)
            ->get(),
    ]);
}
}
