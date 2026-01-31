<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('transaksi_stok', function (Blueprint $table) {
            $table->foreignId('adjustment_id')
                ->nullable()
                ->after('barang_id')
                ->constrained('stock_adjustments')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('transaksi_stok', function (Blueprint $table) {
            $table->dropForeign(['adjustment_id']);
            $table->dropColumn('adjustment_id');
        });
    }
};
