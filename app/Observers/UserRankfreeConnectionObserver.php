<?php

namespace App\Observers;

use App\Models\RankfreeConnection;
use App\Models\User;

class UserRankfreeConnectionObserver
{
    public function deleted(User $user): void
    {
        RankfreeConnection::query()->where('user_id', $user->getKey())->delete();
    }
}
