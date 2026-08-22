<?php

namespace App\Livewire\Admin\Reviews;

use App\Models\Review;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class ReviewList extends Component
{
    public function render()
    {
        $reviews = Review::with([
            'user',
            'destination',
        ])
        ->latest('created_at')
        ->get();

        return view(
            'livewire.admin.reviews.review-list',
            [
                'reviews' => $reviews,
            ]
        );
    }
}