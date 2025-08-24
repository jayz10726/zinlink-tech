<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Review;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reviews = [
            [
                'customer_name' => 'John Doe',
                'service_used' => 'Laptop Repair',
                'rating' => 5,
                'comment' => 'Excellent service! My laptop was fixed quickly and the staff was very professional. Highly recommend!',
                'status' => 'approved'
            ],
            [
                'customer_name' => 'Sarah Johnson',
                'service_used' => 'CCTV Installation',
                'rating' => 4,
                'comment' => 'Great installation service. The team was knowledgeable and completed the work on time. Very satisfied with the quality.',
                'status' => 'approved'
            ],
            [
                'customer_name' => 'Mike Wilson',
                'service_used' => 'MacBook Repair',
                'rating' => 5,
                'comment' => 'Outstanding service! Fixed my MacBook screen issue in just a few hours. Professional and reliable.',
                'status' => 'approved'
            ],
            [
                'customer_name' => 'Emily Davis',
                'service_used' => 'Laptop Maintenance',
                'rating' => 4,
                'comment' => 'Good maintenance service. My laptop runs much faster now. Would use their services again.',
                'status' => 'pending'
            ],
            [
                'customer_name' => 'David Brown',
                'service_used' => 'Gaming Laptop Setup',
                'rating' => 3,
                'comment' => 'Service was okay, but took longer than expected. The setup was done correctly though.',
                'status' => 'pending'
            ],
            [
                'customer_name' => 'Lisa Anderson',
                'service_used' => 'Data Recovery',
                'rating' => 5,
                'comment' => 'Amazing data recovery service! Recovered all my important files. Very grateful for their expertise.',
                'status' => 'approved'
            ],
            [
                'customer_name' => 'Robert Taylor',
                'service_used' => 'Network Setup',
                'rating' => 4,
                'comment' => 'Professional network setup service. Everything works perfectly. Good communication throughout the process.',
                'status' => 'approved'
            ],
            [
                'customer_name' => 'Jennifer White',
                'service_used' => 'Software Installation',
                'rating' => 2,
                'comment' => 'Service was not up to expectations. Software installation took too long and had some issues.',
                'status' => 'rejected'
            ],
            [
                'customer_name' => 'Thomas Lee',
                'service_used' => 'Hardware Upgrade',
                'rating' => 5,
                'comment' => 'Excellent hardware upgrade service! My laptop is now much faster. Professional work and good value.',
                'status' => 'approved'
            ],
            [
                'customer_name' => 'Amanda Garcia',
                'service_used' => 'Virus Removal',
                'rating' => 4,
                'comment' => 'Quick and effective virus removal service. My computer is clean and running smoothly again.',
                'status' => 'pending'
            ]
        ];

        foreach ($reviews as $review) {
            Review::create($review);
        }
    }
} 