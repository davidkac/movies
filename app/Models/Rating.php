<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = ['movie_id','user_id','rating'];

    public function user()
    {
        $this->belongsTo(User::class);
    }


    public function movie()
    {
        $this->belongsTo(Movie::class);
    }

}
