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
            'name' => $validated['name'],
            'email' => $validated['email'],
            'content' => $validated['content'],
            'is_approved' => false, // Comments need approval by default
        ]);

        return redirect()->route('blog.show', $post)
            ->with('success', 'Comment submitted and is awaiting approval');
    }

    public function index()
    {
        // Check if user is admin
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }

        $comments = Comment::with('post')->latest()->get();
        return view('comments.index', compact('comments'));
    }

    public function approve(Comment $comment)
    {
        // Check if user is admin
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }

        $comment->update(['is_approved' => true]);

        return redirect()->route('comments.index')
            ->with('success', 'Comment approved successfully');
    }

    public function destroy(Comment $comment)
    {
        // Check if user is admin
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }

        $comment->delete();

        // Check if the request is coming from comments.index or blog.show
        if (url()->previous() === route('comments.index')) {
            return redirect()->route('comments.index')
                ->with('success', 'Comment deleted successfully');
        }

        return back()->with('success', 'Comment deleted successfully');
    }
}
