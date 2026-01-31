<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('transaksi_stok', function (Blueprint $table) {
            $table->foreignId('dispatch_id')
                ->nullable()
                ->after('barang_id')
                ->constrained('dispatches')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('transaksi_stok', function (Blueprint $table) {
            $table->dropForeign(['dispatch_id']);
            $table->dropColumn('dispatch_id');
        });
    }
};
