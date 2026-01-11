<?php

namespace App\Http\Controllers\Inventory\Adjustment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\Adjustment\StockAdjustmentRequest;
use App\Services\Inventory\Adjustment\StockAdjustmentService;
use App\Models\Inventory\Barang;
use App\Http\Resources\Inventory\Stock\StokResource;
use App\Support\ApiMeta;
use App\Support\HttpMessage;
use App\Support\HttpStatus;

class StockAdjustmentController extends Controller
{
    public function __construct(
        protected StockAdjustmentService $service
    ) {}

    public function store(StockAdjustmentRequest $request)
    {
        $barang = Barang::findOrFail($request->barang_id);

        $barang = $this->service->adjust(
            $barang,
            $request->stok_fisik,
            $request->alasan,
            $request->user()->id
        );

        return response()->json([
            'success' => true,
            'message' => 'Penyesuaian stok berhasil',
            'data'    => new StokResource($barang),
            'meta'    => ApiMeta::withTimestamp(),
        ], HttpStatus::CREATED);
    }
}
