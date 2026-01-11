<?php

namespace App\Http\Controllers\Inventory\Report;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\Report\MutasiStokRequest;
use App\Services\Inventory\Report\MutasiStokService;
use App\Http\Resources\Inventory\Report\MutasiStokCollection;
use App\Support\ApiMeta;
use App\Support\HttpMessage;
use App\Support\HttpStatus;

class LaporanMutasiStokController extends Controller
{
    public function __construct(
        protected MutasiStokService $service
    ) {}

    public function index(MutasiStokRequest $request)
    {
        $data = $this->service->paginate(
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' => HttpMessage::fromStatus(HttpStatus::OK),
            'data'    => new MutasiStokCollection($data),
            'meta'    => ApiMeta::withTimestamp(),
        ], HttpStatus::OK);
    }
}
