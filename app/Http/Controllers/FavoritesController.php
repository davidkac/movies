<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        
        $favoriteMovies = auth()->user()->favoriteMovies()->latest()->simplePaginate(5);

        return view('favorite', compact('favoriteMovies'));
    }

    public function addToFavorites(Movie $movie)
    {
        if (!auth()->user()->favoriteMovies->contains($movie->id)) {
            auth()->user()->favoriteMovies()->attach($movie->id);

            return redirect()->back()->with('success', 'Movie added to favorites');
        }
        return redirect()->back()->with('info', 'Movie is already in favorites');
    }

    public function removeFromFavorites(Movie $movie)
    {
        auth()->user()->favoriteMovies()->detach($movie->id);

        return redirect()->back()->with('success', 'Movie is successfully removed from favorites');

    }
}
