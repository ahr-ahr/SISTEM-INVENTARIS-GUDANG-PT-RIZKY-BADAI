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
        Schema::create('stock_mutations', function (Blueprint $table) {
    $table->id();

    $table->foreignId('barang_id')->constrained('barangs');
    $table->foreignId('warehouse_id')->constrained();
    $table->foreignId('location_id')->constrained('warehouse_locations');

    $table->enum('tipe', ['IN', 'OUT', 'MOVE', 'ADJUST']);
    $table->string('sumber'); // RECEIVING, DISPATCH, TRANSFER, ADJUSTMENT

    $table->string('ref_type')->nullable();
    $table->unsignedBigInteger('ref_id')->nullable();

    $table->integer('qty');
    $table->integer('stok_sebelum');
    $table->integer('stok_sesudah');

    $table->foreignId('user_id')->constrained();
    $table->timestamps();

    $table->index(['barang_id', 'warehouse_id']);
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_mutations');
    }
};
