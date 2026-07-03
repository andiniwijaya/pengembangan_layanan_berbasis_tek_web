<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewStoreRequest;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;

class ReviewController extends Controller
{
    public function store(ReviewStoreRequest $request, Product $product): RedirectResponse
    {
        $this->authorize('review', $product);

        $order = Order::where('id', $request->order_id)
            ->where('user_id', auth()->id())
            ->where('status', 'delivered')
            ->whereHas('items', fn ($q) => $q->where('product_id', $product->id))
            ->firstOrFail();

        Review::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'order_id' => $order->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Ulasan berhasil dikirim.');
    }
}
