<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();

        $products = [
            [
                'name' => 'Premium Wireless Headphones',
                'price' => 299.99,
                'discount' => 15,
                'description' => 'High-quality wireless headphones with noise cancellation and 30-hour battery life.',
                'stock' => 50,
                'featured' => true,
                'category' => 'Electronics',
                'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=300&h=300&fit=crop'
            ],
            [
                'name' => 'Smart Watch Pro',
                'price' => 199.99,
                'discount' => 10,
                'description' => 'Feature-rich smartwatch with health tracking, GPS, and water resistance.',
                'stock' => 30,
                'featured' => true,
                'category' => 'Electronics',
                'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=300&h=300&fit=crop'
            ],
            [
                'name' => 'Laptop Stand',
                'price' => 49.99,
                'discount' => 0,
                'description' => 'Ergonomic aluminum laptop stand for better posture and cooling.',
                'stock' => 100,
                'featured' => false,
                'category' => 'Electronics',
                'image' => 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=300&h=300&fit=crop'
            ],
            [
                'name' => 'Cotton T-Shirt',
                'price' => 29.99,
                'discount' => 0,
                'description' => 'Comfortable 100% cotton t-shirt available in multiple colors.',
                'stock' => 200,
                'featured' => false,
                'category' => 'Clothing',
                'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=300&h=300&fit=crop'
            ],
            [
                'name' => 'Designer Leather Bag',
                'price' => 159.99,
                'discount' => 20,
                'description' => 'Classic fit denim jeans made from premium quality fabric.',
                'stock' => 80,
                'featured' => true,
                'category' => 'Clothing',
                'image' => 'https://images.unsplash.com/photo-1542272604-787c3835535d?w=300&h=300&fit=crop'
            ],
            [
                'name' => 'Running Shoes Elite',
                'price' => 129.99,
                'discount' => 0,
                'description' => 'Lightweight running shoes with advanced cushioning technology.',
                'stock' => 60,
                'featured' => true,
                'category' => 'Sports',
                'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=300&h=300&fit=crop'
            ],
            [
                'name' => 'Yoga Mat Premium',
                'price' => 49.99,
                'discount' => 25,
                'description' => 'Non-slip yoga mat with extra cushioning for comfort.',
                'stock' => 150,
                'featured' => false,
                'category' => 'Sports',
                'image' => 'https://images.unsplash.com/photo-1601925260368-ae2f83cf8b7f?w=300&h=300&fit=crop'
            ],
            [
                'name' => 'Bestseller Novel',
                'price' => 19.99,
                'discount' => 0,
                'description' => 'Award-winning novel that captivated millions of readers worldwide.',
                'stock' => 300,
                'featured' => true,
                'category' => 'Books',
                'image' => 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=300&h=300&fit=crop'
            ],
            [
                'name' => 'Programming Guide',
                'price' => 44.99,
                'discount' => 0,
                'description' => 'Comprehensive guide to modern programming practices and techniques.',
                'stock' => 100,
                'featured' => false,
                'category' => 'Books',
                'image' => 'https://images.unsplash.com/photo-1532012197267-da84d127e765?w=300&h=300&fit=crop'
            ],
            [
                'name' => 'Garden Tool Set',
                'price' => 59.99,
                'discount' => 0,
                'description' => 'Complete set of essential gardening tools for beginners and experts.',
                'stock' => 40,
                'featured' => false,
                'category' => 'Home & Garden',
                'image' => 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=300&h=300&fit=crop'
            ],
            [
                'name' => 'Plant Pot',
                'price' => 24.99,
                'discount' => 0,
                'description' => 'Elegant ceramic plant pot perfect for indoor plants.',
                'stock' => 120,
                'featured' => false,
                'category' => 'Home & Garden',
                'image' => 'https://images.unsplash.com/photo-1485955900006-10f4d324d411?w=300&h=300&fit=crop'
            ],
            [
                'name' => 'Portable Speaker',
                'price' => 79.99,
                'discount' => 0,
                'description' => 'Creative building blocks set with 500 pieces for endless fun.',
                'stock' => 90,
                'featured' => false,
                'category' => 'Electronics',
                'image' => 'https://images.unsplash.com/photo-1587654780291-39c9404d746b?w=300&h=300&fit=crop'
            ],
        ];

        foreach ($products as $productData) {
            $category = $categories->where('name', $productData['category'])->first();
            
            Product::create([
                'name' => $productData['name'],
                'price' => $productData['price'],
                'discount' => $productData['discount'],
                'description' => $productData['description'],
                'stock' => $productData['stock'],
                'featured' => $productData['featured'],
                'image' => $productData['image'],
                'category_id' => $category->id,
            ]);
        }
    }
}
