<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quality_controls', function (Blueprint $table) {
            $table->id();

            // Relasi utama
            $table->foreignId('receiving_id')
                ->constrained('receivings')
                ->cascadeOnDelete();

            $table->foreignId('barang_id')
                ->constrained('barangs')
                ->cascadeOnDelete();

            $table->foreignId('warehouse_id')
                ->constrained('warehouses')
                ->cascadeOnDelete();

            $table->foreignId('location_id')
                ->constrained('warehouse_locations')
                ->cascadeOnDelete();

            // Quantity
            $table->integer('qty_received');
            $table->integer('qty_accepted')->default(0);
            $table->integer('qty_rejected')->default(0);

            // Status QC
            $table->enum('status', [
                'PENDING',
                'APPROVED',
                'REJECTED',
            ])->default('PENDING');

            // Audit
            $table->foreignId('requested_by')
                ->constrained('users')
                ->cascadeOnDelete();

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
            $table->string('reject_reason')->nullable();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Index tambahan
            |--------------------------------------------------------------------------
            */
            $table->index(['barang_id', 'warehouse_id', 'location_id']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quality_controls');
    }
};
