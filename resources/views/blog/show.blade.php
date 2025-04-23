<!-- filepath: /home/mikk/Ralf/hajusrakendused/ralf-hajus/resources/views/blog/show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $post->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <p class="text-sm text-gray-500 mb-2">Posted on {{ $post->created_at ? $post->created_at->format('F d, Y') : 'unknown date' }}</p>
                        <div class="prose max-w-none">
                            {{ $post->description }}
                        </div>
                    </div>

                    <div class="mt-6 flex space-x-4">
                        <a href="{{ route('blog.index') }}" class="text-blue-600 hover:text-blue-800 mr-2">Back to Blog</a>
                        <a href="{{ route('blog.edit', $post) }}" class="text-yellow-600 hover:text-yellow-800 mr-2">Edit Post</a>
                        <form action="{{ route('blog.destroy', $post) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this post?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">Delete Post</button>
                        </form>
                    </div>

                    @if($post->comments->count() > 0)
                        <div class="mt-10">
                            <h3 class="text-lg font-medium mb-4 mt-4">Comments</h3>
                            @foreach($post->approvedComments as $comment)
                                <div class="mb-4 p-4 bg-gray-50 rounded">
                                    <p class="mb-1">{{ $comment->content }}</p>
                                    <p class="text-sm text-gray-500">Posted on {{ $comment->created_at->format('F d, Y') }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="mt-10 border-t pt-6">
                        <h3 class="text-lg font-medium mb-4">Leave a Comment</h3>

                        @if (session('success'))
                            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('comments.store', $post) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" name="name" id="name"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                            </div>

                            <div class="mb-4">
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" id="email"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                            </div>

                            <div class="mb-4">
                                <label for="content" class="block text-sm font-medium text-gray-700">Comment</label>
                                <textarea name="content" id="content" rows="4"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required></textarea>
                            </div>

                            <div class="flex items-center">
                                <button style="background-color: #368f22" type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                    Submit Comment
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
