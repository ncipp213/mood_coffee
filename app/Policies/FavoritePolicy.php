<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Favorite;

class FavoritePolicy
{
    /**
     * Create a new policy instance.
     */

    public function update(User $user, favorite $favorite) { return $user->id === $favorite->user_id; }
    public function delete(User $user, favorite $favorite) { return $user->id === $favorite->user_id; }
    // sama untuk Favorite
    public function __construct()
    {
        //
    }
}
