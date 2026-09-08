<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin')]
class ProfileForm extends Component
{
    use WithFileUploads;

    public string $first_name = '';

    public string $last_name = '';

    public string $email = '';

    public string $phone_number = '';

    /** @var \Livewire\Features\SupportFileUploads\TemporaryUploadedFile|null */
    public $newPhoto = null;

    public ?string $existingPhoto = null;

    public bool $removePhoto = false;

    /*
    |--------------------------------------------------------------------------
    | Success / Error Popup
    |--------------------------------------------------------------------------
    */

    public bool $showAlertPopup = false;

    public string $alertType = 'success';

    public string $alertTitle = '';

    public string $alertMessage = '';

    public function mount(): void
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $this->first_name = $user->first_name ?? '';

        $this->last_name = $user->last_name ?? '';

        $this->email = $user->email ?? '';

        $this->phone_number = $user->phone_number ?? '';

        $this->existingPhoto = $user->profile_picture;
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

    public function removeExistingPhoto(): void
    {
        $this->removePhoto = true;

        $this->existingPhoto = null;
    }

    public function save(): void
    {
        $this->resetValidation();

        $this->validate([
            'first_name' => ['required', 'string', 'max:50'],

            'last_name' => ['required', 'string', 'max:50'],

            'email' => [
                'required',
                'email',
                'max:150',
                Rule::unique('users', 'email')->ignore(Auth::id(), 'user_id'),
            ],

            'phone_number' => ['nullable', 'string', 'max:20'],

            'newPhoto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        try {
            /** @var \App\Models\User $user */
            $user = Auth::user();

            $oldPhotoPath = $user->profile_picture;

            $data = [
                'first_name' => trim($this->first_name),

                'last_name' => trim($this->last_name),

                'email' => trim($this->email),

                'phone_number' => trim($this->phone_number) !== ''
                    ? trim($this->phone_number)
                    : null,
            ];

            if ($this->newPhoto) {
                $path = $this->newPhoto->store('users', 'public');

                $data['profile_picture'] = Storage::url($path);
            } elseif ($this->removePhoto) {
                $data['profile_picture'] = null;
            }

            $user->update($data);

            if ($oldPhotoPath && ($this->newPhoto || $this->removePhoto)) {
                $this->deleteStoredPhoto($oldPhotoPath);
            }

            $this->newPhoto = null;

            $this->removePhoto = false;

            $this->existingPhoto = $user->profile_picture;

            $this->showSuccess('Your profile has been updated successfully.');
        } catch (\Throwable $e) {
            report($e);

            $this->showError('Your profile could not be updated. Please try again.');
        }
    }

    private function deleteStoredPhoto(string $url): void
    {
        $path = parse_url($url, PHP_URL_PATH);

        if (!$path) {
            return;
        }

        $storagePrefix = '/storage/';

        if (str_starts_with($path, $storagePrefix)) {
            Storage::disk('public')->delete(
                substr($path, strlen($storagePrefix))
            );
        }
    }

    public function render()
    {
        return view('livewire.admin.profile-form');
    }
}