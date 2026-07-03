<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_number',
        'status',
        'stock_restored',
        'subtotal',
        'shipping_cost',
        'total',
        'shipping_name',
        'shipping_phone',
        'shipping_address',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'shipping_cost' => 'decimal:2',
            'total' => 'decimal:2',
            'stock_restored' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function statusHistories(): HasMany
    {
        return $this->hasMany(OrderStatusHistory::class)->orderBy('recorded_at');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending', 'waiting_payment'], true);
    }

    public function effectiveStatus(): string
    {
        if ($this->status === 'pending' && $this->payment
            && in_array($this->payment->method, ['bank_transfer', 'qris'], true)
            && $this->payment->status === 'pending') {
            return 'waiting_payment';
        }

        return $this->status;
    }

    public static function userHasDeliveredProduct(int $userId, int $productId): bool
    {
        return OrderItem::query()
            ->where('product_id', $productId)
            ->whereHas('order', fn ($q) => $q
                ->where('user_id', $userId)
                ->where('status', 'delivered'))
            ->exists();
    }

    public function getTimelineSteps(): array
    {
        $histories = $this->statusHistories->keyBy('step_key');
        $isCancelled = $this->status === 'cancelled';
        $needsWaitingPayment = ($this->payment && in_array($this->payment->method, ['bank_transfer', 'qris'], true))
            || $histories->has('waiting_payment');

        $definitions = [
            ['key' => 'order_created', 'label' => 'Order Created'],
            ['key' => 'waiting_payment', 'label' => 'Waiting Payment', 'skip' => ! $needsWaitingPayment],
            ['key' => 'paid', 'label' => 'Paid', 'skip' => $isCancelled && ! $histories->has('paid')],
            ['key' => 'processing', 'label' => 'Processing', 'skip' => $isCancelled],
            ['key' => 'shipped', 'label' => 'Shipped', 'skip' => $isCancelled],
            ['key' => 'completed', 'label' => 'Completed', 'skip' => $isCancelled],
            ['key' => 'cancelled', 'label' => 'Cancelled', 'skip' => ! $isCancelled],
        ];

        $steps = [];
        $foundCurrent = false;

        foreach ($definitions as $definition) {
            if ($definition['skip'] ?? false) {
                continue;
            }

            $history = $histories->get($definition['key']);
            $completed = $history !== null;
            $current = false;

            if (! $foundCurrent && ! $completed) {
                $current = ! $isCancelled || $definition['key'] === 'cancelled';
                $foundCurrent = $current;
            }

            if ($isCancelled && $definition['key'] === 'cancelled') {
                $completed = true;
                $current = true;
            }

            $steps[] = [
                'key' => $definition['key'],
                'label' => $definition['label'],
                'completed' => $completed,
                'current' => $current,
                'recorded_at' => $history?->recorded_at,
            ];
        }

        return $steps;
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Menunggu',
            'waiting_payment' => 'Menunggu Pembayaran',
            'processing' => 'Diproses',
            'shipped' => 'Dikirim',
            'delivered' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'warning',
            'waiting_payment' => 'warning',
            'processing' => 'warning',
            'shipped' => 'warning',
            'delivered' => 'success',
            'cancelled' => 'danger',
            default => 'warning',
        };
    }
}
