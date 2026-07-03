<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    public function view(User $user, Order $order): bool
    {
        return $user->isAdmin() || $order->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->isCustomer();
    }

    public function updateStatus(User $user, Order $order): bool
    {
        return $user->isAdmin();
    }

    public function updatePayment(User $user, Order $order): bool
    {
        return $user->isAdmin();
    }

    public function cancel(User $user, Order $order): bool
    {
        return $order->user_id === $user->id && $order->canBeCancelled();
    }

    public function uploadPaymentProof(User $user, Order $order): bool
    {
        return $order->user_id === $user->id
            && $order->payment?->requiresProofUpload();
    }
}
