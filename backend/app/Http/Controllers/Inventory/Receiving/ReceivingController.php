<?php

namespace App\Http\Controllers\Inventory\Receiving;

use App\Http\Controllers\Controller;
use App\Models\Inventory\Receiving;
use App\Models\Inventory\Barang;
use App\Services\Inventory\StokService;
use App\Http\Requests\Inventory\Receiving\StoreReceivingRequest;
use App\Support\ApiMeta;
use App\Support\HttpMessage;
use App\Support\HttpStatus;

class ReceivingController extends Controller
{
    public function __construct(
        protected StokService $stokService
    ) {}

    public function store(StoreReceivingRequest $request)
    {
        $receiving = Receiving::create([
            'supplier_id' => $request->supplier_id,
            'barang_id'   => $request->barang_id,
            'jumlah'      => $request->jumlah,
            'keterangan'  => $request->keterangan,
            'user_id'     => $request->user()->id,
        ]);

        $barang = Barang::findOrFail($request->barang_id);

        return response()->json([
            'success' => true,
            'message' => HttpMessage::fromStatus(HttpStatus::CREATED),
            'data'    => [
                'receiving_id' => $receiving->id,
            ],
            'meta'    => ApiMeta::withTimestamp(),
        ], HttpStatus::CREATED);
    }
}
