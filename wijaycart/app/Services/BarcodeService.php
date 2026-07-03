<?php

namespace App\Services;

use App\Models\Product;

class BarcodeService
{
    public function generate(): string
    {
        $lastProduct = Product::orderByDesc('id')->first();
        $nextNumber = $lastProduct ? $lastProduct->id + 1 : 1;

        return 'PRD'.str_pad((string) $nextNumber, 6, '0', STR_PAD_LEFT);
    }

    public function generateUnique(): string
    {
        do {
            $barcode = $this->generate();
        } while (Product::where('barcode', $barcode)->exists());

        return $barcode;
    }
}
