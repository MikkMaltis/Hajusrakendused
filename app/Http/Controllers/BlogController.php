<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of blog posts.
     */
    public function index()
    {
        $posts = Post::latest()->get();
        return view('blog.index', compact('posts'));
    }


    public function create()
    {
        return view('blog.create');
    }

    /**
     * Store a newly created blog post.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'content' => 'required|string',
        ]);

        $post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
        ]);

        $post->created_at = now();
        $post->save();

        return redirect()->route('blog.index')->with('success', 'Blog post created successfully!');
    }

    /**
     * Display the specified blog post.
     */
    public function show(Post $post)
    {
        return view('blog.show', compact('post'));
    }

    /**
     * Show the form for editing the specified blog post.
     */
    public function edit(Post $post)
    {
        return view('blog.edit', compact('post'));
    }

    /**
     * Update the specified blog post.
     */
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $post->update($validated);

        $post->created_at = now();
        $post->save();

        return redirect()->route('blog.index')->with('success', 'Blog post updated successfully!');
    }

    /**
     * Remove the specified blog post.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('blog.index')->with('success', 'Blog post deleted successfully!');
    }
}
