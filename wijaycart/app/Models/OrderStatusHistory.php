<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderStatusHistory extends Model
{
    protected $fillable = [
        'order_id',
        'step_key',
        'label',
        'recorded_at',
    ];

    protected function casts(): array
    {
        return [
            'recorded_at' => 'datetime',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public static function record(Order $order, string $stepKey, string $label, ?\DateTimeInterface $recordedAt = null): self
    {
        return static::firstOrCreate(
            [
                'order_id' => $order->id,
                'step_key' => $stepKey,
            ],
            [
                'label' => $label,
                'recorded_at' => $recordedAt ?? now(),
            ]
        );
    }
}
