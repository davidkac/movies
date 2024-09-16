<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use \App\Models\User;
use Illuminate\Http\UploadedFile;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
       
        $movieTitles = [
            'The Lost City', 'Moonlight Shadows', 'Echoes of Eternity',
            'Silent Whisper', 'Dreamland', 'Beyond the Horizon',
            'The Last Stand', 'Rise of the Titans', 'Fallen Kingdom', 'Infinite Worlds'
        ];

        return [
            'title' => $this->faker->randomElement($movieTitles),
            'description' => $this->faker->paragraph(), 
            'image' => fake()->imageUrl(), // URL slike (fake slika)
            'user_id' =>User::factory(), // Nasumično dodeli korisnika (ako postoji veza)
        ];
    }
}
