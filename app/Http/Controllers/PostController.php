<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Achievements\UsersFirstPost;
use App\Achievements\UsersFivePosts;
use App\Achievements\UsersTenPosts;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = auth()->user()
            ->posts()
            ->when($request->search, function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('content', 'like', '%' . $request->search . '%');
            })
            ->oldest()
            ->paginate(4);

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required'
        ]);

        auth()->user()->posts()->create([
            'title' => $request->title,
            'content' => $request->content
        ]);

        $count = auth()->user()->posts()->count();

        if ($count == 1) {
            auth()->user()->achieve(new UsersFirstPost());
        }

        if ($count == 5) {
            auth()->user()->achieve(new UsersFivePosts());
        }

        if ($count == 10) {
            auth()->user()->achieve(new UsersTenPosts());
        }

        return redirect()
            ->route('posts.index')
            ->with('success', 'Post created successfully.');
    }

    public function edit(Post $post)
    {
        if ($post->user_id != auth()->id()) {
            abort(403);
        }

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        if ($post->user_id != auth()->id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required'
        ]);

        $post->update([
            'title' => $request->title,
            'content' => $request->content
        ]);

        return redirect()
            ->route('posts.index')
            ->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        if ($post->user_id != auth()->id()) {
            abort(403);
        }

        $post->delete();

        return redirect()
            ->route('posts.index')
            ->with('success', 'Post deleted successfully.');
    }
}