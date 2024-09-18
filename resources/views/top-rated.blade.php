<x-layout>
    <x-slot:heading>
        Top Rated Movies
    </x-slot:heading>

    <div class="max-w-4xl mx-auto bg-gray-900 p-6 rounded-lg shadow-md text-white">
        <h2 class="text-2xl font-bold mb-4">Top Rated Movies</h2>

        @forelse($movies as $movie)
            <div class="flex items-center justify-between mb-4 p-4 bg-gray-800 text-white rounded-lg shadow-lg">
                <!-- Slika filma -->
                <div class="flex items-center">
                    <img src="{{ filter_var($movie->image, FILTER_VALIDATE_URL) ? $movie->image : asset('storage/' . $movie->image) }}" 
                        alt="{{ $movie->title }}" 
                        class="w-20 h-20 rounded-lg object-cover mr-4">
                    
                    <!-- Naslov filma i prosečna ocena -->
                    <div>
                        <a href="{{ route('movie.show', $movie->id) }}" class="text-lg font-semibold text-blue-400">
                            {{ $movie->title }}
                        </a>
                        <p class="text-gray-300">Rating: {{ number_format($movie->average_rating, 1) }}</p>
                    </div>
                </div>
                
                <!-- Dugme za dodavanje u omiljene ili uklanjanje - samo za ulogovane korisnike -->
                @auth
                    @if (auth()->user()->favoriteMovies->contains($movie->id))
                        <form action="{{ route('favorites.remove', $movie->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                                Remove from Favorites
                            </button>
                        </form>
                    @else
                        <form action="{{ route('favorites.add', $movie->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                Add to Favorites
                            </button>
                        </form>
                    @endif
                @endauth

                <!-- Prikaz datuma kreiranja filma za goste - ako nisu ulogovani -->
                @guest
                    <p class="text-gray-400 italic">Released: {{ $movie->created_at->format('F d, Y') }}</p>
                @endguest
            </div>
        @empty
            <p class="text-gray-500">There are no top-rated movies with a rating higher than 3.</p>
        @endforelse
    </div>
</x-layout>
