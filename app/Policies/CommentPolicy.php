<?php

namespace App\Policies;

use App\Models\Program\Comment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function before($user, $ability)
    {
        if ($user->is_admin === 1) {
            return true;
        }
    }

    public function update(User $user, Comment $comment)
    {
        return $user->id == $comment->user_id;
    }

    public function delete(User $user, Comment $comment)
    {
        return $user->id == $comment->user_id;
    }
}
