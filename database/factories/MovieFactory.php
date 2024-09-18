<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Movie;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class MovieFactory extends Factory
{
    protected $model = Movie::class;

    public function definition(): array
    {
        $movieTitles = [
            'The Lost City', 'Moonlight Shadows', 'Echoes of Eternity',
            'Silent Whisper', 'Dreamland', 'Beyond the Horizon',
            'The Last Stand', 'Rise of the Titans', 'Fallen Kingdom', 'Infinite Worlds'
        ];

        return [
            'title' => $this->faker->unique()->randomElement($movieTitles),
            'description' => $this->faker->paragraph(),
            'image' => fake()->imageUrl(), // URL slike (fake slika)
            'user_id' => User::factory(), // Nasumično dodeli korisnika
        ];
    }
}
