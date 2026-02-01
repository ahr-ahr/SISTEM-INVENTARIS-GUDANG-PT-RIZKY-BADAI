<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stock_adjustments', function (Blueprint $table) {

            $table->foreignId('warehouse_id')
                ->nullable()
                ->after('barang_id')
                ->constrained('warehouses')
                ->nullOnDelete();

            $table->foreignId('location_id')
                ->nullable()
                ->after('warehouse_id')
                ->constrained('warehouse_locations')
                ->nullOnDelete();

            $table->index(['warehouse_id', 'location_id']);
        });
    }

    public function down(): void
    {
        Schema::table('stock_adjustments', function (Blueprint $table) {

            $table->dropForeign(['warehouse_id']);
            $table->dropForeign(['location_id']);

            $table->dropIndex(['warehouse_id', 'location_id']);

            $table->dropColumn(['warehouse_id', 'location_id']);
        });
    }
};
