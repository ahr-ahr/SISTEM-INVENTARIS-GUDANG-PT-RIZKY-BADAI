<?php

namespace App\Http\Controllers\Inventory\Receiving;

use App\Http\Controllers\Controller;
use App\Models\Inventory\Receiving;
use App\Models\Inventory\Barang;
use App\Services\Inventory\StokService;
use App\Http\Requests\Inventory\Receiving\StoreReceivingRequest;
use App\Http\Requests\Inventory\Receiving\ApproveReceivingRequest;
use App\Http\Requests\Inventory\Receiving\RejectReceivingRequest;
use App\Support\ApiMeta;
use App\Support\HttpStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Inventory\Receiving\ReceivingCollection;
use App\Http\Resources\Inventory\Receiving\ReceivingResource;
use App\Services\Inventory\Warehouse\WarehouseStockService;

class ReceivingController extends Controller
{
    public function __construct(
        protected StokService $stokService,
        protected WarehouseStockService $warehouseStockService
    ) {}

    public function store(StoreReceivingRequest $request)
    {
        $receiving = Receiving::create([
            'supplier_id' => $request->supplier_id,
            'barang_id'   => $request->barang_id,
            'warehouse_id' => $request->warehouse_id,
            'location_id'  => $request->location_id,
            'jumlah'      => $request->jumlah,
            'keterangan'  => $request->keterangan,
            'status'      => 'PENDING',
            'user_id'     => $request->user()->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Penerimaan barang diajukan',
            'data'    => new ReceivingResource($receiving),
            'meta'    => ApiMeta::withTimestamp(),
        ], HttpStatus::CREATED);
    }

    public function approve(Receiving $receiving, ApproveReceivingRequest $request) 
    {
        return DB::transaction(function () use ($receiving, $request) {

            if ($receiving->status !== 'PENDING') {
                abort(422, 'Receiving sudah diproses');
            }

            $barang = Barang::lockForUpdate()
                ->findOrFail($receiving->barang_id);

            $this->warehouseStockService->increase(
                $receiving->warehouse_id,
                $receiving->location_id,
                $receiving->barang_id,
                $receiving->jumlah
            );

            $this->stokService->tambahStok(
                barang: $barang,
                jumlah: $receiving->jumlah,
                sumber: 'RECEIVING',
                userId: $request->user()->id,
                keterangan: 'Receiving #' . $receiving->id,
                receivingId: $receiving->id
            );

            $receiving->update([
                'status'      => 'RECEIVED',
                'approved_by' => $request->user()->id,
                'approved_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Receiving disetujui',
                'data'    => new ReceivingResource($receiving),
                'meta'    => ApiMeta::withTimestamp(),
            ], HttpStatus::OK);
        });
    }

    public function reject(Receiving $receiving, RejectReceivingRequest $request) 
    {
        return DB::transaction(function () use ($receiving, $request) {

            if ($receiving->status !== 'PENDING') {
                abort(422, 'Receiving sudah diproses');
            }

            $receiving->update([
                'status'        => 'REJECTED',
                'rejected_by'   => $request->user()->id,
                'rejected_at'   => now(),
                'reject_reason' => $request->alasan,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Receiving ditolak',
                'data'    => new ReceivingResource($receiving),
                'meta'    => ApiMeta::withTimestamp(),
            ], HttpStatus::OK);
        });
    }
}
