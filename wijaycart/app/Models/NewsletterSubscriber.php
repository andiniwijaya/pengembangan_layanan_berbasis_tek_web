<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class NewsletterSubscriber extends Model
{
    protected $fillable = [
        'email',
        'subscribed_at',
        'is_active',
        'unsubscribe_token',
    ];

    protected function casts(): array
    {
        return [
            'subscribed_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    public static function subscribe(string $email): self
    {
        $subscriber = static::where('email', $email)->first();

        if ($subscriber) {
            $subscriber->update([
                'is_active' => true,
                'subscribed_at' => now(),
            ]);

            return $subscriber;
        }

        return static::create([
            'email' => $email,
            'subscribed_at' => now(),
            'is_active' => true,
            'unsubscribe_token' => Str::random(32),
        ]);
    }
}
