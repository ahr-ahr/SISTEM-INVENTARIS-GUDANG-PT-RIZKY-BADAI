<?php

namespace App\Http\Controllers\Inventory\QualityControl;

use App\Http\Controllers\Controller;
use App\Models\Inventory\QualityControl;
use App\Http\Requests\Inventory\QualityControl\DecideQualityControlRequest;
use App\Services\Inventory\QualityControl\QualityControlDecisionService;
use App\Http\Resources\Inventory\QualityControl\QualityControlResource;
use App\Support\ApiMeta;
use App\Support\HttpStatus;

class QualityControlDecisionController extends Controller
{
    public function __construct(
        protected QualityControlDecisionService $service
    ) {}

    public function decide(
        QualityControl $qc,
        DecideQualityControlRequest $request
    ) {
        $this->authorize('decide', $qc);

        $this->service->decide(
            qc: $qc,
            decision: $request->decision,
            note: $request->note,
            userId: $request->user()->id
        );

        return response()->json([
            'success' => true,
            'message' => 'Keputusan QC berhasil disimpan',
            'data'    => new QualityControlResource($qc->fresh()),
            'meta'    => ApiMeta::withTimestamp(),
        ], HttpStatus::OK);
    }
}
