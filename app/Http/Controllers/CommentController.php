<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Post $post): RedirectResponse
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $post->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->input('content'),
        ]);

        return back()->with('success', 'Comment added successfully.');
    }

    public function show(Comment $comment): View
    {
        return view('comments.show', compact('comment'));
    }

    public function edit(Comment $comment): View
    {
        return view('comments.edit', compact('comment'));
    }

    public function update(Request $request, Comment $comment): RedirectResponse
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $comment->update([
            'content' => $request->input('content'),
        ]);

        return redirect()->route('comments.show', $comment)->with('success', 'Comment updated successfully.');
    }

    public function destroy(Comment $comment): RedirectResponse
    {
        $comment->delete();

        return redirect()->route('posts.show', $comment->post)->with('success', 'Comment deleted successfully.');
    }
}
