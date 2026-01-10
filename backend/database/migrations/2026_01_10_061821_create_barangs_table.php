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
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();

            // Identitas barang
            $table->string('kode', 50)->unique();
            $table->string('nama', 150);
            $table->string('kategori', 100)->nullable();
            $table->string('satuan', 50);

            // Informasi stok
            $table->integer('stok')->default(0);
            $table->integer('stok_minimum')->default(0);

            // Informasi tambahan
            $table->text('deskripsi')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->text('deactivated_reason')->nullable();
            $table->timestamp('deactivated_at')->nullable();
            $table->foreignId('deactivated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Audit
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
