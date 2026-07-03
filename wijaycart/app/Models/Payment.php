<?php

namespace App\Models;

use App\Support\ImageAssets;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'method',
        'status',
        'amount',
        'paid_at',
        'payment_proof',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'paid_at' => 'datetime',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function getMethodLabelAttribute(): string
    {
        return match ($this->method) {
            'bank_transfer' => 'Transfer Bank',
            'qris' => 'QRIS',
            'cod' => 'Cash On Delivery (COD)',
            default => $this->method,
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Menunggu Pembayaran',
            'paid' => 'Lunas',
            'failed' => 'Gagal',
            'refunded' => 'Dikembalikan',
            default => $this->status,
        };
    }

    public function getPaymentProofUrlAttribute(): ?string
    {
        if (! $this->payment_proof) {
            return null;
        }

        return ImageAssets::storageUrl($this->payment_proof, '');
    }

    public function requiresProofUpload(): bool
    {
        return in_array($this->method, ['bank_transfer', 'qris'], true)
            && $this->status === 'pending';
    }
}
