<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\ProfileController;
use App\Models\Post;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {

    Route::resource('posts', PostController::class);

    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])
        ->name('comments.store');

    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])
        ->name('comments.destroy');

    Route::get('/achievements', [AchievementController::class, 'index'])
        ->name('achievements.index');

    Route::post('/notifications/read-all', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('success', 'All notifications marked as read.');
    })->name('notifications.read-all');
});

Route::get('/dashboard', function () {

    $postsCount = auth()->user()->posts()->count();
    $commentsCount = auth()->user()->comments()->count();

    $achievementsCount = auth()->user()
        ->achievements()
        ->count();

    $notifications = auth()->user()
        ->unreadNotifications()
        ->latest()
        ->take(5)
        ->get();

    return view('dashboard', compact(
        'postsCount',
        'commentsCount',
        'achievementsCount',
        'notifications'
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