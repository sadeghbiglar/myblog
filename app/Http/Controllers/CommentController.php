<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // دریافت نظرات یک پست خاص
    public function index(Post $post)
    {
        return response()->json($post->comments()->latest()->get());
    }

    // ثبت نظر جدید
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'author' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $comment = $post->comments()->create($request->all());

        return response()->json($comment, 201);
    }

    // حذف یک نظر خاص
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return response()->json(null, 204);
    }
}

