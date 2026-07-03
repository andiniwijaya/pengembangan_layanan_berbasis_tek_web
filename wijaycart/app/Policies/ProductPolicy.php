<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;

class ProductPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Product $product): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Product $product): bool
    {
        return $user->isAdmin();
    }

    public function review(User $user, Product $product): bool
    {
        if (! $user->isCustomer()) {
            return false;
        }

        if (Review::where('user_id', $user->id)->where('product_id', $product->id)->exists()) {
            return false;
        }

        return Order::userHasDeliveredProduct($user->id, $product->id);
    }
}
