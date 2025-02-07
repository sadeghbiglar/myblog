<?php
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;

use Illuminate\Support\Facades\Route;

Route::prefix('api')->group(function () {
    Route::apiResource('posts', PostController::class);
    Route::get('posts/{post}/comments', [CommentController::class, 'index']); // دریافت نظرات یک پست
    Route::post('posts/{post}/comments', [CommentController::class, 'store']); // ثبت نظر جدید
    Route::delete('comments/{comment}', [CommentController::class, 'destroy']); // حذف نظر
    Route::post('posts/{post}/like', [LikeController::class, 'like']); // لایک کردن
    Route::post('posts/{post}/unlike', [LikeController::class, 'unlike']); // حذف لایک
});
use App\Http\Controllers\AdminAuthController;

Route::prefix('api/admin')->group(function () {
    Route::post('register', [AdminAuthController::class, 'register']);
    Route::post('login', [AdminAuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AdminAuthController::class, 'logout']);
    });
});