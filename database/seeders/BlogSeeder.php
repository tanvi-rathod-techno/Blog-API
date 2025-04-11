<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Blog;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Blog::insert([
            [
                'blog_title' => 'First Blog Post',
                'user_id' => 1,
                'blog_tagline' => 'A short tagline for blog 1',
                'blog_content' => 'This is the content of the first blog post.',
                'status' => 'published',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'blog_title' => 'Second Blog Post',
                'user_id' => 2,
                'blog_tagline' => 'Another short tagline',
                'blog_content' => 'This is the second blog post content.',
                'status' => 'draft',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
