@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <div class="bg-white shadow-lg rounded-lg p-6 border border-gray-100 mb-8">
        <h1 class="text-4xl font-bold mb-4 text-blue-600">{{ $post->title }}</h1>
        <div class="text-sm text-gray-600 mb-4">
            <span>By {{ $post->user->user_name }}</span> |
            <span>{{ $post->created_at->format('F d, Y') }}</span>
        </div>
        <p class="text-gray-700 mb-6 leading-relaxed">{{ $post->content }}</p>

        <div class="flex justify-end space-x-4">
            @can('update', $post)
                <a href="{{ route('posts.edit', $post) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md transition duration-300">Edit Post</a>
            @endcan
            @can('delete', $post)
                <form action="{{ route('posts.destroy', $post) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-md transition duration-300" onclick="return confirm('Are you sure you want to delete this post?')">Delete Post</button>
                </form>
            @endcan
        </div>
    </div>

    <div class="mt-8 max-w-3xl mx-auto">
        <h2 class="text-2xl font-bold mb-6 text-blue-600">Comments</h2>

        @auth
            <div class="bg-white shadow-lg rounded-lg p-6 mb-8 border border-gray-100">
                <h3 class="text-xl font-bold mb-4 text-blue-600">Add a Comment</h3>
                <form action="{{ route('comments.store', $post) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <textarea name="content" rows="4" class="shadow appearance-none border rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500 transition duration-300" placeholder="Write your comment here..."></textarea>
                    </div>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md transition duration-300">Submit Comment</button>
                </form>
            </div>
        @else
            <div class="bg-white shadow-lg rounded-lg p-6 mb-8 border border-gray-100">
                <p class="text-gray-700">Please <a href="{{ route('login') }}" class="text-blue-500 hover:text-blue-700 hover:underline transition duration-300">log in</a> to add a comment.</p>
            </div>
        @endauth

        <div class="space-y-6">
            @forelse ($post->comments as $comment)
                <div class="bg-white shadow-lg rounded-lg p-5 border border-gray-100">
                    <div class="text-sm text-gray-600 mb-2">
                        <strong class="text-blue-600">{{ $comment->user->user_name }}</strong> said:
                    </div>
                    <p class="text-gray-700 leading-relaxed">{{ $comment->content }}</p>
                </div>
            @empty
                <div class="bg-white shadow-lg rounded-lg p-5 border border-gray-100 text-center">
                    <p class="text-gray-700 py-2">No comments yet.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
