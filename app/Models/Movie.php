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

    public function getShortDescriptionAttribute()
    {
        return strlen($this->description) > 100 
            ? substr($this->description, 0, 60) . '...' 
            : $this->description;
    }
}
