<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

    use AuthorizesRequests;

    public function store(Request $request, Movie $movie)
    {
 
        $validatedData = $request->validate([
            'content' => 'required|string|max:500',
        ]);

        Comment::create([
            'content' => $validatedData['content'],
            'movie_id' => $movie->id,
            'user_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Comment added successfully!');
    }

    public function destroy(Movie $movie, Comment $comment)
    {
        // Provera autorizacije - da li je ulogovani korisnik autor komentara
        $this->authorize('delete', $comment);

        // Brisanje komentara
        $comment->delete();

        return redirect()->route('movie.show', $movie->id)->with('success', 'Comment is successfully deleted');
    }
}
