<x-layout>
    <x-slot:heading>
        My Favorite Movies
    </x-slot:heading>

    <div class="max-w-4xl mx-auto bg-gray-900 p-6 rounded-lg shadow-md text-white">
        <h2 class="text-2xl font-bold mb-4">My Favorites</h2>

        @forelse($favoriteMovies as $movie)
            <div class="flex items-center justify-between mb-4 p-4 bg-gray-800 text-white rounded-lg shadow-lg">
                <!-- Slika filma (veća, kockasta, sa blagim zaobljenim ivicama) -->
                <div class="flex items-center">
                    <img src="{{ filter_var($movie->image, FILTER_VALIDATE_URL) ? $movie->image : asset('storage/' . $movie->image) }}" 
                        alt="{{ $movie->title }}" 
                        class="w-20 h-20 rounded-lg object-cover mr-4">
                    
                    <!-- Naslov filma -->
                    <a href="{{ route('movie.show', $movie->id) }}" class="text-lg font-semibold text-blue-400">
                        {{ $movie->title }}
                    </a>
                </div>
                
                <!-- Dugme za uklanjanje iz omiljenih -->
                <form action="{{ route('favorites.remove', $movie->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                        Remove from Favorites
                    </button>
                </form>
            </div>
        @empty
            <p class="text-gray-500">You have no favorite movies yet.</p>
        @endforelse

        <div class="mt-6">
            {{ $favoriteMovies->links() }}
        </div>
    </div>
</x-layout>
