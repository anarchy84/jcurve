<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    public function update(User $user, Comment $comment): bool
    {
        return $this->isOwnerOrAdmin($user, $comment->user_id);
    }

    public function delete(User $user, Comment $comment): bool
    {
        return $this->isOwnerOrAdmin($user, $comment->user_id);
    }

    private function isOwnerOrAdmin(User $user, int $ownerId): bool
    {
        return $user->role === 'admin'
            || (int) $user->getKey() === $ownerId;
    }
}
