<x-app-layout>

    <x-slot name="header">
        <h2 class="font-bold text-2xl">
            Edit Post
        </h2>
    </x-slot>

    <div class="py-10">

        <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">

            <form method="POST" action="{{ route('posts.update', $post) }}">

                @csrf
                @method('PUT')

                <div class="mb-4">

                    <label class="block mb-2">
                        Title
                    </label>

                    <input type="text" name="title" value="{{ old('title', $post->title) }}"
                        class="w-full border rounded p-3">

                </div>

                <div class="mb-4">

                    <label class="block mb-2">
                        Content
                    </label>

                    <textarea name="content" rows="6"
                        class="w-full border rounded p-3">{{ old('content', $post->content) }}</textarea>

                </div>

                <button class="bg-blue-500 text-white px-5 py-2 rounded">
                    Update Post
                </button>

            </form>

        </div>

    </div>

</x-app-layout>