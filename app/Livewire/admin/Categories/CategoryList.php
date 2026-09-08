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

    public ?int $viewingCategory = null;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->search = '';
        $this->resetPage();
    }

    public function viewCategory(int $categoryId): void
    {
        $this->viewingCategory = $categoryId;
    }

    public function closeCategoryView(): void
    {
        $this->viewingCategory = null;
    }

    public function deleteCategory(int $categoryId): void
    {
        $category = Category::withCount('destinations')
            ->findOrFail($categoryId);

        if ($category->destinations_count > 0) {
            session()->flash(
                'error',
                'This category cannot be deleted because it has destinations assigned to it.'
            );

            return;
        }

        $category->delete();

        session()->flash(
            'success',
            'Category deleted successfully.'
        );

        $this->closeCategoryView();

        $this->resetPage();
    }

    public function render()
    {
        $categories = Category::query()
            ->withCount('destinations')
            ->when(
                trim($this->search) !== '',
                function ($query) {
                    $search = trim($this->search);

                    $query->where(function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%')
                            ->orWhere(
                                'description',
                                'like',
                                '%' . $search . '%'
                            );
                    });
                }
            )
            ->orderBy('category_id', 'desc')
            ->paginate(10);

        $viewingCategoryData = null;

        if ($this->viewingCategory) {
            $viewingCategoryData = Category::with([
                'destinations' => function ($query) {
                    $query->orderBy('title');
                },
            ])->find($this->viewingCategory);
        }

        return view(
            'livewire.admin.categories.category-list',
            [
                'categories' => $categories,
                'viewingCategoryData' => $viewingCategoryData,
                'totalCategories' => Category::count(),
            ]
        );
    }
}