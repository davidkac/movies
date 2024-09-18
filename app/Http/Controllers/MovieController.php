<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Movie;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class MovieController extends Controller
{
    use AuthorizesRequests;

    public function topRatedMovies()
    {
        // Dohvatanje filmova čiji je prosečni rejting veći od 3
        $movies = Movie::with('ratings')
            ->withCount(['ratings as average_rating' => function ($query) {
                $query->select(\DB::raw('coalesce(avg(rating), 0)'));
            }])
            ->having('average_rating', '>', 3)
            ->orderByDesc('average_rating')
            ->take(10)
            ->get();

        // $movies = Movie::with('ratings')
        //     ->select('movies.*')
        //     ->join('ratings', 'ratings.movie_id', '=', 'movies.id')
        //     ->selectRaw('avg(ratings.rating) as average_rating')
        //     ->groupBy('movies.id')
        //     ->having('average_rating', '>', 3)
        //     ->orderByDesc('average_rating')
        //     ->paginate(10)
        return view('top-rated', compact('movies'));
    }

    public function index(Request $request)
    {
        $search = $request->input('search');

        // Pretražuje filmove po nazivu ili kategorijama
        $movies = Movie::with('categories', 'user')
            ->when($search, function ($query, $search) {
                // Pretraga po nazivu filma
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhereHas('categories', function ($q) use ($search) {
                        // Pretraga po nazivu kategorije
                        $q->where('name', 'like', '%' . $search . '%');
                    });
            })
            ->latest()
            ->simplePaginate(8);

        return view('movies.index', ['movies' => $movies]);
    }

    public function show(Movie $movie)
    {
        $movie->load(['comments' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }]);

        $commentsCount = $movie->comments()->count();
        $userRating = $movie->ratings()->where('user_id', auth()->id())->first();
        $averageRating = $movie->averageRating();

        return view('movies.show', [
            'movies' => $movie,
            'commentsCount' => $commentsCount,
            'userRating' => $userRating,
            'averageRating' => $averageRating,
        ]);
    }

    public function create()
    {
        $categories = Category::all();
        return view('movies.create', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'description' => ['required', 'string', 'min:10'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'categories' => ['required', 'array'],
            'categories.*' => ['exists:categories,id'],
        ], [
            'image.required' => 'An image is required.', // Prilagođena poruka za obavezno polje slike
            'image.image' => 'The file must be a valid image (jpeg, png, jpg, gif).', // Prilagođena poruka za neispravan tip fajla
            'image.mimes' => 'Please upload a valid image file. Allowed formats: jpeg, png, jpg, gif.', // Prilagođena poruka za neodgovarajući format
            'image.max' => 'The image must not be larger than 2MB.', // Prilagođena poruka za preveliku sliku
            'categories.required' => 'At least one category must be selected.',
        ]);

        // Čuvanje slike
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        // Kreiranje filma i povezivanje sa korisnikom
        $movie = Movie::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'image' => $data['image'],
            'user_id' => auth()->id(),
        ]);

        // Povezivanje filma sa izabranim kategorijama
        if (!empty($data['categories'])) {
            $movie->categories()->attach($data['categories']);
        }

        return redirect('/movies');
    }

    public function edit(Movie $movie)
    {
        $this->authorize('edit', $movie);

        // Dohvati sve kategorije za prikaz u formi
        $categories = Category::all();
        return view('movies.edit', ['movie' => $movie, 'categories' => $categories]);
    }

    public function update(Request $request, Movie $movie)
    {

        // Validacija podataka iz forme
        $data = $request->validate([
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'description' => ['required', 'string', 'min:10'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'categories' => ['nullable', 'array'], // Validacija kategorija kao niza
            'categories.*' => ['exists:categories,id'], // Proverava da svaki ID postoji u bazi
        ], [
            'image.required' => 'An image is required.', // Prilagođena poruka za obavezno polje slike
            'image.image' => 'The file must be a valid image (jpeg, png, jpg, gif).', // Prilagođena poruka za neispravan tip fajla
            'image.mimes' => 'Please upload a valid image file. Allowed formats: jpeg, png, jpg, gif.', // Prilagođena poruka za neodgovarajući format
            'image.max' => 'The image must not be larger than 2MB.', // Prilagođena poruka za preveliku sliku
            'categories.required' => 'At least one category must be selected.',
        ]);

        // Ažuriranje slike ako postoji nova slika
        if ($request->hasFile('image')) {
            // Opcionalno: obriši staru sliku ako je potrebno
            if ($movie->image) {
                \Storage::disk('public')->delete($movie->image);
            }
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        // Ažuriranje podataka o filmu
        $movie->update([
            'title' => $data['title'],
            'description' => $data['description'],
            'image' => $data['image'] ?? $movie->image, // Koristi novu sliku ili ostavi staru
        ]);

        // Ažuriranje kategorija
        if (!empty($data['categories'])) {
            $movie->categories()->sync($data['categories']);
        }

        return redirect('/movies')->with('success', 'Movie updated successfully!');
    }


    public function destroy(Movie $movie)
    {
        $this->authorize('delete', $movie);
    
        // Brisanje filma
        $movie->delete();
    
        // Redirektuj na listu filmova
        return redirect()->route('movies.index')->with('success', 'Movie deleted successfully!');
    }
    
}
