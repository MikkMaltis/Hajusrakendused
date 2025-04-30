<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Laptop Pro X1',
                'description' => 'High-performance laptop with 16GB RAM and 1TB SSD storage.',
                'price' => 1299.99,
                'image' => 'product.jpg', // Replace with your actual image name
                'stock' => 15
            ],
            [
                'name' => 'Smart Watch Series 5',
                'description' => 'Water-resistant smartwatch with heart rate monitoring and GPS.',
                'price' => 299.99,
                'image' => 'product.jpg',
                'stock' => 25
            ],
            [
                'name' => 'Wireless Noise-Cancelling Headphones',
                'description' => 'Premium headphones with active noise cancellation and 30-hour battery life.',
                'price' => 199.99,
                'image' => 'product.jpg',
                'stock' => 20
            ],
            [
                'name' => 'Ultra HD 4K Monitor',
                'description' => '32-inch 4K display with HDR support and adjustable stand.',
                'price' => 449.99,
                'image' => 'product.jpg',
                'stock' => 10
            ],
            [
                'name' => 'Mechanical Gaming Keyboard',
                'description' => 'RGB backlit mechanical keyboard with customizable keys.',
                'price' => 129.99,
                'image' => 'product.jpg',
                'stock' => 30
            ],
            [
                'name' => 'Wireless Gaming Mouse',
                'description' => 'High-precision wireless mouse with programmable buttons.',
                'price' => 79.99,
                'image' => 'product.jpg',
                'stock' => 35
            ],
            [
                'name' => 'Smart Home Speaker',
                'description' => 'Voice-controlled speaker with virtual assistant integration.',
                'price' => 149.99,
                'image' => 'product.jpg',
                'stock' => 18
            ],
            [
                'name' => 'Portable External SSD',
                'description' => '1TB external SSD with USB-C connectivity and shock-resistant design.',
                'price' => 169.99,
                'image' => 'product.jpg',
                'stock' => 22
            ],
            [
                'name' => 'Digital Graphics Tablet',
                'description' => 'Pressure-sensitive drawing tablet for digital art and design.',
                'price' => 199.99,
                'image' => 'product.jpg',
                'stock' => 12
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
