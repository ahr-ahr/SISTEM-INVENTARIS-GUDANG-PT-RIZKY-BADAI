<?php

namespace App\Http\Controllers\Inventory\Report;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\Report\StokSnapshotRequest;
use App\Services\Inventory\Report\StokSnapshotService;
use App\Http\Resources\Inventory\Report\StokSnapshotCollection;
use App\Support\ApiMeta;
use App\Support\HttpMessage;
use App\Support\HttpStatus;

class LaporanStokController extends Controller
{
    public function __construct(
        protected StokSnapshotService $service
    ) {}

    public function index(StokSnapshotRequest $request)
    {
        $data = $this->service->paginate(
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' => HttpMessage::fromStatus(HttpStatus::OK),
            'data'    => new StokSnapshotCollection($data),
            'meta'    => ApiMeta::withTimestamp(),
        ], HttpStatus::OK);
    }
}
