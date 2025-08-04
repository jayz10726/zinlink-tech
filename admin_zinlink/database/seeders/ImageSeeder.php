<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Image;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hero carousel images
        $heroImages = [
            [
                'name' => 'Laptop Computer',
                'description' => 'Modern laptop computer for work and productivity',
                'image_url' => 'https://images.pexels.com/photos/7974/pexels-photo.jpg?auto=compress&cs=tinysrgb&w=800&h=600&dpr=1',
                'category' => 'hero',
                'alt_text' => 'Laptop Computer',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Computer Repair',
                'description' => 'Professional computer repair and maintenance services',
                'image_url' => 'https://images.pexels.com/photos/7681091/pexels-photo-7681091.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
                'category' => 'hero',
                'alt_text' => 'Computer Repair Service',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'CCTV Camera',
                'description' => 'Security camera installation and monitoring',
                'image_url' => 'https://images.pexels.com/photos/4484078/pexels-photo-4484078.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
                'category' => 'hero',
                'alt_text' => 'CCTV Security Camera',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'MacBook Pro',
                'description' => 'High-performance laptop for professionals',
                'image_url' => 'https://images.pexels.com/photos/1181467/pexels-photo-1181467.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
                'category' => 'hero',
                'alt_text' => 'MacBook Pro Laptop',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Gaming Monitor',
                'description' => 'Curved gaming monitor for immersive experience',
                'image_url' => 'https://images.pexels.com/photos/1029243/pexels-photo-1029243.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
                'category' => 'hero',
                'alt_text' => 'Curved Gaming Monitor',
                'sort_order' => 5,
                'is_active' => true,
            ],
        ];

        // Product images
        $productImages = [
            [
                'name' => 'ZINBook Pro X1',
                'description' => 'Ultrabook laptop with OLED display',
                'image_url' => 'https://images.pexels.com/photos/18105/pexels-photo.jpg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
                'category' => 'product',
                'alt_text' => 'ZINBook Pro X1 Ultrabook',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'ZINBook Gaming Ultra',
                'description' => 'High-performance gaming laptop',
                'image_url' => 'https://images.pexels.com/photos/1029757/pexels-photo-1029757.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
                'category' => 'product',
                'alt_text' => 'ZINBook Gaming Ultra',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'ZINBook Air S',
                'description' => 'Lightweight ultrabook for mobility',
                'image_url' => 'https://images.pexels.com/photos/7974/pexels-photo.jpg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
                'category' => 'product',
                'alt_text' => 'ZINBook Air S',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'ZINBook Pro Workstation',
                'description' => 'Professional workstation laptop',
                'image_url' => 'https://images.pexels.com/photos/303383/pexels-photo-303383.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
                'category' => 'product',
                'alt_text' => 'ZINBook Pro Workstation',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'ZINBook Flex 360',
                'description' => '2-in-1 convertible laptop',
                'image_url' => 'https://images.pexels.com/photos/1229861/pexels-photo-1229861.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
                'category' => 'product',
                'alt_text' => 'ZINBook Flex 360',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'ZINBook Essential',
                'description' => 'Budget-friendly laptop',
                'image_url' => 'https://images.pexels.com/photos/459654/pexels-photo-459654.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
                'category' => 'product',
                'alt_text' => 'ZINBook Essential',
                'sort_order' => 6,
                'is_active' => true,
            ],
            [
                'name' => 'ZINBook Business Elite',
                'description' => 'Business professional laptop',
                'image_url' => 'https://images.pexels.com/photos/669228/pexels-photo-669228.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
                'category' => 'product',
                'alt_text' => 'ZINBook Business Elite',
                'sort_order' => 7,
                'is_active' => true,
            ],
            [
                'name' => 'ZINBook Creator Pro',
                'description' => 'Content creation laptop',
                'image_url' => 'https://images.pexels.com/photos/40185/mac-freelancer-macintosh-macbook-40185.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
                'category' => 'product',
                'alt_text' => 'ZINBook Creator Pro',
                'sort_order' => 8,
                'is_active' => true,
            ],
        ];

        // Insert hero images
        foreach ($heroImages as $image) {
            Image::create($image);
        }

        // Insert product images
        foreach ($productImages as $image) {
            Image::create($image);
        }

        $this->command->info('Images seeded successfully!');
        $this->command->info('Hero images: ' . count($heroImages));
        $this->command->info('Product images: ' . count($productImages));
    }
}
