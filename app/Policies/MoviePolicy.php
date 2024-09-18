<?php

namespace App\Policies;

use App\Models\Movie;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MoviePolicy
{
    public function edit(User $user, Movie $movie): bool
    {
        return $movie->user->is($user);
    }

    public function delete(User $user, Movie $movie): bool
    {
        return $movie->user->is($user);
    }

    public function rate(User $user, Movie $movie)
    {
        // Vraća false ako je korisnik autor filma
        return $user->id !== $movie->user_id;
    }
}