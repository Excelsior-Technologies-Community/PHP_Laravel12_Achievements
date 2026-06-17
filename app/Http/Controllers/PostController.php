<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Achievements\UsersFirstPost;
use App\Achievements\UsersFivePosts;
use App\Achievements\UsersTenPosts;

class PostController extends Controller
{

    public function index()
    {
        $posts = auth()->user()
            ->posts()
            ->latest()
            ->get();

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required'
        ]);

        $post = auth()->user()
            ->posts()
            ->create(
                $request->only([
                    'title',
                    'content'
                ])
            );

        $count = auth()->user()
            ->posts()
            ->count();

        if ($count == 1) {
            auth()->user()
                ->achieve(
                    new UsersFirstPost()
                );
        }

        if ($count == 5) {
            auth()->user()
                ->achieve(
                    new UsersFivePosts()
                );
        }

        if ($count == 10) {
            auth()->user()
                ->achieve(
                    new UsersTenPosts()
                );
        }

        return redirect()->route('posts.index');
    }
}