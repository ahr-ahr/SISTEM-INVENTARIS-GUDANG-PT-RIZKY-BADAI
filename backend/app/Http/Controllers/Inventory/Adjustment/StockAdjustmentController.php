<?php

namespace App\Http\Controllers\Inventory\Adjustment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\Adjustment\StockAdjustmentRequest;
use App\Services\Inventory\Adjustment\StockAdjustmentService;
use App\Models\Inventory\Barang;
use App\Http\Resources\Inventory\Stock\StokResource;
use Illuminate\Http\Request;
use App\Models\Inventory\StockAdjustment;
use App\Support\ApiMeta;
use Illuminate\Support\Facades\DB;
use App\Support\HttpMessage;
use App\Support\HttpStatus;
use App\Http\Requests\Inventory\Adjustment\RejectStockAdjustmentRequest;
use App\Http\Resources\Inventory\Adjustment\StockAdjustmentResource;

class StockAdjustmentController extends Controller
{
    public function __construct(
        protected StockAdjustmentService $service
    ) {}

    public function store(StockAdjustmentRequest $request)
    {
        $barang = Barang::findOrFail($request->barang_id);

        $stokSistem = $barang->stok;
        $stokFisik  = $request->stok_fisik;

        if ($stokFisik === $stokSistem) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada selisih stok untuk diajukan',
                'meta'    => ApiMeta::withTimestamp(),
            ], HttpStatus::UNPROCESSABLE_ENTITY);
        }

        $adjustment = StockAdjustment::create([
            'barang_id'    => $barang->id,
            'stok_sistem'  => $stokSistem,
            'stok_fisik'   => $stokFisik,
            'selisih'      => $stokFisik - $stokSistem,
            'alasan'       => $request->alasan,
            'status'       => 'PENDING',
            'requested_by' => $request->user()->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Permintaan penyesuaian stok diajukan',
            'data'    => new StockAdjustmentResource($adjustment),
            'meta'    => ApiMeta::withTimestamp(),
        ], HttpStatus::CREATED);
    }

    public function approve(
    StockAdjustment $adjustment,
    ApproveStockAdjustmentRequest $request
) {
    return DB::transaction(function () use ($adjustment, $request) {

        if ($adjustment->status !== 'PENDING') {
            abort(422, 'Adjustment sudah diproses');
        }

        $barang = Barang::lockForUpdate()->findOrFail($adjustment->barang_id);

        $this->service->adjust(
            $barang,
            $adjustment->stok_fisik,
            $adjustment->alasan,
            $request->user()->id,
            adjustmentId: $adjustment->id
        );

        $adjustment->update([
            'status'      => 'APPROVED',
            'approved_by' => $request->user()->id,
            'approved_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Penyesuaian stok disetujui',
            'data'    => new StockAdjustmentResource($adjustment->fresh()),
            'meta'    => ApiMeta::withTimestamp(),
        ], HttpStatus::OK);
    });
}

    public function reject(
    StockAdjustment $adjustment,
    RejectStockAdjustmentRequest $request
) {
    return DB::transaction(function () use ($adjustment, $request) {

        if ($adjustment->status !== 'PENDING') {
            abort(422, 'Adjustment sudah diproses');
        }

        $adjustment->update([
            'status'        => 'REJECTED',
            'rejected_by'   => $request->user()->id,
            'rejected_at'   => now(),
            'reject_reason' => $request->alasan,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Penyesuaian stok ditolak',
            'data'    => new StockAdjustmentResource($adjustment->fresh()),
            'meta'    => ApiMeta::withTimestamp(),
        ], HttpStatus::OK);
    });
}

}
