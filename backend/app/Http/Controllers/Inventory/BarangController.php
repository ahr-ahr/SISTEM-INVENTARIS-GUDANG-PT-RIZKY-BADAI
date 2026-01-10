<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\Barang;
use App\Http\Requests\Inventory\StoreBarangRequest;
use App\Http\Requests\Inventory\UpdateBarangRequest;
use App\Http\Requests\Inventory\DestroyBarangRequest;
use App\Http\Resources\Inventory\BarangResource;
use App\Http\Resources\Inventory\BarangCollection;
use Illuminate\Http\Request;
use App\Support\ApiMeta;
use App\Support\HttpStatus;
use App\Support\HttpMessage;
use App\Services\Inventory\BarangService;

class BarangController extends Controller
{
    public function __construct(
        protected BarangService $barangService
    ) {}

    public function index(Request $request)
    {
        $this->authorize('viewAny', Barang::class);

        $items = $this->barangService->getActive();

        return response()->json([
            'success' => true,
            'message' => HttpMessage::fromStatus(HttpStatus::OK),
            'data' => new BarangCollection($items),
            'meta' => ApiMeta::withTimestamp(),
        ], HttpStatus::OK);
    }

    public function inactive(Request $request)
    {
        $this->authorize('viewAny', Barang::class);

        $items = $this->barangService->getInactive();

        return response()->json([
            'success' => true,
            'message' => HttpMessage::fromStatus(HttpStatus::OK),
            'data' => new BarangCollection($items),
            'meta' => ApiMeta::withTimestamp(),
        ], HttpStatus::OK);
    }

    public function deactivationReasons()
    {
        return response()->json([
            'success' => true,
            'message' => HttpMessage::fromStatus(HttpStatus::OK),
            'data' => collect(BarangDeactivationReason::cases())->map(fn ($reason) => [
                'value' => $reason->value,
                'label' => $reason->label(),
            ]),
            'meta' => ApiMeta::withTimestamp(),
        ], HttpStatus::OK);
    }

    public function store(StoreBarangRequest $request)
    {
        $barang = $this->barangService->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => HttpMessage::fromStatus(HttpStatus::CREATED),
            'data' => new BarangResource($barang),
        ], HttpStatus::CREATED);
    }

    public function update(UpdateBarangRequest $request, Barang $barang)
    {
        $barang = $this->barangService->update($barang, $request->validated());

        return response()->json([
            'success' => true,
            'message' => HttpMessage::fromStatus(HttpStatus::OK),
            'data' => new BarangResource($barang),
        ], HttpStatus::OK);
    }

    public function destroy(DestroyBarangRequest $request, Barang $barang)
    {
        $barang = $this->barangService->deactivate(
            $barang,
            $request->input('reason'),
            $request->user()->id
        );

        return response()->json([
            'success' => true,
            'message' => HttpMessage::fromStatus(HttpStatus::OK),
            'data' => new BarangResource($barang),
        ], HttpStatus::OK);
    }
}