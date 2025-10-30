<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Laptop', 'description' => 'All types of laptops'],
            ['name' => 'Smartphone', 'description' => 'Mobile phones and smartphones'],
            ['name' => 'Tablet', 'description' => 'All tablet devices'],
            ['name' => 'Desktop PC', 'description' => 'Desktop computers'],
            ['name' => 'Printer', 'description' => 'Printers and related devices'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
