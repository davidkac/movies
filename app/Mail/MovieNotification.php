<?php

namespace App\Mail;

use App\Models\Movie;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MovieNotification extends Mailable
{
    use Queueable, SerializesModels;

    protected $movie;
    protected $user;
    protected $rating;


    /**
     * Create a new message instance.
     */
    public function __construct(Movie $movie,User $user, string $rating)
    {
        $this->movie = $movie;
        $this->user = $user;
        $this->rating = $rating;
    }

    public function build()
    {
    
        return $this->subject('New Reaction on Your Movie')
                    ->markdown('mail.movie-posted', [
                        'movie' => $this->movie,
                        'userName' => $this->user->name,
                        'userEmail' => $this->user->email,
                        'rating' => $this->rating,
                    ]);
                }
}