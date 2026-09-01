<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class CategoryForm extends Component
{
    public ?int $categoryId = null;

    public string $name = '';
    public string $description = '';

    public bool $showConfirmPopup = false;
    public string $confirmAction = '';
    public string $confirmTitle = '';
    public string $confirmMessage = '';
    public string $confirmButtonText = 'Confirm';

    public bool $showAlertPopup = false;
    public string $alertType = 'success';
    public string $alertTitle = '';
    public string $alertMessage = '';
    public bool $redirectAfterAlert = false;

    public function mount(?int $categoryId = null): void
    {
        $this->categoryId = $categoryId;

        if ($this->categoryId) {
            $category = Category::findOrFail($this->categoryId);

            $this->name = $category->name ?? '';
            $this->description = $category->description ?? '';
        }
    }

    protected function rules(): array
{
    return [
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
            'max:1000',
        ],
    ];
}

    protected function messages(): array
{
    return [
        'name.required' => 'Category name is required.',
        'name.unique' => 'This category name already exists.',
        'name.max' => 'Category name must not exceed 255 characters.',
        'description.max' => 'Description must not exceed 1000 characters.',
    ];
}

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

    public function closeAlertPopup(): void { $this->showAlertPopup = false;
if ($this->redirectAfterAlert) {
    $this->redirectAfterAlert = false;

    $this->redirectRoute('admin.categories', navigate: true);
}
}

    public function save(): void
    {
        $this->validate();

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

    public function confirmPopupAction(): void
    {
        $action = $this->confirmAction;

        $this->closeConfirmPopup();

        try {
            if ($action === 'save') {
                $this->performSave();
            }
        } catch (\Throwable $e) {
            report($e);

            $this->showError(
                'The operation could not be completed. Please try again.'
            );
        }
    }

    private function performSave(): void
    {
        $validated = $this->validate();

        if ($this->categoryId) {
    $category = Category::findOrFail($this->categoryId);

    $category->update([
        'name' => $validated['name'],
        'description' => $validated['description'] ?: null,
    ]);

    $this->showSuccess('Category updated successfully.');
    $this->redirectAfterAlert = true;
    return;
}

        Category::create([
    'name' => $validated['name'],
    'description' => $validated['description'] ?: null,
]);

$this->redirectAfterAlert = true;

$this->showSuccess('Category created successfully.');
    }

    public function render()
    {
        return view('livewire.admin.categories.category-form');
    }
}