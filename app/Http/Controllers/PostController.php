<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // نمایش همه پست‌ها
    public function index()
    {
        return response()->json(Post::latest()->paginate(10));
    }

    // نمایش یک پست خاص
    public function show(Post $post)
    {
        return response()->json($post);
    }

    // ایجاد پست جدید (فقط ادمین)
    public function store(Request $request)
    {
        if (!$request->user() || !$request->user() instanceof \App\Models\Admin) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'image' => 'nullable|string',
        ]);

        $post = Post::create($request->all());

        return response()->json($post, 201);
    }

    // ویرایش پست (فقط ادمین)
    public function update(Request $request, Post $post)
    {
        if (!$request->user() || !$request->user() instanceof \App\Models\Admin) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'image' => 'nullable|string',
        ]);

        $post->update($request->all());

        return response()->json($post);
    }

    // حذف پست (فقط ادمین)
    public function destroy(Request $request, Post $post)
    {
        if (!$request->user() || !$request->user() instanceof \App\Models\Admin) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $post->delete();

        return response()->json(['message' => 'Post deleted successfully']);
    }
}
