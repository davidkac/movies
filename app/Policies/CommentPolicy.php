<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    public function delete(User $user, Comment $comment)
    {
        // Samo autor komentara može da obriše komentar
        return $user->id === $comment->user_id;
    }
}