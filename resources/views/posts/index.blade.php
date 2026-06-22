<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl">
                📝 My Posts
            </h2>

            <a href="{{ route('posts.create') }}" class="bg-green-500 text-white px-4 py-2 rounded">
                Create Post
            </a>
        </div>
    </x-slot>

    <div class="py-10">

        <div class="max-w-7xl mx-auto">

            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form method="GET" class="mb-5">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search Posts..."
                    class="w-full border rounded-lg p-3">
            </form>

            @if($posts->count())

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    @foreach($posts as $post)

                        <div class="bg-white shadow rounded-xl p-5">

                            <h3 class="font-bold text-xl">
                                {{ $post->title }}
                            </h3>

                            <p class="mt-3 text-gray-600">
                                {{ Str::limit($post->content, 100) }}
                            </p>

                            <div class="mt-3 text-sm text-gray-500">
                                {{ $post->created_at->format('d M Y') }}
                            </div>

                            <div class="mt-4 flex gap-2">

                                <a href="{{ route('posts.edit', $post) }}" class="bg-blue-500 text-white px-3 py-1 rounded">
                                    Edit
                                </a>

                                <form method="POST" action="{{ route('posts.destroy', $post) }}">

                                    @csrf
                                    @method('DELETE')

                                    <button onclick="return confirm('Delete this post?')"
                                        class="bg-red-500 text-white px-3 py-1 rounded">
                                        Delete
                                    </button>

                                </form>

                            </div>

                        </div>

                    @endforeach

                </div>

                <div class="mt-6">
                    {{ $posts->links() }}
                </div>

            @else

                <div class="bg-white p-10 rounded shadow text-center">
                    No Posts Found
                </div>

            @endif

        </div>

    </div>

</x-app-layout>