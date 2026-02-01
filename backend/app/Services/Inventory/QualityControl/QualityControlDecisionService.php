<?php

namespace App\Services\Inventory\QualityControl;

use App\Models\Inventory\QualityControl;
use Illuminate\Support\Facades\DB;
use Exception;

class QualityControlDecisionService
{
    public function decide(
        QualityControl $qc,
        string $decision,
        ?string $note,
        int $userId
    ): void {
        DB::transaction(function () use ($qc, $decision, $note, $userId) {

            if ($qc->status !== 'APPROVED') {
                throw new Exception('QC belum disetujui');
            }

            if ($qc->qty_rejected <= 0) {
                throw new Exception('QC tidak memiliki barang reject');
            }

            if ($qc->reject_decision !== null) {
                throw new Exception('Keputusan QC sudah ada');
            }

            $qc->update([
                'reject_decision' => $decision,
                'decision_note'   => $note,
                'decided_by'      => $userId,
                'decided_at'      => now(),
            ]);
        });
    }
}
