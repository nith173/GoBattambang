<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class CategoryList extends Component
{
    public function render()
    {
        $categories = Category::withCount('destinations')
            ->orderBy('category_id')
            ->get();

        return view(
            'livewire.admin.categories.category-list',
            [
                'categories' => $categories,
            ]
        );
    }
}