<?php

namespace App\Http\Controllers\Inventory\Alert;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\Alert\StokMinimumRequest;
use App\Services\Inventory\Alert\StokMinimumService;
use App\Http\Resources\Inventory\Alert\StokMinimumCollection;
use App\Support\ApiMeta;
use App\Support\HttpMessage;
use App\Support\HttpStatus;

class StokMinimumController extends Controller
{
    public function __construct(
        protected StokMinimumService $service
    ) {}

    public function index(StokMinimumRequest $request)
    {
        $data = $this->service->paginate(
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' => HttpMessage::fromStatus(HttpStatus::OK),
            'data'    => new StokMinimumCollection($data),
            'meta'    => ApiMeta::withTimestamp(),
        ], HttpStatus::OK);
    }
}
