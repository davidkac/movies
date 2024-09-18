<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'image', 'user_id'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_movie');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function favoriteByUsers() 
    {
        return $this->belongsToMany(User::class,'favorites')->withTimestamps();
    }

    public function averageRating()
    {
        return $this->ratings()->avg('rating');
    }

    public function getShortDescriptionAttribute()
    {
        return strlen($this->description) > 100
            ? substr($this->description, 0, 60) . '...'
            : $this->description;
    }
}
