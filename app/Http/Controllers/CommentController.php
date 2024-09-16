<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
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
}
