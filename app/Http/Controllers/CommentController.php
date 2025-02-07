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

    // دریافت تمام نظرات (فقط ادمین)
    public function allComments(Request $request)
    {
        if (!$request->user() || !$request->user() instanceof \App\Models\Admin) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json(Comment::latest()->paginate(10));
    }

    // حذف یک نظر (فقط ادمین)
    public function destroy(Request $request, Comment $comment)
    {
        if (!$request->user() || !$request->user() instanceof \App\Models\Admin) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $comment->delete();
        return response()->json(['message' => 'Comment deleted successfully']);
    }
}
