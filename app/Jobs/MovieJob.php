<?php

namespace App\Jobs;

use App\Mail\MovieNotification;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class MovieJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected readonly Movie $movie,
        protected readonly User $user,
        protected readonly string $rating
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->movie->user->email)
        ->send(
            new MovieNotification($this->movie, $this->user, $this->rating)
        );
    }
}
