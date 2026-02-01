<?php

namespace App\Http\Controllers\Inventory\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\Inventory\Warehouse;
use App\Http\Requests\Inventory\Warehouse\StoreWarehouseRequest;
use App\Http\Requests\Inventory\Warehouse\UpdateWarehouseRequest;
use App\Http\Resources\Inventory\Warehouse\WarehouseResource;
use App\Http\Resources\Inventory\Warehouse\WarehouseCollection;
use App\Support\ApiMeta;
use App\Support\HttpStatus;
use App\Support\HttpMessage;

class WarehouseController extends Controller
{
    public function index()
    {
        $data = Warehouse::query()
            ->orderBy('nama')
            ->paginate(20);

        return response()->json([
            'success' => true,
            'message' => HttpMessage::fromStatus(HttpStatus::OK),
            'data'    => new WarehouseCollection($data),
            'meta'    => ApiMeta::withTimestamp(),
        ], HttpStatus::OK);
    }

    public function store(StoreWarehouseRequest $request)
    {
        $warehouse = Warehouse::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => HttpMessage::fromStatus(HttpStatus::CREATED),
            'data'    => new WarehouseResource($warehouse),
            'meta'    => ApiMeta::withTimestamp(),
        ], HttpStatus::CREATED);
    }

    public function show(Warehouse $warehouse)
    {
        return response()->json([
            'success' => true,
            'message' => HttpMessage::fromStatus(HttpStatus::OK),
            'data'    => new WarehouseResource($warehouse),
            'meta'    => ApiMeta::withTimestamp(),
        ], HttpStatus::OK);
    }

    public function update(UpdateWarehouseRequest $request, Warehouse $warehouse)
    {
        $warehouse->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => HttpMessage::fromStatus(HttpStatus::OK),
            'data'    => new WarehouseResource($warehouse->fresh()),
            'meta'    => ApiMeta::withTimestamp(),
        ], HttpStatus::OK);
    }

    public function destroy(Warehouse $warehouse)
    {
        $warehouse->update(['is_active' => false]);

        return response()->json([
            'success' => true,
            'message' => 'Warehouse dinonaktifkan',
            'meta'    => ApiMeta::withTimestamp(),
        ], HttpStatus::OK);
    }
}
