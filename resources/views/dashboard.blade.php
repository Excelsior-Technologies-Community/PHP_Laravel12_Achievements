<x-app-layout>

    <x-slot name="header">

        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>

    </x-slot>


    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">


                <div class="p-6 text-gray-900">


                    <h3 class="text-2xl font-bold mb-4">
                        Welcome {{ auth()->user()->name }}
                    </h3>



                    <div class="flex gap-4">


                        <a href="{{ route('posts.index') }}"
                           class="bg-blue-500 text-white px-4 py-2 rounded">

                            Manage Posts

                        </a>



                        <a href="{{ route('achievements.index') }}"
                           class="bg-green-500 text-white px-4 py-2 rounded">

                            My Achievements

                        </a>


                    </div>


                </div>


            </div>



        </div>

    </div>


</x-app-layout>