<?php

namespace App\Http\Controllers\Inventory\Adjustment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\Adjustment\StockAdjustmentRequest;
use App\Http\Requests\Inventory\Adjustment\ApproveStockAdjustmentRequest;
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
use App\Models\Inventory\Warehouses\WarehouseStock;

class StockAdjustmentController extends Controller
{
    public function __construct(
        protected StockAdjustmentService $service
    ) {}

    public function store(StockAdjustmentRequest $request)
    {
        $barang = Barang::findOrFail($request->barang_id);

        $stokWarehouse = WarehouseStock::where([
    'warehouse_id' => $request->warehouse_id,
    'location_id'  => $request->location_id,
    'barang_id'    => $request->barang_id,
])->first();

$stokSistem = $stokWarehouse?->stok ?? 0;
$stokFisik  = $request->stok_fisik;

if ($stokFisik === $stokSistem) {
    return response()->json([
        'success' => false,
        'message' => 'Tidak ada selisih stok untuk diajukan',
        'meta'    => ApiMeta::withTimestamp(),
    ], HttpStatus::UNPROCESSABLE_ENTITY);
}

$adjustment = StockAdjustment::create([
    'warehouse_id' => $request->warehouse_id,
    'location_id'  => $request->location_id,
    'barang_id'    => $request->barang_id,
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
    $this->service->adjust(
        $adjustment,
        $request->user()->id
    );

    return response()->json([
        'success' => true,
        'message' => 'Penyesuaian stok disetujui',
        'data'    => new StockAdjustmentResource($adjustment->fresh()),
        'meta'    => ApiMeta::withTimestamp(),
    ], HttpStatus::OK);
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
