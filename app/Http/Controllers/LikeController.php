<?php
namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function like(Post $post)
    {
        $post->increment('likes'); // تعداد لایک‌ها رو یکی اضافه کن
        return response()->json(['likes' => $post->likes]);
    }

    public function unlike(Post $post)
    {
        if ($post->likes > 0) {
            $post->decrement('likes'); // تعداد لایک‌ها رو یکی کم کن
        }
        return response()->json(['likes' => $post->likes]);
    }
}

