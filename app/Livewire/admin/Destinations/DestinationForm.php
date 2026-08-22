<?php

namespace App\Livewire\Admin\Destinations;

use App\Models\Category;
use App\Models\Destination;
use App\Models\DestinationImage;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class DestinationForm extends Component
{
    use WithFileUploads;

    /*
    |--------------------------------------------------------------------------
    | Destination
    |--------------------------------------------------------------------------
    */

    public ?int $destinationId = null;

    public string $title = '';
    public string $slug = '';
    public ?int $category_id = null;
    public string $description = '';
    public string $things_to_do = '';
    public string $things_to_prepare = '';
    public string $address = '';
    public string $latitude = '';
    public string $longitude = '';
    public string $map_link = '';

    /*
    |--------------------------------------------------------------------------
    | Ticket Price
    |--------------------------------------------------------------------------
    */

    public string $ticket_price = '';
    public bool $isFree = false;
    public string $contact_phone = '';
    public string $open_time = '';
    public string $close_time = '';
    public string $status = 'active';

    /*
    |--------------------------------------------------------------------------
    | Photos
    |--------------------------------------------------------------------------
    */

    public array $photos = [];

    /*
    |--------------------------------------------------------------------------
    | New Primary Photo
    |--------------------------------------------------------------------------
    */

    public ?int $newPrimaryPhoto = null;

    /*
    |--------------------------------------------------------------------------
    | Existing Photos
    |--------------------------------------------------------------------------
    */

    public array $existingPhotos = [];

    /*
    |--------------------------------------------------------------------------
    | Popup System
    |--------------------------------------------------------------------------
    */

    public bool $showConfirmPopup = false;

    public string $confirmAction = '';
    public string $confirmTitle = '';
    public string $confirmMessage = '';
    public string $confirmButtonText = 'Confirm';

    public bool $showAlertPopup = false;

    public string $alertType = 'success';
    public string $alertTitle = '';
    public string $alertMessage = '';

    /*
    |--------------------------------------------------------------------------
    | Mount
    |--------------------------------------------------------------------------
    */

    public function mount(?int $destinationId = null): void
    {
        $this->destinationId = $destinationId;

        if (!$destinationId) {
            return;
        }

        $destination = Destination::findOrFail($destinationId);

        $this->title = $destination->title ?? '';
        $this->slug = $destination->slug ?? '';
        $this->category_id = $destination->category_id;
        $this->description = $destination->description ?? '';
        $this->things_to_do = $destination->things_to_do ?? '';
        $this->things_to_prepare = $destination->things_to_prepare ?? '';
        $this->address = $destination->address ?? '';

        $this->latitude = $destination->latitude !== null
            ? (string) $destination->latitude
            : '';

        $this->longitude = $destination->longitude !== null
            ? (string) $destination->longitude
            : '';

        $this->map_link = $destination->map_link ?? '';

        $this->ticket_price = $destination->ticket_price !== null
            ? (string) $destination->ticket_price
            : '';

        $this->isFree = $destination->ticket_price !== null
            && (float) $destination->ticket_price === 0.0;

        $this->contact_phone = $destination->contact_phone ?? '';
        $this->open_time = $destination->open_time ?? '';
        $this->close_time = $destination->close_time ?? '';

        $this->status = $destination->status ?? 'active';

        $this->loadExistingPhotos();
    }

    /*
    |--------------------------------------------------------------------------
    | Load Existing Photos
    |--------------------------------------------------------------------------
    */

    private function loadExistingPhotos(): void
    {
        if (!$this->destinationId) {
            $this->existingPhotos = [];
            return;
        }

        $images = DestinationImage::where(
            'destination_id',
            $this->destinationId
        )
            ->orderBy('display_order')
            ->orderBy('image_id')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Backward Compatibility
        |--------------------------------------------------------------------------
        */

        $needsOrderFix = $images->contains(
            fn ($image) => (int) $image->display_order === 0
        );

        if ($needsOrderFix && $images->isNotEmpty()) {
            $order = 1;

            foreach ($images as $image) {
                $image->update([
                    'display_order' => $order,
                ]);

                $order++;
            }

            $images = DestinationImage::where(
                'destination_id',
                $this->destinationId
            )
                ->orderBy('display_order')
                ->orderBy('image_id')
                ->get();
        }

        $this->existingPhotos = $images
            ->map(function ($image) {
                return [
                    'image_id' => $image->image_id,
                    'image_url' => $image->image_url,
                    'is_primary' => (bool) $image->is_primary,
                    'display_order' => (int) $image->display_order,
                ];
            })
            ->toArray();
    }

    /*
    |--------------------------------------------------------------------------
    | Popup Helpers
    |--------------------------------------------------------------------------
    */

    private function openConfirmPopup(
        string $action,
        string $title,
        string $message,
        string $buttonText = 'Confirm'
    ): void {
        $this->confirmAction = $action;
        $this->confirmTitle = $title;
        $this->confirmMessage = $message;
        $this->confirmButtonText = $buttonText;

        $this->showConfirmPopup = true;
    }

    public function closeConfirmPopup(): void
    {
        $this->showConfirmPopup = false;

        $this->confirmAction = '';
        $this->confirmTitle = '';
        $this->confirmMessage = '';
        $this->confirmButtonText = 'Confirm';
    }

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
    | Confirm Popup Action
    |--------------------------------------------------------------------------
    */

    public function confirmPopupAction(): void
    {
        $action = $this->confirmAction;

        $this->closeConfirmPopup();

        try {
            switch ($action) {

                case 'save':
                    $this->performSave();
                    break;

                case 'delete-photo':
                    $this->performDeleteExistingPhoto();
                    break;

                case 'set-primary':
                    $this->performSetPrimaryPhoto();
                    break;
            }
        } catch (\Throwable $e) {

            report($e);

            $this->showError(
                'The operation could not be completed. Please try again.'
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Save Confirmation
    |--------------------------------------------------------------------------
    */

    public function save(): void
    {
        $this->validateForm();

        if ($this->destinationId) {
            $this->openConfirmPopup(
                'save',
                'Update Destination?',
                'Are you sure you want to save these changes to this destination?',
                'Update Destination'
            );

            return;
        }

        $this->openConfirmPopup(
            'save',
            'Create Destination?',
            'Are you sure you want to create this new destination?',
            'Create Destination'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Validation
    |--------------------------------------------------------------------------
    */

    private function validateForm(): void
    {
        $this->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'nullable',
                'string',
                'max:255',
            ],

            'category_id' => [
                'required',
                'integer',
                'exists:categories,category_id',
            ],

            'description' => [
                'required',
                'string',
            ],

            'things_to_do' => [
                'nullable',
                'string',
            ],

            'things_to_prepare' => [
                'nullable',
                'string',
            ],

            'address' => [
                'required',
                'string',
                'max:500',
            ],

            'latitude' => [
                'nullable',
                'numeric',
                'between:-90,90',
            ],

            'longitude' => [
                'nullable',
                'numeric',
                'between:-180,180',
            ],

            'map_link' => [
                'nullable',
                'url',
                'max:1000',
            ],

            'ticket_price' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'contact_phone' => [
                'nullable',
                'string',
                'max:50',
            ],

            'open_time' => [
                'nullable',
            ],

            'close_time' => [
                'nullable',
            ],

            'status' => [
                'required',
                'string',
                'max:50',
            ],

            'photos' => [
                'nullable',
                'array',
                'max:10',
            ],

            'photos.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ]);

        if (!$this->isFree && trim($this->ticket_price) === '') {
            $this->addError(
                'ticket_price',
                'Please enter a ticket price or select Free.'
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Perform Save
    |--------------------------------------------------------------------------
    */

    private function performSave(): void
    {
        if ($this->isFree) {
            $ticketPrice = 0;
        } else {
            if (trim($this->ticket_price) === '') {
                $this->addError(
                    'ticket_price',
                    'Please enter a ticket price or select Free.'
                );

                $this->showError(
                    'Please enter a ticket price or select Free.'
                );

                return;
            }

            $ticketPrice = $this->ticket_price;
        }

        $slug = trim($this->slug) !== ''
            ? $this->slug
            : str($this->title)->slug()->toString();

        $data = [
            'category_id' => $this->category_id,
            'title' => $this->title,
            'slug' => $slug,
            'description' => $this->description,
            'things_to_do' => $this->things_to_do ?: null,
            'things_to_prepare' => $this->things_to_prepare ?: null,
            'address' => $this->address,

            'latitude' => $this->latitude !== ''
                ? $this->latitude
                : null,

            'longitude' => $this->longitude !== ''
                ? $this->longitude
                : null,

            'map_link' => $this->map_link ?: null,
            'ticket_price' => $ticketPrice,
            'contact_phone' => $this->contact_phone ?: null,
            'open_time' => $this->open_time ?: null,
            'close_time' => $this->close_time ?: null,
            'status' => $this->status,
        ];

        /*
        |--------------------------------------------------------------------------
        | Create / Update
        |--------------------------------------------------------------------------
        */

        if ($this->destinationId) {

            $destination = Destination::findOrFail(
                $this->destinationId
            );

            $destination->update($data);

            $message = 'Destination updated successfully.';

        } else {

            $data['created_by'] = 1;

            $destination = Destination::create($data);

            $this->destinationId =
                $destination->destination_id;

            $message = 'Destination created successfully.';
        }

        /*
        |--------------------------------------------------------------------------
        | Upload New Photos
        |--------------------------------------------------------------------------
        */

        if (!empty($this->photos)) {

            $hasPrimaryImage = DestinationImage::where(
                'destination_id',
                $destination->destination_id
            )
                ->where(
                    'is_primary',
                    true
                )
                ->exists();

            $nextOrder = (int) DestinationImage::where(
                'destination_id',
                $destination->destination_id
            )->max('display_order');

            foreach ($this->photos as $index => $photo) {

                $path = $photo->store(
                    'destinations',
                    'public'
                );

                $isSelectedNewPrimary =
                    $this->newPrimaryPhoto !== null
                    && $index === $this->newPrimaryPhoto;

                $isPrimary = false;

                if ($isSelectedNewPrimary) {
                    $isPrimary = true;
                } elseif (
                    !$hasPrimaryImage
                    && $this->newPrimaryPhoto === null
                    && $index === 0
                ) {
                    $isPrimary = true;
                }

                /*
                |--------------------------------------------------------------------------
                | New photo selected as primary
                |--------------------------------------------------------------------------
                */

                if ($isSelectedNewPrimary) {

                    DestinationImage::where(
                        'destination_id',
                        $destination->destination_id
                    )->update([
                        'is_primary' => false,
                    ]);

                    $hasPrimaryImage = false;
                }

                DestinationImage::create([
                    'destination_id' =>
                        $destination->destination_id,

                    'image_url' =>
                        Storage::url($path),

                    'is_primary' =>
                        $isPrimary,

                    'display_order' =>
                        $nextOrder + $index + 1,
                ]);

                if ($isPrimary) {
                    $hasPrimaryImage = true;
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Reset
        |--------------------------------------------------------------------------
        */

        $this->loadExistingPhotos();

        $this->photos = [];

        $this->newPrimaryPhoto = null;

        /*
        |--------------------------------------------------------------------------
        | Success Popup
        |--------------------------------------------------------------------------
        */

        $this->showSuccess($message);
    }

    /*
    |--------------------------------------------------------------------------
    | Updated Photos
    |--------------------------------------------------------------------------
    */

    public function updatedPhotos(): void
    {
        if (
            $this->newPrimaryPhoto !== null
            && !isset($this->photos[$this->newPrimaryPhoto])
        ) {
            $this->newPrimaryPhoto = null;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Set New Photo as Primary
    |--------------------------------------------------------------------------
    */

    public function setNewPrimaryPhoto(int $index): void
    {
        if (!isset($this->photos[$index])) {
            return;
        }

        $this->newPrimaryPhoto = $index;
    }

    /*
    |--------------------------------------------------------------------------
    | Remove New Photo
    |--------------------------------------------------------------------------
    */

    public function removePhoto(int $index): void
    {
        if (!isset($this->photos[$index])) {
            return;
        }

        unset($this->photos[$index]);

        $this->photos = array_values($this->photos);

        if ($this->newPrimaryPhoto === $index) {

            $this->newPrimaryPhoto = null;

        } elseif (
            $this->newPrimaryPhoto !== null
            && $this->newPrimaryPhoto > $index
        ) {

            $this->newPrimaryPhoto--;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Existing Photo - Ask Confirmation
    |--------------------------------------------------------------------------
    */

    public function deleteExistingPhoto(int $imageId): void
    {
        if (!$this->destinationId) {
            return;
        }

        $image = DestinationImage::where(
            'image_id',
            $imageId
        )
            ->where(
                'destination_id',
                $this->destinationId
            )
            ->first();

        if (!$image) {
            return;
        }

        $this->openConfirmPopup(
            'delete-photo',
            'Delete Photo?',
            'Are you sure you want to permanently delete this photo? This action cannot be undone.',
            'Delete Photo'
        );

        /*
        |--------------------------------------------------------------------------
        | Store ID temporarily
        |--------------------------------------------------------------------------
        */

        $this->confirmAction = 'delete-photo';

        session()->put(
            'destination_delete_photo_id',
            $imageId
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Perform Delete Existing Photo
    |--------------------------------------------------------------------------
    */

    private function performDeleteExistingPhoto(): void
    {
        if (!$this->destinationId) {
            return;
        }

        $imageId = session()->pull(
            'destination_delete_photo_id'
        );

        if (!$imageId) {
            return;
        }

        $image = DestinationImage::where(
            'image_id',
            $imageId
        )
            ->where(
                'destination_id',
                $this->destinationId
            )
            ->first();

        if (!$image) {
            return;
        }

        $path = str_replace(
            '/storage/',
            '',
            $image->image_url
        );

        if ($path !== '') {
            Storage::disk('public')->delete($path);
        }

        $wasPrimary = (bool) $image->is_primary;

        $image->delete();

        /*
        |--------------------------------------------------------------------------
        | Reorder
        |--------------------------------------------------------------------------
        */

        $remainingImages = DestinationImage::where(
            'destination_id',
            $this->destinationId
        )
            ->orderBy('display_order')
            ->orderBy('image_id')
            ->get();

        $order = 1;

        foreach ($remainingImages as $remainingImage) {

            $remainingImage->update([
                'display_order' => $order,
            ]);

            $order++;
        }

        /*
        |--------------------------------------------------------------------------
        | If Primary Deleted
        |--------------------------------------------------------------------------
        */

        if ($wasPrimary) {

            DestinationImage::where(
                'destination_id',
                $this->destinationId
            )->update([
                'is_primary' => false,
            ]);

            $newPrimary = DestinationImage::where(
                'destination_id',
                $this->destinationId
            )
                ->orderBy('display_order')
                ->orderBy('image_id')
                ->first();

            if ($newPrimary) {

                $newPrimary->update([
                    'is_primary' => true,
                ]);
            }
        }

        $this->loadExistingPhotos();

        $this->showSuccess(
            'Photo deleted successfully.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Set Existing Photo as Primary - Ask Confirmation
    |--------------------------------------------------------------------------
    */

    public function setPrimaryPhoto(int $imageId): void
    {
        if (!$this->destinationId) {
            return;
        }

        $image = DestinationImage::where(
            'image_id',
            $imageId
        )
            ->where(
                'destination_id',
                $this->destinationId
            )
            ->first();

        if (!$image) {
            return;
        }

        $this->openConfirmPopup(
            'set-primary',
            'Set Primary Photo?',
            'This photo will become the main photo displayed for this destination.',
            'Set as Primary'
        );

        session()->put(
            'destination_primary_photo_id',
            $imageId
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Perform Set Primary
    |--------------------------------------------------------------------------
    */

    private function performSetPrimaryPhoto(): void
    {
        if (!$this->destinationId) {
            return;
        }

        $imageId = session()->pull(
            'destination_primary_photo_id'
        );

        if (!$imageId) {
            return;
        }

        $image = DestinationImage::where(
            'image_id',
            $imageId
        )
            ->where(
                'destination_id',
                $this->destinationId
            )
            ->first();

        if (!$image) {
            return;
        }

        DestinationImage::where(
            'destination_id',
            $this->destinationId
        )->update([
            'is_primary' => false,
        ]);

        $image->update([
            'is_primary' => true,
        ]);

        $this->loadExistingPhotos();

        $this->showSuccess(
            'Primary photo updated successfully.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Render
    |--------------------------------------------------------------------------
    */

    public function render()
    {
        return view(
            'livewire.admin.destinations.destination-form',
            [
                'categories' =>
                    Category::orderBy('name')->get(),

                'isEditing' =>
                    $this->destinationId !== null,
            ]
        );
    }
}