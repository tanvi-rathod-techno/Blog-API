<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\Like;

class LikeController extends BaseController
{
    public function store(Request $request)
    {
        $request->validate([
            'blog_id' => 'required|exists:blogs,id',
        ]);

        $like = Like::firstOrCreate([
            'blog_id' => $request->blog_id,
            'user_id' => auth()->id(),
        ]);

        return $this->sendResponse($like, 'Post liked successfully');
    }

    public function destroy($blogId)
    {
        $like = Like::where('blog_id', $blogId)
                    ->where('user_id', auth()->id())
                    ->first();

        if (!$like) {
            return $this->sendError(null, 'Like not found', false, 404);
        }

        $like->delete();
        return $this->sendResponse(null, 'Like removed successfully');
    }
}
