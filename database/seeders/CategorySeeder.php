<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::updateOrCreate(
            [
                'name' => 'Tourist Place',
            ],
            [
                'description' => 'Popular tourist destinations and attractions in Battambang.',
            ]
        );
    }
}