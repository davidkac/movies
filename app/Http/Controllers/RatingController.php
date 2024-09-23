<?php

namespace App\Http\Controllers;

use App\Jobs\MovieJob;
use App\Models\Movie;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    use AuthorizesRequests;

    public function store(Request $request, Movie $movie)
    {

        // Validacija ocene
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ], [
            'rating.required' => 'Rating is required.',
            'rating.integer' => 'Rating must be a valid number.',
            'rating.min' => 'Rating must be between 1 and 5.',
            'rating.max' => 'Rating must be between 1 and 5.',
        ]);

        $user = Auth::user();

        // Provera da li je korisnik već ocenio film
        $existingRating = $movie->ratings()->where('user_id', auth()->id())->first();

        if ($existingRating) {
            // Ako ocena već postoji, ne dozvoljava ponovno ocenjivanje istog filma
            return redirect()->back()->with('info', 'Već ste ocenili ovaj film.');
        }

        // Ako ocena ne postoji, kreira se nova ocena
        $movie->ratings()->create([
            'user_id' => auth()->id(),
            'rating' => $request->input('rating'),
        ]);

        MovieJob::dispatch($movie, $user, $request->input('rating'));

        return redirect()->route('movie.show', $movie->id)->with('success', 'Hvala što ste ocenili film!');
    }
}
