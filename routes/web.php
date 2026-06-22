<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\ProfileController;
use App\Models\Post;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {

    Route::resource('posts', PostController::class);

    Route::get('/achievements', [AchievementController::class, 'index'])
        ->name('achievements.index');
});

Route::get('/dashboard', function () {

    $postsCount = auth()->user()->posts()->count();

    $achievementsCount = auth()->user()
        ->achievements()
        ->count();

    return view('dashboard', compact(
        'postsCount',
        'achievementsCount'
    ));

})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__ . '/auth.php';