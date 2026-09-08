<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class CategoryForm extends Component
{
    /*
    |--------------------------------------------------------------------------
    | Category
    |--------------------------------------------------------------------------
    */

    public ?int $categoryId = null;

    public string $name = '';

    public string $description = '';

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

    public function mount(?int $categoryId = null): void
    {
        $this->categoryId = $categoryId;

        if (!$categoryId) {
            return;
        }

        $category = Category::findOrFail($categoryId);

        $this->name = $category->name ?? '';

        $this->description = $category->description ?? '';
    }

    /*
    |--------------------------------------------------------------------------
    | Open Confirmation Popup
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

    /*
    |--------------------------------------------------------------------------
    | Close Confirmation Popup
    |--------------------------------------------------------------------------
    */

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
    | Success Popup
    |--------------------------------------------------------------------------
    */

    private function showSuccess(string $message): void
    {
        $this->alertType = 'success';

        $this->alertTitle = 'Success';

        $this->alertMessage = $message;

        $this->showAlertPopup = true;
    }

    /*
    |--------------------------------------------------------------------------
    | Error Popup
    |--------------------------------------------------------------------------
    */

    private function showError(string $message): void
    {
        $this->alertType = 'error';

        $this->alertTitle = 'Something went wrong';

        $this->alertMessage = $message;

        $this->showAlertPopup = true;
    }

    /*
    |--------------------------------------------------------------------------
    | Close Alert Popup
    |--------------------------------------------------------------------------
    */

    public function closeAlertPopup(): void
    {
        $this->showAlertPopup = false;
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

        if ($this->categoryId) {
            $this->openConfirmPopup(
                'save',
                'Update Category?',
                'Are you sure you want to save these changes to this category?',
                'Update Category'
            );

            return;
        }

        $this->openConfirmPopup(
            'save',
            'Create Category?',
            'Are you sure you want to create this new category?',
            'Create Category'
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
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'name')
                    ->ignore($this->categoryId, 'category_id'),
            ],

            'description' => [
                'nullable',
                'string',
            ],
        ]);
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
                'The category could not be saved. Please try again.'
            );
        }

        $this->confirmAction = '';

        $this->confirmTitle = '';

        $this->confirmMessage = '';

        $this->confirmButtonText = 'Confirm';
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

        $data = [
            'name' => trim($this->name),

            'description' => trim($this->description) !== ''
                ? trim($this->description)
                : null,
        ];

        /*
        |--------------------------------------------------------------------------
        | Update Existing Category
        |--------------------------------------------------------------------------
        */

        if ($this->categoryId) {
            $category = Category::findOrFail(
                $this->categoryId
            );

            $category->update($data);

            $message = 'Category updated successfully.';
        }

        /*
        |--------------------------------------------------------------------------
        | Create New Category
        |--------------------------------------------------------------------------
        */

        else {
            $category = Category::create($data);

            $this->categoryId = $category->category_id;

            $message = 'Category created successfully.';
        }

        $this->showSuccess($message);
    }

    /*
    |--------------------------------------------------------------------------
    | Render
    |--------------------------------------------------------------------------
    */

    public function render()
    {
        return view(
            'livewire.admin.categories.category-form',
            [
                /*
                |--------------------------------------------------------------------------
                | IMPORTANT:
                | Blade uses $isEditMode
                |--------------------------------------------------------------------------
                */

                'isEditMode' => $this->categoryId !== null,
            ]
        );
    }
}