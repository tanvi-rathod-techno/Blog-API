<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Comment;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Comment::insert([
            [
                'blog_id' => 1,
                'user_id' => 2,
                'comment' => 'Great post! Very informative.',
                'status' => 'approved',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'blog_id' => 2,
                'user_id' => 1,
                'comment' => 'Interesting thoughts.',
                'status' => 'approved',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
