<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Movie;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Kreiranje 10 korisnika
        $users = User::factory(10)->create();

        // Kreiranje filmova za svakog korisnika, bez duplih naslova
        $users->each(function ($user) {
            // Generisanje nasumičnog broja filmova za svakog korisnika
            $movies = Movie::factory(rand(1, 3))->create([
                'user_id' => $user->id, // Dodela filma korisniku
            ]);

            // Dodavanje komentara svakom filmu od različitih korisnika
            $movies->each(function ($movie) use ($user) {
                $commentingUsers = User::where('id', '!=', $user->id)->inRandomOrder()->take(rand(1, 5))->get();

                // Kreiranje komentara od različitih korisnika
                $commentingUsers->each(function ($commentingUser) use ($movie) {
                    Comment::factory()->create([
                        'movie_id' => $movie->id,
                        'user_id' => $commentingUser->id, // Komentarišu različiti korisnici
                    ]);
                });
            });
        });
    }
}
