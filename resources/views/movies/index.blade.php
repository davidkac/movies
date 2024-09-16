<x-layout>
    <x-slot:heading>
        Movies
    </x-slot:heading>

    <div class="bg-white">
        <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
            <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                @foreach($movies as $movie)
                <div class="group relative transform transition duration-300 ease-in-out hover:scale-105 hover:shadow-lg">
                    <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-md bg-gray-200 group-hover:opacity-75">
                        <a href="/movies/{{ $movie->id }}">
                            <img src="{{ filter_var($movie->image, FILTER_VALIDATE_URL) ? $movie->image : asset('storage/' . $movie->image) }}" alt="{{ $movie->title }}" class="rounded-xl w-full h-auto">


                        </a>
                    </div>
                    <div class="mt-4 flex justify-between">
                        <div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-900">
                                    <strong>Title:</strong> {{ $movie->title }}
                                </h3>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900"><strong>Creator:</strong> {{ $movie->user->name }}</p>
                                <p class="mt-1 text-sm text-gray-500"><strong>Description</strong> {{ $movie->short_description}}</p>
                            </div>

                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-8">
                {{ $movies->links() }}
            </div>
        </div>
    </div>
</x-layout>