<?php

namespace App\Livewire\Admin\Destinations;

use App\Models\Category;
use App\Models\Destination;
use App\Models\DestinationImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

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
    public bool $isEditing = false;
    public string $title = '';
    public string $slug = '';
    public ?int $category_id = null;
    public string $description = '';
    public string $things_to_do = '';
    public string $things_to_prepare = '';

    /*
    |--------------------------------------------------------------------------
    | Location
    |--------------------------------------------------------------------------
    */

    public string $address = '';
    public string $latitude = '';
    public string $longitude = '';
    public string $map_link = '';

    /*
    |--------------------------------------------------------------------------
    | Pricing & Opening Hours
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
    public ?int $newPrimaryPhoto = null;
    public array $existingPhotos = [];

    /*
    |--------------------------------------------------------------------------
    | Pending Photo Actions
    |--------------------------------------------------------------------------
    */

    public ?int $pendingPhotoId = null;

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

    public function mount(?int $destinationId = null): void
    {
        $this->destinationId = $destinationId;
        $this->isEditing = (bool) $destinationId;

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

        $this->open_time = $this->formatTime($destination->open_time);
        $this->close_time = $this->formatTime($destination->close_time);

        $this->status = $destination->status ?? 'active';

        $this->loadExistingPhotos();
    }

    /*
    |--------------------------------------------------------------------------
    | Format Time
    |--------------------------------------------------------------------------
    */

    private function formatTime($time): string
    {
        if (!$time) {
            return '';
        }

        if ($time instanceof \DateTimeInterface) {
            return $time->format('H:i');
        }

        return substr((string) $time, 0, 5);
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
            ->orderByDesc('is_primary')
            ->orderBy('image_id')
            ->get();

        $this->existingPhotos = $images
            ->map(function ($image) {
                return [
                    'image_id' => $image->image_id,
                    'image_url' => $image->image_url,
                    'is_primary' => (bool) $image->is_primary,
                ];
            })
            ->toArray();
    }

    /*
    |--------------------------------------------------------------------------
    | Confirmation Popup
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
        $this->pendingPhotoId = null;
    }

    /*
    |--------------------------------------------------------------------------
    | Alert Popup
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

    public function showUploadError(): void
    {
        $this->showError(
            'The photo could not be uploaded. Please make sure the file is JPG, JPEG, PNG, or WEBP and is no larger than 5 MB.'
        );
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

        $this->showConfirmPopup = false;

        try {
            switch ($action) {
                case 'save':
                    $this->performSave();
                    break;
            }
        } catch (\Throwable $e) {
            report($e);

            $this->showError($e->getMessage());
        }

        $this->confirmAction = '';
        $this->confirmTitle = '';
        $this->confirmMessage = '';
        $this->confirmButtonText = 'Confirm';
    }

    /*
    |--------------------------------------------------------------------------
    | Save
    |--------------------------------------------------------------------------
    */

    public function save(): void
    {
        $this->resetValidation();

        $this->validateForm();

        if ($this->getTotalPhotoCount() > 10) {
            $this->addError(
                'photos',
                'A destination can have a maximum of 10 photos.'
            );

            $this->showError(
                'A destination can have a maximum of 10 photos.'
            );

            return;
        }

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
                'date_format:H:i',
            ],

            'close_time' => [
                'nullable',
                'date_format:H:i',
            ],

            'status' => [
                'required',
                'in:active,hidden',
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

            throw ValidationException::withMessages([
                'ticket_price' =>
                    'Please enter a ticket price or select Free.',
            ]);
        }
    }

    private function getTotalPhotoCount(): int
    {
        return count($this->existingPhotos)
            + count($this->photos);
    }

    /*
    |--------------------------------------------------------------------------
    | Perform Save
    |--------------------------------------------------------------------------
    */

    private function performSave(): void
    {
        $this->resetValidation();

        $this->validateForm();

        if ($this->getTotalPhotoCount() > 10) {
            $this->addError(
                'photos',
                'A destination can have a maximum of 10 photos.'
            );

            $this->showError(
                'A destination can have a maximum of 10 photos.'
            );

            return;
        }

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
            ? Str::slug($this->slug)
            : Str::slug($this->title);

        $data = [
            'category_id' => $this->category_id,

            'title' => trim($this->title),

            'slug' => $slug,

            'description' => trim($this->description),

            'things_to_do' => trim($this->things_to_do) !== ''
                ? trim($this->things_to_do)
                : null,

            'things_to_prepare' => trim($this->things_to_prepare) !== ''
                ? trim($this->things_to_prepare)
                : null,

            'address' => trim($this->address),

            'latitude' => $this->latitude !== ''
                ? $this->latitude
                : null,

            'longitude' => $this->longitude !== ''
                ? $this->longitude
                : null,

            'map_link' => trim($this->map_link) !== ''
                ? trim($this->map_link)
                : null,

            'ticket_price' => $ticketPrice,

            'contact_phone' => trim($this->contact_phone) !== ''
                ? trim($this->contact_phone)
                : null,

            'open_time' => $this->open_time !== ''
                ? $this->open_time
                : null,

            'close_time' => $this->close_time !== ''
                ? $this->close_time
                : null,

            'status' => $this->status,
        ];

        DB::beginTransaction();

        try {
            if ($this->destinationId) {
                $destination = Destination::findOrFail(
                    $this->destinationId
                );

                $destination->update($data);

                $message = 'Destination updated successfully.';
            } else {
                $data['created_by'] = Auth::id() ?? 1;

                $destination = Destination::create($data);

                $this->destinationId =
                    $destination->destination_id;

                $message = 'Destination created successfully.';
            }

            if (!empty($this->photos)) {
                $hasPrimaryImage = DestinationImage::where(
                    'destination_id',
                    $destination->destination_id
                )
                    ->where('is_primary', true)
                    ->exists();

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
                        DestinationImage::where(
                            'destination_id',
                            $destination->destination_id
                        )->update([
                            'is_primary' => false,
                        ]);

                        $isPrimary = true;
                        $hasPrimaryImage = true;
                    } elseif (
                        !$hasPrimaryImage
                        && $this->newPrimaryPhoto === null
                        && $index === 0
                    ) {
                        $isPrimary = true;
                    }

                    DestinationImage::create([
                        'destination_id' =>
                            $destination->destination_id,

                        'image_url' =>
                            Storage::url($path),

                        'is_primary' =>
                            $isPrimary,
                    ]);

                    if ($isPrimary) {
                        $hasPrimaryImage = true;
                    }
                }
            }

            DB::commit();

            $this->loadExistingPhotos();

            $this->photos = [];

            $this->newPrimaryPhoto = null;

            $this->showSuccess($message);
        } catch (\Throwable $e) {
            DB::rollBack();

            report($e);

            $this->showError($e->getMessage());
        }
    }

    public function updatedPhotos(): void
    {
        if (empty($this->photos)) {
            return;
        }

        if ($this->getTotalPhotoCount() > 10) {
            $this->photos = [];

            $this->newPrimaryPhoto = null;

            $this->showError(
                'You can upload a maximum of 10 photos for this destination.'
            );

            return;
        }

        try {
            $this->validate([
                'photos.*' => [
                    'image',
                    'mimes:jpg,jpeg,png,webp',
                    'max:5120',
                ],
            ]);
        } catch (ValidationException $e) {
            $invalidIndexes = [];

            foreach ($e->validator->errors()->keys() as $key) {
                if (
                    preg_match(
                        '/^photos\.(\d+)$/',
                        $key,
                        $matches
                    )
                ) {
                    $invalidIndexes[] = (int) $matches[1];
                }
            }

            if (!empty($invalidIndexes)) {
                foreach (
                    array_reverse($invalidIndexes)
                    as $invalidIndex
                ) {
                    unset($this->photos[$invalidIndex]);
                }

                $this->photos = array_values($this->photos);
            } else {
                $this->photos = [];
            }

            $this->newPrimaryPhoto = null;

            $this->showError(
                'One or more selected photos do not meet the requirements. Please use JPG, JPEG, PNG, or WEBP images no larger than 5 MB each.'
            );

            return;
        } catch (\Throwable $e) {
            report($e);

            $this->photos = [];

            $this->newPrimaryPhoto = null;

            $this->showError($e->getMessage());

            return;
        }

        if (
            $this->newPrimaryPhoto !== null
            && !isset(
                $this->photos[$this->newPrimaryPhoto]
            )
        ) {
            $this->newPrimaryPhoto = null;
        }
    }

    public function setNewPrimaryPhoto(int $index): void
    {
        if (!isset($this->photos[$index])) {
            return;
        }

        $this->newPrimaryPhoto = $index;
    }

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

        $this->pendingPhotoId = $imageId;

        $this->performDeleteExistingPhoto();
    }

    private function performDeleteExistingPhoto(): void
    {
        if (!$this->destinationId) {
            return;
        }

        $imageId = $this->pendingPhotoId;

        $this->pendingPhotoId = null;

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

        $imageUrl = $image->image_url ?? '';

        $path = parse_url(
            $imageUrl,
            PHP_URL_PATH
        );

        if ($path) {
            $storagePrefix = '/storage/';

            if (str_starts_with(
                $path,
                $storagePrefix
            )) {
                $storagePath = substr(
                    $path,
                    strlen($storagePrefix)
                );

                Storage::disk('public')->delete(
                    $storagePath
                );
            }
        }

        $wasPrimary = (bool) $image->is_primary;

        $image->delete();

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
                ->orderBy('image_id')
                ->first();

            if ($newPrimary) {
                $newPrimary->update([
                    'is_primary' => true,
                ]);
            }
        }

        $this->loadExistingPhotos();
    }

    public function render()
    {
        return view('livewire.admin.destinations.destination-form', [
            'categories' => Category::orderBy('name')->get(),
        ]);
    }
}
