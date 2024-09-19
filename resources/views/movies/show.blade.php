<x-layout>
    <x-slot:heading>
        Movie Details
    </x-slot:heading>

    <div class="max-w-4xl mx-auto bg-gray-800 p-6 rounded-lg shadow-md text-white">
        <div class="flex flex-col lg:flex-row">
            <!-- Prikaz slike filma -->
            <div class="mb-6 lg:mb-0 lg:mr-6">
                <img src="{{ filter_var($movies->image, FILTER_VALIDATE_URL) ? $movies->image : asset('storage/' . $movies->image) }}"
                    alt="{{ $movies->title }}"
                    class="rounded-xl w-[300px] h-[450px] object-cover">
            </div>

            <!-- Prikaz naslova, kreatora i opisa -->
            <div class="flex-1">
                <h1 class="text-2xl font-bold text-white mb-2">Title: {{ $movies->title }}</h1>
                <p class="text-md font-semibold text-gray-300"><strong>Creator:</strong> {{ $movies->user->name }}</p>
                <p class="mt-4 text-gray-300"><strong>Description:</strong> {{ $movies->description }}</p>

                <!-- Prikaz kategorija u jednoj liniji -->
                <p class="mt-4 text-gray-300">
                    <strong>Categories:</strong>
                    @foreach($movies->categories as $category)
                    <span class="inline-block bg-purple-600 text-white text-xs px-2 py-1 rounded-full">
                        {{ $category->name }}
                    </span>
                    @endforeach
                </p>

                <!-- Prikaz prosečne ocene i forma za ocenjivanje -->
                <div class="mt-4">
                    <p class="text-gray-300">
                        <strong>Rating:</strong> {{ number_format($averageRating, 1) ?? '' }}
                        @if ($userRating)
                        (You rated: {{ $userRating->rating }})
                        @endif
                    </p>

                    <!-- Forma za ocenjivanje ako korisnik nije ocenio film -->
                    @if (!$userRating)
                    <form action="{{ route('ratings.store', $movies) }}" method="POST" class="mt-2">
                        @csrf
                        <label for="rating" class="block text-gray-300">How would you rate this movie?</label>
                        <select name="rating" class="border border-gray-600 rounded p-2 mt-1 bg-gray-700 text-white">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded mt-2 hover:bg-blue-600">
                            Rate
                        </button>
                    </form>
                    @else
                    <p class="mt-2 text-green-400">Thank you for rating this movie!</p>
                    @endif
                </div>

                <!-- Edit i Delete dugmad -->
                @can('edit', $movies)
                <div class="mt-4 flex space-x-2">
                    <a href="{{ route('movies.edit', $movies->id) }}"
                        class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">EDIT</a>
                    @endcan
                    @can('delete', $movies)
                    <form id="delete-movie-form" action="{{ route('movies.destroy', $movies->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this movie?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">DELETE</button>
                    </form>
                    @endcan

                </div>
            </div>
            @auth
            <div class="mt-4">
                @if (auth()->user()->favoriteMovies->contains($movies->id))
                <form action="{{ route('favorites.remove', $movies->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                        Remove from Favorites
                    </button>
                </form>
                @else
                <form action="{{ route('favorites.add', $movies->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Add to Favorites
                    </button>
                </form>
                @endif
            </div>
            @endauth
        </div>

        <!-- Sekcija komentara -->
        <div class="mt-8">
            <h2 class="text-xl font-semibold text-gray-200 mb-3">{{ $commentsCount }} Comments</h2>
            <div class="mt-3">
                <form action="{{ route('comment.store', $movies->id) }}" method="POST" class="flex flex-col gap-2">
                    @csrf
                    <textarea
                        name="content"
                        rows="1"
                        placeholder="Add a public comment..."
                        class="border-b border-gray-500 p-1 focus:outline-none focus:border-blue-400 resize-none h-8 bg-gray-700 text-white"
                        style="box-shadow: none; min-height: 36px;"></textarea>
                    <div class="flex justify-end gap-2">
                        <button type="button" class="text-gray-400 hover:text-gray-500">Cancel</button>
                        <button
                            type="submit"
                            class="bg-blue-500 text-white py-1 px-4 rounded-lg hover:bg-blue-600 disabled:bg-gray-400 disabled:cursor-not-allowed"
                            @guest disabled @endguest>
                            Comment
                        </button>
                    </div>
                </form>

                <div class="mt-8">
                    @forelse($movies->comments as $comment)
                    <div class="bg-gray-700 p-4 rounded-lg mb-4 flex justify-between items-center">
                        <div>
                            <p class="text-sm text-white"><strong>User:</strong> {{ $comment->user->name }}</p>
                            <p class="text-xs text-gray-300 mt-2">{{ $comment->content }}</p>
                        </div>
                        <!-- Prikaz X dugmeta samo ako je ulogovani korisnik autor komentara -->
                        @can('delete', $comment)
                        <form action="{{ route('comment.destroy', [$movies->id, $comment->id]) }}" method="POST" class="ml-4">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700">
                                delete comment
                            </button>
                        </form>
                        @endcan
                    </div>
                    @empty
                    <p class="text-sm text-gray-400">No comments yet. Be the first to comment!</p>
                    @endforelse
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (window.history.replaceState) {
                    window.history.replaceState(null, null, window.location.href);
                }

                // Spreči default submit ponašanje i zameni unos u istoriji
                document.querySelectorAll('form').forEach(form => {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault(); // Sprečava default ponašanje forme

                        fetch(this.action, {
                            method: this.method,
                            body: new FormData(this)
                        }).then(response => {
                            if (response.ok) {
                                if (this.id === 'delete-movie-form') {
                                    // Ako je forma za brisanje filma, redirect na /movies
                                    window.location.href = '/movies';
                                } else {
                                    // Osveži stranicu nakon komentara ili druge akcije
                                    window.history.replaceState(null, null, window.location.href); // Zamenjuje trenutni unos
                                    location.reload(); // Osvežava stranicu bez dodavanja u istoriju
                                }
                            } else {
                                alert('An error occurred. Please try again.');
                            }
                        });
                    });
                });
            });
            
        </script>
</x-layout>