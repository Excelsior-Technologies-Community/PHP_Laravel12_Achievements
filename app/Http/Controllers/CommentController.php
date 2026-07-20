<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Achievements\UsersFirstComment;
use App\Achievements\UsersFiveComments;
use App\Achievements\UsersTenComments;
use App\Notifications\AchievementUnlocked;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required'
        ]);

        $comment = auth()->user()->comments()->create([
            'post_id' => $post->id,
            'content' => $request->content
        ]);

        $count = auth()->user()->comments()->count();

        if ($count == 1) {
            auth()->user()->achieve(new UsersFirstComment());
            auth()->user()->notify(new AchievementUnlocked((new UsersFirstComment())->toDatabase()));
        }

        if ($count == 5) {
            auth()->user()->achieve(new UsersFiveComments());
            auth()->user()->notify(new AchievementUnlocked((new UsersFiveComments())->toDatabase()));
        }

        if ($count == 10) {
            auth()->user()->achieve(new UsersTenComments());
            auth()->user()->notify(new AchievementUnlocked((new UsersTenComments())->toDatabase()));
        }

        return redirect()
            ->route('posts.show', $post)
            ->with('success', 'Comment added successfully.');
    }

    public function destroy(Comment $comment)
    {
        if ($comment->user_id != auth()->id()) {
            abort(403);
        }

        $post = $comment->post;
        $comment->delete();

        return redirect()
            ->route('posts.show', $post)
            ->with('success', 'Comment deleted successfully.');
    }
}
