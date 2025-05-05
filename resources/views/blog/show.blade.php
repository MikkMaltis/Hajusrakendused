<!-- filepath: /home/mikk/Ralf/hajusrakendused/ralf-hajus/resources/views/blog/show.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <a href="{{ route('blog.index') }}" class="text-indigo-600 hover:text-indigo-800 mb-6 inline-block">
            &larr; Back to Blog
        </a>

        <article class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h1 class="text-3xl font-bold mb-4">{{ $post->title }}</h1>
            <div class="text-gray-500 mb-4">{{ $post->created_at->format('M d, Y') }}</div>

            <div class="prose max-w-none">
                <p class="text-lg text-gray-700 mb-6">{{ $post->description }}</p>
                <div class="mt-6">
                    {!! $post->content !!}
                </div>
            </div>
        </article>

        <!-- Display Comments -->
        <div class="mt-8">
            <h3 class="text-xl font-semibold mb-4">Comments ({{ $post->approvedComments()->count() }})</h3>

            @if($post->approvedComments()->count() > 0)
                <div class="space-y-4">
                    @foreach($post->approvedComments as $comment)
                        <div class="bg-white p-4 rounded-lg shadow-sm">
                            <div class="flex justify-between">
                                <div>
                                    <h4 class="font-medium">{{ $comment->name }}</h4>
                                    <p class="text-sm text-gray-500">{{ $comment->created_at->format('M d, Y') }}</p>
                                </div>
                                @if(auth()->check() && auth()->user()->is_admin)
                                    <form action="{{ route('comments.destroy', $comment) }}" method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this comment?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                            <div class="mt-2">
                                <p>{{ $comment->content }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">No comments yet. Be the first to comment!</p>
            @endif
        </div>

        <!-- Comment Form -->
        @include('blog.comment-form', ['post' => $post])
    </div>
</div>
@endsection
