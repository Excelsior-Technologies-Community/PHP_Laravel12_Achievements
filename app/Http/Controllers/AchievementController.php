<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AchievementController extends Controller
{
    public function index(Request $request)
    {
        $achievements = auth()->user()
            ->achievements()
            ->when($request->search, function ($query) use ($request) {
                $query->where('type', 'like', '%' . $request->search . '%');
            })
            ->latest()
            ->paginate(6)
            ->withQueryString();

        return view(
            'achievements.index',
            compact('achievements')
        );
    }
}