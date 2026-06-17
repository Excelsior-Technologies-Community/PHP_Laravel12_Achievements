# PHP_Laravel12_Achievements

## Introduction

PHP_Laravel12_Achievements is a Laravel 12 web application that demonstrates the implementation of an achievement-based reward system. The application allows users to create content, track their progress, and automatically unlock achievements when specific milestones are reached.

The project showcases user authentication, post management, achievement tracking, Eloquent relationships, and a modern Blade-based user interface, providing a practical example of building gamification features in Laravel applications.

Key functionalities and features are described in detail below.

---

## Features

### Authentication

- User Registration
- User Login
- User Logout
- Laravel Breeze Authentication


### Post Management

- Create Post
- View Posts
- User based post system


### Achievement System

Automatic achievement unlocking:

| Achievement | Requirement |
|---|---|
| 🏆 First Post | Create 1 Post |
| 🥈 Active Writer | Create 5 Posts |
| 🥇 Content Creator | Create 10 Posts |


### UI

Built using:

- Blade
- Tailwind CSS
- Laravel Breeze Components


---

## Technology Stack


| Technology | Version |
|-|-|
| Laravel | 12 |
| PHP | 8.2+ |
| MySQL | 8+ |
| Composer | Latest |
| Tailwind CSS | Latest |


---

## Requirements

Before starting make sure installed:

- PHP >= 8.2
- Composer
- MySQL
- Node.js
- NPM


Check versions:


```bash
php -v

composer -V

node -v

npm -v
```


---

# Installation


## Step 1: Create Laravel 12 Project


```bash
composer create-project laravel/laravel PHP_Laravel12_Achievements "12.*"
```


Move into project:


```bash
cd PHP_Laravel12_Achievements
```


---

## Step 2: Install Laravel Breeze


Install Breeze:


```bash
composer require laravel/breeze --dev
```


Install authentication:


```bash
php artisan breeze:install
```


Install frontend packages:


```bash
npm install
```


Build assets:


```bash
npm run build
```

---

## Step 3: Database Configuration

Open .env

Update:

```.env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel12_achievements
DB_USERNAME=root
DB_PASSWORD=
```

After Run Migration Command:

```bash
php artisan migrate
```

---

## Step 4: Install Achievement Package


Install package:


```bash
composer require tehwave/laravel-achievements
```

---

## Step 5: Publish Achievement Migration


Publish migrations:


```bash
php artisan vendor:publish --tag="achievements-migrations"
```


Run migration:


```bash
php artisan migrate
```


Publish config:


```bash
php artisan vendor:publish --tag="achievements-config"
```

---

## Database Structure

The package creates achievements table:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAchievementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('achievements.table', 'achievements'), function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type')->index();
            $table->morphs('achiever');
            $table->text('data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('achievements.table', 'achievements'));
    }
}
```


---

## Step 6: User Model Setup


File:

```
app/Models/User.php
```

Add:


```php
<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// Add this
use tehwave\Achievements\Traits\Achiever;


class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, Achiever;


    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
```

---

## Step 7: Create Achievement Classes


Create folder:

```
app/Achievements
```


Create achievement:


```bash
php artisan make:achievement UsersFirstPost
```

### UsersFirstPost.php

File: app/Achievements/UsersFirstPost.php


```php
<?php

namespace App\Achievements;

use tehwave\Achievements\Achievement;

class UsersFirstPost extends Achievement
{
    public $name = 'First Post';

    public $description = 'Create your first post';

    public $icon = '🏆';


    public function toDatabase()
    {
        return [
            'title' => $this->name,
            'description' => $this->description,
            'icon' => $this->icon,
        ];
    }
}
```

### UsersFivePosts.php


Create:


```bash
php artisan make:achievement UsersFivePosts
```

File: app/Achievements/UsersFivePosts.php

Code:


```php
<?php

namespace App\Achievements;

use tehwave\Achievements\Achievement;


class UsersFivePosts extends Achievement
{

    public $name = 'Active Writer';


    public $description = 'Create five posts';


    public $icon = '🥈';



    public function toDatabase()
    {
        return [
            'title' => $this->name,
            'description' => $this->description,
            'icon' => $this->icon,
        ];
    }

}
```

### UsersTenPosts.php


Create:


```bash
php artisan make:achievement UsersTenPosts
```

File: app/Achievements/UsersTenPosts.php

Code:


```php
<?php

namespace App\Achievements;

use tehwave\Achievements\Achievement;


class UsersTenPosts extends Achievement
{

    public $name = 'Content Creator';


    public $description = 'Create ten posts';


    public $icon = '🥇';



    public function toDatabase()
    {
        return [
            'title' => $this->name,
            'description' => $this->description,
            'icon' => $this->icon,
        ];
    }

}
```

---

## Step 8: Create Post System


Create:

```bash
php artisan make:model Post -m
```


### Migration Table:

database/migrations/YYYY_MM_DD_HHMMSS_create_posts_table.php

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('title');

            $table->text('content');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
```

Run:


```bash
php artisan migrate
```

### Post Model


File: app/Models/Post.php

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Post extends Model
{

protected $fillable=[
    'title',
    'content'
];


public function user()
{
    return $this->belongsTo(User::class);
}

}
```

### Post Controller


Create:


```bash
php artisan make:controller PostController
```

File: app/Http/Controllers/PostController.php

```php
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
```

### Blade Files

#### Create Post View

File: resources/views/posts/create.blade.php

```blade
<x-app-layout>

    <x-slot name="header">

        <div>

            <h2 class="font-bold text-2xl text-gray-800">
                ✍️ Create New Post
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Share your thoughts and unlock achievements
            </p>

        </div>

    </x-slot>



    <div class="py-12 bg-gray-100 min-h-screen">


        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">


            <div class="bg-white rounded-2xl shadow-xl p-8">


                <form method="POST"
                      action="{{ route('posts.store') }}">

                    @csrf



                    <!-- Title -->

                    <div>


                        <label class="block text-sm font-semibold text-gray-700 mb-2">

                            Post Title

                        </label>


                        <input
                            type="text"
                            name="title"
                            value="{{ old('title') }}"
                            class="w-full border-gray-300 rounded-xl shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-400 p-3"
                            placeholder="Enter post title">


                        @error('title')

                            <p class="text-red-500 text-sm mt-2">
                                {{ $message }}
                            </p>

                        @enderror


                    </div>




                    <!-- Content -->


                    <div class="mt-6">


                        <label class="block text-sm font-semibold text-gray-700 mb-2">

                            Post Content

                        </label>


                        <textarea
                            name="content"
                            rows="6"
                            class="w-full border-gray-300 rounded-xl shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-400 p-3"
                            placeholder="Write your content here...">{{ old('content') }}</textarea>



                        @error('content')

                            <p class="text-red-500 text-sm mt-2">
                                {{ $message }}
                            </p>

                        @enderror


                    </div>




                    <!-- Buttons -->


                    <div class="mt-8 flex justify-between items-center">


                        <a href="{{ route('posts.index') }}"
                           class="px-5 py-3 rounded-xl bg-gray-200 text-gray-700 hover:bg-gray-300 transition">

                            Cancel

                        </a>




                        <button
                            class="px-6 py-3 rounded-xl bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold shadow hover:shadow-lg transition">


                            🚀 Publish Post


                        </button>


                    </div>



                </form>


            </div>



            <!-- Achievement Info -->


            <div class="mt-6 bg-white rounded-2xl shadow p-6">


                <h3 class="font-bold text-lg text-gray-800">

                    🏆 Achievement Progress

                </h3>


                <p class="text-gray-500 mt-2">

                    Create posts to unlock:

                </p>



                <div class="flex gap-3 mt-4 flex-wrap">


                    <span class="px-4 py-2 rounded-full bg-yellow-100 text-yellow-700">

                        🏆 First Post

                    </span>


                    <span class="px-4 py-2 rounded-full bg-gray-100 text-gray-700">

                        🥈 5 Posts

                    </span>


                    <span class="px-4 py-2 rounded-full bg-orange-100 text-orange-700">

                        🥇 10 Posts

                    </span>


                </div>


            </div>



        </div>


    </div>


</x-app-layout>
```

#### List View

File: resources/views/posts/index.blade.php

```blade
<x-app-layout>

    <x-slot name="header">

        <div class="flex justify-between items-center">

            <div>

                <h2 class="font-bold text-2xl text-gray-800">
                    📝 My Posts
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Manage your created posts
                </p>

            </div>


            <a href="{{ route('posts.create') }}"
               class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-5 py-2 rounded-xl shadow hover:shadow-lg transition">

                + Create Post

            </a>


        </div>


    </x-slot>



    <div class="py-12 bg-gray-100 min-h-screen">


        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">



            @if($posts->count() > 0)


                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">


                    @foreach($posts as $post)



                    <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition p-6">


                        <div class="flex items-start justify-between">


                            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-2xl">

                                📝

                            </div>


                            <span class="text-xs bg-green-100 text-green-700 px-3 py-1 rounded-full">

                                Published

                            </span>


                        </div>



                        <h3 class="text-xl font-bold text-gray-800 mt-5">

                            {{ $post->title }}

                        </h3>



                        <p class="text-gray-600 mt-3 leading-relaxed">

                            {{ Str::limit($post->content, 120) }}

                        </p>



                        <div class="mt-6 border-t pt-4 flex justify-between items-center">


                            <span class="text-sm text-gray-500">

                                Created

                            </span>


                            <span class="text-sm font-semibold text-indigo-600">

                                {{ $post->created_at->format('d M Y') }}

                            </span>


                        </div>



                    </div>



                    @endforeach


                </div>



            @else


                <div class="bg-white rounded-2xl shadow p-10 text-center">


                    <div class="text-6xl mb-4">

                        ✍️

                    </div>


                    <h3 class="text-xl font-bold">

                        No posts yet

                    </h3>


                    <p class="text-gray-500 mt-2">

                        Create your first post and unlock achievements.

                    </p>


                    <a href="{{ route('posts.create') }}"
                       class="inline-block mt-5 bg-green-500 text-white px-5 py-2 rounded-xl">

                        Create First Post

                    </a>


                </div>


            @endif



        </div>


    </div>


</x-app-layout>
```

---

## Step 9: Unlock Achievements


### AchievementController

Create controller:


```bash
php artisan make:controller AchievementController
```

File: app/Http/Controllers/AchievementController.php

```php
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
```

### Achievements View

File: resources/views/achievements/index.blade.php

```blade
<x-app-layout>

    <x-slot name="header">

        <div class="flex justify-between items-center">

            <div>

                <h2 class="font-bold text-2xl text-gray-800">
                    🏆 My Achievements
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Track your unlocked achievements
                </p>

            </div>


            <div class="bg-indigo-100 text-indigo-700 px-4 py-2 rounded-full font-semibold">

                {{ $achievements->count() }} Unlocked

            </div>


        </div>

    </x-slot>



    <div class="py-12 bg-gray-100 min-h-screen">


        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


            @if($achievements->count() > 0)


                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">


                    @foreach($achievements as $achievement)


                    <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition p-6 relative overflow-hidden">


                        <div class="absolute top-0 right-0 bg-yellow-400 text-white px-4 py-1 rounded-bl-xl text-sm font-bold">

                            UNLOCKED

                        </div>



                        <div class="flex items-center gap-4">


                            <div class="w-16 h-16 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-full flex items-center justify-center text-3xl shadow">


                                {{ $achievement->data['icon'] ?? '🏆' }}


                            </div>



                            <div>


                                <h3 class="text-xl font-bold text-gray-800">


                                    {{ $achievement->data['title'] ?? class_basename($achievement->type) }}


                                </h3>


                                <p class="text-gray-500 text-sm">


                                    Achievement


                                </p>


                            </div>


                        </div>




                        <div class="mt-6">


                            <p class="text-gray-600 leading-relaxed">


                                {{ $achievement->data['description'] ?? '' }}


                            </p>


                        </div>




                        <div class="mt-6 border-t pt-4 flex justify-between items-center">


                            <span class="text-sm text-gray-500">


                                Unlocked Date


                            </span>


                            <span class="font-semibold text-indigo-600">


                                {{ $achievement->created_at->format('d M Y') }}


                            </span>


                        </div>


                    </div>


                    @endforeach


                </div>



            @else


                <div class="bg-white rounded-xl shadow p-10 text-center">


                    <div class="text-6xl mb-4">

                        🔒

                    </div>


                    <h3 class="text-xl font-bold">

                        No achievements yet

                    </h3>


                    <p class="text-gray-500 mt-2">

                        Create your first post to unlock achievements.

                    </p>


                </div>


            @endif


        </div>


    </div>


</x-app-layout>
```

---

## Step 10: Routes


File: routes/web.php


```php
<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AchievementController;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {

    Route::resource('posts', PostController::class);

    Route::get('/achievements', [AchievementController::class, 'index'])->name('achievements.index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
```

---

## Step 11: Run Project


### Terminal 1 — Start Laravel Server


```bash
php artisan serve
```

Open:

```
http://127.0.0.1:8000
```

Terminal 2 — Start Vite Development Server

```bash
npm run dev
```

---

## Screenshots

<img width="1918" height="1028" alt="Screenshot 2026-06-17 142116" src="https://github.com/user-attachments/assets/e4a73a30-819c-4be8-85b9-4350c8e2eac4" />

<img width="1900" height="1027" alt="Screenshot 2026-06-17 142219" src="https://github.com/user-attachments/assets/2a798bad-79ee-4f8b-9d49-7dcddec0f72c" />

<img width="1900" height="1027" alt="Screenshot 2026-06-17 142229" src="https://github.com/user-attachments/assets/f2aac32f-6d26-4bcf-bf58-153977ad5916" />

<img width="1898" height="1028" alt="Screenshot 2026-06-17 142251" src="https://github.com/user-attachments/assets/7a671200-71b4-4ff1-80d5-795daee75b6d" />

---

## Project Structure

```text
PHP_Laravel12_Achievements
│
├── app
│   │
│   ├── Achievements
│   │   ├── UsersFirstPost.php
│   │   ├── UsersFivePosts.php
│   │   └── UsersTenPosts.php
│   │
│   ├── Http
│   │   └── Controllers
│   │       ├── AchievementController.php
│   │       └── PostController.php
│   │
│   └── Models
│       ├── Post.php
│       └── User.php
│
├── bootstrap
│
├── config
│   └── achievements.php
│
├── database
│   │
│   ├── migrations
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── YYYY_MM_DD_HHMMSS_create_posts_table.php
│   │   └── 2019_00_00_000000_create_achievements_table.php
│   │
│   └── seeders
│
├── public
│
├── resources
│   │
│   ├── css
│   │   └── app.css
│   │
│   ├── js
│   │   └── app.js
│   │
│   └── views
│       │
│       ├── achievements
│       │   └── index.blade.php
│       │
│       ├── posts
│       │   ├── create.blade.php
│       │   └── index.blade.php
│       │
│       ├── dashboard.blade.php
│       │
│       └── layouts
│
├── routes
│   ├── web.php
│   └── auth.php
│
├── storage
│
├── tests
│
├── .env
├── composer.json
├── package.json
├── vite.config.js
└── README.md
```

---

## Conclusion

This project showcases an achievement-driven system in Laravel 12 that rewards users automatically as they reach predefined milestones.
