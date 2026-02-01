<?php

namespace App\Http\Controllers\Inventory\Transfer;

use App\Http\Controllers\Controller;
use App\Models\Inventory\Transfer;
use App\Services\Inventory\Transfer\TransferService;
use App\Http\Requests\Inventory\Transfer\StoreTransferRequest;
use App\Http\Requests\Inventory\Transfer\ApproveTransferRequest;
use App\Http\Requests\Inventory\Transfer\RejectTransferRequest;
use App\Http\Resources\Inventory\Transfer\TransferResource;
use App\Support\ApiMeta;
use App\Support\HttpStatus;

class TransferController extends Controller
{
    public function __construct(
        protected TransferService $service
    ) {}

    public function store(StoreTransferRequest $request)
    {
        $transfer = Transfer::create([
            'warehouse_id'     => $request->warehouse_id,
            'barang_id'        => $request->barang_id,
            'from_location_id' => $request->from_location_id,
            'to_location_id'   => $request->to_location_id,
            'jumlah'           => $request->jumlah,
            'alasan'           => $request->alasan,
            'status'           => 'PENDING',
            'requested_by'     => $request->user()->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Permintaan transfer diajukan',
            'data'    => new TransferResource($transfer),
            'meta'    => ApiMeta::withTimestamp(),
        ], HttpStatus::CREATED);
    }

    public function approve(
        Transfer $transfer,
        ApproveTransferRequest $request
    ) {
        $this->service->approve(
            $transfer,
            $request->user()->id
        );

        return response()->json([
            'success' => true,
            'message' => 'Transfer disetujui',
            'data'    => new TransferResource($transfer->fresh()),
            'meta'    => ApiMeta::withTimestamp(),
        ], HttpStatus::OK);
    }

    public function reject(
        Transfer $transfer,
        RejectTransferRequest $request
    ) {
        $transfer->update([
            'status'        => 'REJECTED',
            'rejected_by'   => $request->user()->id,
            'rejected_at'   => now(),
            'reject_reason' => $request->alasan,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Transfer ditolak',
            'data'    => new TransferResource($transfer->fresh()),
            'meta'    => ApiMeta::withTimestamp(),
        ], HttpStatus::OK);
    }
}
