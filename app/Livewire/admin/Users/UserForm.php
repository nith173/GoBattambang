<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin')]
class UserForm extends Component
{
    use WithFileUploads;

    /*
    |--------------------------------------------------------------------------
    | User
    |--------------------------------------------------------------------------
    */

    public ?int $userId = null;
    public string $first_name = '';
    public string $last_name = '';
    public string $email = '';
    public string $phone_number = '';

    /*
    |--------------------------------------------------------------------------
    | Credentials
    |--------------------------------------------------------------------------
    |
    | - Creating a user: admin sets an initial password directly.
    | - Editing a user: no raw password field -- sendPasswordResetLink()
    |   emails the user a reset link on demand instead.
    |
    */

    public string $password = '';
    public string $password_confirmation = '';
    public ?string $lastPasswordResetSentAt = null;

    /*
    |--------------------------------------------------------------------------
    | Role & Status
    |--------------------------------------------------------------------------
    */

    public string $role = 'registered';
    public string $account_status = 'active';

    /*
    |--------------------------------------------------------------------------
    | Profile Picture
    |--------------------------------------------------------------------------
    */

    /** @var \Livewire\Features\SupportFileUploads\TemporaryUploadedFile|null */
    public $profilePicture = null;
    public ?string $existingProfilePicture = null;
    public bool $removeExistingProfilePicture = false;

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

    public function mount(?int $userId = null): void
    {
        $this->userId = $userId;

        if (!$userId) {
            return;
        }

        $user = User::findOrFail($userId);

        $this->first_name = $user->first_name ?? '';
        $this->last_name = $user->last_name ?? '';
        $this->email = $user->email ?? '';
        $this->phone_number = $user->phone_number ?? '';

        $this->role = $user->role ?? 'registered';
        $this->account_status = $user->account_status ?? 'active';

        $this->existingProfilePicture = $user->profile_picture;
    }

    /*
    |--------------------------------------------------------------------------
    | Confirmation Popup
    |--------------------------------------------------------------------------
    |
    | Used ONLY when saving/creating/updating the user.
    | Removing the profile picture does NOT use confirmation.
    |
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

            $this->showError(
                'The operation could not be completed. Please try again.'
            );
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

        if ($this->userId) {
            $this->openConfirmPopup(
                'save',
                'Update User?',
                'Are you sure you want to save these changes to this user?',
                'Update User'
            );

            return;
        }

        $this->openConfirmPopup(
            'save',
            'Create User?',
            'Are you sure you want to create this new user?',
            'Create User'
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
            'first_name' => [
                'required',
                'string',
                'max:50',
            ],

            'last_name' => [
                'required',
                'string',
                'max:50',
            ],

            'email' => [
                'required',
                'email',
                'max:150',
                Rule::unique('users', 'email')->ignore($this->userId, 'user_id'),
            ],

            'phone_number' => [
                'nullable',
                'string',
                'max:20',
            ],

            'role' => [
                'required',
                'in:registered,manager,admin',
            ],

            'account_status' => [
                'required',
                'in:active,suspended,banned',
            ],

            'profilePicture' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Credentials (Create Only)
        |--------------------------------------------------------------------------
        |
        | Only validated when creating a new user. Editing a user never
        | touches the password here (see sendPasswordResetLink()).
        |
        */

        if (!$this->userId) {
            $this->validate([
                'password' => [
                    'required',
                    'string',
                    'min:8',
                ],
            ]);

            if ($this->password !== $this->password_confirmation) {
                $this->addError(
                    'password_confirmation',
                    'Password confirmation does not match.'
                );

                throw ValidationException::withMessages([
                    'password_confirmation' =>
                        'Password confirmation does not match.',
                ]);
            }
        }
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

        /*
        |--------------------------------------------------------------------------
        | User Data
        |--------------------------------------------------------------------------
        */

        $data = [
            'first_name' => trim($this->first_name),

            'last_name' => trim($this->last_name),

            'email' => trim($this->email),

            'phone_number' => trim($this->phone_number) !== ''
                ? trim($this->phone_number)
                : null,

            'role' => $this->role,

            'account_status' => $this->account_status,
        ];

        $isNewUser = !$this->userId;

        if ($isNewUser) {
            // Admin sets the initial password directly when creating a user.
            $data['password_hash'] = Hash::make($this->password);
        }

        DB::beginTransaction();

        try {
            /*
            |--------------------------------------------------------------------------
            | Create / Update User
            |--------------------------------------------------------------------------
            */

            if (!$isNewUser) {
                $user = User::findOrFail($this->userId);

                $user->update($data);

                $changedFields = array_keys($user->getChanges());

                $message = 'User updated successfully.';
            } else {
                $user = User::create($data);

                $this->userId = $user->user_id;

                $changedFields = array_keys($data);

                $message = 'User created successfully.';
            }

            /*
            |--------------------------------------------------------------------------
            | Remove Existing Profile Picture
            |--------------------------------------------------------------------------
            */

            if ($this->removeExistingProfilePicture && $this->existingProfilePicture) {
                $this->deleteStoredFile($this->existingProfilePicture);

                $user->update(['profile_picture' => null]);

                $this->existingProfilePicture = null;

                $changedFields[] = 'profile_picture';
            }

            /*
            |--------------------------------------------------------------------------
            | Upload New Profile Picture
            |--------------------------------------------------------------------------
            */

            if ($this->profilePicture) {
                /*
                |--------------------------------------------------------------------------
                | Remove Old Photo Before Storing New One
                |--------------------------------------------------------------------------
                */

                if ($this->existingProfilePicture) {
                    $this->deleteStoredFile($this->existingProfilePicture);
                }

                $path = $this->profilePicture->store(
                    'users',
                    'public'
                );

                $user->update([
                    'profile_picture' => Storage::url($path),
                ]);

                $this->existingProfilePicture = Storage::url($path);

                $changedFields[] = 'profile_picture';
            }

            /*
            |--------------------------------------------------------------------------
            | Audit Trail
            |--------------------------------------------------------------------------
            */

            $this->logAuditEntry(
                $isNewUser ? 'user_created' : 'user_updated',
                $user->user_id,
                array_values(array_unique($changedFields))
            );

            DB::commit();

            /*
            |--------------------------------------------------------------------------
            | Reset Password Fields & New Photo State
            |--------------------------------------------------------------------------
            */

            $this->password = '';
            $this->password_confirmation = '';
            $this->profilePicture = null;
            $this->removeExistingProfilePicture = false;

            /*
            |--------------------------------------------------------------------------
            | Success
            |--------------------------------------------------------------------------
            */

            $this->showSuccess($message);
        } catch (\Throwable $e) {
            DB::rollBack();

            report($e);

            $this->showError(
                'The user could not be saved. Please try again.'
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Send Password Reset Link
    |--------------------------------------------------------------------------
    |
    | Admins can never view or set a raw password. This sends the user a
    | reset link via Laravel's standard password broker instead.
    |
    */

    public function sendPasswordResetLink(): void
    {
        if (!$this->userId) {
            return;
        }

        try {
            $user = User::findOrFail($this->userId);

            $status = Password::sendResetLink(['email' => $user->email]);

            if ($status !== Password::RESET_LINK_SENT) {
                $this->showError(__($status));

                return;
            }

            $this->lastPasswordResetSentAt = now()->format('M d, Y g:i A');

            $this->logAuditEntry('password_reset_requested', $user->user_id, ['email']);

            $this->showSuccess("A password reset link has been sent to {$user->email}.");
        } catch (\Throwable $e) {
            report($e);

            $this->showError(
                'The reset link could not be sent. Please try again.'
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Audit Log
    |--------------------------------------------------------------------------
    |
    | Records admin_id, timestamp, and which fields changed for every
    | administrative edit. Requires an `audit_logs` table:
    |
    |   Schema::create('audit_logs', function (Blueprint $table) {
    |       $table->id();
    |       $table->unsignedBigInteger('admin_id')->nullable();
    |       $table->unsignedBigInteger('target_user_id')->nullable();
    |       $table->string('action');
    |       $table->json('changed_fields')->nullable();
    |       $table->timestamp('created_at')->useCurrent();
    |   });
    |
    | Adjust table/column names to match your schema. Wrapped in try/catch
    | so a missing table doesn't block the admin's actual save/reset.
    |
    */

    private function logAuditEntry(string $action, ?int $targetUserId, array $changedFields = []): void
    {
        try {
            DB::table('audit_logs')->insert([
                'admin_id' => Auth::id(),
                'target_user_id' => $targetUserId,
                'action' => $action,
                'changed_fields' => json_encode($changedFields),
                'created_at' => now(),
            ]);
        } catch (\Throwable $e) {
            report($e);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Stored File
    |--------------------------------------------------------------------------
    */

    private function deleteStoredFile(string $fileUrl): void
    {
        $path = parse_url(
            $fileUrl,
            PHP_URL_PATH
        );

        if (!$path) {
            return;
        }

        $storagePrefix = '/storage/';

        if (str_starts_with($path, $storagePrefix)) {
            $storagePath = substr(
                $path,
                strlen($storagePrefix)
            );

            Storage::disk('public')->delete($storagePath);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Profile Picture Updated
    |--------------------------------------------------------------------------
    |
    | Valid photo:
    | - No success popup
    | - No confirmation popup
    |
    | Invalid photo:
    | - Error popup
    |
    */

    public function updatedProfilePicture(): void
    {
        if (!$this->profilePicture) {
            return;
        }

        try {
            $this->validate([
                'profilePicture' => [
                    'image',
                    'mimes:jpg,jpeg,png,webp',
                    'max:5120',
                ],
            ]);
        } catch (ValidationException $e) {
            $this->profilePicture = null;

            $this->showUploadError();

            return;
        } catch (\Throwable $e) {
            report($e);

            $this->profilePicture = null;

            $this->showUploadError();

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | A newly chosen photo replaces any "remove existing" request.
        |--------------------------------------------------------------------------
        */

        $this->removeExistingProfilePicture = false;
    }

    /*
    |--------------------------------------------------------------------------
    | Remove New Photo (Before Saving)
    |--------------------------------------------------------------------------
    */

    public function removeNewPhoto(): void
    {
        $this->profilePicture = null;
    }

    /*
    |--------------------------------------------------------------------------
    | Mark Existing Photo For Removal
    |--------------------------------------------------------------------------
    |
    | IMPORTANT:
    | Only takes effect once the form is saved.
    | No confirmation popup.
    | No success popup.
    |
    */

    public function markExistingPhotoForRemoval(): void
    {
        $this->removeExistingProfilePicture = true;
        $this->profilePicture = null;
    }

    /*
    |--------------------------------------------------------------------------
    | Undo Removing Existing Photo
    |--------------------------------------------------------------------------
    */

    public function undoRemoveExistingPhoto(): void
    {
        $this->removeExistingProfilePicture = false;
    }

    /*
    |--------------------------------------------------------------------------
    | Render
    |--------------------------------------------------------------------------
    */

    public function render()
    {
        return view(
            'livewire.admin.users.user-form',
            [
                'isEditing' =>
                    $this->userId !== null,
            ]
        );
    }
}