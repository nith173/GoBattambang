<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Destination;
use App\Models\User;

class DestinationSeeder extends Seeder
{
    public function run(): void
    {
        // Get the existing category
        $category = Category::where('name', 'Tourist Place')->first();

        // Get an existing admin user
        $admin = User::where('role', 'admin')->first();

        // Stop if the required records don't exist
        if (!$category) {
            throw new \Exception(
                'Tourist Place category not found. Run CategorySeeder first.'
            );
        }

        if (!$admin) {
            throw new \Exception(
                'Admin user not found. Create an admin user first.'
            );
        }

        Destination::updateOrCreate(
            [
                'slug' => 'phnom-sampov',
            ],
            [
                'category_id' => $category->category_id,
                'created_by' => $admin->user_id,

                'title' => 'Phnom Sampov',

                'description' =>
                    'Phnom Sampov is a popular mountain destination in Battambang Province known for its scenic views, temples, caves, and cultural attractions.',

                'things_to_do' =>
                    'Visit the temples, explore the caves, enjoy the mountain scenery, and watch the bats emerge at sunset.',

                'things_to_prepare' =>
                    'Comfortable shoes, drinking water, sun protection, and a camera.',

                'address' =>
                    'Phnom Sampov, Battambang Province, Cambodia',

                'latitude' => 12.8650000,

                'longitude' => 103.9820000,

                'map_link' =>
                    'https://www.google.com/maps',

                'ticket_price' => 3.00,

                'contact_phone' => null,

                'open_time' => '07:00:00',

                'close_time' => '18:00:00',

                'status' => 'active',
            ]
        );
    }
}