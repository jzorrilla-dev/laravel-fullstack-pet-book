@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-blue-600">Blog</h1>
        <a href="{{ route('posts.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md transition duration-300 ease-in-out transform hover:scale-105">Create New Post</a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-md relative mb-6" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="space-y-6">
        @forelse ($posts as $post)
            <div class="bg-white shadow-lg rounded-lg p-6 border border-gray-100 hover:shadow-xl transition duration-300">
                <h2 class="text-2xl font-bold mb-2 text-blue-600">{{ $post->title }}</h2>
                <div class="text-sm text-gray-600 mb-4">
                    <span>By {{ $post->user->user_name }}</span> | 
                    <span>{{ $post->created_at->format('F d, Y') }}</span>
                </div>
                <p class="text-gray-700 mb-4 leading-relaxed">{{ Str::limit($post->content, 200) }}</p>
                <div class="flex items-center">
                    <a href="{{ route('posts.show', $post) }}" class="text-blue-500 hover:text-blue-700 font-medium hover:underline transition duration-300">Read More</a>
                    @can('update', $post)
                        <a href="{{ route('posts.edit', $post) }}" class="text-yellow-500 hover:text-yellow-700 font-medium hover:underline ml-4 transition duration-300">Edit</a>
                    @endcan
                    @can('delete', $post)
                        <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline ml-4">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 font-medium hover:underline transition duration-300" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                        </form>
                    @endcan
                </div>
            </div>
        @empty
            <div class="bg-white shadow-lg rounded-lg p-6 border border-gray-100">
                <p class="text-gray-700 text-center py-4">No posts found.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8 flex justify-center">
        {{ $posts->links() }}
    </div>
</div>
@endsection
