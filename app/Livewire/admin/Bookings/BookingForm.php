<?php

namespace App\Livewire\Admin\Bookings;

use App\Models\Booking;
use App\Models\Destination;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class BookingForm extends Component
{
    /*
    |--------------------------------------------------------------------------
    | Destination
    |--------------------------------------------------------------------------
    */

    public int $destinationId;
    public ?Destination $destination = null;
    public bool $vendorAvailable = true;

    /*
    |--------------------------------------------------------------------------
    | Form Fields
    |--------------------------------------------------------------------------
    */

    public string $booking_type = 'ticket';
    public string $guest_count = '1';
    public string $visit_date = '';

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
    public string $telegramLink = '';

    /*
    |--------------------------------------------------------------------------
    | Mount
    |--------------------------------------------------------------------------
    */

    public function mount(int $destinationId): void
    {
        $this->destinationId = $destinationId;

        $this->destination = Destination::findOrFail($destinationId);

        $this->vendorAvailable = !empty($this->destination->vendor_telegram);
    }

    /*
    |--------------------------------------------------------------------------
    | Validation
    |--------------------------------------------------------------------------
    */

    protected function rules(): array
    {
        return [
            'booking_type' => [
                'required',
                'in:ticket,accommodation',
            ],

            'guest_count' => [
                'required',
                'integer',
                'min:1',
            ],

            'visit_date' => [
                'required',
                'date',
                'after_or_equal:today',
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

        if (!$this->vendorAvailable) {
            $this->showError(
                'This destination has not set up Telegram booking yet. Please contact the destination directly.'
            );

            return;
        }

        $this->showConfirmPopup = true;
        $this->confirmTitle = 'Send Booking Request?';
        $this->confirmMessage = 'You will be redirected to Telegram to send this booking request to the vendor.';
        $this->confirmButtonText = 'Send Request';
    }

    public function closeConfirmPopup(): void
    {
        $this->showConfirmPopup = false;
    }

    public function confirmPopupAction(): void
    {
        $this->showConfirmPopup = false;

        try {
            $this->submitBooking();
        } catch (\Throwable $e) {
            report($e);

            $this->showError(
                'The booking request could not be submitted. Please try again.'
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Generate Telegram Message
    |--------------------------------------------------------------------------
    */

    private function generateTelegramMessage(): string
    {
        $user = Auth::user();

        $typeLabel = $this->booking_type === 'accommodation'
            ? 'Accommodation'
            : 'Ticket';

        $guestLabel = (int) $this->guest_count > 1 ? 'guests' : 'guest';

        $lines = [
            "Hello, I'd like to book {$typeLabel} for {$this->guest_count} {$guestLabel}"
                . " on " . \Carbon\Carbon::parse($this->visit_date)->format('M d, Y')
                . " at {$this->destination->title}.",
            '',
            'From: ' . ($user->full_name ?? $user->first_name . ' ' . $user->last_name),
        ];

        if (!empty($user->phone_number)) {
            $lines[] = 'Phone: ' . $user->phone_number;
        }

        return implode("\n", $lines);
    }

    /*
    |--------------------------------------------------------------------------
    | Submit Booking
    |--------------------------------------------------------------------------
    */

    private function submitBooking(): void
    {
        $message = $this->generateTelegramMessage();

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'destination_id' => $this->destinationId,
            'booking_type' => $this->booking_type,
            'guest_count' => $this->guest_count,
            'visit_date' => $this->visit_date,
            'telegram_message' => $message,
            'status' => 'pending',
        ]);

        $vendorUsername = $this->destination->vendor_telegram;

        $this->telegramLink = 'https://t.me/' . $vendorUsername
            . '?text=' . rawurlencode($message);

        $booking->update([
            'status' => 'sent',
        ]);

        $this->showSuccess(
            'Your booking request is ready. Redirecting you to Telegram...'
        );
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
        return view('livewire.admin.bookings.booking-form');
    }
}
