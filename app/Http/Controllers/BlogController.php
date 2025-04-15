<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\Blog;
use Exception;
use DB;

class BlogController extends BaseController
{
    public function index()
    {
        try {
            $userId = auth()->id();
            $blogs = Blog::with(['user', 'likes'])
            ->where('user_id', $userId)
            ->latest()
            ->get();

            return $this->sendResponse($blogs, 'Blogs fetched successfully',true,config('const.SUCCESS_CODE'));
        } catch (Exception $ex) {
            return $this->sendError(null, 'Something went wrong while fetching blogs', false, config('const.EXCEPTION_ERROR_CODE'));
        }
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'blog_title'   => 'required|string|max:255',
            'blog_content' => 'required|string',
            'blog_tagline' => 'nullable|string',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        DB::beginTransaction();
        try {
            // Handle image upload if present
            $imagePath = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imagePath = $image->store('blogs', 'public'); // Store in 'public/blogs' folder
            }

            // Create the blog post
            $blog = Blog::create([
                'blog_title'   => $request->blog_title,
                'blog_content' => $request->blog_content,
                'blog_tagline' => $request->blog_tagline,
                'user_id'      => auth()->id(),
                'image_path'   => $imagePath, // Save the image path to the database
            ]);

            DB::commit();
            return $this->sendResponse($blog, 'Blog created successfully', true, config('const.SUCCESS_CODE'));
        } catch (Exception $ex) {
            DB::rollback();
            return $this->sendError(null, 'Failed to create blog. Error: ' . $ex->getMessage(), false, config('const.EXCEPTION_ERROR_CODE'));
        }
    }

    public function show($id)
    {
        try {
            $blog = Blog::with(['user', 'comments'])->find($id);
            if (!$blog) {
                return $this->sendError(null, 'Blog not found', false, 404);
            }
            return $this->sendResponse($blog, 'Blog fetched successfully',true,200);
        } catch (Exception $ex) {
            return $this->sendError(null, 'Something went wrong while fetching blog details', false,  config('const.EXCEPTION_ERROR_CODE'));
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $blog = Blog::find($id);
            if (!$blog) {
                return $this->sendError(null, 'Blog not found', false, 404);
            }

            $blog->update($request->only(['blog_title', 'blog_tagline', 'blog_content']));

            DB::commit();
            return $this->sendResponse($blog, 'Blog updated successfully',true,200);
        } catch (Exception $ex) {
            DB::rollback();
            return $this->sendError(null, 'Failed to update blog. Error: ' . $ex->getMessage(), false,  config('const.EXCEPTION_ERROR_CODE'));
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $blog = Blog::find($id);
            if (!$blog) {
                return $this->sendError(null, 'Blog not found', false,  config('const.NO_RECORD_CODE'));
            }

            $blog->delete();

            DB::commit();
            return $this->sendResponse(null, 'Blog deleted successfully');
        } catch (Exception $ex) {
            DB::rollback();
            return $this->sendError(null, 'Failed to delete blog. Error: ' . $ex->getMessage(), false,  config('const.EXCEPTION_ERROR_CODE'));
        }
    }


    public function allBlogs(Request $request)
    {
        try {
            $pagination = getPaginationAttributes($request);

            $blogs = Blog::with(['user', 'likes'])
                ->orderBy($pagination['sort_by'], $pagination['order'])
                ->paginate($pagination['limit'], ['*'], 'page', $pagination['page']);


            return $this->sendResponse($blogs, 'Blogs fetched successfully', true, config('const.SUCCESS_CODE'));
        } catch (Exception $ex) {
            return $this->sendError(null, 'Something went wrong while fetching all blogs', false, config('const.EXCEPTION_ERROR_CODE'));
        }
    }

}
