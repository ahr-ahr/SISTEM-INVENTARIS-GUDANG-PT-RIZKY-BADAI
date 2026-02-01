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
        Schema::create('transfers', function (Blueprint $table) {
    $table->id();

    $table->foreignId('warehouse_id')
        ->constrained('warehouses')
        ->restrictOnDelete();

    $table->foreignId('barang_id')
        ->constrained('barangs')
        ->restrictOnDelete();

    $table->foreignId('from_location_id')
        ->constrained('warehouse_locations')
        ->restrictOnDelete();

    $table->foreignId('to_location_id')
        ->constrained('warehouse_locations')
        ->restrictOnDelete();

    $table->integer('jumlah');

    $table->enum('status', ['PENDING', 'APPROVED', 'REJECTED'])
        ->default('PENDING')
        ->index();

    $table->text('alasan')->nullable();

    $table->foreignId('requested_by')
        ->constrained('users')
        ->restrictOnDelete();

    $table->foreignId('approved_by')
        ->nullable()
        ->constrained('users')
        ->nullOnDelete();

    $table->timestamp('approved_at')->nullable();

    $table->foreignId('rejected_by')
        ->nullable()
        ->constrained('users')
        ->nullOnDelete();

    $table->timestamp('rejected_at')->nullable();
    $table->text('reject_reason')->nullable();

    $table->timestamps();

    $table->index(['warehouse_id', 'barang_id']);
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
