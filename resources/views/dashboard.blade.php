<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="font-bold text-2xl text-gray-800">
                🎯 Achievement Dashboard
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Track your post activity and unlocked achievements
            </p>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Statistics -->

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="bg-white rounded-2xl shadow-lg p-6">

                    <div class="flex items-center justify-between">

                        <div>

                            <h3 class="text-gray-500 text-sm uppercase">
                                Total Posts
                            </h3>

                            <p class="text-4xl font-bold text-blue-600 mt-2">
                                {{ $postsCount }}
                            </p>

                        </div>

                        <div class="text-5xl">
                            📝
                        </div>

                    </div>

                </div>

                <div class="bg-white rounded-2xl shadow-lg p-6">

                    <div class="flex items-center justify-between">

                        <div>

                            <h3 class="text-gray-500 text-sm uppercase">
                                Total Comments
                            </h3>

                            <p class="text-4xl font-bold text-purple-600 mt-2">
                                {{ $commentsCount }}
                            </p>

                        </div>

                        <div class="text-5xl">
                            💬
                        </div>

                    </div>

                </div>

                <div class="bg-white rounded-2xl shadow-lg p-6">

                    <div class="flex items-center justify-between">

                        <div>

                            <h3 class="text-gray-500 text-sm uppercase">
                                Achievements Unlocked
                            </h3>

                            <p class="text-4xl font-bold text-yellow-500 mt-2">
                                {{ $achievementsCount }}
                            </p>

                        </div>

                        <div class="text-5xl">
                            🏆
                        </div>

                    </div>

                </div>

            </div>

            <!-- Achievement Progress -->

            <div class="mt-8 bg-white rounded-2xl shadow-lg p-6">

                <h3 class="text-xl font-bold text-gray-800 mb-4">
                    🚀 Achievement Progress
                </h3>

                <div class="space-y-4">

                    <div>
                        <div class="flex justify-between mb-1">
                            <span>🏆 First Post</span>
                            <span>{{ $postsCount >= 1 ? 'Completed' : 'Pending' }}</span>
                        </div>

                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-green-500 h-3 rounded-full"
                                style="width: {{ $postsCount >= 1 ? '100%' : '0%' }}">
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between mb-1">
                            <span>🥈 Active Writer (5 Posts)</span>
                            <span>{{ min($postsCount, 5) }}/5</span>
                        </div>

                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-blue-500 h-3 rounded-full"
                                style="width: {{ min(($postsCount / 5) * 100, 100) }}%">
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between mb-1">
                            <span>🥇 Content Creator (10 Posts)</span>
                            <span>{{ min($postsCount, 10) }}/10</span>
                        </div>

                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-yellow-500 h-3 rounded-full"
                                style="width: {{ min(($postsCount / 10) * 100, 100) }}%">
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between mb-1">
                            <span>💬 First Comment</span>
                            <span>{{ $commentsCount >= 1 ? 'Completed' : 'Pending' }}</span>
                        </div>

                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-green-500 h-3 rounded-full"
                                style="width: {{ $commentsCount >= 1 ? '100%' : '0%' }}">
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between mb-1">
                            <span>🗨️ Active Commenter (5 Comments)</span>
                            <span>{{ min($commentsCount, 5) }}/5</span>
                        </div>

                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-purple-500 h-3 rounded-full"
                                style="width: {{ min(($commentsCount / 5) * 100, 100) }}%">
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between mb-1">
                            <span>🎤 Discussion Master (10 Comments)</span>
                            <span>{{ min($commentsCount, 10) }}/10</span>
                        </div>

                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-pink-500 h-3 rounded-full"
                                style="width: {{ min(($commentsCount / 10) * 100, 100) }}%">
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <!-- Notifications -->

            @if($notifications->count() > 0)
            <div class="mt-8 bg-white rounded-2xl shadow-lg p-6">

                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-800">
                        🔔 Recent Notifications
                    </h3>

                    <form action="{{ route('notifications.read-all') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-sm text-indigo-600 hover:text-indigo-800 font-semibold">
                            Mark all as read
                        </button>
                    </form>
                </div>

                <div class="space-y-3">

                    @foreach($notifications as $notification)
                    <div class="flex items-center gap-4 p-4 bg-gradient-to-r from-yellow-50 to-orange-50 rounded-xl border border-yellow-200">

                        <div class="text-4xl">
                            {{ $notification->data['icon'] ?? '🎉' }}
                        </div>

                        <div class="flex-1">

                            <h4 class="font-semibold text-gray-800">
                                {{ $notification->data['title'] ?? 'Achievement Unlocked' }}
                            </h4>

                            <p class="text-sm text-gray-600">
                                {{ $notification->data['description'] ?? 'You have unlocked a new achievement!' }}
                            </p>

                        </div>

                        <div class="text-xs text-gray-500">
                            {{ $notification->created_at->diffForHumans() }}
                        </div>

                    </div>
                    @endforeach

                </div>

            </div>
            @endif

            <!-- Quick Actions -->

            <div class="mt-8 bg-white rounded-2xl shadow-lg p-6">

                <h3 class="text-xl font-bold text-gray-800 mb-4">
                    ⚡ Quick Actions
                </h3>

                <div class="flex flex-wrap gap-4">

                    <a href="{{ route('posts.create') }}"
                        class="px-6 py-3 rounded-xl bg-green-500 text-white font-semibold hover:bg-green-600 transition">

                        ✍️ Create Post

                    </a>

                    <a href="{{ route('posts.index') }}"
                        class="px-6 py-3 rounded-xl bg-blue-500 text-white font-semibold hover:bg-blue-600 transition">

                        📝 View Posts

                    </a>

                    <a href="{{ route('achievements.index') }}"
                        class="px-6 py-3 rounded-xl bg-yellow-500 text-white font-semibold hover:bg-yellow-600 transition">

                        🏆 My Achievements

                    </a>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>