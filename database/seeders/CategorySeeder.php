<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Electronics', 'image' => 'https://images.unsplash.com/photo-1498049794561-7780e7231661?w=150&h=150&fit=crop'],
            ['name' => 'Clothing', 'image' => 'https://images.unsplash.com/photo-1489987707025-afc232f7ea0f?w=150&h=150&fit=crop'],
            ['name' => 'Books', 'image' => 'https://images.unsplash.com/photo-1512820790803-83ca734da794?w=150&h=150&fit=crop'],
            ['name' => 'Home & Garden', 'image' => 'https://images.unsplash.com/photo-1484101403633-562f891dc89a?w=150&h=150&fit=crop'],
            ['name' => 'Sports', 'image' => 'https://images.unsplash.com/photo-1461896836934- voices-1?w=150&h=150&fit=crop'],
            ['name' => 'Toys', 'image' => 'https://images.unsplash.com/photo-1558060370-d644479cb6f7?w=150&h=150&fit=crop'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
