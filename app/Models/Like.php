<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = [
        'blog_id',
        'user_id',
        'status',
    ];

    // A like belongs to a blog post
    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }

    // A like belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
