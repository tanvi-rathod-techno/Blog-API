<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Blog extends Model
{
    use HasFactory;
    protected $fillable = [
        'blog_title',
        'user_id',
        'blog_tagline',
        'blog_content',
        'status',
    ];

    protected $appends = ['total_likes', 'liked_by_user', 'total_comments'];


    public function getTotalLikesAttribute()
    {
        return $this->likes()->count();
    }

    public function getLikedByUserAttribute()
    {
        $userId = auth()->id();


        return $this->likes()->where('user_id', $userId)->exists();
    }

    public function getTotalCommentsAttribute()
    {
        return $this->comments()->count();
    }


     // A blog belongs to a user (author)
     public function user()
     {
         return $this->belongsTo(User::class);
     }

     // A blog has many comments
     public function comments()
     {
         return $this->hasMany(Comment::class);
     }

     // A blog has many likes
     public function likes()
     {
         return $this->hasMany(Like::class);
     }

}
