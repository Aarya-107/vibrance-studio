<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Photo;
use App\Models\Inquiry;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $photos = [
            ['title' => 'Golden Hour', 'author' => 'V. CHEN', 'category' => 'portrait', 'image_path' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=900', 'is_featured' => true],
            ['title' => 'Arctic Dawn', 'author' => 'M. TORRES', 'category' => 'landscape', 'image_path' => 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=900', 'is_featured' => true],
            ['title' => 'Neon Geometry', 'author' => 'K. RASHID', 'category' => 'urban', 'image_path' => 'https://images.unsplash.com/photo-1480714378408-67cf0d13bc1b?w=900', 'is_featured' => true],
            ['title' => 'Refraction', 'author' => 'S. NOVA', 'category' => 'abstract', 'image_path' => 'https://images.unsplash.com/photo-1541701494587-cb58502866ab?w=900', 'is_featured' => true],
            ['title' => 'Silhouette', 'author' => 'V. CHEN', 'category' => 'portrait', 'image_path' => 'https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?w=900', 'is_featured' => false],
            ['title' => 'Desert Flame', 'author' => 'M. TORRES', 'category' => 'landscape', 'image_path' => 'https://images.unsplash.com/photo-1509316975850-ff9c5deb0cd9?w=900', 'is_featured' => false],
            ['title' => 'Grid City', 'author' => 'K. RASHID', 'category' => 'urban', 'image_path' => 'https://images.unsplash.com/photo-1449824913935-59a10b8d2000?w=1200', 'is_featured' => false],
            ['title' => 'Liquid Chrome', 'author' => 'S. NOVA', 'category' => 'abstract', 'image_path' => 'https://images.unsplash.com/photo-1550859492-d5da9d8e45f3?w=1200', 'is_featured' => false],
        ];

        foreach ($photos as $photo) {
            Photo::create($photo);
        }

        Inquiry::create([
            'first_name' => 'Harsh',
            'last_name' => '',
            'email' => 'harsh@example.com',
            'service' => 'Portrait Session',
            'message' => 'I would like to book a session.',
            'status' => 'new'
        ]);

        Inquiry::create([
            'first_name' => 'Aarya',
            'last_name' => '',
            'email' => 'aarya@example.com',
            'service' => 'Commercial Shoot',
            'message' => 'Looking for commercial work.',
            'status' => 'replied'
        ]);

        \App\Models\User::create([
            'name' => 'Harsh',
            'email' => 'harsh@vibrance.studio',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
        ]);

        \App\Models\User::create([
            'name' => 'Aarya',
            'email' => 'aarya@vibrance.studio',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
        ]);
    }
}
