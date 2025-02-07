<?php
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;

use Illuminate\Support\Facades\Route;

Route::prefix('api')->group(function () {
    Route::apiResource('posts', PostController::class);
    
    Route::get('posts/{post}/comments', [CommentController::class, 'index']); // دریافت نظرات یک پست
    Route::post('posts/{post}/comments', [CommentController::class, 'store']); // ثبت نظر جدید

      // مسیرهای زیر فقط برای ادمین‌های لاگین‌شده فعال هستن
      Route::middleware('auth:sanctum')->group(function () {
        Route::get('comments', [CommentController::class, 'allComments']); // ادمین همه نظرات رو ببینه
        Route::delete('comments/{comment}', [CommentController::class, 'destroy']); // ادمین نظر رو حذف کنه
    });

    Route::post('posts/{post}/like', [LikeController::class, 'like']); // لایک کردن
    Route::post('posts/{post}/unlike', [LikeController::class, 'unlike']); // حذف لایک

    Route::get('posts', [PostController::class, 'index']); // همه کاربران می‌تونن پست‌ها رو ببینن
    Route::get('posts/{post}', [PostController::class, 'show']); // مشاهده یک پست خاص

    // مسیرهای زیر فقط برای ادمین‌های لاگین‌شده فعال هستن
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('posts', [PostController::class, 'store']); // ایجاد پست جدید
        Route::put('posts/{post}', [PostController::class, 'update']); // ویرایش پست
        Route::delete('posts/{post}', [PostController::class, 'destroy']); // حذف پست
    });

});
use App\Http\Controllers\AdminAuthController;

Route::prefix('api/admin')->group(function () {
    Route::post('register', [AdminAuthController::class, 'register']);
    Route::post('login', [AdminAuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AdminAuthController::class, 'logout']);
    });
});