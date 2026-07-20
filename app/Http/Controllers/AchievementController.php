<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Achievements\UsersFirstPost;
use App\Achievements\UsersFivePosts;
use App\Achievements\UsersTenPosts;
use App\Achievements\UsersFirstComment;
use App\Achievements\UsersFiveComments;
use App\Achievements\UsersTenComments;

class AchievementController extends Controller
{
    public function index(Request $request)
    {
        $unlockedAchievements = auth()->user()
            ->achievements()
            ->when($request->search, function ($query) use ($request) {
                $query->where('type', 'like', '%' . $request->search . '%');
            })
            ->latest()
            ->get();

        $allAchievements = [
            new UsersFirstPost(),
            new UsersFivePosts(),
            new UsersTenPosts(),
            new UsersFirstComment(),
            new UsersFiveComments(),
            new UsersTenComments(),
        ];

        $unlockedTypes = $unlockedAchievements->pluck('type')->toArray();

        $lockedAchievements = collect($allAchievements)
            ->filter(function ($achievement) use ($unlockedTypes) {
                return !in_array(get_class($achievement), $unlockedTypes);
            })
            ->map(function ($achievement) {
                return [
                    'class' => get_class($achievement),
                    'name' => $achievement->name,
                    'description' => $achievement->description,
                    'icon' => $achievement->icon,
                ];
            });

        return view(
            'achievements.index',
            compact('unlockedAchievements', 'lockedAchievements')
        );
    }
}