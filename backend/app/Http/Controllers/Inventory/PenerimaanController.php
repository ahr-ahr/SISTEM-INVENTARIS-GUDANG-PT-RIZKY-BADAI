<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\Barang;
use App\Services\Inventory\StokService;
use Illuminate\Http\Request;
use App\Http\Requests\Inventory\Receiving\StorePenerimaanRequest;
use App\Http\Resources\Inventory\Stock\StokResource;
use App\Support\ApiMeta;
use App\Support\HttpStatus;
use App\Support\HttpMessage;

class PenerimaanController extends Controller
{
    public function __construct(
        protected StokService $stokService
    ) {}

    public function store(StorePenerimaanRequest $request)
    {
        $barang = Barang::findOrFail($request->barang_id);

        $this->stokService->tambahStok(
            $barang,
            $request->jumlah,
            'PENERIMAAN',
            $request->user()->id,
            $request->keterangan
        );

        return response()->json([
            'success' => true,
            'message' => HttpMessage::fromStatus(HttpStatus::CREATED),
            'data'    => new StokResource($barang),
            'meta' => ApiMeta::withTimestamp(),
        ], HttpStatus::CREATED);
    }
}

?>