<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('quality_controls', function (Blueprint $table) {
            $table->enum('reject_decision', [
                'RETURN_TO_SUPPLIER',
                'DISPOSED',
                'REWORK',
            ])->nullable()->after('qty_rejected');

            $table->string('decision_note')->nullable()->after('reject_decision');
            $table->foreignId('decided_by')->nullable()
                ->constrained('users')->nullOnDelete()->after('decision_note');
            $table->timestamp('decided_at')->nullable()->after('decided_by');
        });
    }

    public function down(): void
    {
        Schema::table('quality_controls', function (Blueprint $table) {
            $table->dropColumn([
                'reject_decision',
                'decision_note',
                'decided_by',
                'decided_at',
            ]);
        });
    }
};
