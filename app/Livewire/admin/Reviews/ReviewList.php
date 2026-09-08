<?php

namespace App\Livewire\Admin\Reviews;

use App\Models\Review;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class ReviewList extends Component
{
    use WithPagination;

    /*
    |--------------------------------------------------------------------------
    | Filters
    |--------------------------------------------------------------------------
    */

    public string $search = '';
    public string $ratingFilter = 'all';
    public string $statusFilter = 'all';
    public string $dateFrom = '';
    public string $dateTo = '';

    /*
    |--------------------------------------------------------------------------
    | Details Popup
    |--------------------------------------------------------------------------
    */

    public bool $showDetailsPopup = false;
    public ?int $detailsReviewId = null;

    /*
    |--------------------------------------------------------------------------
    | Confirmation Popup (Delete only)
    |--------------------------------------------------------------------------
    */

    public bool $showConfirmPopup = false;
    public string $confirmTitle = '';
    public string $confirmMessage = '';
    public string $confirmButtonText = 'Confirm';
    public ?int $pendingReviewId = null;

    /*
    |--------------------------------------------------------------------------
    | Alert Popup
    |--------------------------------------------------------------------------
    */

    public bool $showAlertPopup = false;
    public string $alertType = 'success';
    public string $alertTitle = '';
    public string $alertMessage = '';

    /*
    |--------------------------------------------------------------------------
    | Reset Pagination On Filter Change
    |--------------------------------------------------------------------------
    */

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

    public function updatingDateFrom(): void
    {
        $this->resetPage();
    }

    public function updatingDateTo(): void
    {
        $this->resetPage();
    }

    /*
    |--------------------------------------------------------------------------
    | View Details
    |--------------------------------------------------------------------------
    */

    public function viewDetails(int $reviewId): void
    {
        $this->detailsReviewId = $reviewId;
        $this->showDetailsPopup = true;
    }

    public function closeDetailsPopup(): void
    {
        $this->showDetailsPopup = false;
        $this->detailsReviewId = null;
    }

    /*
    |--------------------------------------------------------------------------
    | Toggle Visibility (instant, no confirmation)
    |--------------------------------------------------------------------------
    */

    public function toggleStatus(int $reviewId): void
    {
        $review = Review::find($reviewId);

        if (!$review) {
            return;
        }

        $review->update([
            'status' => $review->status === 'visible' ? 'hidden' : 'visible',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Review
    |--------------------------------------------------------------------------
    */

    public function deleteReview(int $reviewId): void
    {
        $this->pendingReviewId = $reviewId;

        $this->confirmTitle = 'Delete Review?';
        $this->confirmMessage = 'Are you sure you want to permanently delete this review? This cannot be undone.';
        $this->confirmButtonText = 'Delete Review';
        $this->showConfirmPopup = true;
    }

    public function closeConfirmPopup(): void
    {
        $this->showConfirmPopup = false;
        $this->confirmTitle = '';
        $this->confirmMessage = '';
        $this->confirmButtonText = 'Confirm';
        $this->pendingReviewId = null;
    }

    public function confirmPopupAction(): void
    {
        $reviewId = $this->pendingReviewId;

        $this->showConfirmPopup = false;

        try {
            if ($reviewId) {
                Review::where('review_id', $reviewId)->delete();

                $this->showSuccess('Review deleted successfully.');
            }
        } catch (\Throwable $e) {
            report($e);

            $this->showError('The operation could not be completed. Please try again.');
        }

        $this->confirmTitle = '';
        $this->confirmMessage = '';
        $this->confirmButtonText = 'Confirm';
        $this->pendingReviewId = null;
    }

    /*
    |--------------------------------------------------------------------------
    | Alert Popup Helpers
    |--------------------------------------------------------------------------
    */

    private function showSuccess(string $message): void
    {
        $this->alertType = 'success';
        $this->alertTitle = 'Success';
        $this->alertMessage = $message;
        $this->showAlertPopup = true;
    }

    private function showError(string $message): void
    {
        $this->alertType = 'error';
        $this->alertTitle = 'Something went wrong';
        $this->alertMessage = $message;
        $this->showAlertPopup = true;
    }

    public function closeAlertPopup(): void
    {
        $this->showAlertPopup = false;
    }

    /*
    |--------------------------------------------------------------------------
    | Clear Filters
    |--------------------------------------------------------------------------
    */

    public function clearFilters(): void
    {
        $this->search = '';
        $this->ratingFilter = 'all';
        $this->statusFilter = 'all';
        $this->dateFrom = '';
        $this->dateTo = '';
        $this->resetPage();
    }

    /*
    |--------------------------------------------------------------------------
    | Render
    |--------------------------------------------------------------------------
    */

    public function render()
    {
        $reviews = Review::query()
            ->with(['user', 'destination'])
            ->when($this->search !== '', function ($query) {
                $search = $this->search;

                $query->where(function ($q) use ($search) {
                    $q->whereHas('user', function ($uq) use ($search) {
                        $uq->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%");
                    })->orWhereHas('destination', function ($dq) use ($search) {
                        $dq->where('title', 'like', "%{$search}%");
                    });
                });
            })
            ->when($this->ratingFilter !== 'all', function ($query) {
                $query->where('rating', (int) $this->ratingFilter);
            })
            ->when($this->statusFilter !== 'all', function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->dateFrom !== '', function ($query) {
                $query->whereDate('created_at', '>=', $this->dateFrom);
            })
            ->when($this->dateTo !== '', function ($query) {
                $query->whereDate('created_at', '<=', $this->dateTo);
            })
            ->orderByDesc('created_at')
            ->paginate(10);

        $detailsReview = $this->detailsReviewId
            ? Review::with(['user', 'destination'])->find($this->detailsReviewId)
            : null;

        return view('livewire.admin.reviews.review-list', [
            'reviews' => $reviews,
            'detailsReview' => $detailsReview,
        ]);
    }
}