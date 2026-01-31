<?php

namespace App\Http\Controllers\Inventory\Dispatch;

use App\Http\Controllers\Controller;
use App\Models\Inventory\Dispatch;
use App\Models\Inventory\Barang;
use App\Services\Inventory\StokService;
use App\Http\Requests\Inventory\Dispatch\StoreDispatchRequest;
use App\Http\Requests\Inventory\Dispatch\ApproveDispatchRequest;
use App\Http\Requests\Inventory\Dispatch\RejectDispatchRequest;
use App\Support\ApiMeta;
use App\Support\HttpStatus;
use App\Support\HttpMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Inventory\Stock\StokResource;

class DispatchController extends Controller
{
    public function __construct(
        protected StokService $stokService
    ) {}

    public function store(StoreDispatchRequest $request)
{
 $dispatch = Dispatch::create([
        'barang_id'    => $request->barang_id,
        'jumlah'       => $request->jumlah,
        'tujuan'       => $request->tujuan,
        'keterangan'   => $request->keterangan,
        'status'       => 'PENDING',
        'requested_by' => $request->user()->id,
    ]);

    return response()->json([
        'success' => true,
        'message' => HttpMessage::fromStatus(HttpStatus::OK),
        'data'    => ['dispatch_id' => $dispatch->id],
        'meta' => ApiMeta::withTimestamp(),
    ], HttpStatus::CREATED);
}

    public function approve(
        Dispatch $dispatch,
        ApproveDispatchRequest $request
    ) {
        return DB::transaction(function () use ($dispatch, $request) {

            if ($dispatch->status !== 'PENDING') {
                abort(422, 'Dispatch sudah diproses');
            }

            $barang = Barang::lockForUpdate()
                ->findOrFail($dispatch->barang_id);

            $this->stokService->kurangiStok(
                barang: $barang,
                jumlah: $dispatch->jumlah,
                sumber: 'DISPATCH',
                userId: $request->user()->id,
                keterangan: 'Dispatch ' . $dispatch->kode,
                dispatchId: $dispatch->id
            );

            $dispatch->update([
                'status'      => 'ISSUED',
                'approved_by' => $request->user()->id,
                'approved_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Dispatch disetujui',
                'data'    => ['dispatch_id' => $dispatch->id],
                'meta'    => ApiMeta::withTimestamp(),
            ], HttpStatus::OK);
        });
    }

    public function reject(
        Dispatch $dispatch,
        RejectDispatchRequest $request
    ) {
        return DB::transaction(function () use ($dispatch, $request) {

            if ($dispatch->status !== 'PENDING') {
                abort(422, 'Dispatch sudah diproses');
            }

            $dispatch->update([
                'status'        => 'REJECTED',
                'rejected_by'   => $request->user()->id,
                'rejected_at'   => now(),
                'reject_reason' => $request->alasan,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Dispatch ditolak',
                'data'    => ['dispatch_id' => $dispatch->id],
                'meta'    => ApiMeta::withTimestamp(),
            ], HttpStatus::OK);
        });
    }
}