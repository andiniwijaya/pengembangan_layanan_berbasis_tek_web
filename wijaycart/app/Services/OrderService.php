<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderStatusHistory;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function recordHistory(Order $order, string $stepKey, string $label, ?\DateTimeInterface $recordedAt = null): void
    {
        OrderStatusHistory::record($order, $stepKey, $label, $recordedAt);
    }

    public function cancelOrder(Order $order): void
    {
        if (! $order->canBeCancelled()) {
            abort(403, 'Pesanan tidak dapat dibatalkan pada status ini.');
        }

        DB::transaction(function () use ($order) {
            $order->update(['status' => 'cancelled']);
            $this->restoreStock($order);
            $this->recordHistory($order, 'cancelled', 'Cancelled');
            NotificationService::send(
                $order->user_id,
                'Pesanan Dibatalkan',
                "Pesanan {$order->order_number} telah dibatalkan.",
                'order'
            );
        });
    }

    public function updateStatus(Order $order, string $newStatus): void
    {
        DB::transaction(function () use ($order, $newStatus) {
            $oldStatus = $order->status;

            if ($newStatus === 'cancelled' && $oldStatus !== 'cancelled') {
                $order->update(['status' => 'cancelled']);
                $this->restoreStock($order);
                $this->recordHistory($order, 'cancelled', 'Cancelled');
                NotificationService::send(
                    $order->user_id,
                    'Pesanan Dibatalkan',
                    "Pesanan {$order->order_number} telah dibatalkan.",
                    'order'
                );

                return;
            }

            $order->update(['status' => $newStatus]);

            match ($newStatus) {
                'processing' => $this->recordHistory($order, 'processing', 'Processing'),
                'shipped' => $this->recordHistory($order, 'shipped', 'Shipped'),
                'delivered' => $this->recordHistory($order, 'completed', 'Completed'),
                default => null,
            };

            $label = $order->fresh()->status_label;
            NotificationService::send(
                $order->user_id,
                'Status Pesanan Diperbarui',
                "Pesanan {$order->order_number} sekarang: {$label}.",
                'order'
            );
        });
    }

    public function markPaymentPaid(Order $order): void
    {
        if (! $order->payment) {
            return;
        }

        DB::transaction(function () use ($order) {
            if ($order->payment->status !== 'paid') {
                $order->payment->update([
                    'status' => 'paid',
                    'paid_at' => now(),
                ]);

                NotificationService::send(
                    $order->user_id,
                    'Pembayaran Diterima',
                    "Pembayaran pesanan {$order->order_number} telah dikonfirmasi.",
                    'payment'
                );
            }

            $this->recordHistory($order, 'paid', 'Paid');
        });
    }

    public function restoreStock(Order $order): void
    {
        if ($order->stock_restored) {
            return;
        }

        foreach ($order->items as $item) {
            Product::where('id', $item->product_id)->increment('stock', $item->quantity);
        }

        $order->update(['stock_restored' => true]);
    }
}
