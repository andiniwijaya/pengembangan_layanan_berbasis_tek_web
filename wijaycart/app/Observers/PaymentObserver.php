<?php

namespace App\Observers;

use App\Models\OrderStatusHistory;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class PaymentObserver
{
    public function created(Payment $payment): void
    {
        $order = $payment->order;

        if (! $order) {
            return;
        }

        OrderStatusHistory::record(
            $order,
            'order_created',
            'Order Created',
            $order->created_at
        );

        if (in_array($payment->method, ['bank_transfer', 'qris'], true) && $payment->status === 'pending') {
            OrderStatusHistory::record($order, 'waiting_payment', 'Waiting Payment');

            if (DB::getDriverName() === 'mysql') {
                $order->update(['status' => 'waiting_payment']);
            }
        }
    }
}
