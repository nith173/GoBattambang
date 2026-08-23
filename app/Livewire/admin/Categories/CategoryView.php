<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class CategoryView extends Component
{
    public Category $category;

    public function mount(int $categoryId): void
    {
        $this->category = Category::with([
            'destinations' => function ($query) {
                $query->orderBy('title');
            },
        ])->findOrFail($categoryId);
    }

    public function render()
    {
        return view('livewire.admin.categories.category-view');
    }
}
