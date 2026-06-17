<?php

namespace App\Http\Controllers;


class AchievementController extends Controller
{

    public function index()
    {
        $achievements = auth()->user()
            ->achievements()
            ->get();


        return view(
            'achievements.index',
            compact('achievements')
        );
    }

}