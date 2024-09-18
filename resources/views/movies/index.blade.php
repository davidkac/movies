<x-layout>
    <x-slot:heading>
        Movies
    </x-slot:heading>

    <div class="bg-gradient-to-r from-gray-800 via-purple-800 to-gray-900 shadow text-white">
        <!-- Search Input -->
        <div class="max-w-2xl mx-auto py-4 px-4 lg:px-8">
            <form action="{{ route('movies.index') }}" method="GET" class="mt-6 flex items-center space-x-4">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="w-full p-2 border border-gray-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 bg-purple-200 placeholder-gray-700 text-gray-900"
                    placeholder="Search movies by title or category...">
                <button type="submit"
                    class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700 transition">Search</button>
            </form>
        </div>

        <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
            <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                @forelse($movies as $movie)
                <div class="group relative transform transition duration-300 ease-in-out hover:scale-105 hover:shadow-lg bg-gray-800 rounded-md overflow-hidden">
                    <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden group-hover:opacity-75">
                        <a href="/movies/{{ $movie->id }}">
                            <img src="{{ filter_var($movie->image, FILTER_VALIDATE_URL) ? $movie->image : asset('storage/' . $movie->image) }}"
                                alt="{{ $movie->title }}" class="rounded-xl w-full h-[330px] object-cover">
                        </a>
                    </div>
                    <div class="p-4">
                        <h3 class="text-sm font-medium text-white">
                            <strong>Title:</strong> {{ $movie->title }}
                        </h3>
                        <p class="text-sm font-medium text-white"><strong>Creator:</strong> {{ $movie->user->name }}</p>
                        <p class="text-sm font-medium text-white flex items-center">
                            @if ($movie->averageRating() > 0)
                            <i class="fas fa-star text-yellow-400"></i>
                            <span class="ml-1">
                                {{ number_format($movie->averageRating(), 1) }}
                            </span>
                            @else
                            <span>No rating</span>
                            @endif
                        </p>

                        <p class="text-sm font-medium text-white">Categories:
                            @foreach($movie->categories as $category)
                            <span class="inline-block bg-purple-600 text-white text-xs px-2 py-1 rounded-full">
                                {{ $category->name }}
                            </span>
                            @endforeach
                        </p>
                    </div>
                </div>
                @empty
                <!-- Poruka koja se prikazuje kada nema filmova po kriterijumu pretrage -->
                <div class="col-span-full text-center py-10">
                    <p class="text-white-500 text-lg">No movies found matching your criteria.</p>
                </div>
                @endforelse
            </div>
            <div class="mt-8">
                {{ $movies->links() }}
            </div>
        </div>
    </div>
</x-layout>