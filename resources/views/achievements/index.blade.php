<x-app-layout>

    <x-slot name="header">

        <div class="flex justify-between items-center">

            <div>

                <h2 class="font-bold text-2xl text-gray-800">
                    🏆 My Achievements
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Track your unlocked achievements and progress
                </p>

            </div>


            <div class="bg-indigo-100 text-indigo-700 px-4 py-2 rounded-full font-semibold">

                {{ $unlockedAchievements->count() }} / 6 Unlocked

            </div>


        </div>

    </x-slot>



    <div class="py-12 bg-gray-100 min-h-screen">


        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Unlocked Achievements -->

            @if($unlockedAchievements->count() > 0)

            <h3 class="text-xl font-bold text-gray-800 mb-4">
                ✅ Unlocked Achievements
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">


                @foreach($unlockedAchievements as $achievement)


                <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition p-6 relative overflow-hidden border-2 border-yellow-400">


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

            @endif

            <!-- Locked Achievements -->

            @if($lockedAchievements->count() > 0)

            <h3 class="text-xl font-bold text-gray-800 mb-4">
                🔒 Available Achievements
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                @foreach($lockedAchievements as $achievement)

                <div class="bg-white rounded-2xl shadow-lg p-6 relative overflow-hidden opacity-75">

                    <div class="absolute top-0 right-0 bg-gray-400 text-white px-4 py-1 rounded-bl-xl text-sm font-bold">

                        LOCKED

                    </div>

                    <div class="flex items-center gap-4">

                        <div class="w-16 h-16 bg-gradient-to-r from-gray-300 to-gray-400 rounded-full flex items-center justify-center text-3xl shadow">

                            {{ $achievement['icon'] }}

                        </div>

                        <div>

                            <h3 class="text-xl font-bold text-gray-800">

                                {{ $achievement['name'] }}

                            </h3>

                            <p class="text-gray-500 text-sm">

                                Achievement

                            </p>

                        </div>

                    </div>

                    <div class="mt-6">

                        <p class="text-gray-600 leading-relaxed">

                            {{ $achievement['description'] }}

                        </p>

                    </div>

                    <div class="mt-6 border-t pt-4">

                        <span class="text-sm text-gray-500">

                            Keep working to unlock this achievement!

                        </span>

                    </div>

                </div>

                @endforeach

            </div>

            @endif

            @if($unlockedAchievements->count() == 0 && $lockedAchievements->count() == 0)

                <div class="bg-white rounded-xl shadow p-10 text-center">

                    <div class="text-6xl mb-4">

                        🔒

                    </div>

                    <h3 class="text-xl font-bold">

                        No achievements available

                    </h3>

                    <p class="text-gray-500 mt-2">

                        Start creating posts and comments to unlock achievements.

                    </p>

                </div>

            @endif


        </div>


    </div>


</x-app-layout>