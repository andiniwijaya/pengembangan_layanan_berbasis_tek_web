<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Wishlist;

class WishlistPolicy
{
    public function create(User $user): bool
    {
        return $user->isCustomer();
    }

    public function delete(User $user, Wishlist $wishlist): bool
    {
        return $wishlist->user_id === $user->id;
    }
}
