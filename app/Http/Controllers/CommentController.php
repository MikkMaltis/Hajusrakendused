<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'content' => 'required|string',
        ]);

        $post->comments()->create([
            'name' => $validated['name'],  // Change from 'author_name' to 'name'
            'email' => $validated['email'],
            'content' => $validated['content'],
            'is_approved' => false,
        ]);

        return redirect()->route('blog.show', $post)
            ->with('success', 'Comment submitted and is awaiting approval');
    }

    public function index()
    {
        $comments = Comment::with('post')->latest()->get();
        return view('comments.index', compact('comments'));
    }

    public function approve(Comment $comment)
    {
        $comment->update(['is_approved' => true]);
        return redirect()->route('comments.index')
            ->with('success', 'Comment approved successfully');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return redirect()->route('comments.index')
            ->with('success', 'Comment deleted successfully');
    }
}
