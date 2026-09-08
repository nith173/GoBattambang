<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class ChangePasswordForm extends Component
{
    public string $current_password = '';

    public string $new_password = '';

    public string $new_password_confirmation = '';

    /*
    |--------------------------------------------------------------------------
    | Success / Error Popup
    |--------------------------------------------------------------------------
    */

    public bool $showAlertPopup = false;

    public string $alertType = 'success';

    public string $alertTitle = '';

    public string $alertMessage = '';

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

    public function save(): void
    {
        $this->resetValidation();

        $this->validate([
            'current_password' => ['required', 'string'],

            'new_password' => [
                'required',
                'confirmed',
                PasswordRule::min(8)->mixedCase()->numbers()->symbols(),
            ],
        ], [
            'new_password.confirmed' => 'The new password confirmation does not match.',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!Hash::check($this->current_password, $user->password_hash)) {
            $this->addError('current_password', 'Your current password is incorrect.');

            return;
        }

        try {
            $user->forceFill([
                'password_hash' => Hash::make($this->new_password),
            ])->save();

            $this->reset(['current_password', 'new_password', 'new_password_confirmation']);

            $this->showSuccess('Your password has been changed successfully.');
        } catch (\Throwable $e) {
            report($e);

            $this->showError('Your password could not be changed. Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.admin.change-password-form');
    }
}