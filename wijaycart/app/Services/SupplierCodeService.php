<?php

namespace App\Services;

use App\Models\Supplier;

class SupplierCodeService
{
    public function generateUnique(): string
    {
        do {
            $last = Supplier::orderByDesc('id')->first();
            $next = $last ? $last->id + 1 : 1;
            $code = 'SUP'.str_pad((string) $next, 4, '0', STR_PAD_LEFT);
        } while (Supplier::where('code', $code)->exists());

        return $code;
    }
}
