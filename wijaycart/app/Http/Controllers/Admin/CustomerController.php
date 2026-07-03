<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function index(): View
    {
        $customers = User::where('role', 'customer')
            ->withCount('orders')
            ->latest()
            ->paginate(10);

        return view('admin.customers.index', compact('customers'));
    }

    public function show(User $customer): View
    {
        if (! $customer->isCustomer()) {
            abort(404);
        }

        $customer->load(['orders' => fn ($q) => $q->latest()->take(10)]);

        return view('admin.customers.show', compact('customer'));
    }
}
