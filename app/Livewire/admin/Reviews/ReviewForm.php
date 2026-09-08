<?php

namespace App\Livewire\Admin\Reviews;

use App\Models\Destination;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class ReviewForm extends Component
{
    /*
    |--------------------------------------------------------------------------
    | Destination
    |--------------------------------------------------------------------------
    */

    public int $destinationId;
    public ?Destination $destination = null;

    /*
    |--------------------------------------------------------------------------
    | Existing Review (if editing)
    |--------------------------------------------------------------------------
    */

    public ?int $existingReviewId = null;
    public bool $isEditing = false;

    /*
    |--------------------------------------------------------------------------
    | Form Fields
    |--------------------------------------------------------------------------
    */

    public int $rating = 0;
    public string $comment = '';

    /*
    |--------------------------------------------------------------------------
    | Confirmation Popup
    |--------------------------------------------------------------------------
    */

    public bool $showConfirmPopup = false;
    public string $confirmTitle = '';
    public string $confirmMessage = '';
    public string $confirmButtonText = 'Confirm';

    /*
    |--------------------------------------------------------------------------
    | Success / Error Popup
    |--------------------------------------------------------------------------
    */

    public bool $showAlertPopup = false;
    public string $alertType = 'success';
    public string $alertTitle = '';
    public string $alertMessage = '';

    /*
    |--------------------------------------------------------------------------
    | Mount
    |--------------------------------------------------------------------------
    */

    public function mount(int $destinationId): void
    {
        $this->destinationId = $destinationId;

        $this->destination = Destination::findOrFail($destinationId);

        $existing = Review::where('user_id', Auth::id())
            ->where('destination_id', $destinationId)
            ->first();

        if ($existing) {
            $this->existingReviewId = $existing->review_id;
            $this->isEditing = true;
            $this->rating = $existing->rating;
            $this->comment = $existing->comment ?? '';
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Set Rating (star click)
    |--------------------------------------------------------------------------
    */

    public function setRating(int $value): void
    {
        $this->rating = $value;
        $this->resetValidation('rating');
    }

    /*
    |--------------------------------------------------------------------------
    | Validation
    |--------------------------------------------------------------------------
    */

    protected function rules(): array
    {
        return [
            'rating' => [
                'required',
                'integer',
                'between:1,5',
            ],

            'comment' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ];
    }

    public function updated($field): void
    {
        $this->validateOnly($field);
    }

    /*
    |--------------------------------------------------------------------------
    | Open Confirmation Popup
    |--------------------------------------------------------------------------
    */

    public function submit(): void
    {
        $this->validate();

        $this->confirmTitle = $this->isEditing
            ? 'Update Your Review?'
            : 'Submit Review?';

        $this->confirmMessage = $this->isEditing
            ? 'Are you sure you want to update your review for this destination?'
            : 'Are you sure you want to submit this review?';

        $this->confirmButtonText = $this->isEditing
            ? 'Update Review'
            : 'Submit Review';

        $this->showConfirmPopup = true;
    }

    public function closeConfirmPopup(): void
    {
        $this->showConfirmPopup = false;
    }

    public function confirmPopupAction(): void
    {
        $this->showConfirmPopup = false;

        try {
            $this->saveReview();
        } catch (\Throwable $e) {
            report($e);

            $this->showError(
                'Your review could not be saved. Please try again.'
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Save Review
    |--------------------------------------------------------------------------
    */

    private function saveReview(): void
    {
        $data = [
            'user_id' => Auth::id(),
            'destination_id' => $this->destinationId,
            'rating' => $this->rating,
            'comment' => trim($this->comment) !== '' ? trim($this->comment) : null,
            'status' => 'visible',
        ];

        if ($this->existingReviewId) {
            Review::where('review_id', $this->existingReviewId)->update($data);

            $this->showSuccess('Your review has been updated successfully.');
        } else {
            $review = Review::create($data);

            $this->existingReviewId = $review->review_id;
            $this->isEditing = true;

            $this->showSuccess('Your review has been submitted successfully.');
        }
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
    | Render
    |--------------------------------------------------------------------------
    */

    public function render()
    {
        return view('livewire.admin.reviews.review-form');
    }
}