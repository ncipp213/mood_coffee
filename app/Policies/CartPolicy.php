<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Cart;

class CartPolicy
{
/**
     * Create a new policy instance.
     */

    public function update(User $user, Cart $cart) { return $user->id === $cart->user_id; }
    public function delete(User $user, Cart $cart) { return $user->id === $cart->user_id; }
    // sama untuk Favorite
    public function __construct()
    {
        //
    }
}
