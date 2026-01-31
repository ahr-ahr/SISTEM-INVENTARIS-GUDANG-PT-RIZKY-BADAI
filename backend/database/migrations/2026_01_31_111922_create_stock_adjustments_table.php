<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_adjustments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('barang_id')
                ->constrained('barangs')
                ->cascadeOnDelete();

            // Snapshot stok
            $table->integer('stok_sistem');
            $table->integer('stok_fisik');
            $table->integer('selisih');

            // Workflow
            $table->enum('status', ['PENDING', 'APPROVED', 'REJECTED'])
                ->default('PENDING');

            // Audit request
            $table->text('alasan');
            $table->foreignId('requested_by')
                ->constrained('users')
                ->cascadeOnDelete();

            // Audit approval
            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->timestamp('approved_at')->nullable();

            // Audit rejection
            $table->foreignId('rejected_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->timestamp('rejected_at')->nullable();
            $table->text('reject_reason')->nullable();

            $table->timestamps();

            $table->index(['barang_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_adjustments');
    }
};
