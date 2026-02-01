<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('warehouse_stocks', function (Blueprint $table) {
    $table->id();
    $table->foreignId('warehouse_id')->constrained();
    $table->foreignId('location_id')->constrained('warehouse_locations');
    $table->foreignId('barang_id')->constrained('barangs');

    $table->integer('stok')->default(0);
    $table->integer('stok_reserved')->default(0);
    $table->integer('stok_damaged')->default(0);

    $table->timestamps();

    $table->unique(['warehouse_id', 'location_id', 'barang_id']);
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouse_stocks');
    }
};
