<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Migration untuk mengganti metode pembayaran ewallet menjadi QRIS.
 * Digunakan saat checkout dengan simulasi pembayaran QRIS.
 */
return new class extends Migration
{
    public function up(): void
    {
        DB::table('payments')->where('method', 'ewallet')->update(['method' => 'bank_transfer']);

        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE payments MODIFY COLUMN method ENUM('bank_transfer', 'qris', 'cod') NOT NULL DEFAULT 'bank_transfer'");
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE payments MODIFY COLUMN method ENUM('bank_transfer', 'ewallet', 'cod') NOT NULL DEFAULT 'bank_transfer'");
        }
    }
};
