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