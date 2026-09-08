<?php

namespace App\Livewire\Admin\Bookings;

use App\Models\Booking;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class BookingList extends Component
{
    use WithPagination;

    /*
    |--------------------------------------------------------------------------
    | Filters
    |--------------------------------------------------------------------------
    */

    public string $search = '';
    public string $statusFilter = 'all';
    public string $typeFilter = 'all';
    public string $dateFrom = '';
    public string $dateTo = '';

    /*
    |--------------------------------------------------------------------------
    | Details Popup
    |--------------------------------------------------------------------------
    */

    public bool $showDetailsPopup = false;
    public ?int $detailsBookingId = null;

    /*
    |--------------------------------------------------------------------------
    | Confirmation Popup
    |--------------------------------------------------------------------------
    */

    public bool $showConfirmPopup = false;
    public string $confirmAction = '';
    public string $confirmTitle = '';
    public string $confirmMessage = '';
    public string $confirmButtonText = 'Confirm';
    public ?int $pendingBookingId = null;

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

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    public function updatingTypeFilter(): void
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

    public function viewDetails(int $bookingId): void
    {
        $this->detailsBookingId = $bookingId;
        $this->showDetailsPopup = true;
    }

    public function closeDetailsPopup(): void
    {
        $this->showDetailsPopup = false;
        $this->detailsBookingId = null;
    }

    /*
    |--------------------------------------------------------------------------
    | Cancel Booking
    |--------------------------------------------------------------------------
    */

    public function cancelBooking(int $bookingId): void
    {
        $this->pendingBookingId = $bookingId;

        $this->confirmAction = 'cancel';
        $this->confirmTitle = 'Cancel Booking?';
        $this->confirmMessage = 'Are you sure you want to cancel this booking? This cannot be undone.';
        $this->confirmButtonText = 'Cancel Booking';
        $this->showConfirmPopup = true;
    }

    public function closeConfirmPopup(): void
    {
        $this->showConfirmPopup = false;
        $this->confirmAction = '';
        $this->confirmTitle = '';
        $this->confirmMessage = '';
        $this->confirmButtonText = 'Confirm';
        $this->pendingBookingId = null;
    }

    public function confirmPopupAction(): void
    {
        $action = $this->confirmAction;
        $bookingId = $this->pendingBookingId;

        $this->showConfirmPopup = false;

        try {
            if ($action === 'cancel' && $bookingId) {
                $booking = Booking::findOrFail($bookingId);
                $booking->update(['status' => 'cancelled']);

                $this->showSuccess('Booking cancelled successfully.');
            }
        } catch (\Throwable $e) {
            report($e);

            $this->showError('The operation could not be completed. Please try again.');
        }

        $this->confirmAction = '';
        $this->confirmTitle = '';
        $this->confirmMessage = '';
        $this->confirmButtonText = 'Confirm';
        $this->pendingBookingId = null;
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
        $this->statusFilter = 'all';
        $this->typeFilter = 'all';
        $this->dateFrom = '';
        $this->dateTo = '';
        $this->resetPage();
    }

    /*
    |--------------------------------------------------------------------------
    | Active Filters Helper (for empty-state messaging)
    |--------------------------------------------------------------------------
    */

    public function getHasActiveFiltersProperty(): bool
    {
        return $this->search !== ''
            || $this->statusFilter !== 'all'
            || $this->typeFilter !== 'all'
            || $this->dateFrom !== ''
            || $this->dateTo !== '';
    }

    /*
    |--------------------------------------------------------------------------
    | Render
    |--------------------------------------------------------------------------
    */

    public function render()
    {
        $bookings = Booking::query()
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
            ->when($this->statusFilter !== 'all', function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->typeFilter !== 'all', function ($query) {
                $query->where('booking_type', $this->typeFilter);
            })
            ->when($this->dateFrom !== '', function ($query) {
                $query->whereDate('visit_date', '>=', $this->dateFrom);
            })
            ->when($this->dateTo !== '', function ($query) {
                $query->whereDate('visit_date', '<=', $this->dateTo);
            })
            ->orderBy('booking_id')
            ->paginate(10);

        $detailsBooking = $this->detailsBookingId
            ? Booking::with(['user', 'destination'])->find($this->detailsBookingId)
            : null;

        return view('livewire.admin.bookings.booking-list', [
            'bookings' => $bookings,
            'detailsBooking' => $detailsBooking,
            'totalBookings' => Booking::count(),
            'pendingBookings' => Booking::where('status', 'pending')->count(),
            'confirmedBookings' => Booking::where('status', 'confirmed')->count(),
            'cancelledBookings' => Booking::where('status', 'cancelled')->count(),
        ]);
    }
}