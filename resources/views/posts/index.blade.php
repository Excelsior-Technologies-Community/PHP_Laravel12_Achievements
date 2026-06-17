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