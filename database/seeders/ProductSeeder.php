<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Products with image URLs instead of local filenames
        $products = [
            [
                'name' => 'Laptop Pro X1',
                'description' => 'High-performance laptop with 16GB RAM and 1TB SSD storage.',
                'price' => 1299.99,
                'image' => 'https://m.media-amazon.com/images/I/713-HQZrUCL._AC_SX466_.jpg',
                'stock' => 15
            ],
            [
                'name' => 'Smart Watch Series 5',
                'description' => 'Water-resistant smartwatch with heart rate monitoring and GPS.',
                'price' => 299.99,
                'image' => 'https://images.unsplash.com/photo-1546868871-7041f2a55e12?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=764&q=80',
                'stock' => 25
            ],
            [
                'name' => 'Wireless Noise-Cancelling Headphones',
                'description' => 'Premium headphones with active noise cancellation and 30-hour battery life.',
                'price' => 199.99,
                'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80',
                'stock' => 20
            ],
            [
                'name' => 'Ultra HD 4K Monitor',
                'description' => '32-inch 4K display with HDR support and adjustable stand.',
                'price' => 449.99,
                'image' => 'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80',
                'stock' => 10
            ],
            [
                'name' => 'Mechanical Gaming Keyboard',
                'description' => 'RGB backlit mechanical keyboard with customizable keys.',
                'price' => 129.99,
                'image' => 'https://locoport.ee/wp-content/uploads/2024/09/original-216.jpg',
                'stock' => 30
            ],
            [
                'name' => 'Wireless Gaming Mouse',
                'description' => 'High-precision wireless mouse with programmable buttons.',
                'price' => 79.99,
                'image' => 'https://images.unsplash.com/photo-1605773527852-c546a8584ea3?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1074&q=80',
                'stock' => 35
            ],
            [
                'name' => 'Smart Home Speaker',
                'description' => 'Voice-controlled speaker with virtual assistant integration.',
                'price' => 149.99,
                'image' => 'https://static2.nordic.pictures/29735053-product_big/google-home-assistant-smart-speaker.jpg',
                'stock' => 18
            ],
            [
                'name' => 'Portable External SSD',
                'description' => '1TB external SSD with USB-C connectivity and shock-resistant design.',
                'price' => 169.99,
                'image' => 'https://thumbor.arvutitark.ee/Le1WCHQkKeH9tn12WdwzApVblAQ=/trim/fit-in/800x800/https%3A%2F%2Fstatic.arvutitark.ee%2Fpublic%2Fmedia-hub-cms%2F2023%2F08%2F443921%2F2.webp',
                'stock' => 22
            ],
            [
                'name' => 'Digital Graphics Tablet',
                'description' => 'Pressure-sensitive drawing tablet for digital art and design.',
                'price' => 199.99,
                'image' => 'https://m.media-amazon.com/images/I/8180p9riYgL.jpg',
                'stock' => 12
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
