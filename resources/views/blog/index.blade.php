<!-- filepath: /home/mikk/Ralf/hajusrakendused/ralf-hajus/resources/views/blog/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Blog') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">Latest Posts</h3>
                        <a style="background-color: #368f22" href="{{ route('blog.create') }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            Add New Post
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($posts->count() > 0)
                        @foreach ($posts as $post)
                            <div class="mb-6 pb-6 border-b">
                                <h4 class="text-xl font-semibold mb-2">{{ $post->title }}</h4>
                                <p class="text-sm text-gray-500 mb-2">Posted on {{ $post->created_at->format('F d, Y') }}</p>
                                <p class="mb-3">{{ Str::limit($post->description, 150) }}</p>
                                <div class="flex space-x-4">
                                    <a href="{{ route('blog.show', $post) }}" class="text-blue-600 hover:text-blue-800 mr-2">Read more</a>
                                    <a href="{{ route('blog.edit', $post) }}" class="text-yellow-600 hover:text-yellow-800 mr-2">Edit</a>
                                    <form action="{{ route('blog.destroy', $post) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this post?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-gray-500">No blog posts found. Create your first post!</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
