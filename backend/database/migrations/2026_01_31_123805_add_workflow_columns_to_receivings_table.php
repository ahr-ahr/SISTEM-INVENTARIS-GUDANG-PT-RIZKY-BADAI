<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('receivings', function (Blueprint $table) {

            $table->enum('status', ['PENDING', 'RECEIVED', 'REJECTED'])
                ->default('PENDING')
                ->after('keterangan');

            $table->foreignId('approved_by')
                ->nullable()
                ->after('user_id')
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('approved_at')->nullable();

            $table->foreignId('rejected_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('rejected_at')->nullable();
            $table->string('reject_reason', 255)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('receivings', function (Blueprint $table) {
            $table->dropColumn([
                'status',
                'approved_by',
                'approved_at',
                'rejected_by',
                'rejected_at',
                'reject_reason',
            ]);
        });
    }
};
