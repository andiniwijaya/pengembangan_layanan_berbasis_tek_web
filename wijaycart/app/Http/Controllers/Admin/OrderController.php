<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OrderPaymentUpdateRequest;
use App\Http\Requests\Admin\OrderStatusUpdateRequest;
use App\Models\Order;
use App\Models\Payment;
use App\Services\OrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct(private OrderService $orderService) {}

    public function index(Request $request): View
    {
        $query = Order::with(['user', 'payment']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->get('payment') === 'pending') {
            $query->whereHas('payment', fn ($q) => $q->where('status', 'pending'));
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('shipping_name', 'like', "%{$search}%");
            });
        }

        $orders = $query->latest()->paginate(10)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $order->load(['user', 'items.product', 'payment', 'statusHistories']);

        return view('admin.orders.show', [
            'order' => $order,
            'timelineSteps' => $order->getTimelineSteps(),
        ]);
    }

    public function updateStatus(OrderStatusUpdateRequest $request, Order $order): RedirectResponse
    {
        $this->orderService->updateStatus($order, $request->status);

        if ($request->status === 'delivered') {
            $this->orderService->markPaymentPaid($order);
        }

        return back()->with('success', 'Status pesanan diperbarui.');
    }

    public function updatePayment(OrderPaymentUpdateRequest $request, Order $order): RedirectResponse
    {
        $payment = $order->payment ?? Payment::create([
            'order_id' => $order->id,
            'method' => 'bank_transfer',
            'amount' => $order->total,
        ]);

        $payment->update([
            'status' => $request->status,
            'paid_at' => $request->status === 'paid' ? now() : null,
        ]);

        if ($request->status === 'paid') {
            $this->orderService->markPaymentPaid($order);
        }

        return back()->with('success', 'Status pembayaran diperbarui.');
    }
}
