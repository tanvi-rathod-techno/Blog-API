<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;
use Exception;

class CommentController extends BaseController
{
    public function index(Request $request)
    {
        try {
            $blogId = $request->input('blog_id');
            if (!$blogId) {
                return $this->sendError(null,'Blog ID is required.', false, config('const.VALIDATION_ERROR_CODE'));
            }
            $comments = Comment::where('blog_id', $blogId)->with('user')->get();
            return $this->sendResponse($comments, 'Comments fetched successfully', true, config('const.SUCCESS_CODE'));
        } catch (Exception $e) {
            return $this->sendError(null, 'Failed to fetch comments. Error: ' . $e->getMessage(), false, config('const.EXCEPTION_ERROR_CODE'));
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'blog_id' => 'required|exists:blogs,id',
            'comment' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $comment = Comment::create([
                'blog_id' => $request->blog_id,
                'user_id' => auth()->id(),
                'comment' => $request->comment,
            ]);
            DB::commit();
            return $this->sendResponse($comment, 'Comment added successfully', true, config('const.SUCCESS_CODE'));
        } catch (Exception $e) {
            DB::rollback();
            return $this->sendError(null, 'Failed to add comment. Error: ' . $e->getMessage(), false, config('const.EXCEPTION_ERROR_CODE'));
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $comment = Comment::find($id);
            if (!$comment) {
                return $this->sendError(null, 'Comment not found', false, 404);
            }

            $comment->update($request->only('content'));
            DB::commit();
            return $this->sendResponse($comment, 'Comment updated successfully', true, config('const.SUCCESS_CODE'));
        } catch (Exception $e) {
            DB::rollback();
            return $this->sendError(null, 'Failed to update comment. Error: ' . $e->getMessage(), false, config('const.EXCEPTION_ERROR_CODE'));
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $comment = Comment::find($id);
            if (!$comment) {
                return $this->sendError(null, 'Comment not found', false, 404);
            }

            $comment->delete();
            DB::commit();
            return $this->sendResponse(null, 'Comment deleted successfully', true, config('const.SUCCESS_CODE'));
        } catch (Exception $e) {
            DB::rollback();
            return $this->sendError(null, 'Failed to delete comment. Error: ' . $e->getMessage(), false, config('const.EXCEPTION_ERROR_CODE'));
        }
    }
}
