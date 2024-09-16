<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Movie;


class MovieController extends Controller
{
    public function index() 
    {
        $movies = Movie::latest()->paginate(8);

        return view('movies.index', ['movies' => $movies]);
    } 

    public function show(Movie $movie) 
    {
        $movie->load(['comments' => function ($query) {
            $query->orderBy('created_at', 'desc'); 
        }]);

        $commentsCount = $movie->comments()->count();

        return view('movies.show', ['movies' => $movie , 'commentsCount' => $commentsCount]);
    } 

    public function create() 
    {
        return view('movies.create');
    } 

    public function store(Request $request) 
    {
        // Validacija podataka iz forme
        $data = $request->validate([
            'title' => ['required', 'string', 'min:3', 'max:255'], 
            'description' => ['required', 'string', 'min:10'], 
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], 
        ]);
    
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }
    
        Movie::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'image' => $data['image'],
            'user_id' => auth()->id(), 
        ]);
    
        return redirect('/movies')->with('success', 'Movie created successfully!');
    }
}
