<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentProofRequest;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct(private OrderService $orderService) {}

    public function index(): View
    {
        $orders = Order::with('payment')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $this->authorize('view', $order);

        $order->load(['items.product', 'payment', 'statusHistories']);

        return view('orders.show', [
            'order' => $order,
            'timelineSteps' => $order->getTimelineSteps(),
        ]);
    }

    public function cancel(Order $order): RedirectResponse
    {
        $this->authorize('cancel', $order);

        $this->orderService->cancelOrder($order);

        return redirect()->route('orders.show', $order)->with('success', 'Pesanan berhasil dibatalkan.');
    }

    public function uploadPaymentProof(PaymentProofRequest $request, Order $order): RedirectResponse
    {
        $this->authorize('uploadPaymentProof', $order);

        $payment = $order->payment;

        if ($payment->payment_proof) {
            Storage::disk('public')->delete($payment->payment_proof);
        }

        $path = $request->file('payment_proof')->store('payment-proofs', 'public');
        $payment->update(['payment_proof' => $path]);

        return back()->with('success', 'Bukti pembayaran berhasil diunggah.');
    }
}
