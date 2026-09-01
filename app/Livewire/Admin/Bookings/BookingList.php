<?php

namespace App\Livewire\Admin\Bookings;

use App\Models\Booking;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class BookingList extends Component
{
    public function render()
    {
        $bookings = Booking::with([
            'user',
            'destination',
        ])
        ->latest('created_at')
        ->get();

        return view(
            'livewire.admin.bookings.booking-list',
            [
                'bookings' => $bookings,
            ]
        );
    }
}