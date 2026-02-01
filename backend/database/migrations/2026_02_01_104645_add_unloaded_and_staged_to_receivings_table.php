<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('receivings', function (Blueprint $table) {
            $table->timestamp('unloaded_at')->nullable()->after('status');
            $table->foreignId('unloaded_by')
                ->nullable()
                ->after('unloaded_at')
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('staged_at')->nullable()->after('unloaded_by');
            $table->foreignId('staged_by')
                ->nullable()
                ->after('staged_at')
                ->constrained('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('receivings', function (Blueprint $table) {
            $table->dropForeign(['unloaded_by']);
            $table->dropForeign(['staged_by']);

            $table->dropColumn([
                'unloaded_at',
                'unloaded_by',
                'staged_at',
                'staged_by',
            ]);
        });
    }
};
