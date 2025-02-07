<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

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

    // ایجاد پست جدید
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'image' => 'nullable|string',
        ]);

        $post = Post::create($request->all());

        return response()->json($post, 201);
    }

    // بروزرسانی پست
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'image' => 'nullable|string',
        ]);

        $post->update($request->all());

        return response()->json($post);
    }

    // حذف پست
    public function destroy(Post $post)
    {
        $post->delete();

        return response()->json(null, 204);
    }
}
