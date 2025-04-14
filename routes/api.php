<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });



Route::prefix('v2')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);



    Route::middleware(['auth:api'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/profile', [AuthController::class, 'viewProfile']);

     // BLOG ROUTES
     Route::post('/blogs', [BlogController::class, 'store']);
     Route::get('/blogs', [BlogController::class, 'index']);
     Route::post('/all-blogs', [BlogController::class, 'allBlogs']);
     Route::put('/blogs/{id}', [BlogController::class, 'update']);
     Route::delete('/blogs/{id}', [BlogController::class, 'destroy']);

     // COMMENT ROUTES
     Route::post('/comments', [CommentController::class, 'store']);
     Route::post('/get-comments', [CommentController::class, 'index']);

     // LIKE ROUTES
     Route::post('/likes', [LikeController::class, 'store']);
     Route::delete('/likes/{id}', [LikeController::class, 'destroy']);
    });
});
