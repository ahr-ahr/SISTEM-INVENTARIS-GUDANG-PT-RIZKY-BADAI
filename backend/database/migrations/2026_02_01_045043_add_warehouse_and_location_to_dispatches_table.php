<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('dispatches', function (Blueprint $table) {
            $table->foreignId('warehouse_id')
                ->nullable()
                ->after('barang_id');

            $table->foreignId('location_id')
                ->nullable()
                ->after('warehouse_id');
        });

        Schema::table('dispatches', function (Blueprint $table) {
            $table->foreign('warehouse_id')
                ->references('id')
                ->on('warehouses')
                ->cascadeOnDelete();

            $table->foreign('location_id')
                ->references('id')
                ->on('warehouse_locations')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('dispatches', function (Blueprint $table) {
            $table->dropForeign(['warehouse_id']);
            $table->dropForeign(['location_id']);
            $table->dropColumn(['warehouse_id', 'location_id']);
        });
    }
};
