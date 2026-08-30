<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class CategoryList extends Component
{
    use WithPagination;

    public string $search = '';
    public string $sort = 'newest';
    public bool $showConfirmPopup = false;
    public string $confirmAction = '';
    public string $confirmTitle = '';
    public string $confirmMessage = '';
    public string $confirmButtonText = 'Confirm';

    public bool $showAlertPopup = false;
    public string $alertType = 'success';
    public string $alertTitle = '';
    public string $alertMessage = '';

    public ?int $selectedCategoryId = null;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }
    public function updatingSort(): void
    {
        $this->resetPage();
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
        $this->selectedCategoryId = null;
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

    public function confirmDelete(int $categoryId): void
    {
        $category = Category::withCount('destinations')->findOrFail($categoryId);

        if ($category->destinations_count > 0) {
            $this->showError(
                'This category cannot be deleted because it is being used by one or more destinations.'
            );
            return;
        }

        $this->selectedCategoryId = $categoryId;

        $this->openConfirmPopup(
            'delete',
            'Delete Category?',
            'Are you sure you want to delete this category? This action cannot be undone.',
            'Delete Category'
        );
    }

    public function confirmPopupAction(): void
    {
        $action = $this->confirmAction;
        $categoryId = $this->selectedCategoryId;

        $this->closeConfirmPopup();

        try {
            if ($action === 'delete' && $categoryId) {
                $this->performDelete($categoryId);
            }
        } catch (\Throwable $e) {
            report($e);

            $this->showError(
                'The operation could not be completed. Please try again.'
            );
        }
    }

    private function performDelete(int $categoryId): void
    {
        $category = Category::withCount('destinations')->findOrFail($categoryId);

        if ($category->destinations_count > 0) {
            $this->showError(
                'This category cannot be deleted because it is being used by one or more destinations.'
            );
            return;
        }

        $category->delete();

        $this->showSuccess('Category deleted successfully.');

        $this->resetPage();
    }

    public function render()
    {
        $totalCategories = Category::count();

$totalDestinations = Category::withCount('destinations')
    ->get()
    ->sum('destinations_count');

$categoriesWithDestinations = Category::has('destinations')->count();
        $categories = Category::withCount('destinations')
            ->when($this->search !== '', function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery
                        ->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->sort === 'newest', fn ($query) => $query->orderByDesc('category_id'))
            ->when($this->sort === 'oldest', fn ($query) => $query->orderBy('category_id'))
            ->when($this->sort === 'name_asc', fn ($query) => $query->orderBy('name'))
            ->when($this->sort === 'name_desc', fn ($query) => $query->orderByDesc('name'))
            ->when($this->sort === 'most_destinations', fn ($query) => $query->orderByDesc('destinations_count'))
            ->paginate(10);

        return view('livewire.admin.categories.category-list', [
    'categories' => $categories,
    'totalCategories' => $totalCategories,
    'totalDestinations' => $totalDestinations,
    'categoriesWithDestinations' => $categoriesWithDestinations,
]);
    }
}