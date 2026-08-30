<?php

namespace App\Livewire\Admin\Reviews;

use App\Models\Review;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class ReviewList extends Component
{
    use WithPagination;

    public string $search = '';
    public string $ratingFilter = '';
    public string $statusFilter = '';

    public ?Review $selectedReview = null;
    public bool $showViewModal = false;

    public ?int $reviewToDeleteId = null;
    public bool $showDeleteModal = false;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingRatingFilter(): void
    {
        $this->resetPage();
    }

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    public function toggleStatus(int $reviewId): void
    {
        $review = Review::find($reviewId);

        if ($review) {
            $review->status = $review->status === 'visible' ? 'hidden' : 'visible';
            $review->save();

            session()->flash('message', 'Review status updated successfully!');
        }
    }

    public function viewReview(int $reviewId): void
    {
        $this->selectedReview = Review::with(['user', 'destination'])->find($reviewId);
        $this->showViewModal = true;
    }

    public function closeViewModal(): void
    {
        $this->showViewModal = false;
        $this->selectedReview = null;
    }

    public function confirmDelete(int $reviewId): void
    {
        $this->reviewToDeleteId = $reviewId;
        $this->showDeleteModal = true;
    }

    public function deleteReview(): void
    {
        if ($this->reviewToDeleteId) {
            $review = Review::find($this->reviewToDeleteId);
            if ($review) {
                $review->delete();
                session()->flash('message', 'Review deleted successfully!');
            }
        }

        $this->showDeleteModal = false;
        $this->reviewToDeleteId = null;
    }

   public function render()
       {
           $query = Review::with(['user', 'destination']);

           if (!empty($this->search)) {
               $searchTerm = '%' . $this->search . '%';
               $query->where(function ($q) use ($searchTerm) {
                   $q->whereHas('user', function ($uq) use ($searchTerm) {
                       $uq->where('name', 'like', $searchTerm)
                          ->orWhere('first_name', 'like', $searchTerm)
                          ->orWhere('last_name', 'like', $searchTerm)
                          ->orWhere('email', 'like', $searchTerm);
                   })
                   ->orWhereHas('destination', function ($dq) use ($searchTerm) {
                       $dq->where('name', 'like', $searchTerm)
                          ->orWhere('title', 'like', $searchTerm);
                   })
                   ->orWhere('comment', 'like', $searchTerm);
               });
           }

           if ($this->ratingFilter !== '') {
               $query->where('rating', (int)$this->ratingFilter);
           }

           if ($this->statusFilter !== '') {
               $query->where('status', $this->statusFilter);
           }

           $reviews = $query->latest('created_at')->paginate(10);

           return view('livewire.admin.reviews.review-list', [
               'reviews' => $reviews,
           ]);
       }
}
