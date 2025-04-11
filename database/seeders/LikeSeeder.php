<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Like;

class LikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Like::insert([
            [
                'blog_id' => 1,
                'user_id' => 2,
                'status' => 'liked',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'blog_id' => 2,
                'user_id' => 1,
                'status' => 'liked',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
